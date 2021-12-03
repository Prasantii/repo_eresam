@extends('admin.home')
@section('content')

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Aplikasi</a></li>
        <li ><a href="#">Laporan</a></li>
        <li class="active">Laporan Data WR Yang Belum Diverifikasi Petugas</li>
    </ul>
</div>

<!-- END PAGE HEADING -->


@if(Session::has('success'))
    <script type="text/javascript">
        new Noty({
            text: '<strong>Success</strong> {{Session::get('success')}}',
            layout: 'topRight',
            type: 'success',
            
        }).setTimeout(4000).show();
    </script>
@endif


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="block block-condensed">
                <div class="app-heading app-heading-small">
                    <div class="title">
                        <h2>Laporan Data WR Yang Belum Diverifikasi Petugas Bedasarkan Petugas</h2>
                        <p>Pencarian laporan berdasarkan ketentuan yang berlaku</p>
                    </div>
                </div>
                <div class="block-content">
                    
                    <div class="row margin-top-10">
                        <div class="col-md-6">
                            <label for="id_petugas">PETUGAS</label>
                            <select id="id_petugas" class="form-control" name="id_petugas">
                                @foreach($petugas as $pet)
                                    <option value="{{$pet->id}}">{{$pet->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="block-divider"></div>
                <div class="block-content">
                    <button id="report-view" class="btn btn-info btn-icon-fixed btn-shadowed"><span class="fa fa-search"></span> Lihat Laporan</button>
                    <button id="report-refresh" class="btn btn-warning btn-icon-fixed btn-shadowed"><span class="fa fa-refresh"></span> Segarkan</button>
                </div>
            </div>
        </div>
    </div>
    <div id="lap_jenis_kelamin" class="block block-arrow-top padding-top-20" style="display: none;">
        <div id="aa" class="row">                            
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Laporan Data WR Yang Belum Diverifikasi Petugas Bedasarkan Petugas</b></h3>
                        <div class="panel-elements pull-right hidden-mobile" id="action-btn" style="display: none;">
                            <button id="print" class="btn btn-info btn-icon-fixed"><span class="fa fa-print"></span> Cetak</button> 
                            <button id="export" class="btn btn-success btn-icon-fixed"><span class="fa fa-file-excel-o"></span> Export</button>
                        </div>
                    </div>
                    <div class="panel-body">      
        				<div class="block-content table-responsive">
        	    			<table id="sponsor" class="table table-head-custom table-bordered table-striped margin-bottom-10 small nowrap" style="display: none;"  width="100%">
        	                    <thead>
        	                        <tr>
        	                            <th width="5%">NO</th>
                                        <th>KODE</th>
        					            <th>NIK</th>
                                        <th>NAMA</th>
                                        <th>ALAMAT</th>
                                        <th>PETUGAS</th>
        	                            
        	                        </tr>
                                    <tr id="spinner-data" style="display: none;">
                                        <td colspan="10" style="text-align: center">
                                            <svg class='spinner' width='40px' height='30px' viewBox='0 0 66 66' xmlns='http://www.w3.org/2000/svg'><circle class='path' fill='none' stroke-width='6' stroke-linecap='round' cx='33' cy='33' r='30'></circle></svg> <br> Loading...
                                        </td>
                                    </tr>
        	                    </thead>
                                <tbody>
                                </tbody>     
        	                </table>
        				</div>
                    </div>
                    <div class="panel-footer">                                        
                        
                	</div>
                </div>
            </div>
    	</div> 
    </div>  

</div>




<script>
    $(function () {
        var sponsor       = $('#sponsor'),
            date1     = $('#date1'),
            date2     = $('#date2'),
            id_petugas     = $('#id_petugas'),
            lap_jenis_kelamin     = $('#lap_jenis_kelamin'),
            spinner     = $('#spinner-data');
            

            id_petugas.select2({
                    placeholder: "PILIH STATUS",
                    "language": {
                        "noResults": function () {
                            return "Tidak ada data ditemukan";
                        }
                    }
                });


        function loaddata(date1, date2, id_petugas){
           $.ajax({
                type: "POST",
                url: "{{ url('/devadmin/laporan/verifikasidata/data') }}",
                data: ({_token: "{{csrf_token()}}", date1: date1, date2: date2, id_petugas: id_petugas}),
                beforeSend: function () {
                    spinner.show();
                },
                complete: function () {
                    spinner.hide();
                },
                success: function (result) {
                    if(result['status'] == 'success')
                    {
                        $('#action-btn').show();
                        $('#lap_jenis_kelamin').fadeIn(1000);

                        $('#sponsor').show();
                        $('#sponsor tbody').html(result['data']);
                    }
                    else
                    {
                        new Noty({
                            type: 'error',
                            text: result['message'],
                            timeout: 2000,
                        }).show();
                    }
                },
                error: function (e) {
                    new Noty({
                        type: 'error',
                        text: 'Response error ' + e,
                        timeout: 5000
                    }).show();
                }
            })
        }

        

        $('#report-view').on('click', function () {

            loaddata(date1.val(), date2.val(), id_petugas.val());
        });


        $('#report-refresh').on('click', function () {
            $('#action-btn').hide();
            $('#lap_jenis_kelamin').fadeOut(1000);
            $('#sponsor').hide();
            $('#sponsor tbody').html('');
        });

         $(document).on('click', '#btn_detail', function () {
            window.location.href = $(this).attr('a');
        });

         

            $('#print').on('click', function () {

                PopupCenter('{{ url('/devadmin/laporan/verifikasidata/print') }}?date1=' + date1.val() + '&date2=' + date2.val() + '&id_petugas=' + id_petugas.val(), 'Laporan Data WR Yang Belum Diverifikasi Petugas Bedasarkan Petugas' ,'1200', '800');
            });

            $('#export').on('click', function () {

                window.location.href = '{{ url('/devadmin/laporan/verifikasidata/export') }}?id_petugas=' + id_petugas.val();
            });
    });
</script>
@endsection