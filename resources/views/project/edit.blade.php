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
        <h1 class="font-orbitron">EDITING <small>{{ $project->name }}</small></h1>
    </div>
</div>

<div class="container">
    <div>
        <a href="{{ route('project.index') }}" class="btn btn-primary btn-sm">MAIN MENU</a>
        <a href="{{ route('project.edit.image', $project->id) }}" class="btn btn-info btn-sm">ADD IMAGE</a>
    </div>
    <hr />

    {!! Form::open(['route' => ['project.update', $project->id], 'method' => 'PATCH', 'name' => 'form_create_project', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" ng-required="true" required class="form-control" value="{{ $project->name }}" ng-value="{{ $project->name }}" />
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <textarea name="description" required id="description" cols="30" rows="10" class="form-control" ng-required="true" value="{{ $project->rawDescription() }}" style="resize:none;">{{ $project->rawDescription() }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn" ng-disabled="form_create_project.$invalid" ng-class="{ 'btn-success': form_create_project.$valid }">SUBMIT</button>

            </div>
        </div>
    {!! Form::close() !!}
</div>

@stop