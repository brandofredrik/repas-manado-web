<?php

use App\Http\Middlewares\AuthMiddleware;
use App\Http\Middlewares\GuestMiddleware;


/*
|----------------------------------------------------
| Routing sytem                                      |
|----------------------------------------------------
*/

$app->get('/', function($request, $response) {
    return $response->withStatus(303)->withHeader('Location', '/login');
})->setName('redirect');

$app->group('', function() {
    $this->get('/login', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/login', 'AuthController:postSignIn');

    $this->get('/password/forgot', 'AuthController:getForgotPassword')->setName('auth.password.forgot');
    $this->post('/password/forgot', 'AuthController:postForgotPassword');

    $this->get('/password/change', 'AuthController:getChagePassword')->setName('auth.password.change');
    $this->post('/password/change', 'AuthController:postChagePassword');

})->add(new GuestMiddleware($container));


$app->group('', function() {

    $this->get('/dashboard', 'DashboardController:index')->setName('dash.home');

    $this->get('/dashboard/markets', 'MarketController:index')->setName('dash.market');
    $this->get('/dashboard/markets/{id}/show', 'MarketController:show')->setName('dash.market.show');
    $this->get('/dashboard/markets/{id}/delete', 'MarketController:delete')->setName('dash.market.delete');
    $this->post('/dashboard/markets', 'MarketController:store')->setName('dash.market.store');
    $this->post('/dashboard/markets/update', 'MarketController:update')->setName('dash.market.update');

    $this->get('/dashboard/buildings/types', 'TypeController:index')->setName('dash.building.type');
    $this->get('/dashboard/buildings/types/{id}/show', 'TypeController:show')->setName('dash.building.type.show');
    $this->get('/dashboard/buildings/types/{id}/delete', 'TypeController:delete')->setName('dash.building.type.delete');
    $this->post('/dashboard/buildings/types', 'TypeController:store')->setName('dash.building.type.store');
    $this->post('/dashboard/buildings/types/update', 'TypeController:update')->setName('dash.building.type.update');

    $this->get('/dashboard/buildings/prices', 'PriceController:index')->setName('dash.building.price');
    $this->get('/dashboard/buildings/prices/{id}/show', 'PriceController:show')->setName('dash.building.price.show');
    $this->get('/dashboard/buildings/prices/{id}/delete', 'PriceController:delete')->setName('dash.building.price.delete');
    $this->post('/dashboard/buildings/prices', 'PriceController:store')->setName('dash.building.price.store');
    $this->post('/dashboard/buildings/prices/update', 'PriceController:update')->setName('dash.building.price.update');

    $this->get('/dashboard/merchant/owners', 'OwnerController:index')->setName('dash.merchant.owner');
    $this->get('/dashboard/merchant/owners/{id}/show', 'OwnerController:show')->setName('dash.merchant.owner.show');
    $this->get('/dashboard/merchant/owners/{id}/delete', 'OwnerController:delete')->setName('dash.merchant.owner.delete');
    $this->post('/dashboard/merchant/owners', 'OwnerController:store')->setName('dash.merchant.owner.store');
    $this->post('/dashboard/merchant/owners/update', 'OwnerController:update')->setName('dash.merchant.owner.update');

    $this->get('/dashboard/merchant/buildings', 'BuildingController:index')->setName('dash.merchant.building');
    $this->get('/dashboard/merchant/buildings/{id}/show', 'BuildingController:show')->setName('dash.merchant.building.show');
    $this->get('/dashboard/merchant/buildings/{id}/delete', 'BuildingController:delete')->setName('dash.merchant.building.delete');
    $this->post('/dashboard/merchant/buildings', 'BuildingController:store')->setName('dash.merchant.building.store');
    $this->post('/dashboard/merchant/buildings/update', 'BuildingController:update')->setName('dash.merchant.building.update');

    $this->get('/dashboard/transactions', 'TransactionController:index')->setName('dash.transaction');


    $this->get('/logout', 'AuthController:getSignOut')->setName('auth.signout');

})->add(new AuthMiddleware($container));