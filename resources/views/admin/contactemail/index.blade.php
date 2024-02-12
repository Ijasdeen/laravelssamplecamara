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
                                        <th>Email</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-lg-4 mt-lg-0 mt-3">
                @if(request()->segment(count(request()->segments())) == "edit")
                <div class="card" style="border-radius: 6px;">

                    <div class="card-header bg-warning">
                        <h3>Edit Contact Email</h3>
                    </div>


                    <form action="{{ route('manage-contact-email.update', $contactemail->id) }}" id="contactemail_edit_form" method="POST" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="email">Email</label>

                                <input type="email" id="email"  class="form-control @error('email') is-invalid @enderror "
                                    name="email" placeholder="Enter Email"
                                    value="{{ $contactemail->email }}" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div> 
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <div  class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning mr-1">Update</button>
                                <a href="{{ route('manage-contact-email.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>

            @else

                <div class="card text-left mt-md-0 mt-3" style="border-radius: 6px;">
                    <div class="card-header bg-primary">
                        <h3>
                            Create Contact Email
                        </h3>
                    </div>


                    <form action="{{ route('manage-contact-email.store') }}" id="contactemail_form" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email"  class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Enter email"
                                    value="{{ old('email') }}" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>

                </div>

                @endif

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
                ajax: "{{ route('manage-contact-email.index') }}",
                columns: [
                    {
                        data: 'id'
                    },
                    {
                        data: 'email'
                    }, 
                    {
                        data: 'Actions',
                        orderable: false,
                        serachable: false,
                        sClass: 'd-flex justify-content-center'
                    },
                ]
            });


            // Delete ContactEmail Ajax request.
            $(document).on("click", ".DeleteContactEmail", function(e) {
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
                            url: "{{ url('admin/manage-contact-email/') }}/" + id,
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

            $('#contactemail_form').validate({
                rules: {
                    email: {
                        required: true,
                        email:true
                    } 
                },
                messages: {
                    email: {
                        required: "Email field is required",
                    } 
                },
                errorClass: "text-danger is-invalid",
                errorElement: 'div'
            });

            $('#contactemail_edit_form').validate({
                rules: {
                    email: {
                        required: true,
                        email:true
                    },

                },
                messages: {
                    email: {
                        required: "Email field is required",
                    },
                },
                errorClass: "text-danger is-invalid",
                errorElement: 'div'
            }); 
        });
 
    </script>
@endsection