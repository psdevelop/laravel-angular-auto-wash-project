<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
Route::get('contact', function () {
    return view('contact');
});
*/

Route::get('/', 'PagesController@lobby');
Route::get('/lobby', 'PagesController@lobby');
Route::get('/hello', 'PagesController@lobby');

Route::get('/colors/index', 'ColorsController@index');

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/regnew', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('clients/edit/{user_id}', 'UsersController@showClient');
Route::post('clients/update', 'UsersController@updateClient');
Route::get('clients/new/{wash_id}', 'UsersController@createClient');

Route::get('duties/new/{wash_id}', 'DutiesController@create');
Route::post('duties/save', 'DutiesController@save');
Route::get('duties/open/{wash_id}', 'DutiesController@open');
Route::post('duties/register', 'DutiesController@register');
Route::get('duties/close/{wash_id}', 'DutiesController@close');
Route::post('duties/unregister/{wash_id}', 'DutiesController@unregister');
Route::get('duties/salary/{wash_id}', 'DutiesController@currentSalary');

Route::get('reports/boxes/parameters/{wash_id}', 'ReportsController@showBoxesParameters');
Route::post('reports/boxes/view', 'ReportsController@showBoxesReport');
Route::get('reports/clients/parameters/{wash_id}', 'ReportsController@showClientsParameters');
Route::post('reports/clients/view', 'ReportsController@showClientsReport');
Route::get('reports/noncash/parameters/{wash_id}', 'ReportsController@showNoncashParameters');
Route::get('reports/duties/parameters/{wash_id}', 'ReportsController@showDutiesParameters');
Route::post('reports/duties/view', 'ReportsController@showDutiesReport');
Route::get('reports/boxstat/parameters/{wash_id}', 'ReportsController@showBoxStatisticsParameters');
Route::post('reports/boxstat/view', 'ReportsController@showBoxStatisticsReport');

Route::get('receipts/dynload/{wash_id}', 'CashboxController@receipts');

Route::get('expences/dynload/{wash_id}', 'CashboxController@expences');
Route::get('expences/new/{wash_id}', 'CashboxController@newExpence');
Route::post('expences/create', 'CashboxController@create');


Route::get('users/workers/{wash_id}', 'UsersController@getWorkers');
Route::get('users/clients/{wash_id}', 'UsersController@getClients');
Route::get('users/find/{key}/{wash_id}', 'UsersController@find');
Route::get('users/create', 'UsersController@add');
Route::get('users/edit/{user_id}', 'UsersController@show');
Route::post('users/update', 'UsersController@update');
Route::get('users/createUser/{id}', 'UsersController@createUser');
Route::post('users/saveUser', 'UsersController@saveUser');
Route::post('users/saveClient', 'UsersController@saveClient');
Route::get('users/remove/{id}', 'UsersController@remove');
Route::post('users/delete/{id}', 'UsersController@delete');

Route::group(['prefix'=>'washes'], function(){
  Route::get('index', 'WashesController@index');
  Route::get('load/{id}', 'WashesController@load');
  Route::get('create', 'WashesController@create');
  Route::post('store', 'WashesController@store');
  Route::get('delete/{id}', 'WashesController@delete');
  Route::get('{id}', 'WashesController@show');
});

Route::get('boxes/free/{box_id}', 'BoxesController@free');
Route::get('boxes/dynload/{wash_id}', 'BoxesController@index');
Route::get('boxes/occupied/{wash_id}', 'BoxesController@occupied');
Route::get('boxes/index/{wash_id}', 'BoxesController@records');
Route::get('boxes/find/{wash_id}/{start}/{end}', 'BoxesController@find');
Route::get('boxes/new/{wash_id}', 'BoxesController@create');
Route::get('boxes/edit/{box_id}', 'BoxesController@edit');
Route::get('boxes/manage/{box_id}', 'BoxesController@manage');
Route::get('boxes/singleload/{box_id}', 'BoxesController@loadSingle');
Route::get('boxes/singlerefresh/{box_id}', 'BoxesController@refreshSingle');
Route::post('boxes/update', 'BoxesController@update');
Route::post('boxes/store', 'BoxesController@save');

Route::get('services/dynload/{wash_id}', 'ServicesController@index');
Route::get('services/new/{wash_id}', 'ServicesController@show');
Route::post('services/createService', 'ServicesController@save');
Route::get('services/remove/{auto_id}', 'ServicesController@remove');
Route::post('services/delete/{auto_id}', 'ServicesController@delete');

Route::get('autos/new/{wash_id}', 'AutosController@create');
Route::get('autos/edit/{auto_id}', 'AutosController@edit');
Route::post('autos/updateAuto', 'AutosController@update');
Route::get('autos/dynload/{wash_id}', 'AutosController@index');
Route::post('autos/createAuto', 'AutosController@store');
Route::get('autos/remove/{auto_id}', 'AutosController@remove');
Route::post('autos/delete/{auto_id}', 'AutosController@delete');

Route::get('prices/index/{wash_id}', 'PricesController@index');
Route::get('prices/dynload/{service_id}/{auto_type}', 'PricesController@load');
Route::post('prices/savePrice', 'PricesController@store');
Route::post('prices/updatePrice', 'PricesController@update');

Route::get('washsessions/check/{wash_id}', 'WashsessionsController@refresh');
Route::get('washsessions/dynload/{wash_id}', 'WashsessionsController@index');
Route::get('washsessions/detail/{washsession_id}', 'WashsessionsController@detail');
Route::get('washsessions/list/{wash_id}', 'WashsessionsController@listWashsessions');
Route::get('washsessions/complete/{ws_id}', 'WashsessionsController@complete');
Route::post('washsessions/createWashsession', 'WashsessionsController@store');
Route::get('washsessions/remove/{id}', 'WashsessionsController@remove');
Route::post('washsessions/delete/{id}', 'WashsessionsController@delete');

Route::get('payments/dynload/{wash_id}', 'PaymentsController@index');
Route::get('payments/edit/{payment_id}', 'PaymentsController@show');
Route::post('payments/update', 'PaymentsController@update');

Route::get('cars/new/{wash_id}/{client_id}', 'CarsController@create');
Route::post('cars/save', 'CarsController@save');
Route::get('cars/find/{key}/{wash_id}', 'CarsController@find');

Route::get('discounts/new/{wash_id}/{client_id}', 'DiscountsController@create');
Route::post('discounts/save', 'DiscountsController@save');
Route::get('discounts/remove/{clientId}/{discountId}', 'DiscountsController@remove');
Route::post('discounts/delete/{id}', 'DiscountsController@delete');
