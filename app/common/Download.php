<?php


namespace app\common;


class Download
{
    public static function downloadFile($filePath,$showName) {
        if (is_file($filePath)) {
            //打开文件
            $file = fopen($filePath,"r");
//            halt($file);
            //返回的文件类型
            Header("Content-type: application/octet-stream");
            //按照字节大小返回
            Header("Accept-Ranges: bytes");
            //返回文件的大小
            Header("Accept-Length: ".filesize('./'.$filePath));
            //这里设置客户端的弹出对话框显示的文件名
            Header("Content-Disposition: attachment; filename=".$showName);
            //一次性将数据传输给客户端
//            echo fread($file, filesize('./'.$filePath));
            //一次只传输1024个字节的数据给客户端
            //向客户端回送数据
            $buffer=1024;//
            //判断文件是否读完
            while (!feof($file)) {
                //将文件读入内存
                $file_data = fread($file, $buffer);
                //每次向客户端回送1024个字节的数据
                echo $file_data;
            }
            fclose ( $file );

            return true;
        }else {
            return false;
        }
    }
}