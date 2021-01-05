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
        $result = $this->coupon_items
        ->where('SCP.coupon_id', '=', $id)
        ->get(['coupon_id', 'product_id', 'quantity']);

        return $result;
    }

    public function getCoupons($member_id)
    {
        $result = $this->coupon
        ->where('member_id', '=', $member_id)
        ->get(['id', 'code', 'start_time', 'end_time', 'type', 'discount', 'limit_money']);

        return $result;
    }
}
?>
