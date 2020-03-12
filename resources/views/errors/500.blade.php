@extends('layouts.main')

@section('code', session()->get('code','500'))
@section('title', session()->get('title',__('Server Error')))

@section('message', ($exception->getMessage()?$exception->getMessage():'').'. '.__('The server did not like this request.  IT has been notified.'))
