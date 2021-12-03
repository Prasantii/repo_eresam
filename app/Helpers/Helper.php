<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Hash;

class Helper
{
     public static function check_access($role_id, $menu_id)
	{

	    $akses = DB::table('user_access_menu')->where('role_id',$role_id)->where('menu_id',$menu_id)->first();

	    if ($akses) {
	        echo "checked='checked'";
	    }
	}

	public static function check_zona($id,$idzona)
	{

	    $akses = DB::table('detail_zona')->where('id_districts',$id)->where('id_zona',$idzona)->first();
	  

	    if ($akses) {
	        echo "checked='checked'";
	    }
	}

	

	public static function generate_token() {
		$strr = Hash::make(rand() . time() . rand());
		$strr = str_replace(' ', '-', $strr); // Replaces all spaces with hyphens.

	    return preg_replace('/[^A-Za-z0-9\-]/', '', $strr); // Removes special chars.

	    
	}

	public static function generate_expiry() {
	    return time() + 3600000;
	}

	function clean($string) {
	    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
}

?>