<?php


namespace app\admin\controller;

use GuzzleHttp\Client;
use think\Exception;
use think\facade\App;
use think\facade\Db;
use think\facade\View;
use think\facade\Cache;
use DirectoryIterator;

class Index extends BaseAdmin
{
    public function index()
    {
        $schema = config('extra_config.schema');
        $site_name = config('extra_config.site_name');
        $domain = config('extra_config.domain');
        $img_domain = config('extra_config.img_domain');
        $mobile_domain = config('extra_config.mobile_domain');
        $mip_domain = config('extra_config.mip_domain');
        $admin_domain = config('extra_config.admin_domain');
        $api_domain = config('extra_config.api_domain');
        $app_domain = config('extra_config.app_domain');
        $salt = config('extra_config.salt');
        $api_key = config('extra_config.api_key');
        $app_key = config('extra_config.app_key');
        $front_tpl = config('extra_config.tpl');
        $cdn = config('extra_config.cdn');

        $back_end_page = config('extra_config.back_end_page');
        $img_per_page = config('extra_config.img_per_page');
        $booklist_page = config('extra_config.booklist_page');

        $dirs = array();
        $dir = new DirectoryIterator(App::getRootPath().  'public/template/');
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                if ($fileinfo != 'mip') {
                    array_push($dirs,$fileinfo->getFilename());
                }
            }
        }

        View::assign([
            'schema' => $schema,
            'site_name' => $site_name,
            'domain' => $domain,
            'img_domain' => $img_domain,
            'mobile_domain' =>  $mobile_domain,
            'mip_domain' => $mip_domain,
            'admin_domain' => $admin_domain,
            'api_domain' => $api_domain,
            'app_domain' => $app_domain,
            'salt' => $salt,
            'api_key' => $api_key,
            'app_key' => $app_key,
            'front_tpl' => $front_tpl,
            'back_end_page' => $back_end_page,
            'img_per_page' => $img_per_page,
            'booklist_page' => $booklist_page,
            'tpl_dirs' => $dirs,
            'cdn' => $cdn
        ]);
        return view();
    }

    public function update()
    {
        if (request()->isPost()) {
            $schema = input('schema');
            $site_name = input('site_name');
            $domain = input('domain');
            $img_domain = input('img_domain');
            $mobile_domain = input('mobile_domain');
            $mip_domain = input('mip_domain');
            $admin_domain = input('admin_domain');
            $api_domain = input('api_domain');
            $app_domain = input('app_domain');
            $salt = input('salt');
            $api_key = input('api_key');
            $app_key = input('app_key');
            $front_tpl = input('front_tpl');
            $cdn = input('cdn');
            $site_code = <<<INFO
<?php
return [
    'schema' => '{$schema}',
    'domain' => '{$domain}',
    'img_domain' => '{$img_domain}',
    'mobile_domain' => '{$mobile_domain}',
    'mip_domain' => '{$mip_domain}',
    'admin_domain' => '{$admin_domain}',
    'api_domain' => '{$api_domain}',
    'app_domain' => '{$app_domain}',
    'site_name' => '{$site_name}',
    'salt' => '{$salt}',
    'api_key' => '{$api_key}', 
    'app_key' => '{$app_key}',
    'tpl' => '{$front_tpl}',
    'cdn' => '{$cdn}'       
 ];
INFO;
            $file = App::getRootPath() . 'config/site.php';
            if (!file_exists($file)) {
                return json(['err' => 1, 'msg' => '配置文件不存在']);
            }
            file_put_contents($file, $site_code);
            return json(['err' => 0, 'msg' => '修改成功']);
        }
    }

    public function pagenum()
    {
        if ($this->request->isPost()) {
            $back_end_page = input('back_end_page');
            $img_per_page = input('img_per_page');
            $booklist_page = input('booklist_page');
            $code = <<<INFO
<?php
return [
    'back_end_page' => {$back_end_page},
    'img_per_page' => {$img_per_page},
    'booklist_page' => {$booklist_page}
];
INFO;
            $file = App::getRootPath() . 'config/page.php';
            if (!file_exists($file)) {
                return json(['err' => 1, 'msg' => '配置文件不存在']);
            }
            file_put_contents($file, $code);
            return json(['err' => 0, 'msg' => '修改成功']);
        }
    }

    public function clearCache()
    {
        Cache::clear('redis');
        Cache::clear('pay');
        $rootPath = App::getRootPath();
        delete_dir_file($rootPath . '/runtime/cache/') && delete_dir_file($rootPath . '/runtime/temp/');
        return json(['err' => 0, 'msg' => '清理缓存']);
    }

    public function kamiconfig()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $str = <<<INFO
        <?php
        return [
            'vipcode' => [
                'day' => '{$data["vipcode_day"]}',
                'num' => '{$data["vipcode_num"]}'
            ],
            'chargecode' => [
                'money' => '{$data["chargecode_money"]}',
                'num' => '{$data["chargecode_num"]}'
            ]
        ];
INFO;
            $path = App::getAppPath() . 'config/kami.php';
            file_put_contents($path, $str);
            return json(['err' => 0, 'msg' => '保存成功']);
        } else {
            View::assign([
                'vipcode_day' => config('kami.vipcode.day'),
                'vipcode_num' => config('kami.vipcode.num'),
                'chargecode_money' => config('kami.chargecode.money'),
                'chargecode_num' => config('kami.chargecode.num')
            ]);
            return view();
        }
    }

    public function routeconfig(){
        $path = App::getRootPath() . 'public/routeconf.php';
        if ($this->request->isPost()) {
            $conf = input('json');
            file_put_contents($path, $conf);
           return json(['err' => 0, 'msg' => '保存成功']);
        }
        $conf = file_get_contents($path);
        View::assign('json', $conf);
        return view();
    }

    public function seo(){
        if (request()->post()) {
            $book_end_point = input('book_end_point');
            $name_format = input('name_format');
            $num = input('sitemap_gen_num');
            $baidu_js = input('baidu_js');
            $baidu_js = str_replace("\\","",$baidu_js);
            $baidu_js = str_replace("'","\'",$baidu_js);
            $code = <<<INFO
        <?php
        return [
            'book_end_point' => '{$book_end_point}',  //分别为id和name两种形式
            'name_format' => '{$name_format}', //pure是纯拼音,permalink是拼音带连接字符串，abbr是拼音首字母，abbr_permalink是首字母加连接字符串
            'sitemap_gen_num' => '{$num}', //生成最近的1000条，如果想要全部生成，则填0
            'baidu_js' => '{$baidu_js}' //百度统计代码
        ];
INFO;
            file_put_contents(App::getRootPath() . 'config/seo.php', $code);
            return json(['err' => 0, 'msg' => '保存成功']);
        } else {
            $book_end_point = config('extra_config.book_end_point');
            $name_format = config('extra_config.name_format');
            $num = config('extra_config.sitemap_gen_num');
            $baidu_js = config('extra_config.baidu_js');
            View::assign([
                'book_end_point' => $book_end_point,
                'name_format' => $name_format,
                'sitemap_gen_num' => $num,
                'baidu_js' => $baidu_js,
            ]);
            return view();
        }
    }

    public function upgrade(){
        try {
            $client = new Client();
            $srcUrl = App::getRootPath() . "/ver.txt";
            $localVersion = (int)str_replace('.', '', file_get_contents($srcUrl));
            $server = "http://v5.xhxcms.com";
            $serverFileUrl = $server . "/ver.txt";
            $res = $client->request('GET', $serverFileUrl); //读取版本号
            $serverVersion = (int)str_replace('.', '', $res->getBody());
            echo '<p></p>';

            if ($serverVersion > $localVersion) {
                for ($i = $localVersion + 1; $i <= $serverVersion; $i++) {
                    $res = $client->request('GET', "http://v5up.xhxcms.com/" . $i . ".json");
                    if ((int)($res->getStatusCode()) == 200) {
                        $json = json_decode($res->getBody(), true);

                        foreach ($json['update'] as $value) {
                            $data = $client->request('GET', $server . '/' . $value)->getBody(); //根据配置读取升级文件的内容
                            $saveFileName = App::getRootPath(). $value;
                            $dir = dirname($saveFileName);
                            if (!file_exists($dir)) {
                                mkdir($dir, 0777, true);
                            }
                            file_put_contents($saveFileName, $data, true); //将内容写入到本地文件
                            echo '<p style="padding-left:15px;font-weight: 400;color:#999;">升级文件' . $value . '</p>';
                        }

                        foreach ($json['delete'] as $value) {
                            $flag = unlink(App::getRootPath()  . $value);
                            if ($flag) {
                                echo '<p style="padding-left:15px;font-weight: 400;color:#999;">删除文件' . $value . '</p>';
                            } else {
                                echo '<p style="padding-left:15px;font-weight: 400;color:#999;">删除文件失败</p>';
                            }
                        }

                        foreach ($json['sql'] as $value) {
                            //Db::execute('ALTER TABLE aaa ADD `name` INT(0) NOT NULL DEFAULT 0');
                            $value = str_replace('[prefix]',$this->prefix,$value);
                            Db::execute($value);
                            echo '<p style="padding-left:15px;font-weight: 400;">成功执行以下SQL语句：'.$value.'</p>';
                        }
                    }
                }
                echo '<p style="padding-left:15px;font-weight: 400;color:#999;">升级完成</p>';
                file_put_contents($srcUrl, (string)$res->getBody(), true); //将版本号写入到本地文件
                echo '<p style="padding-left:15px;font-weight: 400;color:#999;">覆盖版本号</p>';
            } else {
                echo '<p style="padding-left:15px;font-weight: 400;color:#999;">已经是最新版本！当前版本是' . $localVersion.'</p>';
            }
        }catch (Exception $e) {
            echo '<p style="padding-left:15px;font-weight: 400;color:#999;">'.$e->getMessage().'</p>';
        }

    }
}