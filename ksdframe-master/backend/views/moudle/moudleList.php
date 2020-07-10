
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
                        <el-button type="primary" size="small" @click="getMoudleList()"><i class="el-icon-search"></i> 搜索</el-button>
                    </div>
                    <div class="fr">
                        <el-button type="primary" plain icon="el-icon-plus" size="small" @click="addMoudle()">新增</el-button>
                        <el-button type="success" plain icon="el-icon-edit" size="small" @click="updateMoudle()">编辑</el-button>
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
                    <el-table ref="multipleTable" :data="moudleList" highlight-current-row  v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit @row-click="currentRowChange"@selection-change="handleSelectionChange">
                        <el-table-column
                              type="selection"
                              width="55">
                        </el-table-column>
                                                    <el-table-column
                                label="MOUDLEID"
                                prop="moudleId">
                            </el-table-column>
                                                    <el-table-column
                                label="模块名"
                                prop="moudleName">
                            </el-table-column>
                                                    <el-table-column
                                label="表字段"
                                prop="tableCols">
                            </el-table-column>
                                                    <el-table-column
                                label="显示字段"
                                prop="showCols">
                            </el-table-column>
                                                    <el-table-column
                                label="主键"
                                prop="primaryKey">
                            </el-table-column>
                                                    <el-table-column
                                label="字段名"
                                prop="colsNames">
                            </el-table-column>
                                                    <el-table-column
                                label="字段类型"
                                prop="colsTypes">
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
            moudleList: [],
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
                this.getMoudleList(this.page,pageSize,keytype,keyword);
            },
            currentRowChange(row, column, event) {
              this.$refs.multipleTable.toggleRowSelection(row);
            },
            handleSelectionChange(val) {
              this.changeData = val;
              console.log(this.changeData);
            },
            handleSizeChange:function(val) {
                this.currentPage = 1;
                this.pageSize = val;
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getMoudleList(this.currentPage,this.pageSize,keytype,keyword);
            },

            addMoudle:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('添加完成');
                                that.getMoudleList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/moudle/addMoudlePage'),'添加',buttonList);
            },


            updateMoudle:function(){
                var that = this;
                var frameId = '';
                if (this.changeData.length != 1) {
                    that.msgError('请选择一行记录');
                    return ;
                }
                var moudleId = this.changeData[0].moudleId;
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('操作完成');
                                that.getMoudleList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/moudle/editMoudlePage?moudleId='+moudleId),'编辑',buttonList);
            },

            getMoudleList:function(page,pageSize,keytype,keyword) {
                var that = this;
                this.listLoading = true;
                var keytype = keytype || this.keytype;
                var keyword = keyword || this.keyword;
                var page = page || this.page;
                var pageSize = pageSize || this.pageSize;
                var zoneIdList = this.zoneIdList;
                AjaxLoader.post(AppCommon.getUrl('/moudle/getMoudleList'),{'page':page,'pageSize':pageSize,'keytype':keytype,'keyword':keyword},function(data){
                    that.moudleList = data['list'];
                    that.total = data['total'];
                    that.listLoading = false;
                });
            },
            delMoudle:function(MoudleId,name){
                var that = this;
                this.$confirm('确认删除【'+name+'】吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/moudle/delMoudle'),{'MoudleId':MoudleId},function(data){
                    that.msgSuccess('删除成功');
                    that.getMoudlelist();
                });
            }).catch(() => {
                });
            }

        },
        mounted:function(){
            this.getMoudleList();
        },

    })
</script>
