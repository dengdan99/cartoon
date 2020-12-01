<?php


namespace app\service;

use app\common\RedisHelper;
use app\model\Book;
use app\model\Chapter;
use app\model\Clicks;
use app\model\UserBuy;
use think\facade\Db;

class BookService
{
    public function getPagedBooksAdmin($status, $where = '1=1')
    {
        if ($status == 1) {
            $data = Book::where($where);
        } else {
            $data = Book::onlyTrashed()->where($where);
        }
        $page = config('extra_config.back_end_page');
        $books = $data->order('id', 'desc')
            ->paginate(
                [
                    'list_rows'=> $page,
                    'query' => request()->param(),
                    'var_page' => 'page',
                ]);
        foreach ($books as &$book) {
            $book['chapter_count'] = Chapter::where('book_id','=',$book->id)->count();
            $book['clicks'] = $this->getClicks($book->id);
        }
        return [
            'books' => $books,
            'count' => $data->count()
        ];
    }

    public function getPagedBooks($num, $end_point, $order = 'id', $where = '1=1')
    {
        $data = Book::where($where)->with('chapters')->order($order, 'desc')
            ->paginate([
                'list_rows'=> $num,
                'query' => request()->param(),
            ]);
        $this->setParamList($data,$end_point);
        $books = $data->toArray();
        return [
            'books' => $books['data'],
            'page' => [
                'total' => $books['total'],
                'per_page' => $books['per_page'],
                'current_page' => $books['current_page'],
                'last_page' => $books['last_page'],
                'query' => request()->param()
            ]
        ];
    }

    public function getBooks($end_point, $order = 'last_time', $where = '1=1', $num = 6 )
    {
        $books = Book::with(['chapters','author'])->where($where)
            ->limit($num)->order($order, 'desc')->select();
        foreach ($books as &$book) {
            $book->taglist = explode('|', $book->tags);
            $this->getParam($book,$end_point);
        }
        return $books;
    }

    public function getMostChargedBook($end_point)
    {
        $data = UserBuy::with(['book' => ['author']])->field('book_id,sum(money) as sum')
            ->group('book_id')->select();
        if (count($data) > 0) {
            foreach ($data as &$item) {
                if (!is_null($item['book'])) {
                    $book = $item['book'];
                    $book['taglist'] = explode('|', $item['book']['tags']);
                    $this->getParam($book,$end_point);
                    $item['book'] = $book;
                }
            }
            $arr = $data->toArray();
            array_multisort(array_column($arr, 'sum'), SORT_DESC, $arr);
            return $arr;
        } else {
            return [];
        }
    }

    public function getRecommand($tags, $end_point)
    {
        $arr = explode('|', $tags);
        $map = array();
        foreach ($arr as $value) {
            $map[] = ['tags', 'like', '%' . $value . '%'];
        }
        $books = Book::where($map)->limit(10)->select();
        $this->setParamList($books,$end_point);
        return $books;
    }

    public function getByTag($tag_id, $end_point, $limit)
    {
        $books = Book::where('tags_id', $tag_id)
            ->order('id','desc')->limit($limit)->select();
        $this->setParamList($books,$end_point);
        return $books;
    }

    public function getRand($num, $prefix, $end_point)
    {
        $books = Db::query('SELECT a.id,a.book_name,a.summary,a.end,a.author_name,a.cover_url FROM 
                    (SELECT ad1.id,book_name,summary,`end`,author_id,cover_url,author_name
FROM ' . $this->prefix . 'book AS ad1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM ' . $this->prefix . 'book)-(SELECT MIN(id) FROM '
            . $this->prefix . 'book))+(SELECT MIN(id) FROM ' . $this->prefix . 'book)) AS id)
             AS t2 WHERE ad1.id >= t2.id ORDER BY ad1.id LIMIT 20) as a');
        $this->setParamList($books,$end_point);
        return $books;
    }

    public function search($keyword, $size, $prefix, $page = 0)
    {
        if ($keyword){
            // with query expansion   IN NATURAL LANGUAGE MODE
            $results = Book::where('delete_time',0)
                ->whereRaw(" match(book_name) against (:keyword with query expansion) ",['keyword'=>$keyword])
                ->paginate([
                    'page'=>$page,
                    'list_rows'=>$size
                ]);
        }else{
            $results = Book::where('delete_time',0)
                ->paginate([
                    'page'=>$page,
                    'list_rows'=>$size
                ]);
        }
        return $results->toArray()['data'];
    }

    public function getHotBooks($prefix, $end_point, $date = '1900-01-01', $num = 10)
    {
//        $data = Db::query("SELECT book_id,SUM(clicks) as clicks FROM " . $prefix . "clicks WHERE cdate>=:cdate
// GROUP BY book_id ORDER BY clicks DESC LIMIT :num", ['cdate' => $date, 'num' => $num]);
        $ids = Book::column('id');
        if (empty($ids)) {
            # code...
            return [];
        }
//        $clicksL = Clicks::field('book_id,sum(clicks) as clicks')
//            ->where('cdate','>=',$date)
//            ->whereIn('book_id',$ids)
//            ->group('book_id')->order('clicks','desc')->limit($num)->select();

        $ids_str = implode(',',$ids);
        $clicksArr = Db::query("SELECT
	b.id AS book_id,
	b.clicks AS b_clicks,
	(
		SELECT
			COUNT(*)
		FROM
			`{$prefix}clicks` AS c
		WHERE
			c.book_id = b.id
		AND c.cdate >= {$date}
	) AS c_clicks
FROM
	`{$prefix}book` AS b
WHERE
	b.id IN ({$ids_str})
ORDER BY
	b_clicks + c_clicks DESC
LIMIT {$num}");


        $books = array();
//        $booksArr = array();
//        foreach ($clicksL->toArray() as $val) {
//            $book = Book::with('chapters')->find($val['book_id']);
//            if ($book) {
//                //$book['chapter_count'] = Chapter::where('book_id', '=', $book['id'])->count();
//                $book->taglist = explode('|', $book->tags);
//                $book->clicks = $val['clicks'];
//                $this->getParam($book,$end_point);
//                array_push($books, $book);
//            }
//        }

        foreach ($clicksArr as $val) {
            $book = Book::with('chapters')->find($val['book_id']);
            if ($book) {
                //$book['chapter_count'] = Chapter::where('book_id', '=', $book['id'])->count();
                $book->taglist = explode('|', $book->tags);
                $book->clicks = intval($val['b_clicks']) + intval($val['c_clicks']);
                $this->getParam($book,$end_point);
                array_push($books, $book);
            }
        }
        return $books;
    }

    public function getClicks($book_id, $prefix = '')
    {
        $book = Book::find($book_id);
        $click = Clicks::where('book_id',$book['id'])->count();
        return $book['clicks'] + $click;
//        $clicks = Db::query("SELECT click FROM(SELECT book_id,
// sum(clicks) as click FROM " . $prefix . "clicks GROUP BY book_id) as a WHERE book_id=:book_id", ['book_id' => $book_id]);
//        if (empty($clicks)) {
//            return 0;
//        }
//        return $clicks[0]['click'];
    }

    public function getByTags($tags_id, $end_point, $limit)
    {
        $books = Book::where('tags_id','=', $tags_id)
            ->order('id','desc')->limit($limit)->select();
        $this->setParamList($books,$end_point);
        return $books;
    }

    public function updateBookClickNumber($book_id)
    {
        $click = new Clicks();
        $click->book_id = $book_id;
        $click->clicks = 1;
        $click->cdate = date('Y-m-d');
        $click->save();
    }

    public function getParam(&$book,$end_point)
    {
        if ($end_point == 'name') {
            $book['param'] = $book['unique_id'];
        } else {
            $book['param'] = $book['id'];
        }
    }

    public function setParamList(&$books, $end_point)
    {
        foreach ($books as &$book){
            $this->getParam($book,$end_point);
        }
    }
}