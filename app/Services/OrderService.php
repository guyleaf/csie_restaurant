<?php
namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\CouponRepository;
use DateTime, DateTimeZone;

class OrderService
{
    /**
     * @var App\Repositories\OrderRepository $orderRepository
     */
    protected $orderRepository;

    /**
     * @var App\Repositories\CouponRepository $couponRepository
     */
    protected $couponRepository;

    public function __construct(OrderRepository $orderRepository, CouponRepository $couponRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->couponRepository = $couponRepository;
    }

    public function getOrders($id)
    {
        $result = $this->orderRepository
        ->getOrders($id);

        return $result;
    }

    public function getOrderInfo($orderId)
    {
        $result = $this->orderRepository
        ->getOrderInfo($orderId);

        if (!empty($result->get('order')->coupon_id) && $result->get('order')->coupon_type == 2)
        {
            $coupon_items = $this->couponRepository
            ->getCouponItems($result->get('order')->coupon_id);
            $result['coupon_items'] = $coupon_items;
        }

        return $result;
    }

    public function updateSellerOrder($id, $payload)
    {
        $result = $this->orderRepository
        ->updateSellerOrder($id, $payload);

        return $result;
    }

    public function addOrder($customer_id, $order)
    {
        $now = new DateTime('now', new DateTimeZone('Asia/Taipei'));
        $order["order"]['order_time'] = $now->format('Y-m-d H:i:s');
        $order["order"]['status'] = 0;
        $this->orderRepository
        ->addOrder($customer_id, $order);
    }
}
?>
