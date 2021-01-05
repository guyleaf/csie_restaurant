<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ShopRepository;
use App\Repositories\CouponRepository;
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
     * Shop service constructor
     *
     * @param \App\Repositories\ShopRepository $shopRepository
     */
    public function __construct(ShopRepository $shopRepository, CouponRepository $couponRepository)
    {
        $this->shopRepository = $shopRepository;
        $this->couponRepository = $couponRepository;
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
        ->getCoupons($id);

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
                    $result[$key] = [
                        'coupon' => $value,
                        'coupon_items' => $this->couponRepository->getCouponItems($value->id)
                    ];

                    echo $this->couponRepository->getCouponItems($value->id)->toJson();
                }
            }
        }

        return $result;
    }
}
?>
