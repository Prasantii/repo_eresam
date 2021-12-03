<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;


class fixController extends Controller
{
  /*  public function __construct()
    {
    	$this->testModel = new testModel();
    }

    public function data1()
    {
		$dat = DB::table('wajib_retribusi')->paginate(10);
		return view('test1',['wajib_retribusi'=> $dat]);
	$data = [
	//	'wr'=>$this->testModel->AllData(),
	//];
	return view('/test1',$data);
    */
	public function data1(){
	$data_wr = DB::table('detail_trs_wr')->get();

	//return $data_wr;
	//return view('/test',['detail_trs_wr'->$data_wr]);
	return view('/coba',['detail_trs_wr'->$data_wr]);

    }

    public function cari(Request $request){
		$cari = $request->cari;
		$data_wr= DB::table('detail_trs_wr')
		->where('id_wr','like',"%".$cari."%")
		->paginate();
	return view('test1',['detail_trs_wr'=>$data_wr]);
	}
}

