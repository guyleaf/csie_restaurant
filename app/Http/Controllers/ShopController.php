<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShopService;
use App\Services\SearchService;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ShopService $shopService, SearchService $searchService)
    {
        $this->shopService = $shopService;
        $this->searchService = $searchService;
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

    
    public function getProduct(Request $request, $id)
    {
        try {
            $result = $this->searchService->getProduct();
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json($result);
    }
}
