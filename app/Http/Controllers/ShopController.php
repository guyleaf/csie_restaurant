<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShopService;
use App\Services\SearchService;
use App\Services\ProductService;
use Exception;

class ShopController extends Controller
{
    /**
     * @var \App\Services\ShopService $shopService
     */
    protected $shopService;

    /**
     * @var \App\Services\SearchService $searchService
     */
    protected $searchService;

    /**
     * @var \App\Services\ProductService $productService
     */
    protected $productService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ShopService $shopService, SearchService $searchService, ProductService $productService)
    {
        $this->shopService = $shopService;
        $this->searchService = $searchService;
        $this->productService = $productService;
    }

    /**
     * Get a part of shops via database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShops(Request $request)
    {
        try {
            if ($request->exists('filters'))
                $result = $this->searchService->getShopsByfilters($request->except('filters'), $request->query('filters'));
            else
                $result = $this->searchService->getShops($request->query());
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json($result);
    }

    public function getCategories(Request $request)
    {
        try {
            $result = $this->searchService->getCategories();
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json($result);
    }

    public function getItems(Request $request, $id)
    {
        try {
            $result = $this->productService->getItems($id);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }
        return response()->json($result);
    }

    public function getShopInfo(Request $request, $id)
    {
        try {
            $result = $this->shopService->getShopInfo($id);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }
        return response()->json($result);
    }

    public function getProductCategories(Request $request, $id)
    {
        try {
            $result = $this->shopService->getProductCategories($id);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }
        return response()->json($result);
    }

    public function getCoupons(Request $request, $id)
    {
        $include_expired = false;
        if ($request->exists('include_expired'))
            $include_expired = (int)$request->query('include_expired');

        $result = $this->shopService->getCoupons($id, $include_expired);
        return response()->json($result);
    }

    public function searchShops(Request $request)
    {
        $keywords = $request->query('keywords');
        $result = $this->searchService
        ->searchShops($keywords);

        return $result;
    }
}
