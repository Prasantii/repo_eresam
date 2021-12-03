@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li><a href="{{url('/devadmin/datapetugas')}}">Data Petugas</a></li>
        <li class="active">Detail Data Petugas</li>
    </ul>
</div>

<!-- END PAGE HEADING -->
@if(Session::has('success'))
    <script type="text/javascript">
        new Noty({
            text: '<strong>Success</strong> {{Session::get('success')}}',
            layout: 'topRight',
            type: 'success',
            theme: 'nest'
        }).setTimeout(4000).show();
    </script>
@endif
@if(Session::has('fail'))
    <script type="text/javascript">
        new Noty({
            text: '<strong>Fails</strong> {{Session::get('fail')}}',
            layout: 'topRight',
            type: 'warning',
            theme: 'nest'
        }).setTimeout(4000).show();
    </script>
@endif

<div class="container">
        <div class="app-tip app-tip-runing app-tip-noborder " style="background-color: #dbe0e4;">
            <div class="app-tip-runner app-tip-speed-slow"><b>SELAMAT DATANG DI APLIKASI E-RESAH - RETRIBUSI SAMPAH</b></div>
        </div>
    <div class="row">
        <div class="col-md-12">   
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="contact contact-rounded contact-bordered contact-lg margin-bottom-0">
                           <?php if($detail->image != ''){ ?>
                                <img src="{{ asset($detail->image) }}">
                            <?php }else{ ?>
                                <img src="{{ asset('avatar.png') }}">
                            <?php } ?>
                            <div class="contact-container">
                                <a href="#" style="text-transform: uppercase;color: black;"><b>{{$detail->nama}}</b></a>
                                <span>NIK : <b>{{$detail->nik}}</b></span>
                            </div>                                                
                        </div>                                        
                </div>
                <div class="panel-body">                                    
                    <div class="block-content row-table-holder">
                        <div class="row row-table">
                            <div class="col-md-3 col-xs-12">
                                <span class="text-bolder text-uppercase text-sm">Photo</span>
                                <p><?php if($detail->image != ''){ ?>
                                    <div class="parent-container"> 
                                        <a href="{{ asset($detail->image) }}"  title=" {{$detail->nama}} " detail-source="{{ asset($detail->image) }}">
                                        <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default parent-container" src="{{ asset($detail->image) }}" style="width: 250px;height: auto;"></a>
                                    </div>
                                <?php }else{ ?>
                                        <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset('halamanlogin/img/img-01.png') }}" style="width: 250px;height: auto;">
                                <?php } ?></p>
                            </div> 
                            <div class="col-md-4 col-xs-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th colspan="2" style="text-align: center;">DATA PRIBADI</th>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <th>{{$detail->nik}}</th>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <th>{{$detail->nama}}</th>
                                    </tr>
                                    <tr>
                                        <td>No. Hp</td>
                                        <th>{{$detail->hp}}</th>
                                    </tr>  
                                    <tr>
                                        <td>Alamat</td>
                                        <th>{{$detail->alamat}}</th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th colspan="2" style="text-align: center;">DATA AKUN APLIKASI</th>
                                    </tr>
                                    <tr>
                                        <td width="20%">Username</td>
                                        <th width="40%">{{$detail->username}}</th>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <th>{{$detail->email}}</th>
                                    </tr>
                                    <tr>
                                        <td>Verifikasi</td>
                                        <th><?php 
                                        if($detail->is_active != 1){
                                            $je = "<span class='label label-danger label-bordered label-ghost'><i class='icon-power-switch'></i> Data Belum Di Verifikasi</span>";
                                        }else{
                                            $je = "<button class='label label-info label-bordered label-ghost'><i class='fa fa-check'></i> Data Sudah Di Verifikasi</button>";
                                        }
                                        echo $je;
                                         ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Verifikasi Email</td>
                                        <th><?php if($detail->email_verify != 1){
                                            $el = "<span class='label label-danger label-bordered label-ghost'><i class='icon-power-switch'></i> Email Belum Di Verifikasi</span>";
                                        }else{
                                            $el = "<button class='label label-info label-bordered label-ghost'><i class='fa fa-check'></i> Email Sudah Di Verifikasi</button>";
                                        }
                                        echo $el;
                                         ?>
                                         </th>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-9 col-xs-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th colspan="4" style="text-align: center;">LOKASI TUGAS</th>
                                    </tr>
                                    <tr>
                                        <td width="20%">Koordinator</td>
                                        <th >{{$detail->namakoordinator}}</th>
                                        <td width="20%">Zona</td>
                                        <th>{{$detail->namazona}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="text-align: center;">DETAIL LOKASI</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Gampong</td>
                                        <td colspan="2" style="text-align: center;">Komersil</td>
                                    </tr>
                                    @foreach($lokasitugas as $zon)
                                    <tr>
                                        
                                        <th colspan="2">{{$zon->namagampong ? $zon->namagampong : '-' }}</th>
                                        <th colspan="2">Kec. {{$zon->namakec}}</th>
                                    </tr>
                                     @endforeach
                                </table>
                            </div>
                                                                
                        </div>
                        <div class="row row-table">
                            <div class="col-md-12 col-xs-12">
                            </div>                                           
                        </div>
                    

                    </div>                                         
                </div>
                <div class="panel-footer">   
                    <div class="panel-elements pull-right">
                        {{-- <button class="btn btn-primary pull-right"><span class="icon-earth"></span> Submit</button> --}}
                    </div>                                        
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#gambar-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#gambar-img").change(function(){
        readURL(this);
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
@endsection