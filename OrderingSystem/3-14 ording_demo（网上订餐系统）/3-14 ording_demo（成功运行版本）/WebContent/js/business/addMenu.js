$(function() {
	$('#menuType').omCombo({
		editable : false,
		dataSource : [{
			'id' : '快餐',
			'text' : '快餐'
		},{
			'id' : '宵夜',
			'text' : '宵夜'
		},{
			'id' : '饮料',
			'text' : '饮料'
		}],
		valueField :'id',
        optionField :'text',
        emptyText : '请选择类型',
        lazyLoad : true,
        width : '120px',
        onValueChange : function(target, newValue, oldValue) {
        }
	});
	$('#storeMenu_upload_button').uploadify({
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
			data = eval("(" + data + ")");
			if(data.length == 0)return;
			var imgpath = data[0].relativePath;
			$("#menuImg").attr("src", images_server + imgpath);
			$("#menu_photo_id").val(data[0].id);
		},
		'onComplete' : function(file, data, response) {
		},
		//当队列中的所有文件全部完成上传时触发
		'onQueueComplete' : function(stats) {
		},
		'onUploadStart' : function(file) {
			lili.win.msgjson({
				info : 'ing',
				time : 2000
			});
			/*$.omMessageBox.waiting({
				title:'请稍候',
				content:'正在上传头像，请稍候...'
			});*/
		},
		//返回一个错误，选择文件的时候触发
		'onSelectError' : function(file, errorCode, errorMsg) {
			switch (errorCode) {
			case -100:
				alert("上传的文件数量已经超出系统限制的"
						+ $('#mystore_upload_button').uploadify('settings',
								'queueSizeLimit') + "个文件！");
				break;
			case -110:
				alert("文件 ["
						+ file.name
						+ "] 大小超出系统限制的"
						+ $('#mystore_upload_button').uploadify('settings',
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
			alert("文件：" + fileObj.name + "上传失败！");
		}
	});
});