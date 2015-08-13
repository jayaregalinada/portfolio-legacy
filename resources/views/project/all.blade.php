@extends('project.template')

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
        <h1>All Projects @if(isset($category)) <small>{{ $category->name }}</small> @endif<a href="{{ route('project.create') }}" class="btn btn-primary">CREATE</a></h1>
    </div>
</div>
<ul class="list-group container">

@foreach($projects as $project)
    <li class="list-group-item clearfix row">

        <div class="col-md-8">
            <h3 class="no-margin">{{ $project->name }}</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('project.edit', $project->id) }}" class="btn btn-info btn-sm">EDIT</a>
            @if(isset($category))
            {!! Form::open(['onsubmit' => 'return areYouSureToDelete(event)', 'url' => route('category.delete.project', [$category->id, $project->id]), 'method' => 'DELETE', 'style' => 'display:inline-block']) !!}
                <button type="submit" class="btn btn-warning btn-sm">REMOVE IN CATEGORY</button>
            @else
            {!! Form::open(['onsubmit' => 'return areYouSureToDelete(event)', 'url' => route('project.destroy', $project->id), 'method' => 'DELETE', 'style' => 'display:inline-block']) !!}
                <button type="submit" class="btn btn-warning btn-sm">DELETE</button>
            @endif

            {!! Form::close() !!}
        </div>


    </li>
@endforeach

</ul>


@stop