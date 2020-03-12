
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title> North Portal</title>

  <!-- Bootstrap  CSS -->
  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Custom styles-->
  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style type="text/css">
    #nav-tab.nav-tabs .nav-link {
    border: 0px solid transparent;
    color: #a5a5a5;
    float: left;
    padding: 0 0 15px;
    margin: 0px 0 0 80px;
}
  </style>
</head>

<body id="page-top">

  <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
    <div class="container-fluid">
      <a class="navbar-brand js-scroll-trigger logo_se" href="#page-top"><img width="150" src="{{asset('img/logo.jpg')}}" alt="" ></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul id="myTab" role="tablist" class="navbar-nav text-uppercase nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" id="profile-tab" href="{{ url('admin/registration') }}" role="tab" aria-controls="profile" aria-selected="true" >Registration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="true" onclick="get_agreementlist()">Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefits" role="tab" aria-controls="benefits" aria-selected="true">Benefits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="classroom-tab" data-toggle="tab" href="#classroom" role="tab" aria-controls="classroom" aria-selected="true">Classroom</a>
          </li>
        </ul>
         <ul class="navbar-nav text-uppercase ">
          <li class="nav-item">
            <!--<a class="nav-link js-scroll-trigger" href="#"><img src="{{asset('img/sign.jpg')}}" alt="" width="24p" ></a>-->

            <a class="nav-link js-scroll-trigger" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>

        </ul>
      </div>
    </div>

  </nav>
  <div class="col-md-12">
    <nav class="top_tab_details">
                  <div class="container-fluid">
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link nav_agreement" id="agree" href="{{ url('admin/agreement') }}" role="tab" aria-controls="nav-agree" aria-selected="true" >Agreement</a>
                        <a class="nav-item nav-link nav_expense" id="nav-expense-tab" href="{{ url('admin/expences_report') }}" role="tab" aria-controls="nav-expense" aria-selected="true">Expense Report</a>
                        <a class="nav-item nav-link nav_mileage" id="nav-mileage-tab" href="{{ route('admin.mileage-book') }}" role="tab" aria-controls="nav-mileage" aria-selected="false" >Mileage Book</a>
                        <a class="nav-item nav-link" id="nav-maintenance-tab" href="{{ url('admin/tech_maintanance') }}" role="tab" aria-controls="nav-maintenance" aria-selected="false">Tech Maintenance</a>
                        <a class="nav-item nav-link" id="nav-time-tab"  href="{{ url('admin/timeoff') }}" role="tab" aria-controls="nav-time" aria-selected="false">Time Off</a>
                        <a class="nav-item nav-link" id="nav-concern_report-tab" href="{{ url('admin/reportconcern') }}" role="tab" aria-controls="nav-concern_report" aria-selected="false">Report a Concern</a>

                        <a class="nav-item nav-link" id="nav-statements-tab" href="{{ route('admin.pay-statements') }}" >Pay Statements</a>
                      </div>
                  </div><!--------------container--------------->
                </nav>
  </div>
