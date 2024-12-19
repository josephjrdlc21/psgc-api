<?php

Route::group(['as' => "api.", 'prefix' => "api", 'namespace' => "Api", 'middleware' => ["api"]], function(){
    Route::group(['prefix' => "regions", 'as' => "regions."], function(){
        Route::get('/', ['as' => "index", 'uses' => "PSGCRegionsController@index"]);

        Route::get('/test', function () {
            return response()->json(['message' => 'New Test Endpoint Working!']);
        });
    });
});