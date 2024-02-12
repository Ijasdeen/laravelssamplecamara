@extends('admin.layouts.app')

@section('content')
    <div>
        <div class="row ">
            <div class="col-md-12">
                <div class="card" style="border-radius: 6px;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>Name</th> 
                                        <th>Email </th>
                                        <th>Phone No </th>
                                        <th>Membership no</th> 
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- The Modal -->
  <div class="modal fade" id="CreateUser">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create User</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form  id="user_form" enctype="multipart/form-data"
                        method="POST">
        <div class="modal-body">
         
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value=''>
                        <div class="card-body">

					 

                        <div class="form-group">
                                <label for="title">Email</label>

                                <input type="email" id="email"  class="form-control @error('email') is-invalid @enderror "
                                    name="email" placeholder="Enter email"
                                    value="" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
 
                            <div class="form-group">
                                <label for="title">Phone no</label>

                                <input type="text" id="phoneno"  class="form-control @error('phoneno') is-invalid @enderror "
                                    name="phoneno" placeholder="Enter phoneno"
                                    value="" />
                                    @error('phoneno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Membership</label>

                                <input type="text" id="membership"  class="form-control @error('membership') is-invalid @enderror "
                                    name="membership" placeholder="Enter membership"
                                    value="" />
                                    @error('membership')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>


                            <div class="form-group">
                                <label for="title">Membership no</label>

                                <input type="text" id="membership_no"  class="form-control @error('membership_no') is-invalid @enderror "
                                    name="membership_no" placeholder="Enter membership no"
                                    value="" />
                                    @error('membership_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Validity</label>

                                <input type="text" id="validity"  class="form-control date @error('validity') is-invalid @enderror "
                                    name="validity" placeholder="Enter validity"
                                    value="" />
                                    @error('validity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

 
                        <!-- /.card-body -->
 
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary form_button text-capitalize mr-2" id="saveBtn">Add</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
            </button>        
    </div>

        </form> 
        
      </div>
    </div>
  </div> 


  <button type="hidden" id="buttontriggerhiddenconfirmation" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

  <div class="modal fade" id="deleteConfirmationmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter user email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
    <script>
        $(document).ready(function() {

            var date = new Date();
		$("#validity").daterangepicker(
			{ 
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    singleDatePicker: true,
    showDropdowns: true,
				autoApply: true,
				showButtonPanel: false, 
				
			}
		); 


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
                "initComplete": function(settings, json) {
                    $('.chkToggle2').bootstrapToggle({
                        on: 'Enable',
                        off: 'Disable'
                    });
                },
                "drawCallback": function(settings, json) {
                    $('.chkToggle2').bootstrapToggle({
                        on: 'Enable',
                        off: 'Disable'
                    });
                },
                ajax: '{{ route("manage-user.index") }}',
                columns: [{
                        data: 'id'
                    }, 
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phoneno'
                    }, 
                    {
                        data: 'membership_no'
                    }, 
                    {
                        data: 'status',
                        sClass: 'text-center'
                    },
                    {
				data: 'Actions',
				orderable: false,
				serachable: false,
				sClass: 'd-flex justify-content-center'
			},
                ]
            });


            dataTable.on('draw', function() {
                $('.image-link').magnificPopup({
                    type: 'image'
                });
            });

            $(document).on("change", "input.chkToggle2", function() {

                var status = $(this).prop('checked') == true ? '1' : '0';

                var user_id = $(this).data('id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '/admin/changeStatus',
                    data: {
                        data: 'User',
                        status: status,
                        id: user_id
                    },
                    success: function(result) {
                        dataTable.ajax.reload(function() {
                            $('.chkToggle2').bootstrapToggle({
                                on: 'Enable',
                                off: 'Disable'
                            });
                        });
                        if (result.error) {
                            toastr.error(result.error);
                        } else {
                            toastr.success(result.success);
                        }
                    }

                });

            });


                      // Delete User Ajax request.
                      $(document).on("click", ".DeleteUser", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var email_user = $(this).data('email');
                let name = $(this).data('name'); 
 
 

                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }); 
 
                Swal.fire({
                        title: `Enter User Email <br/> Email : ${email_user} <br/> Name : ${name}`,
                         input: 'email',
                         inputPlaceholder: 'Enter User Email', 
                        showCancelButton: true ,
                        inputValidator: (value) => {
                            if (value != email_user) {
                                return 'Please verify user email'
                            }
                        
                        },       
                    }).then((result) => {
                        console.log(result);
                        if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/manage-user/') }}/" + id,
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
            
            $(document).on('click', '.EditUser', function() {

                var user_id = $(this).data('id');
                $.get("{{ route('manage-user.index') }}" + '/' + user_id + '/edit', function(data) {
                    $('.modal-header h4.modal-title').html("Edit User");
                    $('#saveBtn').val("edit-user");
                    $('button#saveBtn').html('Update');
                    $('#CreateUser').modal('show');
                    $('#user_id').val(data.id);  
                    $('#phoneno').val(data.phoneno);
                    $('#email').val(data.email);  
                    $('#membership').val(data.membership);   
                    $('#membership_no').val(data.membership_no);  
                    $('#validity').val(data.validity);    
                });

                });

                $("#user_form").submit(function(e) {
		e.preventDefault();
	}).validate({
		ignore: [],
		debug: false,
		errorClass: "text-danger is-invalid",
		errorElement: 'div',
		 
		rules: {
            email:{
                required: true,
                email:true
            },
			phoneno:{
				required: true,
			},
			membership: {
				required: true,
			} ,
            membership_no: {
				required: true,
			} ,
            validity: {
				required: true,
			} 
		},
		messages: {
			email:{
				required: 'Email field is required'
			},
            phoneno:{
				required: 'Phone no field is required'
			},
            membership:{
				required: 'Membership field is required',
			} ,
			membership_no:{
				required: 'Membership no field is required',
			} ,
            validity:{
				required: 'Validity field is required',
			} 
		},
		submitHandler: function(form) {

			let formData = new FormData(document.getElementById("user_form"));;
			$.ajax({
				url: "{{ route('manage-user.store') }}",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(result) {
					// var result=JSON.parse(result);
					if (result.error) {
						toastr.error(result.error);
					} else {
						 $('#user_id').val('');
						toastr.success(result.success);
						$('#user_form')[0].reset();
						$('#CreateUser').modal('hide');
						$('.datatable').DataTable().ajax.reload();
					}
				}
			});
			return false;
		}
	}); 
        })
    </script>
@endsection
