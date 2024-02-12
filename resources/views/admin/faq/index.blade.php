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
                            <button type="button" class="btn btn-primary AddFaq" >
                            <i class="fa fa-plus"></i> Create Faq
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Question</th> 
                                        <th>Answer</th> 
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
  <div class="modal fade" id="CreateFaq">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create Faq</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form  id="faq_form" enctype="multipart/form-data"
                        method="POST">
        <div class="modal-body">
         
                        @csrf
                        <input type="hidden" name="faq_id" id="faq_id" value=''>
                        <div class="card-body">

                        <div class="form-group">
                                <label for="title">Question</label>

                                <input type="text" id="question"  class="form-control @error('question') is-invalid @enderror "
                                    name="question" placeholder="Enter Question"
                                    value="" />
                                    @error('question')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                        <div class="form-group">
                                <label for="image">Answer</label>
                                <textarea name="answer" class="ckeditor" id="answer"></textarea>
                                @error('answer')
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
		ajax: "{{ route('manage-faq.index') }}",
		columns: [{
				data: 'id'
			},
			{
				data: 'question'
			},
			{
				data: 'answer'
			}, 
			{
				data: 'Actions',
				orderable: false,
				serachable: false,
				sClass: 'd-flex justify-content-center'
			},
		],
		 
	});


	// Delete Faq Ajax request.
	$(document).on("click", ".DeleteFaq", function(e) {
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
					url: "{{ url('admin/manage-faq/') }}/" + id,
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

	$('button.btn.btn-primary.AddFaq').click(function() {
 		var editor = CKEDITOR.instances.answer;
		editor.setData('');
		$('#faq_id').val('');
		$('#faq_form')[0].reset();
		$('.modal-header h4.modal-title').html("Add FAQ");
		$('#saveBtn').val("add-faq");
		$('#CreateFaq').modal('show');
		$('.form_button').text('add');
	});


	$(document).on('click', '.EditFaq', function() {

		var faq_id = $(this).data('id');
		$.get("{{ route('manage-faq.index') }}" + '/' + faq_id + '/edit', function(data) {
			$('.modal-header h4.modal-title').html("Edit FAQ");
			$('#saveBtn').val("edit-faq");
			$('#CreateFaq').modal('show');
			$('#faq_id').val(data.id);
			$('#question').val(data.question);
			var editor = CKEDITOR.instances.answer;
			editor.setData(data.answer);
 			$('.form_button').text('update');

		});

	});

	$("#faq_form").submit(function(e) {
		e.preventDefault();
	}).validate({
		ignore: [],
		debug: false,
		errorClass: "text-danger is-invalid",
		errorElement: 'div',
		errorPlacement: function(error, element) {
			if (element.attr("name") == "answer") {
				error.insertBefore("textarea#answer");
			} else {
				error.insertBefore(element);
			}
		},
		rules: {
			question: {
				required: true,
			},
			answer: {
				required: function() {
					CKEDITOR.instances.answer.updateElement();
				},
				minlength: 10

			},
		},
		messages: {
			question: {
				required: "Question field is required",
			},
			answer: {
				required: "Description field is required",
				minlength: "Please enter 10 characters"
			},
		},
		submitHandler: function(form) {

			let formData = new FormData(document.getElementById("faq_form"));;
			$.ajax({
				url: "{{ route('manage-faq.store') }}",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(result) {
					// var result=JSON.parse(result);
					if (result.error) {
						toastr.error(result.error);
					} else {
						var editor = CKEDITOR.instances.answer;
						editor.setData('');
 						$('#faq_id').val('');
						toastr.success(result.success);
						$('#faq_form')[0].reset();
						$('#CreateFaq').modal('hide');
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