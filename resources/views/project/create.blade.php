@extends('project.template')

@section('content')

<div class="jumbotron">
    <div class="container">
        <h1 class="font-orbitron">CREATE NEW PROJECT</h1>
    </div>
</div>

<div class="container">
    {!! Form::open(['route' => 'project.store', 'name' => 'form_create_project', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" ng-model="project.name" ng-required="true" required class="form-control" />
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <textarea name="description" required id="description" cols="30" rows="10" class="form-control" col="2" row="5" ng-model="project.description" ng-required="true" style="resize:none;"></textarea>
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
