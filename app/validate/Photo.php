<?php


namespace app\validate;


use think\Validate;

class Photo extends Validate
{
    protected $rule = [
        'pic_order' => 'require|integer',
    ];

    protected $message = [
        'pic_order.require' => '序号不能为空',
        'pic_order.integer' => '序号必须是整数',
    ];


    public function sceneSort()
    {
        return $this->only(['pic_order']);
    }


}