@extends('admin.home')
@section('content')

<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Data Admin</li>
    </ul>
</div>
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


<!-- START PAGE CONTAINER -->
<div class="container"> 
	<div class="block block-condensed">
    	<div class="block-divider-text"><h2>Data User</h2></div>
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
		<br><br>
			<table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lenkap</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>                                    
                <tbody>
					<?php $no=1; ?>
            <?php foreach ($admins as $admin) { ?>
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$admin->nama}}</td>
                    <td>{{$admin->username}}</td>
                    <td >
                       <a href="{{ URL::Route('AdminEdit', $admin->id) }}"> <button type="button" class="btn btn-warning btn-shadowed"><span class="fa fa-check-square-o"></span>Edit</button> </a>
                       <button type="button" class="btn btn-danger btn-shadowed delete_btn" a="{{$admin->id}}" b="{{$admin->username}}"><span class="icon-cross"></span>Hapus</button>
                       <a href="{{ URL::Route('AdminEditPas', $admin->id) }}"> <button type="button" class="btn btn-warning btn-shadowed "><span class="fa fa-check-square-o"></span>Ubah Password</button> </a>
                        
                    </td>
                </tr>
<?php } ?>
                </tbody>
            </table>
			
            <hr style="border-top: 1px solid #dca300;">
            <center><a href="{{ url('/devadmin/tambah-admin') }}"><button type="button" class="btn btn-info btn-shadowed"><span class="fa fa-check-square-o"></span>  Tambah Admin</button></a></center>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {

        $(document).on('click', '.delete_btn', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                theme: 'nest',
                text: 'Apakah Username <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'GET',
                            url: '{{ url('/devadmin/hapus-admin') }}',
                            data: ({a:a, _token:'{{csrf_token()}}'}),
                            success: function(result){
                                if(result['status'] == 'success')
                                {
                                    new Noty({
                                        type: 'warning',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        theme: 'nest',
                                        timeout: 4000,
                                    }).show();

                                    table.draw();

                                }
                                else
                                {
                                    new Noty({
                                        type: 'error',
                                        text: result['msg'],
                                        timeout: 2000,
                                    }).show();
                                }
                            }
                        });

                    }, {id: 'button1', 'data-status': 'ok'}),

                    Noty.button('BATAL', 'btn btn-error', function () {
                        n.close();
                    })
                ]
            }).show();

        });
       
    });
</script>
@stop