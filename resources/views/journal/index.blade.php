@extends('layouts.main')
@section('title','Journal Entries')
@include('modal')
@section('content1')

    <div class="well-default-trans">
        <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
            <div class="mileage inner-tab-box">
                <div class="col-md-12">
                    <div class="col-sm-12">
                        <h3>
                            <span class="active-span" id="pending_span" onclick="searchJournalPage()">My Journal Entries</span>
                        </h3>
                        <br>
                    </div>
                    <div class="col-sm-12" id="pending_div">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::text('date',null,['id' => 'date_from', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::text('date',null,['id' => 'date_to', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div id="wait"></div>
                            </div>
                            <div class="col-sm-7">
                                <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#journal-edit-modal" onclick="openJournalForm();"> <i class="fa fa-plus"></i> </a>
                            </div>
                            <div class="col-sm-12">
                                <table class="table _table _table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="return_mileagelist" id="search_journal">
                                    <tbody>
                                </table>
                                <div id="paginate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----- Journal Modal edit ---->
    <div id="journal-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {!! Form::label('edit_date','Date') !!}
                                    {!! Form::text('date',null,['id' => 'edit_date', 'class' => 'flatpickr form-control','placeholder' => 'Select Date']) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    {!! Form::label('title') !!}
                                    {!! Form::text('title',null,['class' => 'form-control','placeholder' => 'Insert title here']) !!}
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="text_outer">
                                    {!! Form::textarea('details',null,['id' => 'details', 'class' => 'form-control','placeholder' => 'Insert text here','style' => 'min-height: 100px']) !!}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" id="update" onclick="updateJournal('')" class="btn-dark contact_btn" data-form="expences">Save
                                    </button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i>  Return to journal Reports</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- Journal edit modal end -->
@endsection

@push('scripts')
    <script type="text/javascript">
        let id = from = to = updateRoute = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            const today = new Date();
            to = formatDate(today);
            from = formatDate(today.setDate(today.getDate()-30));
            searchJournalPage();

            $("#pending_span").click(function () {
                $("#pending_span").addClass("active-span");
                $("#pending_div").show();
            });

            $('#date_from').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: from,
                onChange: function (selectedDates, dateStr, instance) {
                    from = null;
                    if(selectedDates.length > 0){
                        from = formatDate(selectedDates);
                    }
                    searchJournalPage();
                },
            });

            $('#date_to').flatpickr({
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: to,
                onChange: function (selectedDates, dateStr, instance) {
                    to = null;
                    if(selectedDates.length > 0){
                        to = formatDate(selectedDates);
                    }
                    searchJournalPage();
                },
            });

        });

        function openJournalForm () {
            $('#title').val('');
            $('#details').val('');
            $('#update').attr('onclick', 'createJournal(event)').attr('data-id', '');
        }

        function createJournal(event) {
            event.preventDefault();
            const date = $('#edit_date').val();
            const title = $('#title').val();
            const details = $('#details').val();

            const data = {
                date: date,
                title: title,
                details: details,
            };
            // console.log(data)
            if (date === '' || title === '' || details === '') {
                $.toaster({message: 'Field is required!', title: 'Required', priority: 'danger'});
                return false;
            }
            $.ajax({
                method: "POST",
                url: "{{ route('journal.store') }}",
                data: data,
                dataType: 'JSON',
                success: function (response) {
                    $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});
                    $('#journal-edit-modal').modal('hide');
                    searchJournalPage();
                }
            });
        }

        function openEditJournalModel(id, route, update) {
            updateRoute = update;
            $('#journal-edit-modal').modal();
            $.ajax({
                type: 'GET',
                url: route,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        const $editDate = $('#edit_date');
                        $editDate.val(results.data.date.split(' ')[0]);
                        $('#title').val(results.data.title);
                        $('#details').val(results.data.details);
                        $('#update').attr('onclick', 'updateJournal(' + id + ')').attr('data-id', id);

                        $editDate.flatpickr({
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.date,
                            onChange: function (selectedDates, dateStr, instance) {
                                let from = formatDate(selectedDates[0]);
                                let to = formatDate(selectedDates[1]);
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

        function updateJournal(id) {
            const data = {
                date: $('#edit_date').val(),
                title: $('#title').val(),
                details: $('#details').val(),
                id: id
            };

            $.ajax({
                method: "POST",
                url: updateRoute,
                data: data,
                dataType: 'JSON',
                success: function (response) {
                    $('#journal-edit-modal').modal('hide');
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                    searchJournalPage();
                }
            });
        }

        function searchJournalPage() {
            let data = {
                from: from,
                to: to,
            };
            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('journal.search-journal') }}",
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
                                let date = '';
                                for (let index = 0; index < data.length; index++) {
                                    html += `<tr>
                                        <td> ${data[index].formatted_date} </td>
                                        <td> ${data[index].title} </td>
                                        <td> ${data[index].details} </td>`;
                                    html += `
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="openEditJournalModel('${data[index].id}', '${data[index].routes.edit}', '${data[index].routes.update}')">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a></td>
                                        </td>
                                        </tr><tr class="spacer"></tr>`;
                                }
                                $('#search_journal').html(html);
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
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                    searchJournalPage();
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
@endpush
