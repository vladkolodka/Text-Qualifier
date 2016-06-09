<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="file">
    <input type="text" name="language" value="ru">
    <input type="text" name="save" value="0">
    <input type="submit">
</form>
</body>
</html>