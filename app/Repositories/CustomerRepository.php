<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CustomerRepository
{

    /**
     * @var \Illuminate\Database\Query\Builder $customer
     */
    protected $customer;

    /**
     * @var \Illuminate\Database\Query\Builder $coupon
     */
    protected $usedCoupon;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->customer = DB::table('customer', 'C');
        $this->customerAddress = DB::table('customer_address', 'CA');
        $this->usedCoupon = DB::table('used_coupon', 'UC');
    }

    // public function getUsedCoupons($id, $coupon_code)
    // {
    //     $result = DB::table('used_coupon', 'UC')
    //     ->join('coupon as CP', 'CP.id', '=', 'UC.coupon_id')
    //     ->where('UC.customer_id', '=', $id)
    //     ->where('CP.code', '=', $coupon_code)
    //     ->get(['*']);

    //     return $result;
    // }

    public function countUsageNumberOfUsedCoupon($id, $coupon_code)
    {
        $result = $this->usedCoupon
        ->join('coupon as CP', 'CP.id', '=', 'UC.coupon_id')
        ->where('CP.code', '=', $coupon_code)
        ->count();

        return $result;
    }

    public function getAddress($id)
    {
        $result = $this->customerAddress
        ->where("customer_id", '=', $id)
        ->get(["address"]);

        return $result;
    }
}
?>
