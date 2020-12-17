<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Services\SearchService;
use App\Services\ProductService;
use Exception;

class ShopController extends Controller
{
    /**
     * @var \App\Services\MemberService $memberService
     */
    protected $memberService;

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
    public function __construct(MemberService $memberService, SearchService $searchService, ProductService $productService)
    {
        $this->memberService = $memberService;
        $this->searchService = $searchService;
        $this->productService = $productService;
    }

    /**
     * Get a part of shops via database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMembers(Request $request)
    {
        try {
            $result = $this->memberService->getMembers($request->query());
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'messages' => unserialize($e->getMessage())
            ], $e->getCode());
        }

        return response()->json($result);
    }
}
