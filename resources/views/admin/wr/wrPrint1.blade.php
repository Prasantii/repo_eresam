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
            <td colspan="3">
                <table width="100%">
                    <tr>
                        <td width="20%" style="text-align:left;">PETUGAS</td>
                        <td>:</td>
                        <td width="75%" style="text-align:left;">{{  }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="8">
                <table>
                    <tr>
                        <td>
                            {{  }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td width="2%"  style="vertical-align: middle;background: #334868;color: #FFF;">NO</td>
            <td style="vertical-align: middle;background: #334868;color: #FFF;">KODE</td>
            <td style="vertical-align: middle;background: #334868;color: #FFF;">NIK</td>
            <td style="vertical-align: middle;background: #334868;color: #FFF;">NAMA</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">ALAMAT</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">JENIS RETRIBUSI</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">TARIF</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">VERIFIKASI</td>
        </tr>


        @if(count($data->report) > 0)
            @foreach($data->report as $item)
                <?php 
                $datawr = DB::table('wajib_retribusi as a')
                            ->select('a.*','b.name as namedistricts','c.name as namevillages')
                            ->leftJoin('districts as b','a.district_id','=','b.id')
                            ->leftJoin('villages as c','a.villages_id','=','c.id')
                            ->where('a.is_active',0)
                            ->where('a.villages_id',$item->id_gampong)
                            ->orderBy('a.code', 'ASC')
                            ->get(); 

                $no             = 1;
                $totalSum       = 0;
                ?>

                @foreach($data as $wrrr)

                <tr class="item">
                    <td align="center">{{ $no++ }}</td>
                    <td align="left">{{ $wrrr->code }}</td>
                    <td align="left">{{ $wrrr->nik }}</td>
                    <td align="left">{{ $wrrr->nama }}</td>
                    <td align="left">{{ $wrrr->alamat }}-{{ $wrrr->namedistricts }}-{{ $wrrr->namevillages }}</td>
                    <td align="left">{{ $data->namajenis }}</td>
                    <td align="left">{{ $data->tarf }}</td>
                    <td align="left">{{ $data->is_active }}</td>
                    

                </tr>
                @php
                    $totalSum = $no - 1;
                @endphp

                @endforeach

                
                
            @endforeach
        @endif

            <tr class="total">
                <td colspan="5" align='right'>TOTAL KESELURUHAN</td>
                <td> {{ number_format($totalSum) }} WR</td>
            </tr>
    </table>
</main>
</body>
</html>