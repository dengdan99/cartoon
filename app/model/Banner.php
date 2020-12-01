<?php


namespace app\model;


use app\common\Upload;
use think\Model;

class Banner extends Model
{
    public function book()
    {
        return $this->hasOne('book', 'id', 'book_id');
    }

    public function setTitleAttr($value)
    {
        return trim($value);
    }

    public function getPicNameAttr($value)
    {
        if(substr( $value, 0, 4 ) == "http") {
            return $value;
        }else{
            return config('extra_config.schema').config('extra_config.img_domain').$value;
        }
    }
}