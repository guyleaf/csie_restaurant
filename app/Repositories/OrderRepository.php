<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OrderRepository
{

    /**
     * @var \Illuminate\Database\Query\Builder $order_item
     */
    protected $order_item;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->order_item = DB::table('order_item');
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
}
?>
