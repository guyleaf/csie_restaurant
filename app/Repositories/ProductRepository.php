<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * @var \Illuminate\Database\Query\Builder $productTable
     */

    protected $productTable;

    /**
     * Shop Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->productTable = DB::table('product');
    }

    public function getShopItemsByShopId($id)
    {
        $items = $this->$productTable
            ->join('product as P', 'P.seller_id', '=', 'member_id')
            ->whereIn('P.member_id', $id)
            ->distinct()
            ->get(['id', 'name', 'price', 'description']);

        return $items;
    }
}
?>
