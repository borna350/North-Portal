<!DOCTYPE html>
<html lang="en">

@include('head')

@php if (!isset($activeMenu)) $activeMenu = ''; @endphp
<body id="page-top">
<div id="app">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
        <div class="container-fluid">
            <a class="navbar-brand js-scroll-trigger logo_se" href="{{ route('home') }}"><img width="150" src="{{asset('img/logo.jpg')}}" alt=""></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            @if (auth()->check())
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <div id="myTabMain">
                        <ul id="myTab" role="tablist" class="navbar-nav text-uppercase nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }}" href="{{ route('edit-profile') }}">My Profile </a>
                            </li>

                        @if(!auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link {{ $activeMenu == 'submit' ? 'active' : '' }}" href="{{ route('employee.module') }}">Admin </a>
                        </li>
                        @endif

                            @admin
                            <li class="nav-item">
                                <a class="nav-link {{ $activeMenu == 'company' ? 'active' : '' }}" href="{{ route('companies.index') }}" role="tab">Company</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ $activeMenu == 'admin' ? 'active' : '' }}" href="{{ route('users.index') }}" role="tab">Admin</a>
                            </li>
                            @endadmin

                            @if(!auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link {{ $activeMenu == 'benefits' ? 'active' : '' }}" href="{{ route('benefits.module') }}" role="tab">Benefits</a>
                            </li>
                            @endif

                            @admin
                            <li class="nav-item">
                                <a class="nav-link {{ $activeMenu == 'benefits' ? 'active' : '' }}" href="{{ route('plans.index') }}" role="tab">Benefits</a>
                            </li>
                            @endadmin

                            <li class="nav-item">
                                <a class="nav-link {{ $activeMenu == 'classroom' ? 'active' : '' }}" href="{{ auth()->user()->is_admin ? route('missions.index') : route('employee.classroom.courses') }}" role="tab">Classroom</a>
                            </li>
                        </ul>
                    </div>
                    <div class="pull-right">
                        <ul class="navbar-nav text-uppercase">
                            <li class="nav-item">
                                <a class="nav-link js-scroll-trigger" href="javascript:void(0)"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <img src="{{asset('img/sign.jpg')}}" alt="" width="24p">
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </nav>
</div>

{{--
@if (isset($subnav))
    @include($subnav)
@endif  --}}
@if (auth()->check())
    <nav class="top_tab_details">
        <div class="container-fluid">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                {{--<a class="nav-item nav-link  {{ (request()->is('home')) ? 'active' : '' }}" id="nav-employee-tab"  href="{{ url('home') }}" aria-controls="nav-employee" aria-selected="true">Employee Information</a>--}}

            @if($activeMenu == 'profile')

            <a class="nav-item nav-link {{ (request()->is('edit-profile')) ? 'active' : '' }}" href="{{ route('edit-profile') }}">Employee Information</a>

            <a class="nav-item nav-link {{ (request()->is('agreements')) ? 'active' : '' }}" href="{{ route('agreements.index') }}">Agreements</a>

            <a class="nav-item nav-link {{request()->is('paystatements') ? 'active' : '' }}" href="{{ route('paystatements.index') }}">Pay Statements</a>

            @endif

            @if($activeMenu == 'company')
                <a class="nav-item nav-link {{ (request()->is('companies')) ? 'active' : '' }}" href="{{ route('companies.index') }}">Company List</a>
            @endif

                @if($activeMenu == 'admin' || $activeMenu == 'submit')
                    @if(auth()->user()->is_admin)
                        <a class="nav-item nav-link {{ (request()->is('users')) ? 'active' : '' }}" href="{{ route('users.index') }}">Employee List</a>
                    @endif

                    @can('expenses-enabled')
                        <a class="nav-item nav-link {{ (request()->is('expenses')) ? 'active' : '' }}" href="{{ route('expenses.index') }}">Expense Report</a>
                    @endcan


                    @can('mileage-enabled')
                        <a class="nav-item nav-link {{ (request()->is('mileages')) ? 'active' : '' }}" href="{{ route('mileages.index') }}">Mileage Book</a>
                    @endcan

                    <a class="nav-item nav-link {{ (request()->is('maintenance_tickets')) ? 'active' : '' }}" href="{{ route('maintenance_tickets.index') }}">Tech Maintenance</a>

                    <a class="nav-item nav-link {{ (request()->is('timeoff/*')) ? 'active' : '' }}" href="{{ url('timeoff/list') }}">Time Off</a>

                    <a class="nav-item nav-link {{ (request()->is('messages')) ? 'active' : '' }}" href="{{ route('messages.index') }}">Report a Concern</a>
                    @if(auth()->user()->is_admin)
                        <a class="nav-item nav-link {{ (request()->is('efficiency')) ? 'active' : '' }}" href="{{ route('efficiency.index') }}">Efficiency</a>
                    @endif
                @endif

                @if($activeMenu == 'benefits')
                    <a class="nav-item nav-link {{ (request()->is('plans')) ? 'active' : '' }}" href="{{ route('plans.index') }}">Plan Overview</a>
                    <a class="nav-item nav-link {{ (request()->is('additionl_benifits_spendings')) ? 'active' : '' }}" href="{{ route('additionl_benifits_spendings.index') }}">Additional Benefits
                        Spending</a>
                    <a class="nav-item nav-link" href="#">Meals</a>
                @endif

                @if($activeMenu == 'classroom' && auth()->user()->is_admin)
                    <a class="nav-item nav-link {{ (request()->is('missions')) ? 'active' : '' }}" href="{{ route('missions.index') }}">49 North Mission</a>
                    <a class="nav-item nav-link {{ (request()->is('personal_development_plans')) ? 'active' : '' }}" href="{{ route('personal_development_plans.index') }}">Personal Development Plan</a>
                    <a class="nav-item nav-link {{ (request()->is('admin/classroom*')) ? 'active' : '' }}" href="{{ route('admin.classroom.index') }}">Courses</a>
                    <a class="nav-item nav-link {{ (request()->is('journal')) ? 'active' : '' }}" href="{{ route('journal.index') }}">Journal</a>
                @endif

            </div>
        </div><!--------------container--------------->
    </nav>
@endif

<div class="container-fluid">


    @if ($errors->any())
        <br>
        <div class="alert alert-danger all_errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    <div class="ajax-delete-msg" style="display: none">
        <br>
        <div class="alert alert-danger" role="alert">
            You have successfully deleted an item.
        </div>
    </div>
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(session()->has('alert-' . $msg))
                <br>
                <p class="alert alert-{{ $msg }}">
                    {!! nl2br(session()->get('alert-' . $msg)) !!} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </p>
            @endif
        @endforeach
    </div>
</div>



@yield('content1')

<div class="logout-footer fixed-bottom float-right">
    @if (Auth::check())
        <div class="text-right">
            @if (session()->exists('was-admin-id') && session()->exists('was-admin'))
                <a class="btn btn-secondary" style="margin-bottom: 30px; margin-right: 20px;" href="{{ route('force-login',[session()->get('was-admin-id'),'return' => 1]) }}">
                    <small>Return To Admin</small>
                </a>
            @endif
            {{--      <a class="btn btn-primary btn-charcoal" href="{{ route('admin.logout') }}">
                      <small>Logout</small>
                  </a>--}}
        </div>
    @endif
</div>

{{--<script type="text/javascript" src="{{ asset('js/jquery.inputmask.min.js') }}"></script>--}}
<script>
    const $confirmText = 'Are you sure you want to delete this item?';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });

    $("document").ready(function () {
        setTimeout(function () {
            $("p.alert").remove();
        }, 5000); // 5 secs

        $(".flatpickr").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });

        $('.select2').select2();
    });

    // Format date
    function formatDate(date) {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    // File preview
    function renderChoosedFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var fileName = input.files[0].name;

            reader.onload = function (e) {
                if (input.files[0]['type'].split('/')[0] === 'image') {
                    $(input).closest('.image-chooser').find('.image-chooser-preview').html('<img class="image-preview" src="' + e.target.result + '" />');
                } else {
                    $(input).closest('.image-chooser').find('.image-chooser-preview').html('<a class="file-preview" href="' + e.target.result + '">' + fileName + '</a>');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    const is_admin = parseInt({{ auth()->user()->is_admin }});
    const is_ticket_admin = parseInt({{ auth()->user()->is_ticket_admin }});
    const auth_id = parseInt({{ auth()->id() }});
</script>

<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
<script src="{{ URL::asset('toaster/jquery.toaster.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-spinner/js/jquery.spinner.js') }}"></script>
<script src="{{asset('flatpicker/js/flatpicker.min.js')}}"></script>
<script src="{{asset('js/pagination.min.js')}}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
@stack('scripts')
@yield('js')

</body>
</html>
