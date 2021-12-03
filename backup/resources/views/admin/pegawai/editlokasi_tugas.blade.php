@extends('admin.home')
@section('content')
    <!-- START PAGE HEADING -->

    <div class="app-heading-container app-heading-bordered bottom">
        <ul class="breadcrumb">
            <li><a href="#">Aplikasi</a></li>
            <li><a href="{{url('/devadmin/petugas')}}">Data Petugas</a></li>
            <li class="active">Edit Data Petugas - (<u>{{ $petugas->nama }}</u>)</li>
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
                    <h2>Edit Lokasi Tugas Petugas</h2>
                    <p>Manajement Data Petugas (<u>{{ $petugas->nama }}</u>)</p>
                </div>
            </div>
            <div class="block-content">
                <form method="post" enctype="multipart/form-data" action="{{ url('/devadmin/editlokasitugas',encrypt($petugas->id)) }}">
                <div class="row table-responsive">
                    <div class="col-md-12">
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
                                    <select id="id_koordinator" name="id_koordinator" class="bs-select" >
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
    $("#hidejab").hide();
    $("#hidestatus").hide();
    $("#hidejenis").hide();
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