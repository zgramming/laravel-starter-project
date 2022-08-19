<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    {{-- Core --}}
    <link rel="stylesheet" href="{{asset('assets/css/main/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/auth.css')}}">

</head>
<body>

<div id="auth">

    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="#"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"></a>
                </div>
                <div>
                    @include('templates.components.messages.errors.witherrors',['errors' => $errors])
                </div>
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                <form action="{{ route('login') }}" method="post" enctype="multipart/form-data" id="form_validation">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" name="username" class="form-control form-control-xl" placeholder="Username"
                               required>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>

                    <div class="form-group position-relative has-icon-left">
                        <input type="password" name="password" class="form-control form-control-xl"
                               placeholder="Password" required>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4">Log in</button>
                    @csrf
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right" style="background-color: red">
            </div>
        </div>
    </div>
</div>
</body>

{{-- Jquery --}}
<script src="{{asset('assets/vendors/jquery/jquery.min.js')}}"></script>

{{-- Jquery Validation --}}
<script src="{{asset('assets/js/third_party/jquery_validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/js/third_party/jquery_validation/additional-methods.js')}}"></script>
<script src="{{asset('assets/js/third_party/jquery_validation/override-core-method.js')}}"></script>
<script src="{{asset('assets/js/third_party/jquery_validation/extends-method.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form_validation").validate({
            rules: {},
            messages: {}
        })
    });
</script>
</html>
