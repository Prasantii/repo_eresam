@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li><a href="{{url('/user/profile')}}">Profile</a></li>
        <li class="active">Edit Profile</li>
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
      <div class="app-heading app-heading-background app-heading-light" style="background: url({{asset('assets/header/header-2.jpg')}}) center center no-repeat;">
        <div class="contact contact-rounded contact-bordered contact-xlg status-online margin-bottom-0">
            <?php if($user->image != ''){ ?>
                <img src="{{ asset($user->image) }}">
            <?php }else{ ?>
                <img src="{{ asset('avatar.png') }}">
            <?php } ?>
            
            <div class="contact-container">
                <a href="#" style="text-transform: uppercase;color: white;"><?php echo $user->name ?></a>
                <p style="text-transform: uppercase;color: white;"><?php echo $user->email ?></p>
            </div>
        </div>                        

        
    </div>   
</div>

<div class="block padding-top-15 typography">
    <div class="row">
        <div class="col-md-12">
            
            <!-- PROFILE CARD -->
            <div class="block block-condensed">
                <div class="block-heading margin-bottom-0">

                    <div class="app-heading app-heading-small">
                        <div class="contact contact-rounded contact-bordered contact-lg margin-bottom-0">
                            <?php if($user->image != ''){ ?>
                                <img src="{{ asset($user->image) }}">
                            <?php }else{ ?>
                                <img src="{{ asset('avatar.png') }}">
                            <?php } ?>
                            <div class="contact-container">
                                <a href="#" style="text-transform: uppercase;color: black;"><?php $name = Session::get('nama');
                                                    echo $name;
                                             ?></a>
                                <span style="text-transform: uppercase;color: black;">{{$user->email}}</span>
                            </div>                                                
                        </div>
                    </div>                                                                                

                </div>
                <div class="block-content row-table-holder">
                    <form method="POST" action="{{ URL::Route('Editprofile',encrypt($user->id)) }}" enctype="multipart/form-data">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="row row-table">
                            <div class="col-md-4 col-xs-12">
                                <span class="text-bolder text-uppercase text-sm">Nama Lengkap:</span>
                                <input type="text" name="name" id="name" class="form-control"  placeholder="name" value="{{ $user->name }}" >

                                @if ($errors->first('name'))
                                 <label  class="label label-warning label-bordered label-ghost" for="name">Kolom ini diperlukan.</label>
                                @endif
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <span class="text-bolder text-uppercase text-sm">Username:</span>
                                <input type="text" name="username" id="username" class="form-control"  placeholder="username" value="{{ $user->username }}" >

                                @if ($errors->first('username'))
                                 <label  class="label label-warning label-bordered label-ghost" for="username">Kolom ini diperlukan.</label>
                                @endif
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <span class="text-bolder text-uppercase text-sm">Email</span>
                                <input type="email" name="email" id="email" class="form-control"  placeholder="email" value="{{ $user->email }}" >

                                @if ($errors->first('email'))
                                 <label  class="label label-warning label-bordered label-ghost" for="email">Kolom ini diperlukan.</label>
                                @endif
                            </div>                                            
                        </div>
                        
                        <div class="row row-table">
                            <div class="col-md-6 col-xs-12">
                                <span class="text-bolder text-uppercase text-sm">Photo</span>
                                <!-- DEFAULT DROPZONE -->
                                <div class="block">                        

                                    <div class="app-heading app-heading-small">                                
                                        <div class="title">
                                            <h2>Photo</h2>
                                        </div>                                
                                    </div>
                                    
                                    <input type="file" id="gambar-img" name="image" class="form-control"  placeholder="Nama gambar" class="dropzone"> <br>

                                    @if ($errors->first('image'))
                                     <div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
                                        <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
                                        <div class="message">
                                          <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
                                            {{ $errors->first('image')}}
                                        </div>
                                      </div>
                                      @endif
                                  <br>
                                    
                                    @if($user->image == "")
                                    <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset('admins/img/images.jpg') }}" width="100x">
                                    @else
                                    <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default" src="{{ asset( $user->image ) }}" width="100x">
                                    @endif
                                    
                                </div>
                                <!-- END DROPZONE -->                                                                   
                            </div>                                            
                        </div>
                        <div class="heading-elements hidden-mobile" style="float: right;">
                            <button type="submit" class="btn btn-danger btn-icon-fixed"><span class="icon-pencil"></span> Simpan</button>
                            <a href="{{url('/user/profile')}}" class="btn btn-danger btn-icon-fixed"><span class="icon-cross-circle"></span> Batal</a>
                        </div>
                    </form>
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