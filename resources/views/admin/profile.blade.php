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
      <div class="app-heading app-heading-background app-heading-light" style="background: url({{asset('assets/header/header-2.jpg')}}) center center no-repeat;">
        <div class="contact contact-rounded contact-bordered contact-xlg status-online margin-bottom-0">
            <?php if($data->image != ''){ ?>
                <img src="{{ asset($data->image) }}">
            <?php }else{ ?>
                <img src="{{ asset('avatar.png') }}">
            <?php } ?>
            
            <div class="contact-container">
                <a href="#" style="text-transform: uppercase;color: white;"><?php echo $data->name ?></a>
                <p style="text-transform: uppercase;color: white;"><?php echo $data->email ?></p>
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
                            <?php if($data->image != ''){ ?>
                                <img src="{{ asset($data->image) }}">
                            <?php }else{ ?>
                                <img src="{{ asset('avatar.png') }}">
                            <?php } ?>
                            <div class="contact-container">
                                <a href="#" style="text-transform: uppercase;color: black;"><?php $name = Session::get('name');
                                                    echo $name;
                                             ?></a>
                                <span style="text-transform: uppercase;color: black;">{{$data->email}}</span>
                            </div>                                                
                        </div>
                        <div class="heading-elements hidden-mobile">
                            <?php if($data->role_id == 1){
                                $url = 'devadmin';
                             }else{
                                $url = 'user';
                             } ?>
                            <a href="{{url('/user/profile/edit',encrypt($data->id))}}" class="btn btn-danger btn-icon-fixed"><span class="icon-pencil"></span> Edit Profile</a>
                            <a href="{{url('/user/profile/changepassword',encrypt($data->id))}}" class="btn btn-danger btn-icon-fixed"><span class="icon-lock"></span> Edit Password</a>
                        </div>
                    </div>                                                                                

                </div>
                <div class="block-content row-table-holder">
                    <div class="row row-table">
                        <div class="col-md-4 col-xs-12">
                            <span class="text-bolder text-uppercase text-sm">Nama Lengkap:</span>
                            <p style="text-transform: uppercase;color: black;">{{$data->name}}</p>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <span class="text-bolder text-uppercase text-sm">Username:</span>
                            <p>{{$data->username}}</p>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <span class="text-bolder text-uppercase text-sm">Email</span>
                            <p>{{$data->email}}</p>
                        </div>                                            
                    </div>
                    
                    <div class="row row-table">
                        <div class="col-md-6 col-xs-12">
                            <span class="text-bolder text-uppercase text-sm">Photo</span>
                            <p><?php if($data->image != ''){ ?>
                                <div class="parent-container"> 
                                    <a href="{{ asset($data->image) }}"  title=" {{$data->name}} " data-source="{{ asset($data->image) }}">
                                    <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default parent-container" src="{{ asset($data->image) }}" style="width: 250px;height: auto;"></a>
                                </div>
                            <?php }else{ ?>
                                    <img id="gambar-img-tag" class="app-widget-button app-widget-button-lg app-widget-button-ghost app-widget-button-default parent-container" src="{{ asset('admins/img/images.jpg') }}" style="width: 250px;height: auto;">
                            <?php } ?></p>
                        </div>                                            
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