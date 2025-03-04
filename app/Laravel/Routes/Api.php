<?php

Route::group(['as' => "api.", 'prefix' => "api", 'namespace' => "Api", 'middleware' => ["api"]], function(){
    Route::group(['prefix' => "auth", 'as' => "auth."], function(){
        Route::post('/register', ['as' => "register", 'uses' => "AuthenticationController@register"]);
        Route::post('/login', ['as' => "login", 'uses' => "AuthenticationController@login"]);

        Route::group(['middleware' => "api.auth:api"], function () {
            Route::post('/logout', ['as' => "logout", 'uses' => "AuthenticationController@logout"]);
        });
    });

    Route::group(['middleware' => "api.auth:api"], function (){
        Route::group(['prefix' => "regions", 'as' => "regions."], function(){
            Route::get('/', ['as' => "index", 'uses' => "PSGCRegionsController@index"]);
            Route::post('/store', ['as' => "store", 'uses' => "PSGCRegionsController@store"]);
            Route::post('/update/{id?}', ['as' => "update", 'uses' => "PSGCRegionsController@update"]);
            Route::any('/delete/{id?}', ['as' => "delete", 'uses' => "PSGCRegionsController@destroy"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCRegionsController@show"]);
        });
        Route::group(['prefix' => "provinces", 'as' => "provinces."], function(){
            Route::get('/', ['as' => "index", 'uses' => "PSGCProvinceController@index"]);
            Route::post('/store', ['as' => "store", 'uses' => "PSGCProvinceController@store"]);
            Route::post('/update/{id?}', ['as' => "update", 'uses' => "PSGCProvinceController@update"]);
            Route::any('/delete/{id?}', ['as' => "delete", 'uses' => "PSGCProvinceController@destroy"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCProvinceController@show"]);
        });
        Route::group(['prefix' => "citymuns", 'as' => "citymuns."], function(){
            Route::get('/', ['as' => "index", 'uses' => "PSGCCitymunController@index"]);
            Route::post('/store', ['as' => "store", 'uses' => "PSGCCitymunController@store"]);
            Route::post('/update/{id?}', ['as' => "update", 'uses' => "PSGCCitymunController@update"]);
            Route::any('/delete/{id?}', ['as' => "delete", 'uses' => "PSGCCitymunController@destroy"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCCitymunController@show"]);
        });
        Route::group(['prefix' => "barangays", 'as' => "barangays."], function(){
            Route::get('/', ['as' => "index", 'uses' => "PSGCBarangayController@index"]);
            Route::post('/store', ['as' => "store", 'uses' => "PSGCBarangayController@store"]);
            Route::post('/update/{id?}', ['as' => "update", 'uses' => "PSGCBarangayController@update"]);
            Route::any('/delete/{id?}', ['as' => "delete", 'uses' => "PSGCBarangayController@destroy"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCBarangayController@show"]);
        });
    });
});