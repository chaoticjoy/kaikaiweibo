<?php

	function fetchurl($url){
	
		$header='';
		$error='';
		$request_sina = $url;
		$response=fetch_url($request_sina, SAE_ACCESSKEY, SAE_SECRETKEY, $header, $error, $opt);
		return $response;
	
	}
	
	function weather($city)
	{
		$ret=fetchurl( 'http://pandoralab.appspot.com/api/weather.json' , '?city='.urlencode($city).'&lan=zh_CN' );
		return json_decode( $ret , true);
	}
	
	print_r(weather('±±¾©'));

?>