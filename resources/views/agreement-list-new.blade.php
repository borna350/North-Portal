@extends('layouts.main')

@section('title', 'Agreement')

@include('modal')

@section('content1')

    <div class="well-default-trans">
        <div class="tab-pane inner-tab-box" id="nav-agreements" role="tabpanel" aria-labelledby="nav-agreements-tab">
            <div class="row">
                @admin
                    <div class="col-sm-2">
                        <div class="form-group">
                            {!! Form::text('search',null,['id' => 'search', 'placeholder' => 'Search agreement','class' => 'form-control-new','onkeyup' => 'searchAgreement()']) !!}
                            <span class="remove-button" onclick="document.getElementById('search').value = '';searchAgreement()"><i class="fa fa-times" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div id="wait"></div>
                    </div>
                @endadmin
                <div class="col-sm-12">
                    <table class="table _table _table-bordered">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Employee Name</th>
                            <th class="text-right">Employee Agreement</th>
                            <th class="text-right">Code of Conduct</th>
                        </tr>
                        </thead>

                        <tbody id="agreement">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script !src="">
        let from = to = null;

        $(document).ready(function () {
            var date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var today = new Date();
            to = formatDate(today);
            from = formatDate(today.setDate(today.getDate()-30));
            searchAgreement();

            $('#date').flatpickr({
                mode: "range",
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: [from, to],
                onChange: function (selectedDates, dateStr, instance) {
                    from = formatDate(selectedDates[0]);
                    to = formatDate(selectedDates[1]);

                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            from = to = null;
                        }

                        searchAgreement();
                    }
                },
            });
        });

        function searchAgreement() {
            $('#agreement').html('');
            $('#wait').css('display', 'inline-block'); // wait for loader
            let search = $('#search').val();

            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }

            let data = {
                search: search,
                from: from,
                to: to,
            };

            $.ajax({
                type: 'get',
                url: "{{ route('agreements.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    $('#wait').css('display', 'none');
                    let html = date = empAgreement = codeOfConduct = amendments = '';

                    if (results.status == 200) {
                        for (let index = 0; index < results.data.length; index++) {
                            date = results.data[index].formatted_date;

                            if (results.data[index].active_agreement) {
                                if (is_admin) {
                                    empAgreement = `<a href="javascript:void(0);" onclick="showModalAgreement('${results.data[index].id}','EA')">EDIT</a>
                                                    <a href="${results.data[index].active_agreement_url}" target="_blank">View</a>
                                                    <a href="javascript:void(0);" onclick="deleteAgreement('${results.data[index].active_agreement.id}','EA', '${results.data[index].active_agreement_routes.destroy}')" class="down">DELETE</a>`;

                                    if (results.data[index].active_agreement.amendments.length > 0) {
                                        results.data[index].active_agreement.amendments.forEach(function myFunction(value, index, array) {
                                            amendments = `<br>${index + 1}<a href="${value.amendment_url}" target="_blank">View</a><a href="javascript:void(0);" onclick="deleteAgreement('${value.id}','COC', '${value.amendment_routes.destroy}')" class="down">DELETE</a>`;
                                        });
                                        
                                        empAgreement += amendments;
                                    }
                                } else {
                                    empAgreement = `<a href="${results.data[index].active_agreement_url}" target="_blank">View</a>`;

                                    if (results.data[index].active_agreement.amendments.length > 0) {
                                        results.data[index].active_agreement.amendments.forEach(function myFunction(value, index, array) {
                                            amendments = `<br>${index + 1}<a href="${value.amendment_url}" target="_blank">View</a>`;
                                        });

                                        empAgreement += amendments;
                                    }
                                }
                            } else if (is_admin) {
                                empAgreement = `<a href="javascript:void(0);" onclick="showModalAgreement('${results.data[index].id}','EA')">Upload</a>`;
                            } else {
                                empAgreement = 'N/A';
                            }

                            if (results.data[index].active_codeofconduct) {
                                if (is_admin) {
                                    codeOfConduct = `<a href="javascript:void(0);" onclick="showModalAgreement('${results.data[index].id}','COC')">EDIT</a>
                                                    <a href="${results.data[index].active_code_of_conduct_url}" target="_blank">View</a>
                                                    <a href="javascript:void(0);" onclick="deleteAgreement('${results.data[index].active_codeofconduct.id}','COC', '${results.data[index].active_code_of_conduct_routes.destroy}')" class="down">DELETE</a>`;
                                } else {
                                    codeOfConduct = `<a href="${results.data[index].active_code_of_conduct_url}" target="_blank">View</a>`;
                                }
                            } else if (is_admin) {
                                codeOfConduct = `<a href="javascript:void(0);" onclick="showModalAgreement('${results.data[index].id}','COC')">Upload</a>`;
                            } else {
                                codeOfConduct = 'N/A';
                            }

                            html += `<tr>
                                        <td> ${date} </td>
                                        <td> ${results.data[index].firstname + ' ' + results.data[index].lastname} </td>
                                        <td class="text-right">
                                            ${empAgreement}
                                        </td>
                                        <td class="text-right">
                                            ${codeOfConduct}
                                        </td>
                                    </tr><tr class="spacer"></tr>`;
                        }

                        $('#agreement').html(html);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function showModalAgreement(id, type) {
            $('#show_modal_agreement').modal('show');
            $('#employee_id_modal').val(id);
            $('#agreement_type').val(type);
        }

        $(".nav_agreement").click(function () {
            searchAgreement();
        });

        $('#upload_agreement').submit(function (e) {
            e.preventDefault();
            var form_data = new FormData($("#upload_agreement")[0]);
            $.ajax({
                type: 'post',
                url: "{{ route('agreements.store') }}",
                // url: './addagreement',
                data: form_data,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#show_modal_agreement').modal('hide');
                    searchAgreement();
                    swal("Agreement Uploaded successfully", "", "success");
                }
            });
        });

        function deleteAgreement(id, type, route) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: 'post',
                url: route,
                dataType: 'json',
                data: {_token: CSRF_TOKEN, _method: 'delete', type: type},
                success: function (response) {
                    searchAgreement();
                    swal("Delete successfully", "", "success");
                }
            });
        }
    </script>
@endpush

