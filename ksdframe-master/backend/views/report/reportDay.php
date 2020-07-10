<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <el-row class="container main-content" >
        <el-col :span="24" class="main">            
            <section class="content-container fix-content">
                <!--工具条-->
                <el-col :span="24" class="toolbar">
                    <el-form :inline="true">
                        <el-form-item>
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
                                class="search-input"
                            >
                            </el-cascader>
                        </el-form-item>
                        <el-form-item>
                        <span style="font-size: 12px;">学校</span>
                            <el-select v-model="schoolId" placeholder="请选择学校" size="small">
                                <el-option
                                        v-for="item in schoolList"
                                        :key="item.schoolId"
                                        :label="item.schoolName"
                                        :value="item.schoolId">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                        <span style="font-size: 12px;">日期</span>
                            <el-date-picker
                                    v-model="dateTime"
                                    type="datetimerange"
                                    value-format="yyyy-MM-dd HH:mm:ss"
                                    align="right"
                                    unlink-panels
                                    range-separator="至"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期"
                                    :picker-options="pickerOptions"
                                    @change="dateTimeChange"
                                    size="small">
                            </el-date-picker>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="getReportDayList()" size="small">
                                <i class="el-icon-search" aria-hidden="true"></i> 搜索
                            </el-button>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="success" id="search" v-on:click="exportReportDay" size="small">
                                <i class="el-icon-download" aria-hidden="true"></i> 导出
                            </el-button>
                        </el-form-item>
                    </el-form>
                </el-col>

                <!--列表-->
                <div class="content-table">
                    <el-table :data="reportDayList" highlight-current-row v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit>
                        <el-table-column prop="day" label="日期" width="100">
                        </el-table-column>
                        <el-table-column prop="schoolName" label="学校名称" width="150">
                        </el-table-column>
                        <el-table-column prop="cardCount" label="当日卡总和">
                        </el-table-column>
                        <el-table-column prop="cardDayCount" label="今日开卡数量" width="100">
                        </el-table-column>
                        <el-table-column prop="cardTalkCount" label="当日通话的卡数量" width="130">
                        </el-table-column>
                        <el-table-column prop="cardChargeCount" label="充值卡数量">
                        </el-table-column>
                        <el-table-column prop="cardChargeTotal" label="今日充值数量" width="100">
                        </el-table-column>
                        <el-table-column prop="cardLeftMinis" label="卡剩余通话分钟数" width="120">
                        </el-table-column>
                        <el-table-column prop="cardMoneyTotal" label="卡剩余账户余额" width="120">
                        </el-table-column>
                        <el-table-column prop="cardDeficitMoneyTotal" label="卡欠费总和">
                        </el-table-column>
                        <el-table-column prop="studentCount" label="学生总数">
                        </el-table-column>
                        <el-table-column prop="userCount" label="用户总数">
                        </el-table-column>
                        <el-table-column prop="userDayCount" label="当日新增用户数" width="120">
                        </el-table-column>
                        <el-table-column prop="userLoginCount" label="登录用户数">
                        </el-table-column>
                        <el-table-column prop="userChargeCount" label="充值用户数量" width="100">
                        </el-table-column>
                        <el-table-column prop="userChargeTotal" label="用户充值金额" width="100">
                        </el-table-column>
                        <el-table-column prop="deviceCount" label="设备总数">
                        </el-table-column>
                        <el-table-column prop="deviceDayCount" label="新增设备总数" width="100">
                        </el-table-column>
                        <el-table-column prop="deviceTalkCount" label="通话设备总数" width="100">
                        </el-table-column>
                        <el-table-column prop="talkCountTotal" label="通话总数量">
                        </el-table-column>
                        <el-table-column prop="talkConnectCount" label="接通通话数量" width="100">
                        </el-table-column>
                        <el-table-column prop="talkEmptyCount" label="未接通通话数量" width="120">
                        </el-table-column>
                        <el-table-column prop="talkFeeTotal" label="消费金额">
                        </el-table-column>
                        <el-table-column prop="talkMinsTotal" label="消费分钟数">
                        </el-table-column>
                        <el-table-column prop="wxChargeMoney" label="微信充值金额" width="150">
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
            pickerOptions: {
                shortcuts: [{
                    text: '最近一天',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24);
                        picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: '最近一周',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                        picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: '最近一个月',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                        picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: '最近三个月',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                        picker.$emit('pick', [start, end]);
                    }
                }]
            },
            dateTime:'',
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
            schoolId:'',
            schoolList:[],
            selectZoneList:[],
            zoneList:[],

            listLoading: false,
        },
        methods: {
            handleCurrentChange:function(val) {
                this.page = val;
                var pageSize = this.pageSize;
                this.getReportDayList(this.page,pageSize);
            },

            handleSizeChange:function(val) {
                this.currentPage = 1;
                this.pageSize = val;
                this.getReportDayList(this.currentPage,this.pageSize);
            },

            dateTimeChange:function(val) {
                console.log(val);
                this.dateTime = val || '';
            },

            getReportDayList:function(page,pageSize) {

                var that = this;
                this.listLoading = true;
                var reportDay = {};
                AjaxLoader.post(AppCommon.getUrl('/report/getReportDayList'),{'reportDay':reportDay,'page':this.page,'pageSize':this.pageSize,'dateTime':this.dateTime,'zoneIdList':this.selectZoneList,'schoolId':this.schoolId},function(data){
                    that.reportDayList = data['list'];
                    that.total = data['total'];
                    that.listLoading = false;
                });
            },

            getSchoolList:function(callback){
                var that = this;
                var keytype = "schoolName";
                var keyword = "";
                var page = 0;
                var pageSize = 2000;
                var zoneIdList = this.selectZoneList;
                AjaxLoader.post(AppCommon.getUrl('/school/getSchoolList'),{'page':page,'pageSize':pageSize,'keytype':keytype,'keyword':keyword,'zoneIdList':zoneIdList},function(data){
                    that.schoolList = data['list'];
                    AppCommon.run(callback,data);
                });
            },
            zoneChange:function(){
                this.schoolId='';
                this.getSchoolList();
            },
            getZoneList:function() {
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/zone/getZoneSelectList'),{},function(data){
                    that.zoneList = data;

                });

            },
            exportReportDay:function () {
                AppCommon.goUrl(AppCommon.getUrl('/report/exportReportDay?'+
                    'dateTime='+this.dateTime+
                    '&schoolId='+this.schoolId+
                    '&zoneIdList='+this.selectZoneList
                ));
            },

        },
        mounted:function(){
            this.getReportDayList();
            this.getZoneList();
            this.getSchoolList();
        },

    })
</script>
