
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company</label>
                                        <select class="select_status form-control" name="company">
                                            <option value="{{ $company->id;  }}">
                                                {{ $company->companyname;  }}</option>
                                            <?php foreach ($companies as $company_ex_report) { ?>
                                                <option
                                                    value="{{ $company_ex_report->id  }}">
                                                    {{ $company_ex_report->companyname  }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Date</label>
                                        <input type="date" placeholder="" value="{{ $expense->date;  }}"
                                               class="form-control" name="date">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Category</label>
                                        <select class="select_status form-control" name="category">
                                            <option
                                                value="{{ $category1->id  }}">
                                                {{ $category1->categoryname  }}</option>
                                            <?php foreach ($category as $category_ex_report) { ?>
                                                <option
                                                    value="{{ $category_ex_report->id  }}">
                                                    {{ $category_ex_report->categoryname  }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Purchase via</label>
                                        <select class="select_status form-control" name="purchase">
                                            <option value="{{ $purchase->id  }}">
                                                {{ $purchase->purchasename  }}</option>
                                            <?php foreach ($purchases as $purchases_ex_report) { ?>
                                                <option
                                                    value="{{ $purchases_ex_report->id  }}">
                                                    {{ $purchases_ex_report->purchasename  }}</option>
                                            <?php } ?>
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
                                            <option value="{{ $projects->id  }}">
                                                {{ $projects->projectname  }}</option>
                                            <?php foreach ($project as $project_ex_report) { ?>
                                                <option
                                                    value="{{ $project_ex_report->id  }}">
                                                    {{ $project_ex_report->projectname  }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Select Receipt</label>
                                        <input type="file" name="receipt" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Description</label>
                                        <input type="text" id="name" name="description" class="form-control"
                                               value="{{ $expense->description  }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox"
                                                   name="billable" <?php if ($expense->billable == "on") {
                                                echo "checked";
                                            } ?> style="margin-left: -12.01rem;"> Billable
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="display:inline-flex;">
                                            <div class="col-md-7 col-sm-7">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="" style="margin-left: -7.25rem;"> Received
                                                    authorization
                                                </label>
                                            </div>
                                            <div class="col-md-5 col-sm-5">
                                                <input type="text" id="name" name="received_auth" class="form-control"
                                                       vale="{{ $expense->received_auth;  }}"
                                                       style="border:0px; border-bottom:1px solid;padding: 0px;background-color: #fff !important;">
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
                                        <input type="number" id="name" name="subtotal" class="form-control"
                                               value="{{ $expense->subtotal  }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">GST</label>
                                        <input type="number" id="name" name="subtotal" class="form-control"
                                        <input type="text" id="name" name="gst" class="form-control"
                                               value="{{ $expense->gst  }}">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">PST</label>
                                        <input type="number" id="name" name="pst" class="form-control"
                                               value="{{ $expense->pst  }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Total</label>
                                        <input type="number" id="name" name="total" class="form-control"
                                               value="{{ $expense->total  }}">
                                    </div>
                                </div>
                            </div>
                            </hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                                        <input type="hidden" name="emp_id" value="{{ auth()->user()->id  }}">
                                        <input type="hidden" name="id" value="{{ $expense->id  }}">
                                        <input type="submit" class="btn-dark contact_btn"
                                               value="Save">
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i
                                                class="fa fa-arrow-left"></i> Return to Expense Reports</span>
                                    </div>
                                </div>
                            </div>
