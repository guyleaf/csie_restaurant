<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\OrderService;
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

    public function __construct(CustomerRepository $customerRepository, OrderService $orderService)
    {
        $this->customerRepository = $customerRepository;
        $this->orderService = $orderService;
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
}
?>
