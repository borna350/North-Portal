@extends('layouts.main')
@section('title', 'Expenses report')
@include('modal')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-sm-12">
                    <h3>
                        <span class="active-span clickable" id="pending_span" onclick="searchExpensesPending()">Pending </span> |
                        <span class="clickable" id="historical_span" onclick="searchExpensesHistory()"> Historical</span>
                    </h3>
                    <br>
                </div>
                <div class="col-sm-12" id="pending_div">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('pending_search',null,['id' => 'pending_search', 'placeholder' => 'Search employee','class' => 'form-control-new','onkeyup' => 'searchExpensesPending()']) !!}
                                <span class="remove-button" onclick="document.getElementById('pending_search').value = '';searchExpensesPending()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('pending_date',null,['id' => 'pending_date_from', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('pending_date',null,['id' => 'pending_date_to', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        <div class="col-sm-5">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#expense-modal" onclick="openExpenseForm();"> <i class="fa fa-plus"></i> </a>
                        </div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    @admin
                                    <th>Employee</th>
                                    @endadmin
                                    <th>Description</th>
                                    <th>Total</th>
                                    @admin
                                    <th>Action</th>
                                    @endadmin
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="expence_pending">
                                </tbody>
                            </table>
                            <div id="paginate"></div>
                        </div>
                    </div>
                </div>
                <div id="historical_div" class="col-sm-12" style="display:none;">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('history_search',null,['id' => 'history_search', 'placeholder' => 'Search employee','class' => 'form-control-new','onkeyup' => 'searchExpensesHistory()']) !!}
                                <span class="remove-button" onclick="document.getElementById('history_search').value = '';searchExpensesHistory()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('history_date',null,['id' => 'history_date_from', 'placeholder' => 'Search Date','class' => 'form-control-new']) !!}
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
                                    @admin
                                    <th>Employee</th>
                                    @endadmin
                                    <th>Description</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="expense_history">
                                </tbody>
                            </table>
                            <div id="paginate-new"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-------------end--------->
    </div>

    <div id="expense-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        {{ Form::open(array('id'=>'Expense_form_id', 'route' => 'expenses.store', 'enctype' => 'multipart/form-data', 'class' => 'expences')) }}
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('company', 'Company') }}
                                    @php
                                        $data = [];
                                    @endphp
                                    @if(auth()->user()->is_admin)
                                        @foreach($companies as $company_ex_report)
                                            @php
                                                $data[$company_ex_report->id] = $company_ex_report->companyname;
                                            @endphp
                                        @endforeach
                                        {!! Form::select('company', $data, '', ['class' => 'select_status form-control', 'placeholder' => 'Select', 'id' => 'company']) !!}
                                    @else
                                        @if(auth()->user()->employee_details && auth()->user()->employee_details->company_id)
                                            {!! Form::select('company', [auth()->user()->employee_details->company_id => auth()->user()->employee_details->company->companyname], auth()->user()->employee_details->company_id, ['class' => 'select_status form-control', 'placeholder' => 'Select', 'id' => 'company']) !!}
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('expense_date', 'Date') }}
                                    {{ Form::text('date', null, array('class' => 'flatpickr form-control','placeholder'=>'Select Date','id'=>'expense_date')) }}
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('category', 'Category') }}
                                    @php
                                        $data = [];
                                    @endphp
                                    @foreach($category as $category_ex_report)
                                        @php
                                            $data[$category_ex_report->id] = $category_ex_report->categoryname;
                                        @endphp
                                    @endforeach
                                    {!! Form::select('category', $data, '', ['class' => 'select_status form-control', 'placeholder' => 'Select', 'id' => 'category']) !!}

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('purchase', 'Purchase via') }}
                                    @php
                                        $data = [];
                                    @endphp
                                    @foreach($purchases as $purchases_ex_report)
                                        @php
                                            $data[$purchases_ex_report->id] = $purchases_ex_report->purchasename;
                                        @endphp
                                    @endforeach
                                    {!! Form::select('purchase', $data, '', ['class' => 'select_status form-control', 'placeholder' => 'Select', 'id' => 'purchase']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('project', 'Project') }}
                                    @php
                                        $data = [];
                                    @endphp
                                    @foreach($project as $project_ex_report)
                                        @php
                                            $data[$project_ex_report->id] = $project_ex_report->projectname;
                                        @endphp
                                    @endforeach
                                    {!! Form::select('project', $data, '', ['class' => 'select_status form-control', 'placeholder' => 'Select', 'id' => 'project']) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 image-chooser">
                                <div class="image-chooser-preview"></div>
                                <div class="text_outer">
                                    {!! Html::decode(Form::label('name', '<i class="fa fa-file-pdf-o"></i>Select Receipt'))!!}
                                    <span id="receipt_show" style="position: relative;z-index: 5"></span>
                                    {{ Form::file('receipt', array('class' => 'form-control _input_choose_file', 'id' => 'receipt', 'onChange' => 'renderChoosedFile(this)')) }}
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('description', 'Description') }}
                                    {{ Form::text('description', null, array('class' => 'form-control','placeholder' => 'Insert text here','id' => 'description')) }}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-12 col-sm-12">
                                    <label class="form-check-label">
                                        {!! Form::checkbox('billable', null, false, array('class' => 'form-check-input', 'id' => 'billable')) !!}
                                        Billable
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display:inline-flex;">
                                        <div class="col-md-7 col-sm-7">
                                            <label class="form-check-label">
                                                {!! Form::checkbox('received_auth', null, false, array('class' => 'form-check-input', 'id' => 'authorization')) !!}
                                                Received authorization
                                            </label>
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            {{ Form::text('received_auth', null, array('class' => 'form-control', 'placeholder' => '','id' => 'ireceived_auth', 'style' => 'border:0px; border-bottom:1px solid;padding: 0px;background-color: #fff !important;', 'onkeyup' => 'checkAuthorization("#authorization")')) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('subtotal', 'Subtotal') }}
                                    {{ Form::number('subtotal', null, array('class' => 'form-control','placeholder' => 'Insert text here','id' => 'subtotal')) }}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('gst', 'GST') }}
                                    {{ Form::number('gst', null, array('class' => 'form-control','placeholder' => 'Insert Figure here','id' => 'gst')) }}
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('pst', 'PST') }}
                                    {{ Form::number('pst', null, array('class' => 'form-control','placeholder' => 'Insert Figure here','id' => 'pst')) }}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {{ Form::label('total', 'Total') }}
                                    {{ Form::number('total', null, array('class' => 'form-control','placeholder' => 'Insert Figure here','id' => 'total')) }}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    {{ csrf_field() }}
                                    {{ Form::hidden('emp_id', auth()->user()->id) }}
                                    <button type="button" onclick="updateExpense({{ auth()->user()->id }})" class="btn-dark contact_btn" data-form="expences" id="create">Save </button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Expense Reports</span>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let id = pending_from = pending_to = history_from = history_to = updateRoute = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var today = new Date();
            pending_to = history_to = formatDate(today);
            pending_from = history_from = formatDate(today.setDate(today.getDate() - 30));
            searchExpensesPending();

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
                    if (selectedDates.length > 0) {
                        pending_from = formatDate(selectedDates);
                    }
                    searchExpensesPending();
                },
            });

            $('#pending_date_to').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: pending_to,
                onChange: function (selectedDates, dateStr, instance) {
                    pending_to = null;
                    if (selectedDates.length > 0) {
                        pending_to = formatDate(selectedDates);
                    }
                    searchExpensesPending();
                },
            });

            $('#history_date_from').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: history_from,
                onChange: function (selectedDates, dateStr, instance) {
                    history_from = null;
                    if (selectedDates.length > 0) {
                        history_from = formatDate(selectedDates);
                    }
                    searchExpensesHistory();
                },
            });

            $('#history_date_to').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: history_to,
                onChange: function (selectedDates, dateStr, instance) {
                    history_to = null;
                    if (selectedDates.length > 0) {
                        history_to = formatDate(selectedDates);
                    }
                    searchExpensesHistory();
                },
            });
        });

        function openExpenseForm() {
            $('#Expense_form_id').trigger('reset');
            $('#create').attr('onclick', 'storeExpense()');
        }

        function storeExpense() {
            event.preventDefault();
            if ($('#authorization').prop('checked')) {
                $('#Expense_form_id').submit();
            } else {
                swal({
                    title: "Confirm",
                    text: "Are you sure want to create without receive authorization!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, create!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        $('#Expense_form_id').submit();
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        }

        function openEditExpenseModel(id, route, update) {
            updateRoute = update;
            $('#expense-modal').modal();
            $('#create').attr('onclick', 'updateExpense(' + id + ')');

            $.ajax({
                type: 'GET',
                url: route,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        let company = '';
                        let selecteds = '';

                        for (let i = 0; i < results.data.companies.length; i++) {
                            if (results.data.companies[i].id === results.data.expense.company) {
                                selecteds = 'selected';
                            }
                            company += ` <option value="${results.data.companies[i].id}" ${selecteds}>${results.data.companies[i].companyname}</option>`;
                            selecteds = '';
                        }
                        let category = '';
                        let selectedc = '';

                        for (let i = 0; i < results.data.category.length; i++) {
                            if (results.data.category[i].id === results.data.expense.category) {
                                selectedc = 'selected';
                            }
                            category += ` <option value="${results.data.category[i].id}" ${selectedc}>${results.data.category[i].categoryname}</option>`;
                            selectedc = '';
                        }
                        let purchase = '';
                        let selectedp = '';

                        for (let i = 0; i < results.data.purchases.length; i++) {
                            if (results.data.purchases[i].id === results.data.expense.purchase) {
                                selectedp = 'selected';
                            }
                            purchase += ` <option value="${results.data.purchases[i].id}" ${selectedp}>${results.data.purchases[i].purchasename}</option>`;
                            selectedp = '';
                        }
                        let project = '';
                        let selectedpr = '';

                        for (let i = 0; i < results.data.project.length; i++) {
                            if (results.data.project[i].id === results.data.expense.project) {
                                selectedpr = 'selected';
                            }
                            project += ` <option value="${results.data.project[i].id}" ${selectedpr}>${results.data.project[i].projectname}</option>`;
                            selectedpr = '';
                        }
                        let check = '';
                        let check1 = '';

                        if (results.data.expense.billable != null) {
                            check = $('#billable').attr('checked', true);
                        } else {
                            check = $('#billable').val(results.data.expense.billable);
                        }

                        if (results.data.expense.received_auth != null) {
                            check1 = $('#authorization').attr('checked', true);
                        } else {
                            check1 = $('#authorization').val(results.data.expense.received_auth);
                        }
                        $('#company').html(company);
                        $('#category').val(results.data.expense.company);
                        $('#category').html(category);
                        $('#category').val(results.data.expense.category);
                        $('#purchase').html(purchase);
                        $('#purchase').val(results.data.expense.purchase);
                        $('#project').html(project);
                        $('#project').val(results.data.expense.project);
                        $('#description').val(results.data.expense.description);
                        if (results.data.expense.receipt != null) {
                            $('#receipt_show').html('<a href="' + results.data.file_url + '" target="_blank"><i class="fa fa-file-pdf-o"></i><a>');
                        }
                        $('#billable').val(check);
                        $('#authorization').val(check1);
                        $('#ireceived_auth').val(results.data.expense.received_auth);
                        $('#subtotal').val(results.data.expense.subtotal);
                        $('#gst').val(results.data.expense.gst);
                        $('#pst').val(results.data.expense.pst);
                        $('#total').val(results.data.expense.total);

                        $('#expense_date').flatpickr({
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.expense.date,
                            onChange: function (selectedDates, dateStr, instance) {
                                from = formatDate(selectedDates[0]);
                                to = formatDate(selectedDates[1]);

                                if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                                    if (selectedDates[0] === undefined) {
                                        from = to = null;
                                    }
                                    searchExpensesPending();
                                }
                            },
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function updateExpense(id) {
            if ($('#authorization-edit').prop('checked')) {
                submitUpdateForm(id);
            } else {
                swal({
                    title: "Confirm",
                    text: "Are you sure want to update without receive authorization!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, create!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        submitUpdateForm(id);
                    } else {
                        e.dismiss;
                    }

                }, function (dismiss) {
                    return false;
                })
            }
        }

        function submitUpdateForm(id) {
            var data = new FormData(document.getElementById('Expense_form_id'));
            data.append('_method', 'put');

            $.ajax({
                method: "post",
                url: updateRoute,
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.status == 'success') {
                        $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                        searchExpensesPending();
                        searchExpensesHistory();
                        $('#expense-modal').modal('hide');
                    } else {
                        if (response.errors === undefined) {
                            swal("Error!", response.msg, "error");
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

        function searchExpensesPending() {
            let pending_search = $('#pending_search').val();
            if ($.trim(pending_search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                pending_search: pending_search,
                from: pending_from,
                to: pending_to,
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader

            $.ajax({
                type: 'post',
                url: "{{ route('expenses.pending') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#wait-his').css('display', 'none');
                        $('#paginate').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = date = adminOption = '';

                                for (let index = 0; index < data.length; index++) {
                                    date = results.data[index].formatted_date;

                                    if (is_admin == 1) {
                                        adminOption = `<a href="javascript:void(0)" data-toggle="tooltip" title="Approved!"  onclick="approveExpense('${data[index].id}', '${data[index].routes.approve}')"><i class="fa fa-check-circle"></i></a>
                                        <a href="javascript:void(0)" data-toggle="tooltip"  title="Reject!" onclick="rejectExpense('${data[index].id}', '${data[index].routes.reject}')"><i class="fa fa-ban"></i></a>`;
                                    }

                                    html += `<tr>
                                    <td> ${date} </td>
                                    <td> ${data[index].employee.firstname == null ? '' : data[index].employee.firstname} ${data[index].employee.lastname == null ? '' : data[index].employee.lastname}</td>
                                    <td> ${data[index].description == null ? '' : data[index].description} </td>
                                    <td> ${data[index].total == null ? '' : data[index].total} </td>
                                    <td>
                                        ${adminOption}
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" onclick="openEditExpenseModel('${data[index].id}', '${data[index].routes.edit}', '${data[index].routes.update}') ">EDIT</a>
                                        <a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>`;
                                }
                                $('#expence_pending').html(html);
                                setTimeout(function () {
                                    $('[data-toggle="tooltip"]').tooltip()
                                }, 400);

                            }
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function searchExpensesHistory() {
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
                url: "{{ route('expenses.history') }}",
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
                                let html = admin = date = '';

                                for (let index = 0; index < data.length; index++) {
                                    date = results.data[index].formatted_date;

                                    if (is_admin == 1) {
                                        admin = `<a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>`;
                                    }

                                    html += `<tr>
                                           <td> ${date} </td>
                                           <td> ${data[index].employee.firstname == null ? '' : data[index].employee.firstname} ${data[index].employee.lastname == null ? '' : data[index].employee.lastname}</td>
                                           <td> ${data[index].description == null ? '' : data[index].description} </td>
                                           <td> ${data[index].total == null ? '' : data[index].total} </td>
                                           <td> ${data[index].status == 1 ? 'Approved' : 'Rejected'} </td>
                                           <td class="action-box">
                                               ${admin}
                                           </td>
                                       </tr>
                                       <tr class="spacer"></tr>`;
                                }
                                $('#expense_history').html(html);
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
                        data: {
                            _method: 'delete'
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                    searchExpensesPending();
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

        function approveExpense(id, route) {
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
                    searchExpensesPending();
                }
            });
        }

        function rejectExpense(id, route) {
            let data = {id: id};

            $.ajax({
                method: "POST",
                url: route,
                data: data,
                success: function (response) {
                    $.toaster({message: 'Disabled', title: 'Success', priority: 'success'});
                    searchExpensesPending();
                }
            });
        }

        function checkAuthorization(id) {
            if (event.target.value === '') {
                $(id).prop('checked', false);
            } else {
                $(id).prop('checked', true);
            }
        }
    </script>
@endsection
