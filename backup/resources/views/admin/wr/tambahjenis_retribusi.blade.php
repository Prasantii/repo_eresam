@extends('admin.home')
@section('content')
    <!-- START PAGE HEADING -->

    <div class="app-heading-container app-heading-bordered bottom">
        <ul class="breadcrumb">
            <li><a href="#">Aplikasi</a></li>
            <li><a href="{{url('/devadmin/jenis_retribusi')}}">Data Jenis Retribusi</a></li>
            <li class="active">Tambah Jenis Retribusi</li>
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
                    <h2>TAMBAH Jenis Retribusi</h2>
                    <p>Manajement Data Jenis Retribusi</p>
                </div>
            </div>
            <div class="block-content">
                <form method="post" enctype="multipart/form-data" action="{{ URL::Route('Tambahjenis_retribusi') }}">
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered" width="100%">
                            
                            <tr>
                                <td>Jenis Objek Retribusi</td>
                                <th id="no_prov_input">
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                                    @if ($errors->first('nama'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="nama">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Luas Bangunan / Tempat</td>
                                <th id="nama_ruas_input">
                                    <input type="text" class="form-control" id="luas" name="luas" value="{{ old('luas') }}" placeholder="contoh: >150 m², 36 – 150m², <36 m²">
                                    @if ($errors->first('luas'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="luas">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        

                        <h3>Tarif Retribusi / Bulan</h3>
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <td>Jalan Utama & Pusat Kota</td>
                                <th id="nama_jembatan_input">
                                    <input type="text" class="form-control" id="tarif_kota" name="tarif_kota" value="{{ old('tarif_kota') }}">
                                    @if ($errors->first('tarif_kota'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="tarif_kota">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Jalan Lingkungan & Gampong</td>
                                <th id="status_input">
                                    <input type="text" class="form-control" id="tarif_gampong" name="tarif_gampong" value="{{ old('tarif_gampong') }}">
                                    @if ($errors->first('tarif_gampong'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="tarif_gampong">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
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
                        <a href="{{ url('/devadmin/jenis_retribusi') }}"><button type="button" class="btn btn-danger"  ><span class="fa fa-remove"></span> Batal</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER -->

<script type="text/javascript">
    $('#tarif_kota').number( true );
    $('#tarif_gampong').number( true );
</script>
@endsection