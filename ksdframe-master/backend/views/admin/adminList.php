<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <el-row class="container main-content" >
        <el-col :span="20" class="main">            
            <section class="content-container fix-content">
                <!--工具条-->
                <el-col :span="24" class="toolbar">
                    <div class="fl top-search">
                        <el-button-group>
                          <el-input placeholder="请输入查询内容" v-model="keyword" class="input-with-select" size="small">
                            <el-select slot="prepend" placeholder="请选择" size="small" v-model="keytype">
                              <el-option label="全部" value=""></el-option>
                              <el-option label="真实姓名" value="adminTrueName"></el-option>
                              <el-option label="手机号" value="mobile"></el-option>
                            </el-select>
                            <el-button slot="append" icon="el-icon-search" size="small" @click="getAdmin()"></el-button>
                          </el-input>
                        </el-button-group>
                    </div>
                    <div class="fr">
                        <el-button type="primary" plain icon="el-icon-plus" size="small" @click="addAdmin()">新增</el-button>
                        <el-dropdown>
                          <el-button type="warning" size="small" plain>
                            更多操作<i class="el-icon-arrow-down el-icon--right"></i>
                          </el-button>
                          <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native="updateAdmin">编辑</el-dropdown-item>
                            <el-dropdown-item @click.native="activeAdmin">激活</el-dropdown-item>
                            <el-dropdown-item @click.native="closeAdmin">禁用</el-dropdown-item>
                            <el-dropdown-item @click.native="delAdmin">删除</el-dropdown-item>
                          </el-dropdown-menu>
                        </el-dropdown>

                    </div>
                </el-col>

                <!--列表-->
                <div class="content-table">
                    <el-table ref="multipleTable" :data="adminList" highlight-current-row  v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit @selection-change="handleSelectionChange" @row-click="currentRowChange">
                        <el-table-column
                              type="selection"
                              width="55">
                        </el-table-column>
                        <el-table-column type="expand">
                            <template slot-scope="props">
                                <el-form label-position="left" inline class="content-table-expand">
                                    <el-form-item label="管理员ID">
                                        <span>{{ props.row.adminId }}</span>
                                    </el-form-item>
                                    <el-form-item label="管理区域">
                                        <span>{{ props.row.zoneName }}</span>
                                    </el-form-item>
                                    <el-form-item label="备注">
                                        <span>{{ props.row.content }}</span>
                                    </el-form-item>
                                </el-form>
                            </template>
                        </el-table-column>
                        <el-table-column label="管理员账号" prop="adminName">
                        </el-table-column>
                        <el-table-column label="管理员姓名" prop="adminTrueName">
                        </el-table-column>
                        <el-table-column label="角色" prop="roleName">
                        </el-table-column>
                        <el-table-column label="管理员状态" prop="adminStateName">
                            <template scope="scope">
                                <span v-if="scope.row.state == '1' " style="color: #4191EC;">{{scope.row.adminStateName}}</span>
                                <span v-if="scope.row.state == '-1' " style="color: #FF4948;">{{scope.row.adminStateName}}</span>
                                <span v-if="scope.row.state == '0' " style="color: #E6A23C;">{{scope.row.adminStateName}}</span>
                            </template>
                        </el-table-column>
                    </el-table>

                    <!--工具条-->
                    <el-col :span="24" class="text-right">
                        <div class="table-page">
                            <el-pagination
                                @current-change="handleCurrentChange"
                                @size-change="handleSizeChange"
                                :current-page="currentPage"
                                :page-sizes="[20, 50, 100]"
                                :page-size="pageSize"
                                layout="total, sizes, prev, pager, next, jumper"
                                :total="total">
                            </el-pagination>
                        </div>
                    </el-col>
                </div>


            </section>
        </el-col>
        <el-col :span="4" class="main-right">
            <section class="content-right">
                <div class="content-main-right">

                    <div class="right-tip-title" style="padding-top:50px;"><i class="el-icon-microphone"></i>小提示</div>
                    <div class="right-tip-content">
                        <span class="tip-title">开卡流程是怎样的？</span>
                        <div>
                            <p>1.输入信息后，系统检测该号码是否与学校卡编码规则匹配。</p>
                            <p>2.点击确认后，卡信息录入数据库，系统记录开卡日志。并将开卡信息发送至审核员确认.</p>
                            <p>3.审核员审查开卡信息，填写审核结果后，系统记录审核日志。</p>
                            <p>4.审核结果发送至业务员。</p>
                            <p>5.开卡操作完成。</p>
                        </div>
                    </div>
                    <div class="right-tip-content">
                        <span class="tip-title">如何设置管理员坐标？</span>
                        <div>
                            <p>1.选中一条操作管理员，点击'更多操作'中的'拾取坐标'。</p>
                            <p>2.在弹出窗口中点击'打开地图'，点击地图中的位置，在地图右下角框中将获得改点的经纬度坐标.</p>
                            <p>3.复制框中经纬度坐标，然后关闭内部地图窗口。</p>
                            <p>4.复制的坐标','之前为经度，之后为纬度。</p>
                            <p>5.将相关坐标复制到对应输入框中，确认无误后点击保存按钮。</p>
                        </div>
                    </div>
                </div>
            </section>
        </el-col>
    </el-row>
    </div>
    <script>
    var frame = AppFrame({
        data:{
            changeData:'',
            fullScreenLoading: true,
            adminList: [],
            currentPage:1,
            total: 1,
            pageSize:20,
            page: 1,
            tableHeight:'',
            keytype:'',
            keyword:'',
            listLoading: false,
        },
        methods: {
            handleCurrentChange:function(val) {
                this.page = val;
                var pageSize = this.pageSize;
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getAdminList(this.page,pageSize,keytype,keyword);
            },

            handleSizeChange:function(val) {
                this.currentPage = 1;
                this.pageSize = val;
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getAdminList(this.currentPage,this.pageSize,keytype,keyword);
            },

            currentRowChange(row, column, event) {
                this.$refs.multipleTable.toggleRowSelection(row);
            },

            handleSelectionChange(val) {
                this.changeData = val;
                console.log(this.changeData);
            },

            getAdmin:function(){
                var keyword = this.keyword;
                var keytype = this.keytype;
                var page = this.page;
                this.getAdminList(page,this.pageSize,keytype,keyword);
            },

            addAdmin:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.getAdmin();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/admin/addAdminDialog'),'添加管理员',buttonList,'max');
            },

            updateAdmin:function(){
                var changeData = this.changeData;
                if(changeData.length>1){
                    this.msgError('编辑不支持多选');
                    return;
                }
                if(changeData.length<1){
                    this.msgError('未勾选操作管理员');
                    return;
                }
                var adminId = changeData[0].adminId;
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.getAdmin();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/admin/addAdminDialog?adminId='+adminId),'编辑管理员',buttonList,'max');
            },

            getAdminList:function(page,pageSize,keytype,keyword) {
                var that = this;
                this.listLoading = true;
                var keytype = keytype || this.keytype;
                var keyword = keyword || this.keyword;
                var admin = {};
                admin.keytype = keytype;
                admin.keyword = keyword;
                admin.page = page;
                admin.pageSize = pageSize;
                console.log(admin);
                AjaxLoader.post(AppCommon.getUrl('/admin/getAdminList'),{'admin':admin},function(data){
                    that.adminList = data['list'];
                    that.total = data['total'];
                    that.listLoading = false;
                });
            },

            delAdmin:function(){
                var changeData = this.changeData;
                if(changeData.length>1){
                    this.msgError('删除暂不支持多选');
                    return;
                }
                if(changeData.length<1){
                    this.msgError('未勾选操作管理员');
                    return;
                }
                var that = this;
                this.$confirm('确认删除已勾选管理员吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/admin/delAdmin'),{'adminList':changeData},function(data){
                    that.msgSuccess('删除成功');
                    that.getAdmin();
                });
            }).catch(() => {
                });
            },

            closeAdmin:function(){
                var changeData = this.changeData;
                if(changeData.length<1){
                    this.msgError('未勾选操作管理员');
                    return;
                }
                var that = this;
                this.$confirm('确认禁用已勾选的管理员吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/admin/closeAdmin'),{'adminList':changeData},function(data){
                    that.msgSuccess('操作成功');
                    that.getAdmin();
                });
            }).catch(() => {
                });
            },

            activeAdmin:function(){
                var changeData = this.changeData;
                if(changeData.length<1){
                    this.msgError('未勾选操作管理员');
                    return;
                }
                var that = this;
                this.$confirm('确认激活已勾选的管理员吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/admin/activeAdmin'),{'adminList':changeData},function(data){
                    that.msgSuccess('操作成功');
                    that.getAdmin();
                });
            }).catch(() => {
                });
            },

        },

        mounted:function(){
            this.getAdmin();
        },

    })
</script>
