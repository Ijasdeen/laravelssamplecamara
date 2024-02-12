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
                            <button type="button" class="btn btn-primary AddChambersOfCommerce" >
                            <i class="fa fa-plus"></i> Create Chambers Of Commerce
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th> 
                                        <th>Description</th> 
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
  <div class="modal fade" id="CreateChambersOfCommerce">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create ChambersOfCommerce</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form  id="chambersofcommerce_form" enctype="multipart/form-data"
                        method="POST">
        <div class="modal-body">
         
                        @csrf
                        <input type="hidden" name="chambers_of_commerce_id" id="chambers_of_commerce_id" value=''>
                        <div class="card-body">

                        <div class="form-group">
                                <label for="title">Title</label>

                                <input type="text" id="title"  class="form-control @error('title') is-invalid @enderror "
                                    name="title" placeholder="Enter Title"
                                    value="" />
                                    @error('title')
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
		ajax: "{{ route('manage-chambers-of-commerce.index') }}",
		columns: [{
				data: 'id'
			},
			{
				data: 'title'
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


	// Delete ChambersOfCommerce Ajax request.
	$(document).on("click", ".DeleteChambersOfCommerce", function(e) {
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
					url: "{{ url('admin/manage-chambers-of-commerce/') }}/" + id,
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

	$('button.btn.btn-primary.AddChambersOfCommerce').click(function() {
		$('img.previewImg.img-thumbnail').attr('src', 'https://camara.tfsbs.com/assets/images/transparent.png');
		var editor = CKEDITOR.instances.description;
		editor.setData('');
		$('#chambers_of_commerce_id').val('');
		$('#chambersofcommerce_form')[0].reset();
		$('.modal-header h4.modal-title').html("Add Chambers Of Commerce");
		$('#saveBtn').val("add-chambers-of-commerce");
		$('#CreateChambersOfCommerce').modal('show');
		$('.form_button').text('add');
	});


	$(document).on('click', '.EditChambersOfCommerce', function() {

		var chambers_of_commerce_id = $(this).data('id');
		$.get("{{ route('manage-chambers-of-commerce.index') }}" + '/' + chambers_of_commerce_id + '/edit', function(data) {
			$('.modal-header h4.modal-title').html("Edit Chambers Of Commerce");
			$('#saveBtn').val("edit-chambers-of-commerce");
			$('#CreateChambersOfCommerce').modal('show');
			$('#chambers_of_commerce_id').val(data.id);
			$('#title').val(data.title);
			var editor = CKEDITOR.instances.description;
			editor.setData(data.description);
			$('img.previewImg.img-thumbnail').attr('src', data.imageurl);
			$('.form_button').text('update');

		});

	});

	$("#chambersofcommerce_form").submit(function(e) {
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
			title: {
				required: true,
			},
			description: {
				required: function() {
					CKEDITOR.instances.description.updateElement();
				},
				minlength: 10

			},
		},
		messages: {
			title: {
				required: "Title field is required",
			},
			description: {
				required: "Description field is required",
				minlength: "Please enter 10 characters"
			},
		},
		submitHandler: function(form) {

			let formData = new FormData(document.getElementById("chambersofcommerce_form"));;
			$.ajax({
				url: "{{ route('manage-chambers-of-commerce.store') }}",
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
						$('#chambers_of_commerce_id').val('');
						toastr.success(result.success);
						$('#chambersofcommerce_form')[0].reset();
						$('#CreateChambersOfCommerce').modal('hide');
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