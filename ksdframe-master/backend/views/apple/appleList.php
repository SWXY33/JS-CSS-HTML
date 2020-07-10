
<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <el-row class="container main-content" >
        <el-col :span="20" class="main">
            <section class="content-container fix-content">
                <!--工具条-->
                <el-col :span="24" class="toolbar">
                    <div class="fl top-search">
                        <div class="search-top-bar">
                            <el-input placeholder="请输入关键词" v-model="keyword" size="small" class="search-input"></el-input>
                        </div>
                        <el-button type="primary" size="small" @click="getAppleList()"><i class="el-icon-search"></i> 搜索</el-button>
                    </div>
                    <div class="fr">
                        <el-button type="primary" plain icon="el-icon-plus" size="small" @click="addApple()">新增</el-button>
                        <el-button type="success" plain icon="el-icon-edit" size="small" @click="updateApple()">编辑</el-button>
                        <el-dropdown>
                          <el-button type="warning" size="small" plain>
                            更多操作<i class="el-icon-arrow-down el-icon--right"></i>
                          </el-button>
                          <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native="addAccess"><span>ACTION1</span></el-dropdown-item>
                          </el-dropdown-menu>
                        </el-dropdown>

                    </div>
                </el-col>

                <!--列表-->
                <div class="content-table">
                    <el-table ref="multipleTable" :data="appleList" highlight-current-row  v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit @row-click="currentRowChange"@selection-change="handleSelectionChange">
                        <el-table-column
                              type="selection"
                              width="55">
                        </el-table-column>
                                                    <el-table-column
                                label="APPLEID"
                                prop="appleId">
                            </el-table-column>
                                                    <el-table-column
                                label="名字"
                                prop="name">
                            </el-table-column>
                                                    <el-table-column
                                label="颜色"
                                prop="color">
                            </el-table-column>
                                                    <el-table-column
                                label="价格"
                                prop="price">
                            </el-table-column>
                                                    <el-table-column
                                label="重量"
                                prop="weight">
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
    </el-row>
    </div>
    <script>
    var frame = AppFrame({
        data:{
            fullScreenLoading: true,
            appleList: [],
            currentPage:1,
            total: 1,
            pageSize:20,
            page: 1,
            changeData:'',
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
                this.getAppleList(this.page,pageSize,keytype,keyword);
            },
            currentRowChange:function(row, column, event) {
              this.$refs.multipleTable.toggleRowSelection(row);
            },
            handleSelectionChange:function(val) {
              this.changeData = val;
              console.log(this.changeData);
            },
            handleSizeChange:function(val) {
                this.currentPage = 1;
                this.pageSize = val;
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getAppleList(this.currentPage,this.pageSize,keytype,keyword);
            },

            addApple:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('添加完成');
                                that.getAppleList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/apple/addApplePage'),'添加',buttonList);
            },


            updateApple:function(){
                var that = this;
                var frameId = '';
                if (this.changeData.length != 1) {
                    that.msgError('请选择一行记录');
                    return ;
                }
                var appleId = this.changeData[0].appleId;
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('操作完成');
                                that.getAppleList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/apple/editApplePage?appleId='+appleId),'编辑',buttonList);
            },

            getAppleList:function(page,pageSize,keytype,keyword) {
                var that = this;
                this.listLoading = true;
                var keytype = keytype || this.keytype;
                var keyword = keyword || this.keyword;
                var page = page || this.page;
                var pageSize = pageSize || this.pageSize;
                var zoneIdList = this.zoneIdList;
                AjaxLoader.post(AppCommon.getUrl('/apple/getAppleList'),{'page':page,'pageSize':pageSize,'keytype':keytype,'keyword':keyword},function(data){
                    that.appleList = data['list'];
                    that.total = data['total'];
                    that.listLoading = false;
                });
            },
            delApple:function(appleId,name){
                var that = this;
                this.$confirm('确认删除【'+name+'】吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/apple/delApple'),{'appleId':appleId},function(data){
                    that.msgSuccess('删除成功');
                    that.getApplelist();
                });
            }).catch(() => {
                });
            }

        },
        mounted:function(){
            this.getAppleList();
        },

    })
</script>
