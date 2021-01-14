<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SellerService;
use App\Services\ShopService;
use App\Services\OrderService;
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

    public function getCoupons(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $result = $this->shopService->getCoupons($id, true);
        return response()->json($result);
    }

    public function addCoupon(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $coupon_id = $this->sellerService->addCoupon($id, $request->all());
        return response()->json(['message' => 'Success', 'coupon_id' => $coupon_id], 201);
    }

    public function deleteCoupon(Request $request)
    {
        $this->sellerService->deleteCoupon($request->input('coupon.id'));
        return response()->json(['message' => 'Success']);
    }

    public function updateCoupon(Request $request)
    {
        $this->sellerService->updateCoupon($request->all());
        return response()->json(['message' => 'Success'], 201);
    }

    public function getOrders(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $result = $this->sellerService->getOrders($id);
        return response()->json($result);
    }

    public function getOrderInfo(Request $request, $orderId)
    {
        $user = auth()->user();
        $id = $user->id;
        $result = $this->sellerService->getOrderInfo($orderId);
        return response()->json($result);
    }
    
    public function updateOrder(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $this->sellerService->updateOrder($id, $request->all());
        return response()->json(['message' => 'Success'], 201);
    }
    
    public function getProducts(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $result = $this->sellerService->getProducts($id);
        return response()->json($result);
    }

    public function addProduct(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $product = $this->sellerService->addProduct($id, $request->all());
        return response()->json(['message' => 'Success', 'product_id' => $product['product_id'], 'image_path' => $product['image_path']], 201);
    }

    public function deleteProduct(Request $request)
    {
        $this->sellerService->deleteProduct($request->input('id'));
        return response()->json(['message' => 'Success']);
    }

    public function updateProduct(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $this->sellerService->updateProduct($id, $request->all());
        return response()->json(['message' => 'Success'], 201);
    }

    public function addProductCategory(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $this->sellerService->addProductCategory($id, $request->all());
        return response()->json(['message' => 'Success'], 201);
    }

    public function deleteProductCategory(Request $request)
    {
        $this->sellerService->deleteProductCategory($request->input('id'));
        return response()->json(['message' => 'Success']);
    }

    public function updateProductCategory(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $this->sellerService->updateProductCategory($id, $request->all());
        return response()->json(['message' => 'Success'], 201);
    }
}
