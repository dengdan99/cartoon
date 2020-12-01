<?php


namespace app\model;


use app\common\Upload;
use think\Model;

class Tags extends Model
{
    public function setTagNameAttr($value){
        return trim($value);
    }

    public function getCoverUrlAttr($value)
    {
        if(substr( $value, 0, 4 ) == "http") {
            return $value;
        }else{
            return config('extra_config.schema').config('extra_config.img_domain').$value;
        }
    }
}