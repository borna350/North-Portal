@include('admin.adminnav')

<div class="well-default-trans">
    <div class="tab-pane fade show active" id="nav-employee" role="tabpanel" aria-labelledby="nav-employee-tab">
        <form id="contacts_form" method="POST" name="contact-form" action="{{url('admin/add_registration')}}"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="login_type"
                   value={{(auth()->user()->user_type == 'employee') ? 'employeelogin': 'adminlogin'}}>
            <div class="personal">
                <h2 class="form_title">Personal Information</h2>
                <div class="row">

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">First name</label>
                            <input type="text" id="firstname" name="firstname" class="form-control"
                                   placeholder="First Name"
                                   value={{isset($employee_details->firstname) ?  $employee_details->firstname : ''}}>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Last name</label>
                            <input type="text" id="lastname" name="lastname" class="form-control"
                                   placeholder="Last Name"
                                   value={{isset($employee_details->lastname) ?  $employee_details->lastname : ''}}>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Date of birth</label>
                            <input type="date" id="dob" name="dob" class="form-control"
                                   value={{isset($employee_details->dob) ?  $employee_details->dob : ''}}>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Phone</label>
                            <input type="number" id="phone" name="phone" class="form-control" placeholder="000 000 0000"
                                   value={{isset($employee_details->phone_no) ?  $employee_details->phone_no : ''}}>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="text_outer">
                            <label for="name" class="">Address</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Address"
                                   value={{isset($employee_details->address) ?  $employee_details->address : ''}}>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Personal email</label>
                            <input type="email" id="personalemail" name="personalemail" class="form-control"
                                   placeholder="Personal Email"
                                   value={{isset($employee_details->personalemail) ?  $employee_details->personalemail : ''}} {{(auth()->user()->user_type == 'employee') ? 'readonly': ''}}>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Work email</label>
                            <input type="email" id="workemail" name="workemail" class="form-control"
                                   placeholder="Work email"
                                   value={{isset($employee_details->workemail) ?  $employee_details->workemail : ''}}>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="text_outer file_upload">
                            <label for="name" class="">Profile photo</label>
                            <input type="file" id="profilepic" name="profilepic" class="form-control">
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Password*</label>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="xxxxxxx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <p>**Only required if you are changing your password. Your password must
                            be more than 6 characters long, should contain at least 1 uppercase, 1
                            lowercase, 1 numeric and 1 special character.
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#upload-modal1">Click
                                Reset</a>
                        </p>
                    </div>

                </div>
            </div><!--------Personal Information----------->

            <div class="circumstances">
                <h2 class="form_title">Personal Circumstances</h2>
                <div class="row">

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Marital status</label>
                            <select class="select_status form-control" name="marital_status">
                                <option value="">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Number of children</label>
                            <input type="number" id="noofchildren" name="noofchildren" class="form-control"
                                   placeholder="0"
                                   value={{isset($employee_details->no_ofchildren) ?  $employee_details->no_ofchildren : ''}}>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text_outer">
                            <label for="name" class="">Family in the area</label>
                            <input type="text" id="familyinarea" name="familyinarea" class="form-control"
                                   placeholder="Insert text here"
                                   value={{isset($employee_details->family_inarea) ?  $employee_details->family_inarea : ''}}>
                        </div>
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="text_outer">
                            <label for="name" class="">Special family circumstances</label>
                            <input type="text" id="familycircum" name="familycircum" class="form-control"
                                   placeholder="Insert text here"
                                   value={{isset($employee_details->familycircumstance) ?  $employee_details->spclfamilycircumstace : ''}}>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Personal belief/religious requirements</label>
                            <input type="text" id="personal_belief" name="personal_belief" class="form-control"
                                   placeholder="Insert text here"
                                   value={{isset($employee_details->prsnl_belief) ?  $employee_details->prsnl_belief : ''}}>
                        </div>
                    </div>

                </div>
            </div><!--------Personal Circumstances----------->

            <div class="health">
                <h2 class="form_title">Health Concerns</h2>
                <div class="row">

                    <div class="col-md-6">
                        <div class="text_outer">
                            <label for="name" class="">Known medical conditions</label>
                            <input type="text" id="medical_conditions" name="medical_conditions" class="form-control"
                                   placeholder="Insert text here">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text_outer">
                            <label for="name" class="">Allergies</label>
                            <input type="text" id="allergies" name="allergies" class="form-control"
                                   placeholder="Insert text here">
                        </div>
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Dietary Restrictions</label>
                            <input type="text" id="dietary_restrictions" name="dietary" class="form-control"
                                   placeholder="Insert text here">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Known mental health concerns</label>
                            <input type="text" id="mental_concerns" name="mental_concerns" class="form-control"
                                   placeholder="Insert text here">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text_outer">
                            <label for="name" class="">Aversion to physical activity</label>
                            <input type="text" id="aversion_phyactivity" name="aversion_phyactivity"
                                   class="form-control" placeholder="Insert text here">
                        </div>
                    </div>

                </div>
            </div><!--------Health Concerns----------->

            <div class="emergency">
                <h2 class="form_title">Emergency Contact Information</h2>
                <div class="row">

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Emergency contact name</label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                                   class="form-control" placeholder="Insert text here">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Relationship to emergency contact</label>
                            <input type="text" id="rel_emer_contact" name="rel_emer_contact" class="form-control"
                                   placeholder="Insert text here">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Emergency contact phone</label>
                            <input type="text" id="emer_contact_phone" name="emer_contact_phone" class="form-control"
                                   placeholder="Insert text here">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="text_outer">
                            <label for="name" class="">Emergency contact email</label>
                            <input type="text" id="emergency_email" name="emergency_email" class="form-control"
                                   placeholder="Insert text here">
                        </div>
                    </div>

                </div>
            </div><!--------Emergency Contact Information----------->

            <button type="submit" class="btn-dark contact_btn">Save</button>

        </form>
    </div><!-------------end--------->


@include('admin.adminfooter')
