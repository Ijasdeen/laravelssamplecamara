<!DOCTYPE html>
<html lang="en">

<head>
    @include('auth.layouts.head')

    <style>
        div#toast-container {
            text-transform: capitalize;
        }

    </style>
</head>

<body class="form">

    <div>
        @yield('content')
    </div>

    @include('auth.layouts.script')

    @yield('script')
</body>
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
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
</script>

</html>