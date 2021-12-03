@extends('admin.home')
@section('content')
<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Dashboard</li>
    </ul>
</div>

<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="min-width: 90px;">
            <!-- CREDIT CARD -->
            <div class="credit-card" style="border-right: 6px solid rgb(147, 197, 75);">
                <div class="row number text-left">
                    <div class="col-xs-6" id="balance" style="color: rgb(147, 197, 75);">{{$wr}}</div>
                    <div class="col-xs-6 text-right" style="font-size: 46px;">
                        <span class="fa fa-users"></span></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="subtitle" style="color: rgb(147, 197, 75);"><b>JUMLAH WAJIB RETRIBUSI</b></div>
                    </div>
                </div>
            </div>
            <!-- END CREDIT CARD -->
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="min-width: 90px;">
            <!-- CREDIT CARD -->
            <div class="credit-card" style="border-right: 6px solid rgb(75, 152, 197);">
                <div class="row number text-left">
                    <div class="col-xs-6" style="color: rgb(75, 152, 197);">{{$petugas}}</div>
                    <div class="col-xs-6 text-right" style="font-size: 46px;">
                        <span class="fa fa-male"></span></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="subtitle" style="color: rgb(75, 152, 197);"><b>JUMLAH PETUGAS</b></div>
                    </div>
                </div>
            </div>
            <!-- END CREDIT CARD -->
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="min-width: 90px;">
            <!-- CREDIT CARD -->
            <div class="credit-card" style="border-right: 6px solid rgb(197, 75, 75);">
                <div class="row number text-left">
                    <div class="col-xs-6" style="color: rgb(197, 75, 75);">{{$koordinator}}</div>
                    <div class="col-xs-6 text-right" style="font-size: 46px;">
                        <span class="fa fa-ambulance"></span></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="subtitle" style="color: rgb(197, 75, 75);"><b>JUMLAH KOORDINATOR</b></div>
                    </div>
                </div>
            </div>
            <!-- END CREDIT CARD -->
        </div> 
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="min-width: 90px;">
            <!-- CREDIT CARD -->
            <div class="credit-card" style="border-right: 6px solid rgb(75, 152, 197);">
                <div class="row number text-left">
                    <div class="col-xs-6" style="color: rgb(75, 152, 197);">{{$wrjumlah}}</div>
                    <div class="col-xs-6 text-right" style="font-size: 46px;">
                        <span class="fa fa-check"></span></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="subtitle" style="color: rgb(75, 152, 197);"><b>JUMLAH WR SUDAH DI VERIFIKASI</b></div>
                    </div>
                </div>
            </div>
            <!-- END CREDIT CARD -->
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="min-width: 90px;">
            <!-- CREDIT CARD -->
            <div class="credit-card" style="border-right: 6px solid rgb(197, 75, 75);">
                <div class="row number text-left">
                    <div class="col-xs-6" style="color: rgb(197, 75, 75);">{{$wrbelumverif}}</div>
                    <div class="col-xs-6 text-right" style="font-size: 46px;">
                        <span class="fa fa-close"></span></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="subtitle" style="color: rgb(197, 75, 75);"><b>JUMLAH WR BELUM DI VERIFIKASI</b></div>
                    </div>
                </div>
            </div>
            <!-- END CREDIT CARD -->
        </div> 
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Tagihan Wajib Retribusi Bulan Ini</b></h3>
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
                                    <th>JENIS RETRIBUSI</th>
                                    <th>TARIF</th>
                                    <th>STATUS BULAN INI</th>
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
    
    <div class="row">
        
    </div>
</div>

<script type="text/javascript">
    // function chart() {
 //        var line = Morris.Donut({
           
 //            element: 'morris-donutt',
 //            data: ,
 //            // xkey: 'label',
 //            // ykeys: ['lk','pp'],
 //            // labels: ["Pegawai Laki-Laki", "Pegawai Perempuan"],
 //            // resize: true,
 //            // lineColors: ['#4FB5DD','#76AB3C'],
 //            // parseTime: false
 //            colors: ['rgb(75, 152, 197)','rgb(197, 75, 75)'],
            

 //        });

 //        line.redraw();
 //    }

 //    $(function() {
 //     setTimeout(function () {
 //                chart();
 //            }, 1000);
 //    });


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
                "url": "{{url('/devadmin/data_tagihan_wr')}}",
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
                { data:  'jenis'  },
                { data:  'tarif'  },
                { data:  'status'  },
                  { data: null, render: function ( data, type, row ) {

                    var editUrl = "{{ url('/devadmin/detail/tagihan_wr/keseluruhan', 'url') }}";
                    editUrl = editUrl.replace('url', data['url']);

                return '<div class="text">\n\
                            <button class="btn btn-info btn-shadowed btn-icon popover-hover" id="btn_detail" a="'+ editUrl +'" data-placement="left" data-container="body" data-content="Detail Tagihan Keseluruhan"><span class="fa fa-eye"></span></button>\n\
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




    $(function() {
         // $("#aa").hide();
         $("#progress").hide();
        
        loaddata();
    });

</script>


<!-- END PAGE CONTAINER -->
@endsection