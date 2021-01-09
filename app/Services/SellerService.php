<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CouponRepository;
use App\Repositories\ProductRepository;

class SellerService
{
    /**
     * @var \App\Repositories\CouponRepository $couponRepository
     */
    protected $couponRepository;

    /**
     * @var \App\Repositories\ProductRepository $productRepository
     */
    protected $productRepository;

    /**
     * Shop service constructor
     *
     * @param \App\Repositories\CouponRepository $couponRepository
     * @param \App\Repositories\ProductRepository $productRepository
     */
    public function __construct(CouponRepository $couponRepository, ProductRepository $productRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->productRepository = $productRepository;
    }

    public function addCoupon($seller_id, $payload)
    {
        $coupon_id = $this->couponRepository->addCoupon($seller_id, $payload);

        return $coupon_id;
    }

    public function deleteCoupon($code)
    {
        $this->couponRepository->deleteCoupon($code);
    }

    public function updateCoupon($payload)
    {
        $this->couponRepository->updateCoupon($payload);
    }

    public function addProduct($seller_id, $payload)
    {
        $image = $payload['image'];
        unset($payload['image']);
        $image_extension = $image->getClientOriginalExtension();

        $product_id = $this->productRepository->addProduct($seller_id, $payload, $image_extension);

        $image_path = 'public/restaurant/' . strval($seller_id);
        $image_name = strval($product_id) . '.' . $image_extension;

        $image->storeAs($image_path, $image_name);

        $image_path = '/storage/restaurant/' . strval($seller_id);
        return ['product_id' => $product_id, 'image_path' => $image_path . '/' . $image_name];
    }

    public function deleteProduct($id)
    {
        $this->productRepository->deleteProduct($id);
    }

    public function updateProduct($seller_id, $payload)
    {
        $this->productRepository->updateProduct($payload);

        if (!empty($payload['image']))
        {
            $image = $payload['image'];
            unset($payload['image']);
            $image_extension = $image->getClientOriginalExtension();

            $product_id = $payload['id'];
            $image->storeAs('public/restaurant/' . strval($seller_id), strval($product_id) . '.' . $image_extension);
        }
    }
}
?>
