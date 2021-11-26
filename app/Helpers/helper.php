<?php
namespace App\Helpers;

use Config;
use Illuminate\Support\Facades\Auth;

class Helper
{
  public static function checkImage($path = '')
  {
    if (@getimagesize($path)) {
      return $path;
    } else {
      return asset('images/no_image.jpg');
    }
  }

	public static function delfirebase($subdatabase){
		$url = config('app.database_firebase')."/".$subdatabase.".json?auth=".config('app.auth_firebase');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);                               
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
		$jsonResponse = curl_exec($ch);
		if(curl_errno($ch)){return 'Curl error: ' . curl_error($ch)."[".$url."]";}
			curl_close($ch);
		return $jsonResponse;
	}
	public static function getfirebase($subdatabase){
		$url = config('app.database_firebase')."/".$subdatabase.".json?print=pretty&auth=".config('app.auth_firebase');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);                               
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
		$jsonResponse = curl_exec($ch);
		//var_dump($jsonResponse);
		if(curl_errno($ch)){return 'Curl error: ' . curl_error($ch)."[".$url."]";}
			curl_close($ch);
		return $jsonResponse;
	}

}

