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

    public function addOrder(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $this->orderService->addOrder($id, $request->input());
    }
}
