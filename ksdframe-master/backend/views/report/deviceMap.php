<style>
    html, body, #container {
        height: 100%;
        width: 100%;
    }

    .input-card .btn {
        margin-right: 1.2rem;
        width: 9rem;
    }

    .input-card .btn:last-child {
        margin-right: 0;
    }
    .content-window-card {
        position: relative;
        box-shadow: none;
        bottom: 0;
        left: 0;
        width: auto;
        padding: 0;
    }

    .content-window-card p {
        height: 2rem;
    }

    .custom-info {
        border: solid 1px silver;
    }

    div.info-top {
        position: relative;
        background: none repeat scroll 0 0 #F9F9F9;
        border-bottom: 1px solid #CCC;
        border-radius: 5px 5px 0 0;
    }

    div.info-top div {
        display: inline-block;
        color: #333333;
        font-size: 14px;
        font-weight: bold;
        line-height: 31px;
        padding: 0 10px;
    }

    div.info-top img {
        position: absolute;
        top: 10px;
        right: 10px;
        transition-duration: 0.25s;
    }

    div.info-top img:hover {
        box-shadow: 0px 0px 5px #000;
    }

    div.info-middle {
        font-size: 12px;
        padding: 10px 6px;
        line-height: 20px;
    }

    div.info-bottom {
        height: 0px;
        width: 100%;
        clear: both;
        text-align: center;
    }

    div.info-bottom img {
        position: relative;
        z-index: 104;
    }

    span {
        margin-left: 5px;
        font-size: 11px;
    }

    .info-middle img {
        float: left;
        margin-right: 6px;
    }
</style>
<script src="http://webapi.amap.com/maps?v=1.4.15&key=cdd792f4b93e9d50dae5d371a4636a45"></script>
<script src="http://webapi.amap.com/loca?v=1.3.2&key=cdd792f4b93e9d50dae5d371a4636a45"></script>
<div id="app">

    <el-row class="container main-content" >
        <el-col :span="24" class="main">            
            <section class="content-container fix-content">
                <div id="container" class="map" tabindex="0"></div>
            </section>
        </el-col>
    </el-row>
    </div>
    <script>
    var frame = AppFrame({
        data:{

        },
        methods: {
        },
        mounted:function(){
            var map = new AMap.Map('container', {
                center: [118.021009, 36.253422],
                features: ['bg', 'road'],
                // mapStyle: 'amap://styles/0dc0a2f262eb17e7d75e11c653781241',
                rotation: 0,
                zoom: 8,
                viewMode: '3D',
                pitch: 0,
                skyColor: '#33216a'
            });

            var layer = new Loca.ScatterPointLayer({
                map: map
            });
            var colors = [
                '#07E8E4',
                '#AD92D1',
                '#3346BD',
                '#EBEB8D',
                '#7FC97F'
            ];

            AjaxLoader.post(AppCommon.getUrl('/report/getDeviceMapData'),{},function(data){
                layer.setData(data.deviceList, {
                    lnglat: 'lnglat'
                });

                layer.setOptions({
                    unit:'px',
                    style: {
                        radius:3,
                        color: function(obj){
                            //这里应该根据obj.value.state或话机活跃度显示颜色
                            var index = parseInt(obj.value.id%5);
                            return colors[index];
                        },
                        borderWidth: 1,
                        borderColor: '#FFFFFF',
                        opacity: 1,
                    }
                });

                // 渲染
                layer.render();
            });
        },

    })
</script>
