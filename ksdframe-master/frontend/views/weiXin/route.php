<div id="app">
    <div class="app-container with-tabbar" style="width: 100%; height: 100%;background-color: #F6F6F6;">
        <div class="app-content">


            <div class="route-car-info-box shaow-pink">
                <div class="clear">
                    <div class="attendance-car-info-title fl">运行时间:</div>
                    <div class="attendance-car-info-content fl">2019-08-30 10:51</div>
                </div>
                <div class="clear">
                    <div class="attendance-car-info-title fl">车牌号:</div>
                    <div class="attendance-car-info-content fl">{{carPlat}}</div>
                </div>
                <div class="clear">
                    <div class="attendance-car-info-title fl">当班司机:</div>
                    <div class="attendance-car-info-content fl">{{driverName}}&nbsp;&nbsp;{{driverMoile}}</div>
                </div>
                <div class="clear">
                    <div class="attendance-car-info-title fl">随车老师:</div>
                    <div class="attendance-car-info-content fl">{{staff}}&nbsp;&nbsp;{{staffMobile}}</div>
                </div>
            </div>

            <div class="route-info-box shaow-pink">

                <div v-for="(item,index) in routeStationList">
                    <div class="route-info-item" v-if="index == '0'" style="height: 1px;">
                        <div class="site-state-start"></div>
                        <div class="site-name">
                            {{item.stationName}}
                            <span class="site-time">07:20</span>
                        </div>
                        <div class="site-desc" v-if="index <= currentStationIndex">已上车</div>
                    </div>
                    <div class="route-info-item" v-if="index < currentStationIndex && index != '0'">
                        <div class="site-state-pass"></div>
                        <div class="site-name">
                            {{item.stationName}}
                            <span class="site-time">07:59</span>
                        </div>
                        <div class="site-desc" v-if="index <= currentStationIndex">已上车</div>
                    </div>
                    <div class="route-info-item" v-if="item.routeStationId == currentStationId">
                        <div class="site-state-current"></div>
                        <div class="site-name color-green">
                            {{item.stationName}}
                            <span class="site-time">07:59</span>
                        </div>
                        <div class="site-desc" v-if="item.routeStationId == currentStationId">校车正在此处接送学生</div>
                    </div>
                    <div class="route-info-item border-not-pass" v-if="index > currentStationIndex && item.routeStationId != currentStationId && index != stationCount">
                        <div class="site-state-not-pass"></div>
                        <div class="site-name">
                            {{item.stationName}}
                            <span class="site-time"></span>
                        </div>
                        <div class="site-desc"></div>
                    </div>
                    <div class="route-info-item border-not-pass" v-if="index == stationCount">
                        <div class="site-state-not-pass"></div>
                        <div class="site-name">
                            目的地:{{item.stationName}}
                            <span class="site-time">08:30</span>
                        </div>
<!--                        <div class="site-desc">预计到达时间 08:30</div>-->
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<script>

    var frame = AppFrame({
        data:{
            routeStationList:[],
            currentStationId:'',
            startStationName:'',
            endStationName:'',
            parentMobile:'',
            driverName:'',
            driverMoile:'',
            carPlat:'',
            staff:'',
            staffMobile:'',
            currentStationIndex:0,
            current:0,
            stationCount:0
        },
        methods: {
            handleClick: function() {
                this.msg("简单普通提示");
                this.msgError("错误提示");
                this.msgSuccess("成功提示");
            },
            getStudentState:function(){
                var that = this;
                var parentMobile = this.parentMobile;
                if(!parentMobile){
                    that.msg("信息错误");
                    return;
                }
                AjaxLoader.post(AppCommon.getUrl('/weiXin/checkStudentState?parentMobile='+parentMobile),{},function(res){
                    if(res){
                        that.driverName = res.driver;
                        that.driverMoile = res.driverMoile;
                        that.carPlat = res.carPlat;
                        that.staff = res.staff;
                        that.staffMobile = res.staffMobile;
                        that.currentStationId = res.routeStationId;
                        if(res.routeType != 1){
                            that.routeStationList = res.routeInfo.gotoRouteStation;
                            that.stationCount = res.routeInfo.gotoRouteStation.length-1;
                            var current = 0;
                            for(var i=0;i<res.routeInfo.gotoRouteStation.length;i++){
                                if(res.routeInfo.gotoRouteStation[i].routeStationId== res.routeInfo.routeStationId){
                                    current = i;
                                }
                            }
                            that.currentStationIndex = current;
                        }else{
                            that.routeStationList = res.routeInfo.leaveRouteStation;
                            that.stationCount = res.routeInfo.leaveRouteStation.length-1;
                            var current = 0;
                            for(var i=0;i<res.routeInfo.leaveRouteStation.length;i++){
                                if(res.routeInfo.leaveRouteStation[i].routeStationId== res.routeInfo.routeStationId){
                                    current = i;
                                }
                            }
                            that.currentStationIndex = current;
                        }

                    }
                });
            }
        },
        mounted:function(){
            this.parentMobile = AppCommon.getUrlParam('parentMobile');
            this.getStudentState();
        }
    });

</script>