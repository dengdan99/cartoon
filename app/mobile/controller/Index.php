<?php


namespace app\mobile\controller;


use app\model\Author;
use app\model\Banner;
use app\common\RedisHelper;
use app\model\Book;
use app\model\Chapter;
use app\model\Tags;
use app\mobile\controller\Base;
use app\service\BookService;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;
use think\facade\View;

class Index extends Base
{
    protected $bookService;
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->bookService = app('bookService');
    }

    public function index()
    {
        $pid = input('pid');
        if ($pid) { //如果有推广pid
            cookie('xwx_promotion', $pid); //将pid写入cookie
        }
        $banners = cache('bannersHomepage');
        if (!$banners) {
            $banners = Banner::with('book')
                ->where('platform','h5')
                ->where('banner_order','>', 0)
                ->order('banner_order','desc')
                ->select();
//            foreach ($banners as &$banner) {
//                if (substr($banner['pic_name'], 0, strlen('http')) != 'http') {
//                    $banner['pic_name'] = $this->mobile_url . '/static/upload/' . $banner['pic_name'];
//                }
//            }
            cache('bannersHomepage',$banners, null, 'redis');
        }
        $hot_books = cache('hotBooks');
        if (!$hot_books) {
            $hot_books = $this->bookService->getHotBooks($this->prefix, $this->end_point);
            cache('hotBooks', $hot_books, null, 'redis');
        }
        $this->bookService->setParamList($hot_books,$this->end_point);

        $newest = cache('newestHomepage');
        if (!$newest) {
            $newest = $this->bookService->getBooks($this->end_point, 'last_time', '1=1', 9);
            cache('newestHomepage', $newest, null, 'redis');
        }
        $this->bookService->setParamList($newest,$this->end_point);

        $ends = cache('endsHomepage');
        if (!$ends) {
            $ends = $this->bookService->getBooks($this->end_point, 'last_time', [['end', '=', '1']], 9);
            cache('endsHomepage', $ends, null, 'redis');
        }
        $this->bookService->setParamList($ends,$this->end_point);

        $tops = cache('topsHomepage');
        if (!$tops) {
            $tops = $this->bookService->getBooks( $this->end_point, 'last_time', [['is_top', '=', '1']], 30);
            cache('topsHomepage', $tops, null, 'redis');
        }
        $this->bookService->setParamList($tops,$this->end_point);

        $tags = cache('tags');
        if (!$tags) {
            $tags = Tags::where('is_show', '=', 1)->order('sort','desc')->select();
            cache('tags', $tags, null, 'redis');
        }

        $catelist = array(); //分类漫画数组
        foreach ($tags as $tag) {
            $books = cache('booksFilterByTag:'.$tag);
            if (!$books) {
                $books = $this->bookService->getByTags($tag->id, $this->end_point, 9);
                cache('booksFilterByTag:'.$tag, $books, null, 'redis');
            }
            $this->bookService->setParamList($books,$this->end_point);
            $catelist[] = ['books'=>$books->toArray(),'tag'=>['id' => $tag->id, 'tag_name' => $tag->tag_name]];
        }

        View::assign([
            'banners' => $banners,
            'banners_count' => count($banners),
            'newest' => $newest,
            'hot' => $hot_books,
            'ends' => $ends,
            'tops' => $tops,
            'tags' => $tags,
            'catelist' => $catelist,
            'c_url' => $this->c_url
        ]);

        return view($this->tpl);
    }

    public function search()
    {
        $keyword = input('keyword');
        $hot_search = $this->getHotWord($keyword);
        $page = input('page',1);
        $size = input('size',2);
//        $books = cache('searchresult:' . $keyword);
//        if (!$books) {
//            //$num = config('extra_config.search_result_pc');
//            cache('searchresult:' . $keyword, $books, null, 'redis');
//        }
        $books = $this->bookService->search($keyword, $size, $this->prefix,$page);
        foreach ($books as &$book) {
            try {
                $author = Author::find($book['author_id']);
                if (is_null($author)) {
                    $author = new Author();
                    $author->author_name = '佚名';
                }
                $book['author'] = $author;
                $this->bookService->getParam($book,$this->end_point);
            } catch (DataNotFoundException $e) {
                abort(404, $e->getMessage());
            } catch (ModelNotFoundException $e) {
                abort(404, $e->getMessage());
            }

        }
        View::assign([
            'books' => $books,
            'count' => count($books),
            'hot_search' => $hot_search,
            'keyword' => $keyword,
            'c_url' => $this->c_url,
        ]);
        return view($this->tpl);
    }

    public function getSearch()
    {
        $keyword = input('keyword');
        $page = input('page',1);
        $size = input('size',2);
        $hot_search = $this->getHotWord($keyword);
        try {
            $books = $this->bookService->search($keyword, $size, $this->prefix,$page);
            if (empty($books)){
                return json(['err' => 0, 'books' => [],'hot_search'=>$hot_search]);
            }
            foreach ($books as &$book) {
                $author = Author::find($book['author_id']);
                if (is_null($author)) {
                    $author = new Author();
                    $author->author_name = '佚名';
                }
                $book['author'] = $author;
                $this->bookService->getParam($book,$this->end_point);
            }

            return json(['err' => 0, 'books' => $books,'hot_search'=>$hot_search]);
        } catch (DataNotFoundException $e) {
            return json(['err' => 1]);
        } catch (ModelNotFoundException $e) {
            return json(['err' => 1]);
        }

    }

    private function getHotWord($keyword)
    {
        $redis = RedisHelper::GetInstance();
        $redis->zIncrBy($this->redis_prefix . 'hot_search', 1, $keyword); //搜索词写入redis热搜
        $hot_search_json = $redis->zRevRange($this->redis_prefix . 'hot_search', 0, 4, true);
        return array_keys($hot_search_json);
    }
}