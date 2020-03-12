@extends('layouts.main')

@section('title',$permission->id ? 'Edit Permission - ' . $permission->name : 'Create Permission')

@section('content1')
    {!! Form::model($permission,['url' => route('admin.permissions.store')]) !!}
    {!! Form::hidden('id') !!}
    {!! Form::hidden('guard_name','web') !!}

    <div class="row">
        <div class="col form-group">
            {!! Form::label('name') !!}
            {!! Form::text('name',null,['class' => 'form-control','required','placeholder' => 'ie. chapter-edit']) !!}
        </div>
        <div class="col form-group">
            {!! Form::label('role','Select Role') !!}
            {!! Form::select('role',$roles,$rolePermissions??0,['class' => 'form-control','required','placeholder' => '-- Select Role --']) !!}
        </div>
        <div class="col form-group">
            {!! Form::label('orderval','Order') !!}
            {!! Form::number('orderval',null,['class' => 'form-control','min' => 0]) !!}
        </div>
    </div>

    <div class="text-center">
        {!! Form::submit('Save',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

@endsection
