<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MemberSeeder;
use Database\Seeders\CustomerAddressSeeder;
use Database\Seeders\SellerCategorySeeder;
use Database\Seeders\SellerCategoryListSeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CouponSeeder;
use Database\Seeders\SpecifiedCouponProductSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OrderItemSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $member_path = base_path('database/seeders/data/member.json');
        $customer_path = base_path('database/seeders/data/customer.json');
        $seller_path = base_path('database/seeders/data/seller.json');
        $customer_address_path = base_path('database/seeders/data/customer_address.json');
        $seller_category_path = base_path('database/seeders/data/seller_category.json');
        $seller_category_list_path = base_path('database/seeders/data/seller_category_list.json');
        $product_category_path = base_path('database/seeders/data/product_category.json');
        $product_path = base_path('database/seeders/data/product.json');
        $coupon_path = base_path('database/seeders/data/coupon.json');
        $specified_coupon_product_path = base_path('database/seeders/data/specified_coupon_product.json');
        $order_path = base_path('database/seeders/data/order.json');
        $order_item_path = base_path('database/seeders/data/order_item.json');

        $this->call(MemberSeeder::class, false,
        ['member_path' => $member_path, 'customer_path' => $customer_path, 'seller_path' => $seller_path]);
        $this->call(CustomerAddressSeeder::class, false, ['customer_address_path' => $customer_address_path]);
        $this->call(SellerCategorySeeder::class, false, ['seller_category_path' => $seller_category_path]);
        $this->call(SellerCategoryListSeeder::class, false, ['seller_category_list_path' => $seller_category_list_path]);
        $this->call(ProductCategorySeeder::class, false, ['product_category_path' => $product_category_path]);
        $this->call(ProductSeeder::class, false, ['product_path' => $product_path]);
        $this->call(CouponSeeder::class, false, ['coupon_path' => $coupon_path]);
        $this->call(SpecifiedCouponProductSeeder::class, false, ['specified_coupon_product_path' => $specified_coupon_product_path]);
        $this->call(OrderSeeder::class, false, ['order_path' => $order_path]);
        $this->call(OrderItemSeeder::class, false, ['order_item_path' => $order_item_path]);
    }
}
