<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OrderRepository
{

    /**
     * @var \Illuminate\Database\Query\Builder $order
     */
    protected $order;

    /**
     * @var \Illuminate\Database\Query\Builder $product_image
     */
    protected $product_image;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->order = DB::table('order', 'O');
        $this->product_image = DB::table('product_image', 'PI');
    }

    /**
     * Get Orders by customer id
     *
     * @param integer $id
     * @return \Illuminate\Support\Collection
     */
    public function getOrders($id)
    {
        $order = $this->order
            ->join('seller as S', 'S.member_id', '=', 'O.seller_id')
            ->join('member as M', 'S.member_id','=','M.id')
            ->where('O.customer_id', '=', $id)
            ->get(['O.id as order_id', 'M.name as seller_name', 'M.id as seller_id', 'O.status', 'O.order_time', 'O.stars']);

        return $order;
    }

    /**
     * Get Order Info
     *
     * @param integer $id
     * @param integer $orderId
     * @return \Illuminate\Support\Collection
     */
    public function getOrderInfo($id, $orderId)
    {
        $order = $this->order
            ->leftjoin('coupon as CP', 'CP.id', '=', 'O.coupon_id')
            ->where('O.id', '=', $orderId)
            ->where('O.customer_id', '=', $id)
            ->get(['O.ship_time', 'O.payment_method', 'O.address',
            'O.fee', 'O.taking_method', 'O.stars', 'O.rating_time', 'O.comment',
            'CP.id as coupon_id', 'CP.type as coupon_type', 'CP.discount', 'CP.limit_money']);

        $items = $this->order
            ->join('order_item as I', 'I.order_id', '=', 'O.id')
            ->join('product as P', 'P.id', '=', 'I.product_id')
            ->leftjoin('product_image as PI', function ($join) {
                $join->on('P.id', '=', 'PI.id')
                     ->limit(1);
            })
            ->where('O.id', '=', $orderId)
            ->where('O.customer_id', '=', $id)
            ->get(['P.id as product_id', 'PI.image_path', 'P.name as product_name', 'I.quantity', 'I.price', 'I.note']);

        return collect(['order' => $order[0], 'order_items' => $items]);
    }
}
?>
