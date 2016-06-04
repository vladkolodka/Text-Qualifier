@extends('layout.admin')

@section('content')
    <h1>
        {{ $document->name }}
    </h1>
    <a href="{{ URL::previous() }}" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">fast_rewind</i></a>
    <p>
        {{ $document->text }}
    </p>
@stop