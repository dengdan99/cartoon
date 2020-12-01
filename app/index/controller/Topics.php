<?php


namespace app\index\controller;


use app\model\Topic;
use think\Exception;
use think\facade\Db;
use think\facade\View;

class Topics extends Base
{
    protected $bookService;
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->bookService = app('bookService');
    }

    public function index() {
        $id = input('id');
        $topic = cache('topic:'.$id);
        if ($topic == false) {
            try {
                $topic = Topic::findOrFail($id);
            } catch (Exception $e) {
                abort(404, $e->getMessage());
            }
        }

        $books = cache('topic:books:'.$id);
        if (!$books) {
            $books = $this->bookService->search($topic->topic_name, 28, $this->prefix);
            foreach ($books as &$book) {
                if ($this->end_point == 'id') {
                    $book['param'] = $book['id'];
                } else {
                    $book['param'] = $book['unique_id'];
                }
            }
        }
        cache('topic:books:'.$id, $books, null, 'redis');

        $topics = cache('topics:'.md5($topic->topic_name));
        if (!$topics) {
            $topics = Db::query(
                "select * from " . $this->prefix . "topic where match(topic_name) 
            against ('" . $topic->topic_name . "') LIMIT 5");
            cache('topics:'.md5($topic->topic_name), $topics, null, 'redis');
        }

        View::assign([
            'books' => $books,
            'topic' => $topic,
            'topics' => $topics
        ]);
        return view($this->tpl);
    }
}