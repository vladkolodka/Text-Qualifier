<?php

namespace Qualifier\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Qualifier\Http\Models\Document;
use Qualifier\Http\Models\Topic;
use Qualifier\Http\Requests;
use Qualifier\Http\Controllers\Controller;
use Qualifier\Models\TextProcessor;

class DocumentController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return view('admin.documents')->with([
            'documents' => Document::paginate(15),
            'page_title' => trans('admin.documents')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.createDocument')->with([
            'page_title' => trans('admin.new_document'),
            'topics' => Topic::all()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
//        if(!$request->ajax()) abort(403);
        
        $qualifier = new TextProcessor($request->file('file'), $request->input('language'));

        $qualifier->save($request->input('topic'));

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param Document $document
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Document $document) {
        return view('admin.showDocument')->with([
            'page_title' => trans('admin.opened_document'),
            'document' => $document
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
