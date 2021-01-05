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

    public function getOrderInfo($id, $orderId)
    {
        $result = $this->orderService
        ->getOrderInfo($id, $orderId);
        return $result;
    }

    public function checkCoupon($id, $coupon_code, $seller_id)
    {
        $code = $this->customerRepository->getUsedCoupon($id, $coupon_code);
        
        if ($code->isNotEmpty())
            return 3;

        $code = $this->shopService->checkCoupon($coupon_code, $seller_id);

        return $code;
    }
}
?>
