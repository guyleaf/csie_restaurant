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
     * @var \Illuminate\Database\Query\Builder $shopsCardView
     *
     * Columns: member_id, name, header_image, category_id, numberOfRatings, averageOfRatings
     */
    protected $shopsCardView;

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
        $this->shopTable = DB::table('seller', 'S');
        $this->categoryTable = DB::table('seller_category', 'SC');
        $this->shopsCardView = DB::table('seller_card_view', 'SCV');
        $this->shopsInfoView = DB::table('seller_info_view', 'SIV');
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
        $shops = $this->shopsCardView
            ->join('member as M', 'M.id', '=', 'member_id')
            ->where('is_deleted', '=', false)
            ->skip($currentNumber)
            ->take($requiredNumber)
            ->get(['member_id as seller_id', 'M.name', 'counter_number', 'header_image', 'numberofratings', 'averageofratings']);

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
        $shops = $this->shopsCardView
            ->join('seller_category_list as SCL', 'SCL.seller_id', '=', 'member_id')
            ->join('member as M', 'M.id', '=', 'member_id')
            ->where('is_deleted', '=', false)
            ->whereIn('SCL.category_id', $filters)
            ->skip($currentNumber)
            ->take($requiredNumber)
            ->distinct()
            ->get(['member_id as seller_id', 'M.name', 'counter_number', 'header_image', 'numberOfRatings', 'averageOfRatings']);

        return $shops;
    }

    public function getCategories()
    {
        $category = $this->categoryTable
            ->get();

        return $category;
    }

    public function getShopInfoByShopId($id)
    {
        $info = $this->shopsInfoView
            ->join('member as M', 'M.id','=','member_id')
            ->where('member_id','=', $id)
            ->where('is_deleted', '=', false)
            ->distinct()
            ->first(['M.name','M.description', 'numberOfRatings', 'averageOfRatings', 'numberOfFans','M.created_at']);

        return $info;
    }

    public function searchShops($keywords)
    {
        $result = $this->shopsCardView
        ->where(function ($query) use ($keywords) {
            for ($i = 0; $i < count($keywords); $i++){
               $query->orwhere('name', 'like',  '%' . $keywords[$i] .'%');
            }
        })->get(['member_id as seller_id', 'name', 'counter_number', 'header_image', 'averageofratings']);

        return $result;
    }
}
?>
