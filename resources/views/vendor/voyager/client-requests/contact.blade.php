
@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop



@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i>

        {{ __('voyager::generic.SendEmail') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')

@section('content')

<div class="page-content edit-add container-fluid">
    
    
    
    <div class="row">
        
    
        <div class="col-md-12">
            
        </div>
    
        
        <div class="col-md-12">
            
            <div class="panel panel-bordered">
            
            <div class="alert alert-warning">
                {{ $clientRequest->description }}
            </div>


@if(Session::has('success'))
   <div class="alert alert-success">
     {{ Session::get('success') }}
   </div>
@endif

{!! Form::open(['route'=>'voyager.client-requests.postmail', 'class'=>'form-edit-add']) !!}

<div class="panel-body">

<div class="form-group col-md-12 {{ $errors->has('subject') ? 'has-error' : '' }}">
        {!! Form::label('subject',  'موضوع الرسالة' , ['class'=>'control-label']) !!}
        {!! Form::text('subject', old('subject'), ['class'=>'form-control', 'placeholder'=> 'موضوع الرسالة' ]) !!}
    <span class="text-danger">{{ $errors->first('subject') }}</span>
</div>


{{ Form::hidden('message_id', $id ) }}

<div class="form-group col-md-12 {{ $errors->has('message') ? 'has-error' : '' }}">
    {!! Form::label('message',  ' الرسالة' , ['class'=>'control-label']) !!}
    {!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'الرسالة']) !!}
    <span class="text-danger">{{ $errors->first('message') }}</span>
</div>

<div class="form-group col-md-12">
<button class="btn btn-success"> إرسال الرسالة </button>
</div>

</div>
{!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
