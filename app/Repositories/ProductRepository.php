<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use DateTime, DateTimeZone, Exception;

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
     * @var \Illuminate\Database\Query\Builder $productCategoryTable
     */

    protected $productCategoryTable;

    /**
     * Shop Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->productTable = DB::table('product', 'P');
        $this->productImageTable = DB::table('product_image', 'PI');
        $this->productCategoryTable = DB::table('product_category', 'PC');
    }

    public function getShopItemsByShopId($id, $include_nonSelling)
    {
        $items = $this->productTable
            ->join('seller as S', 'seller_id', '=', 'S.member_id')
            ->join('product_image as PI', 'PI.id', '=', 'P.id')
            ->where('S.member_id','=', $id)
            ->where('is_deleted', '=', false);

        if (!$include_nonSelling)
            $items = $items
                ->where('status', '=', 1);

        $items = $items
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
        DB::beginTransaction();

        try
        {
            $payload['seller_id'] = $seller_id;
            $payload['category_id'] = $seller_id;
            $payload['publish_time'] = new DateTime('now', new DateTimeZone('Asia/Taipei'));
            $payload['publish_time'] = $payload['publish_time']->format('Y-m-d H:i:s');
            $payload['modified_time'] = $payload['publish_time'];

            $id = $this->productTable
            ->orderByDesc('id')
            ->limit(1)
            ->lockForUpdate()
            ->get(['id'])->first()->id + 1;

            $payload['id'] = $id;

            $this->productTable = DB::table('product');
            $this->productTable
            ->insert($payload);

            $this->productImageTable
            ->insert([
                'image_path' => '/storage/restaurant/' . strval($seller_id) . '/' . strval($id) . '.' . $image_extension,
                'id' => $id
            ]);

            DB::commit();
        }
        catch (Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

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

    public function getProductCategoriesByShopId($seller_id)
    {
        $category = $this->productCategoryTable
            ->where('seller_id','=', $seller_id)
            ->get(['PC.name','display_order']);
        return $category;
    }

    public function addProductCategory($seller_id, $payload)
    {

        $payload['seller_id'] = $seller_id;
        $this->productCategoryTable
        ->insert($payload);
    }

    public function updateProductCategory($seller_id, $payload)
    {
        var_dump($payload);
        DB::transaction(function () use ($seller_id, $payload) {
            if (gettype($payload['old']) != 'array')
            {
                DB::table('product_category', 'PC')
                ->where('seller_id', '=', $seller_id)
                ->where('name', '=', $payload['old']['name'])
                ->update($payload['new']);
            }
            else
            {
                array_map(function ($old, $new) use ($seller_id) {
                    DB::table('product_category', 'PC')
                    ->where('seller_id', '=', $seller_id)
                    ->where('name', '=', $old['name'])
                    ->update($new['display_order']);                                           
                }, $payload['old'], $payload['new']);
            }
        });
    }

    public function deleteProductCategory($seller_id, $payload)
    {
        $this->productCategoryTable
        ->where('seller_id', '=', $seller_id)
        ->where('name', '=', $payload['name'])
        ->delete();
    }
}
?>
