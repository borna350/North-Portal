@extends('layouts.main')
@section('title','Benefits')
@section('content1')


    <div class="container-fluid">
        <div class="tab-content" id="nav-tabContent">

            <!--------------employee-------------->
            <div class="tab-pane fade show active" id="nav-plan" role="tabpanel" aria-labelledby="nav-plan-tab">
                <div class="plan inner-tab-box">
                    <h3><span class="active-span" id="plans_span">Active Plans </span></h3>

                    <div id="plans_div">
                        <table style="width:100%;">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="margin-bottom:10px;">
                                <td>12/09/2019</td>
                                <td>John Doe Benefits Plan</td>
                                <td class="action-box"></td>
                            </tr>
                            <tr class="spacer"></tr>


                            </tbody>
                        </table>
                    </div>


                </div>
            </div><!-------------end--------->

            <!--------------additional-------------->
            <div class="tab-pane fade" id="nav-additional" role="tabpanel" aria-labelledby="nav-additional-tab">
                <div class="additional inner-tab-box">
                    <h3>Pending | <span>History</span></h3>

                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr style="margin-bottom:10px;">
                            <td>12/09/2019</td>
                            <td>Brief description here</td>
                            <td>$50</td>
                            <td class="action-box"><a href="javascript:void();" data-toggle="modal"
                                                      data-target="#additional-modal">EDIT</a><a href="#" class="down">DELETE</a>
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                        <tr>
                            <td>12/09/2019</td>
                            <td>Brief description here</td>
                            <td>$50</td>
                            <td class="action-box"><a href="javascript:void();" data-toggle="modal"
                                                      data-target="#additional-modal">EDIT</a><a href="#" class="down">DELETE</a>
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                        <tr>
                            <td>12/09/2019</td>
                            <td>Brief description here</td>
                            <td>$50</td>
                            <td class="action-box"><a href="javascript:void();" data-toggle="modal"
                                                      data-target="#additional-modal">EDIT</a><a href="#" class="down">DELETE</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div><!-------------end--------->

            <!--------------Meal-------------->
            <div class="tab-pane fade" id="nav-meal" role="tabpanel" aria-labelledby="nav-meal-tab">
                <div class="meal inner-tab-box">
                    <h3>Current Orders | <span>Order History</span></h3>

                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr style="margin-bottom:10px;">
                        <tr style="margin-bottom:10px;">
                            <td>12/09/2019</td>
                            <td>Brief description here</td>
                            <td>$50</td>
                            <td class="action-box"><a href="javascript:void();" data-toggle="modal"
                                                      data-target="#meal-modal">EDIT</a><a href="#"
                                                                                           class="down">DELETE</a></td>
                        </tr>
                        <tr class="spacer"></tr>
                        <tr>
                            <td>12/09/2019</td>
                            <td>Brief description here</td>
                            <td>$50</td>
                            <td class="action-box"><a href="javascript:void();" data-toggle="modal"
                                                      data-target="#meal-modal">EDIT</a><a href="#"
                                                                                           class="down">DELETE</a></td>
                        </tr>
                        <tr class="spacer"></tr>
                        <tr>
                            <td>12/09/2019</td>
                            <td>Brief description here</td>
                            <td>$50</td>
                            <td class="action-box"><a href="javascript:void();" data-toggle="modal"
                                                      data-target="#meal-modal">EDIT</a><a href="#"
                                                                                           class="down">DELETE</a></td>
                        </tr>
                        <tr class="spacer"></tr>

                        </tbody>
                    </table>

                </div>
            </div><!-------------end--------->


        </div>
    </div>

@endsection
