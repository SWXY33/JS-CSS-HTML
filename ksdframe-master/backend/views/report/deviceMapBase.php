<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <el-row class="container main-content report-chart" >
        <el-col :span="24" class="main">            
            <section class="content-container fix-content">
                <div style="display: inline-block;width: 100%">
                    <el-row :gutter="24" class="el-fix" style="padding: 10px 0 20px 0;">
                        <el-col :span="12" style="padding: 0;">
                            <el-card  :body-style="{ padding: '10px' }" shadow="never">
                                  <iframe src="/report/deviceMapMini" scrolling="auto" frameborder="0" height="367px" width="100%"></iframe>
                                  <div style="text-align: right;">
                                       <el-button type="success" size="mini" @click="goDeviceMap">查看详细话机地图>></el-button>
                                  </div>
                            </el-card>
                        </el-col>
                        <el-col :span="12" style="padding: 0;">
                            <el-card :body-style="{ padding: '10px' }" shadow="never">
                                  <el-table :data="schoolDeviceData" highlight-current-row v-loading="listLoading"  style="width: 100%;margin-bottom: 50px;" :max-height=tableHeight fit height="350">
                                    <el-table-column prop="schoolName" label="学校">
                                    </el-table-column>
                                    <el-table-column prop="deviceCount" label="设备数量">
                                    </el-table-column>
                                    <el-table-column label="使用率">
                                        <template scope="scope">
                                            <span>100%</span>
                                      </template>
                                    </el-table-column>
                                </el-table>
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
                            <el-table-column prop="day" label="日期">
                            </el-table-column>
                            <el-table-column prop="deviceTalkCount" label="当日使用话机数量">
                            </el-table-column>
                            <el-table-column prop="deviceCount" label="当日总话机数量">
                            </el-table-column>
                            <el-table-column label="当日话机使用率">
                              <template scope="scope">
                                    <span>{{(scope.row.deviceTalkCount/scope.row.deviceCount*100).toFixed(2)}}%</span>
                              </template>
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
            schoolDeviceData:[],
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
                },function(data){
                    that.reportList = data['list'];
                    that.listLoading = false;
                    // that.talkChart(data);
                    // that.rightChart(data);
                });
            },
            zoneChange() {
                this.zoneIdList = this.selectZoneList;
            },
            getZoneList:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/zone/getZoneSelectList'),{},function(data){
                    that.zoneList = data;
                });
            },
            getSchoolList:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/school/getSchoolList'),{},function(data){
                    that.schoolList = data['list'];
                });
            },
            getSchoolDeviceData:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/report/getSchoolDeviceData'),{},function(data){
                    that.schoolDeviceData = data;
                });
            },
            dateTimeChange:function(val) {
                this.dateTime = val || '';
            },
            goDeviceMap:function(){
                window.open("/report/deviceMap");
            }

        },
        mounted:function(){
            this.getZoneList();
            this.getSchoolList();
            this.getDataList(); 
            this.getSchoolDeviceData(); 
        },

    })
</script>
