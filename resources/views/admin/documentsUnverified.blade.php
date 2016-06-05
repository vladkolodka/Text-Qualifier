@extends('layout.admin')

@section('content')
    @if($documents->currentPage() == $documents->firstItem())
        <a class="waves-effect waves-light btn" href="{{ route('admin::documents.create') }}">{{ trans('admin.new_document') }}</a>
    @endif

    <ul class="collection">
        @foreach($documents as $document)
            <li class="collection-item">
                <div>{{ $document->name }}
                    <a href="{{ route('admin::documents.show', ['document' => $document->id]) }}" class="secondary-content"><i class="material-icons">send</i></a>
                    <a href="{{ route('admin::documents.verify', ['document' => $document->id]) }}" class="secondary-content"><i class="material-icons">thumb_up</i></a>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="center-align">
        {!! $documents->links() !!}
    </div>
@stop