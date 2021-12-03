@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Zona</li>
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
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title"><b>Zona Management</b></h3>
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
                                    <th>NAMA ZONA</th>
						            <th>ACTIVE</th>
						            <th>AKSI</th>
		                            
		                        </tr>
		                    </thead>  
		                    <tfoot>
		                        <tr>
		                           <th>NO</th>
                                    <th>NAMA ZONA</th>
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
                        <label>Nama Zona</label>
                        
                        <input type="text" id="nama" name="nama" class="form-control"  placeholder="Nama Zona" >
                       
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                    <?php $i = 1;$u = 1; ?>
                        @foreach($districts as $men)
                        <div class="app-checkbox success"> 
                            <label><input id="id_districts[<?php echo $u++; ?>]" type="checkbox" name="data[<?php echo $i++; ?>][districts]" value="{{$men->id}}" > {{$men->name}}<span></span></label> 
                        </div>
                    @endforeach
                    </div>
                    
                        <div class="app-checkbox"> 
                            <label><input type="checkbox" name="is_active" value="1" checked="checked"> Active Zona?<span></span></label> 
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
                
                    
                    <div id="districtseditt"></div>
                    
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
        // $('#id_districts').val('');
        $('input[type=checkbox]').prop('checked',false);
        $('#nama').val('');
        $('#modal-backdrop-disable').modal('hide');
        $('#progress').hide();

         $('#idbr').val('');
        $('#id_districtseditedit').val('');
        $('#namaedit').val('');
        $('#modal-backdrop-disable-edit').modal('hide');
        $('#progress2').hide();
    }
    

    function loaddata(){
       table = $('#sponsor').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [20, 20, 50, 100], [20, 20, 50, 100] ],
            "iDisplayLength": 20, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_zona')}}",
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
                { data:  'nama'  },
                { data:  'is_active'  },
                  { data: null, render: function ( data, type, row ) {
				return '<div class="text">\n\
                            <button  class="btn btn-default popover-hover edit_modal" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-edit" data-backdrop="static" data-placement="left" data-content="Edit"><i class="fa fa-pencil"></i> </button>\n\
                            <button class="btn btn-default popover-hover delete_btn" a="'+data['id']+'" b="'+data['nama']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
						</div>';
			} }
                 
                 
            ]
      
        });

       table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        }



     $('#input-sport').validate({
            // Rules for form validation
            rules: {
                id_districts: {
                    required: true
                },
                nama: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                id_districts: {
                    required: "Gampong Wajib Di Pilih"
                },
                nama: {
                    required: "nama Wajib Diisi"
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
                    url: "{{ url('/devadmin/tambahzonaaksi') }}",
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

        $.get('{{ url("/devadmin/editzonaview")}}' + '/' + id, function (data) {
            $('#districtseditt').html(data);
            
            $('#modal-backdrop-disable-edit').modal('show');

            $("#progress2").hide();
        })
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
                url: "{{ url('/devadmin/editzonaaksi') }}",
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
            	
                text: 'Apakah Zona <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/deletezona') }}',
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
                
                text: 'Apakah Zona <strong>' + b + '</strong> akan Di <strong>Aktifkan</strong> ?',
                type: 'info',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/aktifzona') }}',
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
                
                text: 'Apakah Zona <strong>' + b + '</strong> akan Di <strong>Non Aktifkan</strong> ?',
                type: 'warning',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/nonaktifzona') }}',
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