@extends('layout.admin')

@section('includes')
    <script src="{{ load('js/newDocument.js') }}"></script>
@stop

@section('content')
    <div class="results_form">
        <h4 id="upload_status"></h4>
        <div class="progress">
            <div class="determinate" style="width: 0" id="load_progress"></div>
        </div>
    </div>

    <div class="upload_form">
        <h4>{{ trans('main.upload_modal_header') }}</h4>
        <div class="row">
            <div class="col s12 l8">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>{{ trans('main.select_file_button') }}</span>
                        <input type="file" name="file" id="file_field"
                               data-url="{{ route('admin::documents.store') }}"/>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text"
                               placeholder="{{ trans('main.file_not_selected') }}">
                    </div>
                </div>
            </div>
            <div class="col s12 l4 select-h-60">
                <select name="topic" id="topic_id">
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="text_language">
                    <span>{{ trans('main.text_language') }}</span><br>
                    <input value="en" name="text_lang" type="radio"
                           {{  App::isLocale('en') ? 'checked' : '' }} id="text_en"/>
                    <label for="text_en">{{ trans('main.lang_en') }}</label>

                    <input value="ru" name="text_lang" type="radio"
                           {{   !App::isLocale('en') ? 'checked' : ''  }} id="text_ua_ru"/>
                    <label for="text_ua_ru">{{ trans('main.lang_ru') }}</label>
                </div>
            </div>
        </div>

        <input type="button" class="waves-effect waves-light btn" id="upload_file"
               value="{{ trans('main.modal_upload') }}">

    </div>
@stop