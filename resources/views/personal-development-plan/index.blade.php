@extends('layouts.main')
@section('title', 'Personal development plan')
@include('modal')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-sm-12">
                    <br>
                </div>
                <div class="col-sm-12" id="pending_div">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('archive_date',null,['id' => 'archive_date_from', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('archive_date',null,['id' => 'archive_date_to', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait-his"></div>
                        </div>
                        <div class="col-sm-7">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#personal_development_modal" onclick="resetForm()"> <i class="fa fa-plus"></i> </a>
                        </div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="personal_development_archive">
                                </tbody>
                            </table>
                            <div id="paginate-new"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-------------end--------->
    </div>

    <div id="personal_development_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        {{ Form::open(array('id' => 'personal_development_plans_form')) }}
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('create_title', 'Title') }}
                                        {{ Form::text('title', null, array('class' => 'form-control','placeholder' => 'Insert text here', 'id' => 'create_title')) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('create_description', 'Description') }}
                                        {{ Form::text('description', null, array('class' => 'form-control','placeholder' => 'Insert text here', 'id' => 'create_description')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('create_start_date', 'Start Date') }}
                                        {{ Form::text('start_date', null, array('class' => 'flatpickr form-control','placeholder' => 'Select Date', 'id' => 'create_start_date')) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('create_end_date', 'End Date') }}
                                        {{ Form::text('end_date', null, array('class' => 'flatpickr form-control','placeholder' => 'Select Date', 'id' => 'create_end_date')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('company', 'Mentor') }}
                                        @php
                                            $data = [];
                                        @endphp
                                        @foreach($user as $usr)
                                            @php
                                                $data[$usr->id] = $usr->name;
                                            @endphp
                                        @endforeach
                                        {!! Form::select('emp_id', $data, '', ['class' => 'select_status form-control', 'placeholder' => 'Select', 'id' => 'create_emp_id']) !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" onclick="createPersonalDevelopment(event)" class="btn-dark contact_btn" data-form="expences" id="create">Save
                                        </button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i>  Return to Personal Development Plan Reports</span>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--ajax come modal-->

    <script type="text/javascript">
        let id = archive_from = archive_to = updateRoute = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var today = new Date();
            archive_to = formatDate(today);
            archive_from = formatDate(today.setDate(today.getDate()-30));
            personalDevelopmentArchiveSearch();

            $("#pending_span").click(function () {
                $("#pending_span").addClass("active-span");
                $("#pending_div").show();

            });

            $('#archive_date_from').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: archive_from,
                onChange: function (selectedDates, dateStr, instance) {
                    archive_from = null;
                    if(selectedDates.length > 0){
                        archive_from = formatDate(selectedDates);
                    }
                    personalDevelopmentArchiveSearch();
                },
            });

            $('#archive_date_to').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: archive_to,
                onChange: function (selectedDates, dateStr, instance) {
                    archive_to = null;
                    if(selectedDates.length > 0){
                        archive_to = formatDate(selectedDates);
                    }
                    personalDevelopmentArchiveSearch();
                },
            });
        });

        function resetForm() {
            document.getElementById('personal_development_plans_form').reset();
            $('#create').attr('onclick', 'createPersonalDevelopment(event)');
        }

        function createPersonalDevelopment(event) {
            event.preventDefault();
            var title = $('#create_title').val();
            var description = $('#create_description').val();
            var start_date = $('#create_start_date').val();
            var end_date = $('#create_end_date').val();
            var emp_id = $('#create_emp_id').val();
            var data = {
                title: title,
                description: description,
                start_date: start_date,
                end_date: end_date,
                emp_id: emp_id,
            };

            if (title == '' || description == '' || start_date == '' || end_date == '' || emp_id == '') {
                $.toaster({message: 'Field is required!', title: 'Required', priority: 'danger'});
                return false;
            }

            $.ajax({
                method: "POST",
                url: "{{ route('personal_development_plans.store') }}",
                data: data,
                dataType: 'JSON',
                success: function (response) {
                    $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});
                    $('#personal_development_modal').modal('hide');
                    personalDevelopmentArchiveSearch();
                }
            });
        }

        function personalDevelopmentArchiveSearch() {
            let data = {
                from: archive_from,
                to: archive_to,
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader

            $.ajax({
                type: 'post',
                url: "{{ route('personal_development_plans.archive') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#wait-his').css('display', 'none');
                        $('#paginate-new').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = date = '';

                                for (let index = 0; index < data.length; index++) {
                                    date = results.data[index].formatted_date;

                                    html += `<tr>
                                   <td> ${date} </td>
                                   <td>${data[index].description} </td>
                                   <td class="text-center">

                                    </td>
                                    <td class="action-box">
                                        <a href="${data[index].routes.show}"> View</a>
                                        <a href="javascript:void(0);" onclick="openEditDevelopmentModel('${data[index].id}', '${data[index].routes.edit}', '${data[index].routes.update}') ">EDIT</a>
                                        <a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>
                                    </td>
                               </tr>
                               <tr class="spacer"></tr>`;
                                }
                                $('#personal_development_archive').html(html);
                            }
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function openEditDevelopmentModel(id, route, update) {
            updateRoute = update;
            $('#personal_development_modal').modal();
            $.ajax({
                type: 'GET',
                url: route,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        let mentor = '';
                        let selecteds = '';

                        for (let i = 0; i < results.data.user.length; i++) {
                            if (results.data.user[i].id === results.data.emp_id) {
                                selecteds = 'selected';
                            }
                            mentor += ` <option value="${results.data.user[i].id}" ${selecteds}>${results.data.user[i].name}</option>`;
                            selecteds = '';
                        }

                        $('#create_title').val(results.data.title);
                        $('#create_description').val(results.data.description);

                        $('#create_emp_id').html(mentor);
                        $('#create_emp_id').val(results.data.emp_id);

                        $('#create').attr('onclick', 'updatePersonalDevelopment(' + id + ')');
                        $('#update').attr('data-id', id);

                        $('#create_start_date').flatpickr({
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.start_date,
                            onChange: function (selectedDates, dateStr, instance) {
                                from = formatDate(selectedDates[0]);
                                to = formatDate(selectedDates[1]);
                                if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                                    if (selectedDates[0] === undefined) {
                                        from = to = null;
                                    }
                                }
                            },
                        });

                        $('#create_end_date').flatpickr({
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.end_date,
                            onChange: function (selectedDates, dateStr, instance) {
                                from = formatDate(selectedDates[0]);
                                to = formatDate(selectedDates[1]);
                                if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                                    if (selectedDates[0] === undefined) {
                                        from = to = null;
                                    }
                                }
                            },
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function updatePersonalDevelopment() {
            let data = new FormData(document.getElementById('personal_development_plans_form'));
            data.append('_method', 'put');
            $.ajax({
                method: "POST",
                url: updateRoute,
                data: data,
                dataType: 'JSON',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                    personalDevelopmentArchiveSearch();
                    $('#personal_development_modal').modal('hide');
                }
            });
        }

        function deleteConfirm(id, route) {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'post',
                        url: route,
                        data: {
                            _method: 'delete'
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                    personalDevelopmentArchiveSearch();
                                })
                            } else {
                                swal("Error!", results.message, "error");
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }
    </script>
@endsection
