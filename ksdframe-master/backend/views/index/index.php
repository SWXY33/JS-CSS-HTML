<div id="app">
    <el-row class="container" style="overflow: hidden;">
        <el-col :span="24" class="main">
            <aside class="collapsed" :class="isCollapse?'min-menu':'max-menu'">
                <div class="left-logo"><img src="./upload/images/logo.png" width="70px"></div>
                <div class="left-admin">{{adminTrueName}}{{roleName}}</div>
                <div class="left-menu">
                <el-menu unique-opened theme="dark" :collapse="isCollapse" text-color="#949494">
                    <template v-for="(item, index) in Grant">
                      <el-submenu :index="index + ''">
                        <template slot="title">
                          <i v-bind:class='item.icon' style="font-size: 20px;margin-right: 5px;width: 20px;color:#a8c6df"></i>
                          <span slot="title" style="font-weight: 600;">{{ item.name }}</span>
                        </template>
                        <el-menu-item-group>
                        <template v-for="(childItem, index) in item.childGrant">
                          <el-menu-item :index="index + ''" @click="addTab(childItem.name,childItem.tag,childItem.url,$event)" :id="'openTab'+childItem.adminGrantId">{{childItem.name}}</el-menu-item>
                        </template>
                        </el-menu-item-group>
                      </el-submenu>
                   </template>
                </el-menu>
                </div>
                <div class="sign-out" >
                    <i class="fa fa-user-circle-o" style="padding-right: 25px;" @click="updatePassword"></i>
                    <i class="fa fa-sign-out" @click="logout"></i>
                </div>
            </aside>
            <section class="content-container">
                <el-tabs v-model="Tab" type="card" closable @tab-remove="removeTab" class="main-tab">
                  <el-tab-pane
                    v-for="(item, index) in Tabs"
                    :key="item.name"
                    :label="item.title"
                    :name="item.name"
                  >
                    <div v-html="item.content"></div>
                  </el-tab-pane>
                </el-tabs>
            </section>
        </el-col>
        <el-dialog title="修改密码" :visible.sync="updateWindow"  :close-on-click-modal="false" size="tiny">
            <template>
                <el-tabs v-model="activeName"  type="card">
                    <el-form :model="update" label-width="100px" :rules="updatePasswordRules" ref="update">
                        <el-row>
                            <el-col :span="24">
                                <el-form-item label="新密码" prop="newPassword">
                                    <el-input type="password" v-model="update.newPassword" class="agent-input"  style="width:80%"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <el-form-item label="确认密码" prop="rePassword">
                                    <el-input type="password" v-model="update.rePassword" class="agent-input" style="width:80%"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-form-item style="text-align: left;">
                            <el-button type="primary" @click="submitPassword()">更 改</el-button>
                        </el-form-item>
                    </el-form>
                </el-tabs>
            </template>
        </el-dialog>
    </el-row>
    </div>
    <!-- content -->

    <script>
    var frame = AppFrame({
        data:{
            updateWindow:false,
            isCollapse:false,
            Tab: 'index',
            title:'首页',
            defaultLogo:'this.src="./images/login-logo.png"',
            activeName: 'first',
            adminTrueName:'',
            roleName:'',
            avatar:'',
            Grant:[],
            Tabs: [{
              title: '首页',
              name: 'index',
              content: (function(){
                return '<iframe id="gridIframe" scrolling="auto" frameborder="0"  src="'+AppCommon.getUrl('/index/home')+'" style="width:100%;height:950px;"></iframe>';
              })()
            }],
            tabIndex: 2,
            checkNumber:'',
            admin:'',
            update: {
                newPassword:'',
                rePassword:''
            },
            updatePasswordRules: {
                newPassword: [
                    { required: true, message: '请输入密码', trigger: 'blur' },
                    { min: 8, max: 16, message: '长度在 8 到 16 个字符', trigger: 'blur' }
                ],
                rePassword: [
                    { required: true, message: '请确认密码', trigger: 'blur' },
                    { min: 8, max: 16, message: '长度在 8 到 16 个字符', trigger: 'blur' }
                ]
            }
        },


        methods: {
            addTab:function(title,TabName,url,obj) {
                this.checkTab(TabName).then(() => {
                    this.creatTab(title,TabName,url,obj)
                })
            },
            checkTab:function(TabName){
                return new Promise((resolve, reject) => {
                    let tabs = this.Tabs;
                    let isCheck = true;
                    let chekcTab;
                    tabs.forEach((tab, index) => {
                        if (tab.name === TabName) {
                            isCheck = false;
                            checkTab = TabName;
                        }
                      });
                    if (isCheck) {
                        resolve();
                    }else{
                        this.Tab = TabName;
                    }
                })
            },
            creatTab:function(title,TabName,url,obj){
                var iframeHeight = $('.container').height()-40;
                var content = '<iframe id="gridIframe" scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%; min-width:1100px;height:'+iframeHeight+'px;min-height: 400px"></iframe>';
                let tabs = this.Tabs;
                this.Tabs.push({
                  title: title,
                  name: TabName,
                  content: content
                });
                this.Tab = TabName;
            },
            removeTab:function(targetName) {
                if (targetName == 'index') {
                    this.$message('首页不能关闭~');
                    return false;
                }
                let tabs = this.Tabs;
                let activeName = this.Tab;
                if (activeName === targetName) {
                  tabs.forEach((tab, index) => {
                    if (tab.name === targetName) {
                      let nextTab = tabs[index + 1] || tabs[index - 1];
                      if (nextTab) {
                        activeName = nextTab.name;
                      }
                    }
                  });
                }

                this.Tab = activeName;
                this.Tabs = tabs.filter(tab => tab.name !== targetName);
            },

            updatePassword:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                AppDialog.close(frameId);
                            });
                        }
                    },
                    {
                        label:'取消',
                        callback:function(contentWindow){
                            AppDialog.close(frameId);
                        }
                    }
                ];
                frameId = AppDialog.openFrame(AppCommon.getUrl('/admin/updatePasswordDialog'),'修改密码',buttonList);
            },

            submitPassword:function(){
                var self = this;
                var data = Object.assign({}, this.update);
                this.$refs.update.validate((valid) => {
                    if (valid) {
                        if (data.rePassword != data.newPassword) {

                            this.$message.error('两次输入密码不一致!');
                            return;
                        } else {
                            AjaxLoader.post(AppCommon.getUrl('/admin/updatePassword'),{'newPassword':data.newPassword},function(data){

                                self.$confirm('密码修改成功,请重新登陆', '提示', {
                                  confirmButtonText: '确定',
                                  type: 'success'
                                }).then(() => {

                                  self.logout();
                                });
                            });

                        }
                    }else{
                        console.log("submit error");
                    }
                })

            },
            getGrant:function(){
                var self = this;
                AjaxLoader.get(AppCommon.getUrl('/adminGrant/getAdminGrant'),function(data){
                    self.Grant = data;
                });
            },
            getAdmin:function(){
                var self = this;
                AjaxLoader.get(AppCommon.getUrl('/admin/getLoginAdminInfo'),function(data){
                    console.log(data);
                    self.adminTrueName = data['adminTrueName'];
                    self.roleName = "「"+data['roleName']+"」";
                    self.avatar = data['avatar'];
                    localStorage["adminId"] = data['adminId'];
                    localStorage["adminTrueName"] = data['adminTrueName'];
                    localStorage["roleName"] = data['roleName'];
                });
            },
            logout:function(){
                var self = this;
                AjaxLoader.get(AppCommon.getUrl('/login/out'),function(data){
                    localStorage.clear();
                    self.$message('退出成功');
                    window.location.href=AppCommon.getUrl('/login/index');
                });
            },
            openTab:function(id){
                document.getElementById(id).click();
            }
        },
        mounted:function(){
            this.getGrant();
            this.getAdmin();
        }

    })
</script>