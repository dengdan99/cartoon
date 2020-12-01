<?php


namespace app\common;


use app\validate\Image;
use think\Exception;
use think\exception\HttpException;
use think\exception\ValidateException;
use Intervention\Image\ImageManagerStatic as Img;

class Upload
{
    public function uploadFile($cover, $dir,$water = false)
    {
        validate(Image::class)
            ->check(['image'=>$cover]);
        if (true) {
            return $this->uploadAttach($cover,$water);
        } else {
            $savename = str_replace('\\', '/',
                \think\facade\Filesystem::disk('public')->putFile($dir, $cover));
            if (!is_null($savename)) {
                return '/static/upload/'.str_replace('\\', '/', $savename);
            }
        }
    }

    //上传附件
    public function uploadAttach($file,$water)
    {
        $ret = array();
        $ret['err'] = 0;
        $ret['msg'] = '';
        $file_tmp_name = $file->getPathname();
        $file_type = $file->getOriginalMime();
        $filename = $file->getOriginalName();

        $curlFile = new \CURLFile($file_tmp_name, $file_type, $filename);

        $fileSuffix = $this->getSuffix($curlFile->getPostFilename());
        $img = file_get_contents($curlFile->getFilename());
        if ($water){
            $img = $this->imageAddWater(file_get_contents($curlFile->getFilename()),$fileSuffix);
        }
        $ret['file'] = $file;
        $fileId = $this->uploadToFastdfs($img, $fileSuffix);
        if (is_array($fileId)) {
            return implode('/', $fileId);
        }else{
            throw new HttpException(500,json_encode($fileId),null,[],110);
        }
    }

    //获取后缀
    public function getSuffix($fileName)
    {
        preg_match('/\.(\w+)?$/', $fileName, $matchs);
        return isset($matchs[1])?$matchs[1]:'';
    }

    //上传文件到fastdfs
    public function uploadToFastdfs( $file, $fileSuffix)
    {
        $fastDFS = new \FastDFS();
        $res = $fastDFS->connect_server(env('DFS_IP'),env('DFS_PORT'));
        if (!$res){
            throw new HttpException(500,'dfs 连接错误');
        }
//        halt($fastDFS);
        $fastDFS->tracker_get_connection();
        $con = chunk_split(base64_encode($file));
        $img_base64 = 'data:image/' . $fileSuffix . ';base64,' . $con;//合成图片的base64编码
        try {

            $fileId = $fastDFS->storage_upload_by_filebuff($img_base64, 'txt');
            $fastDFS->tracker_close_all_connections();
        }catch (\Exception $e){
            halt($e->getMessage());
        }
        return $fileId;
    }
    
    //给图片添加水印
    public function imageAddWater($image,$fileSuffix)
    {
        $img = Img::make($image);
        $water = Img::make('static/images/image-water.png');
        $img->insert($water,'bottom-right',10,10);
//        return $img->save('static/upload/hebing.jpg',80,'jpg');
        return $img->stream($fileSuffix)->getContents();
    }

    public function deleteFile($group_name,$filename)
    {
        $fastDFS = new \FastDFS();
        $res = $fastDFS->connect_server(env('DFS_IP'),env('DFS_PORT'));
        if (!$res){
            throw new HttpException(500,'dfs 连接错误');
        }
        $fastDFS->tracker_get_connection();
        return fastdfs_storage_delete_file($group_name, $filename);
    }

}