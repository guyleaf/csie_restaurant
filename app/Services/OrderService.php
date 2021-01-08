<?php
namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\CouponRepository;

use function PHPUnit\Framework\isEmpty;

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
}
?>
