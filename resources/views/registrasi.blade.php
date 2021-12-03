<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIMAUN - Sistem Manajemen ASN Untuk Negeri | REGISTER</title>

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


<body class="bg-gradient-primary" style="background: url({{ asset('img/bg-1.jpg') }}) center center no-repeat fixed;">
    
        <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="{{ URL::Route('Register') }}">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name" value="">
                                    @if ($errors->first('name'))
                                        <small  class="text-danger pl-3" for="name">Kolom ini diperlukan.</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email Address" value="">
                                    @if ($errors->first('email'))
                                        <small  class="text-danger pl-3" for="email">Kolom ini diperlukan.</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="">
                                    @if ($errors->first('username'))
                                        <small  class="text-danger pl-3" for="username">Kolom ini diperlukan.</small>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                        @if ($errors->first('password1'))
                                        <small  class="text-danger pl-3" for="password1">Kolom ini diperlukan.</small>
                                    @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                                        @if ($errors->first('password2'))
                                            <small  class="text-danger pl-3" for="password2">Kolom ini diperlukan.</small>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="" style="font-size: 15px;">Forgot Password?</a>
                            </div>
                            <div class=" text-center">
                                    <a class="small" href="{{url('/devadmin/login')}}" style="font-size: 15px;">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
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
