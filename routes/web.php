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
Route::get('/', function () {
    return view('welcome');
});

Route::get('/items', [
  'uses' => 'ItemController@itemList',
  'as' => 'list.item',
]);

Route::get('/useraccess', function () {
  return view('settings.useraccess.useraccess');
});

Route::get('/roles', function () {
  return view('settings.roles.roles');
});

Route::post('/items/newItem', [
  'uses' => 'ItemController@newItem',
  'as' => 'new.item',
]);

Route::post('/getItems', [
  'uses' => 'ItemController@getItems',
  'as' => 'get.item',
]);

Route::post('/saveItem', [
  'uses' => 'ItemController@saveItem',
  'as' => 'save.item',
]);
