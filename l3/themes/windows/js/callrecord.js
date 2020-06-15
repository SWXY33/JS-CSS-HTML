
var webSocket = new WebSocket('ws://127.0.0.1:8555/api');
var timer;
webSocket.onerror = function (event) {
    $('#device-state').text('-1');//设备状态
};
 webSocket.onclose = function (event) {
 webSocket = new WebSocket('ws://127.0.0.1:8555/api');
    clearInterval(timer);
 };
//与WebSocket建立连接
webSocket.onopen = function (event) {
    timer = setInterval(HeartBeatCheck, 10000);
    //document.getElementById('messages').innerHTML += '<br />与服务器端建立连接';
    $('#device-state').text('1');//设备状态
    webSocket.send('{"command":"GetCallState"}');//检查通话状态
	webSocket.send('{"command":"SMSEnable","arguments":{"content":"0"}}');//关闭收取短信
};
function HeartBeatCheck()
{
    webSocket.send('HeartBeatData');
}
//处理服务器返回的信息
webSocket.onmessage = function (event) {
    console.log(event.data);
    var msgJsonData = jQuery.parseJSON(event.data);
    var msg = msgJsonData.message;
    if (msgJsonData.type == "InstructionTrace") {
        document.getElementById('trace').innerHTML += '<br />' + msg;
    }
    else if (msgJsonData.type == "RealTimeState") {

        var call_state = msgJsonData.dynamicdata.realtimestate;
        
        if(msgJsonData.dynamicdata.realtimestate=='incoming'){
        var number = msgJsonData.dynamicdata.number;
        $('#call-mobile').text(number);
        
        //查询客户id
        $.ajax({
            url: "/index.php/callrecord/ajax_get_cid",
            data: {mobile:number},
            type:'post',
            dataType:'json',
            success:function(data){
                if (data.code=='100') {
                    cid = data.msg;
					$('#call-cid').text(cid);
                }else{

                }
            },
            error:function(data){
                layer.msg('失败：'+data.msg,{icon:5,time:3000});
            }
        });
        
        //弹出对应客户窗口
        /*layer.confirm('来电是否接听？', {
		  title: number,
		  offset: 'rb',
		  btn: ['接听','挂断'] //按钮
		}, function(index, layero){
		  OnAnswer();
		  layer.close(index);
		}, function(index, layero){
		  OnHungUp();
		  layer.close(index);
		});	*/
        
        
        }
        
        SetCallState(call_state);
        
        $('.callbox').slideDown("slow");
        
        if(call_state=='outconnected'||call_state=='inconnected'){
        //保存记录
        var cid = $('#call-cid').text();
        $.ajax({
            url: "/index.php/callrecord/ajax_add",
            data: {type:call_state,cid:cid,number:msgJsonData.dynamicdata.number,devicename:msgJsonData.devicename},
            type:'post',
            dataType:'json',
            success:function(data){
                if (data.code=='100') {
        
                }else{

                }
            },
            error:function(data){
                layer.msg('失败：'+data.msg,{icon:5,time:3000});
            }
        });
        }
        

        
    }
    else{
        if(msg!=null)
        {
            document.getElementById('messages').innerHTML += '<br />' + msg;
        }
        if(msgJsonData.dynamicdata!=null)
        {
            if(msgJsonData.type == "SpeechRecogn")
            {
                document.getElementById('messages').innerHTML += '<br />' + msgJsonData.dynamicdata.result;
            }
        }
        if(msgJsonData.data !=null)
        {
            if(msgJsonData.data.invoke_command.toLowerCase()=="readsms")
            {
                var a = msgJsonData.dynamicdata;
                document.getElementById('messageContent').innerHTML = '时间：'+a.time+'\n电话：'+a.phone+'\n内容：'+a.content;
            }
            if(msgJsonData.data.invoke_command.toLowerCase()=="getappkeytoken")
            {
                document.getElementById('appkey').value = msgJsonData.dynamicdata.appkey;
                document.getElementById('accesskeyid').value = msgJsonData.dynamicdata.accesskeyid;
                document.getElementById('accesskeysecret').value = msgJsonData.dynamicdata.accesskeysecret;
                document.getElementById('silence').value = msgJsonData.dynamicdata.silence;
            }
            if(msgJsonData.data.invoke_command.toLowerCase()=="getspeechrecognenbale")
            {
                if(msgJsonData.data.state)
                {
                    document.getElementById('speechrecognenable').innerHTML = "打开";
                }
                else	
                {
                    document.getElementById('speechrecognenable').innerHTML = "关闭";
                }
            }
        }
    }

    
    if (msgJsonData.type == "CallRecord" && msgJsonData.dynamicdata.state == "2") { //结束

        $('#call-stime').text(msgJsonData.dynamicdata.starttime);
        $('#call-atime').text(msgJsonData.dynamicdata.answertime);
        $('#call-etime').text(msgJsonData.dynamicdata.endtime);
        OnStopRecord(); //结束录音

    }
    
    
    if (msgJsonData.type == "CommandResponse") {
        
        if (msgJsonData.data.invoke_command == "StopRecord") {
            
        //更新记录并上传录音
        var recordfile = msgJsonData.dynamicdata.recordpath;
        if(recordfile){
        recordfile = recordfile;	
        }else{
        recordfile = '获取失败';	
        }
        
        OnUploadFile(recordfile);
        
        var stime = $('#call-stime').text();
        var atime = $('#call-atime').text();
        var etime = $('#call-etime').text();
		
		var hours = msgJsonData.dynamicdata.hour;
		var mins = msgJsonData.dynamicdata.min;
		var secs = msgJsonData.dynamicdata.sec;
		
		if (hours >= 0 && hours <= 9) {
			hours = "0" + hours;
		}
		if (mins >= 0 && mins <= 9) {
			mins = "0" + mins;
		}
		if (secs >= 0 && secs <= 9) {
			secs = "0" + secs;
		}

		var timing = hours+':'+mins+':'+secs;
        
        //保存记录
        $.ajax({
            url: "/index.php/callrecord/ajax_updata",
            data: {recordfile:recordfile,timing:timing,stime:stime,atime:atime,etime:etime},
            type:'post',
            dataType:'json',
            success:function(data){
                if (data.code=='100') {
        
                }else{
                    
                }
            },
            error:function(data){
                layer.msg('失败：'+data.msg,{icon:5,time:3000});
            }
        });
                

        }else if(msgJsonData.data.invoke_command == "GetCallState"&&msgJsonData.data.state==true&&msgJsonData.dynamicdata.state=='CALL_STATE_TALKING') {
            
            //检测是否在通话，防止页面刷新后不显示
            var call_state = 'outconnected';
            SetCallState(call_state);
            $('.callbox').slideDown("slow");
            
        }
        
        
    }
    

};

function get_device_state(){
	var device_state = 0;
	device_state = $('#device-state').text();
	return device_state;
}

function SetCallState(call_state)
{

    switch(call_state) {
         case 'outgoing':
            $('#call-state').text('正在拨号');
            $('.box_left').css('background','#ddd');
            $('#call-state').css('color','#333');
            $('.box_right').css('background','#F00');
            break;
         case 'ringback':
            $('#call-state').text('等待接听');
            $('.box_left').css('background','#F93');
            $('#call-state').css('color','#333');
            $('.box_right').css('background','#F00');
            break;
         case 'outconnected':
            $('#call-state').text('正在通话');
            $('.box_left').css('background','#096');
            $('#call-state').css('color','#096');
            $('.box_right').css('background','#F00');
            OnStartRecord(); //开始录音
            break;
         case 'hangup':
            $('#call-state').text('通话结束');
            $('.box_left').css('background','#ddd');
            $('#call-state').css('color','#f00');
            $('.box_right').css('background','#ddd');
            break;
            
         case 'incoming': //收到来电
            $('#call-state').text('来电');
            $('.box_left').html('接听');
            $('.box_left').css('font-size','16px');
            $('.box_left').css('background','#096');
            $('#call-state').css('color','#333');
            $('.box_right').css('background','#F00');
            break;
         case 'inconnected': //来电接通
            $('#call-state').text('来电');
            $('.box_left').css('background','#096');
            $('#call-state').css('color','#333');
            $('.box_right').css('background','#F00');
            OnStartRecord(); //开始录音
            break;
         default:
    }


}



function OnCheckUsbAudio()
{
    webSocket.send('{"command":"CheckUsbAudio"}');
}
function OnGetCCID()
{
    webSocket.send('{"command":"GetCCID"}');
}
function OnReadSms()
{
    var smsindex = document.getElementById('smsindex').value;
    webSocket.send('{"command":"ReadSms","arguments":{"content":"'+smsindex+'"}}');
}
function OnPlayStartRecord()
{
    var filename = document.getElementById("recordFile").value;
    webSocket.send('{"command":"PlayStartRecord","arguments":{"content":"'+filename+'"}}');
}
function OnPlayStopRecord()
{
    webSocket.send('{"command":"PlayStopRecord"}');
}
function OnStartRecord()
{
    webSocket.send('{"command":"StartRecord"}');
}
function OnStopRecord()
{
    webSocket.send('{"command":"StopRecord"}');
}
function OnGetConnectedState()
{
    webSocket.send('{"command":"GetConnectedState"}');
}
function OnResetToFactoryConfig()
{
    webSocket.send('{"command":"ResetToFactoryConfig"}');
}
function OnGetDeviceState()
{
    webSocket.send('{"command":"GetSignalLevel"}');
}
function OnGetSerialNumber()
{
    webSocket.send('{"command":"GetSerialNumber"}');
}
function OnSendDTMF()
{
    var dtmf = document.getElementById('dtmf').value;
    webSocket.send('{"command":"SendDTMF","arguments":{"content":"'+dtmf+'"}}');
}
function OnSendMessage()
{
    var number = document.getElementById('number').value;
    var content = document.getElementById('messageContent').value;
    webSocket.send('{"command":"SendSMS","arguments":{"phone":"'+number+'","content":"'+content+'"}}');
}
function OnUpdateDevice(){
    var filename = document.getElementById("file").value;
    webSocket.send('{"command":"UpdateDevice","arguments":{"content":"'+filename+'"}}');
}
function OnGetDeviceInfo(){
    webSocket.send('{"command":"GetDeviceInfo"}');
}
function OnDailout(cid,mobile){
    $('#call-cid').text(cid);
    $('#call-mobile').text(mobile);
    webSocket.send('{"command":"Dial","arguments":{"phone":"'+ mobile +'"}}');
}

function OnAnswer() {
    webSocket.send('{"command":"Answer"}');
}

function OnHungUp() {
    webSocket.send('{"command":"HungUp"}');
}

function OnGetCallState()
{
    webSocket.send('{"command":"GetCallState"}');
}

function OnOpenDevice()
{
    webSocket.send('{"command":"OpenDevice"}');
}
function OnCloseDevice() {
    webSocket.send('{"command":"CloseDevice"}');
}
function OnGetSpeechRecogn()
{
    webSocket.send('{"command":"GetAppKeyToken"}');
    webSocket.send('{"command":"GetSpeechRecognEnbale"}');
}
function OnSetSpeechRecogn()
{
    var appkey = document.getElementById('appkey').value;
    var accesskeyid = document.getElementById('accesskeyid').value;
    var accesskeysecret = document.getElementById('accesskeysecret').value;
    var silence = document.getElementById('silence').value;
    var sendJson= '{"command":"SetAppKeyToken","arguments":{"appkey":"'+appkey+'","accesskeyid":"' + accesskeyid +'","accesskeysecret":"' + accesskeysecret +'","silence":"'+silence+'"}}';
    webSocket.send(sendJson);
}
function OnOpenSpeechRecogn()
{
    webSocket.send('{"command":"OpenSpeechRecogn"}');
}
function OnCloseSpeechRecogn()
{
    webSocket.send('{"command":"CloseSpeechRecogn"}');
}
function OnOpenOnewayRecord()
{
    webSocket.send('{"command":"OpenOnewayRecord"}');
}
function OnCloseOnewayRecord()
{
    webSocket.send('{"command":"CloseOnewayRecord"}');
}
function OnSetDeviceWindowsAudio()
{
    var audio = document.getElementById('audio').value;
    webSocket.send('{"command":"SetDeviceWindowsAudio","arguments":{"content":"'+ audio +'"}}');
}
function OnGetDeviceAudio()
{
webSocket.send('{"command":"GetDeviceAudio"}');
}
function OnUploadFile(uploadfile)
{
    var url = 'http://test.com:71/index.php/upload/ajax_upload_record';
    var sendJson = '{"command":"UploadFile","arguments":{"url":"'+url+'","file":"'+uploadfile+'","diykey":"testkey,key2,key3","diyvalue":"testvalue,value2,value3"}}';
    webSocket.send(sendJson);
}
function OnHideMenu()
{
    var hidemenu = document.getElementById('hidemenu').value;
    webSocket.send('{"command":"HideMenu","arguments":{"content":"'+hidemenu+'"}}');
}
function OnShowNumber()
{
webSocket.send('{"command":"ShowNumber"}');
}
function OnHideNumber()
{
webSocket.send('{"command":"HideNumber"}');
}