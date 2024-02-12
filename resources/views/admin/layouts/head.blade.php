<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title> {{ $title ? $title . ' | ' : '' }}Camara Qatar</title>

<link rel="icon" type="image/x-icon"
    href="{{ auth()->user()->user_image ? url('/') . '/' . auth()->user()->user_image : asset('assets/img/boy.png') }}" />
<link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/js/loader.js') }}"></script>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->  
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="{{ asset('assets/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
{{-- <link href="{{ asset('assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" /> --}}
<link href="{{ asset('assets/css/components/cards/card.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->


<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/sweetalert2.min.css') }}">
<link href="{{ asset('assets/bootstrap/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/magnific/magnific-popup.css') }}" rel="stylesheet">

<link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />


