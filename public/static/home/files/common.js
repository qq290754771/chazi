$(function(){
	//$(".left-side,.right-side,form").bind('click',function(){
	//	$(".dropdown-menu").css('display','none');
	//});
	/*  $('.dropdown').bind('click',function(){
		 
	     $(this).find("dropdown-menu").toggle();
		 
     }); */
	// $('.user-menu').bind('click',function(){
		 
	//    $(this).find(".dropdown-menu").toggle();
		 
   //  });
	 // $('.tasks-menu').bind('click',function(){
	//	 
	//    $(this).find(".dropdown-menu").toggle();
    // });  

})
var submit_lock = false;
var reset; //全局变量,修改广告主密码layer弹窗索引
//ajax提交信息  默认为post提交
function ajaxSubmit( data , url ) {
	 if(submit_lock){
				/*layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
						  time: 3000, //2s后自动关闭
				 }); */
				 $(".loadings").fadeIn();
                return;
            } 
	submit_lock = true;
	
	//函数默认参数赋值es5 严谨写法，主要是为了兼容ie，es6可以直接赋值默认函数
	var method= typeof arguments[2]!== 'undefined' ? arguments[2] : 'post' ;

	if( !url || url =='' ){
		url = window.location.href;
	}
	$.ajax({
		url:url,
		type:method,
		dataType:'json',
		data:data,
		async: true,
		//timeout:30000,
		beforeSend:function(){
					/* layer.msg('<font color="white" style="font-size:12px;">数据请求中，请稍后</font>', {
						 // time: 300000, //2s后自动关闭
				 }); */
				 $(".loadings").fadeIn();
				},
		complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			/*if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			  //ajaxTimeOut.abort(); //取消请求
			   layer.msg('<font color="white">网络不稳定...</font>', {
				 });
			$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			} */
			$(".loadings").fadeOut();
        }, 
		success:function( data ){
$(".loadings").fadeOut();			
		layer.close(reset);
		$(".layui-layer-shade").remove();
		$(".layui-layer").remove();
		    submit_lock = false;
			//验证不通过
			if (data.status === 0 ) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				return;
			//验证信息错误
			}else if(data.status === 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//验证成功
			}else if (data.status === 1) {
				 layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				 
				if (data.type == 'alertLayerWindow') {
					rightAjax(data.url);					
				}else{
					if(data.url!='/admin/'&&data.url!='/'){
						setTimeout(rightAjax(data.url),3000);
					}else if(data.url=='/'){
						setTimeout("window.location.href='/'",3000);
					}else{
						setTimeout('window.location.href='+data.url+'',3000);
					}
				}							
			}
			
		}	
	})
} 
function ajaxSubmitnm( data , url ) {
	if(submit_lock){
				//layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				//		  time: 3000, //2s后自动关闭
				// });
				 $(".loadings").fadeIn();
                return;
            }
	submit_lock = true;
	//函数默认参数赋值es5 严谨写法，主要是为了兼容ie，es6可以直接赋值默认函数
	var method= typeof arguments[2]!== 'undefined' ? arguments[2] : 'post' ;

	if( !url || url =='' ){
		url = window.location.href;
	}
	$.ajax({
		url:url,
		type:method,
		dataType:'json',
		data:data,
		async: true,
		//timeout:30000,
		beforeSend:function(){
					// layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				 //});
				  $(".loadings").fadeIn();
				},
		complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			//if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			//  ajaxTimeOut.abort(); //取消请求
			 //  layer.msg('<font color="white">网络不稳定...</font>', {
				// });
		//	$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			//}
			 $(".loadings").fadeIn();
        }, 
		success:function( data ){
			 $(".loadings").fadeOut();
$(".layui-layer-shade").remove();
		$(".layui-layer").remove();			
		submit_lock = false;
			//验证不通过
			if (data.status === 0 ) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				return;
			//验证信息错误
			}else if(data.status === 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//验证成功
			}else if (data.status === 1) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				if (data.type == 'alertLayerWindow') {
					//关闭广告主修改密码设置弹出窗口
					//rightAjax(data.url);
					window.location.reload();
					layer.close(reset);
				}else{
				//	layer.close(reset);
				//	if(data.url!='/admin/'&&data.url!='/'){
				//		setTimeout(rightAjax(data.url),3000);
				//	}else if(data.url=='/'){
				//		setTimeout("window.location.href='/'",3000);
				//	}else{
				//		setTimeout('window.location.href='+data.url+'',3000);
				//	}
					
				}							
			}
		}	
	})
}
function ajaxJump( data , url ) {
	if(submit_lock){
				//layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
					//	  time: 3000, //2s后自动关闭
				// });
				 $(".loadings").fadeIn();
                return;
            }
	submit_lock = true;
	//函数默认参数赋值es5 严谨写法，主要是为了兼容ie，es6可以直接赋值默认函数
	var method= typeof arguments[2]!== 'undefined' ? arguments[2] : 'post' ;

	if( !url || url =='' ){
		url = window.location.href;
	}
	$.ajax({
		url:url,
		type:method,
		dataType:'json',
		data:data,
		async: true,
		//timeout:30000,
		beforeSend:function(){
					// layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				 //});
				  $(".loadings").fadeIn();
				},
		complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			//if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			  //ajaxTimeOut.abort(); //取消请求
			 //  layer.msg('<font color="white">网络不稳定...</font>', {
				// });
			//$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			//}
			 $(".loadings").fadeIn();
        },		
		success:function( data ){
 $(".loadings").fadeOut();			
		$(".layui-layer-shade").remove();
		$(".layui-layer").remove();
		submit_lock = false;
			//验证不通过
			if (data.status === 0 ) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				return data;
			//验证信息错误
			}else if(data.status === 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return data;
			//验证成功
			}else if (data.status === 1) {				
					layer.close(reset);
					return data;
										
			}
		}	
	})
} 

function ajaxSubmitk( data , url ) {
	if(submit_lock){
				//layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				//		  time: 3000, //2s后自动关闭
				// });
				 $(".loadings").fadeIn();
                return;
            }
	submit_lock = true;
	//函数默认参数赋值es5 严谨写法，主要是为了兼容ie，es6可以直接赋值默认函数
	var method= typeof arguments[2]!== 'undefined' ? arguments[2] : 'post' ;

	if( !url || url =='' ){
		url = window.location.href;
	}
	var ajaxTimeOut=$.ajax({
		url:url,
		type:method,
		dataType:'json',
		data:data,
		async: true,
		timeout:30000,
		beforeSend:function(){
					 //layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				// });
				 $(".loadings").fadeIn();
				},
		complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			//if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			 // ajaxTimeOut.abort(); //取消请求
			 //  layer.msg('<font color="white">网络不稳定...</font>', {
				// });
			//$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			//}
			 $(".loadings").fadeIn();
        },		
		success:function( data ){ 
		 $(".loadings").fadeOut();
		$(".layui-layer-shade").remove();
		$(".layui-layer").remove();
		submit_lock = false;
			//验证不通过
			if (data.status === 0 ) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				return;
			//验证信息错误
			}else if(data.status === 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//验证成功
			}else if (data.status === 1) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				if (data.type == 'alertLayerWindow') {
					//关闭广告主修改密码设置弹出窗口
					rightAjax(data.url);
					layer.close(reset);
				}else{
					window.location.href="/";	
				}							
			}
		}	
	})
} 
function ajaxSubmitm( data , url ) {
	if(submit_lock){
				//layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				//		  time: 3000, //2s后自动关闭
				 //});
				  $(".loadings").fadeIn();
                return;
            }
	submit_lock = true;
	//函数默认参数赋值es5 严谨写法，主要是为了兼容ie，es6可以直接赋值默认函数
	var method= typeof arguments[2]!== 'undefined' ? arguments[2] : 'post' ;

	if( !url || url =='' ){
		url = window.location.href;
	}
	$.ajax({
		url:url,
		type:method,
		dataType:'json',
		data:data,
		async: true,
		//timeout:30000,
		beforeSend:function(){
					// layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				// });
				 $(".loadings").fadeIn();
				},
		complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			//if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			 // ajaxTimeOut.abort(); //取消请求
			  // layer.msg('<font color="white">网络不稳定...</font>', {
			//	 });
			//$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			//}
			 $(".loadings").fadeIn();
        },
		success:function( data ){
			 $(".loadings").fadeOut();
$(".layui-layer-shade").remove();
		$(".layui-layer").remove();			
		submit_lock = false;
			//验证不通过
			if (data.status === 0 ) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				return;
			//验证信息错误
			}else if(data.status === 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//禁用
			}else if(data.status === 3) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//非法账号			
			}else if(data.status === 4) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//验证成功
			}else if (data.status === 1) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				if (data.type == 'alertLayerWindow') {
					//关闭广告主修改密码设置弹出窗口
					rightAjax(data.url);
					layer.close(reset);
				}else{
					window.location.href="/admin";	
				}							
			}
		}	
	})
} 
function ajaxSubmitml( data , url ) {
	if(submit_lock){
				//layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				//		  time: 3000, //2s后自动关闭
				 //});
				  $(".loadings").fadeIn();
                return;
            }
	submit_lock = true;
	//函数默认参数赋值es5 严谨写法，主要是为了兼容ie，es6可以直接赋值默认函数
	var method= typeof arguments[2]!== 'undefined' ? arguments[2] : 'post' ;

	if( !url || url =='' ){
		url = window.location.href;
	}
	$.ajax({
		url:url,
		type:method,
		dataType:'json',
		data:data,
		async: true,
		//timeout:30000,
		beforeSend:function(){
					// layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				 //});
				  $(".loadings").fadeIn();
				},
	    complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			//if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			 // ajaxTimeOut.abort(); //取消请求
			 //  layer.msg('<font color="white">网络不稳定...</font>', {
				// });
			//$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			//}
			 $(".loadings").fadeIn();
        },			
		success:function( data ){ 
		 $(".loadings").fadeOut();
		$(".layui-layer-shade").remove();
		$(".layui-layer").remove();
		submit_lock = false;
			//验证不通过
			if (data.status === 0 ) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				return;
			//验证信息错误
			}else if(data.status === 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//验证成功
			}else if (data.status === 1) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				if (data.type == 'alertLayerWindow') {
					//关闭广告主修改密码设置弹出窗口
					rightAjax(data.url);
					layer.close(reset);
				}else{
					window.location.href="/index/Percon";	
				}							
			}
		}	
	})
}
function ajaxSubmits( data , url ) {
	if(submit_lock){
				//layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
					//	  time: 3000, //2s后自动关闭
				 ///});
				  $(".loadings").fadeIn();
                return;
            }
	submit_lock = true;
	//函数默认参数赋值es5 严谨写法，主要是为了兼容ie，es6可以直接赋值默认函数
	var method= typeof arguments[2]!== 'undefined' ? arguments[2] : 'post' ;

	if( !url || url =='' ){
		url = window.location.href;
	}
	$.ajax({
		url:url,
		type:method,
		dataType:'json',
		data:data,
		async: true,
		//timeout:30000,
		beforeSend:function(){
				//	 layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				 //});
				  $(".loadings").fadeIn();
				},
		complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			//if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			 // ajaxTimeOut.abort(); //取消请求
			 //  layer.msg('<font color="white">网络不稳定...</font>', {
			//	 });
			//$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			//}
			 $(".loadings").fadeIn();
        },		
		success:function( data ){
			 $(".loadings").fadeOut();
$(".layui-layer-shade").remove();
		$(".layui-layer").remove();			
		submit_lock = false;
			//验证不通过
			if (data.status === 0 ) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				return;
			//验证信息错误
			}else if(data.status === 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//验证成功
			}else if (data.status === 1) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				if (data.type == 'alertLayerWindow') {
					//关闭广告主修改密码设置弹出窗口
					rightAjax(data.url);
					layer.close(reset);
				}else{
					window.location.href="/index/Percon";	
				}							
			}
		}	
	})
} 
//ajax提交信息以及处理文件上传  默认为post提交
function ajaxFileSubmit( data , url ) {
	if(submit_lock){
				//layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				//		  time: 3000, //2s后自动关闭
				// });
				 $(".loadings").fadeIn();
                return;
            }
	submit_lock = true;
	//函数默认参数赋值es5 严谨写法，主要是为了兼容ie，es6可以直接赋值默认函数
	var method= typeof arguments[2]!== 'undefined' ? arguments[2] : 'post' ;

	if( !url || url =='' ){
		url = window.location.href;
	}
	$.ajax({
		url:url,
		type:method,
		data:data,
		dataType: 'json',
		async: true,
		//timeout:30000,
		beforeSend:function(){
					// layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				 //});
				  $(".loadings").fadeIn();
		},
		cache: false,
		processData:false, //处理上传文件后被序列化的问题 illegal invocation
		contentType:false,
		async:true,
		complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			//if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			 // ajaxTimeOut.abort(); //取消请求
			 //  layer.msg('<font color="white">网络不稳定...</font>', {
			//	 });
			//$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			//}
			// $(".loadings").fadeIn();
        },
		success:function( data ){ 
		 $(".loadings").fadeOut();
		$(".layui-layer-shade").remove();
		$(".layui-layer").remove();
		   submit_lock = false;
			//验证不通过
			if (data.status === 0 ) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				return;
			//验证信息错误
			}else if(data.status === 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
				verify();
				return;
			//验证成功
			}else if (data.status === 1) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });				 
				if (data.type == 'alertLayerWindow') {
					//关闭广告主修改密码设置弹出窗口
					setTimeout(rightAjax(data.url),3000);
					//layer.close(reset);
				}else{
					if (data.url != '/admin/' && data.url != '/') {					
						setTimeout(rightAjax(data.url),3000);
					}else if(data.url == '/'){
						setTimeout("window.location.href ='/'",3000);
					}else{
						setTimeout('window.location.href = '+data.url+'',3000);
					}
				}							
			}
		}	
	})
} 







//layer提示弹窗，cotnent提示内容，0-注意 1-成功 2-错误
function alertLayer( content ){

	var error= typeof arguments[1]!== 'undefined' ? arguments[1] : 0 ;
	var type= typeof arguments[2]!== 'undefined' ? arguments[2] : 0 ;

	layer.open({
		type:type,
		title:'提示',
		icon:error,
		offset:'auto',
		time:3000,
		content:content,
	})
}



//主页ajax 请求页面 
function rightSideLoad(){
	$(document).on('mousedown','.post-ajaxs',function(e){
		
		$('.post-ajax-parent').html($.trim($(this).parent().prev().text()));
		$('.post-ajax-me').html($(this).text());
		//$(this).addClass('active');
		
		$(this).parent().addClass('ant-menu-item-selected');
		//$(this).siblings('li').find('a').removeClass('active');
		$(this).parent().siblings('li').removeClass('ant-menu-item-selected');
		$('.wrapper').removeClass('active relative');
		//通过ajax 回传页面,放弃了iframe用法
		var url = $(this).attr('vincent-href');
		rightAjax(url);
		//传递信息
		

	});
		$(document).on('click','.post-ajax',function(e){
			//通过ajax 回传页面,放弃了iframe用法
			var url = $(this).attr('vincent-href');
			rightAjax(url);
			//传递信息
			//$('.post-ajax-parent').html($.trim($(this).parent().parent().prev().text()));
			//$('.post-ajax-me').html($(this).text());
			//$(this).addClass('active');
			//$(this).parent().siblings('li').find('a').removeClass('active');
			//$(this).parent().addClass('active');
			//$(this).parent().siblings('li').removeClass('active');
		//	$('.wrapper').removeClass('active relative');
			// console.log());
			//阻止默认点击事件
			if ( e && e.preventDefault ) {
				e.preventDefault(); 
				return false;
			} else{ 
				window.event.returnValue=fale;
				return false;
			}
		});
	$(document).on('click','.post-ajax-self',function(e){
		//通过ajax 回传页面,放弃了iframe用法
		var url = $(this).attr('vincent-href');
		rightAjax(url);
		//传递信息
		$('.post-ajax-me').html($(this).text());
		// console.log());
		//阻止默认点击事件
		if ( e && e.preventDefault ) {
			e.preventDefault(); 
			return false;
		} else{ 
	        window.event.returnValue=fale;
	        return false;
	    }
	});
}
rightSideLoad();

// 向右边内容页传递内容

function rightAjax(url){
//	var loading = layer.load(2, {
	//  shade: [0.3,'black'] 
	//});
	
	 if(submit_lock){
				//layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
					//	  time: 3000, //2s后自动关闭
				// });
				 $(".loadings").fadeIn();
                return;
            }
	submit_lock = true;
	$.ajax({
		url:url,
		type:'get',
		dataType:'json',
		async: true,
		//timeout:30000,
		beforeSend:function(){
					// layer.msg('<font color="white" style="font-size:12px;">数据正在处理中,请稍等</font>', {
				 //});
				  $(".loadings").fadeIn();
				},
		/*complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			  ajaxTimeOut.abort(); //取消请求
			   layer.msg('<font color="white">网络不稳定...</font>', {
				 });
			$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			}
			layer.close(loading);
        },*/
		success:function(data){
			 $(".loadings").fadeOut();
			$(".layui-layer-shade").remove();
		$(".layui-layer").remove();
			layer.close();
			submit_lock = false;
			console.log(data);
			if (data.status == 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
			}else{
				$('#right-side-content').html(data);
			}
//layer.close(loading);			
		},
		error:function(data){
			 $(".loadings").fadeOut();
			$(".layui-layer-shade").remove();
		$(".layui-layer").remove();
			layer.close();
			submit_lock = false;
			console.log(data);
			if(data.status==200){
				/*var _this = this;
                    layer.open({
                       type: 0 //Page层类型
                      ,shadeClose:true
                      ,title: '载入页面...'
                      ,shade: 0.6 //遮罩透明度
                      ,maxmin: false //允许全屏最小化
                      ,anim: 1 //0-6的动画形式，-1不开启
                      ,content: data.responseText,
                    }); */
				$('#right-side-content').html(data.responseText);
			}else{
			$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			}
			//layer.close(loading);
		}
	})
}
/*var ajaxTimeOut=$.ajax({
		url:'http://zytg.top/admin/material/informationflow.html?page=1',
		type:'get',
		dataType:'json',
		async: true,
		timeout:3000,
		beforeSend:function(){
					 layer.msg('<font color="white">努力加载中...</font>', {
				 });
				},
		complete: function (XMLHttpRequest, status) { //当请求完成时调用函数
			if (status == 'timeout') {//status == 'timeout'意为超时,status的可能取值：success,notmodified,nocontent,error,timeout,abort,parsererror 
			  ajaxTimeOut.abort(); //取消请求
			   layer.msg('<font color="white">网络不稳定...</font>', {
				 });
			$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
			}
      },
		success:function(data){
			if (data.status == 2) {
				layer.msg('<font color="white">'+data.info+'</font>', {
						  time: 3000, //2s后自动关闭
				 });
			}else{
				$('#right-side-content').html(data);
			}		
		},
		error:function(data){
			$('#right-side-content').html('<div style="text-align:center;padding:5vh;box-shadow:1px 1px 3px #999;margin-top:5vh;margin-bottom:5vh;"><font color="#4581fb">知意广告平台</font>：网络故障,请稍后重试 ~ </div>');
		}
	})
	*/

//刷新验证码 ,匿名函数

function verify(){
	$(".captcha").get(0).src="/captcha.html?"+Math.random();	
};

       

