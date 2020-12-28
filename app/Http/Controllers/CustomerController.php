<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;
use Exception;

class CustomerController extends Controller
{
    /**
     * @var \App\Services\CustomerService $customerService
     */
    protected $customerService;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Get a part of shops via database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrders(Request $request)
    {
        try {
            $user = auth()->userOrFail();
            $id = $user->id;
            $result = $this->customerService->getOrders($id);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json($result);
    }

    public function getOrderInfo(Request $request, $orderId)
    {
        try {
            $user = auth()->userOrFail();
            $id = $user->id;
            $result = $this->customerService->getOrderInfo($id, $orderId);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json($result);
    }
}
