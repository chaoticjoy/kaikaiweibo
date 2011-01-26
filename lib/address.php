<?php

	function fetchurl($url){
	
		$header='';
		$error='';
		$request_sina = $url;
		$response=fetch_url($request_sina, SAE_ACCESSKEY, SAE_SECRETKEY, $header, $error, $opt);
		return $response;
	
	}
	
	function Address_Lookup($latlng,$language=0){
		if($language)
			$language='zh-cn';
		else
			$language='en';
		$content=fetchurl("http://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng."&sensor=false&language=".$language);
		$result=json_decode( $content, true);
		if($result['status']=='OK')
			return $result['results'][1]['address_components'][0]['long_name'];
		else
			return 'error!';
	}

/* 	print_r(Address_Lookup('23.3570603,116.6645348',0));
	print_r(Address_Lookup('23.3570603,116.6645348',1)); */

?>