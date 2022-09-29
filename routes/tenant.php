<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
    
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        dd(\App\Models\User::all());
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    


    Route::get('create-user',function(){
        User::create([
            'name' => 'waesdf',
            'email' => 'wadsf@sdsf.com',
            'password' => 'dadfdfssdf'
        ]);
    });

        // ADD $$ Edit $$ Delete ///
    Route::get('/', 'ProductsController@index')->name('user.products');

    Route::get('create', 'ProductsController@create')->name('user.products.create');
    Route::post('store', 'ProductsController@store')->name('store.store');

    Route::get('edit/{id}', 'ProductsController@edit')->name('user.products.edit');
    Route::get('delete/{id}', 'ProductsController@destroy')->name('user.products.delete');
    
    });




});
