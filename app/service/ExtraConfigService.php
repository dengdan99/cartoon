<?php


namespace app\service;

use app\model\ExtraConfig;

class ExtraConfigService
{

    public function getConfig()
    {
        $extra_config = cache('extra_config');
        if ($extra_config){
            $extra_config = json_decode($extra_config,true);
        }else{
            $select = (\app\model\ExtraConfig::select())->toArray();
            $select = arrayMapByKey($select,'key','val');
            $payment = $select['payment_list'];
            $pay = '$pay';
            $str = <<<INFO
$payment;
INFO;
            $str = str_replace('"','',$str);
            eval ("\$pay = $payment;");
            $select['payment'] = $pay;
            $extra_config = ['extra_config'=>$select];
            cache('extra_config',json_encode($extra_config));
        }
        return $extra_config;
    }

}