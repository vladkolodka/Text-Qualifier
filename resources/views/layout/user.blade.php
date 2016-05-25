<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <link href="{{ load('img/favicon.png') }}" rel="shortcut icon" type="image/png" />

    <script src="{{ load('js/jquery.js') }}"></script>

    <title>
        {{ Config::get('app.name') }}
        @if(isset($page_name))
            | {{ $page_name }}
        @endif
    </title>
</head>
<body>
@yield('content')
</body>
</html>