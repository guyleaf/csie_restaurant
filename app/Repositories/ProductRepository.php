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
        $items = $this->productTable
            ->join('seller as S', 'seller_id', '=', 'S.member_id')
            ->where('S.member_id','=', $id)
            ->distinct()
            ->get(['id', 'name', 'price', 'product.description', 'category_name']);

        return $items;
    }

    public function getProductInfo($product_id)
    {
        $items = $this->productTable
            ->where('id','=', $product_id)
            ->get(['*']);

        return $items;
    }
}
?>
