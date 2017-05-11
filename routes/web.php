<?php


use App\Villa;


function routeMapping($routeConfig) {
    foreach($routeConfig as $key => $route) {
        if($key == 'post') {
            foreach ($route as $routeKey => $routeValue) {
                Route::post($routeKey,$routeValue);
            }
        }
        else if($key == 'delete') {
            foreach ($route as $routeKey => $routeValue) {
                Route::delete($routeKey,$routeValue);
            }
        }
        else {
            foreach ($route as $routeKey => $routeValue) {
                Route::get($routeKey,$routeValue);
            }
        }
    }
}



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
$villaRoutes = [
    'get' =>
    [
        '/api/villa/list/{status?}' => ['uses' => 'VillaController@apiList'],
        '/api/villa/search/{filterKey}/{filterValue?}' => ['uses' => 'VillaController@apiSearch'],
        '/api/villa/vacant' => ['uses' => 'VillaController@apiVacant'],
        '/api/villa/create' => ['uses' => 'VillaController@apiCreate'],
        '/api/villa/edit/{id}' => ['uses' => 'VillaController@apiEdit']
    ],
    'post' => [
        '/api/villa/store' => ['uses' => 'VillaController@apiCreate'],
        '/api/villa/update' => ['uses' => 'VillaController@apiUpdate']
    ],
    'delete' => [
        '/api/villa/destroy/' => ['uses' => 'VillaController@apiDestroy']
    ],
    'template' => [
        '/villa' => [
            'uses'  =>  'VillaController@index',
            'as'    =>  'villa.index'
        ],
        '/villa/register/{id?}' => [
            'uses'  =>  'VillaController@register',
            'as'    =>  'villa.register'
        ]
    ]
];

routeMapping($villaRoutes);

//**************************************///




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

/************Contract***********************/
$contractRoutes = [
    'get' =>
        [
            '/api/contract/list/{status?}' => ['uses' => 'ContractController@apiList'],
            '/api/contract/create/' => ['uses' => 'ContractController@apiCreate'],
            '/api/contract/renew/{contract_no}' => ['uses' => 'ContractController@apiRenew']
        ],
    'post' => [
        '/api/contract/update' => ['uses' => 'ContractController@apiUpdate'],
        '/api/contract/store' => ['uses' => 'VillaController@apiStore'],
        '/api/contract/recalc' => ['uses' => 'ContractController@apiRecalculate'],
        '/api/contract/cancel' => ['uses' => 'ContractController@apiCancel']
    ],
    'delete' => [
        '/api/villa/destroy/' => ['uses' => 'VillaController@apiDestroy']
    ],
    'template' => [
        '/villa' => [
            'uses'  =>  'VillaController@index',
            'as'    =>  'villa.index'
        ],
        '/villa/register/{id?}' => [
            'uses'  =>  'VillaController@register',
            'as'    =>  'villa.register'
        ]
    ]
];



Route::get("/api/contract/list/{status?}",
    [
        'uses'  => "ContractController@apiList"
    ]);

Route::get("/api/contract/create/",
    [
        "uses" => "ContractController@apiCreate"
    ]);

Route::get("/api/contract/renew/{contract_no}",
    [
        "uses"  =>  "ContractController@apiRenew"
    ]);

Route::post("/api/contract/update",
    [
        "uses"  =>  "ContractController@apiUpdate"
    ]);

Route::post("/api/contract/store",
    [
        "uses"  =>  "ContractController@apiStore"
    ]);

Route::post("/api/contract/recal/",
    [
        "uses"  =>  "ContractController@apiRecalculate"
    ]);
Route::post("/api/contract/cancel",
    [
        "uses"  =>  "ContractController@apiCancel"
    ]);
/*****************************************/

Route::get("/contract",
    [
        "uses"  =>  "ContractController@index",
        "as"    =>  "contract.index"
    ]);

Route::get("contract/create/",
    [
        "uses"  =>  "ContractController@create",
        "as"    =>  "contract.create"
    ]);

/*************************
 *BILL API End Point
**********************************/
Route::get("bill/create/{contractNo}",
    [
        "uses"  =>  "ContractBillController@create"
    ]);

Route::get('api/bill/create/{contractNo}',
    [
        'uses'  =>  'ContractBillController@apiCreate'
    ]);

Route::post('api/bill/store',
    [
        'uses' =>   'ContractBillController@apiPostStore'
]);

Route::get("bill/show/{billNo}", ["uses"  =>  "ContractBillController@show"]);

Route::get('api/bill/show/{billNo}',
    [
        'uses'  =>  'ContractBillController@apiShow'
    ]);


Route::get("/bill/edit", ["uses"  =>  "ContractBillController@edit"]);


Route::get("/api/bill/edit/{billNo}",[ "uses" => "ContractBillController@apiEdit"]);

Route::get("/api/bill/payment/{id}/{status}",[ "uses" => "ContractBillController@apiPaymentByStatus"]);

Route::post('/api/bill/update', ["uses" => "ContractBillController@apiPostUpdate"]);