<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SellerService;
use App\Services\ShopService;
use App\Services\ProductService;
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
     * @var \App\Services\ProductService $productService
     */
    protected $productService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SellerService $sellerService, ShopService $shopService, ProductService $productService)
    {
        $this->sellerService = $sellerService;
        $this->shopService = $shopService;
        $this->productService = $productService;
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
        $coupon_id = $this->sellerService->addCoupon(4, $request->all());
        return response()->json(['message' => 'Success', 'coupon_id' => $coupon_id], 201);
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
        return response()->json(['message' => 'Success'], 201);
    }

    public function getProducts(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $result = $this->productService->getItems(4);
        return response()->json($result);
    }

    public function addProduct(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $this->sellerService->addProduct(4, $request->all());
        return response()->json(['message' => 'Success']);
    }

    public function deleteProduct(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $this->sellerService->deleteProduct($request->input('id'));
        return response()->json(['message' => 'Success']);
    }

    public function updateProduct(Request $request)
    {
        // $user = auth()->userOrFail();
        // $id = $user->id;
        $this->sellerService->updateProduct(4, $request->all());
        return response()->json(['message' => 'Success']);
    }
}
