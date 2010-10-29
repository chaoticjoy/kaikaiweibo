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
    openComments: function(id){
        var commentContainer = $('#comments-' + id);
        if (commentContainer.css('display') == 'none') {
            //加截评论内容
            
            //显示
            commentContainer.show();
        }
        else {
            commentContainer.hide();
        }
    },
    
    openRetweet: function(id){
        var retweetContainer = $('#retweet-' + id);
        if (retweetContainer.css('display') == 'none') {
            retweetContainer.show();
        }
        else {
            retweetContainer.hide();
        }
    },
    reply: function(id, name){
        var contentArea = $('#comment-content-' + id);
        var content = contentArea.val();
        contentArea.val('回复:@' + name + ' ' + content);
        contentArea[0].focus();
    },
    openImage: function(event){
        this.showMask();
        var thumbnail = event.currentTarget.src;
        var bmiddle = thumbnail.replace('thumbnail', 'bmiddle');
        //---
		var img=$('#image-content');
		img[0].src=bmiddle;
		img[0].onload=function(){
			//img.css('z-index','200');
			var scale;
			
			var properWidth=$(document).width()-30;
			if(img.width()>properWidth){
				scale=img.width()/properWidth;
				img.width(properWidth);
				img.height(img.height()/scale);
			}
			$('#image').show()
			.css('margin-left',-img.width()/2)
			.css('margin-top',document.body.scrollTop-img.height()/2);	
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
        
        
        node.className = 'on';
        switch (type) {
            case 'events':
                break;
            case 'following':
                break;
            case 'followers':
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
		        alert('发普通消息'+$("#send-content").val()+'nor');
		    }
		}else if(type=='dm'){
			$('#send-title').text('发送私信给: '+name);
			$("#send-btn")[0].onclick=function(){
		        alert('发私信给：'+$("#send-content").val());
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
});
