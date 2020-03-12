@extends('layouts.main')

@section('title', session()->get('title',__('Unauthorized Access')))

@php $activeMenu = ''; @endphp
@section('content1')
    <h3 class="text-center" style="margin-top: 30px;">
        @lang('You do not have permissions to access this section')
    </h3>
@endsection
