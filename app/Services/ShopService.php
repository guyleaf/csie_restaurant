<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ShopRepository;
use App\Repositories\CouponRepository;
use App\Services\ProductService;
use DateTime, DateTimeZone;

class ShopService
{
    /**
     * @var \App\Repositories\ShopRepository $shopRepository
     */
    protected $shopRepository;

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
     * @param \App\Repositories\ShopRepository $shopRepository
     * @param \App\Repositories\CouponRepository $couponRepository
     */
    public function __construct(ShopRepository $shopRepository, CouponRepository $couponRepository, ProductService $productService)
    {
        $this->shopRepository = $shopRepository;
        $this->couponRepository = $couponRepository;
        $this->productService = $productService;
    }

    public function getShopInfo($id)
    {
        $result = $this->shopRepository
        ->getShopInfoByShopId($id);
        return $result;
    }

    public function getProductCategories($id)
    {
        $result = $this->shopRepository
        ->getProductCategoriesByShopId($id);
        return $result;
    }

    public function getCoupons($id, $include_expired=false)
    {
        $result = $this->couponRepository
        ->getCouponsBymemberId($id);

        if (!$include_expired)
        {
            $origin = new DateTime('now', new DateTimeZone('Asia/Taipei'));
            $filtered = $result->reject(function ($value, $key) use ($origin) {
                $start_time = new DateTime($value->start_time,  new DateTimeZone('Asia/Taipei'));
                $end_time = new DateTime($value->end_time,  new DateTimeZone('Asia/Taipei'));
                return $origin->diff($start_time)->format("%s") > 0 && $end_time->diff($origin)->format("%s") > 0;
            });

            $result = $filtered->all();
        }

        if (!empty($result))
        {
            $result = $result->toArray();
            foreach ($result as $key => $value) {
                if ($value->type === 2)
                {
                    $coupon_items = $this->couponRepository->getCouponItems($value->id);
                    $coupon_items = $coupon_items->map(function ($item, $key)
                    {
                        $product = $this->productService->getProductInfo($item->product_id);
                        $item->name = $product->first()->name;
                        return $item;
                    });

                    $result[$key] = [
                        'coupon' => $value,
                        'coupon_items' => $coupon_items,
                    ];
                }
            }
        }

        return $result;
    }

    public function checkCoupon($coupon_code, $seller_id)
    {
        $result = $this->couponRepository
        ->getCouponBycouponCode($coupon_code);
        
        if ($result->isEmpty())
            return 1;

        $result = $result->where('member_id', $seller_id);

        if ($result->isEmpty())
            return 2;
        
        return 0;
    }
}
?>