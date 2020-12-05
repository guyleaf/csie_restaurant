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
     * @var \Illuminate\Database\Query\Builder $categoryTable
     */
    protected $categoryTable;

    /**
     * Shop Repository constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->shopTable = DB::table('seller');
        $this->categoryTable = DB::table('seller_category');
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
            ->get(['member_id', 'name', 'counter_number', 'header_image', 'numberofratings', 'averageofratings']);

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
            ->join('seller_category_list as SCL', 'SCL.seller_id', '=', 'member_id')
            ->whereIn('SCL.category_id', $filters)
            ->skip($currentNumber)
            ->take($requiredNumber)
            ->distinct()
            ->get(['member_id', 'name', 'counter_number', 'header_image', 'numberofratings', 'averageofratings']);

        return $shops;
    }

    public function getCategories()
    {
        $category = $this->categoryTable
            ->get();

        return $category;
    }
}
?>
