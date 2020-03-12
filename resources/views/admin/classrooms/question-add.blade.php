@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', 'Add Question')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index',['c' => $chapter->classroomCourse->company]) }}">Courses</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.chapter.list',$chapter->classroom_course_id) }}">{{ $chapter->classroomCourse->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.chapter.edit',$chapter->id) }}">{{ $chapter->chapter_name }}</a></li>
@endsection

@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane inner-tab-box">
            <div class="col-md-12">
                {{ Form::model($question,['url' => route('admin.classroom.chapter.save-question',$chapter->id)]) }}
                {{ Form::hidden('id') }}
                {{ Form::hidden('question_type') }}

                <div class="row">
                    <div class="col">
                        <div class="text_outer">
                            {{ Form::label('question') }}
                            {{ Form::text('question',null,['class' => 'form-control','required']) }}
                        </div>
                    </div>
                    <div class="col">
                        <div class="text_outer">
                            {{ Form::label('classroom_section_id','Section') }}
                            {{ Form::select('classroom_section_id',[0 => 'New Section -->'] + $sections,null,['class' => 'form-control','required', 'placeholder' => '-- Select Section --']) }}
                        </div>
                    </div>
                    <div class="col section-container" style="display: none">
                        <div class="text_outer">
                            {{ Form::label('new_section') }}
                            {{ Form::text('new_section',null,['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col section-container" style="display:none">
                        <div class="text_outer">
                            {{ Form::label('section_order') }}
                            {{ Form::number('section_order',$sectionNextVal,['min' => 0,'class' => 'form-control']) }}
                        </div>
                    </div>
                </div>

                @if ($question->question_type == 'radio' || $question->question_type == 'checkbox')
                    <div id="question-table">
                        @foreach ($question->questionsText AS $text)

                            <div class="form-group form-check">
                                <div class="row">
                                    @if ($question->question_type == 'radio')
                                        <div class="col-1">
                                            {{ Form::radio('buttons',$loop->iteration,$question->answers??false,['class' => 'form-check-input']) }}
                                        </div>
                                    @else
                                        <div class="col-1">
                                            {{ Form::checkbox('buttons[' . $loop->iteration .']',$loop->iteration,$question->answers->{$loop->iteration}??false,['class' => 'form-check-input']) }}
                                        </div>
                                    @endif
                                        <div class="text_outer">
                                            {{ Form::text('questionsText[' . $loop->iteration .']',$text,['required','class' => 'form-control col-8']) }}
                                        </div>
                                    <div class="col-2">
                                        <a class="text-danger" href="#" onclick="$(this).parent().remove(); return false;"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-right">
                        <a href="#" class="btn btn-outline-secondary" id="add-question">Add Responses <i class="fa fa-plus"></i></a>
                    </div>

                @elseif ($question->question_type == 'audio')
                    <div class="text_outer">
                        {{ Form::label('Audio Link') }}
                        {{ Form::text('questionsText[audio]',$question->audio,['class' => 'form-control','required']) }}
                    </div>
                @elseif ($question->question_type == 'textbox')
                    <div class="text_outer">
                        {{ Form::label('answer') }}
                        {{ Form::textarea('answer',$question->answers,['class' => 'form-control', 'style' => 'height:100px', 'required']) }}
                    </div>
                @endif

                <div class="text-center">
                    <button type="submit" class="btn-dark contact_btn" style="margin: 0">Save</button>
                </div>

                {{ Form::close() }}

                <div id="hidden-options" class="d-none">
                    <div class="form-group form-check">
                        <div class="row">
                            @if ($question->question_type == 'radio')
                                <div class="col-1">
                                    {{ Form::radio('buttons[]',null,null,['class' => 'form-check-input']) }}
                                </div>
                                {{ Form::text('questionsText[]',null,['required','class' => 'form-control col-8']) }}
                            @elseif ($question->question_type == 'checkbox')
                                <div class="col-1">
                                    {{ Form::checkbox('buttons[]',null,null,['class' => 'form-check-input']) }}
                                </div>
                                {{ Form::text('questionsText[]',null,['required','class' => 'form-control col-8']) }}
                            @endif
                            <div class="col-3">
                                <a class="text-danger" href="#" onclick="$(this).parent().remove(); return false;"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <!-- add radio / checkbox options -->
    <script type="text/javascript">
        $('#add-question').click(function ($e) {
            $e.preventDefault();
            $('#hidden-options .form-check').clone().appendTo('#question-table');
        });

        $('#classroom_section_id').change(function () {
            const $val = $(this).val();
            if ($val === '0') {
                $('.section-container').show();
                $('.section-container input').attr('required', true);
            } else {
                $('.section-container').hide();
                $('.section-container input').attr('required', false).val('');
            }
        });
    </script>
@endpush
