<?php

namespace Qualifier\Http\Controllers;

use Illuminate\Http\Request;

use Qualifier\Http\Models\Document;
use Qualifier\Http\Models\Language;
use Qualifier\Http\Models\Topic;
use Qualifier\Http\Requests;

class AdminController extends Controller {
    
    public function index() {
        return view('admin.main')->with('page_title', 'Dashboard');
    }

}