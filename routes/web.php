<?php
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'web',
    'prefix'     => config('adashboard.prefix', 'adm'),
], function() {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('salir', 'Auth\LoginController@logout')->name('salir');
    Route::post('login', 'Auth\LoginController@login')->name('.login');

});



Route::group(['prefix' => LaravelLocalization::setLocale()], function() {
    Route::group([
        'prefix'     => config('adashboard.prefix', 'adm'),
        'as'         => 'admin',
        'middleware' => 'auth',
        //'namespace'  => 'Admin',
    ], function() {

        Route::get('/', 'HomeController@index')->name('.home');
        Route::get('/api/menu', 'HomeController@menu')->name('.menu');

        Route::group([
            'prefix' => 'crud-generator',
            'as' => '.crud-generator',
        ], function() {
            Route::get ('/', 'CrudGeneratorController@index');
            Route::get ('/cg', 'CrudGeneratorController@index2')->name('.index');
            Route::get ('/create', 'CrudGeneratorController@create')->name('.create');
            Route::post('/', 'CrudGeneratorController@store')->name('.store');
            Route::get ('/{id}/edit', 'CrudGeneratorController@edit')->name('.edit');
            Route::post('/{id}', 'CrudGeneratorController@update')->name('.update');
            //
            Route::get ('/{id}/delete', 'CrudGeneratorController@destroy')->name('.destroy');
            Route::get ('/trash', 'CrudGeneratorController@trash')->name('.trash');
            Route::get ('/{id}/restore', 'CrudGeneratorController@restore')->name('.restore');
            //
            Route::get ('api/data/{id?}', 'CrudGeneratorController@data')->name('.data');
        });

        Route::group([
            'prefix' => 'crud',
            'as' => '.crud',
        ], function() {
            Route::get ('/{tablename}', 'CrudController@index');
            Route::get ('/{tablename}/create', 'CrudController@create')->name('.create');
            Route::post('/{tablename}/{id?}', 'CrudController@store')->name('.store');
            Route::get ('/{tablename}/{id}/edit', 'CrudController@edit')->name('.edit');
            //
            Route::get ('/{tablename}/{id}/delete', 'CrudController@destroy')->name('.destroy');
            Route::get ('/{tablename}/trash', 'CrudController@trash')->name('.trash');
            Route::get ('/{tablename}/{id}/restore', 'CrudController@restore')->name('.restore');
            //
            Route::get ('/{tablename}/data/{id?}', 'CrudController@data')->name('.data');
            Route::get ('/{tablename}/{id}/copy', 'CrudController@copy')->name('.copy');
        });

        Route::group([
            'prefix' => 'user',
            'as' => '.user',
        ], function() {
            Route::get ('/', 'UserController@index');
            Route::get ('/create', 'UserController@create')->name('.create');
            Route::post('/', 'UserController@store')->name('.store');
            Route::get ('/{id}/edit', 'UserController@edit')->name('.edit');
            Route::post('/{id}', 'UserController@update')->name('.update');
            //
            Route::get ('/{id}/delete', 'UserController@destroy')->name('.destroy');
            Route::get ('/trash', 'UserController@trash')->name('.trash');
            Route::get ('/{id}/restore', 'UserController@restore')->name('.restore');
            //
            Route::get ('/{id}/permission', 'UserController@permission')->name('.permission');
            Route::post('/{id}/permission', 'UserController@updatePermission')->name('.permission.update');

        });
        
        Route::group([
            'prefix' => 'profile',
            'as' => '.profile',
        ], function() {
            Route::get ('/', 'ProfileController@index');
            Route::post('/', 'ProfileController@update')->name('.update');
        });
        Route::group([
            'prefix' => 'permission',
            'as' => '.permission',
        ], function() {
            Route::get ('/', 'PermissionController@index');
        });
        Route::group([
            'prefix' => 'grupo',
            'as' => '.grupo',
        ], function() {
            Route::get ('/', 'GrupoController@index');
            Route::get ('/create', 'GrupoController@create')->name('.create');
            Route::post('/', 'GrupoController@store')->name('.store');
            Route::get ('/{id}/edit', 'GrupoController@edit')->name('.edit');
            Route::post('/{id}', 'GrupoController@update')->name('.update');
            //
            Route::get ('/{id}/delete', 'GrupoController@destroy')->name('.destroy');
            Route::get ('/trash', 'GrupoController@trash')->name('.trash');
            Route::get ('/{id}/restore', 'GrupoController@restore')->name('.restore');
            //
            Route::get ('/{id}/permission', 'GrupoController@permission')->name('.permission');
            Route::post('/{id}/permission', 'GrupoController@updatePermission')->name('.permission.update');
        });
        Route::group([
            'prefix' => 'content',
            'as' => '.content',
        ], function() {
            Route::get('{seccion}', ['uses' => 'ContentController@home', 'as' => '']);
            Route::post('store', ['uses' => 'ContentController@store', 'as' => '.store']);
        });
        Route::group([
            'prefix' => 'dynamic-content',
            'as' => '.dynamic-content',
        ], function() {
            Route::get ('{seccion}', 'DynamicContentController@index');
            Route::get ('{seccion}/create', 'DynamicContentController@create')->name('.create');
            Route::post('{seccion}/', 'DynamicContentController@store')->name('.store');
            Route::get ('/{id}/edit', 'DynamicContentController@edit')->name('.edit');
            Route::post('/{id}/update', 'DynamicContentController@update')->name('.update');
            //
            Route::get ('/{id}/delete', 'DynamicContentController@destroy')->name('.destroy');
            Route::get ('/{seccion}/trash', 'DynamicContentController@trash')->name('.trash');
            Route::get ('/{id}/restore', 'DynamicContentController@restore')->name('.restore');
            //
            Route::get ('api/{seccion}/data/{id?}', 'DynamicContentController@data')->name('.data');
            Route::get ('/{id}/copy', 'DynamicContentController@copy')->name('.copy');
        });
        Route::group([
            'prefix' => 'translation',
            'as' => '.translation',
        ], function() {
            Route::get ('/', 'TranslationController@index');
            Route::get ('/create', 'TranslationController@create')->name('.create');
            Route::post('/', 'TranslationController@store')->name('.store');
            Route::get ('/{id}/edit', 'TranslationController@edit')->name('.edit');
            Route::post('/{id}', 'TranslationController@update')->name('.update');
            //
            Route::get ('/{id}/delete', 'TranslationController@destroy')->name('.destroy');
            Route::get ('/trash', 'TranslationController@trash')->name('.trash');
            Route::get ('/{id}/restore', 'TranslationController@restore')->name('.restore');
        });
        Route::group([
            'prefix' => 'seo',
            'as' => '.seo',
        ], function() {
            Route::get ('/', 'SeoController@index');
            Route::get ('/{id}/edit', 'SeoController@edit')->name('.edit');
            Route::post('/{id}', 'SeoController@update')->name('.update');
        });
        Route::group([
            'prefix' => 'companydata',
            'as' => '.companydata',
        ], function() {
            Route::get ('/', 'CompanyDataController@index');
            Route::post('/', 'CompanyDataController@update')->name('.update');
            Route::get('/api/data', 'CompanyDataController@data')->name('.data');
        });
    });
    /*
    Route::get ('test', function () {
        $test = new \App\Test;
        // $test->text = [
        //     ['id' => 4, 'meta' => ['saludo' => 'hola']],
        //     ['id' => 5, 'meta' => ['saludo' => 'hola']]
        // ];
        $test->text = ['es', 'en'];
        //$test->save();
        $test = new \App\Test;
        //dd($test->whereRaw("JSON_CONTAINS(text, '{\"id\": 5}')")->get());
        dd($test->whereRaw("JSON_SEARCH(text, 'one', \"it\") is not null")->get());
    })->name('test');

    Route::get('/install-laravel', function () {
        return response()->json([
            'storage:link' => Illuminate\Support\Facades\Artisan::call('storage:link')
        ]);
    });
    */
});
