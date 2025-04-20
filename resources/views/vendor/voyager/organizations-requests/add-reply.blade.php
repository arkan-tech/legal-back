
@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop



@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i>

        {{ __('voyager::generic.SendConsultationReply') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')

@section('content')

<div class="page-content edit-add container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">

@if(Session::has('success'))
   <div class="alert alert-success">
     {{ Session::get('success') }}
   </div>
@endif

{!! Form::open(['route'=>'voyager.organizations-requests.postreply', 'class'=>'form-edit-add']) !!}

<div class="panel-body">


{{ Form::hidden('request_id', $consultation->id ) }}

<div class="form-group col-md-12 {{ $errors->has('message') ? 'has-error' : '' }}">
    {!! Form::label('message',  ' الرد' , ['class'=>'control-label']) !!}
    {!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'الرد']) !!}
    <span class="text-danger">{{ $errors->first('message') }}</span>
</div>

<div class="form-group col-md-12">
<button class="btn btn-success"> إرسال الرد </button>
</div>

</div>
{!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
