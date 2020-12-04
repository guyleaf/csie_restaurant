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
}
?>
