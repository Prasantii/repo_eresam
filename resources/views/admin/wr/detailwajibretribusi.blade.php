@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li><a href="{{url('/devadmin/wajib_retribusi')}}">Data Wajib Retribusi</a></li>
        <li class="active">Detail Data Wajib Retribusi</li>
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
                           <?php if($detail->photo != ''){ ?>
                                <img src="{{ asset($detail->photo) }}">
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
                                <p><?php if($detail->photo != ''){ ?>
                                    <div class="parent-container"> 
                                        <a href="{{ asset($detail->photo) }}"  title=" {{$detail->nama}} " data-source="{{ asset($detail->photo) }}">
                                        <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset($detail->photo) }}" style="width: 200px;height: auto;"></a>
                                    </div>
                                <?php }else{ ?>
                                        <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset('halamanlogin/img/img-01.png') }}" style="width: 200px;height: auto;">
                                <?php } ?></p>
                            </div> 
                            <div class="col-md-4 col-xs-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th colspan="2" style="text-align: center;">DATA DIRI</th>
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
                                        <td>Jenis Retribusi</td>
                                        <th>{{$je}}</th>
                                    </tr>
                                    <tr>
                                        <td>Tarif Retribusi</td>
                                        <th>{{$tarf}}</th>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-5 col-xs-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th colspan="2" style="text-align: center;">LOKASI</th>
                                    </tr>
                                    <tr>
                                        <td>Zona</td>
                                        <th>{{$zonama}}</th>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <th>{{$detail->namedistricts}}</th>
                                    </tr>
                                    <tr>
                                        <td>Gampong</td>
                                        <th>{{$detail->namevillages}}</th>
                                    </tr>
                                    <tr>
                                        <td>Alamat Lengkap</td>
                                        <th>{{$detail->alamat.' - KEC.'.$detail->namedistricts.' - GAP.'.$detail->namevillages}}</th>
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
                        </div>
                        <div class="row row-table">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                
                                <table class="table table-striped">
                                    <tr>
                                        <th align="center">KODE : {{$detail->code}}</th>
                                    </tr>
                                    <tr>
                                        <td align="center"> 
                                            <div class="parent-container"> 
                                                <a href="{{ asset($detail->qrcode) }}"  title=" {{$detail->nama}} " data-source="{{ asset($detail->qrcode) }}" >
                                                <img src="{{ asset($detail->qrcode) }}" width="150px" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default parent-container" style="width: 250px;height: auto;"></a> 
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                
                                <table class="table table-striped">
                                    <tr>
                                        <th align="center">KTP : {{$detail->nik}}</th>
                                    </tr>
                                    <tr>
                                        <td align="center"> 
                                            <div class="parent-container"> 
                                                <a href="{{ asset($detail->ktp) }}"  title=" {{$detail->nama}} " data-source="{{ asset($detail->ktp) }}" >
                                                <img src="{{ asset($detail->ktp) }}" width="150px" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default parent-container" style="width: 250px;height: auto;"></a> 
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tr>
                                        <th align="center" colspan="3">Photo Rumah</th>
                                    </tr>
                                    <tr>
                                        <td> 
                                            <div class="parent-container"> 
                                            <?php if($photo_rumah->image != ''){ ?>
                                                <a href="{{ asset($photo_rumah->image) }}"  title=" {{$detail->nama}} " data-source="{{ asset($photo_rumah->image) }}">
                                                <img src="{{ asset($photo_rumah->image) }}" width="150px" class="thumbnail" ></a> 
                                            <?php }else{ ?>
                                                 <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset('halamanlogin/img/img-01.png') }}" style="width: 250px;height: auto;">
                                            <?php } ?>
                                            </div>
                                        </td>
                                        <td> 
                                            <div class="parent-container"> 
                                            <?php if($photo_rumah->imagedua != ''){ ?>
                                                <a href="{{ asset($photo_rumah->imagedua) }}"  title=" {{$detail->nama}} " data-source="{{ asset($photo_rumah->imagedua) }}">
                                                    <img src="{{ asset($photo_rumah->imagedua) }}" width="150px" class="thumbnail" ></a> 
                                            <?php }else{ ?>
                                                 <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset('halamanlogin/img/img-01.png') }}" style="width: 250px;height: auto;">
                                            <?php } ?>
                                            </div>
                                        </td>
                                        <td> 
                                            <div class="parent-container"> 
                                            <?php if($photo_rumah->imagetiga != ''){ ?>
                                                <a href="{{ asset($photo_rumah->imagetiga) }}"  title=" {{$detail->nama}} " data-source="{{ asset($photo_rumah->imagetiga) }}">
                                                    <img src="{{ asset($photo_rumah->imagetiga) }}" width="150px" class="thumbnail" ></a> 
                                                <?php }else{ ?>
                                                     <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset('halamanlogin/img/img-01.png') }}" style="width: 250px;height: auto;">
                                                <?php } ?>
                                            </div> 
                                        </td>
                                    </tr>
                                </table>
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