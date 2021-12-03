@extends('admin.home')
@section('content')
<style type="text/css">
    select {
        font-family: 'FontAwesome', 'sans-serif';
    }
    
</style>
<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Management Data User</li>
    </ul>
</div>

<!-- END PAGE HEADING -->


@if(Session::has('success'))
    <script type="text/javascript">
        new Noty({
            text: '<strong>Success</strong> {{Session::get('success')}}',
            layout: 'topRight',
            type: 'success',
        }).setTimeout(4000).show();
    </script>
@endif


<div class="container">
      <div id="aa" class="row">                            
	    <div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title"><b>Management Data User </b></h3>
	                <div class="panel-elements pull-right">
			            <a href="#"><button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-backdrop-disable" data-backdrop="static"><span class="fa fa-edit"></span> Tambah</button></a>
			        </div>
	            </div>
	            <div class="panel-body">      
					<div class="block-content"  style="overflow-y: auto;">
						
					<div  id="aa">
		    			<table id="sponsor" class="table table-striped table-bordered"  style="width: max-content 100%;" >
		                    <thead>
		                        <tr>
		                            <th>NO</th>
                                    <th>NAMA</th>
                                    <th>EMAIL</th>
                                    <th>USERNAME</th>
                                    <th>HAK AKSES</th>
						            <th>ACTIVE</th>
						            <th>AKSI</th>
		                            
		                        </tr>
		                    </thead>  
		                    <tfoot>
		                        <tr>
		                            <th>NO</th>
                                    <th>NAMA</th>
                                    <th>EMAIL</th>
                                    <th>USERNAME</th>
                                    <th>HAK AKSES</th>
                                    <th>ACTIVE</th>
                                    <th>AKSI</th>
		                        </tr>
		                    </tfoot>                                    
		                   
		                </table>
		                
		            </div>
					
					</div>
	            </div>
	            <div class="panel-footer">                                        
	                
	        	</div>
	        </div>
	    </div>
	</div>   
</div>

<!-- MODAL BACKDROP DISABLE -->
<div class="modal fade" id="modal-backdrop-disable" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Tambah Data</h4>
            </div>
            <div class="modal-body">
               <form id="input-sport" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        
                        <input type="text" id="name" name="name" class="form-control"  placeholder="Nama Lengkap" >
                       
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        
                        <input type="email" id="email" name="email" class="form-control"  placeholder="Email" >
                       
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        
                        <input type="text" id="username" name="username" class="form-control"  placeholder="Username" >
                       
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="password" name="password" class="form-control"  placeholder="Password" >
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" id="password2" name="password2" class="form-control"  placeholder="Konfirmasi Password" >
                    </div>

                    <div class="form-group">
                        <label>Hak Akses</label>
                        <select name="role_id" id="role_id" class="bs-select" data-live-search="true" >
                            <option id="hidden" value="">----SILAHKAN PILIH HAK AKSES----</option>
                            @foreach($roleak as $men)
                                <option value="{{$men->id}}">{{$men->role}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="block">    
                            <div class="app-heading app-heading-small">                                
                                <div class="title">
                                    <h2>Photo</h2>
                                </div>                                
                            </div>
                            <input  type="file" id="image" name="image" class="form-control"  placeholder="Nama image" class="dropzone"> <br>
                            <img id="image-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="app-checkbox success inline"> 
                            <label><input type="checkbox" name="is_active" value="1" checked="checked"> Active<span></span></label> 
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="progress" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>            
</div>
<!-- END MODAL BACKDROP DISABLE -->

<!-- MODAL BACKDROP DISABLE -->
<div class="modal fade" id="modal-backdrop-disable-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Edit Data</h4>
            </div>
            <div class="modal-body">
               <form id="edit-sponsor" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="idbr" id="idbr">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        
                        <input type="text" id="nameedit" name="nameedit" class="form-control"  placeholder="Nama Lengkap" >
                       
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        
                        <input type="email" id="emailedit" name="emailedit" class="form-control"  placeholder="Email" >
                       
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        
                        <input type="text" id="usernameedit" name="usernameedit" class="form-control"  placeholder="Username" >
                       
                    </div>

                    <div class="form-group">
                        <label>Hak Akses</label>
                        <select name="role_idedit" id="role_idedit" class="bs-select" data-live-search="true" >
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="block">    
                            <div class="app-heading app-heading-small">                                
                                <div class="title">
                                    <h2>Photo</h2>
                                </div>                                
                            </div>
                            <input  type="file" id="imageedit" name="imageedit" class="form-control"  placeholder="Nama image" class="dropzone"> <br>
                            <img id="imageedit-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div id="progress2" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpanedit">Simpan</button>
                    </div>
                </form>
            </div>
            
            
        </div>
    </div>            
</div>
<!-- END MODAL BACKDROP DISABLE -->


<div class="modal fade" id="modal-backdrop-disable-editpw" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-headerpw">Edit Password</h4>
            </div>
            <div class="modal-body">
               <form id="edit-sponsor-pw" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="idbrpw" id="idbrpw">
                    <div class="form-group">
                        <label>Password</label>
                        
                        <input type="password" id="passwordpw" name="passwordpw" class="form-control"  placeholder="Password Baru" >
                       
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        
                        <input type="password" id="passwordpw2" name="passwordpw2" class="form-control"  placeholder="Konfirmasi Password" >
                       
                    </div>
                    
                    <div class="col-md-12">
                        <div id="progress2pw" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpaneditpw">Simpan</button>
                    </div>
                </form>
            </div>
            
            
        </div>
    </div>            
</div>

{{-- <script type="text/javascript" src="{{ asset('admins/js/vendor/jquery/jquery.min.js') }}"></script> --}}


<script type="text/javascript">
     $(document).on("mouseenter",".popover-hover",function(){             
            $(this).popover('show');
        }).on("mouseleave",".popover-hover",function(){
            $(this).popover('hide');
        });

	var table;

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#image-tag').attr('src', e.target.result);
                $('#imageedit-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function(){
        readURL(this);
    });
    $("#imageedit").change(function(){
        readURL(this);
    });
   
    function resetForm() {
        $('#id').val('');
        $('#name').val('');
        $('#email').val('');
        $('#username').val('');
        $('#image').val('');
        $('#password').val('');
        $('#password2').val('');
        $('#role_id').val('');
        $('#image-tag').attr('src', '{{ asset('admins/img/images.jpg') }}');
        $('#modal-backdrop-disable').modal('hide');
        $('#progress').hide();

         $('#idbr').val('');
        $('#nameedit').val('');
        $('#emailedit').val('');
        $('#usernameedit').val('');
        $('#imageedit').val('');
        $('#role_idedit').val('');
        $('#imageedit-tag').attr('src', '{{ asset('admins/img/images.jpg') }}');
        $('#modal-backdrop-disable-edit').modal('hide');
        $('#modal-backdrop-disable-editpw').modal('hide');
        $('#progress2').hide();
        $('#progress2pw').hide();

        $('#idbrpw').val('');
        $('#passwordpw').val('');
        $('#passwordpw2').val('');
    }
    

    function loaddata(){
       table = $('#sponsor').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paging":   true,
            "ordering": true,
            "info":     true,
            "bFilter": true,
            "paginationType": "full_numbers",
            "aLengthMenu": [ [10, 20, 50, 100], [10, 20, 50, 100] ],
            "iDisplayLength": 10, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_manajement/user')}}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
           
            "language": {
                "url": "{{ asset('admins/js/vendor/datatables/language/Indonesia.json') }}"
            },
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 0 },
            ],
            "order": [[ 0, 'asc' ]],
            "columns": [
                {
                    "data": "no",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data:  'name'  },
                { data:  'email'  },
                { data:  'username'  },
                { data:  'role_id'  },
                { data:  'is_active'  },
                  { data: null, render: function ( data, type, row ) {
				return '<div class="text">\n\
                            <button  class="btn btn-info popover-hover edit_modal" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-edit" data-backdrop="static" data-placement="left" data-content="Edit"><i class="fa fa-pencil"></i> </button>\n\
                            <button class="btn btn-danger popover-hover delete_btn" a="'+data['id']+'" b="'+data['name']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
                            <button  class="btn btn-warning popover-hover edit_pw" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-editpw" data-backdrop="static" data-placement="left" data-content="Edit Password"><i class="fa fa-lock"></i></button>\n\
						</div>';
			} }
                 
                 
            ],

            drawCallback : function() {
               processInfo(this.api().page.info());
           }
      
        });

       table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        }



    function processInfo(info) {
        //console.log(info);
        // $("#totaldata").hide().html(info.recordsTotal).fadeIn();
        //do your stuff here
    } 

     $('#input-sport').validate({
            // Rules for form validation
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true
                },
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                password2: {
                    required: true,
                    equalTo : "#password"
                },
                role_id: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                name: {
                    required: "Nama Wajib Diisi"
                },
                email: {
                    required: "email Wajib Diisi"
                },
                username: {
                    required: "username Wajib Diisi"
                },
                password: {
                    required: "password Wajib Diisi"
                },
                password2: {
                    required: "Konfrimasi password Wajib Diisi",
                    equalTo: "Konfrimasi password Tidak Sama"

                },
                role_id: {
                    required: "Hak Akses Wajib Dipilih"
                }
            },

            // Error Placement
            errorPlacement: function(error, element)
            {
                // error.insertAfter(element.parent('div').addClass('has-error'));
                error.insertAfter(element).parent('div').addClass('has-error');

            },
            highlight: function (element, errorClass, validClass) {
                $(element).parent("div").removeClass("has-succes").addClass('has-error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parent("div").removeClass("has-error").addClass('has-success');
            },

            //Submit the form
            submitHandler: function (form) {
                var formData = new FormData(form);
                $('#progress').width('0%');
                $('#progress').show();

                $.ajax({
                    type: "POST",
                    url: "{{ url('/devadmin/tambahmanajement/useraksi') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#progress').width(percentComplete+'%');
                            }
                        }, false);

                        return xhr;
                    },
                    error: function (e) {
                        new Noty({
                            type: 'error',
                            text: 'Response error ' + e,
                            timeout: 4000,
                        }).show();
                    },
                    success: function (result) {
                        if(result['status'] == 'success')
                        {
                            new Noty({
                                type: 'success',
                                text: result['msg'],
                                timeout: 4000,
                                layout: 'topRight',
                                
                            }).show();

                            resetForm();
                            table.draw();
                        }
                        else
                        {
                            new Noty({
                                type: 'error',
                                text: result['msg'],
                                timeout: 4000,
                                layout: 'topRight',
                                
                            }).show();

                            $("#progress").hide();
                        }
                    }
                });
                return false;
            }
        });
    $(document).on("click", ".edit_pw", function (){
        
        var id = $(this).val();
        $.get('{{ url("/devadmin/editpasswordmanajementview/useraksi")}}' + '/' + id, function (data) {
            $('#idbrpw').val(data.data.id);

            $('#modal-backdrop-disable-editpw').modal('show');

            $("#progress2pw").hide();
        })
    });
    $('#edit-sponsor-pw').validate({
            // Rules for form validation
            rules: {
                passwordpw: {
                    required: true
                },
                passwordpw2: {
                    required: true,
                    equalTo : "#passwordpw"
                }
            },

            // Messages for form validation
            messages: {
                passwordpw: {
                    required: "Password Wajib Diisi"
                },
                passwordpw2: {
                    required: "Konfrimasi password Wajib Diisi",
                    equalTo: "Konfrimasi password Tidak Sama"
                }
            },

            // Error Placement
            errorPlacement: function(error, element)
            {
                // error.insertAfter(element.parent('div').addClass('has-error'));
                error.insertAfter(element).parent('div').addClass('has-error');

            },
            highlight: function (element, errorClass, validClass) {
                $(element).parent("div").removeClass("has-succes").addClass('has-error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parent("div").removeClass("has-error").addClass('has-success');
            },

            //Submit the form
            submitHandler: function (form) {
                var formData = new FormData(form);
                $('#progress2pw').width('0%');
                $('#progress2pw').show();

                $.ajax({
                    type: "POST",
                    url: "{{ url('/devadmin/editpasswordmanajement/useraksi') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress2pw", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#progress2pw').width(percentComplete+'%');
                            }
                        }, false);

                        return xhr;
                    },
                    error: function (e) {
                        new Noty({
                            type: 'error',
                            text: 'Response error ' + e,
                            timeout: 4000,
                        }).show();
                    },
                    success: function (result) {
                        if(result['status'] == 'success')
                        {
                            new Noty({
                                type: 'success',
                                text: result['msg'],
                                timeout: 4000,
                                layout: 'topRight',
                                
                            }).show();

                            resetForm();
                            table.draw();
                        }
                        else
                        {
                            new Noty({
                                type: 'error',
                                text: result['msg'],
                                timeout: 4000,
                                layout: 'topRight',
                                
                            }).show();

                            $("#progress").hide();
                        }
                    }
                });
                return false;
            }
        });

    $(document).on("click", ".edit_modal", function (){

          var id = $(this).val();

        $.get('{{ url("/devadmin/editmanajement/userview")}}' + '/' + id, function (data) {
            $('#idbr').val(data.data.id);
            $("#role_idedit").empty();
            $('#role_idedit').append(data.sbb).selectpicker('refresh');

            $('#nameedit').val(data.data.name);
            $('#usernameedit').val(data.data.username);
            $('#emailedit').val(data.data.email);

            $('#imageedit-tag').attr('src', '{{asset("/")}}' + data.data.image);

            
            $('#modal-backdrop-disable-edit').modal('show');

            $("#progress2").hide();
        })
    });


    $(function() {
		 // $("#aa").hide();
         $("#progress").hide();
		 $("#progress2pw").hide();

		
        loaddata();
        $("#edit-sponsor").on('submit',(function(e) {
            e.preventDefault();
            $('#progress2').width('0%');
            $('#progress2').show();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ url('/devadmin/editmanajement/useraksi') }}",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('#progress').width(percentComplete+'%');
                        }
                    }, false);

                    return xhr;
                },
                error: function (e) {
                    new Noty({
                        type: 'error',
                        text: 'Response error ' + e,
                        timeout: 4000,
                        layout: 'topRight',
                        
                    }).show();
                },
                success: function(result){
                    if(result['status'] == 'success')
                    {
                        new Noty({
                            type: 'warning',
                            text: result['msg'],
                            timeout: 4000,
                            layout: 'topRight',
                            
                        }).show();

                        resetForm();
                        table.draw();
                    }
                    else
                    {
                        new Noty({
                            type: 'error',
                            text: result['msg'],
                            timeout: 4000,
                            layout: 'topRight',
                            
                        }).show();

                        $("#progress").hide();
                    }
                }

            });
        }));

        $(document).on('click', '.delete_btn', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
            	
                text: 'Apakah Data User <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/deletemanajement/user') }}',
                            data: ({a:a, _token:'{{csrf_token()}}'}),
                            success: function(result){
                                if(result['status'] == 'success')
                                {
                                    new Noty({
                                        type: 'warning',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        
                                        timeout: 4000,
                                    }).show();

                                    table.draw();

                                }
                                else
                                {
                                    new Noty({
                                        type: 'error',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        
                                        timeout: 4000,
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


        $(document).on('click', '.activee', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                
                text: 'Apakah Data User <strong>' + b + '</strong> akan Di <strong>Aktifkan</strong> ?',
                type: 'info',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/aktifmanajement/user') }}',
                            data: ({a:a, _token:'{{csrf_token()}}'}),
                            success: function(result){
                                if(result['status'] == 'success')
                                {
                                    new Noty({
                                        type: 'success',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        
                                        timeout: 4000,
                                    }).show();

                                    table.draw();

                                }
                                else
                                {
                                    new Noty({
                                        type: 'error',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        
                                        timeout: 4000,
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

        $(document).on('click', '.shutt', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                
                text: 'Apakah Data User <strong>' + b + '</strong> akan Di <strong>Non Aktifkan</strong> ?',
                type: 'warning',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/nonaktifmanajement/user') }}',
                            data: ({a:a, _token:'{{csrf_token()}}'}),
                            success: function(result){
                                if(result['status'] == 'success')
                                {
                                    new Noty({
                                        type: 'warning',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        
                                        timeout: 4000,
                                    }).show();

                                    table.draw();

                                }
                                else
                                {
                                    new Noty({
                                        type: 'error',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        
                                        timeout: 4000,
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
    

    $('#hidden').hide();
</script>
@endsection