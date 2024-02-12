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
                            <button type="button" class="btn btn-primary AddEvent" >
                            <i class="fa fa-plus"></i> Create Event
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
										<th>Event date time</th> 
                                        <th>Address</th>
										<th>Share</th>
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
  <div class="modal fade" id="CreateEvent">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create Event</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form  id="event_form" enctype="multipart/form-data"
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
                                <label for="title">Event date time</label>

                                <input type="text" id="event_date"  class="form-control @error('event_date') is-invalid @enderror "
                                    name="event_date" placeholder="Enter event date"
                                    value="" />
                                    @error('event_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div> 

                            <div class="form-group">
                                <label for="image">Address</label>
                                <textarea name="address" class="form-control" id="address"></textarea>
                                @error('address')
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
						<label for="image">Event Share</label>
						<div>  
						<div class="form-check-inline">
							<label class="form-check-label" for="radio1"> 
								<input type="radio" class="form-check-input" id="radio1" name="event_share" value="on" checked>On
							</label>
						</div>
						<div class="form-check-inline">
							<label class="form-check-label" for="radio2">
								<input type="radio" class="form-check-input" id="radio2" name="event_share" value="off">Off
							</label>
						</div>
						</div>
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

  <style>.ranges {
    display: none;
}</style>
<script>  
    $(document).ready(function() { 
	var date = new Date();

		$("#event_date").daterangepicker(
			{
                timePicker: true,
                    timePickerIncrement: 30,
                    locale: {
                        format: 'YYYY-MM-DD h:mm A'
                    },
				minDate:new Date(),
				startDate: moment(date).add(1,'days'),
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
 		ajax: {
                    url:"{{ route('manage-event.index') }}",
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
				data: 'event_date'
			},
            {
                data:'address'
            }, 
			{
				data: 'event_share'
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
    
    $('select').on('change', function() {
                $('.datatable').DataTable().draw();
            });


	// Delete Event Ajax request.
	$(document).on("click", ".DeleteEvent", function(e) {
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
					url: "{{ url('admin/manage-event/') }}/" + id,
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

	$('button.btn.btn-primary.AddEvent').click(function() {
		$('img.previewImg.img-thumbnail').attr('src', 'https://camara.tfsbs.com/assets/images/transparent.png');
		var editor = CKEDITOR.instances.description;
		editor.setData('');
		$('#benefit_id').val('');
		$('#event_form')[0].reset();
		$('.modal-header h4.modal-title').html("Add Benefit");
		$('#saveBtn').val("add-benefit");
		$('#CreateEvent').modal('show');
		$('.form_button').text('add');
	});


	$(document).on('click', '.EditEvent', function() {

		var benefit_id = $(this).data('id');
		$.get("{{ route('manage-event.index') }}" + '/' + benefit_id + '/edit', function(data) {
			$('.modal-header h4.modal-title').html("Edit Benefit");
			$('#saveBtn').val("edit-benefit");
			$('#CreateEvent').modal('show');
			$('#benefit_id').val(data.id);
			$('#title').val(data.title);
			$('#cat_id').val(data.cat_id); 
			$('#cat_id').select2("val", data.cat_id);
			$('#address').val(data.address); 

 			$('#event_date').val(data.event_date); 

			var editor = CKEDITOR.instances.description;
			editor.setData(data.description);
			$('img.previewImg.img-thumbnail').attr('src', data.imageurl);
			$('.form_button').text('update');
			// $('#search-damages').prop('checked', true)
			if(data.event_share=='on')
			{
				$('#radio1').prop('checked', true);
			}else{
				$('#radio2').prop('checked', true);
			}


		});

	});

	$("#event_form").submit(function(e) {
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
            address:{
                required: true,
            },
			cat_id:{
				required: true,
			},
			title: {
				required: true,
			},
			event_date:{
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
			address:{
				required: 'Address field is required'
			},event_date:{
				required: 'Event date field is required'
			},
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

			let formData = new FormData(document.getElementById("event_form"));;
			$.ajax({
				url: "{{ route('manage-event.store') }}",
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
						$('#event_form')[0].reset();
						$('#CreateEvent').modal('hide');
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