@extends('admin.home')
@section('content')
    <!-- START PAGE HEADING -->

    <div class="app-heading-container app-heading-bordered bottom">
        <ul class="breadcrumb">
            <li><a href="#">Aplikasi</a></li>
            <li><a href="{{url('/devadmin/wajib_retribusi')}}">Data Wajib Retribusi</a></li>
            <li class="active">Edit Wajib Retribusi - (<u>{{$wajib_retribusi->nama}}</u>)</li>
        </ul>
    </div>

    @if(Session::has('success'))
        <script type="text/javascript">
            new Noty({
                text: '<strong>Success</strong> {{Session::get('success')}}',
                layout: 'topRight',
                type: 'success'
            }).setTimeout(4000).show();
        </script>
    @endif

    @if(Session::has('fail'))
        <script type="text/javascript">
            new Noty({
                text: '<strong>Fails</strong> {{Session::get('fail')}}',
                layout: 'topRight',
                type: 'error'
            }).setTimeout(4000).show();
        </script>
    @endif

    <!-- END PAGE HEADING -->

    <!-- START PAGE CONTAINER -->
    <div class="container">
        <div class="block block-condensed">
            <div class="app-heading app-heading-small">
                <div class="title">
                    <h2>Edit Data Wajib Retribusi - (<u>{{$wajib_retribusi->nama}}</u>) </h2>
                    <p>Manajement Data Wajib Retribusi</p>
                </div>
            </div>
            <div class="block-content">
                <form method="post" enctype="multipart/form-data" action="{{ url('/devadmin/editwajib_retribusiaksi',encrypt($wajib_retribusi->id)) }}">
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <td>NIK</td>
                                <th id="no_prov_input">
                                    <input type="text" class="form-control" id="nik" name="nik" value="{{ $wajib_retribusi->nik }}">
                                    @if ($errors->first('nik'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="nik">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <th id="no_ruas_input">
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $wajib_retribusi->nama }}">
                                    @if ($errors->first('nama'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="nama">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>No Hp</td>
                                <th id="nama_ruas_input">
                                    <input type="text" class="form-control" id="hp" name="hp" value="{{ $wajib_retribusi->hp }}">
                                    @if ($errors->first('hp'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="hp">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Kabutpaten/Kota</td>
                                <th id="regency_id">
                                    <select id="dep_reg" name="regency_id" class="form-control bs-select" data-live-search="true" style="width: 100%">
                                    </select>
                                    <span id="dep_reg_c" style="margin-top: 10px;display: none; ">
                                        <div class="app-spinner snake"></div>
                                    </span>

                                    @if ($errors->first('regency_id'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="regency_id">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <th id="district_id">
                                    <select id="dep_dist" name="district_id" class="form-control bs-select" data-live-search="true" style="width: 100%">
                                    </select>
                                    <span id="dep_dist_c" style="margin-top: 10px;display: none; ">
                                        <div class="app-spinner snake"></div>
                                    </span>
                                    @if ($errors->first('district_id'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="district_id">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                               <td>Gampong</td> 
                               <th id="villages_id">
                                    <select id="dep_vill" name="villages_id" class="form-control bs-select" data-live-search="true" style="width: 100%">
                                    </select>
                                    <span id="dep_vill_c" style="margin-top: 10px;display: none; ">
                                        <div class="app-spinner snake"></div>
                                    </span>
                                    @if ($errors->first('villages_id'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="regency_id">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Alamat Lengkap</td>
                                <th>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $wajib_retribusi->alamat }}">
                                    @if ($errors->first('alamat'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="alamat">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                        </table>
                        <h3>Jenis Objek Retribusi</h3>
                        <table class="table table-bordered" width="100%">
                            <thead>
                            <tr>
                                <th width="30%">Jenis Objek Retribusi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                               <th id="jenis_id">
                                    <select id="jenis_id" name="jenis_id" class="bs-select" data-live-search="true" style="width: 100%">
                                        @foreach($jenis as $men)
                                            <option value="{{ $men->id }}" {{ $men->id == $wajib_retribusi->jenis_id ? 'selected' : '' }}>{{ $men->nama }} - Luas: {{ $men->luas }} - Tarif Kota:{{ $men->tarif_kota }} - Tarif Gampong:{{ $men->tarif_gampong }}</option>
                                          @endforeach
                                    </select>
                                    @if ($errors->first('jenis_id'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="jenis_id">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                                @if ($errors->first('kota'))
                                <label  class="error label label-warning label-bordered label-ghost" for="jenis_id">Pilih Kota Atau Gampong.</label> <br>
                                @endif
                                <div class="app-radio success inline"> 
                                    <label><input type="radio" name="kota" value="kota" {{ $wajib_retribusi->kota == 1 ? 'checked=checked' : '' }}> Kota(Komersil)?<span></span></label> 
                                </div> 
                                <div class="app-radio success inline"> 
                                    <label><input type="radio" name="kota" value="gampong" {{ $wajib_retribusi->gampong == 1 ? 'checked=checked' : '' }}> Gampong?<span></span></label> 
                                </div> 
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h3>Akun Aplikasi</h3>
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <td>Username</td>
                                <th id="nama_jembatan_input">
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $wajib_retribusi->username }}">
                                    @if ($errors->first('username'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="username">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <th id="status_input">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $wajib_retribusi->email }}">
                                    @if ($errors->first('email'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="email">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                        </table>
                        
                    </div>
                    <div class="col-md-12">
                        <h3>Photo Diri & KTP</h3>
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <td>
                                   <div class="block">  
                                        <div class="app-heading app-heading-small">                                
                                            <div class="title">
                                                <h2>Photo</h2>
                                            </div>                                
                                        </div>
                                        
                                        <input type="file" id="photo-img" name="photo" class="form-control"  placeholder="Nama photo" class="dropzone"> <br>

                                        @if ($errors->first('photo'))
                                        <label  class="error label label-warning label-bordered label-ghost" for="alamat">Kolom ini diperlukan.</label>
                                        @endif
                                      <br>
                                    <?php if($wajib_retribusi->photo != ''){ ?>
                                        <img id="photo-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset($wajib_retribusi->photo) }}" width="100x">
                                    <?php }else{ ?>
                                        <img id="photo-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">
                                    <?php } ?>
                                    </div>
                                </td>
                                <td>
                                   <div class="block">  
                                        <div class="app-heading app-heading-small">                                
                                            <div class="title">
                                                <h2>Photo KTP</h2>
                                            </div>                                
                                        </div>
                                        <label  class="error label label-danger label-bordered label-ghost" for="alamat">Maximal Ukuran Gambar 2mb</label>
                                        <input type="file" id="ktp-img" name="ktp" class="form-control"  placeholder="Nama ktp" class="dropzone"> <br>

                                        @if ($errors->first('ktp'))
                                        <label  class="error label label-warning label-bordered label-ghost" for="alamat">Kolom ini diperlukan.</label>
                                        @endif
                                      <br>
                                        <?php if($wajib_retribusi->ktp != ''){ ?>
                                            <img id="ktp-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset($wajib_retribusi->ktp) }}" width="100x">
                                        <?php }else{ ?>
                                            <img id="ktp-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">
                                        <?php } ?>
                                    </div> 
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                    <div class="col-md-12">
                        <h3>Photo Rumah</h3>
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <td>
                                   <div class="block">  
                                        <div class="app-heading app-heading-small">                                
                                            <div class="title">
                                                <h2>Photo 1</h2>
                                            </div>                                
                                        </div>
                                        
                                        <input type="file" id="image-img" name="image" class="form-control"  placeholder="Nama image" class="dropzone"> <br>

                                        @if ($errors->first('image'))
                                        <label  class="error label label-warning label-bordered label-ghost" for="alamat">Kolom ini diperlukan.</label>
                                        @endif
                                      <br>
                                        <?php if($photo_rumah->image != ''){ ?>
                                                <img id="image-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset($photo_rumah->image) }}" width="100x">
                                        <?php }else{ ?>

                                            <img id="image-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">

                                        <?php } ?>
                                    </div> 
                                </td>
                                <td>
                                   <div class="block">  
                                        <div class="app-heading app-heading-small">                                
                                            <div class="title">
                                                <h2>Photo 2</h2>
                                            </div>                                
                                        </div>
                                        
                                        <input type="file" id="image2-img" name="image2" class="form-control"  placeholder="Nama image2" class="dropzone"> <br>

                                        @if ($errors->first('image2'))
                                        <label  class="error label label-warning label-bordered label-ghost" for="alamat">Kolom ini diperlukan.</label>
                                        @endif
                                      <br>
                                        <?php if($photo_rumah->imagedua != ''){ ?>
                                                <img id="image2-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset($photo_rumah->imagedua) }}" width="100x">
                                        <?php }else{ ?>

                                            <img id="image2-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">

                                        <?php } ?>
                                    </div> 
                                </td>
                                <td>
                                   <div class="block">  
                                        <div class="app-heading app-heading-small">                                
                                            <div class="title">
                                                <h2>Photo 3</h2>
                                            </div>                                
                                        </div>
                                        
                                        <input type="file" id="image3-img" name="image3" class="form-control"  placeholder="Nama image3" class="dropzone"> <br>

                                        @if ($errors->first('image3'))
                                        <label  class="error label label-warning label-bordered label-ghost" for="alamat">Kolom ini diperlukan.</label>
                                        @endif
                                      <br>
                                        <?php if($photo_rumah->imagetiga != ''){ ?>
                                                <img id="image3-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset($photo_rumah->imagetiga) }}" width="100x">
                                        <?php }else{ ?>

                                            <img id="image3-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">

                                        <?php } ?>
                                    </div> 
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                </div>
                

                <div class="progress active" style="display: none">
                    <div class="progress-bar progress-bar-danger progress-bar-striped" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                </div>

                <div class="block-divider dir-left"><span class="fa fa-angle-down"></span></div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info"  ><span class="fa fa-save"></span> Simpan</button>
                        <a href="{{ url('/devadmin/wajib_retribusi') }}"><button type="button" class="btn btn-danger"  ><span class="fa fa-remove"></span> Batal</button></a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER -->

<script type="text/javascript">

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#photo-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#image-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#image2-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#image3-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL5(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            if(input.files[0].size > 2000000){
               new Noty({
                    text: '<strong>Fails</strong> Ukuran Gambar Terlalu Besar. <b>Maximal Ukuran 2MB</b>',
                    layout: 'topRight',
                    type: 'error'
                }).setTimeout(4000).show();
               input.value = "";
            }else{
                reader.onload = function (e) {
                    $('#ktp-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    $("#ktp-img").change(function(){
        readURL5(this);
    });

    $("#photo-img").change(function(){
        readURL(this);
    });

    $("#image-img").change(function(){
        readURL2(this);
    });

    $("#image2-img").change(function(){
        readURL3(this);
    });

    $("#image3-img").change(function(){
        readURL4(this);
    });


    $(function () {
        
        get_reg();
        get_dist();
        //Reg
        function get_reg(a = 11) {
            $.ajax({
                type: "POST",
                url: "{{url('/get_reg')}}",
                data:({a:a, _token:'{{csrf_token()}}'}),
                dataType: "JSON",
                beforeSend: function () {
                    $('#dep_reg_c').show();
                },
                complete: function () {
                    $('#dep_reg_c').fadeOut(1000);
                },
                success: function (result) {
                    if (result['status'] == 'SUCCESS')
                    {
                        var reg_data = result['data'];
                        // $('#dep_reg').html('').selectpicker("refresh");
                        // $('#dep_reg').append('<option value="" id="hidess">Pilih Kabupaten/Kota</option>');
                        // $('#dep_reg').selectpicker("refresh");
                        $.each(reg_data, function (index) {
                            $('#dep_reg').append('<option value="'+reg_data[index].a+'">'+reg_data[index].b+'</option>');
                            $('#dep_reg').selectpicker("refresh");
                        });

                    }
                }
            });
        }

        $('#dep_reg').on("change", function(e){
            $('#dep_dist').val('');

            var a = $('#dep_reg').val();
            get_dist(a);
        });


        //Dist1
        function get_dist(a = <?php echo $wajib_retribusi->regency_id ?>, b = <?php echo $wajib_retribusi->district_id ?> ) {
            $.ajax({
                type: "POST",
                url: "{{url('/get_dist_edit')}}",
                data:({a:a,b:b, _token:'{{csrf_token()}}'}),
                dataType: "JSON",
                beforeSend: function () {
                    $('#dep_dist_c').show();
                },
                complete: function () {
                    $('#dep_dist_c').fadeOut(1000);
                },
                success: function (result) {
                    if (result['status'] == 'SUCCESS')
                    {
                        var dist_data = result['data'];
                        // $('#dep_dist').html('');

                        $('#dep_dist').html('').selectpicker("refresh");
                        $('#dep_dist').append('<option value="" id="hidessasasd">Pilih Kecamatan</option>');
                        $.each(dist_data, function (index) {
                            var aa = dist_data[index].a;
                            var aaa = dist_data[index].aa;
                            if(aa = aaa){
                                var sell = "selected";
                            }
                            $('#dep_dist').append('<option value="'+dist_data[index].a+'" '+sell+'>'+dist_data[index].b+'</option>');
                            $('#dep_dist').selectpicker("refresh");
                        });

                        if(b != null)
                        {
                            $('#dep_dist').val(b).trigger('change');
                            $('#dep_dist').selectpicker("refresh");
                        }


                    }else if (result['status'] == 'FAILED')
                    {
                        // $('#dep_dist').html('');
                        $('#dep_dist').html('').selectpicker("refresh");
                        $('#dep_dist').append('<option value="" id="hidessasasd">Pilih Kecamatan</option>');
                        $('#dep_dist').selectpicker("refresh");
                    }
                }
            });
        }

        $('#dep_dist').on("change", function(e){
            $('#dep_vill').val('');

            var aa = $('#dep_dist').val();
            get_vill(aa);
        });
        


        function get_vill(aa, a = <?php echo $wajib_retribusi->district_id ?>,b = <?php echo $wajib_retribusi->villages_id ?>) {
            $.ajax({
                type: "POST",
                url: "{{url('/get_vill_edit')}}",
                data:({aa:aa,a:a,b:b, _token:'{{csrf_token()}}'}),
                dataType: "JSON",
                beforeSend: function () {
                    $('#dep_vill_c').show();
                },
                complete: function () {
                    $('#dep_vill_c').fadeOut(1000);
                },
                success: function (result) {
                    if (result['status'] == 'SUCCESS')
                    {
                        var dist_data = result['data'];
                        // $('#dep_vill').html('');
                        $('#dep_vill').html('').selectpicker("refresh");
                        $.each(dist_data, function (index) {
                            var aa = dist_data[index].a;
                            var aaa = dist_data[index].aa;
                            if(aa = aaa){
                                var sell = "selected";
                            }
                            $('#dep_vill').append('<option value="'+dist_data[index].a+'" '+sell+'>'+dist_data[index].b+'</option>');
                            $('#dep_vill').selectpicker("refresh");
                        });

                        if(b != null)
                        {
                            $('#dep_vill').val(b).trigger('change');
                            $('#dep_vill').selectpicker("refresh");
                        }


                    }else if (result['status'] == 'FAILED')
                    {
                        // $('#dep_vill').html('');
                        $('#dep_vill').html('').selectpicker("refresh");
                        $('#dep_vill').append('<option value="" id="hidessasasd">Pilih Gampong</option>');
                        $('#dep_vill').selectpicker("refresh");
                    }
                }
            });
        }

        


        $('#dep_dist').append('<option value="" id="hidessasasd">Pilih Kecamatan</option>');
        $('#dep_dist').selectpicker("refresh");

        $('#dep_vill').append('<option value="" id="hidessasasd">Pilih Gampong</option>');
        $('#dep_vill').selectpicker("refresh");

        $('#hidess').hide();
        $('#hidessas').hide();
        $('#hidessasasd').hide();

    });
     

</script>

@endsection