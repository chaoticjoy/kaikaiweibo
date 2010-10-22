/**
 * @author Administrator
 */
var toggle=1;
var kkwb={//kaikai weibo
	history:[],
	currentPanel:null,//当前显示的Panel
	onClickPostBtn:function(){
		//设置遮罩的高宽为当前文档的高宽,开启遮罩,弹出编辑框
		var docHeight=$(document).height(); 
		var docWidth=$(document).width();
		$("#mask").width(docWidth)
				  .height(docHeight)
				  .show();
		$("#send").show();
	},
	onClickEventBtn:function(){
		if (toggle == 1) {
			$("#wrapper").hide(200);
			toggle=0;
		}else {
			$("#wrapper").show(200);
			toggle=1;
		}
		
	},
	onClickCheckBtn:function(){
		
	},
	onClickCityBtn:function(){
		
	},
	onClickUserBtn:function(){
		
	}
};

function onLoad(){
	//隐藏前进后退箭头
	$("#back").hide();
	$("#forward").hide();
	//顶栏各个按钮
	$("#post-btn").click(function(){
		kkwb.onClickPostBtn();
	});
	$("#event-btn").click(function(){
		kkwb.onClickEventBtn();
	});
	$("#check-btn").click(function(){
		kkwb.onClickCheckBtn();
	});
	$("#city-btn").click(function(){
		kkwb.onClickCityBtn();
	});
	$("#user-btn").click(function(){
		kkwb.onClickUserBtn();
	});
	//send btn
	$("#send").click(function(){
		$(this).hide();
		$("#mask").hide();
	})
}
