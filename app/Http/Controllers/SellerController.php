<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SellerService;
use App\Services\ShopService;
use Exception;

class SellerController extends Controller
{
    /**
     * @var \App\Services\SellerService $sellerService
     */
    protected $sellerService;

    /**
     * @var \App\Services\ShopService $shopService
     */
    protected $shopService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SellerService $sellerService, ShopService $shopService)
    {
        $this->sellerService = $sellerService;
        $this->shopService = $shopService;
    }

    protected function checkAuth()
    {

    }

    public function getCoupons(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $result = $this->shopService->getCoupons(4, true);
        return response()->json($result);
    }

    public function addCoupon(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $this->sellerService->addCoupon(4, $request->all());
        return response()->json(['message' => 'Success']);
    }

    public function deleteCoupon(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $this->sellerService->deleteCoupon($request->input('code'));
        return response()->json(['message' => 'Success']);
    }

    public function updateCoupon(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $this->sellerService->updateCoupon($request->all());
        return response()->json(['message' => 'Success']);
    }
}
