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

    $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->post('', 'AuthController@me');
    });
});

$router->group(['prefix' => 'restaurants'], function () use ($router) {
    $router->get('', 'ShopController@getShops');
    $router->get('category', 'ShopController@getCategories');
    $router->get('{id}/products', 'ShopController@getItems');
    $router->get('{id}/category', 'ShopController@getProductCategories');
    $router->get('{id}/Info', 'ShopController@getShopInfo');
    $router->get('{id}/coupons', 'ShopController@getCoupons');
    $router->get('search', 'ShopController@searchShops');
});

$router->group(['prefix' => 'members'], function () use ($router) {
    $router->get('', 'MemberController@getMembers');
    $router->post('/update', 'MemberController@updateMember');
});

$router->group(['prefix' => 'customer'], function () use ($router) {
    $router->group(['middleware' => 'jwt.customer'], function () use ($router) {
        $router->get('orders', 'CustomerController@getOrders');
        $router->get('orders/{orderId}', 'CustomerController@getOrderInfo');
        $router->post('coupon/use', 'CustomerController@useCoupon');
    });
});

// 交易中..
$router->group(['prefix' => 'order'], function () use ($router) {
    $router->post('', 'OrderController@addOrder');
    $router->get('event', 'OrderController@listenOrder');
    $router->post('update', 'OrderController@updateOrder');
});

$router->group(['prefix' => 'seller', 'middleware' => 'jwt.seller'], function () use ($router) {
    $router->get('coupons', 'SellerController@getCoupons');
    $router->post('coupons/add', 'SellerController@addCoupon');
    $router->post('coupons/delete', 'SellerController@deleteCoupon');
    $router->post('coupons/update', 'SellerController@updateCoupon');
    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('', 'SellerController@getProducts');
        $router->post('add', 'SellerController@addProduct');
        $router->post('delete', 'SellerController@deleteProduct');
        $router->post('update', 'SellerController@updateProduct');
    });
});

$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->get('coupons', '');
});

$router->group(['prefix' => 'mall'], function () use ($router) {
    $router->get('coupons', '');
});
?>
