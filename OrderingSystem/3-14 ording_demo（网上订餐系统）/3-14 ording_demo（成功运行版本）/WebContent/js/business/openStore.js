var win = lili.getDialog(), type = lili.comm.request("_type");//获取当前弹出窗体对象
var focusMsg = {
		storename : '3-20位字符，可由中文、英文、数字及“_”、“-”组成',
		storeDescribe : '用简单的几句话介绍下您的店铺吧',
		address : '请输入详细地址',
		storeImgName : '请上传门店logo'
};
$(function(){
	$.validator.addMethod('liliImageConfirm',function(value){
		//return value === 'test';
		alert(value);
	},'请选择门脸图');
	// 在鼠标聚焦到输入框的时候更改样式
	$('#formOpenStore input,textarea').bind('focus',function(){
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
	$('#province').omCombo({
		dataSource : dataUrl + '!provinceCombox.action',
		valueField :'id',
        optionField :'text',
        emptyText : '请选择省份',
        lazyLoad : true,
        width : '120px',
        onValueChange : function(target, newValue, oldValue) {
           $('#city').val('').omCombo('setData', dataUrl+'!cityCombox.action?provinceId='+newValue);
           $('#county').val('').omCombo( 'setData', []);
        }
	});
	$('#city').omCombo({
		editable : false,
		dataSource : [],
		valueField :'id',
        optionField :'text',
        emptyText : '请选择城市',
        lazyLoad : true,
        width : '120px',
        onValueChange : function(target, newValue, oldValue) {
        	$('#county').val('').omCombo( 'setData', dataUrl+'!countyCombox.action?cityId='+newValue);
        }
	});
	$('#county').omCombo({
		editable : false,
		dataSource : [],
		valueField :'id',
        optionField :'text',
        emptyText : '请选择县/区',
        lazyLoad : true,
        width : '120px',
        textField : 'username'
	});
	/*$('#refreshCombox').omButton({
		icons : {
			left : path + '/icon/edit.png'
		},
		onClick : function(){
			$('#province').val('').omCombo('setData', path + '/syscombox!provinceCombox.action');
			$('#city').val('').omCombo('setData', []);
			$('#county').val('').omCombo( 'setData', []);
		}
	});*/
	$('#openStore_upload_button').uploadify({
		//指定swf文件
		'swf' : path + '/lib/uploadify/uploadify.swf',
		//后台处理的页面
		'uploader' : path + '/jqueryUploadify.do',
		//按钮显示的文字
		'buttonText' : '上传照片',
		//显示的高度和宽度，默认 height 30；width 120
		'height' : 15,
		'width' : 80,
		//在浏览窗口底部的文件类型下拉菜单中显示的文本
		'fileTypeDesc' : 'Image Files',
		//允许上传的文件后缀
		'fileTypeExts' : '*.gif; *.jpg; *.png; *.jpeg',
		//上传文件的大小限制
		'fileSizeLimit' : '10MB',
		//上传数量
		'queueSizeLimit' : 1,
		//发送给后台的其他参数通过formData指定
		//'formData': { 'someKey': 'someValue', 'someOtherKey': 1 },
		//上传文件页面中，你想要用来作为文件队列的元素的id, 默认为false  自动生成,  不带#
		'queueID' : 'fileQueue',
		//选择文件后自动上传
		'auto' : true,
		//设置为true将允许多文件上传
		'multi' : false,
		//每次更新上载的文件的进展
		'onUploadProgress' : function(file, bytesUploaded, bytesTotal,
				totalBytesUploaded, totalBytesTotal) {
			//有时候上传进度什么想自己个性化控制，可以利用这个方法
			//使用方法见官方说明
		},
		//选择上传文件后调用
		'onSelect' : function(file) {

			/* alert( 'id: ' + file.id 
				+ ' - 索引: ' + file.index
				+ ' - 文件名: ' + file.name
				+ ' - 文件大小: ' + file.size
				+ ' - 类型: ' + file.type
				+ ' - 创建日期: ' + file.creationdate
				+ ' - 修改日期: ' + file.modificationdate
				+ ' - 文件状态: ' + file.filestatus); */

		},
		//上传成功后执行，服务器返回相应信息到data里
		'onUploadSuccess' : function(file, data, response) {
			$.omMessageBox.waiting('close');
			data = eval("(" + data + ")");
			if(data.length == 0)return;
			var imgpath = data[0].relativePath;
			$("#storeImg").attr("src", images_server + imgpath);
			$("#store_photo_id").val(data[0].id);
			$('#storeImgName_error').attr('class','null').html("");
		},
		'onComplete' : function(file, data, response) {
		},
		//当队列中的所有文件全部完成上传时触发
		'onQueueComplete' : function(stats) {
		},
		'onUploadStart' : function(file) {
			$.omMessageBox.waiting({
				title:'请稍候',
				content:'正在上传头像，请稍候...'
			});
		},
		//返回一个错误，选择文件的时候触发
		'onSelectError' : function(file, errorCode, errorMsg) {
			switch (errorCode) {
			case -100:
				alert("上传的文件数量已经超出系统限制的"
						+ $('#openStore_upload_button').uploadify('settings',
								'queueSizeLimit') + "个文件！");
				break;
			case -110:
				alert("文件 ["
						+ file.name
						+ "] 大小超出系统限制的"
						+ $('#openStore_upload_button').uploadify('settings',
								'fileSizeLimit') + "大小！");
				break;
			case -120:
				alert("文件 [" + file.name + "] 大小异常！");
				break;
			case -130:
				alert("文件 [" + file.name + "] 类型不正确！");
				break;
			}
		},
		//检测FLASH失败调用
		'onFallback' : function() {
			alert("您未安装FLASH控件，无法上传图片！请安装FLASH控件后再试。");
		},
		//上传失败
		'onError' : function(event, queueID, fileObj) {
			$.omMessageBox.waiting('close');
			alert("文件：" + fileObj.name + "上传失败！");
		}
	});
	$('#formOpenStore').validate({
		focusInvalid : false,
		onkeyup : false,
		rules : {
			storename : {
				required : true,
				minlength : 3,
				maxlength : 20,
				// 服务端校验用户名是否已经存在
				//remote : '../../omRegValidateServlet'
			},
			storeDescribe : {
				required : true,
				minlength : 4,
				maxlength : 20
			},
			address : {
				required : true
			},
			storeImgName : {
				required : true
			}
		},
		messages : {
			storename : {
				required : '请输入店铺名称',
				minlength : '店铺名长度只能在3-20位字符之间',
                maxlength : '店铺名长度只能在3-20位字符之间',
                remote : '此用户已经被注册'
			},
			storeDescribe : {
				required : '你还没有输入店铺介绍',
				minlength : '用户名长度只能在4-20位字符之间',
                maxlength : '用户名长度只能在4-20位字符之间'
			},
			address : {
				required : '你还没有输入详细地址'
			},
			storeImgName : {
				required : '你还没有上传门店logo'
			}
		},
		submitHandler : function(form){
			var url = path + '/business/openStore!openStore.action';
			lili.ajax.sys(url,$('#formOpenStore').serialize(),function(data){
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