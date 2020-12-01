<?php


namespace app\model;

use app\common\Upload;
use think\model\concern\SoftDelete;
use think\Model;

class Book extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    public static function onBeforeUpdate($book)
    {
        cache('book:' . $book->id,null);
        cache('tags:book:' . $book->id,null);
    }

    public static function onAfterInsert($user)
    {
        cache('newestHomepage',null);
        cache('endsHomepage',null);
    }

    public function author()
    {
        return $this->belongsTo('Author');
    }

    public function area(){
        return $this->belongsTo('Area');
    }

    public function chapters(){
        return $this->hasMany('chapter');
    }

    public function users(){
        return $this->belongsToMany('User');
    }

    public function setBookNameAttr($value){
        return trim($value);
    }

    public function setTagsAttr($value){
        return trim($value);
    }

    public function setSummaryAttr($value){
        return trim($value);
    }

    public function setSrcAttr($value){
        return trim($value);
    }

    public function tag()
    {
        return $this->belongsTo('Tags');
    }

    public function getMoneyAttr($value)
    {
        return intval($value);
    }

    public function setMoneyAttr($value)
    {
        return intval($value);
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