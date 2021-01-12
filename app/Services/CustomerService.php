<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\OrderService;
use App\Services\ShopService;
use App\Repositories\CustomerRepository;

class CustomerService
{
    /**
     * @var \App\Repositories\CustomerRepository $customerRepository
     */
    protected $customerRepository;

    /**
     * @var App\Services\OrderService $orderService
     */
    protected $orderService;

    /**
     * @var App\Services\ShopService $shopService
     */
    protected $shopService;

    protected function isApplicable($coupon, $order)
    {
        if ($coupon['coupon']->type === 0)
            return $coupon['coupon']->limit_money <= $order['total_price'];
        else if ($coupon['coupon']->type === 1)
            return $coupon['coupon']->limit_money <= $order['total_price'];
        else if ($coupon['coupon']->type === 2)
        {
            $orderItems = collect(json_decode($order['orderItems'], true));
            $coupon_items = $coupon['coupon_items'];

            $tmp = $coupon_items->every(function ($value, $key) use ($order, $orderItems){
                $product_id = $value->product_id;
                $quantity = $value->quantity;
                return $orderItems->contains(function ($value, $key) use ($product_id, $quantity) {
                    return $value['id'] == $product_id &&
                    $value['quantity'] >= $quantity;
                });
            });
            return $tmp;
        }
    }

    public function __construct(CustomerRepository $customerRepository, OrderService $orderService, ShopService $shopService)
    {
        $this->customerRepository = $customerRepository;
        $this->orderService = $orderService;
        $this->shopService = $shopService;
    }

    public function getOrders($id)
    {
        $result = $this->orderService
        ->getOrders($id);
        return $result;
    }

    public function getOrderInfo($orderId)
    {
        $result = $this->orderService
        ->getOrderInfo($orderId);
        return $result;
    }

    public function getAddress($customerId)
    {
        $result = $this->customerRepository
        ->getAddress($customerId);
        return $result;
    }

    public function getCreditCard($customerId)
    {
        $result = $this->customerRepository
        ->getCreditCard($customerId);
        return $result;
    }

    public function addAddress($customerId, $payload)
    {
        $this->customerRepository
        ->addAddress($customerId, $payload);
    }

    public function addCreditCard($customerId, $payload)
    {
        $this->customerRepository
        ->addCreditCard($customerId, $payload);
    }

    public function useCoupon($id, $coupon_code, $seller_id, $order)
    {
        $coupon = $this->shopService->useCoupon($coupon_code, $seller_id);

        if (gettype($coupon) != "array")
            return $coupon;

        $numberOfUsage = $this->customerRepository->countUsageNumberOfUsedCoupon($id, $coupon_code);

        if ($coupon['coupon']->numberOfUsage - $numberOfUsage === 0)
            return 5;

        if (!$this->isApplicable($coupon, $order))
            return 1;

        return $coupon;
    }
}
?>
