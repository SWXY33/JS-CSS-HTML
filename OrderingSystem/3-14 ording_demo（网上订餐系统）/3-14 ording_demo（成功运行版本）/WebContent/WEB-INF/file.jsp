<%@ page language="java" contentType="text/html; charset=utf-8"
	pageEncoding="utf-8"%>
<%String path = request.getContextPath(); %>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<style type="text/css">
body,html {
	margin: 0px;
	padding: 0px;
	font-size: 12px;
}

.g_file_oos {
	list-style-type: none;
	margin: 3px 0px 0px 4px;
	padding: 0px;
	overflow: auto;
}

.g_file_oos li {
	float: left;
	overflow: hidden;
	display: inline;
	list-style: none;
	border: solid 1px #ccc;
	padding: 5px;
	margin-right: 6px;
	position: relative;
	margin-top: 5px;
}

.g_file_oos .div {
	height: 7px;
	text-align: right;
	width: 100px;
	line-height: 1px;
}

.g_file_oos .div a {
	cursor: pointer;
}

.g_file_oos img {
	width: 100px;
	height: 85px;
}

.g_file_oos .text {
	margin-top: 5px;
	height: 15px;
	width: 98px;
	text-align: center;
	overflow: hidden;
	line-height: 17px;
}

.g_file_oos .pro {
	margin-top: 3px;
	height: 15px;
	width: 98px;
	border: 1px solid #6FA5DB;
	display: none;
}

.g_file_oos .pro_1 {
	background-color: #0094ff;
	height: 15px;
	width: 1%;
}

.g_file_oos .pro_2 {
	text-align: center;
	height: 13px;
	line-height: 13px;
	margin-top: -13px;
}

.g_file_oos .pro_3 {
	opacity: .3;
	filter: Alpha(Opacity =   30);
	background: #ffffff;
	height: 7px;
	width: 100%;
	position: absolute;
}

.g_file_oos .divzz {
	position: absolute;
	top: 13px;
	width: 100px;
	height: 87px;
	opacity: .6;
	filter: Alpha(Opacity =   60);
	background: #ffffff;
}

.g_file_oos .divzzImg {
	background: url("images/accept.png") no-repeat;
	height: 64px;
	left: 50%;
	margin-left: -30px;
	margin-top: -30px;
	position: absolute;
	top: 50%;
	width: 64px;
	display: none;
}

.g_file_oos_btn {
	background: url("images/button.png") no-repeat;
	width: 124px;
	height: 28px;
	border: 0 none;
	cursor: pointer;
	margin: 0;
	overflow: hidden;
	padding: 0;
	text-align: center;
	color: #007acc;
	margin-left: 3px;
	vertical-align: top;
	font-weight: 700;
}

.uploadify-queue {
	display: none;
}

.uploadify {
	float: left;
	width: 128px !important;
}

.uploadify-button {
	width: 124px !important;
}
</style>
<link rel="stylesheet" type="text/css" href="<%=path%>/om-ui/css/apusic/om-apusic.css"/>
<link rel="stylesheet" type="text/css" href="<%=path%>/css/common.css"/>
<link href="<%=path%>/lib/uploadify/uploadify.css" rel="stylesheet"/>
<script language="javascript" src="<%=path%>/om-ui/js/jquery.min.js"></script>
<script language="javascript" src="<%=path%>/om-ui/js/operamasks-ui.min.js"></script>
<script language="javascript" src="<%=path%>/lib/iframe.js" contextPath="<%=path%>" imgPath="${images_server}">
</script>
<script language="javascript" src="<%=path%>/lib/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript">
	var win = lili.getDialog(); //获取父页面
	var parDom = win.opener.$("#" + lili.comm.request("id")); //获取父页面file DOM
	var op = parDom.omFiles("options").swf; //获取上传文件参数
	var parLis = parDom.find("li");
	var type = [ '*.rar;*.doc;*.docx;*.xls;*.xlsx;*.txt;*.ppt;*.gif; *.jpg; *.png;*.bmp',
			'*.gif; *.jpg; *.png;*.bmp' ];
	$(function() {
		$("#upFile")
				.uploadify(
						{
							height : 28,
							width : 300,
							buttonImage : 'images/file_button.png',
							swf : 'lib/uploadify/uploadify.swf',
							auto : false,
							fileTypeDesc : op.fileTypeDesc == "img" ? "Img Files" : "All Files",
							fileTypeExts : op.fileTypeDesc == "img" ? type[1] : type[0],
							formData : op.actionData,
							uploader : op.dataSource,
							overrideEvents : [ "onSelect", "onUploadProgress",
									"onUploadSuccess", "onUploadStart",
									"onFallback" ],
							width : 120,
							onSelect : function(fileObj) {
								var li = $(
										'<li name="' + fileObj.id + '" id="' + fileObj.id + '"><div class="div"><a>x</a></div><img src="'
												+ (op.fileTypeDesc == "img" ? "images/image.png"
														: "images/archive.png")
												+ '"><div class="text">'
												+ fileObj.name
												+ '</div><div class="pro"><div class="pro_1"></div><div class="pro_2">0%</div></div><div class="divzz"></div><div class="divzzImg"></div></li>')
										.appendTo('#g_file_oos'), _divArrt = li
										.children("div:eq(0)");
								li.attr({
									type : fileObj.type,
									size : fileObj.size,
									title : fileObj.name
								});
								_divArrt.eq(0).find("a").click(
										function() {
											if (op.cancelFile) {//定义单个文件删除执行事件
												op.cancelFile(liToObj(li));
											}
											$('#upFile').uploadify('cancel',
													fileObj.id);
											li.remove();
											li = null, _divArrt = null;
										});
							},
							onUploadProgress : function(file, bytesUploaded,
									bytesTotal, totalBytesUploaded,
									totalBytesTotal) {
								var _div = $('#g_file_oos').find('#' + file.id)
										.children("div");
								_div.eq(1).hide();
								var proDiv = _div.eq(2).show().children("div");
								var percentage = Math.round(bytesUploaded
										/ bytesTotal * 100);
								if (percentage >= 100) {
									proDiv.eq(1).html("正在释放资源...");//文字层
								} else {
									proDiv.eq(1).html(percentage + "%");//文字层
								}
								proDiv.eq(0).width(percentage + "%");//进度层
								_div.eq(3).width((100 - percentage) + "%");//遮罩层
								_div = null, proDiv = null;
							},
							onUploadSuccess : function(file, data, response) {
								var li = $('#g_file_oos').find('#' + file.id);
								_div = li.children("div");
								_div.eq(2).hide();
								if (op.fileTypeDesc == "img") {
									_div.eq(4).hide();
								} else {
									_div.eq(4).show();
								}
								_div.eq(1).show();
								data = $.parseJSON(data)[0];
								if (op.fileTypeDesc == "img") {
									li.children("img:eq(0)").attr("src",
											data.realFilePath);
								}
								if (op.onUploadSuccess) {
									/** 后台返回文件虚拟路径，唯一标识 **/
									file.path = data.realFilePath;
									file.GUID = data.id;
									li.attr({
										GUID : data.id,
										path : data.realFilePath,
										title : data.filename
									});
									op.onUploadSuccess(file);
								}
								_div = null, file = null;
							},
							onFallback : function() {
								alert("检测到您的Flash版本太低");
							},
							onUploadStart : function(file) {
								var index = $('#' + file.id).index() + 1;
								if (index % 15 == 1) {
									location.hash = file.id;
								}
							}

						});
		/** 获取当前已上传的文件名称，防止重复上传 **/
		var fileDatas = $("#upFile").data("uploadify").queueData;
		fileDatas.names = [];
		parLis.each(function() {
			fileDatas.names.push($(this).attr("title"));
		});
		fileDatas = null;
		$(".g_file_oos_btn:input")
				.each(
						function(i) {
							if (i === 0) {//取消全部上传文件
								$(this).click(function() {
									var lis = $('.g_file_oos').children("li");
									if (lis.size() == 0) {
										lili.win.msg("没有任何列队文件", "alert", 3000);
										return;
									}
									$('#upFile').uploadify('cancel', '*');
									var files = [];//返回所有上传文件集合
									lis.each(function() {
										files.push(liToObj($(this)));
									});
									if (op.cancelFiles) {
										op.cancelFiles(files);//用户事件
									}
									files = null, lis = null;
									$('#g_file_oos').empty();
								});
							} else if (i === 1) {//上传所有文件
								$(this).click(
										function() {
											var lis = $('.g_file_oos')
													.children("li").not(
															"[path]");
											if (lis.size() == 0) {
												lili.win.msg("没有任何列队文件", "alert",
														3000);
												return;
											}
											$("#upFile").uploadify("upload",
													"*");
										});
							} else {
								$(this)
										.click(
												function() {
													var lis = $('#g_file_oos li[path]'), vals = '';
													if (lis.size() === 0) {
														lili.win.msg("没有上传任何文件",
																"alert", 3000);
														ul = null;
														return;
													}
													/** 拼接JSON对象，提供给后台使用 **/
													var obj = null;
													lis.each(function() {
														obj = liToObj($(this));
														parDom.omFiles("addLi",
																obj);//填入omFiles控件
														vals += obj.id + ",";
													});
													parLis.each(function() {
														vals += $(this).attr(
																"GUID")
																+ ",";
													});
													parDom
															.find("input:eq(0)")
															.val(
																	vals
																			.substring(
																					0,
																					vals.length - 1));
													win.get.omDialog("close");
												});
							}
						});
		$('#g_file_oos').height(
				$('body').height() - $('#divFile').height()
						- $('#view-tip').height() - 16);
	});
	function liToObj($li) {
		return {
			filename : $li.attr("title"),
			id : $li.attr("GUID"),
			realFilePath : $li.attr("path")
		};
	}
</script>

</head>
<body>
	<div id="divFile">
		<input type="file" name="upFile" id="upFile" /> <input type="button"
			class="g_file_oos_btn" value="取消全部" /> <input type="button"
			class="g_file_oos_btn" value="开始上传" /> <input type="button"
			class="g_file_oos_btn" value="确认选择" />
	</div>
	<ul id="g_file_oos" class="g_file_oos"></ul>
	<div id="view-tip" class="view-tip">请选择文件后点击开始上传</div>
</body>
</html>