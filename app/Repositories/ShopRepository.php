<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ShopRepository
{
    /**
     * @var \Illuminate\Database\Query\Builder $shopTable
     */
    protected $shopTable;

    /**
     * @var \Illuminate\Database\Query\Builder $shopsInfoView
     *
     * Columns: member_id, name, header_image, category_id, numberOfRatings, averageOfRatings
     */
    protected $shopsInfoView;

    /**
     * Shop Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->shopTable = DB::table('seller');
        $this->shopsInfoView = DB::table('seller_card_view');
    }

    /**
     * Get shops
     *
     * @param integer $currentNumber
     * @param integer $requiredNumber
     * @return \Illuminate\Support\Collection
     */
    public function getShops($currentNumber, $requiredNumber)
    {
        $shops = $this->shopsInfoView
            ->skip($currentNumber)
            ->take($requiredNumber)
            ->get();

        return $shops;
    }

    /**
     * Get shops by filters
     *
     * @param integer $currentNumber
     * @param integer $requiredNumber
     * @param array:id $filters
     * @return \Illuminate\Support\Collection
     */
    public function getShopsByfilters($currentNumber, $requiredNumber, $filters)
    {
        $shops = $this->shopsInfoView
            ->whereIn('category_id', $filters)
            ->skip($currentNumber)
            ->take($requiredNumber)
            ->get();

        return $shops;
    }
}
?>
