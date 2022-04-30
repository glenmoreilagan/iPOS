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



Route::get('/useraccess', function () {
  return view('settings.useraccess.useraccess');
});

Route::get('/roles', function () {
  return view('settings.roles.roles');
});






Route::group(['prefix' => 'items'], function () {
  $ItemC = "ItemController";

  Route::post('/getPic', function() {
    
  });

  Route::get('/', [
    'uses' => "$ItemC@itemList", 'as' => 'list.item',
  ]);

  Route::post('getItems', [
    'uses' => "$ItemC@getItems", 'as' => 'get.item',
  ]);

  Route::post('getUom', [
    'uses' => "$ItemC@getUom", 'as' => 'get.uom',
  ]);

  Route::post('saveItem', [
    'uses' => "$ItemC@saveItem", 'as' => 'save.item',
  ]);

  Route::post('saveUom', [
    'uses' => "$ItemC@saveUom", 'as' => 'save.uom',
  ]);

  Route::match(['GET', 'POST'], 'item', [
    'uses' => "$ItemC@newItem", 'as' => 'new.item',
  ]);

  Route::get('item/{itemid}', [
    'uses' => "$ItemC@newItem", 'as' => 'edit.item',
  ]);
});



Route::group(['prefix' => 'suppliers', 'middleware' => ['sampleware']], function () {
  $SupplierC = "SupplierController";

  Route::post('getSuppliers', [
    'uses' => "$SupplierC@getSuppliers", 'as' => 'get.supplier',
  ]);

  Route::post('saveSupplier', [
    'uses' => "$SupplierC@saveSupplier", 'as' => 'save.supplier',
  ]);

  Route::match(['GET', 'POST'], '/supplier', [
    'uses' => "$SupplierC@newSupplier", 'as' => 'new.supplier',
  ]);

  Route::get('/', [
    'uses' => "$SupplierC@supplierList", 'as' => 'list.supplier',
  ]);

  Route::get('/supplier/{supplierid}', [
    'uses' => "$SupplierC@newSupplier", 'as' => 'edit.supplier',
  ]);
});









Route::group(['prefix' => 'IS'], function () {
  $InvetoryC = "InventoryController";

  Route::get('/', [
    'uses' => "$InvetoryC@setupList", 'as' => 'list.IS',
  ]);

  Route::match(['GET', 'POST'], 'setup', [
    'uses' => "$InvetoryC@newSetup", 'as' => 'new.setup',
  ]);

  Route::get('/IS/{txid}', [
    'uses' => "$InvetoryC@newSetup", 'as' => 'edit.setup',
  ]);

  Route::post('saveSetup', [
    'uses' => "$InvetoryC@saveSetup", 'as' => 'save.setup',
  ]);
});