<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title> Support Portal - {{ $schoolName ?? 'DPSG' }}</title>

    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/pages/extra_pages.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">

                <form class="login100-form validate-form" method="post" id="login-form" action="{{ route('login') }}" autocomplete="off">

                    @csrf

                    <span class="login100-form-title p-b-45">
                        Admin Login
                    </span>@if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>

                            @foreach ($errors->all() as $error)
                            {{ $error }} <br>
                            @endforeach

                        </ul>
                    </div>
                    @endif
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}

                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}

                    </div>
                    @endif
                    <div class="wrap-input100 validate-input" data-validate="Username is required">
                        <input class="input100" type="text" name="uname" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Username</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="upass" required id="upass">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Passkey</span>
                    </div>
                    <div class="flex-sb-m w-full p-t-15 p-b-20">

                        <div>

                        </div>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </form>
                <div class="login100-more" style="background-image: url('{{ asset('images/pages/bg-01.png') }}');">
                </div>
            </div>
        </div>
    </div>
    <!-- Plugins Js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <!-- Extra page Js -->
    <script src="{{ asset('js/pages/examples/pages.js') }}"></script>
</body>


</html>