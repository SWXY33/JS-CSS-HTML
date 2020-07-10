<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <el-row class="container main-content" >
        <el-col :span="24" class="main">            
            <section class="content-container fix-content">
                <!--工具条-->
                <el-col :span="24" class="toolbar">
                    <div class="fl top-search">
                        <el-button-group>
                          <el-input placeholder="请输入查询内容" v-model="keyword" class="input-with-select" size="small">
                            <el-select slot="prepend" placeholder="请选择" size="small" v-model="keytype">
                              <el-option label="卡号" value="cardNumber"></el-option>
                            </el-select>
                            <el-button slot="append" icon="el-icon-search" size="small" @click="getChargeLogList()"></el-button>
                          </el-input>
                        </el-button-group>
                        <div class="more-search" @click="searchCard()">高级搜索 <i :class="searchShow?'el-icon-arrow-up':'el-icon-arrow-down'"></i></div>
                    </div>
                    <div class="fr">
                        <el-button type="success" id="search" v-on:click="exportChargeLogList" size="small" style="margin-left: 10px; margin-top: 0px;">
                            <i class="el-icon-download" aria-hidden="true"></i> 导出
                        </el-button>
                    </div>
                </el-col>

                <!--       高级筛选         -->
                <div class="search-content" :class="searchShow?'show':'hide'">
                    <div class="row">
                        <div class="col-50">
                            <div >
                                <span class="search-title">区域</span>
                                <el-cascader
                                    placeholder="请选择地区"
                                    v-model="searchData.selectZoneList"
                                    @change="zoneChange"
                                    :options="zoneList"
                                    size="small"
                                    filterable
                                    :props="{ checkStrictly: true }"
                                    clearable
                                    class="search-input"
                                >
                                </el-cascader>
                            </div>
                            <div>
                                <span class="search-title" >日期</span>
                                <el-date-picker
                                    v-model="searchData.dateTime"
                                    type="datetimerange"
                                    value-format="yyyy-MM-dd HH:mm:ss"
                                    unlink-panels
                                    range-separator="至"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期"
                                    :picker-options="pickerOptions"
                                    @change="dateTimeChange"
                                    size="small"
                                    class="date-time"
                                >
                                </el-date-picker>
                            </div>

                        </div>
                        <div class="col-50">
                            <div>
                                <span class="search-title">学校</span>
                                <el-select v-model="searchData.schoolId" placeholder="请选择学校" size="small">
                                    <el-option
                                        v-for="item in schoolList"
                                        :key="item.schoolId"
                                        :label="item.schoolName"
                                        :value="item.schoolId">
                                    </el-option>
                                </el-select>
                            </div>
                            <div>
                                <span class="search-title">充值方式</span>
                                <el-select v-model="searchData.type" placeholder="充值方式" size="small">
                                    <el-option value="" label="全部"></el-option>
                                    <el-option value="1" label="手动"></el-option>
                                    <el-option value="2" label="微信"></el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-100">
                            <el-button type="primary" size="small" class="fr margin-r-10" icon="el-icon-search" @click="getChargeLogList()">搜索</el-button>
                        </div>
                    </div>
                </div>

                <!--列表-->
                <div class="content-table">
                    <el-table :data="chargeList" highlight-current-row v-loading="listLoading"  style="width: 100%;" :max-height=tableHeight fit>
                        <el-table-column prop="schoolName" label="学校">
                        </el-table-column>
                        <el-table-column prop="studentName" label="姓名">
                        </el-table-column>
                        <el-table-column prop="cardNumber" label="卡号">
                        </el-table-column>
                        <el-table-column prop="money" label="充值金额">
                        </el-table-column>
                        <el-table-column prop="typeName" label="充值类型">
                        </el-table-column>
                        <el-table-column prop="stateName" label="充值状态">
                        </el-table-column>
                        <el-table-column prop="chargeDate" label="充值时间">
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
            chargeList: [],
            currentPage:1,
            total: 1,
            pageSize:20,
            page: 1,
            tableHeight:'',
            keytype:'cardNumber',
            keyword:'',
            searchData:{
                schoolId:'',
                type:'',
                selectZoneList:[],
                dateTime:''
            },
            schoolList:[],
            searchShow:false,
            zoneList:[],
            listLoading: false,
        },
        methods: {
            handleCurrentChange:function(val) {
                this.page = val;
                var pageSize = this.pageSize;
                this.getChargeLogList(this.page,pageSize);
            },

            handleSizeChange:function(val) {
                this.currentPage = 1;
                this.pageSize = val;
                this.getChargeLogList(this.currentPage,this.pageSize);
            },

            dateTimeChange:function(val) {
                // console.log(val);
                this.dateTime = val || '';
            },

            getChargeLogList:function(page,pageSize) {
                var that = this;
                this.listLoading = true;
                var page = page || this.page;
                var pageSize = pageSize || this.pageSize;
                var charge = {};
                charge.keytype = this.keytype;
                charge.keyword = this.keyword;
                AjaxLoader.post(AppCommon.getUrl('/report/getChargeLogList'),{'charge':charge,'page':page,'pageSize':pageSize,'searchData':this.searchData},function(data){
                    that.chargeList = data['list'];
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
                var zoneIdList = this.searchData.selectZoneList;
                AjaxLoader.post(AppCommon.getUrl('/school/getSchoolList'),{'page':page,'pageSize':pageSize,'keytype':keytype,'keyword':keyword,'zoneIdList':zoneIdList},function(data){
                    that.schoolList = data['list'];
                    AppCommon.run(callback,data);
                });
            },
            zoneChange:function(){
                this.searchData.schoolId='';
                this.getSchoolList();
            },
            getZoneList:function() {
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/zone/getZoneSelectList'),{},function(data){
                    that.zoneList = data;

                });

            },
            exportChargeLogList:function () {
                // console.log(this);return false;

                AppCommon.goUrl(AppCommon.getUrl('/report/exportChargeLogList?'+
                    'dateTime='+this.searchData.dateTime+
                    '&keytype='+this.keytype+
                    '&keyword='+this.keyword+
                    '&schoolId='+this.searchData.schoolId+
                    '&type='+this.searchData.type+
                    '&selectZoneList='+this.searchData.selectZoneList
                ));
            },

            searchCard:function(){
                this.keyword = '';
                !this.searchShow ? this.searchShow = true : this.searchShow = false;
            },

        },
        mounted:function(){
            this.getChargeLogList();
            this.getZoneList();
            this.getSchoolList();
        },

    })
</script>
