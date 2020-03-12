@extends('layouts.main',['activeMenu' => 'classroom'])

@section('title', 'Classroom')

@section('content1')
    <div class="well-default-trans">
        <div class="col-md-12">
            <h1 class="CourseHeading">My Courses</h1>
        </div>
        <div class="col-md-12">
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-md-4">
                        <div class="course-box" style="background-image: url('{{ fileUrl($course->image_path) }}')">
                            <div class="col-md-12">
                                <div class="course_title">{{$course->name}}</div>
                                <div class="course_action">
                                    <a href="{{ route('employee.classroom.chapters',$course->id) }}" class=" course_action_btn">Enter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
