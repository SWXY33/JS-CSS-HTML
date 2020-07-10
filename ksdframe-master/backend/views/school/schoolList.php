<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <el-row class="container main-content" >
        <el-col :span="20" class="main">            
            <section class="content-container fix-content">
                <!--工具条-->
                <el-col :span="24" class="toolbar">
                    <div class="fl top-search">
                        <div class="search-top-bar">
                            <span style="font-size: 12px;">区域</span>
                            <el-cascader
                                    placeholder="请选择地区"
                                    v-model="selectZoneList"
                                    @change="zoneChange"
                                    :options="zoneList"
                                    size="small"
                                    filterable
                                    :props="{ checkStrictly: true }"
                                    clearable
                                    style="width:270px;"
                            >
                            </el-cascader>
                        </div>
                        <div class="search-top-bar">
                            <span style="font-size: 12px;">学校</span>
                            <el-input placeholder="请输入学校名称" v-model="keyword" size="small" class="search-input"></el-input>
                        </div>
                        <el-button type="primary" size="small" @click="getSchoolList()"><i class="el-icon-search"></i> 搜索</el-button>
                    </div>
                    <div class="fr">
                        <el-button type="primary" plain icon="el-icon-plus" size="small" @click="addSchool()">新增</el-button>
                        <el-button type="success" plain icon="el-icon-edit" size="small" @click="updateSchool()">编辑</el-button>
                        <el-dropdown>
                          <el-button type="warning" size="small" plain>
                            更多操作<i class="el-icon-arrow-down el-icon--right"></i>
                          </el-button>
                          <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native="addAccess"><span>通话策略</span></el-dropdown-item>
                          </el-dropdown-menu>
                        </el-dropdown>

                    </div>
                </el-col>

                <!--列表-->
                <div class="content-table">
                    <el-table ref="multipleTable" :data="schoolList" highlight-current-row  v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit @row-click="currentRowChange"@selection-change="handleSelectionChange">
                        <el-table-column 
                              type="selection"
                              width="55">
                        </el-table-column>
                        <el-table-column type="expand">
                          <template slot-scope="props">
                            <el-form label-position="left" inline class="content-table-expand">
                              <el-form-item label="所属区域">
                                <span>{{ props.row.zoneName }}</span>
                              </el-form-item>
                              <el-form-item label="省">
                                <span>{{ props.row.provinceName }}</span>
                              </el-form-item>
                              <el-form-item label="市">
                                <span>{{ props.row.cityName }}</span>
                              </el-form-item>
                              <el-form-item label="区">
                                <span>{{ props.row.districtName }}</span>
                              </el-form-item>
                              <el-form-item label="详细地址">
                                <span>{{ props.row.address}}</span>
                              </el-form-item>
                              <el-form-item label="学校经度">
                                <span>{{ props.row.lon }}</span>
                              </el-form-item>
                              <el-form-item label="学校纬度">
                                <span>{{ props.row.lat }}</span>
                              </el-form-item>
                            </el-form>
                          </template>
                        </el-table-column>
                        <el-table-column
                          label="学校ID"
                          prop="schoolId">
                        </el-table-column>
                        <el-table-column
                          label="学校名称"
                          prop="schoolFullName">
                        </el-table-column>
                        <el-table-column
                          label="学校联系人"
                          prop="contactName">
                        </el-table-column>
                        <el-table-column
                          label="联系人电话"
                          prop="contactPhone">
                        </el-table-column>
                        <el-table-column
                          label="状态"
                          prop="schoolStateName">
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
        <el-col :span="4" class="main-right" style="background-color: #FFF">
            <iframe src="./schoolOperation" width="100%" height="95%" frameborder="0"></iframe>
        </el-col>
    </el-row>
    </div>
    <script>
    var frame = AppFrame({
        data:{
            fullScreenLoading: true,
            schoolList: [],
            selectZoneList:[],
            zoneList: [],
            zoneIdList:[],
            currentPage:1,
            total: 1,
            pageSize:20,
            page: 1,
            changeData:'',
            tableHeight:'',
            keytype:'schoolName',
            keyword:'',
            listLoading: false,
        },
        methods: {
            handleCurrentChange:function(val) {
                this.page = val;
                var pageSize = this.pageSize;
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getSchoolList(this.page,pageSize,keytype,keyword);
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
                this.getSchoolList(this.currentPage,this.pageSize,keytype,keyword);
            },

            addSchool:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                if (<?php echo CONFIG("school_auto_audit")?>) {
                                    that.msgSuccess('新增学校提交审核中');
                                }else{
                                    that.msgSuccess('添加完成');
                                }
                                that.getSchoolList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/school/addSchoolList'),'添加学校',buttonList);
            },

            updContactList:function(){
                var that = this;
                var frameId = '';
                if (this.changeData.length != 1) {
                    that.msgError('请选择一行记录');
                    return ;
                }
                var schoolId = this.changeData[0].schoolId;
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('操作完成');
                                that.getSchoolList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/school/updContactList?schoolId='+schoolId),'调整学校联系人',buttonList);
            },

            updateSchool:function(){
                var that = this;
                var frameId = '';
                if (this.changeData.length != 1) {
                    that.msgError('请选择一行记录');
                    return ;
                }
                var schoolId = this.changeData[0].schoolId;
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('操作完成');
                                that.getSchoolList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/school/addSchoolList?schoolId='+schoolId),'编辑学校信息',buttonList);
            },

            updDistrictList:function(){
                var that = this;
                var frameId = '';
                if (this.changeData.length != 1) {
                    that.msgError('请选择一行记录');
                    return ;
                }
                var schoolId = this.changeData[0].schoolId;
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('操作完成');
                                that.getSchoolList();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/school/updDistrictList?schoolId='+schoolId),'调整学校地址',buttonList);
            },

            getSchoolList:function(page,pageSize,keytype,keyword) {
                var that = this;
                this.listLoading = true;
                var keytype = keytype || this.keytype;
                var keyword = keyword || this.keyword;
                var page = page || this.page;
                var pageSize = pageSize || this.pageSize;
                var zoneIdList = this.zoneIdList;
                AjaxLoader.post(AppCommon.getUrl('/school/getSchoolList'),{'page':page,'pageSize':pageSize,'keytype':keytype,'keyword':keyword,'zoneIdList':zoneIdList},function(data){
                    that.schoolList = data['list'];
                    that.total = data['total'];
                    that.listLoading = false;
                });
            },
            getZoneList:function() {
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/zone/getZoneSelectList'),{},function(data){
                    that.zoneList = data;
                });
            },
            delSchool:function(schoolId,name){
                var that = this;
                this.$confirm('确认删除【'+name+'】吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/school/delSchool'),{'schoolId':schoolId},function(data){
                    that.msgSuccess('删除成功');
                    that.getSchoollIst();
                });
            }).catch(() => {
                });
            },
            addAccess:function(){
                var that = this;
                var frameId = '';
                if (this.changeData.length != 1) {
                    that.msgError('请选择一行记录');
                    return ;
                }
                var schoolId = this.changeData[0].schoolId;
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                AppDialog.close(frameId);
                                that.msgSuccess('设置完成');
                                that.getCardList();
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
                AjaxLoader.post(AppCommon.getUrl('/school/getAccess'),{'schoolId':schoolId},function(data){
                    frameId = AppDialog.openFrame(AppCommon.getUrl('/access/addAccess?accessId='+data.accessId),'学校['+data.schoolName+']设置通话策略',buttonList);
                });
            },
            zoneChange() {
                this.zoneIdList = this.selectZoneList;
            },

        },
        mounted:function(){
            //this.getZoneList();
            this.getSchoolList();
        },

    })
</script>
