@extends('layouts.main')

@section('title',$role->id ? 'Edit Role - ' . $role->name : 'Create Role')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
    @endsection

@section('content1')
    {!! Form::model($role,['url' => route('admin.roles.store')]) !!}
    {!! Form::hidden('id') !!}
    {!! Form::hidden('guard_name','web') !!}

    <div class="row">
        <div class="col-6 form-group">
            {!! Form::label('name') !!}
            {!! Form::text('name',null,['class' => 'form-control','required']) !!}
        </div>
        <div class="col form-group">
            {!! Form::label('orderval','Order') !!}
            {!! Form::number('orderval',null,['class' => 'form-control','min' => 0]) !!}
        </div>
{{--        <div class="col-6 form-group">
            {!! Form::label('guard_name') !!}
            {!! Form::text('guard_name',null,['class' => 'form-control','required']) !!}
        </div>--}}
    </div>

    <div class="text-center">
        {!! Form::submit('Save',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

@endsection
