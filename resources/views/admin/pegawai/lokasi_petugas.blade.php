@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li class="active">Lokasi Petugas Petugas</li>
    </ul>
</div>

<!-- END PAGE HEADING -->


@if(Session::has('success'))
    <script type="text/javascript">
        new Noty({
            text: '<strong>Success</strong> {{Session::get('success')}}',
            layout: 'topRight',
            type: 'success'
        }).setTimeout(4000).show();
    </script>
@endif


<div class="container">
      <div id="aa" class="row">                            
	    <div class="col-md-12">
	        <div class="panel panel-success">
	            <div class="panel-heading">
	                <h3 class="panel-title"><b>Lokasi Petugas</b></h3>
	                <div class="panel-elements pull-right">
                    <button class="btn btn-info btn-shadowed" type="button" id="reload"><span class="fa fa-refresh"></span> Reload</button>
                </div>
	            </div>
	            <div class="panel-body">      
					<div class="block-content">
                        <div id="map" class="pull-left" style="width: 100%; height: 600px;"></div>
					</div>
	            </div>
	            <div class="panel-footer">                                        
	                
	        	</div>
	        </div>
	    </div>
	</div>   
</div>

<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>  -->




<script>

    $('#reload').click(function() {
        location.reload();
    });
    $(function () {
            get_map();
        });
    function get_map()
    {   
        var locations = [
            @foreach($petugas as $pet)
              ['<div id="content">' +
                '<h2>Informasi Lokasi Petugas</h2>' +
                '<div id="bodyContent">' +
                    '<table class="table table-bordered" width="100%">' +
                        '<thead>' +
                        '<tr>' +
                            '<th>Nama Petugas</th>' +
                            '<th>No Hp</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>'+
                        '<tr>' +
                            '<td align="center" style="text-transform: uppercase;">{{ $pet->nama }}</td>' +
                            '<td align="center">{{ $pet->hp }}</td>' +
                        '</tr>' +
                        '</tbody>' +
                    '</table>' +
                '</div>' +
            '</div>', {{$pet->lat}}, {{$pet->lng}}],
            @endforeach
        ];

        var map = L.map('map', { scrollWheelZoom: true }).setView([5.550925, 95.329935], 13);
        mapLink =
          '<a href="http://openstreetmap.org">OpenStreetMap</a>';
        L.tileLayer(
          'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; ' + mapLink + ' Contributors',
            maxZoom: 19,
          }).addTo(map);

        for (var i = 0; i < locations.length; i++) {
          marker = new L.marker([locations[i][1], locations[i][2]])
            .bindPopup(locations[i][0])
            .addTo(map);
        }
    
    }

  </script>
@endsection