@extends('admin.layouts.app')


@section('content')

<style>
     a.btn.btn-primary.btn-sm {
        margin-right: 8px;
    }
</style>
    <div>
        <div class="row mt-3 mb-3">
            <div class="col-lg-8">
                <div class="card" style="border-radius: 6px;">
                    <div class="card-body">
                       
                        <div class="table-responsive">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Banner</th> 
                                        <th>Redirection</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-lg-4 mt-lg-0 mt-3">
                 <div class="card text-left mt-md-0 mt-3" style="border-radius: 6px;">
                    <div class="card-header bg-primary">
                        <h3>
                            Create Banner
                        </h3>
                    </div>


                    <form action="{{ route('manage-banner.store') }}" id="banner_form" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <div class="card-body">

                        <div class="form-group">
                                <label for="banner_type">Banner Type</label>
                                <select name="banner_type" id="banner_type" class="form-control form-control-inverse">
                                 <option value="">Select Banner Type</option>
                                 <option value="event">Event</option>
                                 <option value="services">Services</option>
                                 <option value="benefits">Benefits</option> 
                                 </select>
                            </div>
                            <div class="form-group" id="event_formgroup">
                                <label for="events_chosen">Events</label>
                                <select name="events_chosen" id="events_type" class="form-control form-control-inverse">
                                 <option value=""><--Select event--></option>
                                  @foreach($events as $event)
                                    <option value="{{$event->id}}">{{$event->title}}</option>
                                  @endforeach 
                                 </select>
                                 <div></div>
                            </div>

                            <div class="form-group d-none" id="benefits_formgroup">
                                <label for="Benefits_chosen">Benefits</label>
                                <select name="Benefits_chosen" id="Benefits_chosen" class="form-control form-control-inverse">
                                 <option value=""><--Select Benefits--></option>
                                  @foreach($benefits as $benefit)
                                    <option value="{{$benefit->id}}">{{$benefit->title}}</option>
                                  @endforeach 
                                 </select>
                            </div>

                            
                            <div class="form-group d-none" id="services_formgroup">
                                <label for="services_chosen">Services</label>
                                <select name="services_chosen" id="services_chosen" class="form-control form-control-inverse">
                                 <option value=""><--Select services--></option>
                                  @foreach($Services as $service)
                                    <option value="{{$service->id}}">{{$service->title}}</option>
                                  @endforeach 
                                 </select>
                            </div>




                           
                            <div class="form-group">
                                <label for="redirection">Redirection</label>
                              <div>
                              <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" checked class="form-check-input" value="on" name="redirection">On
                                </label>
                                </div>
                                <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="off" name="redirection">Off
                                </label>
                                </div>
                              </div>

                            </div>
                           

                        <div class="form-group">
                                <label for="banner_image">Image</label>
                                <input type="file" id="banner_image" accept="image/*" class="@error('banner_image') is-invalid @enderror"
                                    name="banner_image" onchange="previewFile(this);"
                                    value="{{ old('banner_image') }}" />
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <img class="previewImg img-thumbnail" style="border: none !important;"  src="{{asset('assets/images/transparent.png') }}" alt="Placeholder">
                         
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>

                </div> 

            </div>

        </div>
    </div>

@endsection

@section('script')
 
    <script>
       
        $(document).ready(function() {
         
            // var id = 3;
            // init datatable.
            var dataTable = $('.datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                scrollX: true,
                "order": [
                    [0, "desc"]
                ],
                ajax: "{{ route('manage-banner.index') }}",
                columns: [
                    {
                        data: 'id'
                    },
                    {
                        data: 'banner_image'
                    }, 
                    {
                        data: 'banner_type'
                    },  {
                        data: 'redirection'
                    }, 
                    
                    {
                        data: 'Actions',
                        orderable: false,
                        serachable: false,
                        sClass: 'd-flex justify-content-center'
                    },
                ],
                drawCallback: function(){
                     $('.image-link').magnificPopup({
                         type: 'image',
                         closeOnBgClick:true
                     }); 
                }
            });


            // Delete Banner Ajax request.
            $(document).on("click", ".DeleteBanner", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete it permenatly ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/manage-banner/') }}/" + id,
                            method: 'DELETE',
                            success: function(result) {
                                if (result.error) {
                                    toastr.error(result.error);
                                } else {
                                    $('.datatable').DataTable().ajax.reload();
                                    toastr.success(result.success);
                                }
                            }
                        });
                    }
                });
            });   

 
            $('#banner_type').change(function(e){
                let value = e.target.value; 
                if(value=="event"){
                    $('#event_formgroup').removeClass("d-none"); 
                    $('#benefits_formgroup').addClass("d-none"); 
                    $("#services_formgroup").addClass("d-none");
                }
                else if(value=="services"){
                    $('#event_formgroup').addClass("d-none"); 
                    $('#benefits_formgroup').addClass("d-none"); 
                    $("#services_formgroup").removeClass("d-none");
                }
                else if(value=='benefits'){
                    $('#event_formgroup').addClass("d-none"); 
                    $('#benefits_formgroup').removeClass("d-none"); 
                    $("#services_formgroup").addClass("d-none");
                }
                else {
                    $('#event_formgroup').addClass("d-none"); 
                    $('#benefits_formgroup').addClass("d-none"); 
                    $("#services_formgroup").addClass("d-none");
                }
              
            }); 
 

            $('#banner_form').validate({
                rules: {
                    banner_image: {
                        required: true,
                    } ,
                    banner_type:{
                        required: true,
                    }
                },
                messages: {
                    banner_image: {
                        required: "Banner image field is required",
                    } ,
                    banner_type: {
                        required: "Banner type field is required",
                    } 
                },
                errorClass: "text-danger is-invalid",
                errorElement: 'div'
            });
        });

     function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
            console.log(input);
            reader.onload = function(){
                $("div").find(".previewImg").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
    </script>
@endsection