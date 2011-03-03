<?php

/*
 * How to use?
 *
 * $w = new weibo( 'APP Key' );
 * $w->setUser( 'username' , 'password' );
 * print_r($w->public_timeline());
 *
*/

/*
 * SAE Version
*/

class weibo 
{
	function __construct( $akey , $skey = '' ) 
	{
		$this->akey = $akey;
		$this->skey = $skey;
		$this->base = 'http://api.t.sina.com.cn/';
		$this->curl = curl_init();
		curl_setopt( $this->curl , CURLOPT_RETURNTRANSFER, true); 
		
		$this->postInit();
		
	}
	
	function postInit()
	{
		$this->postdata = array('source=' . $this->akey);
	
	}

	function setUser( $name , $pass ) 
	{
		$this->user['oname'] = $name;
		$this->user['opass'] = $pass;
		$this->user['name'] = urlencode($name);
		$this->user['pass']  = urlencode($pass);
		curl_setopt( $this->curl , CURLOPT_USERPWD , "$name:$pass" );
	}

	function public_timeline()
	{
		return $this->call_method( 'statuses' , 'public_timeline' );
	}
	
	function friends_timeline($max_id = 0 )
	{
		if($max_id==0)
			return $this->call_method( 'statuses' , 'friends_timeline' ,'?count=20' );
		else
			return $this->call_method( 'statuses' , 'friends_timeline' ,'?count=21&max_id='.$max_id);
	}
	
	function user_timeline( $name=0,$max_id=0 ) 
	{
		if($name===0){
			if($max_id==0)
				return $this->call_method( 'statuses' , 'user_timeline' ,'?count=20');
			else
				return $this->call_method( 'statuses' , 'user_timeline' ,'?count=21&max_id='.$max_id);
		}
		else{
			if($max_id==0)
				return $this->call_method( 'statuses' , 'user_timeline' ,'?screen_name=' . urlencode( $name ) .'&count=20');
			else
				return $this->call_method( 'statuses' , 'user_timeline' ,'?screen_name=' . urlencode( $name ) .'&count=20&max_id='.$max_id);
		}
	}
	
	function unread($with_new_status=false,$since_id=0)
	{
		if($with_new_status&&$since_id)
			return $this->call_method( 'statuses' , 'unread' ,'?with_new_status='.$with_new_status.'&since_id='.$since_id );
		else
			return $this->call_method( 'statuses' , 'unread' ,'');
	}
	
	function reset_count($type)
	{
		$this->postdata[] = 'type='.$type;
		return $this->call_method( 'statuses' , 'reset_count'  );
	}
	
	function followers( $name,$count = 10 , $cursor = -1  ) 
	{
		if(!$name)
			return $this->call_method( 'statuses' , 'followers' , '?count='.$count.'&cursor=' .$cursor);
		else
			return $this->call_method( 'statuses' , 'followers' ,'?screen_name=' . urlencode( $name ) .'&count='.$count.'&cursor=' .$cursor);
	}
	
	function friends( $name,$count = 10 , $cursor = -1  ) 
	{
		if(!$name)
			return $this->call_method( 'statuses' , 'friends' , '?count='.$count.'&cursor=' .$cursor);
		else
			return $this->call_method( 'statuses' , 'friends' , '?screen_name=' . urlencode( $name ) .'&count='.$count.'&cursor=' .$cursor);
	}
	
	function follow( $screen_name )
	{
		return $this->call_method( 'friendships' , 'create' , '?screen_name=' . urlencode( $screen_name));
	}
	
	function unfollow( $screen_name )
	{
		return $this->call_method( 'friendships' , 'destroy' , '?screen_name=' . urlencode( $screen_name));
	}
	
	function user_info( $name )
	{
		return $this->call_method( 'users' , 'show' , '?screen_name=' . urlencode( $name )   );
		//return $this->call_method( 'users' , 'show' , '?user_id=' . $user_id   );
	}
	
	function mentions(  $max_id=0,$count = 20 ) 
	{
		if($max_id)
			return $this->call_method( 'statuses' , 'mentions' , '?count=' . $count . '&max_id=' . $max_id );
		else
			return $this->call_method( 'statuses' , 'mentions' , '?count=' . $count );
	}
	
	function direct_messages(  $max_id=0,$count = 20 ) 
	{
		if($max_id)
			return $this->call_method( '' , 'direct_messages' , '?count=' . $count . '&max_id=' . $max_id );
		else
			return $this->call_method( '' , 'direct_messages' , '?count=' . $count );
	}	
	
	function comments_timeline(  $page =1,$count = 20 )
	{
		return $this->call_method( 'statuses' , 'comments_timeline' , '?count=' . $count . '&page=' . $page  );
	}
	
	function comments_to_me(  $page =1,$count = 20 )
	{
		return $this->call_method( 'statuses' , 'comments_to_me' , '?count=' . $count . '&page=' . $page  );
	}
	
	function comments_by_me( $count = 10 , $page = 1 )
	{
		return $this->call_method( 'statuses' , 'comments_by_me' , '?count=' . $count . '&page=' . $page  );
	}
	
	function comments( $tid , $count = 10 , $page = 1 )
	{
		return $this->call_method( 'statuses' , 'comments' , '?id=' . $tid . '&count=' . $count . '&page=' .$page  );
	}
	
	function counts( $tids )
	{
		return $this->call_method( 'statuses' , 'counts' , '?ids=' . $tids   );
	}
	
	function show( $tid )
	{
		return $this->call_method( 'statuses' , 'show/' . $tid  );
	}
	
		function destroy( $tid )
	{
	
		//curl_setopt( $this->curl , CURLOPT_CUSTOMREQUEST, "DELETE"); 		
		return $this->call_method( 'statuses' , 'destroy/' . $tid  );
	}
	
	
	function repost( $tid , $status )
	{
		$this->postdata[] = 'id=' . $tid;
		$this->postdata[] = 'status=' . urlencode($status);
		return $this->call_method( 'statuses' , 'repost'  );
	}
	
	
	function update( $status )
	{
		$status=str_replace("+","%2B",$status);
		$this->postdata[] = 'status=' . urlencode($status);
		return $this->call_method( 'statuses' , 'update'  );
	}
	
	function upload( $status , $file )
	{
		$status=str_replace("+","%2B",$status);
		$boundary = uniqid('------------------');
		$MPboundary = '--'.$boundary;
		$endMPboundary = $MPboundary. '--';
		
		$multipartbody .= $MPboundary . "\r\n";
		$multipartbody .= 'Content-Disposition: form-data; name="pic"; filename="wiki.jpg"'. "\r\n";
		$multipartbody .= 'Content-Type: image/jpg'. "\r\n\r\n";
		$multipartbody .= $file. "\r\n";

		$k = "source";
		// 这里改成 appkey
		$v = $this->akey;
		$multipartbody .= $MPboundary . "\r\n";
		$multipartbody.='content-disposition: form-data; name="'.$k."\"\r\n\r\n";
		$multipartbody.=$v."\r\n";
		
		$k = "status";
		$v = $status;
		$multipartbody .= $MPboundary . "\r\n";
		$multipartbody.='content-disposition: form-data; name="'.$k."\"\r\n\r\n";
		$multipartbody.=$v."\r\n";
		$multipartbody .= "\r\n". $endMPboundary;
		
		curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt( $this->curl , CURLOPT_POST, 1 );
		curl_setopt( $this->curl , CURLOPT_POSTFIELDS , $multipartbody );
		$url = 'http://api.t.sina.com.cn/statuses/upload.json' ;
		curl_setopt( $this->curl , CURLOPT_USERPWD , $this->user['oname'] . ":" . $this->user['opass'] );
		
		$header_array = array();

        $header_array["FetchUrl"] = $url;
        $header_array['TimeStamp'] = date('Y-m-d H:i:s');
        $header_array['AccessKey'] = $_SERVER['HTTP_ACCESSKEY'];


        $content="FetchUrl";

        $content.=$header_array["FetchUrl"];

        $content.="TimeStamp";

        $content.=$header_array['TimeStamp'];

        $content.="AccessKey";

        $content.=$header_array['AccessKey'];

        $header_array['Signature'] = base64_encode(hash_hmac('sha256',$content, $_SERVER['HTTP_SECRETKEY'] ,true));
		
		$header_array2=array("Content-Type: multipart/form-data; boundary=$boundary" , "Expect: ");
        foreach($header_array as $k => $v)
            array_push($header_array2,$k.': '.$v);

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header_array2 ); 
        curl_setopt($this->curl, CURLOPT_URL, SAE_FETCHURL_SERVICE_ADDRESS );
		curl_setopt($this->curl, CURLOPT_HEADER , true );
		curl_setopt($this->curl, CURLINFO_HEADER_OUT , true );
		
		$info = curl_exec( $this->curl );
		
		//print_r( curl_getinfo( $this->curl ) );
		
		return json_decode( $info , true);
		// =================================================
		
		
		
		
		//return $this->call_method( 'statuses' , 'upload'  );
	}
	
	function send_comment( $tid , $comment , $cid = '' )
	{
		$this->postdata[] = 'id=' . $tid;
		$this->postdata[] = 'comment=' . urlencode($comment);
		if( intval($cid) > 0 ) $this->postdata[] = 'cid=' . $cid;
		return $this->call_method( 'statuses' , 'comment'  );
	}
	
	function reply( $tid , $reply , $cid  )
	{
		$this->postdata[] = 'id=' . $tid;
		$this->postdata[] = 'comment=' . urlencode($comment);
		if( intval($cid) > 0 ) $this->postdata[] = 'cid=' . $cid;
		return $this->call_method( 'statuses' , 'comment'  );
	}
	
	function send_direct_messages( $screen_name , $text  )
	{
		$this->postdata[] = 'screen_name=' . urlencode($screen_name);
		$this->postdata[] = 'text=' . urlencode($text);
		return $this->call_method( 'direct_messages' , 'new'  );
	}
	
	function remove_comment( $cid )
	{
		return $this->call_method( 'statuses' , 'comment_destroy/'.$cid  );
	}
	
	function emotions() 
    { 
        return $this->call_method( '' , 'emotions' , ''  );
    } 
	
	// add favorites supports
	
	function get_favorites( $page = 1 ) 
    { 
        return $this->call_method( '' , 'favorites' , '?page=' . $page  );
    } 

    function add_to_favorites( $sid ) 
    { 
        $this->postdata[] = 'id=' . $sid;
        return $this->call_method( 'favorites' , 'create'   );
    } 

    function remove_from_favorites( $sid ) 
    { 
        $this->postdata[] = 'id=' . $sid;
        return $this->call_method( 'favorites' , 'destroy'   ); 
    } 
    
    // add account supports
    function verify_credentials() 
    { 
        return $this->call_method( 'account' , 'verify_credentials' );
    }

	
	function call_method( $method , $action , $args = '' ) 
	{
		
		curl_setopt( $this->curl , CURLOPT_POSTFIELDS , join( '&' , $this->postdata ) );
		
		$url = $this->base . $method . '/' . $action . '.json' . $args ;
		
		
		
		$header_array = array();

        $header_array["FetchUrl"] = $url;
        $header_array['TimeStamp'] = date('Y-m-d H:i:s');
        //$header_array['AccessKey'] = $_SERVER['HTTP_ACCESSKEY'];
		$header_array['AccessKey'] = SAE_ACCESSKEY;

        $content="FetchUrl";

        $content.=$header_array["FetchUrl"];

        $content.="TimeStamp";

        $content.=$header_array['TimeStamp'];

        $content.="AccessKey";

        $content.=$header_array['AccessKey'];

        //$header_array['Signature'] = base64_encode(hash_hmac('sha256',$content, $_SERVER['HTTP_SECRETKEY'] ,true));
		$header_array['Signature'] = base64_encode(hash_hmac('sha256',$content, SAE_SECRETKEY ,true));
		
		$header_array2=array();
        foreach($header_array as $k => $v)
            array_push($header_array2,$k.': '.$v);

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header_array2 ); 
        curl_setopt($this->curl, CURLOPT_URL, SAE_FETCHURL_SERVICE_ADDRESS );
		
		$ret = curl_exec( $this->curl );
		
		// clean post data
		$this->postInit();
		
		return json_decode( $ret , true);
		/*
		$response=array();
		$header_callback=curl_getinfo( $this->curl );
		array_push($response,$header_callback);
		$json_response=json_decode( $ret , true);
		array_push($response,$json_response);
		return $response;
		*/
		
	}
	
	function __destruct ()
	{
		curl_close($this->curl);
	}
	
	

	
	
	
	
	
	//function 
	
	
	

	
	
}


?>