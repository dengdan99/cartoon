<?php


namespace app\admin\controller;

use app\model\Author;
use app\model\Book;
use app\model\Tags;
use app\validate\Image;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\facade\View;
use app\model\Area;
use Overtrue\Pinyin\Pinyin;
use think\facade\Db;
use app\model\Chapter;
use app\model\Photo;

class Books extends BaseAdmin
{
    protected $authorService;
    protected $bookService;

    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->authorService = app('authorService');
        $this->bookService = app('bookService');
    }

    public function index()
    {

        $data = $this->bookService->getPagedBooksAdmin(1);
        $books = $data['books'];
        foreach ($books as &$book) {
            $book['chapter_count'] = Chapter::where('book_id', '=', $book['id'])->count();
        }
        $count = $data['count'];
        View::assign([
            'books' => $books,
            'count' => $count
        ]);
        return view();
    }

    public function create()
    {
        if (request()->isPost()) {
            $book = new Book();
            $data = $this->request->param();

            try {
                validate(\app\validate\Book::class)->check($data);
            } catch (ValidateException $e){
                return json(['err' =>1,'msg'=>$e->getMessage()]);
            }

            //作者处理 不存在就添加
            try {
                $author = Author::where('author_name', '=', $data['author'])->findOrFail();
            } catch (DataNotFoundException $e) {
            } catch (ModelNotFoundException $e) {
                $author = new Author();
                $author->author_name = $data['author'];
                $author->save();
            }

            $book->author_id = $author->id;
            $book->author_name = $author->author_name;
            $book->last_time = time();
            $str = $this->convert($data['book_name']); //生成标识

            $c = (int)Book::where('unique_id','=',$str)->count();
            if ($c > 0 || empty($str)) {
                $data['unique_id'] = md5(time() . mt_rand(1,1000000)); //如果已经存在相同标识，则生成一个新的随机标识
            } else {
                $data['unique_id'] = $str;
            }


            $dir = 'book/cover';
            if (!empty(request()->file())) {
                $cover = request()->file('cover');
                try {
                    $book->cover_url = $this->uploadImg($cover,$dir);
                } catch (ValidateException $e) {
                    return json(['err' =>1,'msg'=>$e->getError()]);
                }
            }

            $result = $book->save($data);
            if ($result) {
                return json(['err' =>0,'msg'=>'添加成功']);
            } else {
                return json(['err' =>1,'msg'=>'添加失败']);
            }
        }
        $areas = Area::select();
        $types = Tags::select();
        View::assign([
            'areas' => $areas,
            'types' => $types
        ]);
        return view();
    }

    public function edit()
    {
        $areas = Area::select();
        $types = Tags::select();
        $data = request()->param();
        try {
            $book = Book::find($data['id']);
            $delete = false;
            if (!$book){
                $book = Book::onlyTrashed()->findOrFail($data['id']);
                $delete = true;
            }

            if (request()->isPost()) {
                if ($delete){
                    $book->restore();
                }
                try {
                    validate(\app\validate\Book::class)->check($data);
                } catch (ValidateException $e){
                    return json(['err' =>1,'msg'=>$e->getMessage()]);
                }

                //作者处理
                try {
                    $author = Author::where('author_name', '=', $data['author'])->findOrFail();
                } catch (DataNotFoundException $e) {
                } catch (ModelNotFoundException $e) {
                    $author = new Author();
                    $author->author_name = $data['author'];
                    $author->save();
                }

                $book->author_id = $author->id;
                $book->author_name = $author->author_name;
                if($data['unique_id'] != $book->unique_id) {
                    $c = (int)Book::where('unique_id','=',$data['unique_id'])->count();
                    if ($c > 0) {
                        $book->unique_id = md5(time() . mt_rand(1,1000000)); //如果已经存在相同标识，则生成一个新的随机标识
                    } else {
                        $book->unique_id = $data['unique_id'];
                    }
                }
                $book->last_time = time();
                if (!empty(request()->file())) {
                    $cover = request()->file('cover');
                    $dir = 'book/cover';
                    try {
                        $book->cover_url = $this->uploadImg($cover,$dir);
                    } catch (ValidateException $e) {
                        return json(['err' =>1,'msg'=>$e->getError()]);
                    }
                }

                $result = $book->save($data);
                if ($delete){
                    book::destroy($data['id']);
                }
                if ($result) {
                    return json(['err' =>0,'msg'=>'编辑成功']);
                } else {
                    return json(['err' =>1,'msg'=>'修改失败']);
                }
            }
            View::assign([
                'book' => $book,
                'areas' => $areas,
                'types' => $types
            ]);
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
        return view();
    }

    public function search()
    {
        $name = input('book_name');
        $status = input('status');
        $where = [
            ['book_name', 'like', '%' . $name . '%']
        ];
        $data = $this->bookService->getPagedBooksAdmin($status,$where);
        $books = $data['books'];
        foreach ($books as &$book) {
            $book['chapter_count'] = count($book->chapters);
        }
        $count = $data['count'];
        View::assign([
            'books' => $books,
            'count' => $count
        ]);
        return view('index');
    }

    public function disable()
    {
        $id = input('id');
        if (empty($id) || is_null($id)) {
            return json(['err' => 1]);
        }
        try {
            $book = Book::findOrFail($id);
            $result = $book->delete();
            if ($result) {
                return json(['err' => 0]);
            } else {
                return json(['err' => 1]);
            }
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function enable()
    {
        $id = input('id');
        if (empty($id) || is_null($id)) {
            return json(['err' => 1]);
        }
        try {
            $book = Book::onlyTrashed()->findOrFail($id);
            $result = $book->restore();
            if ($result) {
                return json(['err' => 0]);
            } else {
                return json(['err' => 1]);
            }
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function disabled()
    {
        $data = $this->bookService->getPagedBooksAdmin(0);
        $books = $data['books'];
        foreach ($books as &$book) {
            $book['chapter_count'] = count($book->chapters);
        }
        $count = $data['count'];
        View::assign([
            'books' => $books,
            'count' => $count
        ]);
        return view();
    }

    public function payment()
    {
        if (request()->isPost()) {
            $data = request()->param();
            $start_pay = $data['start_pay'];
            $money = $data['money'];
            $area_id = $data['area_id'];
            $start_id = $data['start_id'];
            $sql = 'UPDATE '.$this->prefix.'book SET start_pay=' . $start_pay . ',money=' . $money . ' WHERE 1=1';
            if ($area_id != -1) {
                $sql = $sql . ' AND area_id=' . $area_id;
            }
            if ($start_id > -1) {
                $sql = $sql . ' AND id>=' . $start_id;
            }
            Db::query($sql);
            return json(['err' => 0, 'msg' => '批量设置成功']);

        }
        $areas = Area::select();
        View::assign('areas', $areas);
        return view();
    }

    public function delete()
    {
        $id = input('id');
        try {
            $book = Book::onlyTrashed()->find($id);
            if (!empty($book)) {
                $chapters = Chapter::where('book_id', '=', $id)->select(); //按漫画id查找所有章节
                foreach ($chapters as $chapter) {
                    $pics = Photo::where('chapter_id', '=', $chapter->id)->select(); //按章节id查找所有图片
                    foreach ($pics as $pic) {
                        $this->deletePhoto($pic->img_url);
                        $pic->delete(); //删除图片
                    }
                    $chapter->delete(); //删除章节
                }
                Db::name('book')->where('id', $id)->delete();
            }
            else {
                Book::destroy($id);
            }
            return json(['err' => 0, 'msg' => '删除成功']);

        } catch (DataNotFoundException $e) {
            return json(['err' => 1, 'msg' => $e->getMessage()]);
        } catch (ModelNotFoundException $e) {
            return json(['err' => 1, 'msg' => $e->getMessage()]);
        }
    }

    public function deleteAll()
    {
        $ids = request()->param('ids');
        //删除章节

        $del = Book::onlyTrashed()->select($ids);
        if (!$del->isEmpty()) {

            $chapters = Chapter::select(['book_id'=>$ids]); //按漫画id查找所有章节
            if (!$chapters->isEmpty()) {
                foreach ($chapters as $chapter) {
                    $chapter->delete(); //删除章节
                }
                $chapterIds = Chapter::where('book_id', 'in', $ids)->column('id');
                $pics = Photo::select(['chapter_id'=>$chapterIds]); //按章节id查找所有图片
                if (!$pics->isEmpty()) {
                    foreach ($pics as $pic) {
                        $this->deletePhoto($pic->img_url);
                        $pic->delete(); //删除图片
                    }
                }
            }
            Db::name('book')->whereIn('id', $ids)->delete();
            return json(['err'=>0,'msg'=>'批量删除成功']);
        } else {
            Book::destroy($ids);
            return json(['err'=>0,'msg'=>'批量下架成功']);
        }
    }

    //批量上架
    public function restoreAll()
    {
        $ids = request()->param('ids');
        $del = Book::onlyTrashed()->select($ids);
        if ($del->count() > 0) {
            foreach ($del as $item){
                $item->restore();
            }
            return json(['err'=>0,'msg'=>'批量上架成功']);
        }
    }

    protected function convert($str){
        $pinyin = new Pinyin();
        $name_format = config('extra_config.name_format');
        switch ($name_format) {
            case 'pure':
                $arr = $pinyin->convert($str);
                $str = implode($arr,'');
                break;
            case 'abbr':
                $str = $pinyin->abbr($str);break;
            default:
                $str = $pinyin->convert($str);break;
        }
        return $str;
    }

    public function editClick()
    {
        $id = input('id');
        try {
            $book = Book::findOrFail($id);
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
        $clicks = $this->bookService->getClicks($book->id, $this->prefix);
        if (request()->isPost()) {
            $click = intval(input('clicks'));
            if ( ($click) <= 0 ){
                return json(['err' =>1,'msg'=>'数字过小']);
            }
            $book->clicks = $click;
//            halt($clicks,$click,$book->clicks);
            $result = $book->save();
            if ($result) {
                return json(['err' =>0,'msg'=>'修改成功']);
            } else {
                return json(['err' =>1,'msg'=>'修改失败']);
            }
        }
        View::assign(compact('id','clicks'));
        return view();
    }

    public function setClickAll()
    {
        if (request()->isPost()) {
            $start_id = intval(input('start_id'));
            $end_id = intval(input('end_id'));
            $arr = $start_id > $end_id?[$end_id,$start_id]:[$start_id,$end_id];
            $books = Book::where('id','between',$arr)
                ->where('clicks','<=',0)
                ->select();
            $n = 0;
            foreach ($books as $item){
                $rand = intval( mt_rand(config('extra_config.cartoon_click_min'),config('extra_config.cartoon_click_max')) );
                $r = Book::update(['clicks'=>$rand],['id'=>$item->id]);
                if ($r){
                    $n += 1;
                }
            }
            if ($n) {
                return json(['err' =>0,'msg'=>'成功批量初始化点击量'.$n.'本漫画']);
            } else {
                return json(['err' =>1,'msg'=>'批量初始化点击量0本漫画']);
            }
        }
    }

    public function setUpAll()
    {
        if (request()->isPost()) {
            $start_id = intval(input('start_id'));
            $end_id = intval(input('end_id'));
            $arr = $start_id > $end_id?[$end_id,$start_id]:[$start_id,$end_id];

            $n = Db::name('book')->where('id','between',$arr)->update(['delete_time'=>0]);

            if ($n) {
                return json(['err' =>0,'msg'=>'成功批量上架'.$n.'本漫画']);
            } else {
                return json(['err' =>1,'msg'=>'批量上架0本漫画']);
            }
        }
    }

    public function setDownAll()
    {
        if (request()->isPost()) {
            $start_id = intval(input('start_id'));
            $end_id = intval(input('end_id'));
            $arr = $start_id > $end_id?[$end_id,$start_id]:[$start_id,$end_id];

            $n = Db::name('book')->where('id','between',$arr)->update(['delete_time'=>time()]);

            if ($n) {
                return json(['err' =>0,'msg'=>'成功批量下架'.$n.'本漫画']);
            } else {
                return json(['err' =>1,'msg'=>'批量下架0本漫画']);
            }
        }
    }

    public function setDeleteAll()
    {
        if (request()->isPost()) {
            $start_id = intval(input('start_id'));
            $end_id = intval(input('end_id'));
            $arr = $start_id > $end_id?[$end_id,$start_id]:[$start_id,$end_id];

            $book_ids = Db::name('book')->where('id','between',$arr)
                ->where('delete_time','>',0)->column('id');
            $chapter_ids = Db::name('chapter')->where('book_id','in',$book_ids)->column('id');
            if (!empty($chapter_ids)){
                Db::name('photo')->where('chapter_id','in',$chapter_ids)->delete();
                Db::name('chapter')->where('book_id','in',$book_ids)->delete();
            }
            $n = Db::name('book')->where('id','between',$arr)
                ->where('delete_time','>',0)->delete();

            if ($n) {
                return json(['err' =>0,'msg'=>'成功批量删除'.$n.'本漫画']);
            } else {
                return json(['err' =>1,'msg'=>'批量删除0本漫画']);
            }
        }
    }
}