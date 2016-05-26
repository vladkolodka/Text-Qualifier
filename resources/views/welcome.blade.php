@extends('layout.user')

@section('content')
    <section class="main">
        <div class="valign-wrapper responsive-img" id="content">
            <div class="valign center-align">
                <div class="row">

                    <div class="col s0 m2" style="visibility: hidden">0</div>
                    <div class="col s12 m8">
                        <h1>{{ trans('main.welcome') }}</h1>
                        <div class="card-panel content" id="content_card">

                            <a class="waves-effect waves-light btn-large deep-orange" id="upload">
                                <i class="material-icons right">note_add</i>
                                {{ trans('main.upload_button') }}
                            </a>
                            <p class="blue-grey darken-4">
                                {{ trans('main.annotation') }}<br>
                                {{ trans('main.formats') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop