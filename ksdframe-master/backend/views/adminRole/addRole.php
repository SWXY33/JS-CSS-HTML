<div id="app" style="width: 780px">
    <el-row style="width:780px;padding:20px;" >
        <template>
            <el-form :model="roleData" label-width="100px" ref="roleData">
                <div>
                    <el-row>
                        <el-col :span="24">
                            <el-form-item label="角色名" prop='roleName'>
                                <el-input v-model="roleData.roleName" style="width:300px;"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="24">
                            <el-form-item label="角色描述" prop='roleContent'>
                                <el-input v-model="roleData.roleContent" style="width:500px;"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </div>
                  <el-row>
                      <el-col :span="24">
                          <el-form-item label="角色管理" v-model="kindName">
                              <div style="margin: 15px 0;"></div>                                
                              <el-checkbox-group v-model="roleData.kindName">
                                  <div v-for="roleData in roleList" style="width: 100px;">
                                        <el-checkbox :label="roleData.firstName" style="font-weight: bold;" ></el-checkbox>
                                        <div style="width:550px;border-bottom: 1px solid #ececec;display: inline-block;">
                                        <div v-for="secondName in roleData.secondList" style="float: left;margin-right:10px;">
                                            <el-checkbox :label="secondName"></el-checkbox>
                                        </div>
                                        </div>
                                  </div>
                              </el-checkbox-group>
                          </el-form-item>
                      </el-col>
                  </el-row>
              </el-form>
        </template>
    </el-row>
</div>

<script>
    window.appFrameObject = AppFrame({
        data:{
            adminRoleId:'',
            roleList:[],
            kindName:[],
            roleData:{
              roleName:'',
              roleContent:'',
              kindName:[],
            },
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var roleData = this.roleData;
                var roleId = this.adminRoleId;
                if (!roleId) {
                    if(roleData.roleName==''){
                        this.msgError("角色名不能为空");
                        return;
                    }
                    AjaxLoader.post(AppCommon.getUrl('/adminRole/addRoleData'),{'roleData':roleData},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/adminRole/updateRoleData'),{'roleId':roleId,'roleData':roleData},function(res){
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },

            getRoleInfo:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/adminRole/getRoleInfo'),{'adminRoleId':this.adminRoleId},function(data){
                    that.roleData.roleName = data.name;
                    that.roleData.roleContent = data.content;
                    that.roleData.kindName = data.tagList;
                    AppCommon.run(callback,data);
                });
            },

            getAdminRole:function(){
                var self = this;
                AjaxLoader.get(AppCommon.getUrl('/adminGrant/grantListData'),function(data){
                    self.roleList = data;
                })
            },

            reloadForm:function(){
                location.reload();
            },
        },
        mounted:function(){
            var adminRoleId = AppCommon.getUrlParam('adminRoleId');
            if (adminRoleId) {
                this.adminRoleId = adminRoleId;
                this.getRoleInfo();
            }
            this.getAdminRole();
        },

    })
</script>
