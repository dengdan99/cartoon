<?php


namespace app\validate;


use think\Validate;

class User extends Validate
{
    protected $field = [
        'username' => '用户名',
        'password' => '密码',
        'old_password' => '旧密码',
    ];

    protected $rule = [
        'username' => 'max:32|min:6|alphaDash|unique:user',
        'password' => 'confirm|max:32|min:6|alphaDash',
        'old_password' => 'require|max:32|min:6|alphaDash',
    ];

}