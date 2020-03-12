@extends('layouts.main')
@section('title', 'Company')
@include('modal')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('search',null,['id' => 'search', 'placeholder' => 'Search Company','class' => 'form-control-new','onkeyup' => 'searchCompanyPage()']) !!}
                                <span class="remove-button" onclick="document.getElementById('search').value = '';searchCompanyPage()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        <div class="col-sm-9">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal"  data-target="#company-modal" onclick="openCompanyForm();"> <i class="fa fa-plus"></i> </a>
                        </div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Company Logo</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th width="200px" class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="company_search">
                                </tbody>
                            </table>
                            <div id="paginate"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="company-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" baria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    {{ Form::open(array('id'=>'company_form_id')) }}
                        <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('companyName', 'Company Name') }}
                                        {{ Form::text('companyname', null, array('class' => 'form-control','placeholder' => 'company name','id' => 'companyName')) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('email', 'Company Email') }}
                                        {{ Form::email('email', null, array('class' => 'form-control','placeholder' => 'email','id' => 'email')) }}
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 image-chooser">
                                    <div class="image-chooser-preview"></div>
                                    <div class="text_outer">
                                        {!! Html::decode(Form::label('logo', '<i class="fa fa-fw fa-photo"></i>Click to Choose Logo'))!!}
                                        <img class="d-none" src="" id="edit_logo_show" alt="" width="50" height="50">
                                        {{ Form::file('logo', array('class' => 'form-control _input_choose_file', 'id' => 'logo', 'onChange' => 'renderChoosedFile(this)')) }}
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    {!! Form::hidden('emp_id', auth()->user()->id) !!}
                                    <button type="button" id="create" onclick="updateCompany({{ auth()->user()->id }})" class="btn-dark contact_btn" data-form="expences">Save
                                    </button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Company Reports</span>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        var id = updateRoute = null;
        $.ajaxSetup({headers: {'X-CSRF-Token': "{{csrf_token()}}"}});
        $(document).ready(function () {
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
        });
        window.onload = function () {
            searchCompanyPage();
        };

        function openCompanyForm() {
            $('#edit_logo_show').addClass('d-none');
            $('#company_form_id').trigger('reset');
            $('#create').attr('onclick', 'createCompany(event)').attr('data-id', '');
        }

        function createCompany(event) {
            event.preventDefault();
            var companyname = $('#companyName').val();
            var email = $('#email').val();
            var data = new FormData(document.getElementById('company_form_id'));
            if (companyname === '' || email === '') {
                $.toaster({message: 'Field is required!', title: 'Required', priority: 'danger'});
                return false;
            }
            $.ajax({
                method: "POST",
                url: "{{ route('companies.store') }}",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.status == 'success') {
                        $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});
                        searchCompanyPage();
                        $('#company-modal').modal('hide');
                    } else {
                        $.toaster({message: 'Created failed', title: 'Failed', priority: 'fail'});
                    }
                }
            });
        }

        function openEditCompanyModel(id, route, update) {
            updateRoute = update;
            $('#company-modal').modal();
            $('#edit_logo_show').removeClass('d-none');
            $.ajax({
                type: 'GET',
                url: route,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        $('#companyName').val(results.data.companyname);
                        $('#email').val(results.data.email);
                        $('#edit_logo_show').attr('src', '{{ fileUrl() }}' + results.data.logo);
                        $('#create').attr('onclick', 'updateCompany(' + id + ')');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function updateCompany(id) {
            var data = new FormData(document.getElementById('company_form_id'));
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
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                    searchCompanyPage();
                    $('#company-modal').modal('hide');
                }
            });
        }

        function searchCompanyPage() {
            let search = $('#search').val();
            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                search: search,
            };
            $('#wait').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('companies.search') }}",
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
                                for (let index = 0; index < data.length; index++) {
                                    html += `<tr>
                                        <td> ${data[index].logo !== null ? '<img src={{ fileUrl() }}' + data[index].logo + ' height="50px" alt="">' : 'N/A'} </td>
                                        <td> ${data[index].companyname} </td>
                                        <td> ${data[index].email !== null ? data[index].email : 'N/A'} </td>
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="openEditCompanyModel('${data[index].id}', '${data[index].routes.edit}', '${data[index].routes.update}')">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a></td>
                                        </td>
                                    </tr><tr class="spacer"></tr>`;
                                }
                                $('#company_search').html(html);
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
                                    searchCompanyPage();
                                });
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
