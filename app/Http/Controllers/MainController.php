<?php

namespace Qualifier\Http\Controllers;

use Illuminate\Http\Request;
use Qualifier\Http\Models;
use Qualifier\Http\Requests\UploadRequest;
use Qualifier\Models\TextProcessor;

class MainController extends Controller {
    public function index(){
        return view('welcome');
    }
    public function about(){
        return view('about');
    }

    public function setLanguage($lang = 'en', Request $request){
        if(!in_array($lang, config('app.locales'))) abort(404);

        app()->setLocale($lang);
        if($request->url() == \URL::previous()) return redirect()->route('home');
        return redirect()->back();
    }

    public function uploadFile(UploadRequest $request){
        if(!$request->ajax()) abort(403);
        $qualifier = new TextProcessor($request->file('file'), $request->input('language'));
        $topics = [];
        foreach ($qualifier->analyze($request->input('save')) as $topic) $topics[] = $topic->name;

        return response()->json(['topics' => $topics]);
    }

}