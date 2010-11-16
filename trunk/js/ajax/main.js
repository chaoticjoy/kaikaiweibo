/**
 * @author Administrator
 */
var toggle = 1;
var gui = {//kaikai weibo
    history: [[0, "#events-btn"]],
    currentHistory: 0,///当前历史的Index
    currentPanel: 0,//
    currentBtn: '#events-btn',
    panels: ["#events-panel", "#checkin-panel", "#city-panel", "#user-panel"],
    
    //组件，
    components: {},
    
    init: function(){
        this.components.mask = $("#mask");
        this.components.image = $("#image");
    },
    
    showMask: function(){
        //alert($(document).height()+" "+$(document).width());
        this.components.mask.width($(document).width()).height($(document).height()).show();
    },
    hideMask: function(){
        this.components.mask.hide();
    },
    
    onClickPostBtn: function(){//
		this.sendMsg('normal');
    },
    //tid target panel's id;need to add a '#' before ids. buttonid 
    changePanel: function(tid, bid, history){
        if (tid == this.currentPanel) 
            return;
        
        if (history == undefined) {//不是进行历史操作
            $("#back").show();
            while ((this.history.length - 1) > this.currentHistory) {
                this.history.pop();
            }
            this.history.push([tid, bid]);
            this.currentHistory = this.history.length - 1;
        }
        //alert("c"+this.currentHistory);
        
        var speed = 200;
        var docw = $(document).width();
        var cpanel = $(this.panels[this.currentPanel]);
        var tpanel = $(this.panels[tid]);
        
        //判断向左还是向右滑
        var moveoption = {};
        if (tid > this.currentPanel) {
            moveoption = {
                right: "" + docw + 'px',
                left: '-' + docw + 'px'
            }
            tpanel.css('left', docw + 'px').css('right', '-' + docw + 'px');
        }
        else {
            moveoption = {
                right: "-" + docw + 'px',
                left: '' + docw + 'px'
            }
            tpanel.css('left', -docw + 'px').css('right', +docw + 'px');
        }
        //结束
        tpanel.show();
        
        cpanel.animate(moveoption, {
            duration: speed,
            complete: function(){
                cpanel.hide().css('right', '0').css('left', '0');
            }
        });//向左滑动一个屏幕宽度
        tpanel.animate({
            left: '0px',
            right: '0px'
        }, speed);
        //
        
        //把按钮样式设置为on
        $(this.currentBtn).removeClass('on');
        $(bid).addClass('on');
        this.currentBtn = bid;
        this.currentPanel = tid;
    },
    
    
    onClickEventBtn: function(id){
		sinaApp.moreEvents(true);
        this.changePanel(0, '#events-btn');
    },
    onClickCheckinBtn: function(id){
        this.changePanel(1, '#checkin-btn');
    },
    onClickCityBtn: function(id){
        this.changePanel(2, '#city-btn');
    },
    onClickUserBtn: function(id){
        this.changePanel(3, '#user-btn');
		//载入当前用户的info.
		
		sinaApp.getUserInfo();
    },
    //前进后退按钮
    back: function(){
        var h = this.currentHistory - 1;
        //alert(h);
        if (h == 0) {
            $("#back").hide();
        }
        if (h < 0) 
            return;
        this.currentHistory--;
        this.changePanel(this.history[h][0], this.history[h][1], false);
    },
    //查看评论,
    openComments: function(app,type,id){
		$('#retweet-' + id).hide();
        var commentContainer = $('#comments-' + id);
		if (commentContainer.length > 0) {//已经加入，也就是第二次点击评论了。
			if (commentContainer.css('display') == 'none') {
				//加截评论内容
				
				//显示
				commentContainer.show();
			}
			else {
				commentContainer.hide();
			}
		}else{//如果还没有加入
			//获取微博节点
			var status=$('#'+app+'-'+type+'-'+id);
			//根据模板创建节点
			var comment=document.createElement('div');
			comment.className='comments'
			comment.id="comments-"+id;
			
			comment.innerHTML=
			"<form>"+
				"<textarea rows='2' id='comment-content-"+id+"'></textarea>"+
				"<input type='button' onClick='sinaApp.sendComment(\""+id+"\")' class='submit-button' value='评论' />"+
			"</form>"+
	/*
	<p>
		<span class="author">$someone</span>
		$someone_comment
		<span class="reply" onClick="gui.reply('$id','$name')">回复</span>
		//....
	</p>
	*/	
			"<div class='main-button' onClick='sinaApp.moreComments(\""+id+"\")'>更多评论</div>"
			status.append(comment);
		}
    },
    /**
     * 
     * @param {Object} app
     * @param {Object} type
     * @param {Object} id
     * @param {Boolean} isRT　本条微博是否转自他人．
     */
    openRetweet: function(app,type,id,isRT){
		
        var retweetContainer = $('#retweet-' + id);
		$('#comments-' + id).hide();
		if (retweetContainer.length > 0) {
			if (retweetContainer.css('display') == 'none') {
				retweetContainer.show();
			}
			else {
				retweetContainer.hide();
			}
		}else{
			var status=$('#'+app+'-'+type+'-'+id);
			var retweet=document.createElement('div');
			retweet.className='retweet';
			retweet.id='retweet-'+id;
			
			var retStr=
			"<form>"+
				"<textarea rows='2' id='retweet-content-"+id+"'></textarea>"+
				"<input type='button' onClick='sinaApp.sendRetweet(\""+id+"\")' class='submit-button' value='转发' />"+
			"</form>";
			retweet.innerHTML=retStr;
			status.append(retweet);			
			var content=$("#retweet-content-"+id);
			if (isRT) {
				content[0].value='//'+$("#sina-status-" + id).text().trim();
				content[0].selectionEnd=0;
				content[0].selectionStart=0;
			}
			content[0].focus();
		}
    },
    reply: function(id, name){
        var contentArea = $('#comment-content-' + id);
        var content = contentArea.val();
        contentArea.val('回复:@' + name + ' ' + content);
        contentArea[0].focus();
    },
	addFavourite:function(app,type,id){
		if(app=='sina')
			sinaApp.addFavourite(id);
	},
    openImage: function(target){
        this.showMask();
        var thumbnail = target.src;
        var bmiddle = thumbnail.replace('thumbnail', 'bmiddle');
        //---
		var img=$('#image-content');
		img[0].src=bmiddle;
		var imgObj=new Image();
		imgObj.src=bmiddle;
		imgObj.onload=function(){
			//img.css('z-index','200');
			
			$('#image').show();
			var scale;
			
			var properWidth=window.innerWidth-40;
			var properHeight=window.innerHeight-40;
			//alert(properWidth+': '+properHeight+' \n'+img.width()+':'+img.height());
			img.width(imgObj.width).height(imgObj.height);
			
			if(img.width()>properWidth){
				scale=img.width()/properWidth;
				img.width(properWidth);
				img.height(img.height()/scale);
			}
			
			if(img.height()>properHeight){
				
				scale=img.height()/properHeight;
				img.height(properHeight);
				img.width(img.width()/scale);
			}
			$('#image')
			.css('margin-left',-img.width()/2)
			.css('margin-top',window.pageYOffset-img.height()/2);	
		}
		
		
    },
	closeImage:function(){
		this.hideMask();
		$("#image").hide();
	},
    //under events-panel
    showEvents: function(node, type){
        var p = node.parentNode;
        //前两个元素清空Class
        p.children[0].className = '';
        p.children[1].className = '';
        node.className = 'on';//把当前按钮点亮
        if (type == 'sina') {//如果
            $('#sinaEvents').show();
            $('#kkEvents').hide();
            
        }
        else 
            if (type == 'kk') {
                $('#kkEvents').show();
                $('#sinaEvents').hide();
                
            }
    },
    //under user-panel
    showUser: function(node, type){
        var p = node.parentNode;
        p.children[0].className = "";
        p.children[1].className = "";
        p.children[2].className = "";
        
        $("#user-events").hide();
		$("#user-following").hide();
		$("#user-followers").hide();
		
        node.className = 'on';
        switch (type) {
            case 'events':
				 $("#user-events").show();
				 sinaApp.getUserTimeline();
                break;
            case 'following':
				$("#user-following").show();
				sinaApp.getUserFollowing();
                break;
            case 'followers':
				$("#user-followers").show();
				sinaApp.getUserFollowers();
                break;
                
        }
    },
	sendMsg:function(type,id,name){
		this.showMask();
        $("#send").show();
		$("#send-content").val('');
		if(type=='normal'){
			$('#send-title').text('说说你的新鲜事');
			$("#send-btn")[0].onclick=function(){
		        //alert('发普通消息'+$("#send-content").val()+'nor');
				sinaApp.sendMessage($("#send-content").val());
		    }
		}else if(type=='dm'){
			$('#send-title').text('发送私信给: '+name);
			$("#send-btn")[0].onclick=function(){
		        //alert('发私信给：'+$("#send-content").val());
				sinaApp.sendDirectMessage($("#send-content").val());
		    }
		}
	}
    
};

$(function(){
    gui.init();
    //隐藏前进后退箭头
    $("#back").hide();
    //顶栏各个按钮
    $("#post-btn").click(function(){
        gui.onClickPostBtn();
    });
    $("#events-btn").click(function(){
        gui.onClickEventBtn();
    });
    $("#checkin-btn").click(function(){
        gui.onClickCheckinBtn();
    });
    $("#city-btn").click(function(){
        gui.onClickCityBtn();
    });
    $("#user-btn").click(function(){
        gui.onClickUserBtn();
    });
    
    //发布界面的关闭按钮
    $("#close-btn").click(function(){
        $("#send").hide();
        gui.hideMask();
    });
    //发布按钮
    
    //初始化时只显示第一个Tab
    $("#tabpanel").css('position', 'relative');
    $("#tabpanel :first-child").show();
	$("#image").hide();
	
	sinaApp.moreEvents(true);
});
