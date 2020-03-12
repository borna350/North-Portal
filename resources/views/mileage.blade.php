<div class="row">
                            <div class="col-md-6 col-sm-6">
                                @csrf
                                <input type="hidden" name="editmileage_id" value="{{$mileagedetails->id}}">
                                <div class="text_outer">
                                    <label for="name" class="">Company</label>
                                    <select class="select_status form-control" name="companyname" id="companyname" >
                                        <option>Select</option>
                                        @foreach($companies as $company)
                                        
                                        <option value="{{$company->companyname}}" 
                                            {{ $company->companyname == $mileagedetails->company ? 'selected' : $company->companyname }}  >{{$company->companyname}}</option>
                                       
                                       @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Date</label>
                                    <input type="date"  placeholder = "" name="date" class = "form-control" value={{isset($mileagedetails->date) ? $mileagedetails->date : ''}} >
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Vehicle</label>
                                    <input type="text" id="vehicle" name="vehicle" class="form-control" placeholder="Insert text here" value={{isset($mileagedetails->date) ? $mileagedetails->vehicle : ''}}>
                                </div>
                                
                                
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">No of kilometers</label>
                                    <input type="text" id="kilometers" name="kilometers" class="form-control" placeholder="Insert figure here" value={{isset($mileagedetails->date) ? $mileagedetails->kilometers : ''}}>
                                </div>
                                
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="text_outer">
                                    <label for="name" class="">Reason for mileage</label>
                                    <input type="text" id="reasonformileage" name="reasonformileage" class="form-control" placeholder="Insert text here" value={{isset($mileagedetails->date) ? $mileagedetails->reasonmileage : ''}}>
                                </div>
                            </div>
                            
                        </div>
                        </hr>               
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" onclick="editmileage_details();" class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Mileage</span>
                                    
                                </div>
                            </div>
                        </div>