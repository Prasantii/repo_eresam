@extends('admin.home')
@section('content')
    <!-- START PAGE HEADING -->

    <div class="app-heading-container app-heading-bordered bottom">
        <ul class="breadcrumb">
            <li><a href="#">Aplikasi</a></li>
            <li><a href="{{url('/devadmin/koordinator')}}">Data koordinator</a></li>
            <li class="active">Edit Data koordinator</li>
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
                    <h2>Edit koordinator</h2>
                    <p>Manajement Data koordinator</p>
                </div>
            </div>
            <div class="block-content">
                <form method="post" enctype="multipart/form-data" action="{{ url('/devadmin/editkoordinatoraksi',encrypt($koordinator->id)) }}">
                <div class="row table-responsive">
                    <div class="col-md-6">
                        <table class="table table-bordered" width="100%">
                            
                            <tr>
                                <td>NIK</td>
                                <th id="no_prov_input" colspan="2">
                                    <input type="text" class="form-control" id="nik" name="nik" value="{{ $koordinator->nik }}" placeholder="NIK">
                                    @if ($errors->first('nik'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="nik">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <th id="no_ruas_input" colspan="2">
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $koordinator->nama }}" placeholder="Nama Lengkap">
                                    @if ($errors->first('nama'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="nama">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>No Hp</td>
                                <th id="nama_ruas_input">
                                    <input type="text" class="form-control" id="hp" name="hp" value="{{ $koordinator->hp }}">
                                    @if ($errors->first('hp'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="hp">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                        </table>
                        <h3>Lokasi</h3>
                        <table class="table table-bordered" width="100%">
                            <thead>
                            <tr>
                                <th width="30%">Zona</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                
                                <th id="no_jembatan_input">
                                    {{ csrf_field() }}
                                    <select id="id_zona" name="id_zona" class="bs-select" >
                                        @foreach($zona as $men)
                                            <option value="{{ $men->id }}" {{ $koordinator->id_zona == $men->id ? 'selected' : '' }}>{{ $men->nama }}</option>
                                          @endforeach
                                    </select>
                                    @if ($errors->first('id_zona'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="id_zona">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
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
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $koordinator->username }}">
                                    @if ($errors->first('username'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="username">Kolom ini diperlukan.</label>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <th id="status_input">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $koordinator->email }}">
                                    @if ($errors->first('email'))
                                    <label  class="error label label-warning label-bordered label-ghost" for="email">Kolom ini diperlukan.</label>
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
                            
                         
                            @if($koordinator->image == "")
                                <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">
                            @else
                                <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset( $koordinator->image ) }}" width="100x">
                            @endif
                            
                            
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
                        <a href="{{ url('/devadmin/koordinator') }}"><button type="button" class="btn btn-danger"  ><span class="fa fa-remove"></span> Batal</button>
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
</script>
@endsection