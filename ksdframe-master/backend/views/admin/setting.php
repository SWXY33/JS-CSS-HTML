<div id="app">
    <el-row class="container main-content" >
        <el-col :span="24" class="main">
            <section class="content-container fix-content">
                <div class="content">
                    <template>
                        <el-tabs v-model="activeName" class="setting" v-loading.fullscreen.lock="fullScreenLoading">
                            <el-tab-pane label="个人资料" name="base">
                                <div class="tab-content">
                                    <el-form ref="adminData" :model="adminData" label-width="120px">
                                        <el-form-item label="姓名">
                                            <span>{{adminData.adminTrueName}}</span>
                                        </el-form-item>
                                        <el-form-item label="登录账号">
                                            <span>{{adminData.adminName}}</span>
                                        </el-form-item>
                                        <el-form-item label="手机号">
                                            <el-input v-model="adminData.mobile" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item label="邮箱">
                                            <el-input v-model="adminData.email" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item>
                                            <el-button type="primary" @click="shopSubmit">保 存</el-button>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </template>
                </div>
            </section>
        </el-col>
    </el-row>
</div>

<script>
    var frame = AppFrame({
        data:{
            fullScreenLoading: true,
            activeName:'base',
            adminData: {}
        },
        methods: {
            fileSet:function(response) {
                this.adminData[response.data.keyName] = response.data.fileName;
            },
            fileRmove:function(file){
                this.adminData[file.response.data.keyName] = '';
            },
            getAdminInfo:function(){
                var self = this;
                AjaxLoader.post(AppCommon.getUrl('/admin/getAdminInfo'),{},function(data){
                    console.log(data);
                    self.fullScreenLoading = false;
                    self.adminData = data;
                });
            },
            shopSubmit:function(){ 
                var self = this;
                var adminData = Object.assign({}, this.adminData);
                AjaxLoader.post(AppCommon.getUrl('/admin/updateAdminInfo'),{adminData},function(res){
                    self.getAdminInfo();        
                    self.msgSuccess('保存成功！');
                });
            },
        },
        mounted:function() {
            this.getAdminInfo();
            var tableHeight = document.documentElement.clientHeight - 160;
            this.tableHeight = tableHeight;
        }

    })
</script>
