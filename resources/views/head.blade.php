<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{ env('APP_NAME') }} - @yield('title', 'Home')</title>

    <!-- Bootstrap  CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom styles-->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Bootstrap core JavaScript -->

{{--    <script src="{{asset('js/bootstrap.min.js')}}"></script>--}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <!-- Custom scripts for this template -->
    {{--<script src="{{asset('js/agency.min.js')}}"></script>--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">

    <link rel="stylesheet" href="{{ asset('flatpicker/css/flatpickr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/jquery-spinner/css/bootstrap-spinner.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.css"/>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

    @stack('after-styles')

    <script>
        window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    </script>
</head>
