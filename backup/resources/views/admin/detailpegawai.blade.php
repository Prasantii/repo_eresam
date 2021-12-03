@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">My Profile</li>
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
            <div class="app-tip-runner app-tip-speed-slow"><b>SELAMAT DATANG DI APLIKASI SIMAUN - Sistem Manajemen ASN Untuk Nanggroe</b></div>
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
                                <span>NIP : <b>{{$detail->nip_baru}}</b></span>
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
                                        <a href="{{ asset($detail->image) }}"  title=" {{$detail->name}} " detail-source="{{ asset($detail->image) }}">
                                        <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default parent-container" src="{{ asset($detail->image) }}" style="width: 250px;height: auto;"></a>
                                    </div>
                                <?php }else{ ?>
                                        <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-warning parent-container" src="{{ asset('halamanlogin/img/img-02.png') }}" style="width: 250px;height: auto;">
                                <?php } ?></p>
                            </div> 
                            <div class="col-md-4 col-xs-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th colspan="2" style="text-align: center;">DATA PRIBADI</th>
                                    </tr>
                                    <tr>
                                        <td width="20%">NIP Lama</td>
                                        <th width="40%">{{$detail->nip_lama}}</th>
                                    </tr>
                                    <tr>
                                        <td>NIP Baru</td>
                                        <th>{{$detail->nip_baru}}</th>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <th>{{$detail->nama}}</th>
                                    </tr>
                                    <tr>
                                        <td>Tempat / Tanggal Lahir</td>
                                        <th>{{$detail->tempat_lahir}} / {{$detail->tgl_lahir}}</th>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <th>{{$detail->alamat}}</th>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <th>{{$detail->jenis_kelamin}}</th>
                                    </tr>
                                    <tr>
                                        <td>Agama</td>
                                        <th>{{$detail->agama}}</th>
                                    </tr>
                                    <tr>
                                        <td>No. Hp</td>
                                        <th>{{$detail->no_hp}}</th>
                                    </tr>
                                    <tr>
                                        <td>Pendidikan</td>
                                        <th>{{$detail->pendidikan}}</th>
                                    </tr>   
                                </table>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th colspan="2" style="text-align: center;">DATA KERJA</th>
                                    </tr>
                                    <tr>
                                        <td width="20%">Eselon</td>
                                        <th width="40%">{{$detail->esolon}}</th>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <th>{{$detail->jabatan}}</th>
                                    </tr>
                                    <tr>
                                        <td>Tempat Tugas</td>
                                        <th>{{$detail->tempat_tugas}}</th>
                                    </tr>

                                    <tr>
                                        <td>Golongan</td>
                                        <th>{{$detail->gol}}</th>
                                    </tr>
                                    <tr>
                                        <td>Pangkat</td>
                                        <th>{{$detail->pangkat}}</th>
                                    </tr>
                                    <tr>
                                        <td>Unit Kerja</td>
                                        <th>{{$detail->uker}}</th>
                                    </tr>
                                    <tr>
                                        <td>NPWP</td>
                                        <th>{{$detail->npwp}}</th>
                                    </tr>
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