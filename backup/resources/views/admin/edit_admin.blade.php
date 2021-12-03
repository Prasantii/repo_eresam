@extends('admin.home')
@section('content')

<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li><a href="{{url('/devadmin/data-admin')}}">Data Admin</a></li>
        <li class="active">Edit Data Admin</li>
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
            {{ $errors->first('username')}}<br>
          {{ $errors->first('nama')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span></button>
        </div>  


        @endif

        <form method="POST" action="{{ URL::Route('EditAdmin', $admin->id) }}" enctype="multipart/form-data">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
			<div class="form-group">
                <div class="col-md-8">
                    <label>Nama Lengkap</label>
                    
                    <input type="text" name="nama" class="form-control"  value="{{$admin->nama}}" placeholder="Nama Lengkap">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8">
                    <label>Username</label>
                    
                    <input type="text" name="username" class="form-control"  value="{{$admin->username}}" placeholder="Username">
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