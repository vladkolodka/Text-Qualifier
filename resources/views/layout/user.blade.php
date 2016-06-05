<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>
        {{ Config::get('app.name') }}
        @if(isset($page_name))
            | {{ $page_name }}
        @endif
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ load('css/materialize.css') }}">
    <link rel="stylesheet" href="{{ load('css/main.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="{{ load('img/favicon.png') }}" type="image/png">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src={{ load('js/vendor/materialize.js') }}></script>

    @yield('includes')

    <script src="{{ load('js/main.js') }}"></script>
</head>
<body>
<!-- Translation data -->
<div style="display: none;" id="locale_data">
    {{ json_encode(trans('js')) }}
</div>
<nav class="header" id="header">
    <div class="nav-wrapper blue-grey darken-4">
        <a href="{{ route('home') }}" class="brand-logo">
            <div class="hide-on-med-and-down space"></div>
            <img src="{{ load('img/logo.png') }}" alt="" class="responsive-img ">
        </a>

        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="{{ route('admin::home') }}">{{ trans('main.login') }}</a></li>
            <li><a href="{{ route('about') }}">{{ trans('main.about') }}</a></li>
            <li><a href="">{{ trans('main.help') }}</a></li>
            <li>
                <div class="input-field language-selector">
                    <select class="icons" id="language" title="Select language" data-src="{{ route('setLang') }}">
                        <option value="en" data-icon="{{ load('img/us.png') }}" {{ App::isLocale('en') ? 'selected' : '' }} class="left circle">English</option>
                        <option value="ua" data-icon="{{ load('img/ua.png') }}" {{ App::isLocale('ua') ? 'selected' : '' }} class="left circle">Українська</option>
                        <option value="ru" data-icon="{{ load('img/ru.png') }}" {{ App::isLocale('ru') ? 'selected' : '' }} class="left circle">Русский</option>
                    </select>
                    <label>{{ trans('main.select_language') }}</label>
                </div>
            </li>
        </ul>
    </div>
</nav>
@yield('content')
<footer class="page-footer blue-grey darken-3 footer">
    <div class="footer-copyright blue-grey darken-4">
        <div class="container">
            © {{ date("Y") }} Text Qualifier. {{ trans('main.copyright') }} <a href="https://github.com/vladkolodka" target="_blank">Vladyslav Kolodka</a>.
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
        </div>
    </div>

</footer>
</body>
</html>