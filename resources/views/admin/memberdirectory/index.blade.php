@extends('admin.layouts.app')


@section('content')
<style>
     a.btn.btn-primary.btn-sm {
        margin-right: 8px;
    }
</style>
    <div>
        <div class="row mt-3 mb-3">
            <div class="col-lg-12"> 
                <div class="card" style="border-radius: 6px;">
                    <div class="card-body">
                        <div class="float-right mb-3">
                             <!-- !-- Button to Open the Modal --> 
                            <button type="button" class="btn btn-primary AddMemberdirectory" >
                            <i class="fa fa-plus"></i> Create Member Directory
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Company name</th> 
                                        <th>Website</th> 
                                        <th>Email</th> 
                                        <th>Contact no</th> 
                                        <th>POC name</th> 
                                        <th>Sector</th> 
										<th>Description </th>
                                        <th>Image</th> 
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
  <div class="modal fade" id="CreateMemberdirectory">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create Member Directory</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form  id="memberdirectory_form" enctype="multipart/form-data"
                        method="POST">
        <div class="modal-body">
         
                        @csrf
                        <input type="hidden" name="memberdirectory_id" id="memberdirectory_id" value=''>
                        <div class="card-body">

                        <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" id="company_name"  class="form-control @error('company_name') is-invalid @enderror "
                                    name="company_name" placeholder="Enter company name"
                                    value="" />
                                    @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div>

						<div class="form-group">
                                <label for="website">Website</label>
                                <input type="text" id="website"  class="form-control @error('website') is-invalid @enderror "
                                    name="website" placeholder="Enter website"
                                    value="" />
                                    @error('website')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div>

						<div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email"  class="form-control @error('email') is-invalid @enderror "
                                    name="email" placeholder="Enter email"
                                    value="" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div>
						<div class="form-group">
                                <label for="contact_no">Contact No</label>
                                <input type="text" id="contact_no"  class="form-control @error('contact_no') is-invalid @enderror "
                                    name="contact_no" placeholder="Enter contact no"
                                    value="" />
                                    @error('contact_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div>
						<div class="form-group">
                                <label for="company_name">POC Name</label>
                                <input type="text" id="poc_name"  class="form-control @error('poc_name') is-invalid @enderror "
                                    name="poc_name" placeholder="Enter poc name"
                                    value="" />
                                    @error('poc_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div>
					 
						<div class="form-group">
                                <label for="sector">Sector</label>
                                <input type="text" id="sector"  class="form-control @error('sector') is-invalid @enderror "
                                    name="sector" placeholder="Enter sector"
                                    value="" />
                                    @error('sector')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div>
						<div class="form-group">
                                <label for="image">Description</label>
                                <textarea name="description" class="ckeditor" id="description"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                         </div>
 
                        <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" id="image" accept="image/*" class="@error('image') is-invalid @enderror"
                                    name="image" onchange="previewFile(this);"
                                    value="{{ old('image') }}" />
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <img class="previewImg img-thumbnail" style="border: none !important;"  src="{{asset('assets/images/transparent.png') }}" alt="Placeholder">
                         
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
@endsection

@section('script')
<!-- <script src="{{asset('assets/js/ckeditor.js')}}"></script> -->
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

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
		ajax: "{{ route('manage-member-directory.index') }}",
		columns: [{
				data: 'id'
			},
			{
				data: 'company_name'
			},
			{
				data: 'website'
			},
			{
				data: 'email'
			},
			{
				data: 'contact_no'
			},
			{
				data: 'poc_name'
			},
			{
				data: 'sector'
			},
			{
				data: 'description_data'
			},
			{
				data: 'image'
			},
			{
				data: 'Actions',
				orderable: false,
				serachable: false,
				sClass: 'd-flex justify-content-center'
			},
		],
		drawCallback: function() {
			$('.image-link').magnificPopup({
				type: 'image',
				closeOnBgClick: true
			});
		}
	});


	// Delete Memberdirectory Ajax request.
	$(document).on("click", ".DeleteMemberDirectory", function(e) {
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
					url: "{{ url('admin/manage-member-directory/') }}/" + id,
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

	$('button.btn.btn-primary.AddMemberdirectory').click(function() {
		$('img.previewImg.img-thumbnail').attr('src', 'https://camara.tfsbs.com/assets/images/transparent.png');
		var editor = CKEDITOR.instances.description;
		editor.setData('');
		$('#memberdirectory_id').val('');
		$('#memberdirectory_form')[0].reset();
		$('.modal-header h4.modal-title').html("Add Service");
		$('#saveBtn').val("add-memberdirectory");
		$('#CreateMemberdirectory').modal('show');
		$('.form_button').text('add');
	});


	$(document).on('click', '.EditMemberDirectory', function() {

		var memberdirectory_id = $(this).data('id');
		$.get("{{ route('manage-member-directory.index') }}" + '/' + memberdirectory_id + '/edit', function(data) {
			$('.modal-header h4.modal-title').html("Edit Service");
			$('#saveBtn').val("edit-memberdirectory");
			$('#CreateMemberdirectory').modal('show');
			$('#memberdirectory_id').val(data.id);
			$('#company_name').val(data.company_name);
			$('#website').val(data.website);
			$('#email').val(data.email);
			$('#contact_no').val(data.contact_no);
			$('#poc_name').val(data.poc_name);
			$('#sector').val(data.sector);
			var editor = CKEDITOR.instances.description;
			editor.setData(data.description);
		 $('img.previewImg.img-thumbnail').attr('src', data.imageurl);
			$('.form_button').text('update');

		});

	});

	$("#memberdirectory_form").submit(function(e) {
		e.preventDefault();
	}).validate({
		ignore: [],
		debug: false,
		errorClass: "text-danger is-invalid",
		errorElement: 'div',
		errorPlacement: function(error, element) {
			if (element.attr("name") == "description") {
				error.insertBefore("textarea#description");
			} else {
				error.insertBefore(element);
			}
		},
		rules: {
			company_name: {
				required: true,
			},
			website: {
				required: true,
				url: true
			},
			email: {
				required: true,
				email: true,
			},
			contact_no: {
				required: true,
				number: true
			},
			poc_name: {
				required: true,
			},
			sector: {
				required: true,
			}  ,
			description: {
				required: function() {
					CKEDITOR.instances.description.updateElement();
				},
				minlength: 10

			},
		},
		messages: {
			company_name: {
				required: "Company name field is required",
			}, 
			website: {
				required: "Website field is required",
			}, 
			email: {
				required: "Email field is required",
			}, 
			contact_no: {
				required: "Contact no field is required",
			}, 
			poc_name: {
				required: "POC name field is required",
			}, 
			sector: {
				required: "Sector field is required",
			}, 
			description: {
				required: "Description field is required",
				minlength: "Please enter 10 characters"
			},
			 
		},
		submitHandler: function(form) {

			let formData = new FormData(document.getElementById("memberdirectory_form"));;
			$.ajax({
				url: "{{ route('manage-member-directory.store') }}",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(result) {
					// var result=JSON.parse(result);
					if (result.error) {
						toastr.error(result.error);
					} else {
						var editor = CKEDITOR.instances.description;
						editor.setData('');
						$('img.previewImg.img-thumbnail').attr('src', 'https://camara.tfsbs.com/assets/images/transparent.png');
						$('#memberdirectory_id').val('');
						toastr.success(result.success);
						$('#memberdirectory_form')[0].reset();
						$('#CreateMemberdirectory').modal('hide');
						$('.datatable').DataTable().ajax.reload();
					}
				}
			});
			return false;
		}
	}); 
});

function previewFile(input) {
		var file = $("input[type=file]").get(0).files[0];

		if (file) {
			var reader = new FileReader();
			console.log(input);
			reader.onload = function() {
				$("div").find(".previewImg").attr("src", reader.result);
			}
			reader.readAsDataURL(file);
		}
	}
  </script>
@endsection