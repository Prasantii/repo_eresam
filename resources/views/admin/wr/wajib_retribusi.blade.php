@extends('admin.home')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
    <div>
        <ul class="nav nav-tabs nav-justified">
            
            <li class="active"><a href="#pills-1" data-toggle="tab"><span class="fa fa-home"></span> GAMPONG</a></li>
            <li><a href="#pills-2" data-toggle="tab"><span class="fa fa-building"></span> KOMERSIL</a></li>
            <li><a href="#pills-3" data-toggle="tab"><span class="icon-power-switch"></span> BELUM ADA STATUS</a></li>
        </ul>
        <div class="tab-content tab-content-bordered">
            <div class="tab-pane active" id="pills-1">
               <div id="bb" class="row">                            
                    <div class="col-md-12">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Data Wajib Retribusi (GAMPONG)</b></h3>
                                <br>
                                <div class="panel-elements pull-right">
                                <a href="{{url('/devadmin/wajib_retribusi/cetakWr')}}" target="_blank"><button class="btn btn-success btn-shadowed" type="button"><span class="fa fa-edit"></span> Export</button></a>
 
                                <button type="button" class="btn btn-info btn-shadowed" data-toggle="modal" data-target="#myModal1">Import
                                </button>
                            </div>

                                <div>
                                <a href="{{url('/devadmin/tambahwajib_retribusi')}}"><button class="btn btn-success btn-shadowed" type="button"><span class="fa fa-edit"></span> Tambah</button></a>    
                                </div>
                            </div>
        
                              
                            <div class="panel-body">      
                                <div class="block-content  ">
                                    <table id="gampong" class="table table-head-custom table-bordered table-striped margin-bottom-10 small"  style="width: 100%;" >
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>KODE</th>
                                                <th>NIK</th>
                                                <th>NAMA</th>
                                                <th>ALAMAT</th>
                                                <th>JENIS RETRIBUSI</th>
                                                <th>TARIF</th>
                                                <th>VERIFIKASI</th>
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
            <div class="tab-pane" id="pills-2">
                <div id="aa" class="row">                            
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Data Wajib Retribusi (KOMERSIL)</b></h3>
                                    <br>

                                <div class="panel-elements pull-right">
                                <a href="{{url('/devadmin/wajib_retribusi/cetakWr2')}}" target="_blank"><button class="btn btn-success btn-shadowed" type="button"><span class="fa fa-edit"></span> Export</button></a>

                                <button type="button" class="btn btn-info btn-shadowed" data-toggle="modal" data-target="#myModal2">Import
                                </button>
                                </div>

                                <div>
                                <a href="{{url('/devadmin/tambahwajib_retribusi')}}"><button class="btn btn-success btn-shadowed" type="button"><span class="fa fa-edit"></span> Tambah</button></a>    
                                </div>
                            </div>
                            <div class="panel-body">      
                                <div class="block-content  ">
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
                                                <th>VERIFIKASI</th>
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
            <div class="tab-pane" id="pills-3">
                <div id="cc" class="row">                            
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Data Wajib Retribusi (BELUM ADA STATUS)</b></h3>
                                <br>
                                <div class="panel-elements pull-right">
                                <a href="{{url('/devadmin/wajib_retribusi/cetakWr3')}}" target="_blank"><button class="btn btn-success btn-shadowed" type="button"><span class="fa fa-edit"></span> Export</button></a>

                                <button type="button" class="btn btn-info btn-shadowed" data-toggle="modal" data-target="#myModal3">Import
                                </button>
                                </div>

                                <div>
                                <a href="{{url('/devadmin/tambahwajib_retribusi')}}"><button class="btn btn-success btn-shadowed" type="button"><span class="fa fa-edit"></span> Tambah</button></a>    
                                </div>
                            </div>
                            <div class="panel-body">      
                                <div class="block-content  ">
                                    <table id="sponsor3" class="table table-head-custom table-bordered table-striped margin-bottom-10 small"  style="width: 100%;" >
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>KODE</th>
                                                <th>NIK</th>
                                                <th>NAMA</th>
                                                <th>ALAMAT</th>
                                                <th>JENIS RETRIBUSI</th>
                                                <th>TARIF</th>
                                                <th>VERIFIKASI</th>
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
            
        </div>
    </div>
      
</div>



<!-- Modal gampong -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import File Excel</h4>

      </div>
      <div class="modal-body">
          
      <div class="card card-primary">
      
      <form method="POST"  action="/devadmin/wajib_retribusi/importGampong" enctype="multipart/form-data">      
      {{csrf_field()}}
      
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    
                    <div class="input-group">
                      <div class="custom-file">
                      <!-- <input type="hidden" name="_token" value="{{Session::token()}}" /> -->
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="data-wr" required="required" >
                        <br>
                        <br>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-info" name="submit" value="submit">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
            </div>
            <!-- /.card -->
      </div>
    </div>
  </div>
</div>

<!-- Modal komersil -->
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import File Excel</h4>
      </div>
      <div class="modal-body">
      <div class="card card-primary">
              !!Form::open(['route' => 'import.gampong', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'])!!

              {!! Form::file('import.gampong')}
              <!-- form start -->
       
            </div>
            <!-- /.card -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info" value="import">Submit</button>
      </div>
    </div>


  </div>
</div>

<!-- Modal belum verif -->
<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import File Excel</h4>
      </div>
      <div class="modal-body">
      <div class="card card-primary">
              
              <!-- form start -->
              <form method=POST enctype="multipart/form" action="/devadmin/wajib_retribusi/importGampong">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <br>
                        <br>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-info" name="submit" value="submit">
                      </div>
                      
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
            </div>
            <!-- /.card -->
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

	var table,table2,table3;
   
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
            "aLengthMenu": [ [10, 20, 50, 100], [10, 20, 50, 100] ],
            "iDisplayLength": 10, 
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
            "order": [[ 0, 'DESC' ]],
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
                { data:  'is_active'  },
                  { data: null, render: function ( data, type, row ) {

                    var editUrl = "{{ url('/devadmin/detail/wajib_retribusi', 'url') }}";
                    var edidatatUrl = "{{ url('/devadmin/editwajib_retribusiview/wajib_retribusi', 'url') }}";
                    editUrl = editUrl.replace('url', data['url']);
                    edidatatUrl = edidatatUrl.replace('url', data['url']);

                    var tagihan = "{{ url('/devadmin/detail/tagihan_wr/keseluruhan', 'url') }}";
                    tagihan = tagihan.replace('url', data['url']);

				return '<div class="dropdown">\n\
                            <button type="button" class="btn btn-info btn-shadowed btn-icon" data-toggle="dropdown"><span class="fa fa-arrow-down"></span></button>\n\
                            <ul class="dropdown-menu dropdown-left">\n\
                                <li><a href="#" class="popover-hover btn_detail"  a="'+ editUrl +'" data-placement="left" data-container="body" data-content="Detail Wajib Retribusi" style="background: #4FB5DD;"><span class="fa fa-eye"></span> Detail Wajib Retribusi</a></li> \n\
                                <li><a href="#" class="popover-hover btn_tagihan"  a="'+ tagihan +'" data-placement="left" data-container="body" data-content="Detail Tagihan Wajib Retribusi" style="background: #6ea038;"><span class="fa fa-money"></span>Detail Tagihan</a></li> \n\
                                <li class="divider"></li>\n\
                                <li><a href="#" class="popover-hover btn_edit"  a="'+ edidatatUrl +'" data-placement="left" data-container="body" data-content="Edit Data Wajib Retribusi" style="background: #F69F00;"><span class="fa fa-pencil"></span>Edit Data Wajib Retribusi</a></li> \n\
                                <li><a href="#" class="popover-hover edit_pw"  data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-editpw" data-backdrop="static" data-placement="left" data-content="Edit Password"><i class="fa fa-lock"></i> Edit Password</a></li> \n\
                                <li><a href="#" class="popover-hover delete_btn" a="'+data['id']+'" b="'+data['nama']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus" style="background: #F04E51;"><i class="fa fa-remove"></i>Hapus Data</a></li> \n\
                            </ul>\n\
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

    function loaddatagampong(){
       table2 = $('#gampong').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [10, 20, 50, 100], [10, 20, 50, 100] ],
            "iDisplayLength": 10, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_wajib_retribusi_gampong')}}",
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
            "order": [[ 0, 'DESC' ]],
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
                { data:  'is_active'  },
                  { data: null, render: function ( data, type, row ) {

                    var editUrl = "{{ url('/devadmin/detail/wajib_retribusi', 'url') }}";
                    var edidatatUrl = "{{ url('/devadmin/editwajib_retribusiview/wajib_retribusi', 'url') }}";
                    editUrl = editUrl.replace('url', data['url']);
                    edidatatUrl = edidatatUrl.replace('url', data['url']);

                    var tagihan = "{{ url('/devadmin/detail/tagihan_wr/keseluruhan', 'url') }}";
                    tagihan = tagihan.replace('url', data['url']);

                return '<div class="dropdown">\n\
                            <button type="button" class="btn btn-info btn-shadowed btn-icon" data-toggle="dropdown"><span class="fa fa-arrow-down"></span></button>\n\
                            <ul class="dropdown-menu dropdown-left">\n\
                                <li><a href="#" class="popover-hover btn_detail" a="'+ editUrl +'" data-placement="left" data-container="body" data-content="Detail Wajib Retribusi" style="background: #4FB5DD;"><span class="fa fa-eye"></span> Detail Wajib Retribusi</a></li> \n\
                                <li><a href="#" class="popover-hover btn_tagihan"  a="'+ tagihan +'" data-placement="left" data-container="body" data-content="Detail Tagihan Wajib Retribusi" style="background: #6ea038;"><span class="fa fa-money"></span>Detail Tagihan</a></li> \n\
                                <li class="divider"></li>\n\
                                <li><a href="#" class="popover-hover btn_edit"   a="'+ edidatatUrl +'" data-placement="left" data-container="body" data-content="Edit Data Wajib Retribusi" style="background: #F69F00;"><span class="fa fa-pencil"></span>Edit Data Wajib Retribusi</a></li> \n\
                                <li><a href="#" class="popover-hover edit_pw"  data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-editpw" data-backdrop="static" data-placement="left" data-content="Edit Password"><i class="fa fa-lock"></i> Edit Password</a></li> \n\
                                <li><a href="#" class="popover-hover delete_btn" a="'+data['id']+'" b="'+data['nama']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus" style="background: #F04E51;"><i class="fa fa-remove"></i>Hapus Data</a></li> \n\
                            </ul>\n\
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
    
    function loaddataver(){
       table3 = $('#sponsor3').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [10, 20, 50, 100], [10, 20, 50, 100] ],
            "iDisplayLength": 10, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_WajibRetribusinotverifikasi')}}",
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
            "order": [[ 0, 'DESC' ]],
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
                { data:  'is_active'  },
                  { data: null, render: function ( data, type, row ) {

                    var editUrl = "{{ url('/devadmin/detail/wajib_retribusi', 'url') }}";
                    var edidatatUrl = "{{ url('/devadmin/editwajib_retribusiview/wajib_retribusi', 'url') }}";
                    editUrl = editUrl.replace('url', data['url']);
                    edidatatUrl = edidatatUrl.replace('url', data['url']);

                    var tagihan = "{{ url('/devadmin/detail/tagihan_wr/keseluruhan', 'url') }}";
                    tagihan = tagihan.replace('url', data['url']);

                return '<div class="dropdown">\n\
                            <button type="button" class="btn btn-info btn-shadowed btn-icon" data-toggle="dropdown"><span class="fa fa-arrow-down"></span></button>\n\
                            <ul class="dropdown-menu dropdown-left">\n\
                                <li><a href="#" class="popover-hover btn_detail"  a="'+ editUrl +'" data-placement="left" data-container="body" data-content="Detail Wajib Retribusi" style="background: #4FB5DD;"><span class="fa fa-eye"></span> Detail Wajib Retribusi</a></li> \n\
                                <li><a href="#" class="popover-hover btn_tagihan"  a="'+ tagihan +'" data-placement="left" data-container="body" data-content="Detail Tagihan Wajib Retribusi" style="background: #6ea038;"><span class="fa fa-money"></span>Detail Tagihan</a></li> \n\
                                <li class="divider"></li>\n\
                                <li><a href="#" class="popover-hover btn_edit"  a="'+ edidatatUrl +'" data-placement="left" data-container="body" data-content="Edit Data Wajib Retribusi" style="background: #F69F00;"><span class="fa fa-pencil"></span>Edit Data Wajib Retribusi</a></li> \n\
                                <li><a href="#" class="popover-hover edit_pw"  data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-editpw" data-backdrop="static" data-placement="left" data-content="Edit Password"><i class="fa fa-lock"></i> Edit Password</a></li> \n\
                                <li><a href="#" class="popover-hover delete_btn" a="'+data['id']+'" b="'+data['nama']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus" style="background: #F04E51;"><i class="fa fa-remove"></i>Hapus Data</a></li> \n\
                            </ul>\n\
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

    $(document).on("click", ".edit_pw", function (){
        
        var id = $(this).attr('a');
        $.get('{{ url("/devadmin/editpasswordwrview")}}' + '/' + id, function (data) {
            $('#idbrpw').val(data.data.id);
            $('#modal-backdrop-disable-editpw').modal('show');
            $("#progress2pw").hide();
        })
    });
    
 

    $(document).on('click', '.btn_detail', function () {
            window.location.href = $(this).attr('a');
        });

    $(document).on('click', '.btn_tagihan', function () {
            window.location.href = $(this).attr('a');
        });

    $(document).on('click', '.btn_edit', function () {
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
                    url: "{{ url('/devadmin/editpasswordwraksi') }}",
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



    $(function() {
		 // $("#aa").hide();
		 $("#progress").hide();
         $("#progress2pw").hide();
		
        loaddata();
        loaddatagampong();
        loaddataver();
    });

 

</script>

@endsection