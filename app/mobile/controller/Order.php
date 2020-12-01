<?php


namespace app\mobile\controller;


use app\model\UserOrder;

class Order extends Base
{
    protected $bookService;
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->bookService = app('bookService');
    }

    public function find()
    {
        $order_id = input('order_id');
        $dao = UserOrder::where('id',$order_id)->where('user_id',$this->uid)->find();
        if (empty($dao)){
            return json(['err' => 1, 'msg' => '失败']);
        }else{
            return json(['err' => 0, 'msg' => '成功']);
        }
    }

}