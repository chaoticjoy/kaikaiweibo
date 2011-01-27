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
			$language='en';
		else
			$language='zh-cn';
		$content=fetchurl("http://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng."&sensor=false&language=".$language);
		$result=json_decode( $content, true);
		//return $result;
		if($result['status']=='OK')
			return $result['results'][0]['address_components'][2]['long_name'];
		else
			return $result['status'];
	}

/* 	print_r(Address_Lookup('23.3570603,116.6645348',0));
	print_r(Address_Lookup('23.3570603,116.6645348',1)); */
	//print_r(Address_Lookup('22.914989,112.044335',0));

?>