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
                              <el-option label="线路前缀" value="linePrefix"></el-option>
                              <el-option label="线路名称" value="lineName"></el-option>
                              <el-option label="线路IP" value="lineIP"></el-option>
                            </el-select>
                            <el-button slot="append" icon="el-icon-search" size="small" @click="getLine()"></el-button>
                          </el-input>
                        </el-button-group>
                        <div class="more-search" @click="searchCard()">高级搜索 <i :class="searchShow?'el-icon-arrow-up':'el-icon-arrow-down'"></i></div>
                    </div>
                    <div class="fr">
                        <el-button type="primary" plain icon="el-icon-plus" size="small" @click="addLine()">新增</el-button>
                        <el-dropdown>
                          <el-button type="warning" size="small" plain>
                            更多操作<i class="el-icon-arrow-down el-icon--right"></i>
                          </el-button>
                          <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native="updateLine">编辑</el-dropdown-item>
                            <el-dropdown-item @click.native="activeLine">启用线路</el-dropdown-item>
                            <el-dropdown-item @click.native="closeLine">禁用线路</el-dropdown-item>
<!--                            <el-dropdown-item @click.native="delLine">删除</el-dropdown-item>-->
                          </el-dropdown-menu>
                        </el-dropdown>

                    </div>
                </el-col>

                <!--       高级筛选         -->
                <div class="search-content" :class="searchShow?'show':'hide'">
                    <div class="row">
                        <div class="col-33">
                            <div>
                                <span class="search-title">套餐</span>
                                <el-select v-model="searchData.planId" placeholder="请选择套餐" size="small">
                                    <el-option
                                            v-for="item in planList"
                                            :key="item.planId"
                                            :label="item.planName"
                                            :value="item.planId">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-100">
                            <el-button type="primary" size="small" class="fr margin-r-10" icon="el-icon-search" @click="getLine()">搜索</el-button>
                        </div>
                    </div>
                </div>

                <!--列表-->
                <div class="content-table">
                    <el-table ref="multipleTable" :data="lineList" highlight-current-row  v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit @selection-change="handleSelectionChange" @row-click="currentRowChange">
                        <el-table-column
                              type="selection"
                              width="55">
                        </el-table-column>
                        <el-table-column type="expand">
                          <template slot-scope="props">
                            <el-form label-position="left" inline class="content-table-expand">
                              <el-form-item label="线路ID">
                                <span>{{ props.row.lineId }}</span>
                              </el-form-item>
                              <el-form-item label="线路号码">
                                <span>{{ props.row.lineNumber }}</span>
                              </el-form-item>
                              <el-form-item label="备注">
                                <span>{{ props.row.content }}</span>
                              </el-form-item>
                            </el-form>
                          </template>
                        </el-table-column>
                        <el-table-column label="线路名称" prop="lineName">
                        </el-table-column>
                        <el-table-column label="线路前缀" prop="linePrefix">
                        </el-table-column>
                        <el-table-column label="线路IP" prop="lineIP">
                        </el-table-column>
                        <el-table-column label="标准资费/分钟" prop="baseFee">
                        </el-table-column>
                        <el-table-column label="剩余通话时间" prop="leftMins">
                        </el-table-column>
                        <el-table-column label="套餐" prop="planName">
                        </el-table-column>
                        <el-table-column label="线路状态" prop="lineStateName">
                            <template scope="scope">
                                <span v-if="scope.row.state == '1' " style="color: #4191EC;">{{scope.row.lineStateName}}</span>
                                <span v-if="scope.row.state == '-1' " style="color: #FF4948;">{{scope.row.lineStateName}}</span>
                                <span v-if="scope.row.state == '0' " style="color: #E6A23C;">{{scope.row.lineStateName}}</span>
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
        <el-col :span="4" class="main-right" style="background-color: #FFF">
            <iframe src="./lineOperation" width="100%" height="95%" frameborder="0"></iframe>
        </el-col>
    </el-row>
    </div>
    <script>
    var frame = AppFrame({
        data:{
            changeData: '',
            fullScreenLoading: true,
            lineList: [],
            currentPage:1,
            total: 1,
            pageSize:20,
            page: 1,
            tableHeight:'',
            keytype:'',
            keyword:'',
            listLoading: false,
            searchData:{
                planId:''
            },
            searchShow:false,
            planList:[]
        },
        methods: {
            handleCurrentChange:function(val) {
                this.page = val;
                var pageSize = this.pageSize;
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getLineList(this.page,pageSize,keytype,keyword);
            },

            handleSizeChange:function(val) {
                this.currentPage = 1;
                this.pageSize = val;
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getLineList(this.currentPage,this.pageSize,keytype,keyword);
            },

            currentRowChange(row, column, event) {
                this.$refs.multipleTable.toggleRowSelection(row);
            },

            handleSelectionChange(val) {
                this.changeData = val;
                console.log(this.changeData);
            },

            getLine:function(){
                var keyword = this.keyword;
                var keytype = this.keytype;
                var page = this.page;
                this.getLineList(page,this.pageSize,keytype,keyword);
            },

            addLine:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('添加完成');
                                that.getLine();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/line/addLineDialog'),'添加线路',buttonList);
            },

            updateLine:function(){
                var changeData = this.changeData;
                if(changeData.length>1){
                    this.msgError('编辑不支持多选');
                    return;
                }
                if(changeData.length<1){
                    this.msgError('未勾选操作线路');
                    return;
                }
                var lineId = changeData[0].lineId;
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('更新完成');
                                that.getLine();
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
                frameId = AppDialog.openFrame(AppCommon.getUrl('/line/addLineDialog?lineId='+lineId),'编辑线路',buttonList);
            },

            getLineList:function(page,pageSize,keytype,keyword) {
                var that = this;
                this.listLoading = true;
                var keytype = keytype || this.keytype;
                var keyword = keyword || this.keyword;
                var page = page || this.page;
                var pageSize = pageSize || this.pageSize;
                var searchData = this.searchData;
                var line = {};
                line.keytype = keytype;
                line.keyword = keyword;
                console.log(line);
                AjaxLoader.post(AppCommon.getUrl('/line/getLineList'),{'line':line,'page':page,'pageSize':pageSize,'searchData':searchData},function(data){
                    that.lineList = data['list'];
                    that.total = data['total'];
                    that.listLoading = false;
                });
            },

            delLine:function(){
                var changeData = this.changeData;
                if(changeData.length>1){
                    this.msgError('删除暂不支持多选');
                    return;
                }
                if(changeData.length<1){
                    this.msgError('未勾选操作线路');
                    return;
                }
                var that = this;
                this.$confirm('确认删除已勾选线路吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/line/delLine'),{'lineList':changeData},function(data){
                    that.msgSuccess('删除成功');
                    that.getLine();
                });
            }).catch(() => {
                });
            },

            activeLine:function(){
                var changeData = this.changeData;
                if(changeData.length<1){
                    this.msgError('未勾选操作线路');
                    return;
                }
                var that = this;
                this.$confirm('确认激活已勾选线路吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/line/activeLine'),{'lineList':changeData},function(data){
                    that.msgSuccess('操作成功');
                    that.getLine();
                });
            }).catch(() => {
                });
            },

            closeLine:function(){
                var changeData = this.changeData;
                if(changeData.length<1){
                    this.msgError('未勾选操作线路');
                    return;
                }
                var that = this;
                this.$confirm('确认禁用已勾选线路吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    AjaxLoader.post(AppCommon.getUrl('/line/closeLine'),{'lineList':changeData},function(data){
                    that.msgSuccess('操作成功');
                    that.getLine();
                });
            }).catch(() => {
                });
            },

            getPlanList:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/plan/getSelectPlanList'),{},function(data){
                    data.unshift({'planId':'','planName':'全部'});
                    that.planList = data;
                    AppCommon.run(callback,data);
                });
            },

            searchCard:function(){
                this.keyword = '';
                !this.searchShow ? this.searchShow = true : this.searchShow = false;
            },


        },
        mounted:function(){
            this.getLine();
            this.getPlanList();
        },

    })
</script>
