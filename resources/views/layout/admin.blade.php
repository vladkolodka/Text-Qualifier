<!doctype html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ load('css/materialize.css') }}">
    <link rel="stylesheet" href="{{ load('css/main.css') }}">
    <link rel="stylesheet" href="{{ load('css/admin.css') }}">
    <link rel="shortcut icon" href="{{ load('img/favicon.png') }}" type="image/png">

    <script src="{{ load('js/vendor/jquery.js') }}"></script>
    <script src="{{ load('js/vendor/materialize.js') }}"></script>
    <script src="{{ load('js/main.js') }}"></script>

    @yield('includes')
    <title>
        {{ Config::get('app.name') }} | {{ trans('admin.panel_name') }}
    </title>
</head>
<body>
<div style="display: none;" id="locale_data">
    {{ json_encode(trans('js')) }}
</div>

<nav class="header" id="header">
    <div class="nav-wrapper blue-grey darken-4">
        <a href="{{ route('admin::home') }}" class="brand-logo">
            <div class="hide-on-med-and-down space"></div>
            <img src="{{ load('img/logo.png') }}" alt="" class="responsive-img ">
            <span class="hide-on-med-and-down">{{ trans('admin.panel_name') }}</span>
        </a>

        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="{{ route('home') }}">{{ trans('admin.logout') }}</a></li>
            <li>
                <div class="input-field language-selector">
                    <select class="icons" id="language" title="Select language" data-src="{{ route('setLang') }}">
                        <option value="en" data-icon="{{ load('img/us.png') }}"
                                {{ App::isLocale('en') ? 'selected' : '' }} class="left circle">English
                        </option>
                        <option value="ua" data-icon="{{ load('img/ua.png') }}"
                                {{ App::isLocale('ua') ? 'selected' : '' }} class="left circle">Українська
                        </option>
                        <option value="ru" data-icon="{{ load('img/ru.png') }}"
                                {{ App::isLocale('ru') ? 'selected' : '' }} class="left circle">Русский
                        </option>
                    </select>
                    <label>{{ trans('main.select_language') }}</label>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="row">
    <div class="col s12 l2">
        <div class="collection">
            <a href="{{ route('admin::topics.index') }}" class="collection-item{{ Request::is('topics') ? ' active' : '' }}">{{ trans('admin.topics') }}</a>
            <a href="{{ route('admin::documents.index') }}" class="collection-item{{ Request::is('documents]') ? ' active' : '' }}">{{ trans('admin.documents') }}</a>
            <a href="#!" class="collection-item {{ Request::is('utils') ? ' active' : '' }}">{{ trans('admin.utils') }}</a>
        </div>
    </div>
    <div class="col s12 l10">
        <div class="card-panel white page-content">
            <h2>{{ $page_title or 'No title' }}</h2>
            @yield('content')
        </div>
    </div>
</div>


</body>
</html>