<style type="text/css">
html,body{
  width: 100%;
  height: 100%;
}
.login-bg{
    height: 100%;
    width: 100%;
    position: absolute;
    background-size: 100%;
}
.login-container {
    border-radius: 5px;
    background-clip: padding-box;
    width: 377px;
    padding: 35px 35px 55px 35px;
    background: rgba(255,255,255,0.7);
    border: 1px solid #eaeaea;
    /*box-shadow: 0 0 25px #cac6c6;*/
}

.login-container .title {
    margin: 0px auto 40px auto;
    text-align: center;
    color: #505458;
}
.remember {
    margin: 5px 0px 35px 0px;
    float: left;
}
.login-welcome{
    position: fixed;
    top: 15%;
    text-align: center;
    display: inline-block;
    width: 100%;
}
.login-welcome img{
  width: 500px;
}
.login-main{
    position: fixed;
    top: 30%;
    text-align: center;
    display: inline-block;
    width: 100%;
}
.login-title img{
  width: 50px;
  vertical-align: middle;
}
.login-title span{
  font-size: 25px;
  font-weight: 400;
  color: rgb(5, 126, 255);
  position: relative;
  top: 5px;
}
.login-form{
    margin-top: 20px;
    text-align: center;
    display: inline-block;
    width: 100%;
}
.login-form .login-container{
  margin: 0 auto;
}
.login-cp{
    position: fixed;
    bottom: 5%;
    text-align: center;
    display: inline-block;
    width: 100%;
}
.login-cp span{
    font-size: 12px;
    color: rgba(255,255,255,0.66);
    font-weight: 300;
}
.login-fa{
    position: absolute;
    left: 10px;
    z-index: 99;
    font-size: 18px;
    top: 13px;
    color: #ccc;
}
.login-form .el-input__inner{
  padding: 3px 35px;
  height: 44px;
}
.find-password{
    float: right;
    font-size: 14px;
    position: relative;
    top: 7px;
    color: #20a0ff;
    cursor: pointer;
}
.login-btn{
  width:100%;
  height: 44px;
  font-size: 14px;
}
.login-video-bg {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    text-align: center;
    overflow: hidden;
    background-image: -webkit-linear-gradient(135deg,rgba(32, 161, 237, 0.85) 0,rgba(39, 129, 240, 0.85) 58%,rgba(40, 166, 240, 0.85) 100%);
    background-image: -moz-linear-gradient(135deg,rgba(32, 161, 237, 0.85) 0,rgba(39, 129, 240, 0.85) 58%,rgba(40, 166, 240, 0.85) 100%);
    background-image: -o-linear-gradient(135deg,rgba(32, 161, 237, 0.85) 0,rgba(39, 129, 240, 0.85) 58%,rgba(40, 166, 240, 0.85) 100%);
    background-image: -ms-linear-gradient(135deg,rgba(32, 161, 237, 0.85) 0,rgba(39, 129, 240, 0.85) 58%,rgba(40, 166, 240, 0.85) 100%);
    background-image: linear-gradient(135deg,rgba(32, 161, 237, 0.85) 0,rgba(39, 129, 240, 0.85) 58%,rgba(40, 166, 240, 0.85) 100%);
}
.login-video {
    position: fixed;
    width: auto;
    height: auto;
    min-height: 100%;
    min-width: 100%;
    right: 0;
    left: 0;
    top: 0;
    bottom: 0;
    z-index: -10;
}
</style>
<div class="login-video-bg">
</div>
<!-- <video loop="loop" class="login-video" muted="muted" preload="auto" autoplay="autoplay">
    <source src="../images/loginVideo.mp4" type="video/mp4">
</video> -->
<img src="../images/login.png" alt="" style="height: 100%;min-width: 100%;position: fixed;">
<div id="app">

    <div class="login-bg" @keyup="keySubmit">
      <div class="login-welcome">
        <img src="../images/login-welcome.png">
      </div>
      <div class="login-main">
          <div class="login-title">
            <img src="../upload/images/<?=CONFIG('shop_logo')?>" :onerror="defaultLogo">
            <span><?=CONFIG('sys_title')?>管理中心</span>
          </div>
          <div class="login-form">
            <el-form :model="loginForm" :rules="rules" ref="loginForm" label-position="left" label-width="0px" class="demo-ruleForm login-container">
              <el-form-item prop="account" style="position: relative;">
                <i class="fa fa-user login-fa"></i>
                <el-input type="text" v-model="loginForm.account" auto-complete="off" placeholder="账号"></el-input>
              </el-form-item>
              <el-form-item prop="checkPass" style="position: relative;">
                <i class="fa fa-lock login-fa"></i>
                <el-input type="password" v-model="loginForm.checkPass" auto-complete="off" placeholder="密码"></el-input>
              </el-form-item>
              <el-form-item style="width:100%;margin-bottom: 10px;">
                <el-button type="primary" id="submit" class="login-btn" @click.native.prevent="handleSubmit"  :loading="logining">登 录</el-button>
              </el-form-item>
              <el-checkbox v-model="loginForm.remember" checked class="remember">保存登录</el-checkbox>
              <span class="find-password" @click="findPassword">忘记密码?</span>
            </el-form>
          </div>
      </div>
      <div class="login-cp">
          <span>Copyright &copy; <?php echo date('Y');?> Kasday.CN. All Rights Reserved. <?=CONFIG('sys_version')?> </span>
      </div>
  </div>
</div>
<!-- content -->

<script>
var frame = AppFrame({
    data:{
        logining: false,
        loginForm: {
            account: '',
            checkPass: '',
            remember:1
        },
        defaultLogo:'this.src="../images/login-logo.png"',
        rules: {
          account: [
            { required: true, message: '请输入账号', trigger: 'blur' },
          ],
          checkPass: [
            { required: true, message: '请输入密码', trigger: 'blur' },
          ]
        }
    },
    methods:{
        checkBrowser:function(){
            var isChrome = window.navigator.userAgent;
            if (!isChrome) {
                AppDialog.alert('请使用Chrome内核浏览器登陆本系统！');
            }
        },
        findPassword:function(){
             AppDialog.alert('请联系系统管理员！');
        },
        handleSubmit:function(ev) {
        var self = this;

        if (!self.loginForm.account.length || !self.loginForm.checkPass.length) {
            return AppDialog.alert('请输入账号或密码！');
        }

        self.$refs.loginForm.validate((valid) => {
          if (valid) {
            var remember = self.loginForm.remember?1:0;
            var loginParams = { username: self.loginForm.account, password: self.loginForm.checkPass,remember:remember };
            AjaxLoader.post(AppCommon.getUrl('/login/in'),loginParams,function(data){
                self.$message('登录成功');
                window.location.href=AppCommon.getUrl('/index') ;
            });

          } else {
            console.log('error submit!!');
            return false;
          }
        });
    },
    keySubmit:function(){
        if(event.keyCode==13){
            document.getElementById("submit").click();
        }
    }
  },
  mounted:function() {
      this.checkBrowser();

  }

})
</script>