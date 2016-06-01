@extends('layout.user')

@section('includes')

    <script src="{{ load('js/welcome.js') }}"></script>

@stop

@section('content')

    <!-- Modal Structure -->
    <div id="upload_modal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <div class="upload_form">
                <h4>{{ trans('main.upload_modal_header') }}</h4>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>{{ trans('main.select_file_button') }}</span>
                        <input type="file" id="file_field" data-url="{{ route('upload') }}"/>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text"
                               placeholder="{{ trans('main.file_not_selected') }}">
                    </div>
                </div>
                <div class="text_language">
                    <span>{{ trans('main.text_language') }}</span><br>
                    <input value="en" name="text_lang" type="radio"
                           {{  App::isLocale('en') ? 'checked' : '' }} id="text_en"/>
                    <label for="text_en">{{ trans('main.lang_en') }}</label>

                    <input value="ru" name="text_lang" type="radio"
                           {{   !App::isLocale('en') ? 'checked' : ''  }} id="text_ua_ru"/>
                    <label for="text_ua_ru">{{ trans('main.lang_ru') }}</label>
                </div>
                <p>
                    <input type="checkbox" class="filled-in" id="allow_save" checked="checked" />
                    <label for="allow_save">{{ trans('main.allow_save') }}</label>
                </p>
            </div>
            <div class="results_form">
                <h4 id="upload_status"></h4>
                <div class="progress">
                    <div class="determinate" style="width: 0" id="load_progress"></div>
                </div>
            </div>
            <div class="results">
                {{ trans('main.estimated_categories') }}
                <div id="results"></div>
            </div>
        </div>

        <div class="modal-footer">
            <div class="upload_buttons_wrapper">
                <a href="#" class="modal-action waves-effect waves-green btn-flat"
                   id="upload_file">{{ trans('main.modal_upload') }}</a>
                <a href="#"
                   class="modal-action modal-close waves-effect waves-green btn-flat">{{ trans('main.modal_cancel') }}</a>
            </div>
            <div class="result_buttons_wrapper">
                <a href="#" class="modal-action waves-effect waves-green btn-flat"
                   id="back_button">{{ trans('main.results_back') }}</a>
            </div>
        </div>
    </div>



    <section class="main">
        <div class="valign-wrapper responsive-img" id="content">
            <div class="valign center-align">
                <div class="row">

                    <div class="col s0 l2" style="visibility: hidden">0</div>
                    <div class="col s12 l8">
                        <h1>{{ trans('main.welcome') }}</h1>
                        <div class="card-panel content" id="content_card">

                            <a class="waves-effect waves-light btn-large deep-orange" id="upload" href="#upload_modal">
                                <i class="material-icons right">note_add</i>
                                {{ trans('main.upload_button') }}
                            </a>

                            <p class="blue-grey darken-4 text">
                                {{ trans('main.annotation') }}<br>
                                {{ trans('main.formats') }} {{ implode(', ', config('app.file_formats')) }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop