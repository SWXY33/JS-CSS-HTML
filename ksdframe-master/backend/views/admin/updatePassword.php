<div id="app" style="width: 600px">
    <el-row style="width:600px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" v-model="admin">
              <el-form-item label="请输入新密码">
                  <el-input class="form-input" type="password" v-model="admin.newPassword"></el-input><span style="color: #ff0000;"> *</span>
              </el-form-item>
              <el-form-item label="确定密码">
                  <el-input class="form-input" type="password" v-model="passwordCheck"></el-input><span style="color: #ff0000;"> *</span>
              </el-form-item>
            </el-form>
        </template>
    </el-row>
</div>

<script>
    window.appFrameObject = AppFrame({
        data:{
            admin:{
                newPassword:''
            },
            passwordCheck:'',
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var admin = this.admin;
                if(admin.newPassword==''){
                    this.msgError("请输入新密码");
                    return;
                }
                if(admin.newPassword!=this.passwordCheck){
                    this.msgError("两次密码不一致");
                    return;
                }
                AjaxLoader.post(AppCommon.getUrl('/admin/updateAdminPassword'),{'admin':admin},function(res){
                    that.msgSuccess('保存成功');
                    AppCommon.run(callback,res);
                });
            },

            reloadForm:function(){
                location.reload();
            },
        },
        mounted:function(){

        },

    })
</script>
