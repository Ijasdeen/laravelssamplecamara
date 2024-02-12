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
					<div class="float-left form-group">
                    <label class=" col-form-label">Category</label>
                    <select name="filter_cat_id" id="filter_cat_id" class="form-control form-control-inverse">
                        <option value="">Select Category</option>
                        @foreach ($category as $value)
                            <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                        <div class="float-right mb-3">
                             <!-- !-- Button to Open the Modal --> 
                            <button type="button" class="btn btn-primary AddNewsletter" >
                            <i class="fa fa-plus"></i> Create Newsletter
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
										<th>Category</th> 
                                        <th>Title</th> 
                                        <th>Description</th> 
                                        <th>Image</th> 
										<th>File</th> 
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
  <div class="modal fade" id="CreateNewsletter">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create Newsletter</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form  id="newsletter_form" enctype="multipart/form-data"
                        method="POST">
        <div class="modal-body">
         
                        @csrf
                        <input type="hidden" name="benefit_id" id="benefit_id" value=''>
                        <div class="card-body">

						<div class="form-group">
                                <label class=" col-form-label">Category</label>
                                <select name="cat_id" id="cat_id" class="form-control form-control-inverse">
								   @foreach ($category as $value)
                                        <option value="{{ $value->id }}" >{{ $value->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

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
                                <label for="file">File</label>
                                <input type="file" id="n_file" accept="application/pdf"
								 class="@error('n_file') is-invalid @enderror" name="n_file" 
                                    value="{{ old('n_file') }}" />
                                @error('n_file')
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
 		ajax: {
                    url:"{{ route('manage-newsletter.index') }}",
                    data: function(d) {
                        d.cat_id = $('#filter_cat_id').val(),
                             
                            d.search = $('input[type="search"]').val()
                    }
                },
				columns: [{
				data: 'id'
			},
			{
				data: 'category'
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
				data: 'file'
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
    $('select').on('change', function() {
                $('.datatable').DataTable().draw();
            });


	// Delete Newsletter Ajax request.
	$(document).on("click", ".DeleteNewsletter", function(e) {
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
					url: "{{ url('admin/manage-newsletter/') }}/" + id,
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

	$('button.btn.btn-primary.AddNewsletter').click(function() {
		$('img.previewImg.img-thumbnail').attr('src', 'https://camara.tfsbs.com/assets/images/transparent.png');
		var editor = CKEDITOR.instances.description;
		editor.setData('');
		$('#benefit_id').val('');
		$('#newsletter_form')[0].reset();
		$('.modal-header h4.modal-title').html("Add Benefit");
		$('#saveBtn').val("add-benefit");
		$('#CreateNewsletter').modal('show');
		$('.form_button').text('add');
	});


	$(document).on('click', '.EditNewsletter', function() {

		var benefit_id = $(this).data('id');
		$.get("{{ route('manage-newsletter.index') }}" + '/' + benefit_id + '/edit', function(data) {
			$('.modal-header h4.modal-title').html("Edit Benefit");
			$('#saveBtn').val("edit-benefit");
			$('#CreateNewsletter').modal('show');
			$('#benefit_id').val(data.id);
			$('#title').val(data.title);
			$('#cat_id').val(data.cat_id); 
			$('#cat_id').select2("val", data.cat_id);
			var editor = CKEDITOR.instances.description;
			editor.setData(data.description);
			$('img.previewImg.img-thumbnail').attr('src', data.imageurl);
			$('.form_button').text('update');

		});

	});

	$("#newsletter_form").submit(function(e) {
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
			cat_id:{
				required: true,
			},
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
			 
			cat_id:{
				required: 'Category field is required',
			},
			title: {
				required: "Title field is required",
			},
			description: {
				required: "Description field is required",
				minlength: "Please enter 10 characters"
			},
		},
		submitHandler: function(form) {

			let formData = new FormData(document.getElementById("newsletter_form"));;
			$.ajax({
				url: "{{ route('manage-newsletter.store') }}",
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
						$('#benefit_id').val('');
						toastr.success(result.success);
						$('#newsletter_form')[0].reset();
						$('#CreateNewsletter').modal('hide');
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