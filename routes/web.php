<?php


use App\Villa;


/*
 * Authentication
 * */
Auth::routes();



/********************************
Dashboard
**********************************/
Route::get('/', function() {
    return view('dashboard.index');
})->middleware('auth');


/**********************
*    Villa API End Point
***********************/
Route::get('api/villa/list/{status?}',"VillaController@index");

Route::get('api/villa/search/{filterKey}/{filterValue?}',"VillaController@search");

Route::get('api/villa/vacant',"VillaController@vacant");

Route::get("api/villa/create","VillaController@create");

Route::get("api/villa/edit/{id}","VillaController@edit");

Route::get("api/villa/{id}","VillaController@show");

Route::post("api/villa/store","VillaController@store");

Route::delete("api/villa/destroy/","VillaController@destroy");

Route::post("api/villa/update","VillaController@update");
/***************************************/


Route::get('villa',function() {

    return view("villa.index");

});

Route::get('villa/register/{id?}',function($id = 0) {

    return view("villa.create",compact($id));

});



/************************
 *    Contract API End Point
**************************************/

Route::get("api/contract/list/{status?}","ContractController@index");

Route::get("api/contract/create/","ContractController@create");

Route::post("api/contract/store","ContractController@store");

Route::get("api/contract/renew/{id}","ContractController@renew");

Route::get("api/contract/recalculate/{villaId}","ContractController@recalculate");
/*****************************************/

Route::get("contract",function() {
    return view("contract.contract");
});


Route::get("contract/create/",function() {
    return view("contract.create");
});



/*************************
 *BILL API End Point
**********************************/

Route::get('api/bill/create/{contractId}','ContractBillController@create');

Route::post('api/bill/store','ContractBillController@store');



Route::get("bill/create/{contractId}",function($contractId) {
    return view("bill.entry",['contractId' => $contractId]);
});