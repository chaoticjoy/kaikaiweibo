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
		gui.showTip('载入中．．．')
		$.post("ajax/friends_timeline.php",arg,function(data,textStatus){
			container.append(data);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});
		
	},
	moreComments:function(id){
		
	},
	addFavourite:function(id){
		 var arg={};
		 arg.id=id;
		 gui.showTip('正在收藏．．．')
		$.post("ajax/add_to_favorites.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('收藏成功!',500);
				$("#comments-"+id).hide();
			}else {
				gui.showTip('收藏失败',500);
			}
		});
	},
	
	sendDirectMessage:function(msg,name){
		var arg={};
		arg.screen_name=name;
		arg.text=msg;
		
		gui.showTip('发送私信中．．．');
		$.post("ajax/send_direct_messages.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('发送成功!',500);
				gui.hideSend();
			}else {
				gui.showTip('发送失败',1500);
			}
		});
	},
	sendMessage:function(status){
		var arg={};
		arg.status=status;
		gui.showTip('发送中．．．')
		$.post("ajax/update.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('发送成功!',500);
				gui.hideSend();
			}else {
				gui.showTip('发送失败',500);
			}
		});
	},
	sendComment:function(id){
		var content=$('#comment-content-'+id).val();
		
		var arg={};
		arg.id=id;
		if(content=='')return;
		arg.status=content;

		gui.showTip('评论发送中....');		
		$.post("ajax/send_comment.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('评论成功!',500);
				$("#comments-"+id).hide();
			}else {
				gui.showTip('评论失败',500);
			}
		});
	},
	sendRetweet:function(id){
		//var content=$('#retweet-content-'+id).val();
		var arg={};
		arg.id=id;
		arg.status=$('#retweet-content-'+id).val();
		gui.showTip('发送中....');
		$.post("ajax/repost.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('发送成功!',500);
				$("#retweet-"+id).hide();
			}else {
				gui.showTip('发送失败',500);
			}
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
		$("#user-events").show();
		$("#user-following").hide();
		$("#user-followers").hide();
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
		gui.showTip('载入中...');		
		
		$.post("ajax/user_timeline.php",arg,function(data,textStatus){
			$("#user-events-content").append(data);	
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',1500);	
			}
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
		gui.showTip('载入中...');
		$.post("ajax/friends.php",arg,function(data,textStatus){
			$("#morefollowing").remove();
			$("#user-following").append(data);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',1500);	
			}
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
		gui.showTip('载入中...');
		$.post("ajax/followers.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',1500);	
			}
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
	getCommentList:function(id){
		
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
