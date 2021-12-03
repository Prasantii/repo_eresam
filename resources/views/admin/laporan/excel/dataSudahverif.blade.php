
    <table style="border: 1px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align: right">PERIODE:</th>
        <th colspan="2" style="text-align: right">{{ $data->filter->period }}</th>
    </tr>
    </thead>
    </table>
    
    <table>
    <thead>
    <tr>
        <th colspan="8" style="text-align: center">{{ $data->title }}</th>
    </tr>
    </thead>
    </table>


         <?php 
            $begin = new DateTime($data->filter->tgl1);
            $end = new DateTime($data->filter->tgl2);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

        ?>

<table style="border: 1px;">
    <thead>
        <tr class="heading">
            <td rowspan="2" width="2%"  style="vertical-align: middle;background: #334868;color: #FFF;">NO</td>
            <td rowspan="2" style="vertical-align: middle;background: #334868;color: #FFF;">NAMA PETUGAS</td>
            <td rowspan="2" style="vertical-align: middle;background: #334868;color: #FFF;">ZONA</td>
            <td rowspan="2" style="vertical-align: middle;background: #334868;color: #FFF;">KECAMATAN-GAMPONG</td>
            <td colspan="{{$data->filter->hasiljarak}}" style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">TANGGAL</td>
            <td rowspan="2" style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">TOTAL WR</td>
        </tr>
    </thead>
    
        <tr>
            <?php foreach ($period as $dt) {         ?>                
                <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">{{ $dt->format("d-m-Y") }}</td>
            <?php } ?>
        </tr>

       
        @if(count($data->report) > 0)

        <?php
            $no             = 1;
            $totalSum       = 0;
                 ?>
            @foreach($data->report as $item)
                <?php 
                $datawr = DB::table('wajib_retribusi as a')
                            ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namapet')
                            ->leftJoin('districts as b','a.district_id','=','b.id')
                            ->leftJoin('villages as c','a.villages_id','=','c.id')
                            ->leftJoin('petugas as d','a.id_petugas','=','d.id')
                            ->where('a.is_active',1)
                            ->where('a.id_petugas',$item->id)
                            ->where('a.wkt_verifikasi_data', '>=', $data->filter->tgl1)
                            ->where('a.wkt_verifikasi_data', '<=', $data->filter->tgl2)
                            ->orderBy('a.code', 'ASC')
                            ->count();                 
                ?>


                <tr class="item">
                    <td align="center">{{ $no++ }}</td>
                    <td align="left">{{ $item->nama }}</td>
                    <td align="left">{{ $item->namazona }}</td>
                    <td align="left">
                        <?php $dpet = DB::table('lokasi_tugas as a')
                                ->select('b.id as id_kecamatan','c.id as id_gampong','b.name as nama_kecamatan','c.name as nama_gampong')
                                ->leftJoin('districts as b','a.district_id','=','b.id')
                                ->leftJoin('villages as c','a.villages_id','=','c.id')
                                ->where('a.id_petugas',$item->id)
                                ->get(); 

                                foreach ($dpet as $pettt) {
                                    if($pettt->nama_kecamatan == ''){
                                        $diss = '';
                                    }else{
                                        $diss = $pettt->nama_kecamatan;
                                    }

                                    if($pettt->nama_gampong == ''){
                                        $vill = '';
                                    }else{
                                        $vill = $pettt->nama_gampong.' /';
                                    } ?>

                                    {{ $diss }} - {{ $vill }}

                               <?php } ?>

                    </td>
                    <?php 
                        foreach ($period as $dt) {
                            $tgll1 = date('Y-m-d H:i:s', strtotime($dt->format("Y-m-d 00:00:00")));
                            $tgll2 = date('Y-m-d H:i:s', strtotime($dt->format("Y-m-d 23:59:00")));
                            $datawrper = DB::table('wajib_retribusi as a')
                                    ->select('a.*','b.name as namedistricts','c.name as namevillages','d.nama as namapet')
                                    ->leftJoin('districts as b','a.district_id','=','b.id')
                                    ->leftJoin('villages as c','a.villages_id','=','c.id')
                                    ->leftJoin('petugas as d','a.id_petugas','=','d.id')

                                    ->where('a.wkt_verifikasi_data', '>=', $tgll1)
                                    
                                    ->where('a.wkt_verifikasi_data', '<=', $tgll2)
                                    ->where('a.id_petugas',$item->id)
                                    ->count(); 
                                    ?>


                            <td align='center'><strong>{{ $datawrper }}</strong></td>
                        <?php } ?>

                    <td align="left">{{ $datawr }}</td>
                </tr>
                @php
                    $totalSum += $datawr;
                @endphp

            @endforeach
        @endif
            <?php $jarak = $begin->diff($end);
                $hsil = $jarak->days+5; ?>
            <tr class="total">
                <td colspan="{{$hsil}}" align='right'>TOTAL KESELURUHAN</td>
                <td> {{ number_format($totalSum) }} WR</td>
            </tr>
    </table>
