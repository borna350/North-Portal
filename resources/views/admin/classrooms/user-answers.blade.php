@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', $user->full_name . ' Answers for ' . $chapter->chapter_name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index',['c' => $chapter->classroomCourse->company]) }}">Courses</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.chapter.list',$chapter->classroom_course_id) }}">{{ $chapter->classroomCourse->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.view-results',[$user->id,$chapter->classroomCourse->id]) }}">Chapter List</a></li>
@endsection

@section('content1')
    <h2 class="my-4">
        <span class="active-span clickable">{{ $chapter->chapter_name }}</span>
    </h2>

    <table class="table table-bordered">
        @foreach ($chapter->classroomSections()->with('classroomQuestionsOrder')->get() AS $section)
            <tr>
                <th colspan="2">{{ $section->section_name }}</th>
            </tr>
            @foreach ($section->classroomQuestionsOrder()->with(['answers' => function ($query) use ($user) {
            $query->where('user_id',$user->id);
            }])->get() AS $question)
                <tr>
                    <td width="50%">{{ $question->question }}</td>
                    <td width="50%">{{ $question->answers->answer??null }}</td>
                </tr>
            @endforeach
        @endforeach

    </table>
@stop

