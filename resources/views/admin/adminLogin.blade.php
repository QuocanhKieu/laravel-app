<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{asset('admins/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/bootstrap.min.css')}}">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #17a2b8;
            height: 100vh;
        }
        #login .container #login-row #login-column #login-box {
            margin-top: 120px;
            max-width: 600px;
            height: auto;
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
        }
        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
        }
        #login .container #login-row #login-column #login-box #login-form #register-link {
            margin-top: -85px;
        }
        .invalid-feedback {
            display: block;
            font-size: 90%;
        }
    </style>

</head>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="{{route('checkLogin')}}" method="post">
                            @csrf
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="email" class="text-info @error('email') is-invalid @enderror">Email:</label><br>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
{{--                            @error('email')--}}
{{--                            <script>--}}
{{--                                // Show alert with the error message--}}
{{--                                alert("{{ $message }}");--}}
{{--                            </script>--}}
{{--                            @enderror--}}
                            <div class="form-group">
                                <label for="password" class="text-info @error('password') is-invalid @enderror">Password:</label><br>
                                <input type="text" name="password" id="password" class="form-control">
                            </div>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('Invalid credentials')
                            <script>
                                // Show alert with the error message
                                alert("{{ $message }}");
                            </script>
                            @enderror
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input
                                            id="remember-me" name="remember" type="checkbox"></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
{{--                            <div id="register-link" class="text-right">--}}
{{--                                <a href="#" class="text-info">Register here</a>--}}
{{--                            </div>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('error'))
        <script>
            // Show alert with the error message
            alert("{{ session('error') }}");
        </script>
    @endif
    @if (session('success'))
        <script>
            // Show alert with the error message
            alert("{{ session('success') }}");
        </script>
    @endif

    <script src="{{asset('admins/js/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('admins/js/bootstrap.bundle.min.js')}}"></script>
<!------ Include the above in your HEAD tag ---------->
</body>

</html>


<?php
