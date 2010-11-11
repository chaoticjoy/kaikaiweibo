/**
 * @author Administrator
 */
var sinaApp={
	moreEvents:function(){
		$('#sinaEvents').load("ajax/friends_timeline.php",{count:20});
	},
	moreComments:function(id){
		
	},
	sendComment:function(id){
		var content=$('#comment-content-'+id).val();
		alert("评论:"+content);
	},
	sendRetweet:function(id){
		var content=$('#retweet-content-'+id).val();
		alert("转发:"+content);
	}
}
var kkApp={
	
}
