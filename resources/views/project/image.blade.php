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
        <h1 class="font-orbitron">IMAGES <small>{{ $project->name }}</small></h1>
    </div>
</div>

<div class="container">
    <div>
        <a href="{{ route('project.index') }}" class="btn btn-primary btn-sm">MAIN MENU</a>
        <a href="{{ route('project.edit', $project->id) }}" class="btn btn-info btn-sm">EDIT</a>
    </div>
    <hr />
    {!! Form::open(['route' => ['project.store.image', $project->id], 'name' => 'form_add_image', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="form-group">
            <div class="col-sm-10">
                <input type="file" name="file" class="form-control" />
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-success">UPLOAD</button>
            </div>
        </div>
    {!! Form::close() !!}
</div>

@if(!$project->images()->get()->isEmpty())

    <div class="grid clearfix">
        <div class="grid-sizer"></div>
        @foreach($project->images()->get() as $p)
        <div class="grid-item">
            <img src="{{ $p->sizes[0]['url'] }}" alt="{{ $p->caption }}" class="img-responsive" />
        </div>
        @endforeach
    </div>

@endif

@stop
