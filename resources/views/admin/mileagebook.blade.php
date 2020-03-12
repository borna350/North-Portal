 @include('admin.adminnav')
  <div class="container-fluid">

<div class="tab-pane total_mileage_list" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">

                        <!--- mileage List  -->
                            <div class="mileage inner-tab-box">

                            <h3><span  class="active-span" id="active_mileage_span">Pending </span>
                                <!--<span  id="old_mileage_span" >Old Contracts</span>
                                <span>-->
                                <i class="fa fa-plus" data-toggle="modal" data-target="#mileage-modal" style="background-color:#cecece; font-size:11px; padding:5px; border-radius:50%;color:#fff; float:right;"></i></span></h3>

                            <div id="active_mileage_div">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Reason for mileage</th>
                                        <th>Total Km</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="return_mileagelist">
                                  @foreach($mileage_list as $mlist)
                                     <tr style="margin-bottom:10px;">
                                        <td>{{ $mlist->date }}</td>
                                        <td>{{ $mlist->reasonmileage }}</td>
                                        <td>{{ $mlist->kilometers }}</td>
                                        <td class="action-box"><a href="javascript:void();" data-toggle="modal" data-target="#mileage-modaledit" data="{{ $mlist->id }}" class="edit_mileage" onclick="edit_mileage({{ $mlist->id }})">EDIT</a>
                                        <a href="#" class="down" onclick="delete_mileage({{ $mlist->id }});">DELETE</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                  @endforeach
                                </tbody>
                            </table>
                                </div>



                        </div>




                      </div><!-------------end--------->

</div>

<div id="mileage-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    <form id="employee_mileage" >

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Company</label>
                                    <select class="select_status form-control" name="companyname" id="companyname">
                                        <option>Select</option>
                                        @foreach($companies as $company)
                                        <option value="{{$company->companyname}}">{{$company->companyname}}</option>
                                       @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Date</label>
                                    <input type="date"  placeholder = "" name="date" class = "form-control"  >
                                </div>


                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Vehicle</label>
                                    <input type="text" id="vehicle" name="vehicle" class="form-control" placeholder="Insert text here">
                                </div>


                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">No of kilometers</label>
                                    <input type="text" id="kilometers" name="kilometers" class="form-control" placeholder="Insert figure here">
                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="text_outer">
                                    <label for="name" class="">Reason for mileage</label>
                                    <input type="text" id="reasonformileage" name="reasonformileage" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>

                        </div>
                        </hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" onclick="addmileage_details();" class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Mileage</span>

                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.adminfooter')
