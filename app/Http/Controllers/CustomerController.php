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
            $user = auth()->user();
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
            $user = auth()->user();
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

    public function useCoupon(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $result = $this->customerService
        ->useCoupon($id, $request->input('coupon_code'), $request->input('seller_id'), $request->except(['coupon_code', 'seller_id']));

        if (gettype($result) != 'array')
        {
            $code = $result;
            if ($code == 5)
                return response()->json(['message' => 'Coupon usage limit has been reached.'], 403);
            else if ($code == 4)
                return response()->json(['message' => 'Unknown coupon.'], 403);
            else if ($code == 3)
                return response()->json(['message' => 'Expired coupon.'], 403);
            else if ($code == 2)
                return response()->json(['message' => 'This coupon is not for this seller.'], 403);
            else if ($code == 1)
                return response()->json(['message' => 'You are not applicable to use this coupon.'], 403);
        }
        else
            return response()->json(['message' => 'You can use this coupon.', 'coupon' => $result], 200);
    }
}
