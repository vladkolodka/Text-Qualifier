<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        {{ Config::get('app.name') }}
        @if(isset($page_name))
            | {{ $page_name }}
        @endif
    </title>

    <link rel="stylesheet" href="{{ load('css/materialize.css') }}">
    <link rel="stylesheet" href="{{ load('css/main.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="{{ load('img/favicon.png') }}" type="image/png">

    <script src="{{ load('js/jquery.js') }}"></script>
    <script src={{ load('js/materialize.js') }}></script>

    <script src="{{ load('js/main.js') }}"></script>
</head>
<body>
<nav class="header" id="header">
    <div class="nav-wrapper blue-grey darken-4">
        <a href="{{ route('home') }}" class="brand-logo">
            <div class="hide-on-med-and-down space"></div>
            <img src="{{ load('img/logo.png') }}" alt="" class="responsive-img ">
        </a>

        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="">{{ trans('main.login') }}</a></li>
            <li><a href="">{{ trans('main.about') }}</a></li>
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
</body>
</html>