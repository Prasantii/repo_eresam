<!DOCTYPE html>
<html>
<head>
	
</head>
<body>

	<style type="text/css">
		.pagination li{
			float: left;
			list-style-type: none;
			margin:5px;
		}
	</style>

	<form action="/test/cari" method="GET">
		<input type="text" name="cari" placeholder="Cari" value="{{ old('cari') }}">
		<input type="submit" value="CARI">
	</form>
		
	<br/>

	<table>
		<tr>
			<th>No</th>
			<th>Bulan</th>
			<th>Tarif</th>
			<th>Status</th>
			<th>TGL Bayar</th>
		</tr>
		<?php $no=1; ?>
		@foreach($data_wr as $data)
		<tr>
			<td>{{$no++}}</td>
			<td>{{$data->bulan }}</td>
			<td>{{$data->tarif }}</td>
			<td>{{$data->status}}</td>
			<td>{{$data->tgl_bayar}}</td>
		</tr>
		@endforeach
	</table>



</body>
</html>