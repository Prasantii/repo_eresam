@extends('admin.home')
@section('content')

<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li><a href="{{url('/devadmin/data-admin')}}">Data Admin</a></li>
        <li class="active">Edit Password Admin</li>
    </ul>
</div>
<!-- START PAGE HEADING -->
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="icon-home"></span>
    </div>
    <div class="title">
        <h1>Edit Admin</h1>
    </div>
</div>

<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container"> 
	<div class="block block-condensed">
    	<div class="block-divider-text"><h2>Edit Admin</h2></div>
        <div class="block-content">

        @if(Session::has('success'))

         <div class="alert alert-info alert-icon-block alert-dismissible" role="alert"> 
            <div class="alert-icon">
                <span class="icon-menu-circle"></span> 
            </div>                                        
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span></button>
        </div>   
                              
        @endif

        @if (count($errors) > 0)
          <div class="alert alert-danger alert-icon-block alert-dismissible" role="alert"> 
            <div class="alert-icon">
                <span class="icon-menu-circle"></span> 
            </div>                                        
            {{ $errors->first('konpassword')}}<br>
            {{ $errors->first('newpassword')}}<br>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span></button>
        </div>  


        @endif

        <form method="POST" action="{{ URL::Route('EditAdminPas', $admin->id) }}" enctype="multipart/form-data">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
			<div class="form-group">
                <div class="col-md-8">
                    <label>Password Baru</label>
                    
                    <input type="text" name="newpassword" class="form-control"  placeholder="Password Baru">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8">
                    <label>Konfirmasi Password</label>
                    
                    <input type="text" name="konpassword" class="form-control"   placeholder="Konfirmasi Password">
                </div>
            </div>
            
            
            <br>
			<br>
            <br>
            <br>
            <br>
			<br>

			<div class="col-md-8">
                    <p>
                    <button type="submit" class="btn btn-primary btn-shadowed"><span class="icon-smartphone"></span>Edit</button>
                </p> 
                </div>
        </form>
        </div>
	</div>
</div>



@stop