<?php


namespace app\mobile\controller;


class BaseUc extends Base
{
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->uid = cookie('xwx_user_id');
        if (empty($this->uid)){
            $user = app('userService')->createUser();
            $this->uid = $user->id;
//            $this->redirect(url('account/login'));
        }
    }
}