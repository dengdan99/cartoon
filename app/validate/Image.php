<?php


namespace app\validate;


use think\Validate;

class Image extends Validate
{
    protected $rule = [
        'image'=>'fileExt:jpeg,bmp,jpg,png,tif,gif,pcx,tga,exif,fpx,svg,psd,cdr,pcd,dxf,ufo,eps,ai,raw,WMF,webp,avif'
    ];


    protected $message = [
//        'image.fileSize' => '上传文件大于2M',
        'image.fileExt' => '上传文件不是图片格式',
    ];
}