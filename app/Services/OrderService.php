<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\OrderRepository;

class OrderService
{
    /**
     * @var \App\Repositories\OrderRepository $orderRepository
     */
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrderItems($id)
    {
        $result = $this->orderRepository
        ->getOrderItemsByOrderId($id);
        return $result;
    }
}
?>
