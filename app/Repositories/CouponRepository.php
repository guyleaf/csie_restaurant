<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CouponRepository
{

    /**
     * @var \Illuminate\Database\Query\Builder $coupon_items
     */
    protected $coupon_items;

    /**
     * @var \Illuminate\Database\Query\Builder $coupon
     */
    protected $coupon;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->coupon_items = DB::table('specified_coupon_product', 'SCP');
        $this->coupon = DB::table('coupon', 'CP');
    }

    /**
     * Get Coupon Items
     *
     * @param integer $id
     * @return \Illuminate\Support\Collection
     */
    public function getCouponItems($id)
    {
        $this->coupon_items = DB::table('specified_coupon_product', 'SCP');
        $result = $this->coupon_items
        ->where('SCP.coupon_id', '=', $id)
        ->get(['coupon_id', 'product_id', 'quantity']);

        return $result;
    }

    public function getCouponsBymemberId($member_id)
    {
        $result = $this->coupon
        ->where('member_id', '=', $member_id)
        ->where('is_deleted', '=', false)
        ->get(['id', 'code', 'start_time', 'end_time', 'type', 'discount', 'limit_money']);

        return $result;
    }

    public function getCouponBycouponId($coupon_id)
    {
        $result = $this->coupon
        ->where('id', '=', $coupon_id)
        ->where('is_deleted', '=', false)
        ->get(['id', 'code', 'member_id', 'start_time', 'end_time', 'type', 'discount', 'limit_money']);

        return $result;
    }

    public function getCouponBycouponCode($coupon_code)
    {
        $result = $this->coupon
        ->where('code', '=', $coupon_code)
        ->where('is_deleted', '=', false)
        ->get(['id', 'code', 'member_id', 'start_time', 'end_time', 'type', 'discount', 'limit_money']);

        return $result;
    }

    public function addCoupon($seller_id, $payload)
    {
        $payload['coupon']['member_id'] = $seller_id;
        $id = $this->coupon
        ->insertGetId($payload['coupon']);

        if (!empty($payload['coupon_items']))
        {
            $payload['coupon_items'] = 
            array_map(function ($item) use ($id) {
                $item['coupon_id'] = $id;
                return $item;
            }, $payload['coupon_items']);
            

            $this->coupon_items
            ->insert($payload['coupon_items']);
        }
    }

    public function deleteCoupon($code)
    {
        $this->coupon
        ->where('code', '=', $code)
        ->update(['is_deleted' => true]);
    }

    public function updateCoupon($payload)
    {
        $this->coupon
        ->where('code', '=', $payload['coupon']['code'])
        ->update($payload['coupon']);

        if (!empty($payload['coupon_items']))
        {
            $this->coupon_items
            ->join('coupon as CP', 'CP.id', '=', 'SCP.coupon_id')
            ->where('CP.code', '=', $payload['coupon']['code'])
            ->update($payload['coupon_items']);
        }
    }
}
?>
