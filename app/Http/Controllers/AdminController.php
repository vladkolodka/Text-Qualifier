<?php

namespace Qualifier\Http\Controllers;

use Illuminate\Http\Request;

use Qualifier\Http\Models\Document;
use Qualifier\Http\Models\Language;
use Qualifier\Http\Models\Topic;
use Qualifier\Http\Requests;

class AdminController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('admin.main')->with('page_title', 'Dashboard');
    }

    public function logout(){
        \Auth::logout();
        return redirect('login');
    }

}