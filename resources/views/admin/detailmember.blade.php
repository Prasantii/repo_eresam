@extends('admin.home')
@section('content')
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li><a href="{{url('/devadmin/member')}}">Halaman member</a></li>
        <li class="active">Detail member</li>
    </ul>
</div>

<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="row" id="atas">
        <div class="col-lg-12 col-md-12">
            <!-- BLOCK -->
            <div class="block block-condensed">
                <div class="app-heading app-heading-small">
                    <div class="title">
                        <h2>Detail Member</h2>

                    </div>
                    <a href="{{ url('/devadmin/member') }}"><button type="button" class="btn btn-warning btn-shadowed pull-right"><span class="fa fa-arrow-left"></span>  Kembali</button></a>
                    {{-- <div id="spinner" class="app-spinner loading loading-danger pull-right" style="display: none;"></div> --}}
                </div>
                <div class="col-md-6">
                    <table class="table table-striped">
                        <tr>
                            <td width="20%">Id Member</td>
                            <th width="40%">
                            {{ $member->id_member }}
                            </th>
                        </tr>
                        
                        <tr>
                            <td>Nama Lengkap</td>
                            <th>
                            {{ $member->nama }}
                            </th>
                        </tr>

                        <tr>
                            <td>Username</td>
                            <th>
                            {{ $member->username }}
                            </th>
                        </tr>
                        <tr>
                            <td>No Handphone</td>
                            <th>
                            {{ $member->hp }}
                            </th>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <th>
                            {{ $member->alamat }}
                            </th>
                        </tr>
                        
                    </table>
                </div>
                <br>
                <br>
                <br>
                <div class="app-content-tabs">
                    <ul>
                        <li><a href="#tab-detail" class="active"><span class="icon-file-empty"></span> Booking Request</a></li>
                        <li><a href="#tab-graph"><span class="icon-thumbs-up"></span> Booking Approved</a></li>
                        <li><a href="#tab-map"><span class="icon-cross"></span> Booking Canceled</a></li>
                        {{-- <li><a href="#tab-history"><span class="icon-history"></span> Riwayat</a></li>
                        <li><a href="#tab-demage"><span class="icon-construction"></span> Daftar Kerusakan</a></li> --}}
                    </ul>
                </div>
                <div id="tab-detail" class="row app-content-tab active">                            
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b><span class="icon-file-empty"> Booking Request</b></h3>
                                {{-- <div class="panel-elements pull-right" style="margin-left:10px; ">
                                    <a href="{{url('/devadmin/tambahbooking')}}"><button class="btn btn-default" type="button"><span class="fa fa-edit"></span> Booking</button></a>
                                </div> --}}

                            </div>
                            <div class="panel-body">      
                                <div class="block-content"  style="overflow-y: auto;width: 100%;">
                                    
                                <div  id="aa">
                                    <table id="logokon" class="table table-striped table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Id Booking</th>
                                                <th>Nama Team</th>
                                                <th width="20%">Lapangan</th>
                                                <th>Tgl</th>
                                                <th>Durasi</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                                
                                            </tr>
                                        </thead>  
                                        <tfoot>
                                            <tr>
                                                <th>NO</th>
                                                <th>Id Booking</th>
                                                <th>Nama Team</th>
                                                <th>Lapangan</th>
                                                <th>Tgl</th>
                                                <th>Durasi</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
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

                <div id="tab-graph" class="row app-content-tab">                            
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b><span class="icon-thumbs-up"> Booking Approved</b></h3>
                                {{-- <div class="panel-elements pull-right" style="margin-left:10px; ">
                                    <a href="{{url('/devadmin/tambahbooking')}}"><button class="btn btn-default" type="button"><span class="fa fa-edit"></span> Booking</button></a>
                                </div> --}}

                            </div>
                            <div class="panel-body">      
                                <div class="block-content"  style="overflow-y: auto;width: 100%;">
                                    
                                <div  id="aa">
                                    <table id="bookingterima" class="table table-striped table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Id Booking</th>
                                                <th>Nama Team</th>
                                                <th width="20%">Lapangan</th>
                                                <th>Tgl</th>
                                                <th>Durasi</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                                
                                            </tr>
                                        </thead>  
                                        <tfoot>
                                            <tr>
                                                <th>NO</th>
                                                <th>Id Booking</th>
                                                <th>Nama Team</th>
                                                <th>Lapangan</th>
                                                <th>Tgl</th>
                                                <th>Durasi</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
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

                <div id="tab-map" class="row app-content-tab">                            
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b><span class="icon-cross"></span> Booking Canceled</b></h3>
                                {{-- <div class="panel-elements pull-right" style="margin-left:10px; ">
                                    <a href="{{url('/devadmin/tambahbooking')}}"><button class="btn btn-default" type="button"><span class="fa fa-edit"></span> Booking</button></a>
                                </div> --}}

                            </div>
                            <div class="panel-body">      
                                <div class="block-content"  style="overflow-y: auto;">
                                    
                                <div  id="aa">
                                    <table id="bookinggagal" class="table table-striped table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Id Booking</th>
                                                <th>Nama Team</th>
                                                <th width="20%">Lapangan</th>
                                                <th>Tgl</th>
                                                <th>Durasi</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                                
                                            </tr>
                                        </thead>  
                                        <tfoot>
                                            <tr>
                                                <th>NO</th>
                                                <th>Id Booking</th>
                                                <th>Nama Team</th>
                                                <th>Lapangan</th>
                                                <th>Tgl</th>
                                                <th>Durasi</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
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
        </div>
    </div>
</div>

<script type="text/javascript">

    var atas = $('#atas'),
    spinner = $('#spinner'),
    tableBlock = $('#table-block');


    function goToTop() {
            $('html,body').animate({
                scrollTop: 0
            }, 1500);
        }

        function goToTable() {
            $('html,body').animate({
                scrollTop: 820
            }, 1500);
        }

    $('#des').on('click', function () {

            spinner.show();
            setTimeout(function () {
                tableBlock.fadeIn(500);
                goToTable();
                spinner.fadeOut(500);
            }, 1000);
            return false; 
        });

    $('#table-close').on('click', function () {
            goToTop();
            tableBlock.fadeOut(2000);
        });


    $('.parent-container').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function(item) {
                return item.el.attr('title') + '&middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">Detail Gambar</a>';
            }
        },
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function(element) {
                return element.find('img');
            }
        }

    });
</script>

<script type="text/javascript">

     $(document).on("mouseenter",".popover-hover",function(){             
            $(this).popover('show');
        }).on("mouseleave",".popover-hover",function(){
            $(this).popover('hide');
        });
    var table;

    function close(){
        table.destroy();
        loaddata();

        $("#aa").hide();
        // $("#bb").hide();
    }

    

    function loaddata(){
       table = $('#logokon').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_booking')}}" +"/<?php $id_member = $member->id_member;echo $id_member;?>/1",
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
                  { data:   'id_booking' },
                  { data:   'namateam' },
                  { data:   'lapangan' },
                  { data:   'tgl' },
                  { data:   'jam' },
                  { data:   'status' },
                  { data:   'total' },
                  { data: null, render: function ( data, type, row ) {
                return '<div class="text">\n\
                            <a href="{{url("/devadmin/detailbooking")}}/'+data['id']+' "><button class="btn btn-default popover-hover" a="'+data['id']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Detail"><i class="fa fa-eye"></i> </button></a>\n\
                        </div>';
            } }
                 
                 
            ],

            drawCallback : function() {
               processInfo(this.api().page.info());
           }
      
        });
    }

    function loaddataterima(){
       table = $('#bookingterima').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_booking')}}" +"/<?php $id_member = $member->id_member;echo $id_member;?>/3",
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
                  { data:   'id_booking' },
                  { data:   'namateam' },
                  { data:   'lapangan' },
                  { data:   'tgl' },
                  { data:   'jam' },
                  { data:   'status' },
                  { data:   'total' },
                  { data: null, render: function ( data, type, row ) {
                return '<div class="text">\n\
                            <a href="{{url("/devadmin/detailbooking")}}/'+data['id']+' "><button class="btn btn-default popover-hover" a="'+data['id']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Detail"><i class="fa fa-eye"></i> </button></a>\n\
                        </div>';
            } }
                 
                 
            ],

            drawCallback : function() {
               processInfo(this.api().page.info());
           }
      
        });
    }

    function loaddatagagal(){
       table = $('#bookinggagal').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/devadmin/data_booking')}}" +"/<?php $id_member = $member->id_member;echo $id_member;?>/4",
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
                  { data:   'id_booking' },
                  { data:   'namateam' },
                  { data:   'lapangan' },
                  { data:   'tgl' },
                  { data:   'jam' },
                  { data:   'status' },
                  { data:   'total' },
                  { data: null, render: function ( data, type, row ) {
                return '<div class="text">\n\
                            <a href="{{url("/devadmin/detailbooking")}}/'+data['id']+' "><button class="btn btn-default popover-hover" a="'+data['id']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Detail"><i class="fa fa-eye"></i> </button></a>\n\
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

    $(function() {
         // $("#aa").hide();
         // $("#bb").hide();

        
        loaddata();
        loaddataterima();
        loaddatagagal();


        $(document).on('click', '.delete_btn', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                theme: 'nest',
                text: 'Apakah Data Lapangan <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/devadmin/deletelapangan') }}',
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

@endsection