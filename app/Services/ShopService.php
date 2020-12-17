<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ShopRepository;

class ShopService
{
    /**
     * @var \App\Repositories\ShopRepository $shopRepository
     */
    protected $shopRepository;

    /**
     * Shop service constructor
     *
     * @param \App\Repositories\ShopRepository $shopRepository
     */
    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function getShopInfo($id)
    {
        $result = $this->shopRepository
        ->getShopInfoByShopId();
        return $result;
    }
}
?>
