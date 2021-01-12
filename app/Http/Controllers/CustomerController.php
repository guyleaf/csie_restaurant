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
            $result = $this->customerService->getOrderInfo($orderId);
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
                return response()->json(['message' => '優惠券使用次數到達上限'], 403);
            else if ($code == 4)
                return response()->json(['message' => '無效的優惠券'], 403);
            else if ($code == 3)
                return response()->json(['message' => '優惠券已過期'], 403);
            else if ($code == 2)
                return response()->json(['message' => '優惠券不適用於此店家'], 403);
            else if ($code == 1)
                return response()->json(['message' => '未滿足優惠券之條件'], 403);
        }
        else
            return response()->json(['message' => '恭喜! 優惠券可以使用', 'coupon' => $result], 200);
    }

    public function getAddress(Request $request)
    {
        try {
            $user = auth()->user();
            $id = $user->id;
            $result = $this->customerService->getAddress($id);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }
        return response()->json($result);
    }

    public function addAddress(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $this->customerService->addAddress($id, $request->all());
        return response()->json(['message' => 'success'], 201);
    }

    public function addCreditCard(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $this->customerService->addCreditCard($id, $request->all());
        return response()->json(['message' => 'success'], 201);
    }

    public function getCreditCard(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $result = $this->customerService->getCreditCard($id);
        return response()->json($result);
    }
}
