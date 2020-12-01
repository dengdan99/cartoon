<?php


namespace app\index\controller;

use app\model\UserFavor;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;
use app\model\Chapter;
use app\model\UserBuy;
use think\facade\View;

class Chapters extends Base
{
    protected $photoService;

    protected function initialize()
    {
        parent::initialize();
        $this->photoService = app('photoService');
    }

    public function index($id)
    {
        try {
            $chapter = Chapter::with('book')->cache('chapter:' . $id, 600, 'redis')->findOrFail($id);
            if ($this->end_point == 'id') {
                $chapter->book['param'] = $chapter->book['id'];
            } else {
                $chapter->book['param'] = $chapter->book['unique_id'];
            }
            $flag = true;
            $start_pay = 0;
            if ($chapter->book->start_pay > 0) {
                $start_pay = $chapter->book->start_pay;
                if ($chapter->chapter_order >= $chapter->book->start_pay) { //如果本章序大于起始付费章节，则是付费章节
                    $flag = false;
                }
            } else if ($chapter->book->start_pay < 0) { //如果是倒序付费设置
                $abs = abs($chapter->book->start_pay) - 1; //取得倒序的绝对值，比如-2，则是倒数第2章开始付费
                $max_chapter_order = cache('maxChapterOrder:' . $chapter->book_id);
                if (!$max_chapter_order) {
                    $max_chapter_order = Db::query("SELECT MAX(chapter_order) as max FROM " . $this->prefix . "chapter WHERE book_id=:id",
                        ['id' => $chapter->book_id])[0]['max'];
                    cache('maxChapterOrder:' . $chapter->book_id, $max_chapter_order);
                }
                $start_pay = (float)$max_chapter_order - $abs; //计算出起始付费章节
                if ($chapter->chapter_order >= $start_pay) { //如果本章序大于起始付费章节，则是付费章节
                    $flag = false;
                }
            }

            if (!$flag) {
                $uid = cookie('xwx_user_id');
                if (!is_null($uid)) { //如果用户已经登录
                    $vip_expire_time = cookie('xwx_vip_expire_time'); //用户等级
                    $time = $vip_expire_time - time(); //计算vip用户时长
                    if ($time > 0) { //如果是vip会员且没过期，则可以不受限制
                        $flag = true;
                    } else { //如果不是会员，则判断用户是否购买本章节
                        $map[] = ['user_id', '=', $uid];
                        $map[] = ['chapter_id', '=', $id];
                        $userBuy = UserBuy::where($map)->find();
                        if (!is_null($userBuy)) {
                            $flag = true; //说明用户购买了本章节
                        }
                    }
                }
            }

            if ($flag) {
                $num = config('extra_config.img_per_page');
                $page = empty(input('page')) ? '1' : input('page');
                $data = $this->photoService->getPaged($chapter->id, $page, $num); //图片分页数据

                $book_id = $chapter->book_id;
                $chapters = cache('mulu:' . $book_id);
                if (!$chapters) {
                    $chapters = Chapter::where('book_id', '=', $book_id)->select();
                    cache('mulu:' . $book_id, $chapters, null, 'redis');
                }


                $prev = cache('chapterPrev:' . $id);
                if (!$prev) {
                    $prev = Chapter::where('book_id',$book_id)
                        ->where('chapter_order','<',$chapter->chapter_order)
                        ->order('chapter_order','desc')->limit(1)->find();
                    cache('chapterPrev:' . $id, $prev, null, 'redis');
                }
                if ($prev) {
                    View::assign('prev', $prev);
                } else {
                    View::assign('prev', 'null');
                }

                $next = cache('chapterNext:' . $id);
                if (!$next) {
                    $next = Chapter::where('book_id',$book_id)
                        ->where('chapter_order','>',$chapter->chapter_order)
                        ->order('chapter_order')->limit(1)->find();
                    cache('chapterNext:' . $id, $next, null, 'redis');
                }
                if ( $next ) {
                    View::assign('next', $next);
                } else {
                    View::assign('next', 'null');
                }

                $isfavor = 0;
                if (!is_null($this->uid)) {
                    $where[] = ['user_id', '=', $this->uid];
                    $where[] = ['book_id', '=', $book_id];
                    try {
                        $userfavor = UserFavor::where($where)->findOrFail();
                        $isfavor = 1;
                    } catch (DataNotFoundException $e) {
                    } catch (ModelNotFoundException $e) {
                    }
                }

                View::assign([
                    'chapter' => $chapter,
                    'page' => $data['page'],
                    'chapters' => $chapters,
                    'photos' => $data['photos'],
                    'chapter_count' => count($chapters),
                    'isfavor' => $isfavor,
                    'site_name' => config('extra_config.site_name'),
                    'start_pay'=>$start_pay
                ]);

                return view($this->tpl);
            } else {
                return redirect('/buychapter?chapter_id='.$id);
            }
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }
}