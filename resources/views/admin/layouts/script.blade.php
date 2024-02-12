<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{ asset('assets/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />   
 

<script>
    $(document).ready(function() {
        App.init();
        $('select').select2({
            closeOnSelect: true,  
        });
        $('.card-body .float-left.form-group select').select2({
            closeOnSelect: true,
            placeholder: "All",
            allowClear: true,
 
        });
 
         
		
    });
</script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>


<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="{{ asset('assets/plugins/apex/apexcharts.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/dashboard/dash_1.js') }}"></script> --}}

<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>


<script type="text/javascript" src="{{ asset('assets/bootstrap/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/magnific/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>


 <script src="{{ asset('assets/js/daterangepicker.js') }}"></script> 

<script>
$(function(){
    $('.image-link').magnificPopup({
                         type: 'image',
                         closeOnBgClick:true
    }); 
    }); 
</script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->