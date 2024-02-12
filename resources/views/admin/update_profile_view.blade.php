@extends('admin.layouts.app')

@section('content')

    <div class="row justify-content-center mt-3 mb-3">
        <div class="col-md-12">
            <div class="card" style="border-radius: 6px;">
                <div class="card-body">
                    <h4 class="sub-title pb-3">Admin Information</h4>
                    <form action="{{ route('edit_profile') }}" method="POST" enctype="multipart/form-data"id="edit_profile_form">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group row">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black" for="email">Email</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" id="email" placeholder="Email"  value="{{ $user['email'] }}" disabled  class="form-control  @error('email') form-control-danger @enderror">
                                @error('email')
                                    <div class="text-danger error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black" for="name">First name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="name" placeholder="Name" value="{{ $user['name'] }}" class="form-control  @error('name') form-control-danger @enderror">
                                @error('name')
                                    <div class="text-danger error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black" for="user_image">Image</label>
                            <div class="col-sm-6">
                                <input type="file" name="user_image" id="user_image" accept="image/*" class="@error('user_image') form-control-danger @enderror">
                                @error('user_image')
                                    <div class="text-danger error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-sm-3"></label>
                            <div class="col-sm-6">
                                <div class="text-center user-info">
                                    <img id="upload_image" src="{{ $user->user_image ? url('/') . '/' . $user->user_image : asset('assets/img/boy.png') }}" alt="avatar">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row text-start mt-2">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black"></label>
                            <div class="col-sm-6">
                                <input type="submit" class="btn btn-primary" style="width: 150px;" value="Save">
                            </div>
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

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#upload_image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert('select a file to see preview');
                    $('#upload_image').attr('src', '');
                }
            }

            $("#user_image").change(function() {
                var extension = user_image.value.split('.')[1];;
                console.log(extension);
                if ((extension == "png") || (extension == "jpeg") || (extension == "jpg")) {
                    readURL(this);
                }

            });

            $('#edit_profile_form').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    
                    user_image: {
                        extension: "png|jpeg|jpg",
                        // filesize: 200000 //max size 200 kb
                    },

                },
                messages: {
                     name: {
                        required: "The name field is required",
                    }, 
                    user_image: {
                        //     extension: "Please upload file in these format only (jpg, jpeg, png)."
                        extension: "File must be JPG,JPEG or PNG",
                        // filesize: " file size must be less than 200 KB"
                    },
                },
                errorClass: "text-danger is-invalid",
                errorElement: 'div'
            });


        });
    </script>

@endsection