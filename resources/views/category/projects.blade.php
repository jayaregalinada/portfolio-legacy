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
        <h1>{{ $category->name }} <a href="{{ route('project.create') }}" class="btn btn-primary">CREATE PROJECT</a></h1>
        <div>
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm">MAIN MENU</a>
            <a href="{{ route('category.show', $category->id) }}" class="btn btn-info btn-sm">EDIT CATEGORY</a>
        </div>
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

            @if(in_array($project->id, $category->projects()->get()->lists('id')))
            {!! Form::open(['onsubmit' => 'return areYouSureToDelete(event)', 'url' => route('category.delete.project', [$category->id, $project->id]), 'method' => 'DELETE', 'style' => 'display:inline-block']) !!}
                <input type="hidden" name="redirect" value="{{ URL::current() }}" />
                <button type="submit" class="btn btn-danger btn-sm">REMOVE</button>
            @else

            {!! Form::open(['url' => route('category.store.projects', $category->id), 'method' => 'POST', 'style' => 'display:inline-block']) !!}
                <input type="hidden" name="project" value="{{ $project->id }}" />
                <button type="submit" class="btn btn-sucess btn-sm">ADD</button>

            @endif

            {!! Form::close() !!}
        </div>


    </li>
@endforeach

</ul>


@stop