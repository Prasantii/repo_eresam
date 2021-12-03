@extends('admin.home')
@section('content')
<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li><a href="{{url('/devadmin/member')}}">Data Member</a></li>
        <li class="active">Edit Data Member</li>
    </ul>
</div>

<!-- END PAGE HEADING -->

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

<!-- START PAGE CONTAINER -->
<div class="container">
      <div id="aa" class="row">                            
	    <div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title"><b> Edit Member</b></h3>
	                {{-- <div class="panel-elements pull-right">
			            <a href="{{url('/devadmin/editlatar', $latar->id)}}"><button class="btn btn-default" type="button"><span class="fa fa-edit"></span> Edit</button></a>
			        </div> --}}
	            </div>
	            <div class="panel-body">      
					<div class="block-content"  style="overflow-y: auto;">
						<form method="POST" action="{{ URL::Route('editpas',$member->id) }}" enctype="multipart/form-data">
				        <input name="_token" type="hidden" value="{{ csrf_token() }}">
							
							<div class="form-group">
								<div class="col-md-6">
				                    <label>Password Baru</label>
				                    
				                    <input type="password" id="newpassword" name="newpassword" class="form-control"  placeholder="Password Baru">
				                    @if ($errors->first('newpassword'))
									 <label  class="label label-warning label-bordered label-ghost" for="no_jembatan">Kolom ini diperlukan.</label>
									@endif
				                </div>
								<div class="col-md-6">
				                    <label>Konfrimasi Password</label>
				                    <input type="password" name="konpassword" class="form-control"  placeholder="Konfirmasi Password" >

				                    @if ($errors->first('konpassword'))
									 <label  class="label label-warning label-bordered label-ghost" for="no_jembatan">Kolom ini diperlukan.</label>
									@endif
				                </div>	
				                		
							</div>

				            <br>
							<br>
							<br>

							<div class="col-md-4">
			                    <p>
			                    <button type="submit" class="btn btn-primary btn-shadowed"><span class="icon-smartphone"></span>Edit</button>
			                    <a href="{{ url('/devadmin/member') }}"><button type="button" class="btn btn-warning btn-shadowed"><span class="fa fa-remove"></span>  Batal</button>
			                </p> 
			                </div>
				        </form>
					
					</div>
	            </div>
	            <div class="panel-footer">                                        
	                
	        	</div>
	        </div>
	    </div>
	</div>   
</div>
<!-- END PAGE CONTAINER -->
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#gambar-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#gambar2-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#gambar3-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#gambar4-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#gambar-img").change(function(){
        readURL(this);
    });
    $("#gambar2-img").change(function(){
        readURL2(this);
    });
    $("#gambar3-img").change(function(){
        readURL3(this);
    });
    $("#gambar4-img").change(function(){
        readURL4(this);
    });

    $('#harga').number( true );
    $('#dp1').number( true );
    $('#dp2').number( true );
    $('#dp3').number( true );
    $('#dp4').number( true );
    $('#dp5').number( true );
    $('#dp6').number( true );
    $('#cicilan1').number( true );
    $('#cicilan2').number( true );
    $('#cicilan3').number( true );
    $('#cicilan4').number( true );
    $('#cicilan5').number( true );
    $('#cicilan6').number( true );

    $('#hidden').hide();
</script>

@endsection