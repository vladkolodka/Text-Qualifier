@extends('layout.admin')

@section('content')
    @if($topics->currentPage() == $topics->firstItem())
        <a class="waves-effect waves-light btn" href="{{ route('admin::topics.create') }}">{{ trans('admin.new_topic') }}</a>
    @endif
    <ul class="collection">
        @foreach($topics as $topic)
            <li class="collection-item">
                <div>{{ $topic->name }}<a href="{{ route('admin::topics.show', ['topic' => $topic->id]) }}"
                                          class="secondary-content"><i class="material-icons">send</i></a>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="center-align">
        {!! $topics->links() !!}
    </div>
@stop