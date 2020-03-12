@include('admin.adminnav')
  <div class="container-fluid">
   <div class="tab-pane " id="nav-statements" aria-labelledby="nav-statements-tab">
                        <div class="agreements">
                            <h3><span  class="active-span" id="active_contracts_span">Active Contracts </span> | <span  id="old_contracts_span"> Old Contracts</span></h3>
                            
                            <div id="active_contracts_div">
                                <div class="top_part_">
                                    <ul>
                                        <li>Date</li>
                                        <li>Descripon</li>
                                    </ul>
                                </div>
                              @if($user_list)
                            	@foreach($user_list as $plist)
                                <div class="download_file">
                                    <div class="left_part">
                                        <p>12/09/2019</p>
                                        <p>John Doe Contract of Employment</p>
                                    </div>
                                    <div class="right_part">
                                    	<a href="#show_modal_paystatement" data-toggle="modal" data-target="#show_modal_paystatement">UPLOAD</a>
                                        <a href="#">VIEW</a>                                        
                                    </div>
                                </div><!------------------>
                              @endforeach
                            @endif
                            </div>
                           
                            <div id="old_contracts_div" style="display:none;">
                                <div class="top_part_">
                                    <ul>
                                        <li>Date</li>
                                        <li>Descripon</li>
                                    </ul>
                                </div>
                                <div class="download_file">
                                    <div class="left_part">
                                        <p>12/09/2019</p>
                                        <p>John Doe Contract of Employment</p>
                                    </div>
                                    <div class="right_part">
                                        <a href="#">VIEW</a>
                                        
                                    </div>
                                </div><!------------------>
                                <div class="download_file">
                                    <div class="left_part">
                                        <p>12/09/2019</p>
                                        <p>John Doe Contract of Employment</p>
                                    </div>
                                    <div class="right_part">
                                        <a href="#">VIEW</a>
                                        
                                    </div>
                                </div><!------------------>
                            </div>
                            
                        </div>
                      </div>


<div id="show_modal_paystatement" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    <form id="upload_agreement" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf
                        <input type="hidden"  name="employee_id" id="employee_id_modal">
                        <input type="hidden"  name="agreement_type" id="agreement_type">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text_outer">
                                    <label for="name" class="">Description</label>
                                    <input type="text" id="name" name="subject" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>
                            <div class="col-md-4">
                               <div class="text_outer">
                                    <label for="name" class="">Date</label>
                                    <input type="date" id="name" name="subject" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>
                            <div class="col-md-4">  
                                <div class="text_outer file_upload" style="height: 60px;">
                                    <label for="name" class="">Upload PDF</label>
                                    <input type="file"  name="agreement_file" class="form-control" id="agreement_file" style="height: 30px;" required>
                                </div>
                            </div>
                        </div>
                        </hr>               
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit"  class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Paystatement</span>
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
  
