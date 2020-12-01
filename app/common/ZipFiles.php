<?php


namespace app\common;


class ZipFiles
{

    public static function addFileToZip($path, $current, $zip)
    {
        // 打开文件夹资源
        $handler = opendir($path);
        // 循环读取文件夹内容
        while (($filename = readdir($handler)) !== false) {
            // 过滤掉Linux系统下的.和..文件夹
            if ($filename != '.' && $filename != '..') {
                // 文件指针当前位置指向的如果是文件夹，就递归压缩
                if (is_dir($path . '/' . $filename)) {
                    self::addFileToZip($path . '/' . $filename, $filename, $zip);
                } else {
                    // 为了在压缩文件的同时也将文件夹压缩，可以设置第二个参数为文件夹/文件的形式，文件夹不存在自动创建压缩文件夹
                    $zip->addFile($path . '/' . $filename, $current . '/' . $filename);
                }
            }
        }
        @closedir($handler);
    }
}