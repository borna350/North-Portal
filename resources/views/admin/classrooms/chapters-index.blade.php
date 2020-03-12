@extends('layouts.main', ['activeMenu' => 'classroom'])

@section('title', $course->name . ' Chapters')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index', ['c' => $course->company]) }}">Courses</a></li>
@endsection

@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane inner-tab-box">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h2>
                            <span class="active-span clickable">{{ $course->name }}</span>
                        </h2>
                    </div>
                    <div class="col-md-6 mb-4">
                        <a href="{{ route('admin.classroom.chapter.create',$course->id) }}" class="_new_icon_button_1" style="padding: 7px 12px"><i class="fa fa-plus"></i> </a>
                    </div>
                    <div class="col-md-12">
                        {{ Form::open(['url' => route('admin.classroom.chapter.update-chapter-order')]) }}
                        <table class="table _table _table-bordered">
                            <thead>
                            <tr>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $delSection = 'chapter';
                            @endphp
                            @foreach ($course->chapters AS $chapter)
                                <tr class="del-{{ $delSection }}-{{ $chapter->id }}">
                                    <td class="text-center">{{ Form::number('orderval[' . $chapter->id . ']',$chapter->orderval,['class' => 'form-control','min' => 1]) }}</td>
                                    <td><a href="{{ route('admin.classroom.chapter.edit',$chapter->id) }}">{{ $chapter->chapter_name }}</a></td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.classroom.chapter.edit',$chapter->id) }}">EDIT</a>
                                        <a title="Course User" href="javascript:void(0)" class="down deletejson" data-token="{{ csrf_token() }}" data-url="{{ route('admin.classroom.chapter.destroy',$chapter->id) }}" data-id="{{ $chapter->id }}" data-section="{{ $delSection }}">DELETE</a>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                            @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn-dark contact_btn">Update Order</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
