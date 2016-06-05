<?php

Route::singularResourceParameters();

Route::group(['domain' => config('app.domain')], function () {

    Route::get('/', ['uses' => 'MainController@index', 'as' => 'home']);

    Route::get('about', ['uses' => 'MainController@about', 'as' => 'about']);

    Route::post('upload', ['uses' => 'MainController@uploadFile', 'as' => 'upload']);

    Route::get('language/{lang?}', ['uses' => 'MainController@setLanguage', 'as' => 'setLang'])->where('lang', '[a-z]{2,}');

});

Route::group(['domain' => 'admin.' . config('app.domain'), 'as' => 'admin::'], function () {
    Route::get('/', ['uses' => 'AdminController@index', 'as' => 'home']);

    Route::get('logout', ['uses' => 'AdminController@logout', 'as' => 'logout']);

    Route::resource('topics', 'Admin\TopicController');

    Route::get('documents/unverified', ['uses' => 'Admin\DocumentController@indexUnverified', 'as' => 'documents.index_unverified']);
    Route::get('documents/verify/{id}', ['uses' => 'Admin\DocumentController@verify', 'as' => 'documents.verify']);
    Route::resource('documents', 'Admin\DocumentController');
});

Route::any('password/reset', 'AdminController@index');

Route::auth();