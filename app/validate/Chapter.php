<?php


namespace app\validate;


use think\facade\Db;
use think\Validate;

class Chapter extends Validate
{
    protected $rule = [
        'chapter_order' => 'require|integer|checkSort',
    ];

    protected $message = [
        'chapter_order.require' => '章节序不能为空',
        'chapter_order.integer' => '章节序必须是整数',
        'chapter_order.checkSort' => '章节序不能重复',
    ];

    public function sceneSort()
    {
        return $this->only(['chapter_order']);
    }


    public function checkSort($value,$rule,$data)
    {
        if (isset($data['id']) && !empty($data['id'])){
            $table = Db::name('chapter')->find($data['id']);
            if (empty($table))
                return false;
            else
                return true;
        }
        return true;
    }
}