<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>CETAK QR CODE</title>
    <link rel="stylesheet" href="{{ asset('admins/css/stylessss.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
        <!-- IMPORTANT SCRIPTS -->
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jquery/jquery-migrate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/bootstrap/bootstrap.min.js') }}"></script>
        
        

        <style type="text/css">
            @media print {
                * {
                    -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
                    color-adjust: exact !important;  /*Firefox*/
                  }
                #ad{ display:none;}
                #leftbar{ display:none;}
                #contentarea{ width:100%;}
                .colorr{
                    color:#FFFFFF !important;
                }
            }
            .block{
                background-image: url('{{ asset('uploads/bgqrcodeedit.jpg') }}') !important;
                background-size: 595px 420px !important;
            }
            .list-group-item{
                background: #FFF !important;
                border-color: #DBE0E4 !important;
            }
            
        </style>
</head>

<body onload="window.print()">
<!--<body>-->
    <div class="app">
        <div class="app-container">
            <div class="container">
                <div class="row">
                    @foreach($wr as $warr)
                    <div class="col-lg-6 col-md-6 col-xs-12">                                
                        <div class="block block-condensed padding-top-20" style="width: 598px;height: 420px;background-image: url('{{ asset('uploads/bgqrcodeedit.jpg') }}');background-size: 595px 420px;">
                            <div class="row row-table" style="height: 400px;">
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                        <div class="parent-container"> 
                                            <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset('halamanlogin/img/img-01.png') }}" style="width: 270px;height: auto;margin-top: 34px;">
                                        </div>
                                            
                                 
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                    <div class="list-group" style="margin-top: 60px;font-size: 12px;">                                        
                                        <div class="list-group-item" style="text-transform: uppercase;"><span class="fa fa-user"></span> NAMA : {{$warr->nama}}</div>
                                        
                                        <div class="list-group-item"><span class="fa fa-map-marker"></span> ALAMAT : {{$warr->alamat.' - GAP.'.$warr->namevillages.' - KEC.'.$warr->namedistricts}}</div> 
                                        <div class="list-group-item"><span class="fa fa-qrcode"></span> ID : {{$warr->code}}</div> 
                                        <div class="list-group-item"><span class="fa fa-money"></span> Tarif Retribusi : <?php 
                                                                        if($warr->kota == 1){ 
                                                                            echo "Rp. ".$warr->tarif_kota.",-"; 
                                                                        }elseif($warr->gampong == 1){ 
                                                                            echo "Rp. ".$warr->tarif_gampong.",-"; ; 
                                                                        }elseif($warr->gampong == 0 && $warr->kota == 0){
                                                                            echo "-";
                                                                        }else{
                                                                            echo "-";
                                                                        }?></div> 
                                        
                                        
                                        <span class="colorr" style="color:#FFFFFF !important;font-size: 10px;"> Tarif Berdasarkan Qanun No.5 Tahun 2017 Tentang Retribusi Pelayanan Persampahan/Kebersihan </span><br>
                                        <span><img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-success parent-container" src="{{ asset($warr->qrcode) }}" style="float: right;width: 76px;height: auto;margin-top: -19px;margin-bottom: 16px;"></span> 
                                            
                                        
                                    </div>  
                                </div> 
                            </div>
                        </div>                                
                    </div>
                    @endforeach
                </div>  
            </div>
        </div>
    </div>
</body>
</html>