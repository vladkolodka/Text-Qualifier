<?php

namespace Qualifier\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Qualifier\Http\Controllers\Controller;
use Qualifier\Http\Models\Language;
use Qualifier\Http\Models\Topic;
use Qualifier\Http\Requests;

class TopicController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.topics')->with([
            'topics' => Topic::paginate(15),
            'page_title' => trans('admin.topics')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.createTopicForm')->with('page_title', trans('admin.new_topic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
//        $validator = \Validator::make($request->all(), [
//            'name' => 'required|min:5|max:255|unique:topics',
//            'language' => 'required|in:en,ru'
//        ]);
//
//        if($validator->fails()){
//            $request->session()->flash('result', trans('js.error'));
//            return redirect()->back();
//        }
        $this->validate($request, [
            'name' => 'required|min:5|max:255|unique:topics',
            'language' => 'required|in:en,ru'
        ]);

        $topic = Topic::firstOrNew(['name' => $request->input('name')]);
        Language::OfLang($request->input('language'))->topics()->save($topic);

        $request->session()->flash('result', 'Topic created.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Topic $topic
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Topic $topic) {
//        dd($topic->documents()->paginate(15));
        return view('admin.documents')->with([
            'documents' => $topic->documents()->paginate(15),
            'page_title' => $topic->name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
