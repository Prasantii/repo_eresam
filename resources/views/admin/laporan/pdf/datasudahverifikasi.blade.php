<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data->title }}</title>

    <style>
        @page {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            margin-top: 1cm; margin-left: 1.5cm; margin-right: 1.5cm; margin-bottom: 1.5cm;
        }

        body {
            border: 1px solid #eee;
            color: #555;
        }

        header{
            top: -2.5cm;
            height: 60px;
            position: fixed;
            text-align: left;
        }

        header table {
            width: 100%;
            text-align: left;
            border: 1px solid #eee;
        }

        header table {
            width: 100%;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        header table td {
            padding: 5px;
            vertical-align: top;
        }

        header table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box {
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 10px;
            line-height: 16px;
        }

        .invoice-box table {
            width: 100%;
            padding: 10px;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            font-size: 14px;
            line-height: 7px;
            text-align: right;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border: 1px solid #000000;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border: 1px solid #000000;
        }

        .invoice-box table tr.total td {
            text-align: right;
            border: 2px solid #000000;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
<main class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table width="100%">
                    <tr>
                        <td width="20%" style="text-align:left;">PERIODE</td>
                        <td>:</td>
                        <td width="75%" style="text-align:left;">{{ $data->filter->period }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="6">
                <table>
                    <tr>
                        <td>
                            {{ $data->title }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

         <?php 
            $begin = new DateTime($data->filter->tgl1);
            $end = new DateTime($data->filter->tgl2);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

        ?>

        <tr class="heading">
            <td rowspan="2" width="2%"  style="vertical-align: middle;background: #334868;color: #FFF;">NO</td>
            <td rowspan="2" style="vertical-align: middle;background: #334868;color: #FFF;">NAMA PETUGAS</td>
            <td rowspan="2" style="vertical-align: middle;background: #334868;color: #FFF;">ZONA</td>
            <td rowspan="2" style="vertical-align: middle;background: #334868;color: #FFF;">KECAMATAN-GAMPONG</td>
            <td colspan="{{$data->filter->hasiljarak}}" style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">TANGGAL</td>
            <td rowspan="2" style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">TOTAL WR</td>
        </tr>
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
</main>
</body>
</html>