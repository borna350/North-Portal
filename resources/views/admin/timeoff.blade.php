 @include('admin.adminnav')
  <div class="container-fluid">

     <div class="tab-pane" id="nav-time" role="tabpanel" aria-labelledby="nav-time-tab">
                        <div class="time inner-tab-box">
                            <div class="col-md-12" style="text-align:center">
                                <h3>Requests | <span>Team Calendar</span></h3>
                            </div>
                            <div class="request">
                                <h3>Pending | <span>Historical</span></h3>

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

@include('admin.adminfooter')
