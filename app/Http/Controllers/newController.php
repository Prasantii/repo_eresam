<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\newModel;
use App\Models\WajibRetribusi;
use App\Models\new2Model;


class newController extends Controller
{
    public function home(){
        return view('home');
    }

    public function read()
    {
        return 'Input kode';
    }
    
    
    public function ajax(Request $request)
    {
      //  $code = ['code'=>$this->new2Model->alldata()->where('code','like','%'.$code.'%')->get(),];

        $code = $request->code;
        $hasil = DB::table('detail_trs_wr as a')
                ->select('a.bulan' , 'a.tarif' , 'a.status' , 'a.tgl_bayar' , 'b.code', 'b.nama')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
              //  ->distinct('b.nama')
                ->where('code','like','%'.$code.'%')->get();
        $c = count($hasil);
        if($c == 0){
            return '<p class="text-muted">Data not Found</p>';
        }
        else{
            return view('cobapage')->with([
                'code' => $hasil
            ]);
        }
    }

    public function search(Request $request)
    {
          $code = $request->code;
        $hasil = DB::table('detail_trs_wr as a')
                ->select('a.bulan' , 'a.tarif' , 'a.status' , 'a.tgl_bayar' , 'b.code', 'b.nama')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
              //  ->distinct('b.nama')
        ->where('code','like','%'.$code.'%')->get();
       
        return view('cobapage',['code'=>$hasil]);
    }

    //===============================DARI SINI SAMPE BAWAH GAK DI PAKE================================
    public function index(Request $request){
    $data_wr = DB::table('detail_trs_wr')->paginate(10);
    return view('/test',['detail_trs_wr'=> $data_wr]);
    }

    public function detail()
    {
        //$total = DB::table('detail_trs_wr')->count();
        $dtl = DB::table('detail_trs_wr')->paginate(12000);
        return view('/coba',['dtl'=>$dtl]);
        
    }

    public function lihat()
    {
   // $services = DB::table('wajib_retribusi') ->join('id','wajib_retribusi.id', '=', 'id.wajib_retribusi')->join();

    $user = DB::table('wajib_retribusi')
    ->join('detail_trs_wr','id','detail_trs_wr.id','=','wajib_retribusi.id_wr')->get();
    return view('');

    }

    public function melihat_1()
    {
    //$datafix =  DB::table('wajib_retribusi')->leftjoin('detail_trs_wr','detail_trs_wr.id_wr', '=' , 'wajib_retribusi.id')->get();
    $datafix = [
        'datafix'=>$this->new2Model->melihat(),
    ];
    return view('/home/coba',['datafix'=>$datafix]);
    }

    public function apa(){
        $this->new2Model = new new2Model();
    }

    public function TagihanWrKeseluruhan_luar(Request $request,$id){
    $war = WajibRetribusi::where('id',decrypt($id))->first();
    //return view('/testcoba',compact('war'))->with(["page" => "Data Tagihan Wr"]);
    return view('/home/coba');
    }
    public function fixtabel()//ajax
    {
        
        // $fix =  DB::table('detail_trs_wr as a')
        // ->select( 'a.bulan' , 'a.tarif' , 'a.status' , 'a.tgl_bayar' , 'b.code')
        // ->leftJoin('wajib_retribusi as b ', 'a.id_wr', '=', 'b.id')
        // ->get();

        $fix = DB::table('detail_trs_wr as a')
                ->select('a.bulan' , 'a.tarif' , 'a.status' , 'a.tgl_bayar' , 'b.code')
                ->leftJoin('wajib_retribusi as b','a.id_wr','=','b.id')
        ->get();

                // ->where('id_wr',$id);
        //return view('/coba',['fix'=>$fix]);
    }
  //$start_date = formatDate($start_date,'Y-m-d');
}
