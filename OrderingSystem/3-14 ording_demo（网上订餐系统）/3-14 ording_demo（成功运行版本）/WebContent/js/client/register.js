var win = lili.getDialog(), type = lili.comm.request("_type");//获取当前弹出窗体对象
var focusMsg = {
		username : '3-20位字符，可由中文、英文、数字及“_”、“-”组成',
		password : '6-20位字符，可由中文、英文、数字及“_”、“-”组成',
		telephone : '11位数字组成',
		email : '邮箱'
};
$(function(){
	$.validator.addMethod('liliImageConfirm',function(value){
		//return value === 'test';
		alert(value);
	},'请选择门脸图');
	// 在鼠标聚焦到输入框的时候更改样式
	$('#registerVip input').bind('focus',function(){
		var item = $(this);
		item.removeClass('highlight2').addClass('highlight1');
		var name = item.attr('name');
		item.parent().find('#' + name + '_error').attr('class','focus').html(focusMsg[name]);
	}).bind('blur',function(){
		var item = $(this);
		item.removeClass('highlight1');
		if(item.hasClass('highlight2')){
			return;
		}
		var name = item.attr('name');
		item.parent().find('#' + name + '_error').attr('class','null').html('');
	});
	var dataUrl = path + '/syscombox';
	
	$('#registerVip').validate({
		focusInvalid : false,
		onkeyup : false,
		rules : {
			username : {
				required : true,
				minlength : 3,
				maxlength : 20,
				// 服务端校验用户名是否已经存在
				//remote : '../../omRegValidateServlet'
			},
			password : {
				required : true,
				minlength : 6,
				maxlength : 20
			},
			telephone : {
				required : true,
				length : 11
			},
			email : {
				required : true
			}
		},
		password : {
			username : {
				required : '请输入密码',
				minlength : '密码长度只能在6-20位字符之间',
                maxlength : '密码长度只能在6-20位字符之间',
                remote : '此用户已经被注册'
			},
			telephone : {
				required : '你还没有输入手机号',
				length : '手机号长度 为11位数字',
			},
			email : {
				required : '你还没有填写邮箱'
			}
		},
		submitHandler : function(form){
			var url = path + '/business/openStore!openStore.action';
			lili.ajax.sys(url,$('#registerVip').serialize(),function(data){
				if(data.success == true){
					window.location.href = path + '/home.action';
				}
			});
			return false;
		},
		showErrors: function(errorMap, errorList) {
            if(errorList && errorList.length > 0){
                $.each(errorList,function(index,obj){
                	var item = $(obj.element); 
            		var name = item.attr('name');
            		// 给输入框添加出错样式
            		item.addClass('highlight2');
            	    // 填写出错信息
            		item.parent().find('#' + name + '_error').attr('class','error').html(obj.message);
            	    // 隐藏输入框成功提示
            		item.parent().find('#' + name + '_succeed').removeClass('succeed');
                });
            }else{
            	var item = $(this.currentElements);
            	var name = item.attr('name');
            	// 显示输入框成功提示
            	item.parent().find('#' + name + '_succeed').addClass('succeed');
            	// 删除出错信息
            	item.parent().find('#' + name + '_error').attr('class','null').html("");
            	// 移除出错样式
            	item.removeClass('highlight2');
            }
        }
	});
});