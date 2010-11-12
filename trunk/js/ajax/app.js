/**
 * @author Administrator
 */
var sinaApp={
	
	/**
	 * 
	 * @param {boolean} clear  表示是否清楚SinaEvents里有所有元素
	 */
	moreEvents:function(clear){
		var container=$('#sinaEvents-content');
		if(clear)//如果为True则清空
			container.empty();
		var sc=document.getElementById('sinaEvents-content');
		
		
		var lastchild=sc.lastChild;
		while(lastchild&&lastchild.nodeType!=1){
			lastchild=lastchild.previousSibling;
		}
		var maxid=null;//默认是没有最大ID，当有子节点时才会有最大ID
		if(lastchild){//如果有最后一个节点
			maxid=lastchild.id;
			maxid=maxid.split('-')[2];
		}
		var arg={};
		if(maxid)
			arg.max_id=maxid; 
		
		$.post("ajax/friends_timeline.php",arg,function(data,textStatus){
			container.append(data);
		});
		
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
