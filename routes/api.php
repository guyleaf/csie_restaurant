<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');

    $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->post('', 'AuthController@me');
    });
});

$router->group(['prefix' => 'restaurants'], function () use ($router) {
    $router->get('', 'ShopController@getShops');
    $router->get('category', 'ShopController@getCategories');
    $router->get('{id}/products', 'ShopController@getProducts');
    $router->get('{id}/category', 'ShopController@getProductCategories');
    $router->get('{id}/Info', 'ShopController@getShopInfo');
    $router->get('{id}/coupons', 'ShopController@getCoupons');
    $router->get('search', 'ShopController@searchShops');
});

$router->group(['prefix' => 'customer'], function () use ($router) {
    $router->group(['middleware' => 'jwt.customer'], function () use ($router) {
        $router->get('orders', 'CustomerController@getOrders');
        $router->get('orders/{orderId}', 'CustomerController@getOrderInfo');
        $router->post('coupon/use', 'CustomerController@useCoupon');
        $router->get('address', 'CustomerController@getAddress');
        $router->get('creditCard', 'CustomerController@getCreditCard');
        $router->post('creditCard', 'CustomerController@addCreditCard');
        $router->post('address', 'CustomerController@addAddress');
    });
});

// 交易中..
$router->group(['prefix' => 'order', 'middleware' => 'jwt.customer'], function () use ($router) {
    $router->post('', 'OrderController@addOrder');
    $router->get('event', 'OrderController@listenOrder');
});

$router->group(['prefix' => 'seller', 'middleware' => 'jwt.seller'], function () use ($router) {
    $router->get('coupons', 'SellerController@getCoupons');
    $router->post('coupons/add', 'SellerController@addCoupon');
    $router->post('coupons/delete', 'SellerController@deleteCoupon');
    $router->post('coupons/update', 'SellerController@updateCoupon');
    $router->get('orders', 'SellerController@getOrders');
    $router->get('orders/{orderId}', 'SellerController@getOrderInfo');
    $router->post('orders/update', 'SellerController@updateOrder');
    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('', 'SellerController@getProducts');
        $router->post('add', 'SellerController@addProduct');
        $router->post('delete', 'SellerController@deleteProduct');
        $router->post('update', 'SellerController@updateProduct');
    });
    $router->group(['prefix' => 'categories'], function () use ($router) {
        $router->post('add', 'SellerController@addProductCategory');
        $router->post('update', 'SellerController@updateProductCategory');
        $router->post('delete', 'SellerController@deleteProductCategory');
    });
});

$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->get('coupons', '');
    $router->get('sellers', 'AdminController@getSellers');
    $router->get('customers', 'AdminController@getCustomers');
    $router->group(['prefix' => 'members'], function () use ($router) {
        $router->post('update', 'AdminController@updateMember');
        $router->post('delete', 'AdminController@deleteMember');
        $router->post('add', 'AdminController@addMember');
    });
});

$router->group(['prefix' => 'mall'], function () use ($router) {
    $router->get('coupons', '');
});
?>
