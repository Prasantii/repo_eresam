@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Role</li>
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
	                <h3 class="panel-title"><b>Role Access</b></h3>
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
						            <th>ROLE</th>
						            <th>AKSI</th>
		                            
		                        </tr>
		                    </thead>  
		                    <tfoot>
		                        <tr>
		                            <th>NO</th>
                                    <th>ROLE</th>
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
                        <label>Role Name</label>
                        
                        <input type="text" id="judul" name="judul" class="form-control"  placeholder="Role Name" >
                       
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
                        <label>Role Name</label>
                        
                        <input type="text" id="juduledit" name="juduledit" class="form-control"  placeholder="Role Name" >
                       
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


<div class="modal fade" id="modal-backdrop-disable-editakses" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Edit Data Role Akses</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idbrakses" id="idbrakses">
                    <div id="akses"></div>

                    <div class="col-md-12">
                        <div id="progress3" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                    </div>
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
   
    function resetForm() {
        $('#id').val('');
        $('#judul').val('');
        $('#modal-backdrop-disable').modal('hide');
        $('#progress').hide();

         $('#idbr').val('');
         $('#idbrakses').val('');
        $('#juduleditd').val('');
        $('#menuedit').val('');
        $('#roleedit').val('');
        $('#modal-backdrop-disable-edit').modal('hide');
        $('#progress2').hide();
        $('#progress3').hide();
    }
    

    function loaddata(){
       table = $('#sponsor').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_role')}}",
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
            "columns": [
                { data:  'no'  },
                { data:  'role'  },
                  { data: null, render: function ( data, type, row ) {
				return '<div class="text">\n\
                            <button  class="btn btn-default popover-hover edit_modal" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-edit" data-backdrop="static" data-placement="left" data-content="Edit"><i class="fa fa-pencil"></i> </button>\n\
                            <button class="btn btn-default popover-hover delete_btn" a="'+data['id']+'" b="'+data['role']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
                            <button  class="btn btn-default popover-hover akses" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-edit" data-backdrop="static" data-placement="left" data-content="Access"><i class="fa fa-lock"></i> </button>\n\
						</div>';
			} }
                 
                 
            ],

            drawCallback : function() {
               processInfo(this.api().page.info());
           }
      
        });
    }


    function processInfo(info) {
        //console.log(info);
        // $("#totaldata").hide().html(info.recordsTotal).fadeIn();
        //do your stuff here
    } 

     $('#input-sport').validate({
            // Rules for form validation
            rules: {
                judul: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                judul: {
                    required: "Role Name Tidak Boleh Kosong"
                }
            },

            // Error Placement
            errorPlacement: function(error, element)
            {
                error.insertAfter(element.parent('div').addClass('has-error'));

            },

            //Submit the form
            submitHandler: function (form) {
                var formData = new FormData(form);
                $('#progress').width('0%');
                $('#progress').show();

                $.ajax({
                    type: "POST",
                    url: "{{ url('/devadmin/tambahroleaksi') }}",
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

    $(document).on("click", ".edit_modal", function (){

          var id = $(this).val();

        $.get('{{ url("/devadmin/editroleview")}}' + '/' + id, function (data) {
            $('#idbr').val(data.data.id);
            $('#juduledit').val(data.data.role);
            
            $('#modal-backdrop-disable-edit').modal('show');

            $("#progress2").hide();
        })
    });

    $(document).on("click", ".akses", function (){

          var id = $(this).val();

        $.get('{{ url("/devadmin/editroleakses")}}' + '/' + id, function (data) {
            $('#akses').html(data);
            
            $('#modal-backdrop-disable-editakses').modal('show');

            $("#progress3").hide();
        })
    });

    function redraww(id){
        $.get('{{ url("/devadmin/editroleakses")}}' + '/' + id, function (data) {
            $('#akses').html(data);
        })
    }

    $(document).on("click", ".check-input", function (e){
            e.preventDefault();
            $('#progress3').width('0%');
            $('#progress3').show();

            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');
            $.ajax({
                url: "{{ url('/devadmin/editroleaksesaksi') }}",
                type: 'GET',
                data: {
                    menuId: menuId,
                    roleId: roleId,
                    _token: "{{csrf_token()}}"
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('#progress3').width(percentComplete+'%');
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
                            type: 'success',
                            text: result['msg'],
                            timeout: 4000,
                            layout: 'topRight',
                            
                        }).show();

                        redraww(roleId);
                    }
                    else
                    {
                        new Noty({
                            type: 'warning',
                            text: result['msg'],
                            timeout: 4000,
                            layout: 'topRight',
                            
                        }).show();
                        redraww(roleId);
                    }
                }
            });

        });

    $(function() {
		 // $("#aa").hide();
		 $("#progress").hide();

		
        loaddata();
        $("#edit-sponsor").on('submit',(function(e) {
            e.preventDefault();
            $('#progress2').width('0%');
            $('#progress2').show();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ url('/devadmin/editroleaksi') }}",
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
            	
                text: 'Apakah Role <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/deleterole') }}',
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

</script>
@endsection