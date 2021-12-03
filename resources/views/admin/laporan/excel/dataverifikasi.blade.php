<table style="border: 1px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align: right">NAMA PETUGAS:</th>
        <th colspan="2" style="text-align: right">{{ $data->filter->status }}</th>
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
<table style="border: 1px;">
    <thead>
        <tr>
            <td width="2%"  style="vertical-align: middle;background: #334868;color: #FFF;">NO</td>
            <td style="vertical-align: middle;background: #334868;color: #FFF;">KODE</td>
            <td style="vertical-align: middle;background: #334868;color: #FFF;">NIK</td>
            <td style="vertical-align: middle;background: #334868;color: #FFF;">NAMA</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">ALAMAT</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">PETUGAS</td>
        </tr>
    </thead>
    <tbody>

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
                        ->get(10); 

            $no             = 1;
            $totalSum       = 0;
            ?>

            @foreach($datawr as $wrrr)

            <tr class="item">
                <td align="center">{{ $no++ }}</td>
                <td align="left">'{{ $wrrr->code }}</td>
                <td align="left">{{ $wrrr->nik }}</td>
                <td align="left">{{ $wrrr->nama }}</td>
                <td align="left">{{ $wrrr->alamat }}-{{ $wrrr->namedistricts }}-{{ $wrrr->namevillages }}</td>
                <td align="center">{{ $data->filter->status }}</td>
            </tr>
            @php
                $totalSum = $no - 1;
            @endphp

            @endforeach
            
        @endforeach
    @endif
    <tr>
                <td style="text-align: right;vertical-align: middle;background: #334868;color: #FFF;" colspan="5">TOTAL KESELURUHAN </td>
                <td align="left">{{ number_format($totalSum) }} WR</td>
            </tr>
    </tbody>
</table>