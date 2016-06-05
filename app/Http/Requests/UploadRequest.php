<?php

namespace Qualifier\Http\Requests;

use Qualifier\Http\Requests\Request;

class UploadRequest extends Request {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
//            'file' => 'required|max:10240|mimes:' . implode(',', config('app.file_formats')),
            'language' => 'required|in:en,ru',
            'save' => 'required|in:0,1'
        ];
    }
}
