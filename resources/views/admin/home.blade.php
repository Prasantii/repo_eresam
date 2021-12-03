<!DOCTYPE html>
<html lang="en">
    <head>                        
        <title>E-RESAM - RETRIBUSI SAMPAH | Administrator</title>            
        
        <!-- META SECTION -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="shortcut icon" href="{{asset ('halamanlogin/img/img-01.png') }}" type="image/x-icon">
        <link rel="icon" href="{{asset ('halamanlogin/img/img-01.png') }}" type="image/x-icon">
        <!-- END META SECTION -->
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" href="{{ asset('admins/css/styles.css') }}">

        <link rel="stylesheet" href="{{ asset('admins/js/vendor/noty/noty.css') }}">
        <link rel="stylesheet" href="{{ asset('admins/js/vendor/noty/themes/bootstrap-v3.css') }}">
        <link rel="stylesheet" href="{{ asset('admins/magnific/magnific-popup.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
      integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
      crossorigin=""/>

        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('asset/datatables.min.css') }}"/> --}}

        <!-- IMPORTANT SCRIPTS -->
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jquery/jquery-migrate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/bootstrap/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/moment/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/moment/id.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/customscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>

    

        <!-- END IMPORTANT SCRIPTS -->
        <!-- THIS PAGE SCRIPTS -->
        <script type="text/javascript" src="{{ asset('admins/js/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}"></script>
        
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jvectormap/jquery-jvectormap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
        
        <script type="text/javascript" src="{{ asset('admins/js/vendor/rickshaw/d3.v3.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/rickshaw/rickshaw.min.js') }}"></script>
        <!-- END THIS PAGE SCRIPTS -->
        <!-- APP SCRIPTS -->
        <script type="text/javascript" src="{{ asset('admins/js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/app_plugins.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/app_demo.js') }}"></script>

        <script type="text/javascript" src="{{ asset('admins/js/vendor/bootstrap-select/bootstrap-select.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/select2/select2.full.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('admins/js/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/datatables/dataTables.bootstrap.min.js') }}"></script>
        
        <script src="{{ asset('admins/js/vendor/tinymce/tinymce.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/dropzone/dropzone.js')}}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/cropper/cropper.min.js')}}"></script>


        <script src="{{ asset('admins/js/vendor/noty/noty.min.js') }}"></script>


        
        <script type="text/javascript" src="{{ asset('admins/js/vendor/sweetalert/sweetalert.min.js')}}"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
         <script type="text/javascript" src="{{ asset('admins/js/vendor/isotope/isotope.pkgd.min.js')}}"></script>

         <script type="text/javascript" src="{{ asset('admins/magnific/jquery.magnific-popup.js') }}"></script>

         <script src="{{ asset('admins/js/vendor/jquery-number/jquery.number.js') }}"></script>
        <script src="{{ asset('admins/js/vendor/jquery-number/jquery.money.js') }}"></script>
    
         <script type="text/javascript" src="{{ asset('admins/js/vendor/tableexport/tableExport.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/tableexport/jquery.base64.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/tableexport/html2canvas.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/tableexport/jspdf/libs/sprintf.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/tableexport/jspdf/jspdf.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admins/js/vendor/tableexport/jspdf/libs/base64.js') }}"></script>
 
        <script type="text/javascript" src="{{ asset('admins/js/vendor/morris/raphael.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/js/vendor/morris/morris.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
      integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
      crossorigin=""></script>
    <script type="text/javascript">
        Noty.overrideDefaults({
                layout: 'topRight',
                theme: 'bootstrap-v3',
                animation: {
                    open: 'animated fadeInRight',
                    close: 'animated fadeOutRight'
                }
            });
            
        function PopupCenter(url, title, w, h) {  
            // Fixes dual-screen position                         Most browsers      Firefox  
            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;  
            var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;  
                      
            width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;  
            height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;  
                      
            var left = ((width / 2) - (w / 2)) + dualScreenLeft;  
            var top = ((height / 2) - (h / 2)) + dualScreenTop;  
            var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);  
          
            // Puts focus on the newWindow  
            if (window.focus) {  
                newWindow.focus();  
            }  
        }  
    </script>

        <!-- EOF CSS INCLUDE -->
    </head>
    <body>        
        
        <!-- APP WRAPPER -->
        <div class="app">           

            <!-- START APP CONTAINER -->
            <div class="app-container">
                <!-- START SIDEBAR -->

                @include('admin.navigasi')

                <!-- END SIDEBAR -->
                
                <!-- START APP CONTENT -->
                <div  class="app-content app-sidebar-left">
                    <!-- START APP HEADER -->
                    <div class="app-header app-header-design-orange">
                        <ul class="app-header-buttons">
                            <li class="visible-mobile"><a href="#" class="btn btn-link btn-icon" data-sidebar-toggle=".app-sidebar.dir-left"><span class="icon-menu"></span></a></li>
                            <li class="hidden-mobile"><a href="#" class="btn btn-link btn-icon" data-sidebar-minimize=".app-sidebar.dir-left"><span class="icon-menu"></span></a></li>
                        </ul>
                        
                        <ul class="app-header-buttons pull-right">
                            <li>
                                <div class="contact contact-rounded contact-bordered contact-lg contact-ps-controls">
                                    <?php
                                        $sesdata = session()->get('id'); 
                                        $dataaa = DB::table('user')->where('id',$sesdata)->first();
                                         if($dataaa->image != ''){ ?>
                                        <img src="{{ asset($dataaa->image) }}">
                                    <?php }else{ ?>
                                        <img src="{{ asset('avatar.png') }}">
                                    <?php } ?>
                                    <div class="contact-container">
                                        <span style="text-transform: uppercase;color: black;"><?php $name = Session::get('name');
                                                    echo $name;
                                             ?></span>
                                        <span style="color: black;"><?php $email = Session::get('email');
                                                    echo $email;
                                             ?></span>
                                    </div>
                                    <div class="contact-controls">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-default btn-icon" data-toggle="dropdown"><span class="icon-cog"></span></button>
                                            <ul class="dropdown-menu dropdown-left">
                                                <li><a href="{{url('/user/profile')}}"><span class="icon-users"></span> Profile</a></li> 
                                                <li class="divider"></li>
                                                <li><a href="{{url('/logout')}}"><span class="icon-exit"></span> Log Out</a></li> 
                                            </ul>
                                        </div>                     
                                    </div>
                                </div>
                            </li>        
                        </ul>
                    </div>
                    <!-- END APP HEADER  -->
                    <div class="app-heading app-heading-bordered app-heading-page">
                        <div class="icon icon-lg">
                            {{-- <span class="icon-home"></span> --}}
                            <img src="{{ asset('halamanlogin/img/img-01.png') }}" width="40px">
                        </div>
                        <div class="title pull-right">
                            {{-- <span class="icon-home"></span> --}}
                            {{-- <a href="{{url('/')}}" target="_blank"><button class="btn btn-primary btn-shadowed btn-rounded" type="button" ><span class="fa fa-eye"></span>&nbsp; Liat Website</button> </a> --}}
                        </div>
                        <div class="title">
                            <h1><b>E-RESAM</b></h1>
                            <p><b>RETRIBUSI SAMPAH</b></p>
                        </div>
                    </div> 
                    
                    @yield('content')
                </div>
                
                <!-- END APP CONTENT -->
                 <div class="app-footer app-footer-default" id="footer">
            <!--
            <div class="alert alert-danger alert-dismissible alert-inside text-center">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="icon-cross"></span></button>
                We use cookies to offer you the best experience on our website. Continuing browsing, you accept our cookies policy.
            </div>
            -->
            
            <div class="app-footer-line darken">                
                <div class="copyright wide text-center">   2020 &copy; ALL Rights Reserved</div>                
            </div>
            </div>               
            </div>
            <!-- END APP CONTAINER -->
                        
            <!-- START APP FOOTER -->
             
           
            
               
                
            
            
            <!-- END APP FOOTER -->
            <!-- START APP SIDEPANEL -->
            
            <!-- END APP SIDEPANEL -->
            
            <!-- APP OVERLAY -->
            
            <!-- END APP OVERLAY -->
              
        <!-- END APP WRAPPER -->                
    
        </div>

        <script type="text/javascript">
            
           
            
            tinymce.init({
                selector: '.editor-full',
                theme_advanced_resizing: true,
                theme_advanced_resizing_use_cookie : false,
                // height: 550,    

                // file_picker_callback: function(callback, value, meta) {
                //         imageFilePicker(callback, value, meta);
                //     },
                //     file_picker_types: 'file image media',

                    
                plugins: [
                  'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                  'searchreplace wordcount visualblocks visualchars code fullscreen',
                  'insertdatetime media nonbreaking save table contextmenu directionality',
                  'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ',
                toolbar2: 'print preview media | forecolor backcolor emoticons | imageupload',
                image_advtab: true,
                setup: function(editor) {
                 var inp = $('<input id="tinymce-uploader" type="file" name="pic" accept="image/*" style="display:none">');
                    $(editor.getElement()).parent().append(inp);

                    inp.on("change",function(){
                        var input = inp.get(0);
                        var file = input.files[0];
                        var fr = new FileReader();
                        fr.onload = function() {
                            var img = new Image();
                            img.src = fr.result;
                            editor.insertContent('<img src="'+img.src+'"/>');
                            inp.val('');
                        }
                        fr.readAsDataURL(file);
                    });

                    editor.addButton( 'imageupload', {
                        text:"Insert Image",
                        icon: "mce-ico mce-i-image",
                        onclick: function(e) {
                            inp.trigger('click');
                        }
                    });
                },
                
                skin_url: "{{ asset('admins/css/vendor/tinymce') }}",
                content_css: "{{ asset('admins/css/vendor/tinymce/content-style.css') }}"
            });
            

            
                  
        </script>

    </body>
</html>