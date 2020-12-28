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
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->coupon_items = DB::table('specified_coupon_product', 'SCP');
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
        ->where('coupon_id', '=', $id)
        ->get(['coupon_id', 'product_id', 'quantity']);

        return $result;
    }
}
?>
