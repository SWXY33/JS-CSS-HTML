<div id="app">
    <div class="app-container with-tabbar" style="width: 100%; height: 100%;background-color: #F6F6F6;min-height: 500px;">
        <div class="app-content">


            <div class="check-box">
                <div class="check-box-item clear">
                    <p class="fl">学生姓名:</p>
                    <input type="text" placeholder="请输入学生姓名" class="fl">
                </div>
                <div class="check-box-item clear">
                    <p class="fl">家长手机号:</p>
                    <input type="text" placeholder="请输入家长手机号" class="fl">
                    <div class="check-code-btn fr">获取验证码</div>
                </div>
                <div class="check-box-item clear">
                    <p class="fl">手机验证码:</p>
                    <input type="text" placeholder="请输入手机验证码" class="fl">
                </div>
            </div>

            <div class="check-bind-btn">立即绑定</div>

            <div class="powered-by">技术支持:山东跨世代网络科技有限公司</div>


        </div>
    </div>
</div>

<script>

    var frame = AppFrame({
        data:{

        },
        methods: {
            handleClick: function() {
                this.msg("简单普通提示");
                this.msgError("错误试题");
                this.msgSuccess("成功提示");
            },
            getList:function(){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/member/setUserPasswordKey'),{
                    'email':11
                },function(res){
                    that.msg("登录提示");
                });
            }
        },
        mounted:function(){
        }
    });

</script>