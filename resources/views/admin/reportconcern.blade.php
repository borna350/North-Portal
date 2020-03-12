@include('admin.adminnav')
  <div class="container-fluid">

   <div class="tab-pane" id="nav-concern_report" role="tabpanel" aria-labelledby="nav-concern-tab">
                        <div class="concern_report inner-tab-box">
                            <h3>Pending | <span>Historical</span></h3>

                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Subject</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="margin-bottom:10px;">
                                        <td>MM/DD/YYYY</td>
                                        <td>Subject line here</td>
                                        <td class="action-box"><a href="javascript:void();" data-toggle="modal" data-target="#concern-modal">EDIT</a><a href="#" class="down">DELETE</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    <tr style="margin-bottom:10px;">
                                        <td>MM/DD/YYYY</td>
                                        <td>Subject line here</td>
                                        <td class="action-box"><a href="javascript:void();" data-toggle="modal" data-target="#concern-modal">EDIT</a><a href="#" class="down">DELETE</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    <tr style="margin-bottom:10px;">
                                        <td>MM/DD/YYYY</td>
                                        <td>Subject line here</td>
                                        <td class="action-box"><a href="javascript:void();" data-toggle="modal" data-target="#concern-modal">EDIT</a><a href="#" class="down">DELETE</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    <tr style="margin-bottom:10px;">
                                        <td>MM/DD/YYYY</td>
                                        <td>Subject line here</td>
                                        <td class="action-box"><a href="javascript:void();" data-toggle="modal" data-target="#concern-modal">EDIT</a><a href="#" class="down">DELETE</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>

                                </tbody>
                            </table>

                        </div>
                      </div><!-------------end--------->

@include('admin.adminfooter')
