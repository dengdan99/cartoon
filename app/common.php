<?php
// 应用公共文件

if (!function_exists('delete_dir_file')) {
    function delete_dir_file($dir_name)
    {
        $result = false;
        if (is_dir($dir_name)) {
            if ($handle = opendir($dir_name)) {
                while (false !== ($item = readdir($handle))) {
                    if ($item != '.' && $item != '..') {
                        if (is_dir($dir_name . DIRECTORY_SEPARATOR . $item)) {
                            delete_dir_file($dir_name . DIRECTORY_SEPARATOR . $item);
                        } else {
                            unlink($dir_name . DIRECTORY_SEPARATOR . $item);
                        }
                    }
                }
                closedir($handle);
                if (rmdir($dir_name)) { //删除空白目录
                    $result = true;
                }
            }
        }
        return $result;
    }
}

if (!function_exists('subtext')) {
    function subtext($text, $length)
    {
        $text2 = strip_tags($text);
        if (mb_strlen($text2, 'utf8') > $length)
            return mb_substr($text2, 0, $length, 'utf8');
        return $text2;
    }
}
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 4)
    {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

//验证session中的验证码和手机号码是否正确
if (!function_exists('verifycode')) {
    function verifycode($code, $phone)
    {
        if (is_null(session('xwx_sms_code')) || $code != session('xwx_sms_code')) {
            return 0;
        }
        if (is_null(session('xwx_cms_phone')) || $phone != session('xwx_cms_phone')) {
            return 0;
        }
        return 1;
    }
}

if (!function_exists('random_color')) {
    function random_color()
    {
        mt_srand((double)microtime() * 1000000);
        $c = '';
        while (strlen($c) < 6) {
            $c .= sprintf("%02X", mt_rand(0, 255));
        }
        return $c;
    }
}

/**
 * curl post data
 * @param $url
 * @param array $data
 * @param bool $header
 * @return bool|string
 */
if (!function_exists('curlPost')) {
    function curlPost($url, $data, $header = ['Content-Type: application/x-www-form-urlencoded'])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        // POST提交
        curl_setopt($curl, CURLOPT_POST, true);
        // POST数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        if (1 == strpos("$" . $url, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output, true);
    }
}

if (!function_exists('getIp')) {
    function getIp()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return ($ip);
    }
}

/**
 * 算出两个时间差的天数
 * $date1>$date2
 * @param $date1
 * @param $date2
 * @param string $a
 * @return string
 */
if (!function_exists('diffDays')) {
    function diffDays($date1, $date2, $a = "a")
    {
        $date1 = date_create(date('Y-m-d H:i:s', $date1));
        $date2 = date_create(date('Y-m-d H:i:s', $date2));
        $diff = date_diff($date1, $date2);
        return $diff->format("%" . $a);
    }
}

/**
 * 获取随机字符串
 * @param int $length 长度
 * @param string $type 类型
 * @param int $convert 转换大小写
 * @return string 随机字符串
 */
if (!function_exists('random')) {
    function random($length = 6, $type = 'all', $convert = 0)
    {
        $config = array(
            'number' => '1234567890',
            'letter' => 'abcdefghijklmnopqrstuvwxyz',
            'string' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        );

        if (!isset($config[$type])) $type = 'string';
        $string = $config[$type];

        $code = '';
        $strlen = strlen($string) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{mt_rand(0, $strlen)};
        }
        if (!empty($convert)) {
            $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
        }
        return $code;
    }
}

/**
 * 返回key=>val映射
 * @param $data
 * @param $key
 * @param $val
 * @return array
 */
if (!function_exists('arrayMapByKey')) {
    function arrayMapByKey($data, $key = 'id', $val = '')
    {
        $result = array();
        if (!empty($data)) {
            foreach ($data as $record) {
                if (empty($val)) {
                    $result[$record[$key]] = $record;
                } else {
                    $result[$record[$key]] = $record[$val];
                }
            }
        }
        return $result;
    }
}