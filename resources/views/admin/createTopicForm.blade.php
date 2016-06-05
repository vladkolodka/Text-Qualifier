@extends('layout.admin')

@section('content')
    @if(Session::has('result'))
        <div class="info">
            {{ Session::get('result') }}
        </div>
    @endif

    <form action="{{ route('admin::topics.store') }}" method="post">
        {{ csrf_field() }}
        {{ $errors->first('name') }}

        <div class="row">
            <div class="input-field col s12 l8">
                <input id="name" type="text" class="validate" name="name" required>
                <label class="active" for="name">{{ trans('admin.topic_name') }}</label>
            </div>
            <div class="input-field col s12 l4">
                <select name="language">
                    <option value="en" selected>{{ trans('main.lang_en') }}</option>
                    <option value="ru">{{ trans('main.lang_ru') }}</option>
                </select>
                <label>{{ trans('admin.select_topic_language') }}</label>
            </div>
        </div>


        <input type="submit" class="waves-effect waves-light btn" value="{{ trans('admin.create') }}">
    </form>
@stop