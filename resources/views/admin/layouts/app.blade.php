<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.head')
    @yield('style')

    <style>
        div#toast-container {
            text-transform: capitalize;
        }

        .toast-top-right {
            top: 90px;
            right: 17px;
        }

    </style>
</head>

<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    @include('admin.layouts.header')
    @include('admin.layouts.breadcrumbs')

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        @include('admin.layouts.sidebar')

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="layout-top-spacing">
                    @yield('content')
                </div>
            </div>
        </div>
        <!--  END CONTENT AREA  -->

        @include('admin.layouts.footer')

    </div>
    <!-- END MAIN CONTAINER -->

    @include('admin.layouts.script')
    @yield('script')
</body>

<script>
    
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    @if (Session::has('message'))
        toastr.success("{{ session('message') }}");
    @endif

    @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (Session::has('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if (Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif


    jQuery.extend(jQuery.validator.messages, {
        required: "This field is required",
        remote: "Please fix this field",
        email: "Please enter a valid email address",
        url: "Please enter a valid URL",
        date: "Please enter a valid date",
        dateISO: "Please enter a valid date (ISO)",
        number: "Please enter a valid number",
        digits: "Please enter only digits",
        creditcard: "Please enter a valid credit card number",
        equalTo: "Please enter the same value again",
        accept: "Please enter a value with a valid extension",
        maxlength: jQuery.validator.format("Please enter no more than {0} characters"),
        minlength: jQuery.validator.format("Please enter at least {0} characters"),
        rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long"),
        range: jQuery.validator.format("Please enter a value between {0} and {1}"),
        max: jQuery.validator.format("Please enter a value less than or equal to {0}"),
        min: jQuery.validator.format("Please enter a value greater than or equal to {0}")
    });
 
 
</script>

</html>