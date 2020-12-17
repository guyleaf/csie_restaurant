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
     * @var \Illuminate\Database\Query\Builder $historyOrderView
     */
    protected $historyOrderView;

    /**
     * Member Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->orderItemTable = DB::table('order_item');
        $this->historyOrderView = DB::table('history_order_view');
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
        $items = $this->orderItemTable
            ->join('product as P', 'P.id', '=', 'product_id')
            ->where('order_id', '=', $id)
            ->get(['name', 'price', 'quantity']);

        return $items;
    }

    public function getOrderByCustomerId($id)
    {
        $order = $this->historyOrderView
            ->where('customer_id', '=', $id)
            ->get();

        return $order;
    }
}
?>
