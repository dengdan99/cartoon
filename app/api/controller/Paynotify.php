<?php


namespace app\api\controller;


use app\BaseController;
use app\model\User;
use app\model\UserFinance;
use app\model\UserOrder;
use app\service\PromotionService;

class Paynotify extends BaseController
{
    public function index2()
    {
        $data = request()->param();
        ksort($data); //排序post参数
        reset($data); //内部指针指向数组中的第一个元素
        $pay_key = config('extra_config.zhapay.appkey'); //这是您的密钥
        $sign = '';//初始化
        foreach ($_POST AS $key => $val) { //遍历POST参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不签名
            if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
            $sign .= "$key=$val"; //拼接为url参数形式
        }
        if (!$data['transaction_id'] || md5($sign . $pay_key) != $data['sign'] || $data['status'] != 1) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $order_id = str_replace('xwx_order_', '', $data['out_trade_no']);
            $type = 1; //默认支付宝
            if ($data['pay_type'] == 1) {
                $type = 3; //微信支付
            }
            $status = 0;
            if ((int)$data['status'] == 1) { //如果已支付，则更新用户财务信息
                $status=1;
                $order = UserOrder::find($order_id); //通过返回的订单id查询数据库
                if ($order) {
                    if ((int)$order->status == 0){
                        $order->money = $data['total_fee'];
                        $order->update_time = $data['paytime']; //云端处理订单时间戳
                        $order->status = $status;
                        $order->save(); //更新订单

                        $userFinance = new UserFinance();
                        $userFinance->user_id = $order->user_id;
                        $userFinance->money = $order->money;
                        $userFinance->usage = 1; //用户充值
                        $userFinance->summary = '幻兮支付';
                        $userFinance->save(); //存储用户充值数据

                        $promotionService = new PromotionService();
                        $promotionService->rewards($order->user_id, $order->money, 1); //调用推广处理函数
                    }
                }
            }
            return 'success';
        }
    }

    public function index()
    {
        $mch_id = trim(config('extra_config.payment.pay.mchid'));//这里改成支付ID
        $mch_key = trim(config('extra_config.payment.pay.appkey')); //这是您的通讯密钥
        $data = file_get_contents("php://input");
//        print_r(request());
        if (is_string($data)) $data = json_decode($data,true);
        if (empty($data))
            return "DATA ERROR";
        if (
            !isset($data['orderno']) ||
            !isset($data['status']) ||
            !isset($data['money']) ||
            !isset($data['merorderno']) ||
            !isset($data['time']) ||
            !isset($data['attach']) ||
            !isset($data['payed_time']) ||
            !isset($data['sign'])
        )
            return "DATA FALSE";
        $sign = md5($mch_id.$data['orderno'].$data['money'].$data['merorderno'].$data['time'].$mch_key);
        if (intval($data['status']) === 0 )
            return "FAIL";
        if ($sign != $data['sign'])
            return "SIGN FAIL";

        $order = UserOrder::find(str_replace('xwx_order_', '', $data['merorderno'])); //通过返回的订单id查询数据库
        if (!$order->isEmpty() && intval($order->status) === 0) {
            $status = 1;
            $order->money = ($data['money']/100);
            $order->update_time = $data['time']; //云端处理订单时间戳
            $order->order_id = $data['orderno'];
            $order->status = $status;
            $order->save(); //更新订单
            if ($order->order_type == 1){
                $userFinance = new UserFinance();
                $userFinance->user_id = $order->user_id;
                $userFinance->money = $order->wallet;
                $userFinance->usage = 6; //用户充值
                $userFinance->summary = '汇付支付，vip充值天数';
                $userFinance->save(); //存储用户充值数据
                $user = User::find($order->user_id);
                $user->vip_expire_time = strtotime('+'.$order->wallet.' days');
                $user->save();
                session('xwx_vip_expire_time', $user->vip_expire_time);
            }elseif ($order->order_type == 2){
                $userFinance = new UserFinance();
                $userFinance->user_id = $order->user_id;
                $userFinance->money = $order->wallet;
                $userFinance->usage = 1; //用户充值
                $userFinance->summary = '汇付支付,金币充值';
                $userFinance->save(); //存储用户充值数据
            }
            $promotionService = new PromotionService();
            $promotionService->rewards($order->user_id, $order->money, 1); //调用推广处理函数
        }
        return 'SUCCESS';
    }
}