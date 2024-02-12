<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('assets/js/authentication/form-1.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>


<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script>
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