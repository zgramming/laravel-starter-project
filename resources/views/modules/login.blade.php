<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    {{-- Core --}}
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">

</head>

<body>
    @php
        $key = json_encode(['key' => '123', 'iv' => '456']);
    @endphp
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="#"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"></a>
                    </div>
                    <div>
                        @include('templates.components.messages.errors.witherrors', ['errors' => $errors])
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                    {{-- <form action="{{ route('login') }}" method="post" enctype="multipart/form-data"
                        id="form_validation"> --}}
                    <form action="{{ route('testing_encrypt') }}" method="post" enctype="multipart/form-data"
                        id="form_validation">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="username" type="text" name="username" class="form-control form-control-xl"
                                placeholder="Username" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left">
                            <input id="password" type="password" name="password" class="form-control form-control-xl"
                                placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4" type="submit">Log in</button>
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
<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

{{-- Jquery Validation --}}
<script src="{{ asset('assets/js/third_party/jquery_validation/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/third_party/jquery_validation/additional-methods.js') }}"></script>
<script src="{{ asset('assets/js/third_party/jquery_validation/override-core-method.js') }}"></script>
<script src="{{ asset('assets/js/third_party/jquery_validation/extends-method.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"
    integrity="sha512-E8QSvWZ0eCLGk4km3hxSsNmGWbLtSCSUcewDQPQWZF6pEU8GlT8a5fF32wOl1i8ftdMhssTrF/OhyGWwonTcXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#form_validation").on("submit", async function(e) {
            e.preventDefault();
            const key = "{{ config('app.encryption-aes-key') }}";
            const iv = "{{ config('app.encryption-aes-iv') }}";

            const url = `{{ url('testing_encrypt') }}`;
            const obj = JSON.stringify({
                name: $("#username").val() || "",
                password: $("#password").val() || "",
            })
            const enc = encryptionAES(obj);
            const response = await $.ajax({
                url: url,
                method: "POST",
                data: {
                    auth_encryption: enc
                },
                success: function() {
                    alert("success")
                },

            }).then();
        });
    });
</script>

</html>
