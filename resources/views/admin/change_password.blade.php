@extends('admin.layouts.app')

@section('content')

    <div class="row mt-3 mb-3 justify-content-center">
        <div class="col-md-12">
            <div class="card" style="border-radius: 6px;">
                <div class="card-body">
                    <h4 class="sub-title pb-3">Change password</h4>
                    <form action="{{ route('edit_password') }}" method="POST" enctype="multipart/form-data"
                        id="change_password_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black" for="email">Email</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" id="email" value="{{ $user['email'] }}" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black" for="password">Current password</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" id="password" placeholder="Current password" class="form-control @error('password') form-control-danger @enderror">
                                @error('password')
                                    <div class="text-danger error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black" for="new_password">New password</label>
                            <div class="col-sm-6">
                                <input type="password" name="new_password" id="new_password" placeholder="New password" class="form-control @error('new_password') form-control-danger @enderror">
                                @error('new_password')
                                    <div class="text-danger error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black" for="password_confirmation">Confirm password</label>
                            <div class="col-sm-6">
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" class="form-control @error('password_confirmation') form-control-danger @enderror">
                                @error('password_confirmation')
                                    <div class="text-danger error">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row text-start mt-2">
                            <label class="col-lg-2 col-sm-3 col-form-label text-black"></label>
                            <div class="col-sm-6">
                                <input type="submit" class="btn btn-primary" style="width:150px;" value="Save">
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

            var value = $("#new_password").val();

            $.validator.addMethod("pwcheck", function(value) {
                return /^[A-Za-z0-9\d`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]*$/.test(value) && /[a-z]/.test(
                        value) && /\d/.test(value) &&
                    /[A-Z]/.test(value);
            });

            $('#change_password_form').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 30,

                    },
                    new_password: {
                        minlength: 6,
                        maxlength: 30,
                        required: true,
                        pwcheck: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#new_password",
                    },
                },
                messages: {
                    password: {
                        required: "The password field is required",
                    },
                    new_password: {
                        required: "The new password field is required",
                        pwcheck: "Password must contain uppercase,lowercase,digit,sign letter",
                    },
                    password_confirmation: {
                        required: "The password confirmation field is required",
                        equalTo: "The passwords do not match"
                    },
                },
                errorClass: "text-danger is-invalid",
                errorElement: 'div'
            });


        });
    </script>

@endsection