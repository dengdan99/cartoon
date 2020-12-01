<?php

namespace app\pay;


use app\BaseController;
use Exception;
use think\App;

class Pay
{

    public function submit1($order_id, $money, $pay_type, $pay_code)
    {
        $mch_id = trim(config('extra_config.payment.pay.appid'));//这里改成支付ID
        $mch_key = trim(config('extra_config.payment.pay.appkey')); //这是您的通讯密钥
        $data = array(
            "mch_uid" => $mch_id,//你的支付ID
            "out_trade_no" => $order_id, //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "pay_type_id" => (int)$pay_code,//1微信支付 2支付宝
            "total_fee" => $money,//金额
            "notify_url" => config('extra_config.schema').config('extra_config.api_domain') . '/paynotify',//通知地址
            "return_url" => config('extra_config.schema').config('extra_config.domain') . '/feedback',//跳转地址
            "mepay_type" => 2
        ); //构造需要传递的参数
        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素
        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空

        foreach ($data AS $key => $val) { //遍历需要传递的参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值
        }

        $query = $urls . '&sign=' . md5($sign . $mch_key); //创建订单所需的参数
        $url = "https://www.zhapay.com/pay.html?{$query}"; //支付页面
        header("Location:{$url}"); //跳转到支付页面
    }

    public function submit($order_id, $money, $pay_type, $pay_code)
    {
        $mch_id = trim(config('extra_config.payment.pay.mchid'));//这里改成支付ID
        $mch_key = trim(config('extra_config.payment.pay.appkey')); //这是您的通讯密钥

        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad'))
//            echo 'systerm is IOS';
            $devicetype = "1";
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android'))
//            echo 'systerm is Android';
            $devicetype = "2";
        else
//            echo 'systerm is other';
            $devicetype = "3";


        $data = [
            'merid'=>$mch_id,
            'orderno'=>$order_id,
            'paytype'=>$pay_type,
            'money'=>$money*100,
            'notifyurl'=> config('extra_config.schema').config('extra_config.api_domain') . '/paynotify',//通知地址
            'deviceip'=>getIp(),
            'deviceid'=>"",
            'devicetype'=>$devicetype,
            'payname'=>"",
            'payrealname'=>"",
            'time'=>time(),
            'attach'=>"",
            'user_id'=>"",
            'tel'=>"",
        ];
        $data['sign'] = md5($data['merid'].$data['orderno'].$data['paytype'].$data['money'].$data['notifyurl'].$data['time'].$mch_key);
        $url = "http://oth2.syzxmy.com:22893/pay/index.html";
        $header = ["Content-Type: application/x-www-form-urlencoded"];
        $result = curlPost($url,http_build_query($data),$header);
        // if ($result['status'] == 1){
        //     $sign = md5($mch_id.$result['status'].$result['orderno'].$result['payurl'].$mch_key);
        //     if ($sign != $result['sign']){
        //         return ['status'=>1,'content'=>'签名验证失败'];
        //     }
        //     return ['status'=>1,'content'=>$result['payurl']];
        // }else{
        //     return ['status'=>2,'content'=>'支付错误：'.$result['text']];
        // }
        if ($result['status'] == 1) {
            $sign = md5($mch_id.$result['status'].$result['orderno'].$result['payurl'].$mch_key);
            if ($sign != $result['sign']){
                throw new Exception('签名验证失败');
            }
        }
        return $result;
    }
}