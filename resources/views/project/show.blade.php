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

<div class="jumbotron" style="background-image:url({{ $project->thumbnail[0]['url'] }});background-size:cover;background-position:center;">
    <div class="container">
        <h1 class="font-orbitron">{{ $project->name }}</h1>
        <br />
        <div>{!! $project->description !!}</div>
    </div>
</div>






@stop