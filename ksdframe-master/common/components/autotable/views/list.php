
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
                        <el-button type="primary" size="small" @click="get<?=ucfirst($name)?>List()"><i class="el-icon-search"></i> 搜索</el-button>
                    </div>
                    <div class="fr">
                        <el-button type="primary" plain icon="el-icon-plus" size="small" @click="add<?=ucfirst($name)?>()">新增</el-button>
                        <el-button type="success" plain icon="el-icon-edit" size="small" @click="update<?=ucfirst($name)?>()">编辑</el-button>
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
                    <el-table ref="multipleTable" :data="<?=$name?>List" highlight-current-row  v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit @row-click="currentRowChange"@selection-change="handleSelectionChange">
                        <el-table-column
                              type="selection"
                              width="55">
                        </el-table-column>
                        <?php foreach($config['showCols'] as $col ): ?>
                            <el-table-column
                                label="<?=isset($config['colsNames'][$col])?$config['colsNames'][$col]:strtoupper($col)?>"
                                prop="<?=$col?>">
                            </el-table-column>
                        <?php endforeach; ?>

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
            <?=$name?>List: [],
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
                this.get<?=ucfirst($name)?>List(this.page,pageSize,keytype,keyword);
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
                this.get<?=ucfirst($name)?>List(this.currentPage,this.pageSize,keytype,keyword);
            },

            add<?=ucfirst($name)?>:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('添加完成');
                                that.get<?=ucfirst($name)?>List();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/<?=$name?>/add<?=ucfirst($name)?>Page'),'添加',buttonList);
            },


            update<?=ucfirst($name)?>:function(){
                var that = this;
                var frameId = '';
                if (this.changeData.length != 1) {
                    that.msgError('请选择一行记录');
                    return ;
                }
                var <?=$config['primaryKey']?> = this.changeData[0].<?=$config['primaryKey']?>;
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('操作完成');
                                that.get<?=ucfirst($name)?>List();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/<?=$name?>/edit<?=ucfirst($name)?>Page?<?=$config['primaryKey']?>='+<?=$config['primaryKey']?>),'编辑',buttonList);
            },

            get<?=ucfirst($name)?>List:function(page,pageSize,keytype,keyword) {
                var that = this;
                this.listLoading = true;
                var keytype = keytype || this.keytype;
                var keyword = keyword || this.keyword;
                var page = page || this.page;
                var pageSize = pageSize || this.pageSize;
                var zoneIdList = this.zoneIdList;
                AjaxLoader.post(AppCommon.getUrl('/<?=$name?>/get<?=ucfirst($name)?>List'),{'page':page,'pageSize':pageSize,'keytype':keytype,'keyword':keyword},function(data){
                    that.<?=$name?>List = data['list'];
                    that.total = data['total'];
                    that.listLoading = false;
                });
            },
            del<?=ucfirst($name)?>:function(<?=$config['primaryKey']?>,name){
                var that = this;
                this.$confirm('确认删除【'+name+'】吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/<?=$name?>/del<?=ucfirst($name)?>'),{'<?=$config['primaryKey']?>':<?=$config['primaryKey']?>},function(data){
                    that.msgSuccess('删除成功');
                    that.get<?=ucfirst($name)?>list();
                });
            }).catch(() => {
                });
            }

        },
        mounted:function(){
            this.get<?=ucfirst($name)?>List();
        },

    })
</script>
