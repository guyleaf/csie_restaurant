<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CustomerRepository;

class CustomerService
{
    /**
     * @var \App\Repositories\CustomerRepository $customerRepository
     */
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getOrders($id)
    {
        $result = $this->customerRepository
        ->getOrderByCustomerId($id);
        return $result;
    }

    public function getOrderItem($id)
    {
        $result = $this->customerRepository
        ->getOrderItemsByOrderId($id);
        return $result;
    }
}
?>
