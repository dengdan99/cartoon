<?php


namespace app\admin\controller;


use app\BaseController;
use app\common\Upload;

class Test extends BaseController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $url = "http://dfs.w.fanyuwangluo.com/group1/M00/00/18/rBie7V9pZGWAUqJbAADmg5ePvas767.jpg";
//        $url = "http://m.mh.manhua-php.net:8080/static/upload/book/cover/20200831/63aaee234eb58/7f220874ac48a79c80d.jpg";

        $upload = new Upload();
        $fileSuffix = $upload->getSuffix($url);
//        halt($fileSuffix);

        @$content = file_get_contents($url);
        if (!$content){
            @$content = file_get_contents(config('extra_config.schema').config('extra_config.mobile_domain').$url);
//            halt($content);
        }
        if (!$content){
            return '<img src="' . $url . '">';       //图片形式展示
        }
        $con = chunk_split(base64_encode($content));
        $img_base64 = 'data:image/' . $fileSuffix . ';base64,' . $con;//合成图片的base64编码
        return '<img src="' . $img_base64 . '">';       //图片形式展示

    }
}