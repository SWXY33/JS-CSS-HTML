<div id="app" style="width: 600px">
    <el-row style="width:600px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" v-model="admin">
                <el-form-item label="管理员真实姓名">
                    <el-input class="form-input" v-model="admin.adminTrueName"></el-input><span style="color: #ff0000;"> *</span>
                </el-form-item>
              <el-form-item label="管理员用户名">
                  <el-input class="form-input" v-model="admin.adminName"></el-input><span style="color: #ff0000;"> *</span>
              </el-form-item>
                <el-form-item label="管理员密码" v-if="adminId==''">
                    <el-input class="form-input" type="password" v-model="admin.password"></el-input>
                </el-form-item>
                <el-form-item label="确认密码" v-if="adminId==''">
                    <el-input class="form-input" type="password" v-model="passwordCheck"></el-input>
                </el-form-item>
              <el-form-item label="手机号">
                  <el-input class="form-input" type="number" v-model="admin.mobile"></el-input>
              </el-form-item>
              <el-form-item label="选择角色">
                  <el-select v-model="admin.roleId" placeholder="选择角色">
                      <el-option
                            v-for="item in roleList"
                            :key="item.roleId"
                            :label="item.roleName"
                            :value="item.roleId">
                      </el-option>
                  </el-select><span style="color: #ff0000;"> *</span>
              </el-form-item>
                <el-form-item label="管理区域">
                    <template>
                        <el-checkbox-group v-model="zoneCheckList" @change="handleCheckedZoneChange">
                            <el-checkbox v-for="zone in zoneList" :label="zone" :key="zone">{{zone}}</el-checkbox>
                        </el-checkbox-group>
                    </template>
                </el-form-item>
              <el-form-item label="备注">
                  <el-input type="textarea" v-model="admin.content"></el-input>
              </el-form-item>
            </el-form>
        </template>
    </el-row>
</div>

<script>
    window.appFrameObject = AppFrame({
        data:{
            admin:{
                adminName:'',
                adminTrueName:'',
                password:'',
                mobile:'',
                roleId:'',
                content:'',
                zoneNameList:[]
            },
            passwordCheck:'',
            zoneCheckList:[],
            zoneList:[],
            roleList:[],
            adminId:''
        },
        methods: {
            handleCheckedZoneChange(value) {
                console.log(value);
                console.log(this.zoneCheckList);
            },
            onSubmit:function(callback){
                var that = this;
                var admin = this.admin;
                var adminId = this.adminId;
                admin.zoneNameList = this.zoneCheckList;
                if(admin.adminTrueName==''){
                    this.msgError("管理员姓名不能为空");
                    return;
                }
                if(admin.adminName==''){
                    this.msgError("管理员用户名不能为空");
                    return;
                }
                var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
                if(reg.test(admin.adminName)) {
                    this.msgError("管理员用户名不能包含中文");
                    return;
                }
                if(admin.roleId==''){
                    this.msgError("请选择管理员所属角色");
                    return;
                }
                if (!adminId) {
                    if(admin.password!=this.passwordCheck){
                        this.msgError("两次密码不一致");
                        return;
                    }
                    AjaxLoader.post(AppCommon.getUrl('/admin/addAdmin'),{'admin':admin},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/admin/updateAdmin'),{'adminId':adminId,'admin':admin},function(res){
                        that.msgSuccess('更新完成');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },

            getAdminInfo:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/admin/getAdminInfo'),{'adminId':this.adminId},function(data){
                    that.zoneCheckList = data.zoneNameList;
                    that.admin = data;
                    AppCommon.run(callback,data);
                });
            },

            getRoleList:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/adminRole/getSelectRoleList'),{},function(data){
                    that.roleList = data;
                    AppCommon.run(callback,data);
                });
            },

            getZoneList:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/zone/getActiveZoneNameList'),{},function(data){
                    that.zoneList = data;
                    AppCommon.run(callback,data);
                });
            },

            reloadForm:function(){
                location.reload();
            },
        },
        mounted:function(){
            this.getZoneList();
            this.getRoleList();
            var adminId = AppCommon.getUrlParam('adminId');
            if (adminId) {
                this.adminId = adminId;
                this.getAdminInfo();
            }
        },

    })
</script>
