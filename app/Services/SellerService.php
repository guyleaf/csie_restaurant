<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CouponRepository;
use App\Services\ProductService;

class SellerService
{
    /**
     * @var \App\Repositories\CouponRepository $couponRepository
     */
    protected $couponRepository;

    /**
     * @var \App\Repositories\ProductService $productService
     */
    protected $productService;

    /**
     * Shop service constructor
     *
     * @param \App\Repositories\CouponRepository $couponRepository
     * @param \App\Repositories\ProductService $productService
     */
    public function __construct(CouponRepository $couponRepository, ProductService $productService)
    {
        $this->couponRepository = $couponRepository;
        $this->productService = $productService;
    }

    public function addCoupon($seller_id, $payload)
    {
        $this->couponRepository->addCoupon($seller_id, $payload);
    }

    public function deleteCoupon($code)
    {
        $this->couponRepository->deleteCoupon($code);
    }

    public function updateCoupon($payload)
    {
        $this->couponRepository->updateCoupon($request->all());
    }
}
?>