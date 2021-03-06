<?php


namespace app\admin\controller;

use app\BaseController;
use app\common\Upload;
use app\validate\Image;
//use http\Header;
use think\App;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Env;
use think\facade\Route;
use think\facade\View;

class BaseAdmin extends BaseController
{
    protected $prefix;
    protected $site;
    protected $end_point;

    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        if (empty(session('xwx_admin'))) {
            $this->redirect((string)url('login/login'));
        }

        $extra_config = app('extraConfigService')->getConfig();
        config($extra_config);

        $this->prefix = Env::get('database.prefix');
        $this->site = config('extra_config.schema').config('extra_config.domain');
        $this->end_point = config('extra_config.book_end_point');

        View::assign([
            'prefix' => $this->prefix,
            'admin' => cookie('xwx_admin'),
            'cdn' => config('extra_config.cdn'),
            'site' => $this->site
        ]);
    }

    public function uploadImg($cover, $dir, $water = false)
    {
        $upload = new Upload();
        return $upload->uploadFile($cover,$dir,$water);
    }

    public function deletePhoto($urls)
    {
        if (is_array($urls)){
            foreach ($urls as $url){
                $this->deleteFile($url);
            }
        }elseif (is_string($urls)){
            $this->deleteFile($urls);
        }
    }
    
    private function deleteFile($urls){
        $upload = new Upload();
        $img_site = config('extra_config.schema').config('extra_config.img_domain');
        $urls = str_replace($img_site,'',$urls);
        $arr = explode('/',$urls);
        $group = $arr[0];
        unset($arr[0]);
        $path = implode('/',$arr);
        return $upload->deleteFile($group,$path);
    }
}