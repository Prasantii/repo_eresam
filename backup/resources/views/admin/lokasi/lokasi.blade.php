@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Lokasi</li>
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
      <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Data Kecamatan</b></h3>
                    <div class="panel-elements pull-right">
                        <a href="#"><button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-backdrop-disable-titlemenuadd" data-backdrop="static"><span class="fa fa-edit"></span> Tambah</button></a>
                    </div>
                </div>
                <div class="panel-body">      
                    <div class="block-content"  style="overflow-y: auto;width: 100%">
                        
                    <div  id="aa" class="table-responsive">
                        <table id="titlemenu" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="50%">KECAMATAN</th>
                                    <th width="45%">AKSI</th>
                                    
                                </tr>
                            </thead>  
                            <tfoot>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="50%">KECAMATAN</th>
                                    <th width="45%">AKSI</th>
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
	    <div class="col-md-8">
	        <div class="panel panel-success">
	            <div class="panel-heading">
	                <h3 class="panel-title"><b>DATA GAMPONG</b></h3>
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
                                    <th>KECAMATAN</th>
                                    <th>GAMPONG</th>
						            <th>AKSI</th>
		                            
		                        </tr>
		                    </thead>  
		                    <tfoot>
		                        <tr>
		                            <th>NO</th>
                                    <th>KECAMATAN</th>
                                    <th>GAMPONG</th>
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

<!-- MODAL KECAMATAN MENU -->
<div class="modal fade" id="modal-backdrop-disable-titlemenuadd" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Tambah Data Kecamatan</h4>
            </div>
            <div class="modal-body">
               <form id="input-title" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="idtitle" id="idtitle">
                    <div class="form-group">
                        <label>Nama Kecamatan</label>
                        
                        <input type="text" id="judultitle" name="judultitle" class="form-control"  placeholder="Nama Kecamatan" >
                       
                    </div>

                    <div class="col-md-12">
                        <div id="progresstitlemenu" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
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

<!-- MODAL KECAMATAN MENU -->
<div class="modal fade" id="modal-backdrop-disable-titlemenuedit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Edit Data Kecamatan</h4>
            </div>
            <div class="modal-body">
               <form id="edit-title" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="idbrtitle" id="idbrtitle">
                    <div class="form-group">
                        <label>Nama Kecamatan</label>
                        
                        <input type="text" id="juduledittitle" name="juduledittitle" class="form-control"  placeholder="Nama Kecamatan" >
                       
                    </div>

                    <div class="col-md-12">
                        <div id="progresstitlemenuedit" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
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

<!-- MODAL GAMPONG -->
<div class="modal fade" id="modal-backdrop-disable" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Tambah Data Gampong</h4>
            </div>
            <div class="modal-body">
               <form id="input-sport" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Kecamtan</label>
                        <select name="district_id" id="district_id" class="bs-select" data-live-search="true" >
                            <option id="hiddent" value="">----SILAHKAN PILIH KECAMATAN----</option>
                            @foreach($districts as $men)
                                <option value="{{$men->id}}">{{$men->name}}</option>
                            @endforeach
                        </select>
                       
                    </div>
                    <div class="form-group">
                        <label>Nama Gampong</label>
                        
                        <input type="text" id="judul" name="judul" class="form-control"  placeholder="Nama Gampong" >
                       
                    </div>

                    <div class="col-md-12">
                        <div id="progress" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpann">Simpan</button>
                    </div>
                </form>
            </div>
            
            
        </div>
    </div>            
</div>
<!-- END MODAL BACKDROP DISABLE -->

<!-- MODAL GAMPONG -->
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
                        <label>Kecamatan</label>
                        <select name="district_idedit" id="district_idedit" class="bs-select" data-live-search="true" >
                        </select>
                       
                    </div>
                    <div class="form-group">
                        <label>Nama Gampong</label>
                        
                        <input type="text" id="juduledit" name="juduledit" class="form-control"  placeholder="Nama Gampong" >
                       
                    </div>

                    <div class="col-md-12">
                        <div id="progress2" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpaneditt">Simpan</button>
                    </div>
                </form>
            </div>
            
            
        </div>
    </div>            
</div>
<!-- END MODAL BACKDROP DISABLE -->



<script type="text/javascript">
     $(document).on("mouseenter",".popover-hover",function(){             
            $(this).popover('show');
        }).on("mouseleave",".popover-hover",function(){
            $(this).popover('hide');
        });

	var table,table2;
   
    function resetForm() {
        $('#id').val('');
        $('#idtitle').val('');
        $('#judul').val('');
        $('#judultitle').val('');
        $('#district_id').val('');
        $('#modal-backdrop-disable').modal('hide');
        $('#modal-backdrop-disable-titlemenuadd').modal('hide');
        $('#progress').hide();
        $('#progresstitlemenu').hide();

         $('#idbr').val('');
         $('#idbrtitle').val('');
        $('#juduledit').val('');
        $('#juduledittitle').val('');
        $('#district_idedit').val('');
        $('#modal-backdrop-disable-edit').modal('hide');
        $('#modal-backdrop-disable-titlemenuedit').modal('hide');
        $('#progress2').hide();
        $('#progresstitlemenuedit').hide();
    }
    
    ////////////////////KECAMATAN
    function loaddatatitle(){
       table = $('#titlemenu').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paging":   false,
            "ordering": false,
            "info":     false,
            "bFilter": false,
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/data_kecamatan')}}",
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
                { data:  'name'  },
                  { data: null, render: function ( data, type, row ) {
                return '<div class="text">\n\
                            <button  class="btn btn-sm btn-default popover-hover edit_modaltitle" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-edit" data-backdrop="static" data-placement="left" data-content="Edit"><i class="fa fa-pencil"></i> </button>\n\
                            <button class="btn btn-sm btn-default popover-hover delete_btntitle" a="'+data['id']+'" b="'+data['name']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
                        </div>';
            } }
                 
                 
            ]
      
        });
    }

    /////////////////////Gampong
    function loaddata(){
       table2 = $('#sponsor').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "numbers",
            "aLengthMenu": [ [10, 20, 50, 100], [10, 20, 50, 100] ],
            "iDisplayLength": 10, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/data_gampong')}}",
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
                { data:  'districtsname'  },
                { data:  'name'  },
                  { data: null, render: function ( data, type, row ) {
				return '<div class="text">\n\
                            <button  class="btn btn-default popover-hover edit_modal" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-edit" data-backdrop="static" data-placement="left" data-content="Edit"><i class="fa fa-pencil"></i> </button>\n\
                            <button class="btn btn-default popover-hover delete_btn" a="'+data['id']+'" b="'+data['name']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
						</div>';
			} }
                 
                 
            ]
        });

       table2.on( 'order.dt search.dt', function () {
            table2.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }

    ///////////////////KECAMTAN
     $('#input-title').validate({
            // Rules for form validation
            rules: {
                judultitle: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                judultitle: {
                    required: "KECAMATAN Tidak Boleh Kosong"
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
                $('#progresstitlemenu').width('0%');
                $('#progresstitlemenu').show();

                $.ajax({
                    type: "POST",
                    url: "{{ url('/tambahkecamatanaksi') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progresstitlemenu", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#progresstitlemenu').width(percentComplete+'%');
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

                            $("#progresstitlemenu").hide();
                        }
                    }
                });
                return false;
            }
        });


    ///////////////////Gampong
     $('#input-sport').validate({
            // Rules for form validation
            rules: {
                judul: {
                    required: true
                },
                district_id: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                judul: {
                    required: "Nama Menu Tidak Boleh Kosong"
                },
                district_id: {
                    required: "Kecamatan Wajib Di pilih"
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
                    url: "{{ url('/tambahgampongaksi') }}",
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
                            table2.draw();
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

     /////////////////KECAMATAN
     $(document).on("click", ".edit_modaltitle", function (){

          var id = $(this).val();

        $.get('{{ url("/editkecamatanview")}}' + '/' + id, function (data) {
            $('#idbrtitle').val(data.data.id);
            $('#juduledittitle').val(data.data.name);
            
            $('#modal-backdrop-disable-titlemenuedit').modal('show');

            $("#progresstitlemenuedit").hide();
        })
    });

     /////////////////GAMPONG
    $(document).on("click", ".edit_modal", function (){

          var id = $(this).val();

        $.get('{{ url("/editgampongview")}}' + '/' + id, function (data) {
            $('#idbr').val(data.data.id);
            $('#juduledit').val(data.data.name);
            $("#district_idedit").html('');
            $('#district_idedit').append(data.sbb).selectpicker('refresh');

            
            $('#modal-backdrop-disable-edit').modal('show');

            $("#progress2").hide();
        })
    });


    $(function() {

       
       $("#progress").hide();
	   $("#progresstitlemenu").hide();

		
        loaddata();
        loaddatatitle();

        ////////////////////KECAMATAN
        $("#edit-title").on('submit',(function(e) {
            e.preventDefault();
            $('#progresstitlemenuedit').width('0%');
            $('#progresstitlemenuedit').show();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ url('/editkecamatanaksi') }}",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progresstitlemenuedit", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('#progresstitlemenuedit').width(percentComplete+'%');
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

                        $("#progresstitlemenueditss").hide();
                    }
                }

            });
        }));

        ////////////////////GAMPONG
        $("#edit-sponsor").on('submit',(function(e) {
            e.preventDefault();
            $('#progress2').width('0%');
            $('#progress2').show();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ url('/editgampongaksi') }}",
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
                        table2.draw();
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


        ///////////////////KECAMATAN
        $(document).on('click', '.delete_btntitle', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                
                text: 'Apakah Kecamatan <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/deletekecamatan') }}',
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

        ///////////////////GAMPONG
        $(document).on('click', '.delete_btn', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
            	
                text: 'Apakah Gampong <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/deletegampong') }}',
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

                                    table2.draw();

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
    $("#hiddent").hide();
</script>
@endsection