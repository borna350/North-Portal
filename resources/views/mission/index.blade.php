@extends('layouts.main')

@section('title', '49 north mission')

@section('content1')
    <div class="well-default-trans">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <h3>
                        <span class="active-span" id="pending_span">Active Missions </span>
                    </h3>
                </div>
            </div>
            <div class="col-sm-10">

            </div>
            <div class="col-sm-12">
            @if($mission)
                @if(auth()->user()->is_admin == 1)
                {{ Form::open(array('route' => array('missions.update', $mission->id), 'enctype' => 'multipart/form-data', 'method' => 'post')) }}
                    @method('put')
                    @csrf
                    <div class="form-group image-chooser">
                        <div class="image-chooser-preview"></div>
                        <div class="text_outer">
                            {!! Html::decode(Form::label('agreement_file', '<i class="fa fa-fw fa-photo"></i>Upload File'))!!}
                            {{ Form::file('file', array('class' => 'form-control _input_choose_file', 'onchange' => 'renderChoosedFile(this)')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-dark contact_btn">Save</button>
                    </div>
                {{ Form::close() }}
                @endif
                <iframe src="{{ fileUrl($mission->file, true) }}" style="width: 100%;"></iframe>
            @else

            <h3>No file has been uploaded yet.</h3>
            @if(auth()->user()->is_admin == 1)
            {{ Form::open(array('route' => 'missions.store', 'method' => 'post', 'enctype' => 'multipart/form-data')) }}
                @csrf
                <div class="form-group image-chooser">
                    <div class="image-chooser-preview"></div>
                    <div class="text_outer">
                        {!! Html::decode(Form::label('agreement_file', '<i class="fa fa-fw fa-photo"></i>Upload File'))!!}
                        {{ Form::file('file', array('class' => 'form-control _input_choose_file', 'onchange' => 'renderChoosedFile(this)')) }}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-dark contact_btn">Save</button>
                </div>
            {{ Form::close() }}
            @endif
            @endif
            </div>
        </div>
    </div>
@endsection
