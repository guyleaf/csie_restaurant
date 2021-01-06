<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use DateTime, DateTimeZone;

class ProductRepository
{
    /**
     * @var \Illuminate\Database\Query\Builder $productTable
     */

    protected $productTable;

    /**
     * @var \Illuminate\Database\Query\Builder $productImageTable
     */

    protected $productImageTable;

    /**
     * Shop Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->productTable = DB::table('product', 'P');
        $this->productImageTable = DB::table('product_image', 'PI');
    }

    public function getShopItemsByShopId($id)
    {
        $items = $this->productTable
            ->join('seller as S', 'seller_id', '=', 'S.member_id')
            ->join('product_image as PI', 'PI.id', '=', 'P.id')
            ->where('S.member_id','=', $id)
            ->where('is_deleted', '=', false)
            ->distinct()
            ->get(['P.id', 'name', 'price', 'P.description', 'category_name','sold_out','status', 'PI.image_path']);

        return $items;
    }

    public function getProductInfo($product_id)
    {
        $this->productTable = DB::table('product');
        $items = $this->productTable
            ->where('id', '=', $product_id)
            ->get(['*']);

        return $items;
    }

    public function addProduct($seller_id, $payload, $image_extension)
    {
        $payload['seller_id'] = $seller_id;
        $payload['category_id'] = $seller_id;
        $payload['publish_time'] = new DateTime('now', new DateTimeZone('Asia/Taipei'));
        $payload['publish_time'] = $payload['publish_time']->format('Y-m-d H:i:s');
        $payload['modified_time'] = $payload['publish_time'];
        $id = $this->productTable
        ->insertGetId($payload);

        $this->productImageTable
        ->insert([
            'image_path' => 'public/restaurant/' . strval($seller_id) . strval($id) . '.' . $image_extension,
            'id' => $id
        ]);

        return $id;
    }

    public function deleteProduct($id)
    {
        $now = new DateTime('now', new DateTimeZone('Asia/Taipei'));
        $this->productTable
        ->where('id', '=', $id)
        ->update(['is_deleted' => true, 'modified_time' => $now->format('Y-m-d H:i:s')]);
    }

    public function updateProduct($payload)
    {
        $now = new DateTime('now', new DateTimeZone('Asia/Taipei'));
        $payload['modified_time'] = $now->format('Y-m-d H:i:s');

        $this->productTable
        ->where('id', '=', $payload['id'])
        ->update($payload);
    }
}
?>
