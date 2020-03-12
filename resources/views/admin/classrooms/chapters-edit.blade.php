@extends('layouts.main', ['activeMenu' => 'classroom'])

@section('title', $chapter->name . ' Chapter')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index',['c' => $course->company]) }}">Courses</a>
    </li>
    <li class="breadcrumb-item"><a
            href="{{ route('admin.classroom.chapter.list',$course->id) }}">{{ $course->name }}</a></li>
@endsection

@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
            <div class="col-md-12">
                <div class="col-sm-12">
                    <h4 class="my-4"><span class="active-span clickable">{{ $course->name }}</span></h4>
                </div>
                {!! Form::model($chapter,['url' => route('admin.classroom.chapter.store'),'files' => true]) !!}
                {!! Form::hidden('id') !!}
                {!! Form::hidden('classroom_course_id') !!}
                <div class="col-sm-12" id="pending_div">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('chapter_name') }}
                                        {{ Form::text('chapter_name', null, array('class' => 'form-control', 'required')) }}
                                    </div>
                                </div>
                                <div class="col col-sm-6 image-chooser">
                                    <div class="image-chooser-preview"></div>
                                    <div class="text_outer">
                                        {!! Html::decode(Form::label('s3_path', '<i class="fa fa-file-pdf-o"></i>PDF Instruction Upload'))!!}
                                        {{ Form::file('s3_path', array('class' => 'form-control _input_choose_file', 'accept' => '.pdf', 'onChange' => 'renderChoosedFile(this)')) }}
                                        <br>
                                        @if ($chapter->s3_path)
                                            <small><a target="_blank" href="{{ fileUrl($chapter->s3_path, true) }}">{{ $chapter->s3_path }}</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col col-sm-12">
                                    <div class="text-center">
                                        <button type="submit" class="btn-dark contact_btn" style="margin: 0">Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                @if ($chapter->id)
                    <div class="col-sm-12" id="pending_div">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card" style="margin-top: 30px;">
                                    <div class="card-header">Questions</div>
                                    <div class="card-body">
                                        {!! Form::open(['url' => route('admin.classroom.chapter.add-question',$chapter->id)]) !!}
                                        <div class="row">
                                            <div class="col">
                                                <div class="text_outer">
                                                    {!! Form::select('question_type',\App\Models\ClassroomQuestion::$questionTypes,null,['class' => 'select_status form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn-dark contact_btn" style="margin: 0">Save  </button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}

                                        {!! Form::open(['url' => route('admin.classroom.chapter.update-question-order')]) !!}
                                        <table class="table _table _table-bordered">
                                            @php $delSection = 'question'; @endphp
                                            @foreach ($chapter->classroomSections()->with('classroomQuestionsOrder')->get() AS $section)
                                                <tr>
                                                    <th colspan="4">{{ $section->orderval }} ) {{ $section->section_name }}</th>
                                                </tr>
                                                @foreach ($section->classroomQuestionsOrder AS $question)
                                                    <tr class="del-{{ $delSection }}-{{ $question->id }}">
                                                        <td class="text-center">{!! Form::number('orderval[' . $question->id . ']',$question->orderval,['class' => 'form-control text-center','min' => 1, 'style' => 'min-width: 80px']) !!}</td>
                                                        <td>
                                                            <a href="{{ route('admin.classroom.chapter.edit-question',$question->id) }}">{{ $question->question }}</a>
                                                        </td>
                                                        <td class="text-center">{{ $question->question_type }}</td>
                                                        <td class="text-center" width="15%">
                                                            <a href="{{ route('admin.classroom.chapter.edit-question',$question->id) }}">EDIT</a>
                                                            <a title="Delete User" href="javascript:void(0)" class="down deletejson" data-token="{{ csrf_token() }}" data-url="{{ route('admin.classroom.chapter.destroy-question',$question->id) }}"
                                                               data-id="{{ $question->id }}" data-section="{{ $delSection }}">DELETE</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="spacer"></tr>
                                                @endforeach
                                            @endforeach
                                        </table>
                                        <button type="submit" class="btn-dark contact_btn" style="margin: 0">Update Order </button>
                                        {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
@stop

