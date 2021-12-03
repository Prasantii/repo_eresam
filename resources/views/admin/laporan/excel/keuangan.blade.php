<table style="border: 1px;">
    <thead>
    <tr>
        <th colspan="3" style="text-align: right">PERIODE:</th>
        <th colspan="2" style="text-align: right">{{ $data->filter->period }}</th>
    </tr>
    <tr>
        <th colspan="3" style="text-align: right">STATUS:</th>
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
            <td style="vertical-align: middle;background: #334868;color: #FFF;">NAMA</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">DARI - SAMPAI</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">TGL BAYAR</td>
            <td style="text-align: left;vertical-align: middle;background: #334868;color: #FFF;">PENANGGUNG JAWAB(PETUGAS)</td>
            <td style="text-align: center;vertical-align: middle;background: #334868;color: #FFF;">STATUS</td>
            <td width="9%" style="vertical-align: middle;background: #334868;color: #FFF;">TOTAL BAYAR</td>
        </tr>
    </thead>
    <tbody>

    @php
        $no = 1;
        $totalSum = 0;
    @endphp

    @if(count($data->report) > 0)
        @foreach($data->report as $item)
            <?php if($item->status == 0){
                        $statuss = "Verifikasi Bukti Oleh Petugas";
                    }elseif($item->status == 1){
                         $statuss = "Pembayaran Melalui Aplikasi";
                    }elseif($item->status == 2){
                         $statuss = "Pembayaran Manual Ke Petugas";
                    }elseif($item->status == 3){
                         $statuss = "Pembayaran Ditolak Petugas";
                    } ?>
            <tr class="item">
                <td align="center">{{ $no++ }}</td>
                <td align="left">{{ $item->code }}</td>
                <td align="left">{{ $item->nama }}</td>
                <td align="center">{{ date('F/Y',strtotime($item->dari)).'-'.date('F/Y',strtotime($item->sampai)) }}</td>
                <td align="center">{{ date('d/M/Y H:i',strtotime($item->tgl_upload)) }}</td>
                <td align="left">{{ $item->namapetugas }}</td>
                <td align="center">{{ $statuss }}</td>
                <td align="left">Rp. {{ number_format($item->total_bayar) }}</td>
            </tr>

            @php
                $totalSum += $item->total_bayar;
            @endphp
        @endforeach
    @endif
    <tr>
        <td style="text-align: right;vertical-align: middle;background: #334868;color: #FFF;" colspan="7">TOTAL KESELURUHAN </td>
        <td align="left">Rp. {{ number_format($totalSum) }}</td>
    </tr>
    </tbody>
</table>