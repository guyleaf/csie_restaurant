<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CustomerRepository
{

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
        $this->order = DB::table('order', 'O');
    }

    public function getOrderByCustomerId($id)
    {
        $order = $this->order
            ->join('member as M', 'O.seller_id','=','M.id')
            ->where('O.customer_id', '=', $id)
            ->get(['O.id as order_id', 'M.name', 'O.order_time', 'O.stars']);

        return $order;
    }
}
?>
