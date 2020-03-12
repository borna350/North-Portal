 @include('admin.adminnav')
  <div class="container-fluid">

 <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
                            <div class="expense inner-tab-box">
                                <h3><span  class="active-span" id="pending_span" onclick="expences_pending(this.value)">Pending </span> | <span  id="historical_span" onclick="expences_histocial(this.value)"> Historical</span><span><i class="fa fa-plus" data-toggle="modal" data-target="#expense-modal" style="background-color:#cecece; font-size:11px; padding:5px; border-radius:50%;color:#fff; float:right;"></i></span></h3>

                                <div id="pending_div">
                                    <table style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="return_expence_ajax">
                                        @foreach ($expence as $expence_list)
                                             <tr style="margin-bottom:10px;">
                                                <td>{{  $expence_list->date }}</td>
                                                <td>{{ $expence_list->description }}</td>
                                                <td>{{ $expence_list->total }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" onclick="expence_approve({{ $expence_list->id  }})"><i class="fa fa-check-circle" title="Approved"></i></a>
                                                    <a href="javascript:void(0)" title="Reject!" onclick="expence_reject({{ $expence_list->id  }})"><i class="fa fa-ban"></i></a>
                                                </td>
                                                <td class="action-box"><a href="javascript:void(0);" onclick="edit_view_ajax({{ $expence_list->id  }})" >EDIT</a><a href="javascript:void(0);" class="down" onclick="delete_expence({{ $expence_list->id  }})">DELETE</a></td>
                                            </tr>
                                            <tr class="spacer"></tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="historical_div" style="display:none;">
                                    <table style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="return_expence_ajax_history">


                                        </tbody>
                                    </table>

                                </div>

                             </div>
                        </div><!-------------end--------->

</div>



<div id="expense-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- body modal -->
            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    <form class="expences" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Company</label>
                                    <select class="select_status form-control" name="company">
                                        <option value="">Select</option>
                                      @foreach($companies as $company_ex_report)
                                        <option value="{{ $company_ex_report->id }}">{{ $company_ex_report->companyname }}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Date</label>
                                    <input type="date"  placeholder = "" class = "form-control" name="date">
                                </div>


                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Category</label>
                                    <select class="select_status form-control" name="category">
                                        <option value="">Select</option>
                                      @foreach($category as $category_ex_report)
                                        <option value="{{ $category_ex_report->id }}">{{ $category_ex_report->categoryname }}</option>
                                      @endforeach
                                    </select>
                                </div>


                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Purchase via</label>
                                    <select class="select_status form-control" name="purchase">
                                        <option value="">Select</option>
                                       @foreach($purchases as $purchases_ex_report)
                                        <option value="{{ $purchases_ex_report->id }}">{{ $purchases_ex_report->purchasename }}</option>
                                      @endforeach
                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Project</label>
                                    <select class="select_status form-control" name="project">
                                        <option value="">Select</option>
                                      @foreach($project as $project_ex_report)
                                        <option value="{{ $project_ex_report->id }}">{{ $project_ex_report->projectname }}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Select Receipt</label>
                                    <select class="select_status form-control" name="receipt">
                                        <option value="">Select</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Description</label>
                                    <input type="text" id="name" name="description" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-12 col-sm-12">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="checkbox" name="billable"> Billable
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display:inline-flex;">
                                        <div class="col-md-7 col-sm-7">

                                            <label class="form-check-label">
                                              <input class="form-check-input" type="checkbox" name="    "> Received authorization
                                            </label>

                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <input type="text" id="name" name="received_auth" class="form-control" placeholder="" style="border:0px; border-bottom:1px solid;padding: 0px;background-color: #fff !important;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Subtotal</label>
                                    <input type="text" id="name" name="subtotal" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">GST</label>
                                    <input type="text" id="name" name="gst" class="form-control" placeholder="Insert Figure here">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">PST</label>
                                    <input type="text" id="name" name="pst" class="form-control" placeholder="Insert Figure here">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Total</label>
                                    <input type="text" id="name" name="total" class="form-control" placeholder="Insert Figure here">
                                </div>
                            </div>
                        </div>
                        </hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                    <input type="submit" class="btn-dark contact_btn" value="Save" data-form="expences">
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Expense Reports</span>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<div id="expense-modal-edit" class="modal fade bs-example-modal-lg expense-modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <!--ajax come modal-->

</div>

@include('admin.adminfooter')
