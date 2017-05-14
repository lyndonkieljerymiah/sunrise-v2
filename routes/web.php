<?php


use App\Villa;


function routeMapping($routeConfig) {
    foreach($routeConfig as $key => $route) {
        if($key == 'post') {
            foreach ($route as $routeKey => $routeValue) {
                Route::middleware('auth')->post($routeKey,$routeValue);
            }
        }
        else if($key == 'delete') {
            foreach ($route as $routeKey => $routeValue) {
                Route::middleware('auth')->delete($routeKey,$routeValue);
            }
        }
        else {
            foreach ($route as $routeKey => $routeValue) {
                Route::middleware('auth')->get($routeKey,$routeValue);
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


/*
|--------------------------------------------------------------------------
| Villa API Routes
|--------------------------------------------------------------------------
|
|
|
*/

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
        '/api/villa/store' => ['uses' => 'VillaController@apiStore'],
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


/*
|--------------------------------------------------------------------------
| Contract API Routes
|--------------------------------------------------------------------------
|
|
|
*/

$contractRoutes = [
    'get' =>
        [
            '/api/contract/list/{status?}' => ['uses' => 'ContractController@apiList'],
            '/api/contract/create/' => ['uses' => 'ContractController@apiCreate'],
            '/api/contract/renew/{contract_no}' => ['uses' => 'ContractController@apiRenew']
        ],
    'post' => [
        '/api/contract/update' => ['uses' => 'ContractController@apiUpdate'],
        '/api/contract/store' => ['uses' => 'ContractController@apiStore'],
        '/api/contract/recalc' => ['uses' => 'ContractController@apiRecalculate'],
        '/api/contract/cancel' => ['uses' => 'ContractController@apiCancel']
    ],
    'template' => [
        '/contract' => [
            'uses'  =>  'ContractController@index',
            'as'    =>  'contract.index'
        ],
        '/contract/create/' => [
            'uses'  =>  'ContractController@create',
            'as'    =>  'contract.create'
        ]
    ]
];

routeMapping($contractRoutes);

/*
|--------------------------------------------------------------------------
| Bill API Routes
|--------------------------------------------------------------------------
|
|
|
*/

$billRoutes = [
    'get' =>
        [
            '/api/bill/create/{contractNo}' => ['uses' => 'ContractBillController@apiCreate'],
            '/api/bill/show/{billNo}' => ['uses' => 'ContractBillController@show'],
            '/api/bill/edit/{billNo}' => ['uses' => 'ContractBillController@apiEdit'],
            '/api/bill/payment/{id}/{status}' => ['uses' => 'ContractBillController@apiPaymentByStatus']

        ],
    'post' => [
        '/api/bill/store' => ['uses' => 'ContractBillController@apiPostStore'],
        '/api/bill/update' => ['uses' => 'ContractBillController@apiPostUpdate'],
    ],
    'template' => [
        'bill/create/{contractNo}' => [
            'uses'  =>  'ContractBillController@create',
            'as'    =>  'bill.create'
        ],
        'bill/show/{billNo}' => [
            'uses'  =>  'ContractBillController@show',
            'as'    =>  'bill.show'
        ],
        "/bill/edit" => ["uses"  =>  "ContractBillController@edit"]
    ]
];

routeMapping($billRoutes);



