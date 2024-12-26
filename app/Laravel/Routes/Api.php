<?php

Route::group(['as' => "api.", 'prefix' => "api", 'namespace' => "Api", 'middleware' => ["api"]], function(){
    Route::group(['prefix' => "regions", 'as' => "regions."], function(){
        Route::get('/', ['as' => "index", 'uses' => "PSGCRegionsController@index"]);
        Route::get('/show/{id?}', ['as' => "show", 'uses' => "PSGCRegionsController@show"]);
    });
});