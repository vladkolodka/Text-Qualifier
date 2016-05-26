<?php

namespace Qualifier\Http\Controllers;

use Illuminate\Http\Request;
use Qualifier\Http\Models;

class MainController extends Controller {
    public function index(Request $request){

        return view('welcome');
//        \DB::table('topics')->truncate();
//        \DB::table('documents')->truncate();
//        \DB::table('words')->truncate();
//        \DB::table('document_word')->truncate();

//        Models\Language::ofLang('en')->topics()->save(
//            Models\Topic::create(['name' => 'Topic 1'])
//        );

//        Models\Document::create(['name' => 'Hello, world!', 'text' => 'One day far away...']);

//        Models\Document::first()->delete();
//        Models\Topic::first()->delete();


//        dd(Models\Document::first()->id);

//        Models\Document::first()->words()->saveMany([
//            new Models\Word(['name' => 'One']),
//            new Models\Word(['name' => 'day']),
//            new Models\Word(['name' => 'far']),
//            new Models\Word(['name' => 'away']),
//        ]);

//        dd(Models\Topic::first()->words());

//        dd(Models\Topic::all()->documents()->get());
    }
}