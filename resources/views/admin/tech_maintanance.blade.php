@include('admin.adminnav')
  <div class="container-fluid">

    <div class="tab-pane" id="nav-maintenance" role="tabpanel" aria-labelledby="nav-maintenance-tab">
                        <div class="maintenance inner-tab-box">
                            <h3><span  class="active-span" id="active_ticket_span" onclick="maintanance_list(this.value)">Active Tickets</span> | <span id="complited_ticket_span" onclick="complited_ticket(this.value)">Completed Tickets</span><span><i class="fa fa-plus"data-toggle="modal" data-target="#maintenance-modal" style="background-color:#cecece; font-size:11px; padding:5px; border-radius:50%;color:#fff; float:right;"></i></span></h3>
                          <div id="active_ticket_div">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Submited by</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="maintanance_list_come_ajax">
            <?php foreach ($maintanance as $maintanance_list){
                    $emprec = DB::table('employee_details')->where(['id' => $maintanance_list->emp_id])->first();
            ?>
                <tr style="margin-bottom:10px;">
                    <td>{{ "#00".$maintanance_list->id }}</td>
                    <td>{{ $maintanance_list->subject }}</td>
                    <td><?php
                     if($maintanance_list->status == NULL){
                        echo "Pending";
                     }elseif ($maintanance_list->status == 1) {
                        echo "in progress";
                     }else if ($maintanance_list->status == 2) {
                        echo "Close";
                     }
                     ?></td>
                    <td>{{ $maintanance_list->updated_at }}</td>
                    <td>{{ isset($emprec->firstname) .' '. isset($emprec->lastname) }}</td>
                     <td>
                        <a href="javascript:void(0)" onclick="ticketInProgress({{ $maintanance_list->id  }})"><i class="fa fa-check-circle" title="In Progress"></i></a>
                        <a href="javascript:void(0)" title="Cancel!" onclick="ticketCancel({{ $maintanance_list->id  }})"><i class="fa fa-ban"></i></a>
                    </td>

                    <td class="action-box"><a href="javascript:void(0);" onclick="maintenanceEditView({{ $maintanance_list->id  }})" >EDIT</a>
                        <a href="javascript:void(0);" class="down" onclick="deleteMaintenance({{ $maintanance_list->id  }})">DELETE</a></td>
                </tr>
                <tr class="spacer"></tr>
              <?php  } ?>
                                </tbody>
                            </table>
                          </div>

                          <div id="complited_ticket_div" style="display:none;">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Submited by</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="maintanance_list_come_ajax_completed_ticket">
            <?php foreach ($maintanance1 as $maintanance_list){
                  $emprec = DB::table('employee_details')->where(['id' => $maintanance_list->emp_id])->first();
            ?>
                <tr style="margin-bottom:10px;">
                    <td>{{ "#00".$maintanance_list->id }}</td>
                    <td>{{ $maintanance_list->subject }}</td>
                    <td><?php
                     if($maintanance_list->status == NULL){
                        echo "Pending";
                     }elseif ($maintanance_list->status == 1) {
                        echo "in progress";
                     }else if ($maintanance_list->status == 2) {
                        echo "Close";
                     }
                     ?></td>
                    <td>{{ $maintanance_list->updated_at }}</td>
                    <td>{{ isset($emprec->firstname) .' '. isset($emprec->lastname) }}</td>
                     <td>
                        <a href="javascript:void(0)">View</a>
                    </td>

                </tr>
                <tr class="spacer"></tr>
            <?php } ?>
                                </tbody>
                            </table>
                          </div>
                        </div>
                      </div><!-------------end--------->



<div id="edit-maintenance-modal" class="modal fade bs-example-modal-lg edit-maintenance-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <!-- modal come on ajax-->
</div>

<div id="maintenance-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    <form class="maintenance1" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Subject</label>
                                    <input type="text" id="name" name="subject" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Website</label>
                                    <select class="select_status form-control" name="website">
                                        <option>Select</option>
                                        <option>Website1</option>
                                        <option>Website2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                A brief description of your ticket
                                <div class="text_outer">
                                    <label for="name" class="">Description</label>
                                    <input type="text" id="name" name="description" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Priority</label>
                                    <select class="select_status form-control" name="priority">
                                        <option>Select</option>
                                        <option>1</option>
                                        <option>2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Category</label>
                                    <select class="select_status form-control" name="category">
                                        <option>Select</option>
                                        @foreach($category as $category_ex_report)
                                        <option value="{{ $category_ex_report->id }}">{{ $category_ex_report->categoryname }}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="updated_at" value="{{ now() }}">
                                    <button type="submit" class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Maintenance</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

</div>

@include('admin.adminfooter')
