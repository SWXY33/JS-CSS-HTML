<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <el-row class="container main-content" >
        <el-col :span="24" class="main">            
            <section class="content-container fix-content">
                <!--工具条-->
                <el-col :span="24" class="toolbar">
                    <div class="fr top-search">
<!--                        <el-button-group>-->
<!--                          <el-input placeholder="请输入查询内容" v-model="keyword" class="input-with-select" size="small">-->
<!--                            <el-select slot="prepend" placeholder="请选择" size="small" v-model="keytype">-->
<!--                              <el-option label="卡号" value="cardSn"></el-option>-->
<!--                            </el-select>-->
<!--                            <el-button slot="append" icon="el-icon-search" size="small" @click="getReportDayList()"></el-button>-->
<!--                          </el-input>-->
<!--                        </el-button-group>-->
                    </div>
                </el-col>

                <!--列表-->
                <div class="content-table">
                    <el-table :data="reportDayList" highlight-current-row v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit>
                        <el-table-column
                          type="selection"
                          width="55">
                        </el-table-column>
                        <el-table-column type="index" label="序号">
                        </el-table-column>
                        <el-table-column prop="day" label="日期">
                        </el-table-column>
                        <el-table-column prop="attendanceStudentTodayCount" label="当日出勤学生人数/人">
                        </el-table-column>
                        <el-table-column prop="attendanceStudentCount" label="当日应考勤人数/人">
                        </el-table-column>
                        <el-table-column prop="attendanceTodayPer" label="当日考勤率/%">
                        </el-table-column>
<!--                        <el-table-column label="操作" width="140" fixed="right">-->
<!--                            <template scope="scope">-->
<!--                                <el-button type="text" size="small" @click="updateIcCard(scope.row.icCardId)">编辑</el-button>-->
<!--                                <el-dropdown>-->
<!--                                <span class="el-dropdown-link">-->
<!--                                    更多操作<i class="el-icon-arrow-down el-icon--right"></i>-->
<!--                                </span>-->
<!--                                    <el-dropdown-menu slot="dropdown">-->
<!--                                        <el-dropdown-item >-->
<!--                                            <div @click="updateIcCard(scope.row.icCardId)">编辑</div>-->
<!--                                        </el-dropdown-item>-->
<!--                                        <el-dropdown-item>-->
<!--                                            <div @click="delIcCard(scope.row.icCardId,scope.row.cardSn)">删除</div>-->
<!--                                        </el-dropdown-item>-->
<!--                                    </el-dropdown-menu>-->
<!--                                </el-dropdown>-->
<!--                            </template>-->
<!--                        </el-table-column>-->
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
            nouse: true,
            reportDayList: [],
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
                this.getReportDayList(this.page,pageSize,keytype,keyword);
            },

            handleSizeChange:function(val) {
                this.currentPage = 1;
                this.pageSize = val;
                var keytype = this.keytype;
                var keyword = this.keyword;
                this.getReportDayList(this.currentPage,this.pageSize,keytype,keyword);
            },
            getReportDayList:function(page,pageSize,keytype,keyword) {

                var that = this;
                this.listLoading = true;
                var keytype = keytype || this.keytype;
                var keyword = keyword || this.keyword;
                var reportDay = {};
                reportDay.keytype = keytype;
                reportDay.keyword = keyword;
                reportDay.page = page;
                reportDay.pageSize = pageSize;
                AjaxLoader.post(AppCommon.getUrl('/reportDay/getReportDay'),{'reportDay':reportDay},function(data){
                    that.reportDayList = data['list'];
                    that.total = data['total'];
                    that.listLoading = false;
                });
            },

        },
        mounted:function(){
            this.getReportDayList();
        },

    })
</script>
