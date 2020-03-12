@extends('layouts.main')

@section('title', $user->exists ? 'Edit ' . $user->name : 'Add User')

@section('content1')
    <div class="tab-pane fade show active" id="nav-employee" role="tabpanel" aria-labelledby="nav-employee-tab">

        {{ Form::model($user, ['route' => 'users.store', 'enctype' => 'multipart/form-data']) }}
        {!! Form::hidden('id') !!}

        <div class="personal">
            <h2 class="form_title">Personal Information</h2>
            @if($user->profile_pic)
                <div class="row my-4">
                    <div class="col-md-12">
                        <img src="{{ fileUrl($user->profile_pic) }}" alt="" width="200" height="200">
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('firstname', 'First Name') }}
                        {{ Form::text('firstname', null, array('class' => 'form-control','placeholder'=>'First Name','required'=>'required')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('lastname', 'Last Name') }}
                        {{ Form::text('lastname', null, array('class' => 'form-control','placeholder'=>'Last Name','required'=>'required')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('dob', 'Date of birth') }}
                        {{ Form::date('dob', null, array('class' => 'flatpickr form-control', 'placeholder' => 'Select Date of birth')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('phone_no', 'Phone') }}
                        {{ Form::number('phone_no', null, array('class' => 'form-control','Placeholder'=>"000 000 0000")) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="text_outer">
                        {{ Form::label('address', 'Address') }}
                        {{ Form::text('address', null, array('class' => 'form-control','Placeholder'=>"Address")) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('personalemail', 'Personal email') }}
                        {{ Form::email('personalemail', null, array('class' => 'form-control','Placeholder'=>"Personal email")) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('workemail', 'Work email') }}
                        {{ Form::email('workemail', null, array('class' => 'form-control','Placeholder'=>"Work email",'required'=>'required')) }}
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 image-chooser">
                    <div class="image-chooser-preview"></div>
                    <div class="text_outer">
                        {!! Html::decode(Form::label('profile_pic', '<i class="fa fa-fw fa-photo"></i>Profile photo'))!!}
                        {{ Form::file('profile_pic', array('class' => 'form-control _input_choose_file', 'onchange' => 'renderChoosedFile(this)', 'id' => 'profile_pic')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('name', 'Password*') }}
                        {{ Form::password('password', array('class' => 'form-control','Placeholder' => 'xxxxxxxx', 'id' => 'password', 'required' => $user->id ? false : true)) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <p>**Only required if you are changing your password. Your password must
                        be more than 8 characters long, should contain at least 1 uppercase, 1
                        lowercase, 1 numeric and 1 special character.
                        <a href="javascript:void(0)"  onclick="resetStuffPassword()">Click Reset</a>
                    </p>
                </div>
            </div>
        </div><!--------Personal Information----------->

        <div class="circumstances">
            <h2 class="form_title">Personal Circumstances</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('name', 'Marital status') }}
                        {!!Form::select('marital_status', array('Single' => 'Single', 'Married' => 'Married', 'Common Law' => 'Common Law', 'Rather Not Say' => 'Rather Not Say'), $user->marital_status, ['class'=>'select_status form-control','placeholder'=>'Select'])!!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('no_ofchildren', 'Number of children') }}
                        {{ Form::number('no_ofchildren', null, array('class' => 'form-control','min' => 0)) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text_outer">
                        {{ Form::label('family_inarea', 'Family in the area') }}
                        {{ Form::text('family_inarea', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="text_outer">
                        {{ Form::label('familycircumstance', 'Special family circumstances') }}
                        {{ Form::text('familycircumstance', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('prsnl_belief', 'Personal belief/religious requirements') }}
                        {{ Form::text('prsnl_belief', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
            </div>
        </div><!--------Personal Circumstances----------->

        <div class="health">
            <h2 class="form_title">Health Concerns</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="text_outer">
                        {{ Form::label('known_medical_conditions', 'Known medical conditions') }}
                        {{ Form::text('known_medical_conditions', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text_outer">
                        {{ Form::label('allergies', 'Allergies') }}
                        {{ Form::text('allergies', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('dietary_restrictions', 'Dietary Restrictions') }}
                        {{ Form::text('dietary_restrictions', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('known_health_concerns', 'Known mental health concerns') }}
                        {{ Form::text('known_health_concerns', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text_outer">
                        {{ Form::label('aversion_phyactivity', 'Aversion to physical activity') }}
                        {{ Form::text('aversion_phyactivity', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
            </div>
        </div><!--------Health Concerns----------->

        <div class="emergency">
            <h2 class="form_title">Emergency Contact Information</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('emergency_contact_name', 'Emergency contact name') }}
                        {{ Form::text('emergency_contact_name', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('reltn_emergency_contact', 'Relationship to emergency contact') }}
                        {{ Form::text('reltn_emergency_contact', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('emergency_contact_phone', 'Emergency contact phone') }}
                        {{ Form::text('emergency_contact_phone', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text_outer">
                        {{ Form::label('emergency_contact_email', 'Emergency contact email') }}
                        {{ Form::email('emergency_contact_email', null, array('class' => 'form-control','placeholder'=>'Insert text here')) }}
                    </div>
                </div>
            </div>
        </div><!--------Emergency Contact Information----------->

        <div class="emergency">
            <h2 class="form_title">Company</h2>
            <div class="col-md-3">
                <div class="text_outer">
                    {{ Form::label('company_id', 'Company') }}
                    @php
                        $data = [];
                    @endphp
                    @foreach($companies as $company)
                        @php
                            $data[$company->id] = $company->companyname;
                        @endphp
                    @endforeach
                    {!! Form::select('company_id', $data, '', ['class' => 'select_status form-control', $user->company_id && $user->company_id == $company->id ? 'selected' : '']) !!}
                </div>
            </div>
            @if($user->is_admin)
                <h2 class="form_title">Ticket Admin</h2>
                <div class='col-md-3'>
                    <div class="text_outer">
                        <label class="custom-checkbox form-check-label">
                            {!! Form::checkbox('is_ticket_admin', 1, false, array('class' => 'form-check-input', 'checked' => $user->user->is_ticket_admin ? true : false)) !!}Is Ticket Admin
                        </label>
                    </div>
                </div>
            @endif
        </div>

        @if(auth()->user()->is_admin == 1)
            <div class="emergency">
                <h2 class="form_title">Admin</h2>
                <div class="row">
                    <div class='col-md-3'>
                        <div class="text_outer">
                            <label class="custom-checkbox form-check-label">
                                {!! Form::checkbox('is_admin', 1, false, array('class' => 'form-check-input', 'checked' => $user->is_admin ? true : false)) !!}Is Admin
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">Permissions (Admins Edit permissions required)</div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($roles AS $role)
                                        <div class="form-group col-6 col-md-4 col-lg-3">
                                            {!! Form::label('role-' . $role->id,$role->name,['class' => 'font-weight-bold']) !!}
                                            @foreach ($role->permissions AS $permission)
                                                <div class="form-check">
                                                    @if($user->exists)
                                                    {!! Form::checkbox('permission[' . $permission->id .']',$permission->id, false,['class' => 'form-check-input','id' => 'permission-' . $permission->id, 'checked' => $user->user->hasPermissionTo($permission->name) ? true : false ]) !!}
                                                    @else
                                                        {!! Form::checkbox('permission[' . $permission->id .']',$permission->id, false,['class' => 'form-check-input','id' => 'permission-' . $permission->id]) !!}
                                                    @endif
                                                    {!! Form::label('permission-' . $permission->id,$permission->name,['class' => 'form-check-label']) !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif
        {{ Form::button($user->exists ? 'Edit' : 'Add', array('class' => 'btn-dark contact_btn','type'=>'submit')) }}

        {{ Form::close() }}
    </div>

    <script type="text/javascript">
        var user_id = null
        let route = '{{$route}}';
        function resetStuffPassword() {
            $.ajax({
                method: "POST",
                url: '{{$route}}',
                dataType: 'JSON',
                success: function (results) {
                    if (results.success === true) {
                        swal("Done!", results.message, "success").then(function () {
                        })
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }
    </script>
@endsection
