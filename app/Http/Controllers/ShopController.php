<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShopService;

class ShopController extends Controller
{
    /**
     * @var \App\Services\ShopService $shopService
     */
    protected $shopService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    /**
     * Get a part of shops via database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShops(Request $request)
    {
        return $this->shopService->getShops($request);
    }
}
