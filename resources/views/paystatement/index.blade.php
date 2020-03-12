@extends('layouts.main')

@section('title', 'Pay statements')

@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane " id="nav-statements" aria-labelledby="nav-statements-tab">
            <div class="agreements">
                <div class="col-sm-12" id="pending_div">
                    <div class="row">
                        @if(auth()->user()->is_admin ==1)
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('search',null,['id' => 'search', 'placeholder' => 'Select pay-statement','class' => 'form-control-new','onkeyup' => 'searchPayStatementsPage()']) !!}
                                <span class="remove-button" onclick="document.getElementById('search').value = '';searchPayStatementsPage()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        @endif
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('date',null,['id' => 'date_from', 'placeholder' => 'From','class' => 'form-control-new']) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('date',null,['id' => 'date_to', 'placeholder' => 'To','class' => 'form-control-new']) !!}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        @if(auth()->user()->is_admin ==1)
                            <div class="col-sm-5">
                                <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#show_modal_paystatement" style="padding: 7px 12px;"> <i class="fa fa-plus"></i> </a>
                            </div>
                        @endif
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="payments_search">
                                </tbody>
                            </table>
                            <div id="paginate"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="show_modal_paystatement" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                            {{ Form::open(array('id'=>'createPayForm')) }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text_outer">
                                            {{ Form::label('employee', 'Employee') }}
                                            @php
                                                $data = [];
                                            @endphp
                                            @foreach($user as $usr)
                                                @php
                                                    $data[$usr->id] = $usr->name;
                                                @endphp
                                            @endforeach
                                            {!! Form::select('emp_id', $data, '', ['class' => 'select_status form-control', 'placeholder' => 'Select', 'id' => 'emp_id']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text_outer">
                                            {{ Form::label('description', 'Description') }}
                                            {{ Form::text('description', null, array('class' => 'form-control','placeholder'=>'Insert text here','id'=>'description')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text_outer">
                                            {{ Form::label('date', 'Date') }}
                                            {{ Form::text('date', null, array('class' => 'flatpickr form-control','placeholder' => 'Insert text here',)) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 image-chooser">
                                        <div class="image-chooser-preview"></div>
                                        <div class="text_outer">
                                            {!! Html::decode(Form::label('pdfname', '<i class="fa fa-file-pdf-o"></i>Upload PDF'))!!}
                                            {{ Form::file('pdfname', array('class' => 'form-control _input_choose_file', 'id' => 'pdfname', 'onchange' => 'renderChoosedFile(this)', 'accept' => 'application/pdf')) }}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row margin-top-30">
                                    <div class="form-group" style="width:100%;">
                                        <div class="col-md-12 col-sm-12">
                                            <button type="button" id="create" onclick="createUpload(event)" class="btn-dark contact_btn" data-form="expences">Save </button>
                                            <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Paystatement</span>
                                        </div>
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var from = null;
        var to = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var today = new Date();
            to = formatDate(today);
            from = formatDate(today.setDate(today.getDate()-30));
            searchPayStatementsPage();

            $('#date_from').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: from,
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        from = formatDate(selectedDates);
                    } else {
                        from = null;
                    }

                    searchPayStatementsPage();
                },
            });

            $('#date_to').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: to,
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        to = formatDate(selectedDates);
                    } else {
                        to = null;
                    }

                    searchPayStatementsPage();
                },
            });
        });

        function createUpload(event) {
            event.preventDefault();
            $('#create').attr('disabled', 'disabled');
            var data = new FormData(document.getElementById('createPayForm'));

            $.ajax({
                method: "POST",
                url: "{{ route('paystatements.store') }}",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    $('#create').removeAttr('disabled');

                    if (response.status === 'success') {
                        $('#createPayForm')[0].reset();
                        $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});
                        searchPayStatementsPage();
                        $('#show_modal_paystatement').modal('hide');
                    } else {
                        if (response.errors === undefined) {
                            $.toaster({message: 'Created failed', title: 'Failed', priority: 'fail'});
                        } else {
                            let errors = '';
                            for (let [key, value] of Object.entries(response.errors)) {
                                errors += value[0] + '<br>';
                            }
                            swal("Error!", errors, "error");
                        }
                    }
                }
            });
        }

        function searchPayStatementsPage() {
            let search = $('#search').val();
            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                _token: '{{  @csrf_token() }}',
                search: search,
                from: from,
                to: to,

            };
            $('#wait').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'get',
                url: "{{ route('paystatements.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#paginate').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = '';
                                let date = '';
                                let description = '';
                                let action = '';
                                for (let index = 0; index < data.length; index++) {
                                    date = results.data[index].formatted_date;

                                    if (data[index].description != null && data[index].description != '') {
                                        description = data[index].description;
                                    } else {
                                        description = '';
                                    }
                                    let admin_user = '{{ auth()->user()->is_admin }}';
                                    // console.log(admin_user);

                                    if (admin_user == 1) {
                                        action = `<a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>`;
                                    } else {
                                        action = '';
                                    }

                                    html += `<tr>
                                <td>${data[index].employee.firstname + ' ' + data[index].employee.lastname}</td>
                                <td> ${date} </td>
                                <td>${description} </td>
                                <td class="text-right">
                                    <a href="${data[index].pdfname}" target="_blank">VIEW</a>
                                    ${action}
                                    </td>
                            </tr><tr class="spacer"></tr>`;
                                }
                                $('#payments_search').html(html);
                            }
                        });

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
                                    searchPayStatementsPage();
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
