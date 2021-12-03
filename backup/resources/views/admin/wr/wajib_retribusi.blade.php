@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Data Wajib Retribusi</li>
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
	        <div class="panel panel-info">
	            <div class="panel-heading">
	                <h3 class="panel-title"><b>Data Wajib Retribusi</b></h3>
	               <div class="panel-elements pull-right">
                        <a href="{{url('/devadmin/tambahwajib_retribusi')}}"><button class="btn btn-success btn-shadowed" type="button"><span class="fa fa-edit"></span> Tambah</button></a>
                    </div>
	            </div>
	            <div class="panel-body">      
					<div class="block-content table-responsive"  style="overflow-y: auto;">
		    			<table id="sponsor" class="table table-head-custom table-bordered table-striped margin-bottom-10 small"  style="width: 100%;" >
		                    <thead>
		                        <tr>
		                            <th>NO</th>
                                    <th>KODE</th>
                                    <th>NIK</th>
						            <th>NAMA</th>
                                    <th>ALAMAT</th>
                                    <th>JENIS RETRIBUSI</th>
                                    <th>TARIF</th>
						            <th>AKSI</th>
		                            
		                        </tr>
		                    </thead>  
		                </table>
					</div>
	            </div>
	            <div class="panel-footer">                                        
	                
	        	</div>
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
                "url": "{{url('/devadmin/data_wajib_retribusi')}}",
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
                { data:  'code'  },
                { data:  'nik'  },
                { data:  'nama'  },
                { data:  'alamat'  },
                { data:  'jenis'  },
                { data:  'tarif'  },
                  { data: null, render: function ( data, type, row ) {

                    var editUrl = "{{ url('/devadmin/detail/wajib_retribusi', 'url') }}";
                    var edidatatUrl = "{{ url('/devadmin/editwajib_retribusiview/wajib_retribusi', 'url') }}";
                    editUrl = editUrl.replace('url', data['url']);
                    edidatatUrl = edidatatUrl.replace('url', data['url']);

                    var tagihan = "{{ url('/devadmin/detail/tagihan_wr/keseluruhan', 'url') }}";
                    tagihan = tagihan.replace('url', data['url']);

				return '<div class="text">\n\
                            <button class="btn btn-info btn-shadowed btn-icon popover-hover" id="btn_detail" a="'+ editUrl +'" data-placement="left" data-container="body" data-content="Detail Wajib Retribusi"><span class="fa fa-eye"></span></button>\n\
                            <button class="btn btn-success btn-shadowed btn-icon popover-hover" id="btn_tagihan" a="'+ tagihan +'" data-placement="left" data-container="body" data-content="Detail Tagihan Wajib Retribusi"><span class="fa fa-money"></span></button>\n\
                            <button class="btn btn-danger btn-shadowed btn-icon popover-hover delete_btn" a="'+data['id']+'" b="'+data['nama']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
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

    $(document).on('click', '#btn_tagihan', function () {
            window.location.href = $(this).attr('a');
        });

    $(document).on('click', '#btn_edit', function () {
            // window.href($(this).attr('a'));
            window.location.href = $(this).attr('a');
        });

     $(document).on('click', '.delete_btn', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                
                text: 'Apakah Data Wajib Retribusi Atas Nama <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/wajib_retribusi/delete') }}',
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
                
                text: 'Apakah Wajib Retribusi Atas Nama  <strong>' + b + '</strong> akan Di <strong>Aktifkan</strong> ?',
                type: 'warning',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/detail/wajib_retribusi/aktifwajib_retribusi') }}',
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
                
                text: 'Apakah Wajib Retribusi Atas Nama  <strong>' + b + '</strong> akan Di <strong>Non Aktifkan</strong> ?',
                type: 'warning',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/detail/wajib_retribusi/nonaktifwajib_retribusi') }}',
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


    $(function() {
		 // $("#aa").hide();
		 $("#progress").hide();
		
        loaddata();
    });

</script>
@endsection