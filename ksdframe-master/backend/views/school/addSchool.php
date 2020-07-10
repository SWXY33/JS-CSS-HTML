<div id="app" style="width: 800px">
    <el-row style="width:800px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" :rules="rules" v-model="school">
                <el-form-item label="学校名称" prop="schoolName">
                    <el-input class="form-input" autofocus="true" placeholder="请输入名称" v-model="school.schoolName"></el-input><span style="color: #ff0000;"> *</span>
                </el-form-item>
                <el-form-item label="学校联系人">
                    <el-input class="form-input" placeholder="请输入联系人" v-model="school.contactName"></el-input>
                </el-form-item>
                <el-form-item label="学校联系人电话">
                    <el-input class="form-input" type="number" placeholder="请输入联系人电话" v-model="school.contactPhone"></el-input>
                </el-form-item>
                <el-form-item label="所属区域">
                    <template>
                        <div class="block">
                            <el-cascader
                                    style="width: 100%;"
                                    v-model="selectZoneList"
                                    @change="handleChange"
                                    :options="zoneList"
                                    :props="{ checkStrictly: true }"
                                    clearable>
                            </el-cascader>
                        </div>
                    </template>
                </el-form-item>
                <el-form-item label="省市区">
                    <el-cascader
                            v-model="school.regionValue"
                            :options="regionList"
                            @change="regionChange"
                            size="small"
                            placeholder="请选择省市区"
                            filterable
                            class="region-list">
                    </el-cascader>
                </el-form-item>
                <el-form-item label="详细地址">
                    <el-input class="form-input" placeholder="请输入详细地址" v-model="school.address"></el-input>
                </el-form-item>
                <el-form-item label="学校经纬度">
                    <el-input class="form-input" v-model="school.coordinate"></el-input><el-link type="primary" @click="map()">打开地图</el-link>
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
                contactName:'',
                contactPhone:'',
                zoneIdList:[],
                regionValue:'',
                address:'',
                coordinate:'',
            },
            regionList:[],
            selectZoneList:[],
            zoneList:[],
            rules: {},
            schoolId:''
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var school = this.school;
                var schoolId = this.schoolId;
                if (school.schoolName=='') {
                    that.msgError('学校名称不可为空');
                    return false;
                }
                if (!schoolId) {
                    AjaxLoader.post(AppCommon.getUrl('/school/addSchool'),{'school':this.school},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/school/updateSchool'),{'schoolId':schoolId,'school':school},function(res){
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },

            handleChange() {
                console.log(this.selectZoneList);
                this.school.zoneIdList = this.selectZoneList;
            },

            map:function(callback){
                AppDialog.openFrame(AppCommon.getUrl('/device/map'),'拾取坐标');
            },

            reloadForm:function(){
                location.reload();
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

            getZoneList:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/zone/getZoneSelectList'),{},function(data){
                    that.zoneList = data;
                    AppCommon.run(callback,data);
                });
            },

            getSchoolInfo:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/school/getSchoolInfo'),{'schoolId':this.schoolId},function(data){
                    console.log(data);
                    that.selectZoneList = data.selectZoneList;
                    that.school = data;
                    that.school.zoneIdList = data.selectZoneList;
                    AppCommon.run(callback,data);
                });
            },


        },
        mounted:function(){
            this.getRegionList();
            this.getZoneList();
            var schoolId = AppCommon.getUrlParam('schoolId');
            if (schoolId) {
                this.schoolId = schoolId;
                this.getSchoolInfo();
            }
        },

    })
</script>
