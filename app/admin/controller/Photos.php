<?php


namespace app\admin\controller;

use app\service\PhotoService;
use app\model\Chapter;
use app\model\Book;
use app\model\Photo;
use app\validate\Image;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\ValidateException;
use think\facade\View;

class Photos extends BaseAdmin
{
    protected $photoService;

    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->photoService = app('photoService');
    }

    public function index()
    {
        $chapter_id = input('chapter_id');
        try {
            $chapter = Chapter::findOrFail($chapter_id);
            $book_id = input('book_id');
            $book =Book::withTrashed()->find($book_id);
            if (empty($book)) {
                throw new ModelNotFoundException('book不存在');
            }
            $page = config('extra_config.back_end_page');
            $data = $this->photoService->getAdminPaged($chapter_id, $page);
            View::assign([
                'photos' => $data['photos'],
                'chapter_id' => $chapter_id,
                'book_id' => $book_id,
                'book_name' => $book->book_name,
                'chapter_name' => $chapter->chapter_name,
                'count' => $data['count'],
            ]);
            return view();
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function clear()
    {
        $chapter_id = input('chapter_id');
        $arr = Photo::where('chapter_id', '=', $chapter_id)->column('img_url');
        $this->deletePhoto($arr);
        Photo::destroy(function ($query) use ($chapter_id) {
            $query->where('chapter_id', '=', $chapter_id);
        });
        return json(['err' => 0, 'msg' => '清空成功']);
    }

    public function delete()
    {
        $id = input('id');
        $arr = Photo::find($id);
        $this->deletePhoto($arr->img_url);
        Photo::destroy($id);
        return json(['err' => 0, 'msg' => '删除成功']);
    }

    public function upload()
    {
        $data = request()->param();
        $chapter_id = $data['chapter_id'];
//        $book_id = $data['book_id'];
        $lastPhoto = $this->photoService->getLastPhoto($chapter_id);
        $order = 1;
        if ($lastPhoto != null) {
            $order = $lastPhoto->pic_order + 1; //拿到最新图片的order，加1
        }
        try {
            $files = request()->file('file');
            $dir = 'book/content';
            $photo = new Photo();
            $photo->chapter_id = $chapter_id;
            $photo->pic_order = $order;
//            validate(Image::class)
//                ->check(['image'=>$files]);
//            $savename =str_replace ( '\\', '/',
//                \think\facade\Filesystem::disk('public')->putFile($dir, $files));
//            $photo->img_url = '/static/upload/' . $savename;
            $photo->img_url = $this->uploadImg($files,$dir,true);
            $photo->save();
            return json(['err'=>0,'msg'=>"上传成功"]);
        } catch (ValidateException $e) {
            return json(['err'=>1,'msg'=>$e->getMessage()]);
        }
    }

    public function edit(){

        $id = input('id');
        try {
            $photo = Photo::findOrFail($id);
            if (request()->isPost()){
                $id = input('id');
                $order = input('pic_order');
                $photo->pic_order = $order;
                $result = $photo->save();
                if ($result) {
                    return json(['err' =>0,'msg'=>'修改成功']);
                }else{
                    return json(['err' =>1,'msg'=>'修改失败']);
                }
            }
            View::assign([
                'id' => $id,
                'order' => $photo->pic_order,
            ]);
            return view();
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function editSort()
    {
        if (request()->isPost()){
            $id = request()->param('id');
            $sort = request()->param('sort');
            try {
                validate(\app\validate\Photo::class)->scene('sort')
                    ->check(['pic_order'=>$sort]);
            }catch (ValidateException $e){
                return json(['err' =>1,'msg'=>$e->getMessage()]);
            }
            $table = Photo::find($id);
            $table->pic_order = $sort;
            $table->save();
            return json(['err' =>0,'msg'=>'修改成功']);
        }
    }
}