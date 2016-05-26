<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['uses' => 'MainController@index', 'as' => 'home']);

Route::get('lang/{lang?}', ['as' => 'setLang', function ($lang = 'en', Request $request) {
    if (!in_array($lang, config('app.locales'))) {
        return view('error')->with([
            'page_name' => "Error",
            'error_info' => [
                'name' => 'Ошибка при смене языка',
                'desc' => 'Такого языка не существует!'
            ]
        ]);
    }

    app()->setLocale($lang);
    return redirect()->back();
}])->where('lang', '[a-z]+');