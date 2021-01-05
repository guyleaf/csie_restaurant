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
            // $user = auth()->userOrFail();
            // $id = $user->id;
            $result = $this->customerService->getOrders(8);
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
            // $user = auth()->userOrFail();
            // $id = $user->id;
            $result = $this->customerService->getOrderInfo(8, $orderId);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json($result);
    }

    public function checkCoupon(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $code = $this->customerService->checkCoupon(8, $request->query('coupon_code'), $request->query('seller_id'));

        if ($code == 3)
            return response()->json(['message' => 'You have used this coupon before'], 403);
        else if ($code == 2)
            return response()->json(['message' => 'This coupon is not for this seller'], 403);
        else if ($code == 1)
            return response()->json(['message' => 'Unknown coupon'], 403);
        else
            return response()->json(['message' => 'Valid coupon'], 200);
    }
}
