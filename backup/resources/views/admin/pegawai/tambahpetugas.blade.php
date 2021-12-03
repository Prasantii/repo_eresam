@extends('admin.home')
@section('content')
    <!-- START PAGE HEADING -->

    <div class="app-heading-container app-heading-bordered bottom">
        <ul class="breadcrumb">
            <li><a href="#">Aplikasi</a></li>
            <li><a href="{{url('/devadmin/datapetugas')}}">Data Petugas</a></li>
            <li class="active">Tambah Petugas</li>
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
                    <h2>TAMBAH PETUGAS</h2>
                    <p>Manajement Data Petugas</p>
                </div>
            </div>
            <div class="block-content">
                <form method="post" enctype="multipart/form-data" action="{{ URL::Route('Tambahpetugas') }}">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered" width="100%">
                            
                            <tr>
                                <td>NIK</td>
                                <th id="no_prov_input">
                                    <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}">
                                    @if ($errors->first('nik'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="nik">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Nama Petugas</td>
                                <th id="no_ruas_input">
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                                    @if ($errors->first('nama'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="nama">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>No Hp</td>
                                <th id="nama_ruas_input">
                                    <input type="text" class="form-control" id="hp" name="hp" value="{{ old('hp') }}">
                                    @if ($errors->first('hp'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="hp">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <th id="nama_ruas_input" colspan="2">
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Lengkap">
                                    @if ($errors->first('alamat'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="alamat">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                        </table>
                        
                        <h3>Lokasi Tugas</h3>
                        <table class="table table-bordered" width="100%">
                            <thead>
                            <tr>
                                <th width="30%">Zona - Koordinator</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                
                                <th id="no_jembatan_input">
                                    {{ csrf_field() }}
                                    <select id="id_koordinator" name="id_koordinator" class="form-control bs-select" data-live-search="true" >
                                       
                                    </select>
                                    <span id="id_koordinator_c" style="margin-top: 10px;display: none; ">
                                        <div class="app-spinner snake"></div>
                                    </span>
                                    @if ($errors->first('id_koordinator'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="id_koordinator">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th width="30%">KECAMATAN</th>
                            </tr>
                            <tr>
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
                                <th width="30%">GAMPONG</th>
                            </tr>
                            <tr>
                               <th id="villages_id">
                                    <select id="dep_vill" name="villages_id[]" class="form-control bs-select" multiple  data-live-search="true" style="width: 100%">
                                    </select>
                                    <span id="dep_vill_c" style="margin-top: 10px;display: none; ">
                                        <div class="app-spinner snake"></div>
                                    </span>
                                    @if ($errors->first('villages_id'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="regency_id">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        <div class="app-checkbox success inline"> 
                            <label><input type="checkbox" name="is_active" value="1" checked="checked"> Active Akun?<span></span></label> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        

                        <h3>Akun Aplikasi</h3>
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <td>Username</td>
                                <th id="nama_jembatan_input">
                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
                                    @if ($errors->first('username'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="username">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <th id="status_input">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                    @if ($errors->first('email'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="email">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <th id="fungsi_input">
                                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                                    @if ($errors->first('password'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="password">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Konfirmasi Password</td>
                                <th id="cadin_input">
                                    <input type="password" class="form-control" id="password2" name="password2" value="{{ old('password2') }}">
                                    @if ($errors->first('password2'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="password2">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                        </table>
                        <div class="block">  
                            <div class="app-heading app-heading-small">                                
                                <div class="title">
                                    <h2>Photo</h2>
                                </div>                                
                            </div>
                            
                            <input type="file" id="gambar-img" name="image" class="form-control"  placeholder="Nama gambar" class="dropzone"> <br>

                            @if ($errors->first('image'))
                            <label  class="error label label-warning label-bordered label-ghost" for="alamat">Kolom ini diperlukan.</label>
                            @endif
                          <br>
                            <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">
                        </div>
                        
                        
                    </div>
                </div>

                <div class="progress active" style="display: none">
                    <div class="progress-bar progress-bar-danger progress-bar-striped" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                </div>

                <div class="block-divider dir-left"><span class="fa fa-angle-down"></span></div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info"  ><span class="fa fa-save"></span> Simpan</button>
                        <a href="{{ url('/devadmin/datapetugas') }}"><button type="button" class="btn btn-danger"  ><span class="fa fa-remove"></span> Batal</button>
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
                $('#gambar-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }

        $("#gambar-img").change(function(){
            readURL(this);
        });
    }

    $(function () {
        
        get_koordinator();
        //Reg
        function get_koordinator() {
            $.ajax({
                type: "POST",
                url: "{{url('/get_koordinator')}}",
                data:({_token:'{{csrf_token()}}'}),
                dataType: "JSON",
                beforeSend: function () {
                    $('#id_koordinator_c').show();
                },
                complete: function () {
                    $('#id_koordinator_c').fadeOut(1000);
                },
                success: function (result) {
                    if (result['status'] == 'SUCCESS')
                    {
                        var reg_data = result['data'];
                        // $('#get_koordinator').html('').selectpicker("refresh");
                        $('#id_koordinator').append('<option value="" id="hidess">Pilih Zona - Koordinator</option>');
                        $('#id_koordinator').selectpicker("refresh");
                        $.each(reg_data, function (index) {
                            $('#id_koordinator').append('<option value="'+reg_data[index].a+'">'+reg_data[index].b+'</option>');
                            $('#id_koordinator').selectpicker("refresh");
                        });

                    }
                }
            });
        }

        $('#id_koordinator').on("change", function(e){
            $('#dep_dist').val('');

            var a = $('#id_koordinator').val();
            get_dist(a);
        });


        //Dist1
        function get_dist(a, b) {
            $.ajax({
                type: "POST",
                url: "{{url('/get_dist_koordinator')}}",
                data:({a:a, _token:'{{csrf_token()}}'}),
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

                            $('#dep_dist').append('<option value="'+dist_data[index].a+'">'+dist_data[index].b+'</option>');
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

        


        function get_vill(a, b) {
            $.ajax({
                type: "POST",
                url: "{{url('/get_vill_koordinator')}}",
                data:({a:a, _token:'{{csrf_token()}}'}),
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
                            $('#dep_vill').append('<option value="'+dist_data[index].a+'">'+dist_data[index].b+'</option>');
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

        $('#dep_dist').on("change", function(e){
            $('#dep_vill').val('');

            var a = $('#dep_dist').val();
            get_vill(a);
        });


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