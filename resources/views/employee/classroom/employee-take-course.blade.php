@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', $chapter->chapter_name . ' - ' . $section->section_name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('employee.classroom.courses') }}">Courses</a></li>
    <li class="breadcrumb-item"><a href="{{ route('employee.classroom.chapters',$chapter->classroom_course_id) }}">{{ $chapter->classroomCourse->name }}</a></li>
@endsection

@section('content1')
    {{ Form::open(['url' => route('employee.classroom.save')]) }}
    {{ Form::hidden('section',$section->id) }}
    {{ Form::hidden('chapter',$chapter->id) }}
    {{ Form::hidden('qid',$question->id) }}

    @php
        $answers = null;
        if (isset($question->questions)) {
            $json = json_decode($question->questions);
            $answers = $json->answers??null;
        }
        $isAnswered = isset($question->classroomAnswers->answer);
        $userAnswer = $isAnswered ? $question->classroomAnswers->answer : null;
    @endphp
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3  text-center">
            <h3 style="margin-top: 30px;">{{ $chapter->chapter_name }}</h3>
            <h4>{{ $section->section_name }}</h4>
            <h5 style="margin-top: 30px;">{{ $question->question }}</h5>
            {{-- Audio --}}
            @if ($question->question_type == 'audio')
                {!! $question->question_details->audio !!}
                <br><br>
                {{ Form::label('notes-' . $question->id,'Audio Notes') }}
                {{ Form::textarea('text[' . $question->id .']',$userAnswer,['class' => 'form-control','required','id' => 'notes-' . $question->id]) }}
                {{-- Radio Buttons --}}
            @elseif ($question->question_type == 'radio')
                @foreach ($question->question_details->questions??[] AS $key => $response)
                    <div class="form-check">
                        @if ($isAnswered && $userAnswer == $response)
                            {{ Form::hidden('text[' . $question->id . ']',$response) }}
                        @endif

                        {{ Form::radio('text[' . $question->id . ']',$response,$userAnswer == $response,['class' => 'form-check-input','required','id' => 'radio-' . $question->id .'-'.$loop->iteration, 'disabled' => $isAnswered]) }}
                        {{ Form::label('radio-' . $question->id .'-'.$loop->iteration,$response,['class' => 'form-check-label']) }}
                        @if ($isAnswered && $answers == $loop->iteration)
                            @if ($userAnswer == $response)
                                <span class="text-success">Correct</span>
                            @else
                                <span class="text-danger">Correct Answer</span>
                            @endif
                        @endif
                    </div>
                @endforeach
                {{-- Checkboxes --}}
            @elseif ($question->question_type == 'checkbox')

                @foreach ($question->question_details->questions??[] AS $key => $response)
                    @if ($isAnswered && $question->checkCheckboxAnswer($response))
                        {{ Form::hidden('text[' . $question->id . '][]',$response) }}
                    @endif
                    <div class="form-check">
                        {{ Form::checkbox('text[' . $question->id . '][]',$response,$question->checkCheckboxAnswer($response),['class' => 'form-check-input','id' => 'check-' . $question->id .'-'.$loop->iteration,'disabled' => $isAnswered]) }}
                        {{ Form::label('check-' . $question->id.'-'.$loop->iteration,$response,['class' => 'form-check-label']) }}
                        @if ($isAnswered && isset($answers->{$loop->iteration}))
                            @if ($question->checkCheckboxAnswer($response))
                                <span class="text-success">Correct</span>
                            @else
                                <span class="text-danger">Correct Answer</span>
                            @endif
                        @endif
                    </div>
                @endforeach
                {{-- textbox --}}
            @elseif ($question->question_type == 'textbox')
                <div class="text_outer">
                {{ Form::textarea('text[' . $question->id .']',$userAnswer,['class' => 'form-control','required','style' => 'min-height: 100px','id' => 'notes-' . $question->id, 'readonly' => $isAnswered]) }}
                </div>
                @if ($isAnswered)
                    <div class="text-left">
                        <h6>Answer</h6>
                        <p>{!! $answers ? nl2br($answers) : 'No Answer Provided' !!}</p>
                    </div>
                @endif
            @endif

            <div class="text-center" style="margin-top: 30px;">
                {{--@if (isset($question->classroomAnswers->answer))
                    {{ Form::submit('Continue =>',['class' => 'btn btn-primary']) }}
                @else
                    {{ Form::submit('Save',['class' => 'btn btn-outline-secondary','name' => 'stay']) }}
                @endif--}}

                <button type="submit" class="btn-dark contact_btn">Continue => </button>
            </div>
            <div class="progress" style="margin-top: 70px">
                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

@stop
