@extends('category.template')

@section('content')

@if(Session::has('success'))
<div class="alert alert-fixed alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    {{ Session::get('success') }}
</div>
@endif

<div class="jumbotron">
    <div class="container">
        <h1>All Categories <a href="{{ route('category.create') }}" class="btn btn-primary">CREATE</a> <a href="{{ route('category.index', ['trashed' => true]) }}" class="btn btn-info btn-sm">With Trashed</a></h1>
    </div>
</div>
<ul class="list-group container">

@foreach($categories as $category)
    <li class="list-group-item clearfix row @if($category->trashed()) list-group-item-danger @endif">

        <div class="col-md-8">
            <h3 class="no-margin">{{ $category->name }}&nbsp;&nbsp;<small>{{ $category->slug }}</small></h3>
        </div>
        <div class="col-md-4 text-right">
            @if($category->trashed())
            {!! Form::open(['url' => route('category.update', $category->id), 'method' => 'PATCH', 'style' => 'display:inline-block']) !!}
                <input type="hidden" name="restore" value="true" />
                <button type="submit" class="btn btn-warning btn-sm">ENABLE</button>
            {!! Form::close() !!}
            @else
            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-info btn-sm">EDIT</a>
            @endif
            {!! Form::open(['onsubmit' => 'return areYouSureToDelete(event)', 'url' => route('category.destroy', $category->id), 'method' => 'DELETE', 'style' => 'display:inline-block']) !!}
                <button type="submit" class="btn btn-danger btn-sm">DELETE</button>

            {!! Form::close() !!}
        </div>


    </li>
@endforeach

</ul>


@stop