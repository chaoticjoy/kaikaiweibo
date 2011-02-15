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
	/**
	 * 
	 * @param {Object} str
	 * @param {Object} duration 如果有则表示持续时间
	 */
    showTip:function(str,duration){
		var tip=$("#pop-msg").html("<p>"+str+"</p>")
				.css('margin-top',window.pageYOffset-30).show();
		if(duration){
			setTimeout("$('#pop-msg').hide()", duration);
		}
	},
	hideTip:function(){
		$("#pop-msg").hide();
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
	/**
	 * 
	 * @param {string} target panel's id;need to add a '#' before id
	 * @param {String} bid target button's id ;need to add a '#' before id
	 * @param {Boolean} history if undefined or true  ,then it will be auto added to historys,
	 *                 
	 */ 
    changePanel: function(tid, bid, history){
        if (tid == this.currentPanel) 
            return;
        
        if (history == undefined||history) {//是否将当前动作加入历史
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
		var refresh=false;
		if(gui.currentBtn=='#events-btn'){
			refresh=true;
		}
		//如果当前选中的是Event,则刷新当前选中的动态新浪或开开
		if (refresh) {
			if (gui.selectedEvent == 'kk') {
				kk.moreEvents(true);
			}
			else {
				sinaApp.moreEvents(true);
			}
		}
        this.changePanel(0, '#events-btn');
    },
    onClickCheckinBtn: function(id){
        
		//第一次载入或再次点击.
		if(!this.firstLoadCheckin||'#checkin-btn'==this.currentBtn){
			this.firstLoadCheckin=true;
			kk.moreCheckin(true);
		}
		this.changePanel(1, '#checkin-btn');
    },
    onClickCityBtn: function(id){
		//第一次载入或再次点击.
		if(!this.firstLoadCity||'#city-btn'==this.currentBtn){
			this.firstLoadCity=true;
			var arg={
				latlng:kk.lat+','+kk.lon,
				pinying:0
			}
			gui.showTip('获取地点...');
			$.post("ajax/address_lookup.php",arg,function(data,textStatus){
				kk.cityName=data;
				//alert('weather:'+kk.cityName);
				kk.getWeather();
			});
			arg.pinying=1;
			$.post("ajax/address_lookup.php",arg,function(data,textStatus){
				gui.hideTip();
				kk.cityNamePY=data;
				//alert('moreEvents:'+kk.cityNamePY);
				douban.moreEvents(true);
			});
		}
		this.changePanel(2, '#city-btn');
    },
	/**
	 * User标签按钮
	 * TODO: 是否每次点击都默认打开新浪的当用户,或是改成每次打开都是上一次的用户资料,直到再次刷新为止?
	 * 
	 * @param {Object} id
	 */
    onClickUserBtn: function(id){
		if (!this.firstLoadUser || '#user-btn' == this.currentBtn) {
			gui.openUserInfo('','','sina');
			this.firstLoadUser=true;
		}
		this.changePanel(3, '#user-btn');
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
				$("#comment-list-"+id).empty();
				sinaApp.getCommentList(id);
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
			"<div id=\"comment-list-"+id+ "\">" +
			"</div>";
			//"<div class='main-button' onClick='sinaApp.moreComments(\""+id+"\")'>更多评论</div>"
			status.append(comment);
			sinaApp.getCommentList(id);
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
				content[0].value='//@'+status.attr('username')+":"+$("#sina-status-" + id).text().trim();
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
	openCheckin:function(node,id){
		var signBox=
		'<form>'+
		'<textarea rows="2"></textarea>'+
		'<input type="button"  class="submit-button" value="签到" onclick="kk.checkin(this.previousElementSibling.value,'+id+')"/>'+
		'</form>';
		var container=$('#checkin-'+id);
		if(container.length>0){//已加入
			if(container.css('display') == 'none'){
				//清空TIPS
				container.html(signBox);
				container.show();
			}else{
				container.hide();
			}
		}else {//新建节点
			var sign=document.createElement('div');
			sign.className="checkin";
			sign.id="checkin-"+id;
			sign.innerHTML=signBox;
			node.appendChild(sign);
		}

	},
    openImage: function(target){
        
        var thumbnail = target.src;
        var bmiddle = thumbnail.replace('thumbnail', 'bmiddle');
        //---
		var img=$('#image-content');
		img[0].src=bmiddle;
		var imgObj=new Image();
		imgObj.src=bmiddle;
		gui.showTip('图片打开中．．．');
		imgObj.onload=function(){
			gui.showMask();
			//img.css('z-index','200');
			gui.hideTip();
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
		imgObj.onerror=function(){
			gui.showTip('打开图片失败',1500);
		}
		
    },
	closeImage:function(){
		this.hideMask();
		$("#image").hide();
	},
    //under events-panel
    showEvents: function(node, type){
		var refresh=false;
		if(type==gui.selectedEvent){
			refresh=true;
		}
		gui.selectedEvent=type;//当前选中的动态
		
        var p = node.parentNode;
        //前两个元素清空Class
        p.children[0].className = '';
        p.children[1].className = '';
        node.className = 'on';//把当前按钮点亮
        if (type == 'sina') {//如果
            $('#sinaEvents').show();
            $('#kkEvents').hide();
            if(refresh)
				sinaApp.moreEvents(true);
			else if(!this.sinaEventLoaded){
				sinaApp.moreEvents(true);
				this.sinaEventLoaded=true;
			}
        }
        else 
            if (type == 'kk') {
                $('#kkEvents').show();
                $('#sinaEvents').hide();
				if(refresh)
					kk.moreEvents(true);
				else if(!this.kkEventLoaded){
					kk.moreEvents(true);
					this.kkEventLoaded=true;
				}
            }
    },
    /**
     * 新浪用户标签,里的三个按钮切换.
     * @param {Object} node
     * @param {Object} type
     */
    showUser: function(node, type){
		var refresh=false;
		if(node.getAttribute('class')=='on'||node.getAttribute('loaded')==null){//已打开,表示刷新.
			refresh=true; 
			node.setAttribute('loaded','true');
		}
        var p = node.parentNode;
        p.children[0].className = "";
        p.children[1].className = "";
        p.children[2].className = "";
        
        $("#user-events").hide();
		$("#user-following").hide();
		$("#user-followers").hide();

        node.setAttribute('class','on');
        switch (type) {
            case 'events':
				 $("#user-events").show();
				 if(refresh)
				 if(this.kkUserInfoLoaded)
				 	kk.moreUserEvents(true);
				 else 
				 	sinaApp.getUserTimeline();
                break;
            case 'following':
				$("#user-following").show();
				 if(refresh)
				 if(this.kkUserInfoLoaded)
				 	kk.moreFriends(true);
					else
				sinaApp.getUserFollowing();
                break;
            case 'followers':
				$("#user-followers").show();
				 if(refresh)
				 if(this.kkUserInfoLoaded)
				 	kk.moreFollowers(true);
					else
				sinaApp.getUserFollowers();
                break;
        }
    },
	/**
	 * 点击用户的头像进而打开Userinfo面板
	 * 包括新浪的和开开的.
	 * 
	 * @param {Object} id
	 * @param {Object} type
	 */
	openUserInfo:function(id,name,type){
		gui.changePanel(3, '#user-btn');
		var url="kk_userinfo.php";
		var arg={};
		arg.id=id;
		$("#user-events").hide();
		$("#user-following").hide();
		$("#user-followers").hide();
		$("#user-events").show();
		if(type=='kk'){
			this.kkUserInfoLoaded=true;
			kk.userInfo.id=id;
			kk.userInfo.name=name;
			//默认打开用户动态
			gui.showTip('载入中．．．');
			$.post("ajax/"+url,arg,function(data,textStatus){
				$("#user-panel-header").empty().append(data);
				gui.hideTip();
				if(textStatus!='success'){
					gui.showTip('载入失败，请重新载入',500);
				}
			});
			kk.moreUserEvents(true);
		}else if(type=='sina'){
			sinaApp.userInfo.id=id;
			sinaApp.userInfo.name=name;			
			this.kkUserInfoLoaded=false;
			//
			sinaApp.getUserInfo();
			sinaApp.getUserTimeline();
		}
		

		
	},
	hideSend:function(){
		this.hideMask();
		$("#send").hide();
	},
	/**
	 * 
	 * @param {Object} type
	 * @param {Object} id
	 * @param {Object} name
	 */
	sendMsg:function(type,id,name){
		this.showMask();
        $("#send").show();
		
		$("#send-content").val('')[0].focus();
		
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
		}else if(type=='douban'){
			$("#send-content").val('我分享了一个活动:'+id+' '+name+' ');
			$('#send-title').text('分享一个活动');
			$("#send-btn")[0].onclick=function(){
				sinaApp.sendMessage($("#send-content").val());
		    }
		}
	},
	getCityEvent:function(node,type){
		if(type=='event'){
			node.className="on";
			node.nextElementSibling.className="";
			$('#acti').show();
			$('#group-buy').hide();
			if(this.lastDBType==type||node.getAttribute('load')!='true'){
				douban.moreEvents(true);
				node.setAttribute('load','true');
			}
			this.lastDBType=type;
		}else if(type=='groupbuy'){
			
			$('#group-buy').show();
			$('#acti').hide();
			node.className="on";
			node.previousElementSibling.className="";
			if(this.lastDBType==type||node.getAttribute('load')!='true'){
				lashou.moreGroupBuy(true);
				node.setAttribute('load','true');
			}
			this.lastDBType=type;
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
    /**
     * 载入当前的位置
     *
     */
    
	//navigator.geolocation.getCurrentPosition(function(position){
	navigator.geolocation.watchPosition(function(position){
        kk.lat=position.coords.latitude;
        kk.lon=position.coords.longitude;
		alert('当前位置->经度:'+kk.lon+' 纬度:'+kk.lat);
		gui.showTip('已更新你的位置',1000);
    }, function(error){
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("你的浏览器不允许获取地理位置");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("获取不到你当前的位置");
                break;
            case error.TIMEOUT:
                alert("获取地理位置超时");
                break;
                
            default:
                alert("获取地理位置时发生未知错误");
                break;
        }
    });
	
	
});