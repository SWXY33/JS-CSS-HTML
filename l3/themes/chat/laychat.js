layui.define(['layim', 'laypage'], function(exports){
  //do something
  var $ = layui.jquery,
	layer = layui.layer,
	layim = layui.layim;
	var WEB_SOCKET_SWF_LOCATION = "/themes/websocket/WebSocketMain.swf";
	var WEB_SOCKET_DEBUG = true;
	var WEB_SOCKET_SUPPRESS_CROSS_DOMAIN_SWF_ERROR = true;
	
	
	var laychat = {
		
		
		init:function(){
			var layim = layui.layim;
			//基础配置
			layim.config({
				//获取主面板列表信息
				init: {
					url: "/index.php/chat/init" //接口地址（返回的数据格式见下文）
				}
				//获取群员接口
				,members: {
				  url: "/index.php/chat/members" //接口地址（返回的数据格式见下文）
				  ,type: 'get' //默认get，一般可不填
				  ,data: {} //额外参数
				},
				uploadFile: {
					url: "/index.php/upload/ajax_upload_chat?type=file"
				}
				,uploadImage: {
					url: "/index.php/upload/ajax_upload_chat?type=image"
				}
				,isAudio:false
				,isVideo:false
				//聊天窗口工具按钮
				/*,tool: [{
				alias: 'groupset' //工具别名
				,title: '群组' //工具名称
				,icon: '&#xe64e;' //工具图标，参考图标文档
				}]*/ 				
				,brief: false //是否简约模式（默认false，如果只用到在线客服，且不想显示主面板，可以设置 true）
				,title: 'IM即时沟通' //主面板最小化后显示的名称
				,maxLength: 3000 //最长发送的字符长度，默认3000
				,isfriend: true //是否开启好友（默认true，即开启）
				,isgroup: true //是否开启群组（默认true，即开启）
				,notice:true
				,right: '0px' //默认0px，用于设定主面板右偏移量。该参数可避免遮盖你页面右下角已经的bar。
				,chatLog: "/index.php/chat/chatlog" //聊天记录地址（如果未填则不显示）
				//,msgbox: '/index.php/chat/msgbox' //消息盒子页面地址，若不开启，剔除该项即可
				,find: "index.php/chat/grouplist" //查找好友/群的地址（如果未填则不显示）
				,copyright: true //是否授权，如果通过官网捐赠获得LayIM，此处可填true
			});
		  
			
			//layim建立就绪
			layim.on('ready', function(res){
				//建立WebSocket通讯
				var socket = new WebSocket('ws://'+document.domain+':8201');
				//连接成功时触发
				socket.onopen = function(){
					var userdata = layim.cache().mine;
					userdata['type']='init';
					//console.log(userdata);
					// 登录
					socket.send( JSON.stringify(userdata));
					//console.log( login_data );
					console.log("websocket握手成功!"); 
				};
				socket.onerror = function(err){
					console.log(err); 
				}
				//监听收到的消息
				socket.onmessage = function(res){
					//console.log(res.data);
					var data = eval("("+res.data+")");
					switch(data['message_type']){
						// 服务端ping客户端
						case 'ping':
							socket.send('{"type":"ping"}');
							break;
						// 登录 更新用户列表
						case 'init':
							//console.log(data['id']+"登录成功");
							//layim.getMessage(res.data); //res.data即你发送消息传递的数据（阅读：监听发送的消息）
							break;
						//添加 用户
						case 'addUser':
							//console.log(data.data);
							layim.addList(data.data);
							break;
						//删除 用户
						case 'delUser':
							layim.removeList({
								type: 'friend'
								,id: data.data.id //好友或者群组ID
							});
							break;
						// 添加 分组信息
						case 'addGroup':
						   // console.log(data.data);
							layim.addList(data.data);
							break;
						case 'delGroup':
							layim.removeList({
								type: 'group'
								,id: data.data.id //好友或者群组ID
							});
							break;
						// 检测聊天数据
						case 'chatMessage':
							return layim.getMessage(data.data);						
							break;
						// 离线消息推送
						case 'logMessage':
							return layim.getMessage(data.data);
							//console.log(data.data);
							//if(data.data.type === 'friend'&&data.data.system){
							//  return data.data.content=='对方下线'?layim.getMessage(data.data):'';
							//}else if(data.data.type === 'system'){
							//	layim.getMessage(data.data);
							///}else{
							//	layim.getMessage(data.data);
							//}
							break;
						// 用户退出 更新用户列表
						case 'logout':
							break;
						//聊天还有不在线
						case 'ctUserOutline':
							//console.log('11111');
							//layer.msg('好友不在线', {'time' : 1000});
							break;
						   
					}
				};
					
				layim.on('sendMessage', function(res){				
					socket.send(JSON.stringify({type: 'chatMessage' ,data: res} ));
				});
			});
			
		}
	}
	laychat.init();
	exports('laychat', {});
  /*exports('laychat', function(){
    console.log('Hello World!');
  });*/
});