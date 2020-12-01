<?php


namespace app\admin\controller;


use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\facade\View;
use app\service\UserService;
use app\model\User;

class Users extends BaseAdmin
{
    protected $userService;

    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->userService = app('userService');
    }

    public function index()
    { 
        $data = $this->userService->getAdminPagedUsers(1, [], 'id', 'desc');
        View::assign([
            'users' => $data['users'],
            'count' => $data['count']
        ]);
        return view();
    }

    public function search()
    {
        $username = input('username');
        $status = input('status');
        $isvip = input('isvip');
        $sort = input('sort', 'asc');
        $where[] = ['username', 'like', '%' . $username . '%'];
        $time = time();
        if ($isvip == 'yes') {
            $where[] = ['vip_expire_time', '>', $time];
        } else if ($isvip == 'no') {
            $where[] = ['vip_expire_time', '<', $time];
        }
        if ($sort) {
            $orderBy = 'update_time';
        } else {
            $orderBy = 'id';
        }
        $data = $this->userService->getAdminPagedUsers($status, $where, $orderBy, $sort);
        View::assign([
            'users' => $data['users'],
            'count' => $data['count']
        ]);
        if ($status == 1) {
            return view('index');
        } else {
            return view('disabled');
        }
    }

    public function subusers() {
        $parent = input('parent');
        if (empty($parent)) {
            $parent = -1;
        }
        $where[] = ['pid', '=', $parent];
        $data = $this->userService->getAdminPagedUsers(1, $where, 'id', 'desc');
        View::assign([
            'users' => $data['users'],
            'count' => $data['count']
        ]);
        return view();
    }

    public function disabled()
    {
        $data = $this->userService->getAdminPagedUsers(0, [], 'id', 'desc');
        View::assign([
            'users' => $data['users'],
            'count' => $data['count']
        ]);
        return view();
    }

    public function disable()
    {
        $id = input('id');
        if (empty($id) || is_null($id)) {
            return json(['err' => 1]);
        }
        try {
            $user = User::findOrFail($id);
            $result = $user->delete();
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
            $user = User::onlyTrashed()->findOrFail($id);
            $result = $user->restore();
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

    public function edit()
    {
        $id = input('id');
        try {
            $user = User::findOrFail($id);
            if (request()->isPost()) {
                $user->vip_expire_time = strtotime(input('expire_time'));
                $result = $user->save();
                if ($result) {
                    return json(['err' =>0,'msg'=>'修改成功']);
                }else{
                    return json(['err' =>1,'msg'=>'修改失败']);
                }
            }
            $expire_time = (date('Y-m-d', $user->vip_expire_time));
            View::assign([
                'user' => $user,
                'expire_time' => $expire_time
            ]);
            return view();
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function delete()
    {
        $id = input('id');
        try {
            $user = User::find($id);
            if (!empty($user)) {
                $result = $user->delete();
            }else {
                $user = User::onlyTrashed()->find($id);
                if (!empty($user)) {
                    $result = $user->force()->delete();
                }
            }
            if ($result) {
                return ['err' => 0, 'msg' => '删除成功'];
            } else {
                return ['err' => 1, 'msg' => '删除失败'];
            }
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }

    }

    public function deleteAll()
    {
        $ids = input('ids');
        User::destroy($ids);
    }
}