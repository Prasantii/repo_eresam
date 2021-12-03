@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Cetak QRCODE Wajib Retribusi</li>
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

    <nav class="pull-right">
        {!! $wr->render() !!}
    </nav> <div>
        <button class="btn btn-success btn-shadowed" id="print"><span class="fa fa-qrcode"></span> Print Semua</button>
    </div>
       <br><br><br>
    <div class="row">
        @foreach($wr as $warr)
        <div class="col-lg-6 col-md-6 col-xs-12">                                
            <div class="block block-condensed padding-top-20" >
                <div class="row row-table" >
                    <div class="col-lg-6 col-md-6 col-xs-6">
                        <?php if($warr->qrcode != ''){ ?>
                            <div class="parent-container"> 
                                <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-success parent-container" src="{{ asset($warr->qrcode) }}" style="width: 200px;height: auto;">
                            </div>
                        <?php }else{ ?>
                                <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset('halamanlogin/img/img-01.png') }}" style="width: 200px;height: auto;">
                        <?php } ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6">
                        <div class="list-group">                                        
                            <div class="list-group-item"><span class="fa fa-user"></span> NAMA :  {{$warr->nama}}</div>
                            
                            <div class="list-group-item" style="font-size: 11px;"><span class="fa fa-map-marker"></span> ALAMAT : {{$warr->alamat.' - GAP.'.$warr->namevillages.' - KEC.'.$warr->namedistricts}}</div>     
                            <div class="list-group-item"><span class="fa fa-qrcode"></span> ID : {{$warr->code}}</div> 
                            <div class="list-group-item"><span class="fa fa-money"></span> Tarif Retribusi : <?php 
                                                                        if($warr->kota == 1){ 
                                                                            echo $warr->tarif_kota.$warr->luasjenis; 
                                                                        }elseif($warr->gampong == 1){ 
                                                                            echo $warr->tarif_gampong.$warr->luasjenis;  
                                                                        }else{
                                                                            echo "-";
                                                                        }?></div> 
                            <br>        
                            <div class="pull-right">
                                <button class="btn btn-info btn-shadowed">Print</button>
                            </div>                                                                                                                  
                        </div>  
                    </div> 
                </div>
            </div>                                
        </div>
        @endforeach
    </div> 
    <nav class="pull-right">
        {!! $wr->render() !!}
    </nav>  
</div>

<script type="text/javascript">
     $(document).on("mouseenter",".popover-hover",function(){             
            $(this).popover('show');
        }).on("mouseleave",".popover-hover",function(){
            $(this).popover('hide');
        });

        $('#print').on('click', function () {
            window.open('{{ url("/devadmin/cetak_qrcode/print") }}');
            // PopupCenter('', 'CETAK QRCODE WR' ,'1200', '800');
        });
</script>
@endsection