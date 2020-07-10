<div id="app" style="width: 800px">
    <el-row style="width:800px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" v-model="school">
                <el-form-item label="学校ID">
                    {{school.schoolId}}
                </el-form-item>
                <el-form-item label="学校名称">
                    {{school.schoolName}}
                </el-form-item>
                <el-form-item label="区域">
                    <el-select v-model="school.zoneId" placeholder="请选择该校所属区域">
                        <el-option
                                v-for="item in zoneList"
                                :key="item.zoneId"
                                :label="item.zoneName"
                                :value="item.zoneId">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="地区">
                    <el-cascader
                            v-model="school.regionValue"
                            :options="regionList"
                            @change="regionChange"
                            size="small"
                            placeholder="请选择地区"
                            filterable
                            class="region-list">
                    </el-cascader>
                </el-form-item>
                <el-form-item label="详细地址">
                    <el-input class="form-input" placeholder="请输入详细地址" v-model="school.address"></el-input>
                </el-form-item>
                <el-form-item label="学校经度">
                    <el-input class="form-input" v-model="school.lon"></el-input>
                </el-form-item>
                <el-form-item label="学校纬度">
                    <el-input class="form-input" v-model="school.lat"></el-input>
                </el-form-item>
            </el-form>
        </template>
    </el-row>
</div>

    <script>
        window.appFrameObject = AppFrame({
        data:{
            school:{
                schoolName:'',
                regionValue:[],
                address:'',
                zoneId:'',
                lon:'',
                lat:'',
            },
            zoneList:[],
            regionList:[],
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var school = this.school;
                AjaxLoader.post(AppCommon.getUrl('/school/setAddress'),{'school':this.school},function(res){
                    that.msgSuccess('保存成功');
                    that.reloadForm();
                    AppCommon.run(callback,res);
                });
            },
            reloadForm:function(){
                location.reload();
            },
            getZoneList:function(){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/zone/getZoneList'),{},function(res){
                    console.log(res['list'])
                    that.zoneList = res['list'];
                });
            },
            getSchoolInfo:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/school/getSchoolInfo'),{'schoolId':this.school.schoolId},function(data){
                    console.log(data);
                    that.school = data;
                    AppCommon.run(callback,data);
                });
            },
            getRegionList:function() {
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/region/getRegionList'),{},function(data){
                    that.regionList = data;
                });
            },
            regionChange(region) {
              this.province = region[0];
              this.city = region[1];
              this.district = region[2];
              console.log(this.province,this.city,this.district);
            },
        },
        mounted:function(){
            var schoolId = AppCommon.getUrlParam('schoolId');
            this.getZoneList();
            this.getRegionList();
            if (schoolId) {
                this.school.schoolId = schoolId;
                this.getSchoolInfo();
            }
        },

    })
</script>
