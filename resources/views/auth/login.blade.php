@extends('auth.layouts.app')

@section('content')
 
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1 class="">Log In to <a href="{{ url('/') }}">
                                <span class="brand-name">Camara Qatar</span></a>
                        </h1>
                        <form method="POST" action="{{ route('login') }}" id="login_form">
                            @csrf
                            <div class="form">
                                <div class="form-group left-icon-form has-error">
                                    <input id="email" name="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Email">
                                    <div class="left-icon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group left-icon-form has-error">
                                    <input id="password" name="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    <div class="left-icon">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                            <input type="checkbox" class="new-control-input" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }} />
                                            <span class="new-control-indicator"></span> {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>

                                {{-- <div class="field-wrapper"> --}}
                                {{-- <a href="{{ route('password.request') }}" class="forgot-pass-link"> --}}
                                {{-- {{ __('Forgot Your Password?') }} --}}
                                {{-- </a> --}}
                                {{-- </div> --}}

                            </div>
                        </form>
                        <p class="terms-conditions">© @php echo date('Y'); @endphp All Rights Reserved. <a href="{{ url('/') }}">
                        Camara Qatar</a> is a product of Designreset.
                            <a href="javascript:void(0);">Cookie Preferences</a>,
                            <a href="javascript:void(0);">Privacy</a>, and
                            <a href="javascript:void(0);">Terms</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#login_form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "The email field is required",
                    },
                    password: {
                        required: "The password field is required",
                    }
                },
                errorClass: "text-danger is-invalid",
                errorElement: 'div'
            });
        });
    </script>

@endsection