<?php


namespace app\validate;


use think\Validate;

class Book extends Validate
{
    protected $rule = [
        'book_name|漫画名' => 'require|max:50',
        'tags|标签' => 'require|max:100',
        'tags_id|题材' => 'require|integer',
        'area_id|地区' => 'require|integer',
        'author|作者' => 'require|max:100',
        'start_pay|起始付费章节' => 'require|integer|max:9',
        'money|每章所需费用' => 'require|integer|max:8',
    ];


}