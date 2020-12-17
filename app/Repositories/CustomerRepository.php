<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CustomerRepository
{

    /**
     * @var \Illuminate\Database\Query\Builder $order_item
     */
    protected $order_item;

    /**
     * @var \Illuminate\Database\Query\Builder $order
     */
    protected $order;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->order_item = DB::table('order_item');
        $this->order = DB::table('order');
    }
    /**
     * Get shops
     *
     * @param integer $currentNumber
     * @param integer $requiredNumber
     * @return \Illuminate\Support\Collection
     */
    public function getOrderItemsByOrderId($id)
    {
        $items = $this->order_item
            ->join('product as P', 'P.id', '=', 'product_id')
            ->where('order_id', '=', $id)
            ->get(['name', 'price', 'quantity']);

        return $items;
    }

    public function getOrderByCustomerId($id)
    {
        $order = $this->order
            ->join('order as O', 'member as M', 'O.seller_id','=','M.id')
            ->where('O.customer_id', '=', $id)
            ->get(['O.id as order_id', 'M.name', 'O.order_time', 'O.stars']);
        return $order;
    }
}
?>
