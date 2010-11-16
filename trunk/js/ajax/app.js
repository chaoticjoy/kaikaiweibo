/**
 * @author Administrator
 */
var sinaApp={
	user:'',
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
	addFavourite:function(id){
		 var arg={};
		 arg.id=id;
		$.post("ajax/add_to_favorites.php",arg,function(data,textStatus){
			
		});
	},
	
	sendDirectMessage:function(msg,name){
		
	},
	sendMessage:function(status){
		var arg={};
		arg.status=status;
		$.post("ajax/update.php",arg,function(data,textStatus){
			
		});
	},
	sendComment:function(id){
		var content=$('#comment-content-'+id).val();
		alert("评论:"+content);
	},
	sendRetweet:function(id){
		//var content=$('#retweet-content-'+id).val();
		var arg={};
		arg.id=id;
		arg.status=$('#retweet-content-'+id).val();
		$.post("ajax/repost.php",arg,function(data,textStatus){
			
		});
	},
	getUserInfo:function(name){
		sinaApp.user=name;//标记当前用户信息正在显示的用户名
		var arg={};
		if(name)
			arg.screen_name=name;
		$.post("ajax/userinfo.php",arg,function(data,textStatus){
			$("#user-panel-header").empty()//清空后插入
			.append(data);	
		});
		//插入后载入动态
		this.getUserTimeline();
	},
	getUserTimeline:function(maxid){
		//
		var arg={};
		arg.screen_name=sinaApp.user;
		if (maxid) {
			arg.max_id = maxid;
		}
		else {//如果不带Max参数表示第一次打开,所以要清空
			$("#user-events-content").empty();
		}

		$.post("ajax/user_timeline.php",arg,function(data,textStatus){
			$("#user-events-content").append(data);	
		});
	},
	getUserFollowing:function(cursor){
		var arg={
			screen_name:sinaApp.user,
			count:20
		}
		if(cursor)
			arg.cursor=cursor;
		else	$("#user-following").empty();
		$.post("ajax/friends.php",arg,function(data,textStatus){
			$("#morefollowing").remove();
			$("#user-following").append(data);
		});
	},
	getUserFollowers:function(cursor){
		var arg={
			screen_name:sinaApp.user,
			count:20
		}
		if(cursor)
			arg.cursor=cursor;
		else $("#user-followers").empty();
		
		$.post("ajax/followers.php",arg,function(data,textStatus){
			$("#morefollowers").remove();
			$("#user-followers").append(data);
		});
	},
	moreUserEvents:function(){
		var lastchild=document.getElementById("user-events-content").lastChild;
		while(lastchild&&lastchild.nodeType!=1){
			lastchild=lastchild.previousSibling;
		}
		if(lastchild){
			var maxid;
			maxid=lastchild.id;
			maxid=maxid.split('-')[2];
			this.getUserTimeline(maxid);
		}
		
	},
	moreFollowers:function(cursor){
		this.getUserFollowers(cursor);
	},
	moreFollowing:function(cursor){
		this.getUserFollowing(cursor);
	}

}
var kkApp={
	
}
