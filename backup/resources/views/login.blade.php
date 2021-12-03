<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{asset ('halamanlogin/img/img-01.png') }}" type="image/x-icon">
        <link rel="icon" href="{{asset ('halamanlogin/img/img-01.png') }}" type="image/x-icon">
    <title>E-Resah - Eletronik Retribusi Sampah | LOGIN</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset ('halamanlogin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset ('halamanlogin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="{{asset ('halamanlogin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset ('halamanlogin/vendor/bootstrap/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{asset ('halamanlogin/vendor/animate/animate.css') }}" rel="stylesheet">
    <link href="{{asset ('halamanlogin/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet">
    <link href="{{asset ('halamanlogin/vendor/css/util.css') }}" rel="stylesheet">
    <link href="{{asset ('halamanlogin/vendor/css/main.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('admins/noty/noty.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/noty/themes/nest.css') }}">

</head>


<body class="bg-gradient-primary">
    
    <div class="limiter" >
        <div class="container-login100" style="background: url({{ asset('img/bg-1.jpg') }}) center center no-repeat fixed;">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt">
                    <img src="{{asset ('halamanlogin/img/img-01.png') }}" alt="IMG">
                </div>
                <form class="Login100-form" action="{{ URL::Route('Login') }}" method="post">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <span class="login100-form-title">
                        <h2 style="color: black">E-RESAH</h2>
                        <h5 class="h5 text-gray-900">ELEKTRONIK RETRIBUSI SAMPAH</h3>
                    </span>
                    
                    <form class="user" action="{{ URL::Route('Register') }}" method="post">
                        <div class="wrap-input100 validate-input" data-validate = "">
                            <input type="text" class="input100" id="email" placeholder="Enter Email Address or Username..." name="username" value="">
                                                
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate = "Password is required">
                            <input type="password" class="input100" id="password" name="password" placeholder="Password">
                                                
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>
                        
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>
                    

                    <div class="text-center p-t-11">
                        {{-- <span class="txt1">
                             <a href="" style="font-size: 15px;">Lupa Password?</a>
                        </span> --}}
                        <br>
                        <br>
                        {{-- <span class="txt2">
                            <a href="{{url('/register')}}" style="font-size: 15px;">Daftar Akun!</a>
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </span> --}}
                        
                    </div>

                    <div class="text-center p-t-136">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset ('halamanlogin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{asset ('halamanlogin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset ('halamanlogin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{asset ('halamanlogin/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{asset ('halamanlogin/vendor/bootstrap/js/main.js') }}"></script>
<script src="{{asset ('halamanlogin/vendor/bootstrap/js/tilt.jquery.min.js') }}"></script>
<script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>

<!-- Core plugin JavaScript-->
<script src="{{asset ('halamanlogin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset ('halamanlogin/js/sb-admin-2.min.js') }}"></script>

<script src="{{ asset('admins/noty/noty.js') }}"></script>

@if(Session::has('success'))
    <script type="text/javascript">
        new Noty({
            text: '<strong>Success</strong> {{Session::get('success')}}',
            layout: 'topRight',
            type: 'success',
            theme: 'nest'
        }).setTimeout(4000).show();
    </script>
@endif
@if(Session::has('fail'))
    <script type="text/javascript">
        new Noty({
            text: '<strong>Fails</strong> {{Session::get('fail')}}',
            layout: 'topRight',
            type: 'warning',
            theme: 'nest'
        }).setTimeout(4000).show();
    </script>
@endif

</body>

</html>
