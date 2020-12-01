<?php


namespace app\service;

use app\model\Book;
use app\model\User;
use app\model\UserFavor;
use app\model\UserFinance;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\HttpException;
use think\facade\Cookie;

class UserService
{
    public function getAdminPagedUsers($status, $where, $orderBy, $order)
    {
        if ($status == 1) { //正常用户
            $data = User::where($where)->order($orderBy, $order);
        } else { 
            $data = User::onlyTrashed()->where($where)->order($orderBy, $order);
        }
        $financeService = new FinanceService();
        $page = config('extra_config.back_end_page');
        $users = $data->paginate(
            [
                'list_rows'=> $page,
                'query' => request()->param(),
                'var_page' => 'page',
            ])->each(function ($item, $key) use($financeService){
            $item['balance'] = $financeService->getBalance($item->id);
        });
         
        return [
            'users' => $users,
            'count' => $data->count()
        ];
    }

    public function getFavors($uid, $end_point)
    {
        try {
            $where[] = ['user_id', '=', $uid];
            $data = UserFavor::where($where)->order('create_time', 'desc')->paginate(10, false);
            $books = array();
            foreach ($data as &$favor) {
                $book = Book::findOrFail($favor->book_id);
                if ($end_point == 'id') {
                    $book['param'] = $book['id'];
                } else {
                    $book['param'] = $book['unique_id'];
                }
                $books[] = $book->toArray();
            }
            $pages = $data->toArray();
            return [
                'books' => $books,
                'page' => [
                    'total' => $pages['total'],
                    'per_page' => $pages['per_page'],
                    'current_page' => $pages['current_page'],
                    'last_page' => $pages['last_page'],
                    'query' => request()->param()
                ]
            ];
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function delFavors($uid, $ids)
    {
        $where[] = ['user_id', '=', $uid];
        $where[] = ['book_id', 'in', $ids];
        $favors = UserFavor::where($where)->selectOrFail();
        foreach ($favors as $favor) {
            $favor->delete();
        }
    }

    /**
     * 注册用户 没有传值就随机注册
     * @param string $username
     * @param string $password
     * @return array|\think\Model|null
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws \think\db\exception\DbException
     */
    public function createUser($username = '', $password = '')
    {
        if (empty($username)){
            $username = random(mt_rand(5,10));
        }
        if (empty($password)){
            $password = "123456";
        }
        $user = new User();
        $user->username = $username;
        $user->password = $password;
        $user->pid = 0; //设置用户上线id
        $pid = cookie('xwx_promotion');
        if ($pid) {
            $user->pid = $pid; //设置用户上线id
        }
        $user->save();
        $user = User::find($user->id);
        $this->updateCookieUser($user, $password);
        if ($pid){
            $pidUser = User::find($pid);
            app('financeService')->addSpreadUserGold($pidUser);
        }
        return $user;
    }

    /**
     * 更新用户cookie
     * @param User $user
     * @param string $password
     */
    public function updateCookieUser($user,$password = '')
    {
        $this->clearCookie();
        $balance = app('financeService')->getBalance($user->id);
        Cookie::forever('xwx_user_id', (string)$user->id);
        Cookie::forever('xwx_user', (string)$user->username);
        if (!empty($password)) {
            Cookie::forever('xwx_user_pwd', (string)$password);
        }
        Cookie::forever('xwx_nick_name', (string)$user->nick_name);
        Cookie::forever('xwx_user_mobile',(string)$user->mobile);
        Cookie::forever('xwx_vip_expire_time', (string)$user->vip_expire_time);
        Cookie::forever('balance',(string)$balance);
    }

    public function clearCookie()
    {
        Cookie::delete('xwx_user_id');
        Cookie::delete('xwx_user');
        Cookie::delete('xwx_user_pwd');
        Cookie::delete('xwx_nick_name');
        Cookie::delete('xwx_user_mobile');
        Cookie::delete('xwx_vip_expire_time');
        Cookie::delete('balance');

    }
}