<?php


namespace app\model;


use think\Model;

class Chapter extends Model
{
    public function book(){
        return $this->belongsTo('book');
    }

    public function photos(){
        return $this->hasMany('photo');
    }

    public function setChapterNameAttr($value){
        return trim($value);
    }


    public function getChapterOrderAttr($value)
    {
        return intval($value);
    }

    public function setChapterOrderAttr($value)
    {
        return intval($value);
    }
}