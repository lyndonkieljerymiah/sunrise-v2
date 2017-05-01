<?php


use App\Villa;



Auth::routes();



/********************************
Dashboard
**********************************/
Route::get('/', function() {

    return view('dashboard.index');
})->middleware('auth');


/**********************
*    Villa API
    - API

    GET - api/villa/list/{status?} - get api via status - [list,statuscount]

    GET - api/villa/vacant - get vacant villa - active-list

    GET - api/villa/{id} - get villa - villa-row

    POST - apiStore  - store villa - result

    PATCH - apiUpdate - update villa - result

    DELETE - apiDelete - mark delete - result

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



Route::get('villa',function() {

    return view("villa.index");

});


Route::get('villa/register/{id?}',function($id = 0) {

    return view("villa.create",["id" => $id]);

});



/************Contracts API**************

    GET - contract - get the list of the contract -

    GET - contract/apiCreate    - create new contract

    POST - contract/apiStore    - store contract

    GET - contract/apiRenew     - renew contract

    POST - contract/apiRenew    - save renewal

    GET - contract/apiTerminate - terminate contract

    POST - contract/apiTerminate - save terminate

    DELETE - contract/apiDelete

    //notification

**************************************/
Route::get("contract",function() {
    return view("contract.contract");
});


Route::get("contract/create/",function() {
    return view("contract.create");
});


Route::get("api/contract/list/{status?}","ContractController@index");

Route::get("api/contract/create/","ContractController@create");

Route::post("api/contract/store","ContractController@store");

Route::get("api/contract/renew/{id}","ContractController@renew");




/************BILL API**************

**************************************/
Route::get('api/bill/create/{contractId}','ContractBillController@create');


Route::get("bill/register/{contractId}",function($contractId) {
    return view("bill.entry",['contractId' => $contractId]);
});