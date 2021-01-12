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
     * @var \Illuminate\Database\Query\Builder $usedCoupon
     */
    protected $usedCoupon;

    /**
     * @var \Illuminate\Database\Query\Builder $customerAddress
     */
    protected $customerAddress;

    /**
     * @var \Illuminate\Database\Query\Builder $customerCreditCard
     */
    protected $creditCard;

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
        $this->creditCard = DB::table('credit_card', 'CC');
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

    public function getCreditCard($id)
    {
        $result = $this->creditCard
        ->where('customer_id', '=', $id)
        ->get(['credit_card', 'expire_date']);
        return $result;
    }
}
?>
