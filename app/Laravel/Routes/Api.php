<?php

Route::group(['as' => "api.", 'prefix' => "api", 'namespace' => "Api", 'middleware' => ["api"]], function(){
    Route::group(['prefix' => "regions", 'as' => "regions."], function(){
        Route::get('/', ['as' => "index", 'uses' => "PSGCRegionsController@index"]);
        Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCRegionsController@show"]);
    });
    Route::group(['prefix' => "provinces", 'as' => "provinces."], function(){
        Route::get('/', ['as' => "index", 'uses' => "PSGCProvinceController@index"]);
        Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCProvinceController@show"]);
    });
    Route::group(['prefix' => "citymuns", 'as' => "citymuns."], function(){
        Route::get('/', ['as' => "index", 'uses' => "PSGCCitymunController@index"]);
        Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCCitymunController@show"]);
    });
    Route::group(['prefix' => "barangays", 'as' => "barangays."], function(){
        Route::get('/', ['as' => "index", 'uses' => "PSGCBarangayController@index"]);
        Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCBarangayController@show"]);
    });
});