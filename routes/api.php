<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    Route::post('companies/change_status', 'CompaniesController@changeStatus');
});
