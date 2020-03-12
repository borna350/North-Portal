@extends('layouts.main')
@section('title','Time off')
@section('content1')

    <div class="container-fluid">

        <div class="tab-pane" id="nav-time" role="tabpanel" aria-labelledby="nav-time-tab">
            <div class="time inner-tab-box">
                <div class="col-md-12" style="text-align:center">
                    <h3 class="clickable">Requests | <span>Team Calendar</span></h3>
                </div>
                <div class="request">
                    <h3><span class="active-span clickable" id="pending_span" onclick="expences_pending(this.value)">Pending </span> | <span class="clickable" id="historical_span" onclick="expense_history(this.value)"> Historical</span><span><i class="fa fa-plus" data-toggle="modal" data-target="#time-modal" style="background-color:#cecece; font-size:11px; padding:5px; border-radius:50%;color:#fff; float:right;"></i></span></h3>

                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <th>Requested by</th>
                            <th>Type</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Total no. days</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr style="margin-bottom:10px;">
                            <td>John Doe</td>
                            <td>Time off</td>
                            <td>MM/DD/YYYY</td>
                            <td>MM/DD/YYYY</td>
                            <td>2</td>
                            <td>Time off for vacation</td>
                            <td class="action-box"><a href="javascript:void();" data-toggle="modal" data-target="#time-modal">EDIT</a><a href="#" class="down">DELETE</a></td>
                        </tr>
                        <tr class="spacer"></tr>

                        </tbody>
                    </table>
                </div>
                <div class="calender">
                </div>
            </div>
        </div><!-------------end--------->

    </div>

    <div id="time-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form id="" action="" >
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox"> Vacation
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox"> Sick Day
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-check-label">
                                            <input class="form-check-input allday" type="checkbox"> All Day
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Start Date</label>
                                        <input type="date"  class="form-control datepicker" placeholder="Select">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Start Time</label>
                                        <select class=" form-control" id="starttime" name="starttime">
                                            {{ get_times() }}</select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">End Date</label>
                                        <input type="date"  class="form-control datepicker" placeholder="Select">
                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">End Time</label>
                                        <select class=" form-control" id="endtime" name="endtime">
                                            {{ get_times() }}</select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    *Dates are available.
                                    <div class="text_outer">
                                        <label for="name" class="">Notes</label>
                                        <input type="text" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    *Dates are available.
                                    <div class="text_outer">
                                        <label for="name" class="">Notes</label>
                                        <input type="text" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12" style="display:inline-flex;">
                                    <div class="col-md-6 col-sm-6">
                                        <label class="form-check-label">
                                            Number of days taken to date:
                                        </label>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="" style="border:0px; border-bottom:1px solid;padding: 0px;background-color: #fff !important;margin-left: -42%; margin-top: -18px;">
                                    </div>
                                </div>
                            </div>
                            </hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="submit" class="btn-dark contact_btn">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Time Off</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.allday').click(function()
            {
                if ($(this).is(":checked"))
                {
                    $("#starttime").prop("disabled", true);
                    $("#endtime").prop("disabled", true);
                }
                else{
                    $("#starttime").prop("disabled", false);
                    $("#endtime").prop("disabled", false);
                }
            });

        });
    </script>
@endsection
