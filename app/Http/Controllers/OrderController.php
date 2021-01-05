<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use Exception;

class OrderController extends Controller
{
    /**
     * @var \App\Services\OrderService $orderService
     */
    protected $orderService;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // public function getOrderItems(Request $request, $id)
    // {
    //     try {
    //         $result = $this->orderService->getOrderItems($id);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => $e->getCode(),
    //             'messages' => unserialize($e->getMessage())
    //         ], $e->getCode());
    //     }

    //     return response()->json($result);
    // }
}
