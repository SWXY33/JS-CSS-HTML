
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
                <el-form-item label="负责人名称">
                    <el-input class="form-input" v-model="school.contactName"></el-input>
                </el-form-item>
                <el-form-item label="负责人电话">
                    <el-input class="form-input" type="number" v-model="school.contactPhone"></el-input>
                </el-form-item>
            </el-form>
        </template>
    </el-row>
</div>

    <script>
        window.appFrameObject = AppFrame({
        data:{
            school:{
                schoolId:'',
                schoolName:'',
                contactName:'',
                contactPhone:'',
            },
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var school = this.school;
                AjaxLoader.post(AppCommon.getUrl('/school/setContact'),{'school':this.school},function(res){
                    that.msgSuccess('保存成功');
                    that.reloadForm();
                    AppCommon.run(callback,res);
                });
            },
            reloadForm:function(){
                location.reload();
            },
            getSchoolInfo:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/school/getSchoolInfo'),{'schoolId':this.school.schoolId},function(data){
                    if(data.schoolId==0){
                        data.schoolId='';
                    }
                    that.school = data;
                    AppCommon.run(callback,data);
                });
            },
        },
        mounted:function(){
            var schoolId = AppCommon.getUrlParam('schoolId');
            if (schoolId) {
                this.school.schoolId = schoolId;
                this.getSchoolInfo();
            }
        },

    })
</script>
