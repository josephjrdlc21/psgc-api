<?php

Route::group(['as' => "api.", 'prefix' => "api", 'namespace' => "Api", 'middleware' => ["api"]], function(){
    Route::group(['prefix' => "psgc-regions", 'as' => "psgc_regions."], function(){
        Route::get('/', ['as' => "index", 'uses' => "PSGCRegionsController@index"]);
    });
});