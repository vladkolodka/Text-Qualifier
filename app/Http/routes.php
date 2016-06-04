<?php

Route::singularResourceParameters();

Route::group(['domain' => config('app.domain')], function () {

    Route::get('test', 'TestController@getTopics');

    Route::get('/', ['uses' => 'MainController@index', 'as' => 'home']);

    Route::post('upload', ['uses' => 'MainController@uploadFile', 'as' => 'upload']);

    Route::get('language/{lang?}', ['uses' => 'MainController@setLanguage', 'as' => 'setLang'])->where('lang', '[a-z]{2,}');

});

Route::group(['domain' => 'admin.' . config('app.domain'), 'as' => 'admin::'], function () {
    Route::get('/', ['uses' => 'AdminController@index', 'as' => 'home']);

    Route::resource('topics', 'Admin\TopicController');
    Route::resource('documents', 'Admin\DocumentController');
});