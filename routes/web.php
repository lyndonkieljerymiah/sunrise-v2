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
Route::get('api/villa/list/{status?}',[
    'uses'  =>  "VillaController@apiList",
    'as'    =>  "villa.list"
    ]);

Route::get('api/villa/search/{filterKey}/{filterValue?}',"VillaController@apiSearch");

Route::get('api/villa/vacant',"VillaController@apiVacant");

Route::get("api/villa/create","VillaController@apiCreate");

Route::get("api/villa/edit/{id}","VillaController@apiEdit");

Route::post("api/villa/store","VillaController@apiStore");

Route::delete("api/villa/destroy/","VillaController@apiDestroy");

Route::post("api/villa/update","VillaController@apiUpdate");
/***************************************/

Route::get('villa',[
        'uses'  =>  'VillaController@index',
        'as'    =>  'villa.index'
    ]);

Route::get('villa/register/{id?}',[
    'uses'  =>  'VillaController@register',
    'as'    =>  'villa.register'
]);


// *********************** USER ACCOUNT *************************

Route::get('users',function() {

    return view("users.users");

});
Route::get('users/profile',function() {

    return view("users.profile");

});


// ****************  END OF USERS ACCOUNT *********************
/************************
 *    Contract API End Point
**************************************/

Route::get("/api/contract/list/{status?}",
    [
        'uses'  => "ContractController@apiList",
        'as'    =>  "contract.list"
    ]);

Route::get("/api/contract/create/",
    [
        "uses" => "ContractController@apiCreate",
        "as"    =>  "contract.create"
    ]);

Route::get("/api/contract/renew/{contract_no}",
    [
        "uses"  =>  "ContractController@apiRenew",
        "as"    =>  "contract.renew"
    ]);

Route::post("/api/contract/update",
    [
        "uses"  =>  "ContractController@apiUpdate",
        "as"    =>  "contract.update"
    ]);

Route::post("/api/contract/store",
    [
        "uses"  =>  "ContractController@apiStore"
    ]);

Route::post("/api/contract/recal/",
    [
        "uses"  =>  "ContractController@apiRecalculate"
    ]);
/*****************************************/

Route::get("/contract",
    [
        "uses"  =>  "ContractController@index",
        "as"    =>  "contract.index"
    ]);


Route::get("contract/create/",
    [
        "uses"   =>  "ContractController@create"
    ]);



/*************************
 *BILL API End Point
**********************************/
Route::get('api/bill/create/{contractNo}',[
    'uses'  =>  'ContractBillController@apiCreate'
    ]);

Route::get('api/bill/show/{billNo}',
    [
        'uses'  =>  'ContractBillController@apiShow'
    ]);


Route::get("bill/create/{contractNo}",
    [
        "uses"  =>  "ContractBillController@create"
    ]);


Route::post('api/bill/store',
    [
        'uses' =>   'ContractBillController@apiStore'
    ]);
