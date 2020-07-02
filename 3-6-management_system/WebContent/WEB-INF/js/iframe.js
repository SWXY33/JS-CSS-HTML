var path = $("script:last").attr("contextPath");
var images_server = $("script:last").attr("imgPath");
var lili = {};

//扩展JQ
$.fn.extend({
	liliFile: function (params) {//封装文件上传
        //if (!params || !params.valueField || !params.path) { this.html("定义上传控件参数出错.");return; }
        this.omFiles({
            width: params.width||'auto',
            height: params.height||170,
            label: params.label||'上传',
            title: params.title||"上传附件",
            loadType: params.loadType || "edit",//填充类型,des,edit，des为浏览，不显示上传按钮
            showPic: params.showPic,//对于loadType是des时，是否定义图片浏览，默认为点击下载
            emptyText: '<img style="margin-right:5px;" src="'+path+'/images/winrar_x.png" />'+(params.emptyText||"请上传附件"),//无附件时提示
            filePath: 'toUpload.action',//上传界面URL
            valueField: params.valueField,//表单提交到后台的字段名
            maxString: params.maxString,//每条记录显示字数
            formatHTML: params.formatHTML,//自定义展示文件，实现规则，li为单位，里面第一个span为删除按钮，其它自定义
            /**
             * 示例
             * formatHTML：function(obj){
             * 	 return "<li><a href='"+obj.fileUrl+"' fileID='"+obj.id+"'></a></li>";
             * }
             */
            loadData: params.loadData,//填充的JSON或URL
            downloadUrl:"http://baidu.com/",//定义后台下载URL
            clickLiEdit: params.clickLiEdit,//编辑时点击的方法
            swf: {
                actionData: params.actionData,//上传时附带参数，格式为{xx:'xx',cc:'xx'}不支持多层嵌套
                dataSource: 'jqueryUploadify.do',
                fileTypeDesc: params.fileTypeDesc||'All Files',
                onUploadSuccess: function () { },//单个文件上传成功后执行的方法
                cancelFile: function (obj) {
                    //和后台结合，删除文件
                },//单个文件删除后执行的方法
                cancelFiles: function (obj) {
                    //和后台结合，删除文件
                }//清空文件后执行的方法
            }
        });
    },
    liliPhoto : function (obj) {
        //图片浏览功能
        this.children("li").click(function () {
        	if(!obj){obj={path:''};}
            obj.self = $(this);
            top.lili.liliImg.fill(obj);
        });
    },
    liliCombo : function (params) {
        //封装omCombo
        this.omCombo({
            dataSource: params.data,
            forceSelection: true,
            valueField: params.valueField || 'value',
            inputField:params.inputField || 'text',
            optionField:params.optionField || 'text',
            width: params.width || "96%",
            editable: false,
            multi: params.multi || false,
            listMaxHeight: params.listMaxHeight || 260,
            onValueChange:function(target,newValue,oldValue,event){ 
                if(params.change){
                	params.change(target,newValue,oldValue,event);
                }
            },
            forceSelection:false,
            value: params.value || null,
            onSuccess:function(data, textStatus, event){
                if(params.ajaxOK){
                	params.ajaxOK(data, textStatus, event);
                }
            }
        });
    },
    liliRadio: function (clickFun) {
        //美化RADIO
    	var self=this;
        return $(':radio+label', self).each(function () {
            $(this).addClass('hRadio');
            if ($(this).prev().is(':checked'))
                $(this).addClass('hRadio_Checked');
        }).click(function (event) {
            if (!$(this).prev().is(':checked')) {
            	$(':radio+label', self).removeClass("hRadio_Checked");
                $(this).prev()[0].click();
                $(this).addClass("hRadio_Checked");
                $(this).prev()[0].checked = true;
                if(clickFun){
                	clickFun($(this).prev());
                }
            }
            event.stopPropagation();
        })
        .prev().hide();
    }
});

lili.win = {
	msgjson : function(params) {
		top.lili.dialog.msg(params);
	},
	msg: function (msg, info, time) {
        this.msgjson({ msg: msg, info: info, time: time });
    },
	alert : function(msg, info, title, fun) {
		lili.$.omMessageBox.alert({
			title : title ? title : '操作提示',
			type : info ? info : "alert",
			content : msg,
			onClose : function(v) {
				if (fun) {
					fun();
				}
			}
		});
	},
	dialog: function (params) {
        //弹窗
        if (params.html && params.isID !== false) {
            params.html = $(params.html).html();
        }
        params.self = self;
        return top.lili.dialog.load(params);
    }
};
lili.dialog = {
	load : function(params) {
		// 开启等待窗口
		this.msg({
			msg : "正在加载中...",
			info : "ing"
		}, null);
		// 封装弹窗
		var $$ = null, k = 0;
		while (true) {
			if (!document.getElementById("dialog" + k)) {
				// 不存在则创建层并加载
				$('body').append('<div index="' + k + '" id="dialog' + k + '"></div>');

				$('#dialog' + k).omDialog({
					autoOpen : false,
					modal : true,
					resizable : false,
					draggable : true,
					onBeforeClose : function(event) {
						var self = $(this), stopFun = self.data("self")[1];
						var func = function() {
							// 弹出层中有框架则先销毁资源
							var frames = self.find("iframe");
							if (frames.length > 0) {
								for ( var i = 0; i < frames.length; i++) {
									frames[i].contentWindow.document.write('');
									frames[i].contentWindow.close();
								}
								frames.attr("src", 'about:blank');
								frames.remove();
								if ($.browser.msie) {
									CollectGarbage();
								}
							}
							self.empty();
							lili.dialog._list.pop();
						};
						if (stopFun != undefined && stopFun() === false) {
							return false;
						}
						func();
						func = null, self = null, stopFun = null;
						return true;
					},
					onOpen : function() {
						lili.dialog._list.push($(this));
					}
				});
				break;
			} else if (!$('#dialog' + k).omDialog("isOpen")) {
				break;
			}
			k++;
		}
		$$ = $('#dialog' + k), k = null;// 读取弹出框
		setTimeout(function() {
					// 初始化
					$$.css("padding", "3px").data("self",
							[ params.self, params.stopFun,params.resultTop ? true : false ])
							.omDialog('options').height = "auto";
					lili.dialog.open(params, $$);
					// 是否自动创建表单
					if (params.form) {
						var formCount = $("body").find("form").size() == 0 ? 0
								: $("body").find("form").size() + 1;
						params.form = $(
								'<form id="form' + formCount + '"></form>')
								.appendTo($$);
						formCount = null;
					}
					if (params.bFun) {// 赋值前
						params.bFun($$);
					}
					// 加载内容
					if (params.url) {// 是框架则先创建框架
						var iframe = $(
								'<iframe id="'
										+ $$.attr("id")
										+ 'Iframe" name="'
										+ $$.attr("id")
										+ 'Iframe" frameborder="0" style="width:100%;height:100%;" src="about:blank"></iframe>')
								.appendTo($$);
						iframe.attr('src', params.url).load(function() {
							if (iframe != null) {
								$("#loading-msg").hide().prev().hide();
								if (params.fun) {
									params.fun(iframe);
								}
								iframe = null;
							}
						});
					} else {
						// 普通HTML
						params.form.html(params.html);
						if (params.fun) {
							params.fun(params.form);
						}
						$("#loading-msg").hide().prev().hide();
					}
					if (params.aFun) {
						params.aFun($$);
					}
				}, 1);
		return $$;
	},
	_list : [],// 弹出窗所有对象
	fit : function(height) {
		return lili.home.skin === "apusic" ? 85 : 75;
	},
	open : function(params, $$) {
		params.height += this.fit();
		if ($$.parent().width() > $(window).width()
				|| params.width > $(window).width()) {
			$$.omDialog("option", "width", $(window).width() - 10);
		} else {
			$$.omDialog("option", "width", params.width);
		}
		if ($$.parent().height() > $(window).height()
				|| params.height > $(window).height()) {
			$$.omDialog("option", "height", $(window).height() - 10);
		} else {
			$$.omDialog("option", "height", params.height);
		}
		// 是否模态窗口
		if (typeof params.modal != 'undefined') {
			$$.omDialog("option", "modal", params.modal);
		} else {
			$$.omDialog("option", "modal", true);
		}
		if (params.resizable) {
			$$.omDialog("option", "resizable", params.resizable);
		}
		if (params.draggable) {
			$$.omDialog("option", "draggable", params.draggable);
		}

		// 有按钮
		if (params.btn) {
			params.btn.unshift({
				text : "关闭",
				icon : path + '/icon/cancel.png',
				click : function() {
					$(this).omDialog("close");
				}
			});
			$$.omDialog("option", 'buttons', params.btn);
		} else {
			$$.omDialog("option", 'buttons', []);
		}
		// 改变标题
		$$.prev().children('span[class="om-dialog-title"]').html(
				params.title || "弹窗提示");
		$$.omDialog("option", 'position', []);
		$$.omDialog("open");
	},
	clearmsg : null,
	msg : function(params, dom) {
		/**
		 * 简单提示层，自动隐藏 params
		 * 参数列表：{msg:'操作成功',info:'ok',time:3,layer:true,fun:function(){alert(1)}}
		 * dom 指定弹出层父区域
		 */
		if (this.clearmsg) {
			return;// 当前提示框未关闭，则返回
		}
		var $$ = $("#loading-msg");
		$$.attr("style", "");
		if (params) {
			params.time = params.info == "error" ? 3000 : (params.time || 1500);
			$$.children("div").removeClass().addClass(
					"loading_" + (params.info || "alert")).html(params.msg);
			// 关闭效果
			this.clearmsg = setTimeout(function() {
				if (params.layer) {// 启用遮罩层则关闭
					$$.prev().hide();
				}
				if (params.info != "ing") {// 不为加载层时则开启动态效果
					$$.animate({
						top : "10px",
						opacity : .3
					}, null, null, function() {
						$$.hide(), $$ = null;
					});
				} else {
					$$.hide(), $$ = null;
				}
				if (params.fun) {
					params.fun();
				}
				lili.dialog.clearmsg = null, params = null;
			}, params.time);
			if (params.layer) {
				$$.prev().show();
			} else {
				$$.prev().hide();
			}
			$$.show();
		} else {
			$$.show().children("div").removeClass().addClass("loading_ing")
					.html("正在加载中，请稍后..."), $$.prev().show();
		}
		if (dom) {
			var offset = dom.offset();
			$$.css({
				top : offset.top + (dom.height() / 2 - $$.height() / 2),
				left : offset.left + (dom.width() / 2 - $$.width() / 2)
			}).prev().css({
				left : offset.left,
				top : offset.top,
				height : dom.height(),
				width : dom.width()
			});
			;
		} else {
			$$.css({
				top : $(window).height() / 2 - $$.height(),
				left : $(window).width() / 2 - $$.width() / 2 - 30
			}).prev().css({
				left : 0,
				top : 0,
				height : '100%',
				width : '100%'
			});
		}
		dom = null;
	}
};
lili.liliImg = {
	// 加载仿QQ空间相册功能
	fill : function(params) {
		if (!top.document.getElementById('zoom_list')) {
			top.$('body').append('<div id="zoom_list" class="photo_list">'
					+'<a class="close"></a><a class="previous"></a>'
					+'<a class="next"></a><div class="content" '
					+'style="width: 32px; height: 32px; margin-top: -16px;'
					+' margin-left: -16px;"><img id="photo_list_c_img" '
					+'style="display: none;"></div>'
					+'<img src="/img/loading.gif" class="photo_list_loading" />'
					+'<div class="bottom"></div><a class="revolve p1"></a>'
					+'<a class="revolve p2"></a><a class="revolve p3"></a></div>');
		}
		// IE9以下判断图片对象是否存在
		var isExist = function() {
			var content = $$.children(".content");
			if (content.children("img").size() == 0) {
				content.empty();
				$('<img id="photo_list_c_img" style="display: none;">').load(
					function() {
						lili.img._load.apply(this, [ params ]);
					}).appendTo(content);
			}
			return content.children("#photo_list_c_img");
		};
		var $$ = top.$("#zoom_list").show();
		// 图片加载
		$$.children(".content").children("#photo_list_c_img").attr("src",
				params.path + params.self.attr("path")).hide().load(function() {
			lili.img._load.apply(this, [ params ]);
		}).parent().attr("index", params.self.index());
		// 关闭
		$$.children(".close").click(function() {
			$(this).parent().remove();
		});
		// 左右按钮
		$$.children(".previous").click(
			function() {
				// 左
				var img = isExist(), index = Number(img.parent().attr(
						"index"));
				if (index == 0) {
					lili.dialog.msg({
						msg : "前面已经没有了",
						info : "alert"
					});
				} else {
					index--;
					img.removeAttr("style").attr("src",params.path
						+ params.self.parent().children("li:eq(" + index + ")").attr("path"))
					.hide().parent().attr({
						angle : 0,
						index : index
					}).next().show();
				}
				img = null, index = null;
			}).next().click(
				function() {
					// 右
					var img = isExist(), index = Number(img.parent().attr("index"));
					var list = params.self.parent().children("li");
					if (index == list.size() - 1) {
						lili.dialog.msg({
							msg : "后面已经没有了",
							info : "alert"
						});
					} else {
						index++;
						img.removeAttr("style").attr("src",params.path
								+ list.eq(index).attr("path"))
						.hide().parent().attr({
							angle : 0,
							index : index
						}).next().show();
					}
					img = null, index = null, list = null;
				}
		);
		// 旋转，IE9以下使用vml，CSS3浏览器使用transform
		$$.children(".revolve").click(
				function() {
					var img = $$.find("#photo_list_c_img");
					if ($(this).index() == 6) {
						index = Number(img.parent().attr("angle")) || 0;
						if (index == -270) {
							index = 0;
						} else {
							index -= 90;
						}
						img.rotate(index);
						img.parent().attr("angle", index);
					} else if ($(this).index() == 7) {
						index = Number(img.parent().attr("angle")) || 0;
						if (index == 270) {
							index = 0;
						} else {
							index += 90;
						}
						img.rotate(index);
						img.parent().attr("angle", index);
					} else {
						window.open(params.path
								+ params.self.parent().children("li").eq(
										img.parent().attr("index"))
										.attr("path"));
					}
				});
	},
	_load : function(params) {
		// 图片加载成功后处理方法
		var height = $(this).height();
		if (height > $("body").height()) {
			height = $("body").height() - 100;
		}
		var width = $(this).width();
		if (width > $(document).width()) {
			width = $("body").width() - 100;
		}

		$(this).height(height).width(width).show().parent().css({
			width : width,
			height : height,
			"margin-top" : -(height / 2) - 30,
			"margin-left" : -(width / 2)
		}).next().hide();
		if (!$(this).parent().attr("index")) {
			$(this).parent().attr("index", 0);
		}
		var li = params.self.parent().children(
				"li:eq(" + $(this).parent().attr("index") + ")");
		if (li.attr("title")) {
			$(this).parent().parent().children(".bottom")
					.html(li.attr("title")).show();
		} else {
			$(this).parent().parent().children(".bottom").hide();
		}
		width = null, height = null, li = null;
	}
};
lili.home = {
	menuList : null,
	tabObj : null,
	ifh : null,
	createMenu : function(index) {
		var menu_div = $('#menutab').children('div');
		menu_div.removeClass('nav_icon_h_item_hover');
		menu_div.eq(index).addClass("nav_icon_h_item_hover");
		// 初始化左则菜单
		$('#west-panel').empty();
		$('#west-panel').html('<div id="accordionId"></div>');
		// 拼接HTML
		var menu = this.menuList[index].childs;// 根据索引取出二三级菜单
		var html = '', title = '<ul>';
		$.each(menu,function(i, n) {
			title += '<li><a href="#accordion-' + i + '" iconCls="' + (path + n.icon) + '">' + n.name;
			html += '<div id="accordion-'+ i + '" style="padding:2px;"><ul class="navlist">';
			if (n.childs) {
				$.each(n.childs,function(k, o) {
					html += "<li><div childs='" + ((o.childs && o.childs.length > 0) ? "true" : "false")
						+ "' url='" + o.url + "' icon='" + o.icon + "' title='" + o.name
						+ "' oid='" + o.id + "'><img src='" + (path + o.icon)
						+ "' style='width:16px;height:16px;'/>&nbsp;<span>"+ o.name+ "</span></div>";
					if (n.childs) {
						html += '<ul class="navlist third_ul" style="padding-left: 20px;">';
						$.each(o.childs,function(q,w) {
							html += "<li><div url='" + w.url + "' icon='" + w.icon + "' title='"
								+ w.name + "' oid='" + w.id + "'><img src='" + (path + w.icon)
								+ "' style='width:16px;height:16px;'/>&nbsp;<span>" + w.name + "</span></div></li>";
						});
						html += '</ul>';
					}
					html += "</li>";
				});
			}
			title += '</a></li>';
			html += '</ul></div>';
		});
		title += '</ul>';
		// 展示omAccordion
		$('#accordionId').html(title + html).find(".navlist li div").click(
				function() {
					if ($(this).attr("childs") === "true") {
						$('.third_ul').slideUp();
						var ul = $(this).next();
						if (ul.is(":hidden"))
							ul.slideDown();
						else
							ul.slideUp();
					} else {
						$('.navlist li div').removeClass("selected");
						$(this).addClass("selected");
						lili.home.addTab({
							id : $(this).attr("oid"),
							title : $(this).attr("title"),
							url : $(this).attr("url"),
							icon : $(this).attr("icon"),
							isClose : true
						});
					}
				});
		$("#accordionId").omAccordion({
			height : 'fit'
		});
		screen(this.menuList[index].doubleScreen);
	},
	addTab : function(parans) {
		var tabId = lili.home.tabObj.omTabs('getAlter', 'tab_' + parans.id);
		if (tabId) {
			lili.home.tabObj.omTabs('activate', tabId);
			// 如果请求页面和原始页不同，则刷新（tab内部跳转的情况）
			if (window.frames["t" + parans.id].location.href.indexOf(parans.url
					.replace("../", "")) == -1) {
				$('#t' + parans.id).attr('src', parans.url);
			}
		} else {
			lili.home.tabObj.omTabs('add',{
				title : parans.title,
				tabId : 'tab_' + parans.id,
				content : "<iframe name='t" + parans.id + "' id='t" + parans.id
					+ "' src='" + parans.url
					+ "' onload='$(\"#loading-msg\").fadeOut().prev().fadeOut();' border=0 frameBorder='no' style='width:100%;height:"
					+ (lili.home.ifh) + "px;'></iframe>",
				closable : parans.isClose,
				iconCls : path + parans.icon
			});
			if (parans.isClose) {
				$('#tab_' + parans.id + '_id').dblclick(function() {
					var subtitle = $(this).children('a').attr('tabid');
					lili.home.tabObj.omTabs('close', subtitle);
				}).bind('contextmenu', function(e) {
					var subtitle = $(this).children('a').attr('tabid');
					lili.home.tabObj.omTabs('activate', subtitle);
					$('#menu').omMenu('show', e);
				});
			}
			if (lili.home.tabObj.omTabs('getLength') > 8) {
				lili.home.tabObj.omTabs('close', 1);
			}
		}
	},
	resize : function() {
		$('#left').omBorderLayout("resize");
		// 改变大小
		lili.home.tabObj.height($('#center-panel').height())
			.find(".om-tabs-panels")
			.height(lili.home.tabObj.height() - (lili.home.tabObj.find(".om-tabs-headers")
				.height() + ($.browser.msie&& ($.browser.version == "6.0" || $.browser.version == "7.0") ? 6: 4)));
		lili.home.ifh = lili.home.tabObj.height()
			- lili.home.tabObj.find(".om-tabs-headers").outerHeight() - _fit;
		lili.home.tabObj.find(".om-tabs-panels iframe").height(lili.home.ifh);
		$('#accordionId').omAccordion('resize');
	}
};
lili.ajax = {
	sys : function(url, data, func, errorFun, dataType, type, async) {
		//url:处理URL,data:参数对象,func:处理成功后返回方法,errorFun:处理失败后返回方法,dataType:后台返回结果类型,type:处理类型(get,post)
		top.$("#sys_ajax_text").show().prev().show();
		var time = setTimeout(
				"top.$('#sys_ajax_text').hide().prev().hide();lili.win.alert('对不起,连接超时,请重试!');",
				3000 * 60);
		$.ajax({
			type : type || "post",
			url : url,
			data : data,
			async : async || true,
			dataType : dataType || 'json',
			success : function(d) {
				top.$("#sys_ajax_text").fadeOut().prev().fadeOut();
				clearTimeout(time);
				if (d.errorUrl != undefined) {
					alert("error");
					//建议统一处理AJAX登陆超时问题
				} else {
					func(d);
				}
			},
			error : function(a, b, c) {
				top.$("#sys_ajax_text").fadeOut().prev().fadeOut();
				clearTimeout(time);
				if (errorFun) {
					errorFun();
				} else {
					top.$.omMessageBox.alert({
						title : '操作提示',
						type : "error",
						content : "系统发生了一个错误，操作无法继续"
					});
				}
			}
		});
	}
};
lili.ui = {
	validate : function(rules, messages, submitHandler, form) {
		form = lili.me.$(form || "#form0");
		form.validate({
			rules : rules,
			messages : messages,
			submitHandler : function() {
				submitHandler($(this));
				return false;
			},
			errorPlacement : function(error, element) {
				var attentionElement = $(element).parents("td").children().eq(1);
				if (error.html()) {
					attentionElement.html(error.html());
					attentionElement.prev().addClass("error-border");
				}
			},
			showErrors : function(errorMap, errorList) {
				if (errorList && errorList.length > 0) {
					$.each(errorList, function(index, obj) {
						var attentionElement = $(obj.element).parents("td").children().eq(1);
						attentionElement.html(this.message);
						attentionElement.prev().addClass("error-border");
					});
				} else {
					var attentionElement = $(this.currentElements).parents("td").children().eq(1);
					if (attentionElement.is(".errorMsg")) {
						attentionElement.html("");
						attentionElement.prev().removeClass("error-border");
						lili.me.$("#formtip").css('display', 'none');//弹出tip要关闭
					}
				}
			}
		});
		lili.me.$('.errorMsg', form).prev().bind('mouseover', function(e) {
			//有错误才显示
			if ($(this).next().html().length > 0) {
				var position = $(this).position();
				position.text = $(this).next().html();
				position.top = position.top + $(this).height() + 3;
				position.left = position.left - 2;
				lili.ui.formtip(position, form);
			}
		}).bind('mouseout', function() {
			lili.me.$("#formtip").hide();
		});
	},
	formtip: function (position, appObj) {//生成一个在元素下方的提示框
        if (!lili.me.document.getElementById("formtip")) {//保证弹出tip只生成一次
            appObj = lili.me.$(appObj || "#body");
            appObj.append('<table id="formtip" class="tableTip" style="">' +
            '<tr>' +
            '<td class="leftImage"></td>' +
            '<td class="contenImage" align="left"></td>' +
            '<td class="rightImage"></td>' +
            '</tr>' +
            '</table>');
        }
        lili.me.$("#formtip").css({ 'top': position.top, 'left': position.left }).show().find('td:eq(1)').html(position.text);
    },
    formClear: function (obj) {
    	//清除表单值
        obj.find('input,select,textarea').each(function (a, b) {
        	if($(this).attr('type')!="button")
            if (b.value)
                if (b.getAttribute("type") == "checkbox" || b.getAttribute("type") == "radio") {
                    $(b).attr("checked", false);
                } else {
                    b.value = "";
                    if ($('[id="' + b.id + '"]:data(omComboTree)').size() > 0){
                        $(this).omComboTree('setEmptyText');
                    }else if($('[id="' + b.id + '"]:data(omCombo)').size() > 0) {
                        $(this).omCombo('setEmptyText');
                    }
                }
        });
    }
};
lili.comm = {
	request : function(sProp) {
		// 获取URL？问后以&分隔的参数
		var re = new RegExp(sProp + "=([^\&]*)", "i");
		var a = re.exec(document.location.search);
		if (a == null)
			return null;
		return a[1];
	},
	_eval : function(val, name, form) {
		// 解决空值TD高度问题
		lili.me.$(name, lili.me.$(form || "#form0")).html(val || "&nbsp;");
	}
};
/** 跨iframe操作 * */
lili.$ = top.$;
lili.me = self;
// 弹出层操作
lili.getDialog = function () {
    //方法返回get，opener两个属性，分别为弹出层dom，父页面self，stopFun为弹出层阻止方法，为false阻止关闭
    var list = top.lili.dialog._list;
    if (list === null || list.length == 0) {
        return { get: null, opener: null };
    }
    var win = list[list.length - 1],data=win.data("self");
    return {
        get: win,
        $jq: !data[2]?data[0].$ : top.$,
        opener: data[0] || self.window,
        stopFun: function (fun) {
            if (fun) {
            	data[1]=fun;
            }
        }
    };
};

//--------------------------------------------------- 
//日期格式化 
//格式 YYYY/yyyy/YY/yy 表示年份 
//MM/M 月份 
//W/w 星期 
//dd/DD/d/D 日期 
//hh/HH/h/H 时间 
//mm/m 分钟 
//ss/SS/s/S 秒 
//--------------------------------------------------- 
Date.prototype.Format = function(formatStr){
	var str = formatStr;
	var Week = ['日','一','二','三','四','五','六'];
	str = str.replace(/yyyy|YYYY/,this.getFullYear());
	str = str.replace(/yy|YY/,(this.getYear() % 100)>9?(this.getYear() % 100).toString():'0' + (this.getYear() % 100));
	str=str.replace(/MM/,this.getMonth()>9?this.getMonth().toString():'0' + this.getMonth());
	str=str.replace(/M/g,this.getMonth());
	str=str.replace(/w|W/g,Week[this.getDay()]);
	str=str.replace(/dd|DD/,this.getDate()>9?this.getDate().toString():'0' + this.getDate());
	str=str.replace(/d|D/g,this.getDate());
	str=str.replace(/hh|HH/,this.getHours()>9?this.getHours().toString():'0' + this.getHours());
	str=str.replace(/h|H/g,this.getHours());
	str=str.replace(/mm/,this.getMinutes()>9?this.getMinutes().toString():'0' + this.getMinutes());
	str=str.replace(/m/g,this.getMinutes());
	str=str.replace(/ss|SS/,this.getSeconds()>9?this.getSeconds().toString():'0' + this.getSeconds());
	str=str.replace(/s|S/g,this.getSeconds());
	return str;
};
function liliDateFormat(date){
	if(date.time){
		var JsonDateValue = new Date(date.time);
		var text = JsonDateValue.getYear() + "-" + JsonDateValue.getMonth()
			+ "-" + JsonDateValue.getDay() + " " + JsonDateValue.getHours()
			+ ":" + JsonDateValue.getMinutes() + ":" + JsonDateValue.getSeconds();
		return text;
	}
	return '';
}