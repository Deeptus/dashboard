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

Route::group([
    'prefix'     => config('adashboard.prefix', 'adm'),
], function() {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
});

Route::group(
    [
        "prefix" => config('adashboard.prefix', 'adm') . "/log-viewer",
        "namespace" => "\Arcanedev\LogViewer\Http\Controllers"
    ]
    , function() {
    Route::name('log-viewer::')->group(function () {
        // log-viewer::dashboard
        Route::get('/', 'LogViewerController@index')->name('dashboard');

        Route::prefix('logs')->name('logs.')->group(function() {
            Route::get('/', 'LogViewerController@listLogs')
                 ->name('list'); // log-viewer::logs.list

            Route::delete('delete', 'LogViewerController@delete')
                 ->name('delete'); // log-viewer::logs.delete

            Route::prefix('{date}')->group(function() {
                Route::get('/', 'LogViewerController@show')
                     ->name('show'); // log-viewer::logs.show

                Route::get('download', 'LogViewerController@download')
                     ->name('download'); // log-viewer::logs.download

                Route::get('{level}', 'LogViewerController@showByLevel')
                     ->name('filter'); // log-viewer::logs.filter

                Route::get('{level}/search', 'LogViewerController@search')
                     ->name('search'); // log-viewer::logs.search
            });
        });
    });
});

Route::group(['prefix' => LaravelLocalization::setLocale()], function() {
    Route::group([
    	'prefix'     => config('adashboard.prefix', 'adm'),
    	'as'         => 'admin',
    	'middleware' => 'auth',
    	//'namespace'  => 'Admin',
    ], function() {
        Route::post('chat-area',    'ChatAreaController@getMessages')->name('.chat-area');
        Route::get ('file-manager', 'FileManagerController@data')->name('.file-manager');
        Route::post('file-manager', 'FileManagerController@upload');

        Route::get('/', 'HomeController@index')->name('.home');
        
        Route::get('/homework', 'HomeworkController@index')->name('.homework.index');
        Route::group([
            'prefix' => 'api/homework',
            'as' => '.homework',
        ], function() {
            Route::get ('/',    'HomeworkController@myTasks');
            Route::get ('data', 'HomeworkController@data')->name('.data');
            Route::post('save', 'HomeworkController@save')->name('.save');
            Route::post('find', 'HomeworkController@find')->name('.find');
        });
        Route::group([
            'prefix' => 'api/notification',
            'as' => '.notification',
        ], function() {
            Route::get ('/',    'NotificationController@all');
            Route::post('find', 'NotificationController@find')->name('.find');
        });
        Route::group([
            'prefix' => 'crud-generator',
            'as' => '.crud-generator',
        ], function() {
            Route::get ('/', 'CrudGeneratorController@index');
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
            Route::get ('/{tablename}/api/data/{id?}', 'CrudController@data')->name('.data');
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
            'prefix' => 'multimedia',
            'as' => '.multimedia',
        ], function() {
            Route::get ('/', 'MultimediaController@index');
            Route::get ('/create', 'MultimediaController@create')->name('.create');
            Route::post('/', 'MultimediaController@store')->name('.store');
            Route::get ('/{id}/edit', 'MultimediaController@edit')->name('.edit');
            Route::post('/{id}', 'MultimediaController@update')->name('.update');
            //
            Route::get ('/{id}/delete', 'MultimediaController@destroy')->name('.destroy');
            Route::get ('/{id}/restore', 'MultimediaController@restore')->name('.restore');
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