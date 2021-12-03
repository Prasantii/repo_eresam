@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Menu</li>
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


<div class="container">
      <div id="aa" class="row">    
      <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Title Menu</b></h3>
                    <div class="panel-elements pull-right">
                        <a href="#"><button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-backdrop-disable-titlemenuadd" data-backdrop="static"><span class="fa fa-edit"></span> Tambah</button></a>
                    </div>
                </div>
                <div class="panel-body">      
                    <div class="block-content"  style="overflow-y: auto;width: 100%">
                        
                    <div  id="aa" class="table-responsive">
                        <table id="titlemenu" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="50%">MENU</th>
                                    <th width="45%">AKSI</th>
                                    
                                </tr>
                            </thead>  
                            <tfoot>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th width="50%">MENU</th>
                                    <th width="45%">AKSI</th>
                                </tr>
                            </tfoot>                                    
                           
                        </table>
                        
                    </div>
                    
                    </div>
                </div>
                <div class="panel-footer">                                        
                    
                </div>
            </div>
        </div>                        
	    <div class="col-md-8">
	        <div class="panel panel-success">
	            <div class="panel-heading">
	                <h3 class="panel-title"><b>Menu Management</b></h3>
	                <div class="panel-elements pull-right">
			            <a href="#"><button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-backdrop-disable" data-backdrop="static"><span class="fa fa-edit"></span> Tambah</button></a>
			        </div>
	            </div>
	            <div class="panel-body">      
					<div class="block-content"  style="overflow-y: auto;">
						
					<div  id="aa">
		    			<table id="sponsor" class="table table-striped table-bordered"  style="width: max-content 100%;" >
		                    <thead>
		                        <tr>
		                            <th>NO</th>
                                    <th>TITLE MENU</th>
                                    <th>NAMA MENU</th>
						            <th>ICON</th>
						            <th>AKSI</th>
		                            
		                        </tr>
		                    </thead>  
		                    <tfoot>
		                        <tr>
		                            <th>NO</th>
                                    <th>TITLE MENU</th>
                                    <th>NAMA MENU</th>
                                    <th>ICON</th>
                                    <th>AKSI</th>
		                        </tr>
		                    </tfoot>                                    
		                   
		                </table>
		                
		            </div>
					
					</div>
	            </div>
	            <div class="panel-footer">                                        
	                
	        	</div>
	        </div>
	    </div>
	</div>   
</div>

<!-- MODAL TITLE MENU -->
<div class="modal fade" id="modal-backdrop-disable-titlemenuadd" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Tambah Data</h4>
            </div>
            <div class="modal-body">
               <form id="input-title" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="idtitle" id="idtitle">
                    <div class="form-group">
                        <label>Title Menu Name</label>
                        
                        <input type="text" id="judultitle" name="judultitle" class="form-control"  placeholder="Role Name" >
                       
                    </div>

                    <div class="col-md-12">
                        <div id="progresstitlemenu" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpan">Simpan</button>
                    </div>
                </form>
            </div>
            
            
        </div>
    </div>            
</div>
<!-- END MODAL BACKDROP DISABLE -->

<!-- MODAL TITLE MENU -->
<div class="modal fade" id="modal-backdrop-disable-titlemenuedit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Edit Data</h4>
            </div>
            <div class="modal-body">
               <form id="edit-title" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="idbrtitle" id="idbrtitle">
                    <div class="form-group">
                        <label>Title Menu Name</label>
                        
                        <input type="text" id="juduledittitle" name="juduledittitle" class="form-control"  placeholder="Role Name" >
                       
                    </div>

                    <div class="col-md-12">
                        <div id="progresstitlemenuedit" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpanedit">Simpan</button>
                    </div>
                </form>
            </div>
            
            
        </div>
    </div>            
</div>
<!-- END MODAL BACKDROP DISABLE -->

<!-- MODAL MENU -->
<div class="modal fade" id="modal-backdrop-disable" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Tambah Data</h4>
            </div>
            <div class="modal-body">
               <form id="input-sport" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Title Menu</label>
                        <select name="id_titile_menu" id="id_titile_menu" class="bs-select" data-live-search="true" >
                            <option id="hiddent" value="">----SILAHKAN PILIH TITLE MENU----</option>
                            @foreach($titlemenu as $men)
                                <option value="{{$men->id}}">{{$men->menu}}</option>
                            @endforeach
                        </select>
                       
                    </div>
                    <div class="form-group">
                        <label>Menu Name</label>
                        
                        <input type="text" id="judul" name="judul" class="form-control"  placeholder="Menu Name" >
                       
                    </div>

                    <div class="form-group">
                        <label>Icon</label>
                        <select name="icon" id="icon" class="form-control" style="font-weight: 900;font-size: 16px;">
                            <option value="fa-align-left">&#xf036; fa-align-left</option>
                            <option value="fa-align-right">&#xf038; fa-align-right</option>
                            <option value="fa-amazon">&#xf270; fa-amazon</option>
                            <option value="fa-ambulance">&#xf0f9; fa-ambulance</option>
                            <option value="fa-anchor">&#xf13d; fa-anchor</option>
                            <option value="fa-android">&#xf17b; fa-android</option>
                            <option value="fa-angellist">&#xf209; fa-angellist</option>
                            <option value="fa-angle-double-down">&#xf103; fa-angle-double-down</option>
                            <option value="fa-angle-double-left">&#xf100; fa-angle-double-left</option>
                            <option value="fa-angle-double-right">&#xf101; fa-angle-double-right</option>
                            <option value="fa-angle-double-up">&#xf102; fa-angle-double-up</option>
                            <option value="fa-angle-left">&#xf104; fa-angle-left</option>
                            <option value="fa-angle-right">&#xf105; fa-angle-right</option>
                            <option value="fa-angle-up">&#xf106; fa-angle-up</option>
                            <option value="fa-apple">&#xf179; fa-apple</option>
                            <option value="fa-archive">&#xf187; fa-archive</option>
                            <option value="fa-area-chart">&#xf1fe; fa-area-chart</option>
                            <option value="fa-arrow-circle-down">&#xf0ab; fa-arrow-circle-down</option>
                            <option value="fa-arrow-circle-left">&#xf0a8; fa-arrow-circle-left</option>
                            <option value="fa-arrow-circle-o-down">&#xf01a; fa-arrow-circle-o-down</option>
                            <option value="fa-arrow-circle-o-left">&#xf190; fa-arrow-circle-o-left</option>
                            <option value="fa-arrow-circle-o-right">&#xf18e; fa-arrow-circle-o-right</option>
                            <option value="fa-arrow-circle-o-up">&#xf01b; fa-arrow-circle-o-up</option>
                            <option value="fa-arrow-circle-right">&#xf0a9; fa-arrow-circle-right</option>
                            <option value="fa-arrow-circle-up">&#xf0aa; fa-arrow-circle-up</option>
                            <option value="fa-arrow-down">&#xf063; fa-arrow-down</option>
                            <option value="fa-arrow-left">&#xf060; fa-arrow-left</option>
                            <option value="fa-arrow-right">&#xf061; fa-arrow-right</option>
                            <option value="fa-arrow-up">&#xf062; fa-arrow-up</option>
                            <option value="fa-arrows">&#xf047; fa-arrows</option>
                            <option value="fa-arrows-alt">&#xf0b2; fa-arrows-alt</option>
                            <option value="fa-arrows-h">&#xf07e; fa-arrows-h</option>
                            <option value="fa-arrows-v">&#xf07d; fa-arrows-v</option>
                            <option value="fa-asterisk">&#xf069; fa-asterisk</option>
                            <option value="fa-at">&#xf1fa; fa-at</option>
                            <option value="fa-automobile">&#xf1b9; fa-automobile</option>
                            <option value="fa-backward">&#xf04a; fa-backward</option>
                            <option value="fa-balance-scale">&#xf24e; fa-balance-scale</option>
                            <option value="fa-ban">&#xf05e; fa-ban</option>
                            <option value="fa-bank">&#xf19c; fa-bank</option>
                            <option value="fa-bar-chart">&#xf080; fa-bar-chart</option>
                            <option value="fa-bar-chart-o">&#xf080; fa-bar-chart-o</option>

                            <option value="fa-battery-full">&#xf240; fa-battery-full</option>
                            n value="fa-beer">&#xf0fc; fa-beer</option>
                            <option value="fa-behance">&#xf1b4; fa-behance</option>
                            <option value="fa-behance-square">&#xf1b5; fa-behance-square</option>
                            <option value="fa-bell">&#xf0f3; fa-bell</option>
                            <option value="fa-bell-o">&#xf0a2; fa-bell-o</option>
                            <option value="fa-bell-slash">&#xf1f6; fa-bell-slash</option>
                            <option value="fa-bell-slash-o">&#xf1f7; fa-bell-slash-o</option>
                            <option value="fa-bicycle">&#xf206; fa-bicycle</option>
                            <option value="fa-binoculars">&#xf1e5; fa-binoculars</option>
                            <option value="fa-birthday-cake">&#xf1fd; fa-birthday-cake</option>
                            <option value="fa-bitbucket">&#xf171; fa-bitbucket</option>
                            <option value="fa-bitbucket-square">&#xf172; fa-bitbucket-square</option>
                            <option value="fa-bitcoin">&#xf15a; fa-bitcoin</option>
                            <option value="fa-black-tie">&#xf27e; fa-black-tie</option>
                            <option value="fa-bold">&#xf032; fa-bold</option>
                            <option value="fa-bolt">&#xf0e7; fa-bolt</option>
                            <option value="fa-bomb">&#xf1e2; fa-bomb</option>
                            <option value="fa-book">&#xf02d; fa-book</option>
                            <option value="fa-bookmark">&#xf02e; fa-bookmark</option>
                            <option value="fa-bookmark-o">&#xf097; fa-bookmark-o</option>
                            <option value="fa-briefcase">&#xf0b1; fa-briefcase</option>
                            <option value="fa-btc">&#xf15a; fa-btc</option>
                            <option value="fa-bug">&#xf188; fa-bug</option>
                            <option value="fa-building">&#xf1ad; fa-building</option>
                            <option value="fa-building-o">&#xf0f7; fa-building-o</option>
                            <option value="fa-bullhorn">&#xf0a1; fa-bullhorn</option>
                            <option value="fa-bullseye">&#xf140; fa-bullseye</option>
                            <option value="fa-bus">&#xf207; fa-bus</option>
                            <option value="fa-cab">&#xf1ba; fa-cab</option>
                            <option value="fa-calendar">&#xf073; fa-calendar</option>
                            <option value="fa-camera">&#xf030; fa-camera</option>
                            <option value="fa-car">&#xf1b9; fa-car</option>
                            <option value="fa-caret-up">&#xf0d8; fa-caret-up</option>
                            <option value="fa-cart-plus">&#xf217; fa-cart-plus</option>
                            <option value="fa-cc">&#xf20a; fa-cc</option>
                            <option value="fa-cc-amex">&#xf1f3; fa-cc-amex</option>
                            <option value="fa-cc-jcb">&#xf24b; fa-cc-jcb</option>
                            <option value="fa-cc-paypal">&#xf1f4; fa-cc-paypal</option>
                            <option value="fa-cc-stripe">&#xf1f5; fa-cc-stripe</option>
                            <option value="fa-cc-visa">&#xf1f0; fa-cc-visa</option>
                            <option value="fa-chain">&#xf0c1; fa-chain</option>
                            <option value="fa-check">&#xf00c; fa-check</option>
                            <option value="fa-chevron-left">&#xf053; fa-chevron-left</option>
                            <option value="fa-chevron-right">&#xf054; fa-chevron-right</option>
                            <option value="fa-chevron-up">&#xf077; fa-chevron-up</option>
                            <option value="fa-child">&#xf1ae; fa-child</option>
                            <option value="fa-chrome">&#xf268; fa-chrome</option>
                            <option value="fa-circle">&#xf111; fa-circle</option>
                            <option value="fa-circle-o">&#xf10c; fa-circle-o</option>
                            <option value="fa-circle-o-notch">&#xf1ce; fa-circle-o-notch</option>
                            <option value="fa-circle-thin">&#xf1db; fa-circle-thin</option>
                            <option value="fa-clipboard">&#xf0ea; fa-clipboard</option>
                            <option value="fa-clock-o">&#xf017; fa-clock-o</option>
                            <option value="fa-clone">&#xf24d; fa-clone</option>
                            <option value="fa-close">&#xf00d; fa-close</option>
                            <option value="fa-cloud">&#xf0c2; fa-cloud</option>
                            <option value="fa-cloud-download">&#xf0ed; fa-cloud-download</option>
                            <option value="fa-cloud-upload">&#xf0ee; fa-cloud-upload</option>
                            <option value="fa-cny">&#xf157; fa-cny</option>
                            <option value="fa-code">&#xf121; fa-code</option>
                            <option value="fa-code-fork">&#xf126; fa-code-fork</option>
                            <option value="fa-codepen">&#xf1cb; fa-codepen</option>
                            <option value="fa-coffee">&#xf0f4; fa-coffee</option>
                            <option value="fa-cog">&#xf013; fa-cog</option>
                            <option value="fa-cogs">&#xf085; fa-cogs</option>
                            <option value="fa-columns">&#xf0db; fa-columns</option>
                            <option value="fa-comment">&#xf075; fa-comment</option>
                            <option value="fa-comment-o">&#xf0e5; fa-comment-o</option>
                            <option value="fa-commenting">&#xf27a; fa-commenting</option>
                            <option value="fa-commenting-o">&#xf27b; fa-commenting-o</option>
                            <option value="fa-comments">&#xf086; fa-comments</option>
                            <option value="fa-comments-o">&#xf0e6; fa-comments-o</option>
                            <option value="fa-compass">&#xf14e; fa-compass</option>
                            <option value="fa-compress">&#xf066; fa-compress</option>
                            <option value="fa-connectdevelop">&#xf20e; fa-connectdevelop</option>
                            <option value="fa-contao">&#xf26d; fa-contao</option>
                            <option value="fa-copy">&#xf0c5; fa-copy</option>
                            <option value="fa-copyright">&#xf1f9; fa-copyright</option>
                            <option value="fa-creative-commons">&#xf25e; fa-creative-commons</option>
                            <option value="fa-credit-card">&#xf09d; fa-credit-card</option>
                            <option value="fa-crop">&#xf125; fa-crop</option>
                            <option value="fa-crosshairs">&#xf05b; fa-crosshairs</option>
                            <option value="fa-css3">&#xf13c; fa-css3</option>
                            <option value="fa-cube">&#xf1b2; fa-cube</option>
                            <option value="fa-cubes">&#xf1b3; fa-cubes</option>
                            <option value="fa-cut">&#xf0c4; fa-cut</option>
                            <option value="fa-cutlery">&#xf0f5; fa-cutlery</option>
                            <option value="fa-dashboard">&#xf0e4; fa-dashboard</option>
                            <option value="fa-dashcube">&#xf210; fa-dashcube</option>
                            <option value="fa-database">&#xf1c0; fa-database</option>
                            <option value="fa-dedent">&#xf03b; fa-dedent</option>
                            <option value="fa-delicious">&#xf1a5; fa-delicious</option>
                            <option value="fa-desktop">&#xf108; fa-desktop</option>
                            <option value="fa-deviantart">&#xf1bd; fa-deviantart</option>
                            <option value="fa-diamond">&#xf219; fa-diamond</option>
                            <option value="fa-digg">&#xf1a6; fa-digg</option>
                            <option value="fa-dollar">&#xf155; fa-dollar</option>
                            <option value="fa-download">&#xf019; fa-download</option>
                            <option value="fa-dribbble">&#xf17d; fa-dribbble</option>
                            <option value="fa-dropbox">&#xf16b; fa-dropbox</option>
                            <option value="fa-drupal">&#xf1a9; fa-drupal</option>
                            <option value="fa-edit">&#xf044; fa-edit</option>
                            <option value="fa-eject">&#xf052; fa-eject</option>
                            <option value="fa-ellipsis-h">&#xf141; fa-ellipsis-h</option>
                            <option value="fa-ellipsis-v">&#xf142; fa-ellipsis-v</option>
                            <option value="fa-empire">&#xf1d1; fa-empire</option>
                            <option value="fa-envelope">&#xf0e0; fa-envelope</option>
                            <option value="fa-envelope-o">&#xf003; fa-envelope-o</option>
                            <option value="fa-eur">&#xf153; fa-eur</option>
                            <option value="fa-euro">&#xf153; fa-euro</option>
                            <option value="fa-exchange">&#xf0ec; fa-exchange</option>
                            <option value="fa-exclamation">&#xf12a; fa-exclamation</option>
                            <option value="fa-exclamation-circle">&#xf06a; fa-exclamation-circle</option>
                            <option value="fa-exclamation-triangle">&#xf071; fa-exclamation-triangle</option>
                            <option value="fa-expand">&#xf065; fa-expand</option>
                            <option value="fa-expeditedssl">&#xf23e; fa-expeditedssl</option>
                            <option value="fa-external-link">&#xf08e; fa-external-link</option>
                            <option value="fa-external-link-square">&#xf14c; fa-external-link-square</option>
                            <option value="fa-eye">&#xf06e; fa-eye</option>
                            <option value="fa-eye-slash">&#xf070; fa-eye-slash</option>
                            <option value="fa-eyedropper">&#xf1fb; fa-eyedropper</option>
                            <option value="fa-facebook">&#xf09a; fa-facebook</option>
                            <option value="fa-facebook-f">&#xf09a; fa-facebook-f</option>
                            <option value="fa-facebook-official">&#xf230; fa-facebook-official</option>
                            <option value="fa-facebook-square">&#xf082; fa-facebook-square</option>
                            <option value="fa-fast-backward">&#xf049; fa-fast-backward</option>
                            <option value="fa-fast-forward">&#xf050; fa-fast-forward</option>
                            <option value="fa-fax">&#xf1ac; fa-fax</option>
                            <option value="fa-feed">&#xf09e; fa-feed</option>
                            <option value="fa-female">&#xf182; fa-female</option>
                            <option value="fa-fighter-jet">&#xf0fb; fa-fighter-jet</option>
                            <option value="fa-file">&#xf15b; fa-file</option>
                            <option value="fa-file-archive-o">&#xf1c6; fa-file-archive-o</option>
                            <option value="fa-file-audio-o">&#xf1c7; fa-file-audio-o</option>
                            <option value="fa-file-code-o">&#xf1c9; fa-file-code-o</option>
                            <option value="fa-file-excel-o">&#xf1c3; fa-file-excel-o</option>
                            <option value="fa-file-image-o">&#xf1c5; fa-file-image-o</option>
                            <option value="fa-file-movie-o">&#xf1c8; fa-file-movie-o</option>
                            <option value="fa-file-o">&#xf016; fa-file-o</option>
                            <option value="fa-file-pdf-o">&#xf1c1; fa-file-pdf-o</option>
                            <option value="fa-file-photo-o">&#xf1c5; fa-file-photo-o</option>
                            <option value="fa-file-picture-o">&#xf1c5; fa-file-picture-o</option>
                            <option value="fa-file-powerpoint-o">&#xf1c4; fa-file-powerpoint-o</option>
                            <option value="fa-file-sound-o">&#xf1c7; fa-file-sound-o</option>
                            <option value="fa-file-text">&#xf15c; fa-file-text</option>
                            <option value="fa-file-text-o">&#xf0f6; fa-file-text-o</option>
                            <option value="fa-file-video-o">&#xf1c8; fa-file-video-o</option>
                            <option value="fa-file-word-o">&#xf1c2; fa-file-word-o</option>
                            <option value="fa-file-zip-o">&#xf1c6; fa-file-zip-o</option>
                            <option value="fa-files-o">&#xf0c5; fa-files-o</option>
                            <option value="fa-film">&#xf008; fa-film</option>
                            <option value="fa-filter">&#xf0b0; fa-filter</option>
                            <option value="fa-fire">&#xf06d; fa-fire</option>
                            <option value="fa-fire-extinguisher">&#xf134; fa-fire-extinguisher</option>
                            <option value="fa-firefox">&#xf269; fa-firefox</option>
                            <option value="fa-flag">&#xf024; fa-flag</option>
                            <option value="fa-flag-checkered">&#xf11e; fa-flag-checkered</option>
                            <option value="fa-flag-o">&#xf11d; fa-flag-o</option>
                            <option value="fa-flash">&#xf0e7; fa-flash</option>
                            <option value="fa-flask">&#xf0c3; fa-flask</option>
                            <option value="fa-flickr">&#xf16e; fa-flickr</option>
                            <option value="fa-floppy-o">&#xf0c7; fa-floppy-o</option>
                            <option value="fa-folder">&#xf07b; fa-folder</option>
                            <option value="fa-folder-o">&#xf114; fa-folder-o</option>
                            <option value="fa-folder-open">&#xf07c; fa-folder-open</option>
                            <option value="fa-folder-open-o">&#xf115; fa-folder-open-o</option>
                            <option value="fa-font">&#xf031; fa-font</option>
                            <option value="fa-fonticons">&#xf280; fa-fonticons</option>
                            <option value="fa-forumbee">&#xf211; fa-forumbee</option>
                            <option value="fa-forward">&#xf04e; fa-forward</option>
                            <option value="fa-foursquare">&#xf180; fa-foursquare</option>
                            <option value="fa-frown-o">&#xf119; fa-frown-o</option>
                            <option value="fa-futbol-o">&#xf1e3; fa-futbol-o</option>
                            <option value="fa-gamepad">&#xf11b; fa-gamepad</option>
                            <option value="fa-gavel">&#xf0e3; fa-gavel</option>
                            <option value="fa-gbp">&#xf154; fa-gbp</option>
                            <option value="fa-ge">&#xf1d1; fa-ge</option>
                            <option value="fa-gear">&#xf013; fa-gear</option>
                            <option value="fa-gears">&#xf085; fa-gears</option>
                            <option value="fa-genderless">&#xf22d; fa-genderless</option>
                            <option value="fa-get-pocket">&#xf265; fa-get-pocket</option>
                            <option value="fa-gg">&#xf260; fa-gg</option>
                            <option value="fa-gg-circle">&#xf261; fa-gg-circle</option>
                            <option value="fa-gift">&#xf06b; fa-gift</option>
                            <option value="fa-git">&#xf1d3; fa-git</option>
                            <option value="fa-git-square">&#xf1d2; fa-git-square</option>
                            <option value="fa-github">&#xf09b; fa-github</option>
                            <option value="fa-github-alt">&#xf113; fa-github-alt</option>
                            <option value="fa-github-square">&#xf092; fa-github-square</option>
                            <option value="fa-gittip">&#xf184; fa-gittip</option>
                            <option value="fa-glass">&#xf000; fa-glass</option>
                            <option value="fa-globe">&#xf0ac; fa-globe</option>
                            <option value="fa-google">&#xf1a0; fa-google</option>
                            <option value="fa-google-plus">&#xf0d5; fa-google-plus</option>
                            <option value="fa-google-plus-square">&#xf0d4; fa-google-plus-square</option>
                            <option value="fa-google-wallet">&#xf1ee; fa-google-wallet</option>
                            <option value="fa-graduation-cap">&#xf19d; fa-graduation-cap</option>
                            <option value="fa-gratipay">&#xf184; fa-gratipay</option>
                            <option value="fa-group">&#xf0c0; fa-group</option>
                            <option value="fa-h-square">&#xf0fd; fa-h-square</option>
                            <option value="fa-hacker-news">&#xf1d4; fa-hacker-news</option>
                            <option value="fa-hand-grab-o">&#xf255; fa-hand-grab-o</option>
                            <option value="fa-hand-lizard-o">&#xf258; fa-hand-lizard-o</option>
                            <option value="fa-hand-o-down">&#xf0a7; fa-hand-o-down</option>
                            <option value="fa-hand-o-left">&#xf0a5; fa-hand-o-left</option>
                            <option value="fa-hand-o-right">&#xf0a4; fa-hand-o-right</option>
                            <option value="fa-hand-o-up">&#xf0a6; fa-hand-o-up</option>
                            <option value="fa-hand-paper-o">&#xf256; fa-hand-paper-o</option>
                            <option value="fa-hand-peace-o">&#xf25b; fa-hand-peace-o</option>
                            <option value="fa-hand-pointer-o">&#xf25a; fa-hand-pointer-o</option>
                            <option value="fa-hand-rock-o">&#xf255; fa-hand-rock-o</option>
                            <option value="fa-hand-scissors-o">&#xf257; fa-hand-scissors-o</option>
                            <option value="fa-hand-spock-o">&#xf259; fa-hand-spock-o</option>
                            <option value="fa-hand-stop-o">&#xf256; fa-hand-stop-o</option>
                            <option value="fa-hdd-o">&#xf0a0; fa-hdd-o</option>
                            <option value="fa-header">&#xf1dc; fa-header</option>
                            <option value="fa-headphones">&#xf025; fa-headphones</option>
                            <option value="fa-heart">&#xf004; fa-heart</option>
                            <option value="fa-heart-o">&#xf08a; fa-heart-o</option>
                            <option value="fa-heartbeat">&#xf21e; fa-heartbeat</option>
                            <option value="fa-history">&#xf1da; fa-history</option>
                            <option value="fa-home">&#xf015; fa-home</option>
                            <option value="fa-hospital-o">&#xf0f8; fa-hospital-o</option>
                            <option value="fa-hotel">&#xf236; fa-hotel</option>
                            <option value="fa-hourglass">&#xf254; fa-hourglass</option>
                            <option value="fa-hourglass-1">&#xf251; fa-hourglass-1</option>
                            <option value="fa-hourglass-2">&#xf252; fa-hourglass-2</option>
                            <option value="fa-hourglass-3">&#xf253; fa-hourglass-3</option>
                            <option value="fa-hourglass-end">&#xf253; fa-hourglass-end</option>
                            <option value="fa-hourglass-half">&#xf252; fa-hourglass-half</option>
                            <option value="fa-hourglass-o">&#xf250; fa-hourglass-o</option>
                            <option value="fa-hourglass-start">&#xf251; fa-hourglass-start</option>
                            <option value="fa-houzz">&#xf27c; fa-houzz</option>
                            <option value="fa-html5">&#xf13b; fa-html5</option>
                            <option value="fa-i-cursor">&#xf246; fa-i-cursor</option>
                            <option value="fa-ils">&#xf20b; fa-ils</option>
                            <option value="fa-image">&#xf03e; fa-image</option>
                            <option value="fa-inbox">&#xf01c; fa-inbox</option>
                            <option value="fa-indent">&#xf03c; fa-indent</option>
                            <option value="fa-industry">&#xf275; fa-industry</option>
                            <option value="fa-info">&#xf129; fa-info</option>
                            <option value="fa-info-circle">&#xf05a; fa-info-circle</option>
                            <option value="fa-inr">&#xf156; fa-inr</option>
                            <option value="fa-instagram">&#xf16d; fa-instagram</option>
                            <option value="fa-institution">&#xf19c; fa-institution</option>
                            <option value="fa-internet-explorer">&#xf26b; fa-internet-explorer</option>
                            <option value="fa-intersex">&#xf224; fa-intersex</option>
                            <option value="fa-ioxhost">&#xf208; fa-ioxhost</option>
                            <option value="fa-italic">&#xf033; fa-italic</option>
                            <option value="fa-joomla">&#xf1aa; fa-joomla</option>
                            <option value="fa-jpy">&#xf157; fa-jpy</option>
                            <option value="fa-jsfiddle">&#xf1cc; fa-jsfiddle</option>
                            <option value="fa-key">&#xf084; fa-key</option>
                            <option value="fa-keyboard-o">&#xf11c; fa-keyboard-o</option>
                            <option value="fa-krw">&#xf159; fa-krw</option>
                            <option value="fa-language">&#xf1ab; fa-language</option>
                            <option value="fa-laptop">&#xf109; fa-laptop</option>
                            <option value="fa-lastfm">&#xf202; fa-lastfm</option>
                            <option value="fa-lastfm-square">&#xf203; fa-lastfm-square</option>
                            <option value="fa-leaf">&#xf06c; fa-leaf</option>
                            <option value="fa-leanpub">&#xf212; fa-leanpub</option>
                            <option value="fa-legal">&#xf0e3; fa-legal</option>
                            <option value="fa-lemon-o">&#xf094; fa-lemon-o</option>
                            <option value="fa-level-down">&#xf149; fa-level-down</option>
                            <option value="fa-level-up">&#xf148; fa-level-up</option>
                            <option value="fa-life-bouy">&#xf1cd; fa-life-bouy</option>
                            <option value="fa-life-buoy">&#xf1cd; fa-life-buoy</option>
                            <option value="fa-life-ring">&#xf1cd; fa-life-ring</option>
                            <option value="fa-life-saver">&#xf1cd; fa-life-saver</option>
                            <option value="fa-lightbulb-o">&#xf0eb; fa-lightbulb-o</option>
                            <option value="fa-line-chart">&#xf201; fa-line-chart</option>
                            <option value="fa-link">&#xf0c1; fa-link</option>
                            <option value="fa-linkedin">&#xf0e1; fa-linkedin</option>
                            <option value="fa-linkedin-square">&#xf08c; fa-linkedin-square</option>
                            <option value="fa-linux">&#xf17c; fa-linux</option>
                            <option value="fa-list">&#xf03a; fa-list</option>
                            <option value="fa-list-alt">&#xf022; fa-list-alt</option>
                            <option value="fa-list-ol">&#xf0cb; fa-list-ol</option>
                            <option value="fa-list-ul">&#xf0ca; fa-list-ul</option>
                            <option value="fa-location-arrow">&#xf124; fa-location-arrow</option>
                            <option value="fa-lock">&#xf023; fa-lock</option>
                            <option value="fa-long-arrow-down">&#xf175; fa-long-arrow-down</option>
                            <option value="fa-long-arrow-left">&#xf177; fa-long-arrow-left</option>
                            <option value="fa-long-arrow-right">&#xf178; fa-long-arrow-right</option>
                            <option value="fa-long-arrow-up">&#xf176; fa-long-arrow-up</option>
                            <option value="fa-magic">&#xf0d0; fa-magic</option>
                            <option value="fa-magnet">&#xf076; fa-magnet</option>

                            <option value="fa-mars-stroke-v">&#xf22a; fa-mars-stroke-v</option>
                            <option value="fa-maxcdn">&#xf136; fa-maxcdn</option>
                            <option value="fa-meanpath">&#xf20c; fa-meanpath</option>
                            <option value="fa-medium">&#xf23a; fa-medium</option>
                            <option value="fa-medkit">&#xf0fa; fa-medkit</option>
                            <option value="fa-meh-o">&#xf11a; fa-meh-o</option>
                            <option value="fa-mercury">&#xf223; fa-mercury</option>
                            <option value="fa-microphone">&#xf130; fa-microphone</option>
                            <option value="fa-mobile">&#xf10b; fa-mobile</option>
                            <option value="fa-motorcycle">&#xf21c; fa-motorcycle</option>
                            <option value="fa-mouse-pointer">&#xf245; fa-mouse-pointer</option>
                            <option value="fa-music">&#xf001; fa-music</option>
                            <option value="fa-navicon">&#xf0c9; fa-navicon</option>
                            <option value="fa-neuter">&#xf22c; fa-neuter</option>
                            <option value="fa-newspaper-o">&#xf1ea; fa-newspaper-o</option>
                            <option value="fa-opencart">&#xf23d; fa-opencart</option>
                            <option value="fa-openid">&#xf19b; fa-openid</option>
                            <option value="fa-opera">&#xf26a; fa-opera</option>
                            <option value="fa-outdent">&#xf03b; fa-outdent</option>
                            <option value="fa-pagelines">&#xf18c; fa-pagelines</option>
                            <option value="fa-paper-plane-o">&#xf1d9; fa-paper-plane-o</option>
                            <option value="fa-paperclip">&#xf0c6; fa-paperclip</option>
                            <option value="fa-paragraph">&#xf1dd; fa-paragraph</option>
                            <option value="fa-paste">&#xf0ea; fa-paste</option>
                            <option value="fa-pause">&#xf04c; fa-pause</option>
                            <option value="fa-paw">&#xf1b0; fa-paw</option>
                            <option value="fa-paypal">&#xf1ed; fa-paypal</option>
                            <option value="fa-pencil">&#xf040; fa-pencil</option>
                            <option value="fa-pencil-square-o">&#xf044; fa-pencil-square-o</option>
                            <option value="fa-phone">&#xf095; fa-phone</option>
                            <option value="fa-photo">&#xf03e; fa-photo</option>
                            <option value="fa-picture-o">&#xf03e; fa-picture-o</option>
                            <option value="fa-pie-chart">&#xf200; fa-pie-chart</option>
                            <option value="fa-pied-piper">&#xf1a7; fa-pied-piper</option>
                            <option value="fa-pied-piper-alt">&#xf1a8; fa-pied-piper-alt</option>
                            <option value="fa-pinterest">&#xf0d2; fa-pinterest</option>
                            <option value="fa-pinterest-p">&#xf231; fa-pinterest-p</option>
                            <option value="fa-pinterest-square">&#xf0d3; fa-pinterest-square</option>
                            <option value="fa-plane">&#xf072; fa-plane</option>
                            <option value="fa-play">&#xf04b; fa-play</option>
                            <option value="fa-play-circle">&#xf144; fa-play-circle</option>
                            <option value="fa-play-circle-o">&#xf01d; fa-play-circle-o</option>
                            <option value="fa-plug">&#xf1e6; fa-plug</option>
                            <option value="fa-plus">&#xf067; fa-plus</option>
                            <option value="fa-plus-circle">&#xf055; fa-plus-circle</option>
                            <option value="fa-plus-square">&#xf0fe; fa-plus-square</option>
                            <option value="fa-plus-square-o">&#xf196; fa-plus-square-o</option>
                            <option value="fa-power-off">&#xf011; fa-power-off</option>
                            <option value="fa-print">&#xf02f; fa-print</option>
                            <option value="fa-puzzle-piece">&#xf12e; fa-puzzle-piece</option>
                            <option value="fa-qq">&#xf1d6; fa-qq</option>
                            <option value="fa-qrcode">&#xf029; fa-qrcode</option>
                            <option value="fa-question">&#xf128; fa-question</option>
                            <option value="fa-question-circle">&#xf059; fa-question-circle</option>
                            <option value="fa-quote-left">&#xf10d; fa-quote-left</option>
                            <option value="fa-quote-right">&#xf10e; fa-quote-right</option>
                            <option value="fa-ra">&#xf1d0; fa-ra</option>
                            <option value="fa-random">&#xf074; fa-random</option>
                            <option value="fa-rebel">&#xf1d0; fa-rebel</option>
                            <option value="fa-recycle">&#xf1b8; fa-recycle</option>
                            <option value="fa-reddit">&#xf1a1; fa-reddit</option>
                            <option value="fa-reddit-square">&#xf1a2; fa-reddit-square</option>
                            <option value="fa-refresh">&#xf021; fa-refresh</option>
                            <option value="fa-registered">&#xf25d; fa-registered</option>
                            <option value="fa-remove">&#xf00d; fa-remove</option>
                            <option value="fa-renren">&#xf18b; fa-renren</option>
                            <option value="fa-reorder">&#xf0c9; fa-reorder</option>
                            <option value="fa-repeat">&#xf01e; fa-repeat</option>
                            <option value="fa-reply">&#xf112; fa-reply</option>
                            <option value="fa-reply-all">&#xf122; fa-reply-all</option>
                            <option value="fa-retweet">&#xf079; fa-retweet</option>
                            <option value="fa-rmb">&#xf157; fa-rmb</option>
                            <option value="fa-road">&#xf018; fa-road</option>
                            <option value="fa-rocket">&#xf135; fa-rocket</option>
                            <option value="fa-rotate-left">&#xf0e2; fa-rotate-left</option>
                            <option value="fa-rotate-right">&#xf01e; fa-rotate-right</option>
                            <option value="fa-rouble">&#xf158; fa-rouble</option>
                            <option value="fa-rss">&#xf09e; fa-rss</option>
                            <option value="fa-rss-square">&#xf143; fa-rss-square</option>
                            <option value="fa-rub">&#xf158; fa-rub</option>
                            <option value="fa-ruble">&#xf158; fa-ruble</option>
                            <option value="fa-rupee">&#xf156; fa-rupee</option>
                            <option value="fa-safari">&#xf267; fa-safari</option>
                            <option value="fa-sliders">&#xf1de; fa-sliders</option>
                            <option value="fa-slideshare">&#xf1e7; fa-slideshare</option>
                            <option value="fa-smile-o">&#xf118; fa-smile-o</option>
                            <option value="fa-sort-asc">&#xf0de; fa-sort-asc</option>
                            <option value="fa-sort-desc">&#xf0dd; fa-sort-desc</option>
                            <option value="fa-sort-down">&#xf0dd; fa-sort-down</option>
                            <option value="fa-spinner">&#xf110; fa-spinner</option>
                            <option value="fa-spoon">&#xf1b1; fa-spoon</option>
                            <option value="fa-spotify">&#xf1bc; fa-spotify</option>
                            <option value="fa-square">&#xf0c8; fa-square</option>
                            <option value="fa-square-o">&#xf096; fa-square-o</option>
                            <option value="fa-star">&#xf005; fa-star</option>
                            <option value="fa-star-half">&#xf089; fa-star-half</option>
                            <option value="fa-stop">&#xf04d; fa-stop</option>
                            <option value="fa-subscript">&#xf12c; fa-subscript</option>
                            <option value="fa-tablet">&#xf10a; fa-tablet</option>
                            <option value="fa-tachometer">&#xf0e4; fa-tachometer</option>
                            <option value="fa-tag">&#xf02b; fa-tag</option>
                            <option value="fa-tags">&#xf02c; fa-tags</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <div id="progress" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpann">Simpan</button>
                    </div>
                </form>
            </div>
            
            
        </div>
    </div>            
</div>
<!-- END MODAL BACKDROP DISABLE -->

<!-- MODAL MENU -->
<div class="modal fade" id="modal-backdrop-disable-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-info modal-lg" role="document">                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>

        <div class="modal-content">
            <div class="modal-header">                        
                <h4 class="modal-title" id="modal-info-header">Edit Data</h4>
            </div>
            <div class="modal-body">
               <form id="edit-sponsor" method="POST" action="" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input type="hidden" name="idbr" id="idbr">
                    <div class="form-group">
                        <label>Title Menu</label>
                        <select name="id_titile_menuedit" id="id_titile_menuedit" class="bs-select" data-live-search="true" >
                        </select>
                       
                    </div>
                    <div class="form-group">
                        <label>Menu Name</label>
                        
                        <input type="text" id="juduledit" name="juduledit" class="form-control"  placeholder="Role Name" >
                       
                    </div>

                    <div class="form-group">
                        <label>Icon</label>
                        <select name="iconedit" id="iconedit" class="form-control" data-live-search="true" style="font-weight: 900;font-size: 16px;">
                            <option value="fa-align-left">&#xf036; fa-align-left</option>
                            <option value="fa-align-right">&#xf038; fa-align-right</option>
                            <option value="fa-amazon">&#xf270; fa-amazon</option>
                            <option value="fa-ambulance">&#xf0f9; fa-ambulance</option>
                            <option value="fa-anchor">&#xf13d; fa-anchor</option>
                            <option value="fa-android">&#xf17b; fa-android</option>
                            <option value="fa-angellist">&#xf209; fa-angellist</option>
                            <option value="fa-angle-double-down">&#xf103; fa-angle-double-down</option>
                            <option value="fa-angle-double-left">&#xf100; fa-angle-double-left</option>
                            <option value="fa-angle-double-right">&#xf101; fa-angle-double-right</option>
                            <option value="fa-angle-double-up">&#xf102; fa-angle-double-up</option>
                            <option value="fa-angle-left">&#xf104; fa-angle-left</option>
                            <option value="fa-angle-right">&#xf105; fa-angle-right</option>
                            <option value="fa-angle-up">&#xf106; fa-angle-up</option>
                            <option value="fa-apple">&#xf179; fa-apple</option>
                            <option value="fa-archive">&#xf187; fa-archive</option>
                            <option value="fa-area-chart">&#xf1fe; fa-area-chart</option>
                            <option value="fa-arrow-circle-down">&#xf0ab; fa-arrow-circle-down</option>
                            <option value="fa-arrow-circle-left">&#xf0a8; fa-arrow-circle-left</option>
                            <option value="fa-arrow-circle-o-down">&#xf01a; fa-arrow-circle-o-down</option>
                            <option value="fa-arrow-circle-o-left">&#xf190; fa-arrow-circle-o-left</option>
                            <option value="fa-arrow-circle-o-right">&#xf18e; fa-arrow-circle-o-right</option>
                            <option value="fa-arrow-circle-o-up">&#xf01b; fa-arrow-circle-o-up</option>
                            <option value="fa-arrow-circle-right">&#xf0a9; fa-arrow-circle-right</option>
                            <option value="fa-arrow-circle-up">&#xf0aa; fa-arrow-circle-up</option>
                            <option value="fa-arrow-down">&#xf063; fa-arrow-down</option>
                            <option value="fa-arrow-left">&#xf060; fa-arrow-left</option>
                            <option value="fa-arrow-right">&#xf061; fa-arrow-right</option>
                            <option value="fa-arrow-up">&#xf062; fa-arrow-up</option>
                            <option value="fa-arrows">&#xf047; fa-arrows</option>
                            <option value="fa-arrows-alt">&#xf0b2; fa-arrows-alt</option>
                            <option value="fa-arrows-h">&#xf07e; fa-arrows-h</option>
                            <option value="fa-arrows-v">&#xf07d; fa-arrows-v</option>
                            <option value="fa-asterisk">&#xf069; fa-asterisk</option>
                            <option value="fa-at">&#xf1fa; fa-at</option>
                            <option value="fa-automobile">&#xf1b9; fa-automobile</option>
                            <option value="fa-backward">&#xf04a; fa-backward</option>
                            <option value="fa-balance-scale">&#xf24e; fa-balance-scale</option>
                            <option value="fa-ban">&#xf05e; fa-ban</option>
                            <option value="fa-bank">&#xf19c; fa-bank</option>
                            <option value="fa-bar-chart">&#xf080; fa-bar-chart</option>
                            <option value="fa-bar-chart-o">&#xf080; fa-bar-chart-o</option>

                            <option value="fa-battery-full">&#xf240; fa-battery-full</option>
                            n value="fa-beer">&#xf0fc; fa-beer</option>
                            <option value="fa-behance">&#xf1b4; fa-behance</option>
                            <option value="fa-behance-square">&#xf1b5; fa-behance-square</option>
                            <option value="fa-bell">&#xf0f3; fa-bell</option>
                            <option value="fa-bell-o">&#xf0a2; fa-bell-o</option>
                            <option value="fa-bell-slash">&#xf1f6; fa-bell-slash</option>
                            <option value="fa-bell-slash-o">&#xf1f7; fa-bell-slash-o</option>
                            <option value="fa-bicycle">&#xf206; fa-bicycle</option>
                            <option value="fa-binoculars">&#xf1e5; fa-binoculars</option>
                            <option value="fa-birthday-cake">&#xf1fd; fa-birthday-cake</option>
                            <option value="fa-bitbucket">&#xf171; fa-bitbucket</option>
                            <option value="fa-bitbucket-square">&#xf172; fa-bitbucket-square</option>
                            <option value="fa-bitcoin">&#xf15a; fa-bitcoin</option>
                            <option value="fa-black-tie">&#xf27e; fa-black-tie</option>
                            <option value="fa-bold">&#xf032; fa-bold</option>
                            <option value="fa-bolt">&#xf0e7; fa-bolt</option>
                            <option value="fa-bomb">&#xf1e2; fa-bomb</option>
                            <option value="fa-book">&#xf02d; fa-book</option>
                            <option value="fa-bookmark">&#xf02e; fa-bookmark</option>
                            <option value="fa-bookmark-o">&#xf097; fa-bookmark-o</option>
                            <option value="fa-briefcase">&#xf0b1; fa-briefcase</option>
                            <option value="fa-btc">&#xf15a; fa-btc</option>
                            <option value="fa-bug">&#xf188; fa-bug</option>
                            <option value="fa-building">&#xf1ad; fa-building</option>
                            <option value="fa-building-o">&#xf0f7; fa-building-o</option>
                            <option value="fa-bullhorn">&#xf0a1; fa-bullhorn</option>
                            <option value="fa-bullseye">&#xf140; fa-bullseye</option>
                            <option value="fa-bus">&#xf207; fa-bus</option>
                            <option value="fa-cab">&#xf1ba; fa-cab</option>
                            <option value="fa-calendar">&#xf073; fa-calendar</option>
                            <option value="fa-camera">&#xf030; fa-camera</option>
                            <option value="fa-car">&#xf1b9; fa-car</option>
                            <option value="fa-caret-up">&#xf0d8; fa-caret-up</option>
                            <option value="fa-cart-plus">&#xf217; fa-cart-plus</option>
                            <option value="fa-cc">&#xf20a; fa-cc</option>
                            <option value="fa-cc-amex">&#xf1f3; fa-cc-amex</option>
                            <option value="fa-cc-jcb">&#xf24b; fa-cc-jcb</option>
                            <option value="fa-cc-paypal">&#xf1f4; fa-cc-paypal</option>
                            <option value="fa-cc-stripe">&#xf1f5; fa-cc-stripe</option>
                            <option value="fa-cc-visa">&#xf1f0; fa-cc-visa</option>
                            <option value="fa-chain">&#xf0c1; fa-chain</option>
                            <option value="fa-check">&#xf00c; fa-check</option>
                            <option value="fa-chevron-left">&#xf053; fa-chevron-left</option>
                            <option value="fa-chevron-right">&#xf054; fa-chevron-right</option>
                            <option value="fa-chevron-up">&#xf077; fa-chevron-up</option>
                            <option value="fa-child">&#xf1ae; fa-child</option>
                            <option value="fa-chrome">&#xf268; fa-chrome</option>
                            <option value="fa-circle">&#xf111; fa-circle</option>
                            <option value="fa-circle-o">&#xf10c; fa-circle-o</option>
                            <option value="fa-circle-o-notch">&#xf1ce; fa-circle-o-notch</option>
                            <option value="fa-circle-thin">&#xf1db; fa-circle-thin</option>
                            <option value="fa-clipboard">&#xf0ea; fa-clipboard</option>
                            <option value="fa-clock-o">&#xf017; fa-clock-o</option>
                            <option value="fa-clone">&#xf24d; fa-clone</option>
                            <option value="fa-close">&#xf00d; fa-close</option>
                            <option value="fa-cloud">&#xf0c2; fa-cloud</option>
                            <option value="fa-cloud-download">&#xf0ed; fa-cloud-download</option>
                            <option value="fa-cloud-upload">&#xf0ee; fa-cloud-upload</option>
                            <option value="fa-cny">&#xf157; fa-cny</option>
                            <option value="fa-code">&#xf121; fa-code</option>
                            <option value="fa-code-fork">&#xf126; fa-code-fork</option>
                            <option value="fa-codepen">&#xf1cb; fa-codepen</option>
                            <option value="fa-coffee">&#xf0f4; fa-coffee</option>
                            <option value="fa-cog">&#xf013; fa-cog</option>
                            <option value="fa-cogs">&#xf085; fa-cogs</option>
                            <option value="fa-columns">&#xf0db; fa-columns</option>
                            <option value="fa-comment">&#xf075; fa-comment</option>
                            <option value="fa-comment-o">&#xf0e5; fa-comment-o</option>
                            <option value="fa-commenting">&#xf27a; fa-commenting</option>
                            <option value="fa-commenting-o">&#xf27b; fa-commenting-o</option>
                            <option value="fa-comments">&#xf086; fa-comments</option>
                            <option value="fa-comments-o">&#xf0e6; fa-comments-o</option>
                            <option value="fa-compass">&#xf14e; fa-compass</option>
                            <option value="fa-compress">&#xf066; fa-compress</option>
                            <option value="fa-connectdevelop">&#xf20e; fa-connectdevelop</option>
                            <option value="fa-contao">&#xf26d; fa-contao</option>
                            <option value="fa-copy">&#xf0c5; fa-copy</option>
                            <option value="fa-copyright">&#xf1f9; fa-copyright</option>
                            <option value="fa-creative-commons">&#xf25e; fa-creative-commons</option>
                            <option value="fa-credit-card">&#xf09d; fa-credit-card</option>
                            <option value="fa-crop">&#xf125; fa-crop</option>
                            <option value="fa-crosshairs">&#xf05b; fa-crosshairs</option>
                            <option value="fa-css3">&#xf13c; fa-css3</option>
                            <option value="fa-cube">&#xf1b2; fa-cube</option>
                            <option value="fa-cubes">&#xf1b3; fa-cubes</option>
                            <option value="fa-cut">&#xf0c4; fa-cut</option>
                            <option value="fa-cutlery">&#xf0f5; fa-cutlery</option>
                            <option value="fa-dashboard">&#xf0e4; fa-dashboard</option>
                            <option value="fa-dashcube">&#xf210; fa-dashcube</option>
                            <option value="fa-database">&#xf1c0; fa-database</option>
                            <option value="fa-dedent">&#xf03b; fa-dedent</option>
                            <option value="fa-delicious">&#xf1a5; fa-delicious</option>
                            <option value="fa-desktop">&#xf108; fa-desktop</option>
                            <option value="fa-deviantart">&#xf1bd; fa-deviantart</option>
                            <option value="fa-diamond">&#xf219; fa-diamond</option>
                            <option value="fa-digg">&#xf1a6; fa-digg</option>
                            <option value="fa-dollar">&#xf155; fa-dollar</option>
                            <option value="fa-download">&#xf019; fa-download</option>
                            <option value="fa-dribbble">&#xf17d; fa-dribbble</option>
                            <option value="fa-dropbox">&#xf16b; fa-dropbox</option>
                            <option value="fa-drupal">&#xf1a9; fa-drupal</option>
                            <option value="fa-edit">&#xf044; fa-edit</option>
                            <option value="fa-eject">&#xf052; fa-eject</option>
                            <option value="fa-ellipsis-h">&#xf141; fa-ellipsis-h</option>
                            <option value="fa-ellipsis-v">&#xf142; fa-ellipsis-v</option>
                            <option value="fa-empire">&#xf1d1; fa-empire</option>
                            <option value="fa-envelope">&#xf0e0; fa-envelope</option>
                            <option value="fa-envelope-o">&#xf003; fa-envelope-o</option>
                            <option value="fa-eur">&#xf153; fa-eur</option>
                            <option value="fa-euro">&#xf153; fa-euro</option>
                            <option value="fa-exchange">&#xf0ec; fa-exchange</option>
                            <option value="fa-exclamation">&#xf12a; fa-exclamation</option>
                            <option value="fa-exclamation-circle">&#xf06a; fa-exclamation-circle</option>
                            <option value="fa-exclamation-triangle">&#xf071; fa-exclamation-triangle</option>
                            <option value="fa-expand">&#xf065; fa-expand</option>
                            <option value="fa-expeditedssl">&#xf23e; fa-expeditedssl</option>
                            <option value="fa-external-link">&#xf08e; fa-external-link</option>
                            <option value="fa-external-link-square">&#xf14c; fa-external-link-square</option>
                            <option value="fa-eye">&#xf06e; fa-eye</option>
                            <option value="fa-eye-slash">&#xf070; fa-eye-slash</option>
                            <option value="fa-eyedropper">&#xf1fb; fa-eyedropper</option>
                            <option value="fa-facebook">&#xf09a; fa-facebook</option>
                            <option value="fa-facebook-f">&#xf09a; fa-facebook-f</option>
                            <option value="fa-facebook-official">&#xf230; fa-facebook-official</option>
                            <option value="fa-facebook-square">&#xf082; fa-facebook-square</option>
                            <option value="fa-fast-backward">&#xf049; fa-fast-backward</option>
                            <option value="fa-fast-forward">&#xf050; fa-fast-forward</option>
                            <option value="fa-fax">&#xf1ac; fa-fax</option>
                            <option value="fa-feed">&#xf09e; fa-feed</option>
                            <option value="fa-female">&#xf182; fa-female</option>
                            <option value="fa-fighter-jet">&#xf0fb; fa-fighter-jet</option>
                            <option value="fa-file">&#xf15b; fa-file</option>
                            <option value="fa-file-archive-o">&#xf1c6; fa-file-archive-o</option>
                            <option value="fa-file-audio-o">&#xf1c7; fa-file-audio-o</option>
                            <option value="fa-file-code-o">&#xf1c9; fa-file-code-o</option>
                            <option value="fa-file-excel-o">&#xf1c3; fa-file-excel-o</option>
                            <option value="fa-file-image-o">&#xf1c5; fa-file-image-o</option>
                            <option value="fa-file-movie-o">&#xf1c8; fa-file-movie-o</option>
                            <option value="fa-file-o">&#xf016; fa-file-o</option>
                            <option value="fa-file-pdf-o">&#xf1c1; fa-file-pdf-o</option>
                            <option value="fa-file-photo-o">&#xf1c5; fa-file-photo-o</option>
                            <option value="fa-file-picture-o">&#xf1c5; fa-file-picture-o</option>
                            <option value="fa-file-powerpoint-o">&#xf1c4; fa-file-powerpoint-o</option>
                            <option value="fa-file-sound-o">&#xf1c7; fa-file-sound-o</option>
                            <option value="fa-file-text">&#xf15c; fa-file-text</option>
                            <option value="fa-file-text-o">&#xf0f6; fa-file-text-o</option>
                            <option value="fa-file-video-o">&#xf1c8; fa-file-video-o</option>
                            <option value="fa-file-word-o">&#xf1c2; fa-file-word-o</option>
                            <option value="fa-file-zip-o">&#xf1c6; fa-file-zip-o</option>
                            <option value="fa-files-o">&#xf0c5; fa-files-o</option>
                            <option value="fa-film">&#xf008; fa-film</option>
                            <option value="fa-filter">&#xf0b0; fa-filter</option>
                            <option value="fa-fire">&#xf06d; fa-fire</option>
                            <option value="fa-fire-extinguisher">&#xf134; fa-fire-extinguisher</option>
                            <option value="fa-firefox">&#xf269; fa-firefox</option>
                            <option value="fa-flag">&#xf024; fa-flag</option>
                            <option value="fa-flag-checkered">&#xf11e; fa-flag-checkered</option>
                            <option value="fa-flag-o">&#xf11d; fa-flag-o</option>
                            <option value="fa-flash">&#xf0e7; fa-flash</option>
                            <option value="fa-flask">&#xf0c3; fa-flask</option>
                            <option value="fa-flickr">&#xf16e; fa-flickr</option>
                            <option value="fa-floppy-o">&#xf0c7; fa-floppy-o</option>
                            <option value="fa-folder">&#xf07b; fa-folder</option>
                            <option value="fa-folder-o">&#xf114; fa-folder-o</option>
                            <option value="fa-folder-open">&#xf07c; fa-folder-open</option>
                            <option value="fa-folder-open-o">&#xf115; fa-folder-open-o</option>
                            <option value="fa-font">&#xf031; fa-font</option>
                            <option value="fa-fonticons">&#xf280; fa-fonticons</option>
                            <option value="fa-forumbee">&#xf211; fa-forumbee</option>
                            <option value="fa-forward">&#xf04e; fa-forward</option>
                            <option value="fa-foursquare">&#xf180; fa-foursquare</option>
                            <option value="fa-frown-o">&#xf119; fa-frown-o</option>
                            <option value="fa-futbol-o">&#xf1e3; fa-futbol-o</option>
                            <option value="fa-gamepad">&#xf11b; fa-gamepad</option>
                            <option value="fa-gavel">&#xf0e3; fa-gavel</option>
                            <option value="fa-gbp">&#xf154; fa-gbp</option>
                            <option value="fa-ge">&#xf1d1; fa-ge</option>
                            <option value="fa-gear">&#xf013; fa-gear</option>
                            <option value="fa-gears">&#xf085; fa-gears</option>
                            <option value="fa-genderless">&#xf22d; fa-genderless</option>
                            <option value="fa-get-pocket">&#xf265; fa-get-pocket</option>
                            <option value="fa-gg">&#xf260; fa-gg</option>
                            <option value="fa-gg-circle">&#xf261; fa-gg-circle</option>
                            <option value="fa-gift">&#xf06b; fa-gift</option>
                            <option value="fa-git">&#xf1d3; fa-git</option>
                            <option value="fa-git-square">&#xf1d2; fa-git-square</option>
                            <option value="fa-github">&#xf09b; fa-github</option>
                            <option value="fa-github-alt">&#xf113; fa-github-alt</option>
                            <option value="fa-github-square">&#xf092; fa-github-square</option>
                            <option value="fa-gittip">&#xf184; fa-gittip</option>
                            <option value="fa-glass">&#xf000; fa-glass</option>
                            <option value="fa-globe">&#xf0ac; fa-globe</option>
                            <option value="fa-google">&#xf1a0; fa-google</option>
                            <option value="fa-google-plus">&#xf0d5; fa-google-plus</option>
                            <option value="fa-google-plus-square">&#xf0d4; fa-google-plus-square</option>
                            <option value="fa-google-wallet">&#xf1ee; fa-google-wallet</option>
                            <option value="fa-graduation-cap">&#xf19d; fa-graduation-cap</option>
                            <option value="fa-gratipay">&#xf184; fa-gratipay</option>
                            <option value="fa-group">&#xf0c0; fa-group</option>
                            <option value="fa-h-square">&#xf0fd; fa-h-square</option>
                            <option value="fa-hacker-news">&#xf1d4; fa-hacker-news</option>
                            <option value="fa-hand-grab-o">&#xf255; fa-hand-grab-o</option>
                            <option value="fa-hand-lizard-o">&#xf258; fa-hand-lizard-o</option>
                            <option value="fa-hand-o-down">&#xf0a7; fa-hand-o-down</option>
                            <option value="fa-hand-o-left">&#xf0a5; fa-hand-o-left</option>
                            <option value="fa-hand-o-right">&#xf0a4; fa-hand-o-right</option>
                            <option value="fa-hand-o-up">&#xf0a6; fa-hand-o-up</option>
                            <option value="fa-hand-paper-o">&#xf256; fa-hand-paper-o</option>
                            <option value="fa-hand-peace-o">&#xf25b; fa-hand-peace-o</option>
                            <option value="fa-hand-pointer-o">&#xf25a; fa-hand-pointer-o</option>
                            <option value="fa-hand-rock-o">&#xf255; fa-hand-rock-o</option>
                            <option value="fa-hand-scissors-o">&#xf257; fa-hand-scissors-o</option>
                            <option value="fa-hand-spock-o">&#xf259; fa-hand-spock-o</option>
                            <option value="fa-hand-stop-o">&#xf256; fa-hand-stop-o</option>
                            <option value="fa-hdd-o">&#xf0a0; fa-hdd-o</option>
                            <option value="fa-header">&#xf1dc; fa-header</option>
                            <option value="fa-headphones">&#xf025; fa-headphones</option>
                            <option value="fa-heart">&#xf004; fa-heart</option>
                            <option value="fa-heart-o">&#xf08a; fa-heart-o</option>
                            <option value="fa-heartbeat">&#xf21e; fa-heartbeat</option>
                            <option value="fa-history">&#xf1da; fa-history</option>
                            <option value="fa-home">&#xf015; fa-home</option>
                            <option value="fa-hospital-o">&#xf0f8; fa-hospital-o</option>
                            <option value="fa-hotel">&#xf236; fa-hotel</option>
                            <option value="fa-hourglass">&#xf254; fa-hourglass</option>
                            <option value="fa-hourglass-1">&#xf251; fa-hourglass-1</option>
                            <option value="fa-hourglass-2">&#xf252; fa-hourglass-2</option>
                            <option value="fa-hourglass-3">&#xf253; fa-hourglass-3</option>
                            <option value="fa-hourglass-end">&#xf253; fa-hourglass-end</option>
                            <option value="fa-hourglass-half">&#xf252; fa-hourglass-half</option>
                            <option value="fa-hourglass-o">&#xf250; fa-hourglass-o</option>
                            <option value="fa-hourglass-start">&#xf251; fa-hourglass-start</option>
                            <option value="fa-houzz">&#xf27c; fa-houzz</option>
                            <option value="fa-html5">&#xf13b; fa-html5</option>
                            <option value="fa-i-cursor">&#xf246; fa-i-cursor</option>
                            <option value="fa-ils">&#xf20b; fa-ils</option>
                            <option value="fa-image">&#xf03e; fa-image</option>
                            <option value="fa-inbox">&#xf01c; fa-inbox</option>
                            <option value="fa-indent">&#xf03c; fa-indent</option>
                            <option value="fa-industry">&#xf275; fa-industry</option>
                            <option value="fa-info">&#xf129; fa-info</option>
                            <option value="fa-info-circle">&#xf05a; fa-info-circle</option>
                            <option value="fa-inr">&#xf156; fa-inr</option>
                            <option value="fa-instagram">&#xf16d; fa-instagram</option>
                            <option value="fa-institution">&#xf19c; fa-institution</option>
                            <option value="fa-internet-explorer">&#xf26b; fa-internet-explorer</option>
                            <option value="fa-intersex">&#xf224; fa-intersex</option>
                            <option value="fa-ioxhost">&#xf208; fa-ioxhost</option>
                            <option value="fa-italic">&#xf033; fa-italic</option>
                            <option value="fa-joomla">&#xf1aa; fa-joomla</option>
                            <option value="fa-jpy">&#xf157; fa-jpy</option>
                            <option value="fa-jsfiddle">&#xf1cc; fa-jsfiddle</option>
                            <option value="fa-key">&#xf084; fa-key</option>
                            <option value="fa-keyboard-o">&#xf11c; fa-keyboard-o</option>
                            <option value="fa-krw">&#xf159; fa-krw</option>
                            <option value="fa-language">&#xf1ab; fa-language</option>
                            <option value="fa-laptop">&#xf109; fa-laptop</option>
                            <option value="fa-lastfm">&#xf202; fa-lastfm</option>
                            <option value="fa-lastfm-square">&#xf203; fa-lastfm-square</option>
                            <option value="fa-leaf">&#xf06c; fa-leaf</option>
                            <option value="fa-leanpub">&#xf212; fa-leanpub</option>
                            <option value="fa-legal">&#xf0e3; fa-legal</option>
                            <option value="fa-lemon-o">&#xf094; fa-lemon-o</option>
                            <option value="fa-level-down">&#xf149; fa-level-down</option>
                            <option value="fa-level-up">&#xf148; fa-level-up</option>
                            <option value="fa-life-bouy">&#xf1cd; fa-life-bouy</option>
                            <option value="fa-life-buoy">&#xf1cd; fa-life-buoy</option>
                            <option value="fa-life-ring">&#xf1cd; fa-life-ring</option>
                            <option value="fa-life-saver">&#xf1cd; fa-life-saver</option>
                            <option value="fa-lightbulb-o">&#xf0eb; fa-lightbulb-o</option>
                            <option value="fa-line-chart">&#xf201; fa-line-chart</option>
                            <option value="fa-link">&#xf0c1; fa-link</option>
                            <option value="fa-linkedin">&#xf0e1; fa-linkedin</option>
                            <option value="fa-linkedin-square">&#xf08c; fa-linkedin-square</option>
                            <option value="fa-linux">&#xf17c; fa-linux</option>
                            <option value="fa-list">&#xf03a; fa-list</option>
                            <option value="fa-list-alt">&#xf022; fa-list-alt</option>
                            <option value="fa-list-ol">&#xf0cb; fa-list-ol</option>
                            <option value="fa-list-ul">&#xf0ca; fa-list-ul</option>
                            <option value="fa-location-arrow">&#xf124; fa-location-arrow</option>
                            <option value="fa-lock">&#xf023; fa-lock</option>
                            <option value="fa-long-arrow-down">&#xf175; fa-long-arrow-down</option>
                            <option value="fa-long-arrow-left">&#xf177; fa-long-arrow-left</option>
                            <option value="fa-long-arrow-right">&#xf178; fa-long-arrow-right</option>
                            <option value="fa-long-arrow-up">&#xf176; fa-long-arrow-up</option>
                            <option value="fa-magic">&#xf0d0; fa-magic</option>
                            <option value="fa-magnet">&#xf076; fa-magnet</option>

                            <option value="fa-mars-stroke-v">&#xf22a; fa-mars-stroke-v</option>
                            <option value="fa-maxcdn">&#xf136; fa-maxcdn</option>
                            <option value="fa-meanpath">&#xf20c; fa-meanpath</option>
                            <option value="fa-medium">&#xf23a; fa-medium</option>
                            <option value="fa-medkit">&#xf0fa; fa-medkit</option>
                            <option value="fa-meh-o">&#xf11a; fa-meh-o</option>
                            <option value="fa-mercury">&#xf223; fa-mercury</option>
                            <option value="fa-microphone">&#xf130; fa-microphone</option>
                            <option value="fa-mobile">&#xf10b; fa-mobile</option>
                            <option value="fa-motorcycle">&#xf21c; fa-motorcycle</option>
                            <option value="fa-mouse-pointer">&#xf245; fa-mouse-pointer</option>
                            <option value="fa-music">&#xf001; fa-music</option>
                            <option value="fa-navicon">&#xf0c9; fa-navicon</option>
                            <option value="fa-neuter">&#xf22c; fa-neuter</option>
                            <option value="fa-newspaper-o">&#xf1ea; fa-newspaper-o</option>
                            <option value="fa-opencart">&#xf23d; fa-opencart</option>
                            <option value="fa-openid">&#xf19b; fa-openid</option>
                            <option value="fa-opera">&#xf26a; fa-opera</option>
                            <option value="fa-outdent">&#xf03b; fa-outdent</option>
                            <option value="fa-pagelines">&#xf18c; fa-pagelines</option>
                            <option value="fa-paper-plane-o">&#xf1d9; fa-paper-plane-o</option>
                            <option value="fa-paperclip">&#xf0c6; fa-paperclip</option>
                            <option value="fa-paragraph">&#xf1dd; fa-paragraph</option>
                            <option value="fa-paste">&#xf0ea; fa-paste</option>
                            <option value="fa-pause">&#xf04c; fa-pause</option>
                            <option value="fa-paw">&#xf1b0; fa-paw</option>
                            <option value="fa-paypal">&#xf1ed; fa-paypal</option>
                            <option value="fa-pencil">&#xf040; fa-pencil</option>
                            <option value="fa-pencil-square-o">&#xf044; fa-pencil-square-o</option>
                            <option value="fa-phone">&#xf095; fa-phone</option>
                            <option value="fa-photo">&#xf03e; fa-photo</option>
                            <option value="fa-picture-o">&#xf03e; fa-picture-o</option>
                            <option value="fa-pie-chart">&#xf200; fa-pie-chart</option>
                            <option value="fa-pied-piper">&#xf1a7; fa-pied-piper</option>
                            <option value="fa-pied-piper-alt">&#xf1a8; fa-pied-piper-alt</option>
                            <option value="fa-pinterest">&#xf0d2; fa-pinterest</option>
                            <option value="fa-pinterest-p">&#xf231; fa-pinterest-p</option>
                            <option value="fa-pinterest-square">&#xf0d3; fa-pinterest-square</option>
                            <option value="fa-plane">&#xf072; fa-plane</option>
                            <option value="fa-play">&#xf04b; fa-play</option>
                            <option value="fa-play-circle">&#xf144; fa-play-circle</option>
                            <option value="fa-play-circle-o">&#xf01d; fa-play-circle-o</option>
                            <option value="fa-plug">&#xf1e6; fa-plug</option>
                            <option value="fa-plus">&#xf067; fa-plus</option>
                            <option value="fa-plus-circle">&#xf055; fa-plus-circle</option>
                            <option value="fa-plus-square">&#xf0fe; fa-plus-square</option>
                            <option value="fa-plus-square-o">&#xf196; fa-plus-square-o</option>
                            <option value="fa-power-off">&#xf011; fa-power-off</option>
                            <option value="fa-print">&#xf02f; fa-print</option>
                            <option value="fa-puzzle-piece">&#xf12e; fa-puzzle-piece</option>
                            <option value="fa-qq">&#xf1d6; fa-qq</option>
                            <option value="fa-qrcode">&#xf029; fa-qrcode</option>
                            <option value="fa-question">&#xf128; fa-question</option>
                            <option value="fa-question-circle">&#xf059; fa-question-circle</option>
                            <option value="fa-quote-left">&#xf10d; fa-quote-left</option>
                            <option value="fa-quote-right">&#xf10e; fa-quote-right</option>
                            <option value="fa-ra">&#xf1d0; fa-ra</option>
                            <option value="fa-random">&#xf074; fa-random</option>
                            <option value="fa-rebel">&#xf1d0; fa-rebel</option>
                            <option value="fa-recycle">&#xf1b8; fa-recycle</option>
                            <option value="fa-reddit">&#xf1a1; fa-reddit</option>
                            <option value="fa-reddit-square">&#xf1a2; fa-reddit-square</option>
                            <option value="fa-refresh">&#xf021; fa-refresh</option>
                            <option value="fa-registered">&#xf25d; fa-registered</option>
                            <option value="fa-remove">&#xf00d; fa-remove</option>
                            <option value="fa-renren">&#xf18b; fa-renren</option>
                            <option value="fa-reorder">&#xf0c9; fa-reorder</option>
                            <option value="fa-repeat">&#xf01e; fa-repeat</option>
                            <option value="fa-reply">&#xf112; fa-reply</option>
                            <option value="fa-reply-all">&#xf122; fa-reply-all</option>
                            <option value="fa-retweet">&#xf079; fa-retweet</option>
                            <option value="fa-rmb">&#xf157; fa-rmb</option>
                            <option value="fa-road">&#xf018; fa-road</option>
                            <option value="fa-rocket">&#xf135; fa-rocket</option>
                            <option value="fa-rotate-left">&#xf0e2; fa-rotate-left</option>
                            <option value="fa-rotate-right">&#xf01e; fa-rotate-right</option>
                            <option value="fa-rouble">&#xf158; fa-rouble</option>
                            <option value="fa-rss">&#xf09e; fa-rss</option>
                            <option value="fa-rss-square">&#xf143; fa-rss-square</option>
                            <option value="fa-rub">&#xf158; fa-rub</option>
                            <option value="fa-ruble">&#xf158; fa-ruble</option>
                            <option value="fa-rupee">&#xf156; fa-rupee</option>
                            <option value="fa-safari">&#xf267; fa-safari</option>
                            <option value="fa-sliders">&#xf1de; fa-sliders</option>
                            <option value="fa-slideshare">&#xf1e7; fa-slideshare</option>
                            <option value="fa-smile-o">&#xf118; fa-smile-o</option>
                            <option value="fa-sort-asc">&#xf0de; fa-sort-asc</option>
                            <option value="fa-sort-desc">&#xf0dd; fa-sort-desc</option>
                            <option value="fa-sort-down">&#xf0dd; fa-sort-down</option>
                            <option value="fa-spinner">&#xf110; fa-spinner</option>
                            <option value="fa-spoon">&#xf1b1; fa-spoon</option>
                            <option value="fa-spotify">&#xf1bc; fa-spotify</option>
                            <option value="fa-square">&#xf0c8; fa-square</option>
                            <option value="fa-square-o">&#xf096; fa-square-o</option>
                            <option value="fa-star">&#xf005; fa-star</option>
                            <option value="fa-star-half">&#xf089; fa-star-half</option>
                            <option value="fa-stop">&#xf04d; fa-stop</option>
                            <option value="fa-subscript">&#xf12c; fa-subscript</option>
                            <option value="fa-tablet">&#xf10a; fa-tablet</option>
                            <option value="fa-tachometer">&#xf0e4; fa-tachometer</option>
                            <option value="fa-tag">&#xf02b; fa-tag</option>
                            <option value="fa-tags">&#xf02c; fa-tags</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <div id="progress2" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="simpaneditt">Simpan</button>
                    </div>
                </form>
            </div>
            
            
        </div>
    </div>            
</div>
<!-- END MODAL BACKDROP DISABLE -->



<script type="text/javascript">
     $(document).on("mouseenter",".popover-hover",function(){             
            $(this).popover('show');
        }).on("mouseleave",".popover-hover",function(){
            $(this).popover('hide');
        });

	var table,table2;
   
    function resetForm() {
        $('#id').val('');
        $('#idtitle').val('');
        $('#judul').val('');
        $('#judultitle').val('');
        $('#id_titile_menu').val('');
        $('#icon').val('');
        $('#modal-backdrop-disable').modal('hide');
        $('#modal-backdrop-disable-titlemenuadd').modal('hide');
        $('#progress').hide();
        $('#progresstitlemenu').hide();

         $('#idbr').val('');
         $('#idbrtitle').val('');
        $('#juduledit').val('');
        $('#juduledittitle').val('');
        $('#id_titile_menuedit').val('');
        $('#iconedit').val('');
        $('#modal-backdrop-disable-edit').modal('hide');
        $('#modal-backdrop-disable-titlemenuedit').modal('hide');
        $('#progress2').hide();
        $('#progresstitlemenuedit').hide();
    }
    
    ////////////////////TITLE MENU
    function loaddatatitle(){
       table = $('#titlemenu').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paging":   false,
            "ordering": false,
            "info":     false,
            "bFilter": false,
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/data_menutitle')}}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
           
            "language": {
                "url": "{{ asset('admins/js/vendor/datatables/language/Indonesia.json') }}"
            },
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 0 },
            ],
            "columns": [
                { data:  'no'  },
                { data:  'menu'  },
                  { data: null, render: function ( data, type, row ) {
                return '<div class="text">\n\
                            <button  class="btn btn-sm btn-default popover-hover edit_modaltitle" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-edit" data-backdrop="static" data-placement="left" data-content="Edit"><i class="fa fa-pencil"></i> </button>\n\
                            <button class="btn btn-sm btn-default popover-hover delete_btntitle" a="'+data['id']+'" b="'+data['menu']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
                        </div>';
            } }
                 
                 
            ]
      
        });
    }

    /////////////////////MENU
    function loaddata(){
       table2 = $('#sponsor').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "autoWidth": true, 
            "paginationType": "full_numbers",
            "aLengthMenu": [ [5, 20, 50, 100], [5, 20, 50, 100] ],
            "iDisplayLength": 5, 
            "autoWidth": true,
            "ajax":{
                "url": "{{url('/data_menu')}}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
           
            "language": {
                "url": "{{ asset('admins/js/vendor/datatables/language/Indonesia.json') }}"
            },
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 0 },
            ],
            "columns": [
                { data:  'no'  },
                { data:  'titlemenu'  },
                { data:  'menu'  },
                { data:  'icon'  },
                  { data: null, render: function ( data, type, row ) {
				return '<div class="text">\n\
                            <button  class="btn btn-default popover-hover edit_modal" data-id="'+data['id']+'" value="'+data['id']+'" a="'+data['id']+'" data-toggle="tooltip modal" data-target="#modal-backdrop-disable-edit" data-backdrop="static" data-placement="left" data-content="Edit"><i class="fa fa-pencil"></i> </button>\n\
                            <button class="btn btn-default popover-hover delete_btn" a="'+data['id']+'" b="'+data['menu']+'" data-container="body" data-toggle="tooltip" data-placement="left" data-content="Hapus"><i class="fa fa-remove"></i></button>\n\
						</div>';
			} }
                 
                 
            ]
      
        });
    }

    ///////////////////TITLE MENU
     $('#input-title').validate({
            // Rules for form validation
            rules: {
                judultitle: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                judultitle: {
                    required: "Nama Menu Tidak Boleh Kosong"
                }
            },

            // Error Placement
            errorPlacement: function(error, element)
            {
                error.insertAfter(element.parent('div').addClass('has-error'));

            },

            //Submit the form
            submitHandler: function (form) {
                var formData = new FormData(form);
                $('#progresstitlemenu').width('0%');
                $('#progresstitlemenu').show();

                $.ajax({
                    type: "POST",
                    url: "{{ url('/tambahmenutitleaksi') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progresstitlemenu", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#progresstitlemenu').width(percentComplete+'%');
                            }
                        }, false);

                        return xhr;
                    },
                    error: function (e) {
                        new Noty({
                            type: 'error',
                            text: 'Response error ' + e,
                            timeout: 4000,
                        }).show();
                    },
                    success: function (result) {
                        if(result['status'] == 'success')
                        {
                            new Noty({
                                type: 'success',
                                text: result['msg'],
                                timeout: 4000,
                                layout: 'topRight',
                                theme: 'nest',
                            }).show();

                            // resetForm();
                            // table.draw();
                            window.location.href = '{{url('/menu')}}';
                        }
                        else
                        {
                            new Noty({
                                type: 'error',
                                text: result['msg'],
                                timeout: 4000,
                                layout: 'topRight',
                                theme: 'nest',
                            }).show();

                            $("#progresstitlemenu").hide();
                        }
                    }
                });
                return false;
            }
        });


    ///////////////////MENU
     $('#input-sport').validate({
            // Rules for form validation
            rules: {
                judul: {
                    required: true
                },
                icon: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                judul: {
                    required: "Nama Menu Tidak Boleh Kosong"
                }
            },

            // Error Placement
            errorPlacement: function(error, element)
            {
                error.insertAfter(element.parent('div').addClass('has-error'));

            },

            //Submit the form
            submitHandler: function (form) {
                var formData = new FormData(form);
                $('#progress').width('0%');
                $('#progress').show();

                $.ajax({
                    type: "POST",
                    url: "{{ url('/tambahmenuaksi') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('#progress').width(percentComplete+'%');
                            }
                        }, false);

                        return xhr;
                    },
                    error: function (e) {
                        new Noty({
                            type: 'error',
                            text: 'Response error ' + e,
                            timeout: 4000,
                        }).show();
                    },
                    success: function (result) {
                        if(result['status'] == 'success')
                        {
                            new Noty({
                                type: 'success',
                                text: result['msg'],
                                timeout: 4000,
                                layout: 'topRight',
                                theme: 'nest',
                            }).show();

                            resetForm();
                            table2.draw();
                        }
                        else
                        {
                            new Noty({
                                type: 'error',
                                text: result['msg'],
                                timeout: 4000,
                                layout: 'topRight',
                                theme: 'nest',
                            }).show();

                            $("#progress").hide();
                        }
                    }
                });
                return false;
            }
        });

     /////////////////TITLE MENU
     $(document).on("click", ".edit_modaltitle", function (){

          var id = $(this).val();

        $.get('{{ url("/editmenutitleview")}}' + '/' + id, function (data) {
            $('#idbrtitle').val(data.data.id);
            $('#juduledittitle').val(data.data.menu);
            
            $('#modal-backdrop-disable-titlemenuedit').modal('show');

            $("#progresstitlemenuedit").hide();
        })
    });

     /////////////////MENU
    $(document).on("click", ".edit_modal", function (){

          var id = $(this).val();

        $.get('{{ url("/editmenuview")}}' + '/' + id, function (data) {
            $('#idbr').val(data.data.id);
            $('#juduledit').val(data.data.menu);
            $("#id_titile_menuedit").html('');
            $('#id_titile_menuedit').append(data.sbb).selectpicker('refresh');

            $("#iconedit").empty();
            $('#iconedit').append(data.icc).trigger('change');
            
            $('#modal-backdrop-disable-edit').modal('show');

            $("#progress2").hide();
        })
    });


    $(function() {

       
       $("#progress").hide();
	   $("#progresstitlemenu").hide();

		
        loaddata();
        loaddatatitle();

        ////////////////////TITLE MENU
        $("#edit-title").on('submit',(function(e) {
            e.preventDefault();
            $('#progresstitlemenuedit').width('0%');
            $('#progresstitlemenuedit').show();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ url('/editmenutitleaksi') }}",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progresstitlemenuedit", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('#progresstitlemenuedit').width(percentComplete+'%');
                        }
                    }, false);

                    return xhr;
                },
                error: function (e) {
                    new Noty({
                        type: 'error',
                        text: 'Response error ' + e,
                        timeout: 4000,
                        layout: 'topRight',
                        theme: 'nest',
                    }).show();
                },
                success: function(result){
                    if(result['status'] == 'success')
                    {
                        new Noty({
                            type: 'warning',
                            text: result['msg'],
                            timeout: 4000,
                            layout: 'topRight',
                            theme: 'nest',
                        }).show();

                        resetForm();
                        table.draw();
                    }
                    else
                    {
                        new Noty({
                            type: 'error',
                            text: result['msg'],
                            timeout: 4000,
                            layout: 'topRight',
                            theme: 'nest',
                        }).show();

                        $("#progresstitlemenueditss").hide();
                    }
                }

            });
        }));

        ////////////////////MENU
        $("#edit-sponsor").on('submit',(function(e) {
            e.preventDefault();
            $('#progress2').width('0%');
            $('#progress2').show();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ url('/editmenuaksi') }}",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('#progress').width(percentComplete+'%');
                        }
                    }, false);

                    return xhr;
                },
                error: function (e) {
                    new Noty({
                        type: 'error',
                        text: 'Response error ' + e,
                        timeout: 4000,
                        layout: 'topRight',
                        theme: 'nest',
                    }).show();
                },
                success: function(result){
                    if(result['status'] == 'success')
                    {
                        new Noty({
                            type: 'warning',
                            text: result['msg'],
                            timeout: 4000,
                            layout: 'topRight',
                            theme: 'nest',
                        }).show();

                        resetForm();
                        table2.draw();
                    }
                    else
                    {
                        new Noty({
                            type: 'error',
                            text: result['msg'],
                            timeout: 4000,
                            layout: 'topRight',
                            theme: 'nest',
                        }).show();

                        $("#progress").hide();
                    }
                }

            });
        }));


        ///////////////////TITLE MENU
        $(document).on('click', '.delete_btntitle', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
                theme: 'nest',
                text: 'Apakah Title Menu <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/deletemenutitle') }}',
                            data: ({a:a, _token:'{{csrf_token()}}'}),
                            success: function(result){
                                if(result['status'] == 'success')
                                {
                                    new Noty({
                                        type: 'warning',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        theme: 'nest',
                                        timeout: 4000,
                                    }).show();

                                    table.draw();

                                }
                                else
                                {
                                    new Noty({
                                        type: 'error',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        theme: 'nest',
                                        timeout: 4000,
                                    }).show();
                                }
                            }
                        });

                    }, {id: 'button1', 'data-status': 'ok'}),

                    Noty.button('BATAL', 'btn btn-error', function () {
                        n.close();
                    })
                ]
            }).show();

        });

        ///////////////////MENU
        $(document).on('click', '.delete_btn', function () {
            var a = $(this).attr('a');
            var b = $(this).attr('b');

            var n = new Noty({
            	theme: 'nest',
                text: 'Apakah Menu <strong>' + b + '</strong> akan dihapus?',
                type: 'error',
                buttons: [
                    Noty.button('YA', 'btn btn-success', function () {
                        n.close();
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/deletemenu') }}',
                            data: ({a:a, _token:'{{csrf_token()}}'}),
                            success: function(result){
                                if(result['status'] == 'success')
                                {
                                    new Noty({
                                        type: 'warning',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        theme: 'nest',
                                        timeout: 4000,
                                    }).show();

                                    table2.draw();

                                }
                                else
                                {
                                    new Noty({
                                        type: 'error',
                                        layout: 'topRight',
                                        text: result['msg'],
                                        theme: 'nest',
                                        timeout: 4000,
                                    }).show();
                                }
                            }
                        });

                    }, {id: 'button1', 'data-status': 'ok'}),

                    Noty.button('BATAL', 'btn btn-error', function () {
                        n.close();
                    })
                ]
            }).show();

        });



       
    });
    $("#hiddent").hide();
</script>
@endsection