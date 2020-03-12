@extends('layouts.main')
@section('title','Mileage Book')
@include('modal')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
            <div class="mileage inner-tab-box">
                <div class="col-md-12">
                    <div class="col-sm-12">
                        <h3>
                            <span class="active-span clickable" id="pending_span" onclick="searchPendingMileagePage()">Pending </span> |
                            <span class="clickable" id="historical_span" onclick="searchHistoryMileagePage()"> Historical</span>
                        </h3>
                        <br>
                    </div>
                    <div class="col-sm-12" id="pending_div">
                        <div class="row">
                            @admin
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::text('search',null,['id' => 'search', 'placeholder' => 'Search employee','class' => 'form-control-new','onkeyup' => 'searchPendingMileagePage()']) !!}
                                    <span class="remove-button" onclick="document.getElementById('search').value = '';searchPendingMileagePage()"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            @endadmin
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::text('date',null,['id' => 'pending_date_from', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::text('date',null,['id' => 'pending_date_to', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div id="wait"></div>
                            </div>
                            <div class="@admin col-sm-5 @else col-sm-7 @endadmin">
                                <a href="javascript:void(0)" onclick="$('#mileage-modal-edit input').val(''); $('#update').attr('onclick', 'createMileage();');" class="_new_icon_button_1" data-toggle="modal" data-target="#mileage-modal-edit"><i class="fa fa-plus"></i> </a>
                            </div>
                            <div class="col-sm-12">
                                <table class="table _table _table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Employee</th>
                                        <th>Reason for mileage</th>
                                        <th>Total Km</th>
                                        @admin
                                        <th class="text-center">Action</th>
                                        @endadmin
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="return_mileagelist" id="mileage_pending">
                                    <tbody>
                                </table>
                                <div id="paginate"></div>
                            </div>
                        </div>
                    </div>
                    <div id="historical_div" class="col-sm-12" style="display:none;">
                        <div class="row">
                            @admin
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::text('history_search',null,['id' => 'history_search', 'placeholder' => 'Search employee','class' => 'form-control-new','onkeyup' => 'searchHistoryMileagePage()']) !!}
                                    <span class="remove-button" onclick="document.getElementById('history_search').value = '';searchHistoryMileagePage()"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            @endadmin
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::text('history_date',null,['id' => 'history_date_from', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::text('history_date',null,['id' => 'history_date_to', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div id="wait-his"></div>
                            </div>
                            <div class="col-sm-7"></div>
                            <div class="col-sm-12">
                                <table class="table _table _table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Employee</th>
                                        <th>Reason for mileage</th>
                                        <th>Total Km</th>
                                        <th>Status</th>
                                        @admin
                                        <th class="text-center">Action</th>
                                        @endadmin
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="return_expence_ajax" id="mileage_history">

                                    </tbody>
                                </table>
                                <div id="paginate-new"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----- Mileage Modal edit ---->
    <div id="mileage-modal-edit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        {{ Form::open(array('id' => 'mileage')) }}
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('edit_companyname', 'Company') }}
                                        @php
                                            $data = [];
                                        @endphp
                                        @foreach($companies as $company)
                                            @php
                                                $data[$company->companyname] = $company->companyname;
                                            @endphp
                                        @endforeach
                                        {!! Form::select('companyname', $data, '', ['class' => 'select_status form-control', 'placeholder' => 'Select', 'id' => 'edit_companyname']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('edit_date', 'Date') }}
                                        {{ Form::text('date', null, array('class' => 'flatpickr form-control', 'placeholder' => 'Select Date', 'id' => 'edit_date')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('edit_vehicle', 'Vehicle') }}
                                        {{ Form::text('vehicle', null, array('class' => 'form-control', 'placeholder' => 'Insert text here', 'id' => 'edit_vehicle')) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('edit_kilometers', 'No of kilometers') }}
                                        {{ Form::number('kilometers', null, array('class' => 'form-control', 'placeholder' => 'Insert figure here', 'id' => 'edit_kilometers')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="text_outer">
                                        {{ Form::label('edit_reasonformileage', 'Reason for mileage') }}
                                        {{ Form::text('reasonformileage', null, array('class' => 'form-control', 'placeholder' => 'Insert text here', 'id' => 'edit_reasonformileage')) }}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" id="update" onclick="createMileage()" class="btn-dark contact_btn" data-form="expences">Save
                                        </button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Mileage</span>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        let id = pending_from = pending_to = history_from = history_to = updateRoute = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var today = new Date();
            pending_to = history_to = formatDate(today);
            pending_from = history_from = formatDate(today.setDate(today.getDate()-30));
            searchPendingMileagePage();

            $("#historical_span").click(function () {
                $("#historical_span").addClass("active-span");
                $("#pending_span").removeClass("active-span");
                $("#pending_div").hide();
                $("#historical_div").show();
            });

            $("#pending_span").click(function () {
                $("#pending_span").addClass("active-span");
                $("#historical_span").removeClass("active-span");
                $("#pending_div").show();
                $("#historical_div").hide();

            });

            $('#pending_date_from').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: pending_from,
                onChange: function (selectedDates, dateStr, instance) {
                    pending_from = null;
                    if(selectedDates.length > 0){
                        pending_from = formatDate(selectedDates);
                    }
                    searchPendingMileagePage();
                },
            });

            $('#pending_date_to').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: pending_to,
                onChange: function (selectedDates, dateStr, instance) {
                    pending_to = null;
                    if(selectedDates.length > 0){
                        pending_to = formatDate(selectedDates);
                    }
                    searchPendingMileagePage();
                },
            });

            $('#history_date_from').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: history_from,
                onChange: function (selectedDates, dateStr, instance) {
                    history_from = null;
                    if(selectedDates.length > 0){
                        history_from = formatDate(selectedDates);
                    }
                    searchHistoryMileagePage();
                },
            });

            $('#history_date_to').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: history_to,
                onChange: function (selectedDates, dateStr, instance) {
                    history_to = null;
                    if(selectedDates.length > 0){
                        history_to = formatDate(selectedDates);
                    }
                    searchHistoryMileagePage();
                },
            });
        });

        function createMileage() {
            $.ajax({
                method: "POST",
                url: '{{ route('mileages.store') }}',
                data: new FormData(document.getElementById('mileage')),
                dataType: 'JSON',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.status === 200) {
                        if (response.errors === undefined) {
                            $.toaster({message: 'created successfully', title: 'Success', priority: 'success'});
                            searchPendingMileagePage();
                            $('#mileage-modal-edit').modal('hide');
                        } else {
                            let errors = '';
                            for (let [key, value] of Object.entries(response.errors)) {
                                errors += value[0] + '<br>';
                            }
                            swal("Error!", errors, "error");
                        }
                    } else {
                        swal("Error!", response.message, "error");
                    }
                }
            });
        }

        function openEditMileageModel(id, editRoute, updateUri) {
            updateRoute = updateUri;
            $('#mileage-modal-edit').modal();
            $('#update').attr('onclick', 'updateMileage();');

            $.ajax({
                type: 'get',
                data: {id: id},
                url: editRoute,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        let company = '';
                        let selecteds = '';
                        for (let i = 0; i < results.data.companies.length; i++) {
                            if (results.data.companies[i].companyname === results.data.mileage.company) {
                                selecteds = 'selected';
                            }
                            company += ` <option value="${results.data.companies[i].companyname}" ${selecteds}>${results.data.companies[i].companyname}</option>`;
                            selecteds = '';
                        }
                        $('#edit_companyname').html(company);
                        $('#edit_vehicle').val(results.data.mileage.vehicle);
                        $('#edit_kilometers').val(results.data.mileage.kilometers);
                        $('#edit_reasonformileage').val(results.data.mileage.reasonmileage);
                        $('#update').attr('onclick', 'updateMileage()');

                        $('#edit_date').flatpickr({
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.mileage.date,
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

        function updateMileage() {
            const data = {
                company: $('#edit_companyname').val(),
                date: $('#edit_date').val(),
                vehicle: $('#edit_vehicle').val(),
                kilometers: $('#edit_kilometers').val(),
                reasonmileage: $('#edit_reasonformileage').val(),
                _method: 'put'
            };

            $.ajax({
                method: "POST",
                url: updateRoute,
                data: data,
                dataType: 'JSON',
                success: function (response) {
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                    searchPendingMileagePage();
                    $('#mileage-modal-edit').modal('hide');
                }
            });
        }

        function searchPendingMileagePage() {
            let search = $('#search').val();

            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }

            let data = {
                search: search,
                from: pending_from,
                to: pending_to,
            };
            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('mileages.searchPending') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let date = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#wait-his').css('display', 'none');
                        $('#paginate').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = '';
                                let action = '';
                                let date = '';
                                for (let index = 0; index < data.length; index++) {
                                    date = results.data[index].formatted_date;

                                    let admin_user = '{{ auth()->user()->is_admin }}';
                                    // console.log(admin_user);

                                    if (admin_user == 1) {
                                        action = `<a href="javascript:void(0)" data-toggle="tooltip" title="Approved" onclick="mileageApprove('${data[index].id}', '${data[index].routes.approve}')"><i class="fa fa-check-circle"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Reject!" onclick="mileageReject('${data[index].id}', '${data[index].routes.reject}')"><i class="fa fa-ban"></i></a>`;
                                    } else {
                                        action = '';
                                    }

                                    html += `<tr>
                                        <td> ${date} </td>
                                        <td> ${data[index].employee.firstname + ' ' + data[index].employee.lastname} </td>
                                        <td> ${data[index].reasonmileage} </td>
                                        <td> ${data[index].kilometers} </td>`;

                                        html += `

                                        <td class="text-center">
                                            ${action}
                                        </td>`;

                                    html += `
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="openEditMileageModel('${data[index].id}', '${data[index].routes.edit}', '${data[index].routes.update}')">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>
                                        </td>
                                    </tr><tr class="spacer"></tr>`;

                                }
                                $('#mileage_pending').html(html);
                                setTimeout(function(){
                                    $('[data-toggle="tooltip"]').tooltip()
                                },400);
                            }
                        })
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function searchHistoryMileagePage() {
            let history_search = $('#history_search').val();

            if ($.trim(history_search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                history_search: history_search,
                from: history_from,
                to: history_to,
            };
            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('mileages.searchHistory') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let date = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#wait-his').css('display', 'none');
                        $('#paginate-new').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = admin = '';
                                for (let index = 0; index < data.length; index++) {
                                    date = results.data[index].formatted_date;

                                    if (is_admin == 1) {
                                        admin = `<td class="text-center">
                                            <a href="javascript:void(0)"  data-toggle="tooltip" title="Pending" onclick="mileagePending('${data[index].id}', '${data[index].routes.pending}')"><i class="fa fa-check-circle"></i></a>
                                        </td>

                                        <td class="text-right">
                                            <a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>
                                        </td>`;
                                    } else {
                                        admin = `<td class="text-center">N/A</td><td></td>`;
                                    }

                                    html += `<tr>
                                                <td> ${date} </td>
                                                <td> ${data[index].employee.firstname + ' ' + data[index].employee.lastname} </td>
                                                <td> ${data[index].reasonmileage} </td>
                                                <td> ${data[index].kilometers} </td>
                                                <td> ${data[index].status == 'A' ? 'Approved' : 'Rejected'} </td>
                                                ${admin}
                                            </tr><tr class="spacer"></tr>`;
                                }
                                $('#mileage_history').html(html);
                                setTimeout(function(){
                                    $('[data-toggle="tooltip"]').tooltip()
                                },400);
                            }
                        })
                    } else {
                        swal("Error!", results.message, "error");
                    }
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
                        data: {_method: 'delete'},
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                    searchPendingMileagePage();
                                    searchHistoryMileagePage();
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

        function mileagePending(id, route) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let data = {id: id};

            $.ajax({
                method: "POST",
                url: route,
                data: data,
                success: function (response) {
                    $.toaster({message: 'Pending', title: 'Success', priority: 'success'});
                    searchPendingMileagePage()
                    searchHistoryMileagePage()
                }
            });
        }

        function mileageApprove(id, route) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let data = {id: id};

            $.ajax({
                method: "POST",
                url: route,
                data: data,
                success: function (response) {
                    $.toaster({message: 'Enabled', title: 'Success', priority: 'success'});
                    searchPendingMileagePage();
                    searchHistoryMileagePage();
                }
            });
        }

        function mileageReject(id, route) {

            let data = {id: id};
            $.ajax({

                method: "POST",
                url: route,
                data: data,

                success: function (response) {
                    $.toaster({message: 'Disabled', title: 'Success', priority: 'success'});
                    searchPendingMileagePage()
                    searchHistoryMileagePage()
                }
            });
        }
    </script>
@endpush
