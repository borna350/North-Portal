@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', 'Edit Course')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index',['c' => $classroom->company]) }}">Courses</a>
    </li>
@endsection

@section('content1')

    {{ Form::model($classroom,['url' => route('admin.classroom.store'),'files' => true]) }}
    {{ Form::hidden('id') }}
    {{ Form::hidden('company') }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-4">
                    <div class="text_outer">
                        {{ Form::label('subject') }}
                        {{ Form::select('subject',[0 => '-- New Subject'] + \App\Models\ClassroomCourse::groupBy('subject')->orderBy('subject')->pluck('subject','subject')->toArray(),null,['class' => 'select_status form-control','placeholder' => '-- Select Subject --','required']) }}
                    </div>
                    <div class="text_outer" id="new-subject-container" style="display: none">
                        {{ Form::label('new_subject') }}
                        {{ Form::text('new_subject',null,['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="text_outer">
                        {{ Form::label('name','Course Name') }}
                        {{ Form::text('name',null,['class' => 'form-control','required']) }}
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="col-md-12 col-sm-12 image-chooser">
                        <div class="image-chooser-preview"></div>
                        <div class="text_outer">
                        {!! Html::decode(Form::label('s3_path', '<i class="fa fa-file-pdf-o"></i>PDF Instruction Upload'))!!}
                        {{ Form::file('s3_path', array('class' => 'form-control _input_choose_file', 'onchange' => 'renderChoosedFile(this)')) }}
                        <br>
                        @if ($classroom->s3_path)<small><a target="_blank" href="{{ fileUrl($classroom->s3_path, true) }}">{{ $classroom->s3_path }}</a></small>@endif
                    </div>
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="col-md-12 col-sm-12 image-chooser">
                        <div class="image-chooser-preview"></div>
                        <div class="text_outer">
                            {!! Html::decode(Form::label('image_path', '<i class="fa fa-fw fa-photo"></i>Image Upload'))!!}
                            {{ Form::file('image_path', array('class' => 'form-control _input_choose_file', 'onchange' => 'renderChoosedFile(this)')) }}
                            <br>
                            @if ($classroom->image_path) <img src="{{ fileUrl($classroom->image_path) }}" width="50" height="50">@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header">Assign To:</div>
        <div class="card-body">
            <table class="table table-bordered" id="assignment-list">
                @if ($classroom)
                    @foreach ($classroom->assignments()->with('user:id,name')->get() AS $assignment)
                        <tr id="assignment-{{ $assignment->id }}">
                            <td>
                                {{ Form::hidden('deleteList[]',null,['class' => 'delete-list']) }}
                                {{ $assignment->user->name }}
                            </td>
                            <td class="text-center"> <a class="" href="{{ route('admin.classroom.view-results',[$assignment->user_id,$assignment->classroom_course_id]) }}">View Results</a></td>
                            <td class="text-center"> <a class="down deletejson remove-assignment" href="#" data-id="{{ $assignment->id }}">DELETE</a> </td>
                        </tr>
                    @endforeach
                @endif
            </table>
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn-dark contact_btn">Save </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-4">
                    <div class="text_outer">
                        {{ Form::select('user_id',$users,null,['class' => 'select_status form-control','id' => 'user-list','placeholder' => '-- Select Employee --']) }}
                    </div>
                </div>
                <div class="col">
                    <a href="#" id="add-user" class="_new_icon_button_1" , style="padding : 7px 12px; float: left"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
    <table id="hidden-table" class="d-none">
        <tr>
            <td>
                {{ Form::hidden('userList[]') }}
                <span class="name"></span>
            </td>
            <td></td>
            <td class="text-center">
                <a href="#" class="down deletejson" onclick="$(this).parent().parent().remove(); return false;">DELETE</a>
            </td>
        </tr>
    </table>
@stop

@push('scripts')
    <!-- show "new subject" -->
    <script type="text/javascript">
        $('#subject').change(function () {
            const $val = $(this).val();

            if ($val === '0') {
                $('#new-subject-container').show();
                $('input[name=new_subject]').attr('required', true);
            } else {
                $('#new-subject-container').hide();
                $('input[name=new_subject]').attr('required', false).val('');
            }
        });

        $('#add-user').click(function ($e) {
            $e.preventDefault();
            const $userList = $('#user-list');
            const $val = $userList.val();
            const $name = $userList.find(':selected').text();
            if ($val) {
                let $tr = $('#hidden-table tr').clone();
                $tr.find('input').val($val);
                $tr.find('.name').html($name);
                $tr.appendTo('#assignment-list');
            }
        });

        $('.remove-assignment').click(function ($e) {
            $e.preventDefault();
            const $id = $(this).data('id');
            const $tr = $('#assignment-' + $id);
            $tr.find('.delete-list').val($id);
            $tr.fadeOut();
        });
    </script>
@endpush
