<div id="app">
    <div class="app-container with-tabbar" style="width: 100%; height: 100%;background-color: #F6F6F6;">
        <div class="app-content">


            <div class="attendance-top-box clear">
                <div class="box-half-width fl">
                    <p class="fl font-14">学生:{{studentName}}</p>
<!--                    <p class="attendance-unbind fl">解绑</p>-->
                </div>
                <div class="box-half-width fl">
                    <p class="fl font-14" style="max-width: 80%;word-break: break-all;">{{nowTime}}</p>
                    <p class="fr font-14" style="max-width: 20%;">今天</p>
                </div>
            </div>

            <div class="arrendance-item-box">
                <p class="arrendance-item-title color-blue">上学记录</p>
                <div class="arrendance-item-main clear shaow-blue">
                    <div class="bg-blue arrendance-item-main-list-top clear">
                        <p class="fl">上/下车地点</p>
                        <p class="fl">状态</p>
                        <p class="fl">时间</p>
                    </div>
                    <div class="arrendance-item-main-list border-b clear">
                        <p class="fl">{{gotoStartRouteStation}}</p>
                        <p class="color-green fl" v-if="gotoStartStateName =='已上车'">{{gotoStartStateName}}</p>
                        <p class="fl" v-if="gotoStartStateName !='已上车'">{{gotoStartStateName}}</p>
                        <p class="fl">{{gotoStartTime}}</p>
                    </div>
                    <div class="arrendance-item-main-list clear">
                        <p class="fl">{{gotoEndRouteStation}}</p>
                        <p class="color-green fl" v-if="gotoEndStateName =='已上车'">{{gotoEndStateName}}</p>
                        <p class="fl" v-if="gotoEndStateName !='已上车'">{{gotoEndStateName}}</p>
                        <p class="fl">{{gotoEndTime}}</p>
                    </div>
                </div>
            </div>

            <div class="arrendance-item-box">
                <p class="arrendance-item-title color-orange">放学记录</p>
                <div class="arrendance-item-main clear shaow-orange">
                    <div class="bg-orange arrendance-item-main-list-top clear">
                        <p class="fl">上/下车地点</p>
                        <p class="fl">状态</p>
                        <p class="fl">时间</p>
                    </div>
                    <div class="arrendance-item-main-list border-b clear">
                        <p class="fl">{{leaveStartRouteStation}}</p>
                        <p class="color-green fl" v-if="leaveStartStateName=='已上车'">{{leaveStartStateName}}</p>
                        <p class="fl" v-if="leaveStartStateName !='已上车'">{{leaveStartStateName}}</p>
                        <p class="fl">{{leaveStartTime}}</p>
                    </div>
                    <div class="arrendance-item-main-list clear">
                        <p class="fl">{{leaveEndRouteStation}}</p>
                        <p class="color-green fl" v-if="leaveEndStateName =='已上车'">{{leaveEndStateName}}</p>
                        <p class="fl" v-if="leaveEndStateName !='已上车'">{{leaveEndStateName}}</p>
                        <p class="fl">{{leaveEndTime}}</p>
                    </div>
                </div>
            </div>

            <div class="attendance-btn-big shaow-pink" @click="getStudentRoute()">校车监控</div>

            <div class="attendance-car-info-box shaow-pink">
                <div class="clear">
                    <div class="attendance-car-info-title fl">校车状态:</div>
                    <div class="attendance-car-info-content fl">运行中</div>
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

                <div class="attendance-btn-small" @click="getStudentRoute()">实时监控</div>
            </div>

        </div>
    </div>
</div>

<script>

    var frame = AppFrame({
        data:{
            studentName:'',
            nowTime:'',
            gotoStartRouteStation:'',
            gotoEndRouteStation:'',
            gotoStartStateName:'',
            gotoEndStateName:'',
            gotoStartTime:'',
            gotoEndTime:'',
            leaveStartRouteStation:'',
            leaveEndRouteStation:'',
            leaveStartStateName:'',
            leaveEndStateName:'',
            leaveStartTime:'',
            leaveEndTime:'',
            carPlat:'',
            driverName:'',
            driverMoile:'',
            staff:'',
            staffMobile:'',


            parentMobile:'',

        },
        methods: {
            handleClick: function() {
                this.msg("简单普通提示");
                this.msgError("错误试题");
                this.msgSuccess("成功提示");
            },
            getStudentState:function(){
                var that = this;
                var parentMobile = this.parentMobile;
                if(!parentMobile){
                    return;
                }
                AjaxLoader.post(AppCommon.getUrl('/weiXin/checkStudentState?parentMobile='+parentMobile),{},function(res){
                    if(res){
                        that.studentName = res.studentName;
                        that.nowTime = res.nowTime;
                        that.gotoStartRouteStation = res.gotoStart.routeStation;
                        that.gotoEndRouteStation = res.gotoEnd.routeStation;
                        that.gotoStartStateName = res.gotoStart.stateName;
                        that.gotoEndStateName = res.gotoEnd.stateName;
                        that.gotoStartTime = res.gotoStart.time;
                        that.gotoEndTime = res.gotoEnd.time;

                        that.leaveStartRouteStation = res.leaveStart.routeStation;
                        that.leaveEndRouteStation = res.leaveEnd.routeStation;
                        that.leaveStartStateName = res.leaveStart.stateName;
                        that.leaveEndStateName = res.leaveEnd.stateName;
                        that.leaveStartTime = res.leaveStart.time;
                        that.leaveEndTime = res.leaveEnd.time;
                        that.driverName = res.driver;
                        that.driverMoile = res.driverMoile;
                        that.carPlat = res.carPlat;
                        that.staff = res.staff;
                        that.staffMobile = res.staffMobile;

                    }
                });
            },
            getStudentRoute:function(){
                parentMobile = this.parentMobile;
                AppCommon.goUrl(AppCommon.getUrl('weiXin/route'));
            }
        },
        mounted:function(){
            this.parentMobile = AppCommon.getUrlParam('parentMobile');
            this.getStudentState();
        }
    });

</script>