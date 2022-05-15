<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST, GET');
// header('Access-Control-Allow-Headers: glen-key, Authorization, Content-Type');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/errors/404', function () {
    return view('errors.404');
});



// Route::get('/useraccess', function () {
//   return view('settings.useraccess.useraccess');
// });

Route::get('/roles', function () {
  return view('settings.roles.roles');
});

Route::group(['prefix' => 'login'], function () {
  Route::get('/', [
    'uses' => "LoginController@index"
  ]);
  Route::post('/login', [
    'uses' => "LoginController@login"
  ]);
});






Route::group(['prefix' => 'items'], function () {
  $ItemC = "ItemController";

  Route::post('/getPic', function() {
    
  });

  Route::get('/', [
    'uses' => "$ItemC@itemList"
  ]);

  Route::post('getItems', [
    'uses' => "$ItemC@getItems"
  ]);

  Route::post('getUom', [
    'uses' => "$ItemC@getUom"
  ]);

  Route::post('saveItem', [
    'uses' => "$ItemC@saveItem"
  ]);

  Route::post('saveUom', [
    'uses' => "$ItemC@saveUom"
  ]);

  Route::match(['GET', 'POST'], 'item', [
    'uses' => "$ItemC@newItem"
  ]);

  Route::get('item/{itemid}', [
    'uses' => "$ItemC@newItem"
  ]);
});


Route::group(['prefix' => 'suppliers', 'middleware' => ['sampleware']], function () {
  $SupplierC = "SupplierController";

  Route::post('getSuppliers', [
    'uses' => "$SupplierC@getSuppliers"
  ]);

  Route::post('saveSupplier', [
    'uses' => "$SupplierC@saveSupplier"
  ]);

  Route::match(['GET', 'POST'], '/supplier', [
    'uses' => "$SupplierC@newSupplier"
  ]);

  Route::get('/', [
    'uses' => "$SupplierC@supplierList"
  ]);

  Route::get('/supplier/{supplierid}', [
    'uses' => "$SupplierC@newSupplier"
  ]);
});


Route::group(['prefix' => 'IS'], function () {
  $InvetoryC = "InventoryController";

  Route::get('/', [
    'uses' => "$InvetoryC@setupList"
  ]);

  Route::match(['GET', 'POST'], 'setup', [
    'uses' => "$InvetoryC@newSetup"
  ]);

  Route::get('setup/{txid}', [
    'uses' => "$InvetoryC@newSetup"
  ]);

  Route::post('saveSetup', [
    'uses' => "$InvetoryC@saveSetup"
  ]);

  Route::post('getSetup', [
    'uses' => "$InvetoryC@getSetup"
  ]);

  Route::post('getItems', [
    'uses' => "$InvetoryC@getItems"
  ]);

  Route::post('addItem', [
    'uses' => "$InvetoryC@addItem"
  ]);

  Route::post('loadStock', [
    'uses' => "$InvetoryC@loadStock"
  ]);

  Route::post('saveStock', [
    'uses' => "$InvetoryC@saveStock"
  ]);
});

Route::group(['prefix' => 'POS'], function () {
  $posC = "PosController";
  Route::get('/', [
    'uses' => "$posC@index"
  ]);

  Route::post('/saveCart', [
    'uses' => "$posC@saveCart"
  ]);
  Route::post('/loadCart', [
    'uses' => "$posC@loadCart"
  ]);
});

Route::group(['prefix' => 'category'], function () {
  $catC = "CategoryController";
  Route::get('/', [
    'uses' => "$catC@index"
  ]);
  Route::post('/getCategory', [
    'uses' => "$catC@getCategory"
  ]);
});

Route::group(['prefix' => 'user'], function () {
  $userC = "UserController";
  Route::get('/', [
    'uses' => "$userC@index"
  ]);
});