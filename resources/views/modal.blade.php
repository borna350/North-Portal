<div id="upload-modal1" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    <form id="" action="{{ route('reset_apssword') }}" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text_outer file_upload" style="height: 60px;">
                                    {{ Form::label('name', 'Password') }}
                                    {{ Form::text('password', null, array('class' => 'form-control', 'maxlength' => 6, 'required' => 'required', 'style' => 'height: 30px;')) }}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Reset</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="show_modal_agreement" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    {!! Form::open(['url' => route('agreements.store'), 'files' => true]) !!}
                        {!! Form::hidden('employee_id',null,['id' => 'employee_id_modal']) !!}
                        {!! Form::hidden('agreement_type',null,['id' => 'agreement_type']) !!}
                        <div class="row">
                            <div class="col-md-12 image-chooser">
                                <div class="image-chooser-preview"></div>
                                <div class="text_outer">
                                    {!! Html::decode(Form::label('agreement_file', '<i class="fa fa-fw fa-photo"></i>Upload Agreement'))!!}
                                    {{ Form::file('agreement_file', array('class' => 'form-control _input_choose_file', 'id' => 'agreement_file', 'onChange' => 'renderChoosedFile(this)')) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    {!! Form::checkbox('is_amendment',1,null,['class' => 'form-check-input','id' => 'is-amendment']) !!}
                                    {!! Form::label('is-amendment','Is Amendment') !!}
                                </div>
                                <small>Applies to Agreements Only (not Codes of Conduct)</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit" class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Agreement</span>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
