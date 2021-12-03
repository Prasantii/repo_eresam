@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Data Petugas</li>
    </ul>
</div>

<!-- END PAGE HEADING -->


@if(Session::has('success'))
    <script type="text/javascript">
        new Noty({
            text: '<strong>Success</strong> {{Session::get('success')}}',
            layout: 'topRight',
            type: 'success'
        }).setTimeout(4000).show();
    </script>
@endif


<div class="container">
      <div id="aa" class="row">                            
	    <div class="col-md-12">
	        <div class="panel panel-warning">
	            <div class="panel-heading">
	                <h3 class="panel-title"><b>Data Petugas</b></h3>
	               <div class="panel-elements pull-right">
                        <a href="{{url('/devadmin/tambahpetugas')}}"><button class="btn btn-success btn-shadowed" type="button"><span class="fa fa-edit"></span> Tambah</button></a>
                    </div>
	            </div>
	            <div class="panel-body">      
					<div class="block-content table-responsive"  style="overflow-y: auto;">
		    			<table id="sponsor" class="table table-head-custom table-bordered table-striped margin-bottom-10 small"  style="width: 100%;" >
		                    <thead>
		                        <tr>
		                            <th>NO</th>
                                    <th>NIK</th>
						            <th>NAMA</th>
                                    <th>EMAIL</th>
                                    <th>ZONA</th>
                                    <th>KOORDINATOR</th>
                                    <th>AKTIF</th>
						            <th>AKSI</th>
		                            
		                        </tr>
		                    </thead>  
		                    <tfoot>
		                        <tr>
		                            <th>NO</th>
                                    <th>NIK</th>
                                    <th>NAMA</th>
                                    <th>EMAIL</th>
                                    <th>ZONA</th>
                                    <th>KOORDINATOR</th>
                                    <th>AKTIF</th>
                                    <th>AKSI</th>
		                        </tr>
		                    </tfoot>                                    
		                   
		                </table>
					</div>
	            </div>
	            <div class="panel-footer">                                        
	                
	        	</div>
	        </div>
	    </div>
	</div>   
</div>

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

<script type="text/javascript">
     $(document).on("mouseenter",".popover-hover",function(){             
            $(this).popover('show');
        }).on("mouseleave",".popover-hover",function(){
            $(this).popover('hide');
        });

	var table;
   
    function resetForm() {

        $('#modal-backdrop-disable-editpw').modal('hide');
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
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_petugas')}}",
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
                {
                    "data": "no",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data:  'nik'  },
                { data:  'nama'  },
                { data:  'email'  },
                { data:  'namazona'  },
                { data:  'namakoordinator'  },
                { data:  'is_active'  },
                

                
                  { data: null, render: function ( data, type, row ) {

                    var editUrl = "{{ url('/devadmin/detail/petugas', 'url') }}";
                    var edidatatUrl = "{{ url('/devadmin/editpetugasview/petugas', 'url') }}";
                    var lokasi = "{{ url('/devadmin/editlokasitugasview', 'url') }}";
                    editUrl = editUrl.replace('url', data['url']);
                    edidatatUrl = edidatatUrl.replace('url', data['url']);
                    lokasi = lokasi.replace('url', data['url']);

				return '<div class="text">\n\
                            <button class="btn btn-info btn-shadowed btn-icon popover-hover" id="btn_detail" a="'+ editUrl +'" data-placement="left" data-container="body" data-content="Detail Petugas"><span class="fa fa-eye"></span></button>\n\
                            <button class="btn btn-warning btn-shadowed btn-icon popover-hover" id="btn_edit" a="'+ edidatatUrl +'" data-placement="left" data-container="body" data-content="Edit Data Petugas"><span class="fa fa-pencil"></span></button>\n\
                            <button class="btn btn-success btn-shadowed btn-icon popover-hover" id="btn_editlokasi" a="'+ lokasi +'" data-placement="left" data-container="body" data-content="Edit Lokasi Tugas Petugas"><span class="fa fa-black-tie"></span></button>\n\
                            <button class="btn btn-danger btn-shadowed btn-icon popover-hover delete_btn" a="'+data['id']+'" b="'+data['nama']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
                            <button class="btn btn-danger btn-shadowed btn-icon popover-hover " id="edit_pw" a="'+data['id']+'" b="'+data['nama']+'" data-container="body" data-toggle="tooltip modal"  data-target="#modal-backdrop-disable-editpw" data-placement="left" data-content="Edit Password"><i class="fa fa-lock"></i></button>\n\
						</div>';
			} }
                 
                 
            ],

         
      
        });

       table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }

 

    $(document).on('click', '#btn_detail', function () {
            window.location.href = $(this).attr('a');
        });

    $(document).on('click', '#btn_edit', function () {
            // window.href($(this).attr('a'));
            window.location.href = $(this).attr('a');
        });

    $(document).on('click', '#btn_editlokasi', function () {
            // window.href($(this).attr('a'));
            window.location.href = $(this).attr('a');
        });
        
    $(document).on("click", "#edit_pw", function (){
        
        var id = $(this).attr('a');
        $.get('{{ url("/devadmin/editpasswordpetugasview")}}' + '/' + id, function (data) {
            $('#idbrpw').val(data.data.id);
            $('#modal-backdrop-disable-editpw').modal('show');
            $("#progress2pw").hide();
        })
    });

     $(document).on('click', '.delete_btn', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                
                text: 'Apakah Data Petugas Atas Nama <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/petugas/delete') }}',
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
                
                text: 'Apakah Petugas Atas Nama  <strong>' + b + '</strong> akan Di <strong>Aktifkan</strong> ?',
                type: 'warning',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/detail/petugas/aktifpetugas') }}',
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
                
                text: 'Apakah Petugas Atas Nama  <strong>' + b + '</strong> akan Di <strong>Non Aktifkan</strong> ?',
                type: 'warning',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/detail/petugas/nonaktifpetugas') }}',
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

        //============================STATUS PETUGAS===============================
        $(document).on('click', '.activee1', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                
                text: 'Apakah Petugas Atas Nama  <strong>' + b + '</strong> akan Di <strong>Aktifkan Sebagai Petugas Komersil</strong> ?',
                type: 'warning',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/detail/petugas/aktifpetugas_komersil') }}',
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

        $(document).on('click', '.shutt1', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                
                text: 'Apakah Petugas Atas Nama  <strong>' + b + '</strong> akan Di <strong>Aktifkan Sebagai Petugas Gampong</strong> ?',
                type: 'warning',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/detail/petugas/aktifpetugas_gampong') }}',
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
                    url: "{{ url('/devadmin/editpasswordpetugasaksi') }}",
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
    
    $(function() {
		 // $("#aa").hide();
		 $("#progress").hide();
		 $("#progress2pw").hide();
		
        loaddata();
    });

</script>
@endsection