<?php


namespace app\service\Impls;



use app\model\UserOrder;
use app\service\IUserOrderService;

class UserOrderService implements IUserOrderService
{
    protected $model;
    public function __construct()
    {
        $this->model = new UserOrder();
    }

    public function stored($request)
    {

    }

}