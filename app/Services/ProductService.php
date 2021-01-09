<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProductRepository;

class ProductService
{
    /**
     * @var \App\Repositories\ProductRepository $productRepository
     */
    protected $productRepository;

    /**
     * Shop service constructor
     *
     * @param \App\Repositories\ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getItems($id)
    {
        $result = $this->productRepository
            ->getShopItemsByShopId($id);
        return $result;
    }

    public function getProductInfo($product_id)
    {
        $result = $this->productRepository->getProductInfo($product_id);
        return $result;
    }

    public function getProductCategoriesByShopId($seller_id)
    {
        $result = $this->productRepository->getProductCategoriesByShopId($seller_id);
        return $result;
    }
}
?>
