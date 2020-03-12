@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', $companyName . ' Courses')

@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
            <div class="mileage inner-tab-box">
                <div class="col-md-12">
                    <div class="col-sm-12" id="pending_div">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ route('admin.classroom.create',['c' => $company]) }}" class="_new_icon_button_1" , style="padding : 7px 12px"> <i class="fa fa-plus"></i> </a>
                            </div>
                            <div class="col-sm-12">
                                <table class="table _table _table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-left">Course</th>
                                        <th class="text-center">Chapters (edit)</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="return_mileagelist">
                                    @php
                                        $delSection = 'classroom';
                                        $curSubject = '';
                                    @endphp
                                    @foreach ($courses AS $course)
                                        @php
                                            $prevSubject = $curSubject;
                                            $curSubject = $course->subject;
                                        @endphp
                                        @if ($prevSubject != $curSubject)
                                            <tr>
                                                <th colspan="4">
                                                    {{ $curSubject }}
                                                </th>
                                            </tr>
                                        @endif
                                        <tr class="del-{{ $delSection }}-{{ $course->id }}">
                                            <td> <a href="{{ route('admin.classroom.edit',$course->id) }}">{{ $course->name }}</a> </td>
                                            <td class="text-center"><a href="{{ route('admin.classroom.chapter.list',$course->id) }}">{{ $course->chapters_count }}</a> </td>
                                            <td class="text-center">{{ $course->created_at->format('M d, Y') }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('admin.classroom.edit',$course->id) }}">EDIT</a>
                                                <a title="Course User" class="down deletejson" data-token="{{ csrf_token() }}" data-url="{{ route('admin.classroom.destroy',$course->id) }}" data-id="{{ $course->id }}"
                                                   data-section="{{ $delSection }}">DELETE</a>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

