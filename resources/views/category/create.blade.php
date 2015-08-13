@extends('category.template')

@section('title', ':: CREATE')

@section('content')

<div class="jumbotron">
    <div class="container">
        <h1 class="font-orbitron">CREATE NEW CATEGORY</h1>
    </div>
</div>

<div class="container">
    @if($errors->any())
    <ul class="alert alert-warning list-unstyled">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
    @endif

    {!! Form::open(['route' => 'category.store', 'name' => 'form_create_category', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" ng-model="category.name" ng-required="true" required class="form-control" />
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <textarea name="description" required id="description" cols="30" rows="10" class="form-control" col="2" row="5" ng-model="category.description" ng-required="true" style="resize:none;"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn" ng-disabled="form_create_category.$invalid" ng-class="{ 'btn-success': form_create_category.$valid }">SUBMIT</button>
            </div>
        </div>
    {!! Form::close() !!}
</div>

@stop
