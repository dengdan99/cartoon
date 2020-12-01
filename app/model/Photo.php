<?php


namespace app\model;


use app\common\Upload;
use think\Model;

class Photo extends Model
{
    public function chapter(){
        return $this->belongsTo('chapter');
    }

    public function getPicOrderAttr($value)
    {
        return intval($value);
    }

    public function setPicOrderAttr($value)
    {
        return intval($value);
    }

    public function getImgUrlAttr($value)
    {
        if(substr( $value, 0, 4 ) == "http") {
            return $value;
        }else{
            return config('extra_config.schema').config('extra_config.img_domain').$value;
        }

    }
}