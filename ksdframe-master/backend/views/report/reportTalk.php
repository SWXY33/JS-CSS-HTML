<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <el-row class="container main-content report-chart" >
        <el-col :span="24" class="main">            
            <section class="content-container fix-content">
                <!--工具条-->
                <el-col :span="24" class="toolbar">
                    <div class="fl">   
                        <span style="font-size: 12px;">区域</span>
                        <el-cascader
                            placeholder="选择区域"
                            v-model="selectZoneList"
                            @change="zoneChange"
                            :options="zoneList"
                            size="small"
                            filterable
                            :props="{ checkStrictly: true }"
                            clearable
                            style="width:300px;"
                            >
                        </el-cascader>
                        <span style="font-size: 12px;">学校</span>
                        <el-select class="form-input" size="small" filterable clearable v-model="schoolId" placeholder="选择学校">
                            <el-option
                              v-for="item in schoolList"
                              :key="item.schoolId"
                              :label="item.schoolName"
                              :value="item.schoolId">
                            </el-option>
                        </el-select>
                        <span style="font-size: 12px;">日期</span>
                        <el-date-picker
                              size="small"
                              :picker-options="pickerOptions"
                              value-format="yyyy-MM-dd HH:mm:ss"
                              v-model="dateTime"
                              type="datetimerange"
                              range-separator="至"
                              start-placeholder="开始日期"
                              end-placeholder="结束日期"
                              @change="dateTimeChange"
                              class="date-time"
                              >
                        </el-date-picker>

                    </div>
                    <div class="fr">
                        <el-button type="primary" size="small" @click="getDataList"><i class="el-icon-search"></i> 搜索</el-button>
                        <!-- <el-button type="primary" size="small"><i class="el-icon-s-promotion"></i> 导出</el-button> -->
                    </div>
                </el-col>
                <div style="display: inline-block;width: 100%">
                    <el-row :gutter="24" class="el-fix" style="padding: 10px 0 20px 0;">
                        <el-col :span="12" style="padding: 0;">
                            <el-card  :body-style="{ padding: '10px' }" shadow="never">
                                  <div id="talkChart" style="width:100%;height:300px"></div>
                            </el-card>
                        </el-col>
                        <el-col :span="12" style="padding: 0;">
                            <el-card :body-style="{ padding: '10px' }" shadow="never">
                                  <div id="rightChart" style="width:100%;height:300px"></div>
                            </el-card>
                        </el-col>
                    </el-row>
                    <!--列表-->
                    <div class="content-table">
                        <el-table :data="reportList" highlight-current-row v-loading="listLoading"  style="width: 100%;margin-bottom: 50px;" :max-height=tableHeight fit>
                            <el-table-column
                              type="selection"
                              width="55">
                            </el-table-column>
                            <el-table-column type="index" label="序号">
                            </el-table-column>
                            <el-table-column prop="day" label="日期">
                            </el-table-column>
                            <el-table-column prop="schoolName" label="学校">
                            </el-table-column>
                            <el-table-column prop="talkCountTotal" label="通话总数量">
                            </el-table-column>
                            <el-table-column prop="talkConnectCount" label="接通通话数量">
                            </el-table-column>
                            <el-table-column prop="talkEmptyCount" label="未接通通话数量">
                            </el-table-column>
                             <el-table-column prop="talkFeeTotal" label="消费金额">
                            </el-table-column>
                            <el-table-column prop="talkMinsTotal" label="消费分钟数">
                            </el-table-column>
                        </el-table>
                    </div>
                </div>
            </section>
        </el-col>
    </el-row>
    </div>
    <script>
    var frame = AppFrame({
        data:{
            fullScreenLoading: true,
            schoolId:'',
            selectZoneList:[],
            reportList:[],
            listLoading:false,
            zoneList:[],
            schoolList:[],
            zoneIdList:'',
            dateTime:AppCommon.dateTimeRange(10),
            pickerOptions: {
              shortcuts: [{
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
        },
        methods: {
            talkChart:function(data){
                var talkChart = echarts.init(document.getElementById("talkChart"), 'walden');
                var colors = ['#F7BA2A', '#13ce66', '#20A0FF'];
                var option = {
                    title: {
                        text:'通话报表'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['通话总数量','接通通话数量','未接通通话数量']
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    toolbox: {
                        feature: {
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: data.chartList.day
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name:'通话总数量',
                            type:'line',
                            stack: '总量1',
                            data:data.chartList.talkCountTotal
                        },
                        {
                            name:'接通通话数量',
                            type:'line',
                            stack: '总量2',
                            data:data.chartList.talkConnectCount
                        },
                        {
                            name:'未接通通话数量',
                            type:'line',
                            stack: '总量3',
                            data:data.chartList.talkEmptyCount
                        }
                    ]
                };
                talkChart.setOption(option)
            },
            rightChart:function(data){
                var rightChart = echarts.init(document.getElementById("rightChart"), 'walden');
                var colors = ['#F7BA2A', '#13ce66', '#20A0FF'];
                var option = {
                    title: {
                        // text:'通话报表'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['消费金额','消费分钟数']
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    toolbox: {
                        feature: {
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: data.chartList.day
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name:'消费金额',
                            type:'bar',
                            stack: '金额',
                            data:data.chartList.talkFeeTotal
                        },
                        {
                            name:'消费分钟数',
                            type:'bar',
                            stack: '分钟数',
                            data:data.chartList.talkMinsTotal
                        }
                    ]
                };
                rightChart.setOption(option)

            },
            getDataList:function(){
                var that = this;
                this.listLoading = true;
                AjaxLoader.post(AppCommon.getUrl('/report/getReportChartData'),{
                    'schoolId':this.schoolId,
                    'zoneIdList':this.zoneIdList,
                    'dateTime':this.dateTime,
                    'regionIdList':this.regionIdList,
                },function(data){
                    that.reportList = data['list'];
                    that.listLoading = false;
                    that.talkChart(data);
                    that.rightChart(data);
                });
            },
            zoneChange() {
                this.schoolId='';
                this.getSchoolList();
            },
            getZoneList:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/zone/getZoneSelectList'),{},function(data){
                    that.zoneList = data;
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
            dateTimeChange:function(val) {
                this.dateTime = val || '';
            },

        },
        mounted:function(){
            this.getZoneList();
            this.getSchoolList();
            this.getDataList(); 
        },

    })
</script>
