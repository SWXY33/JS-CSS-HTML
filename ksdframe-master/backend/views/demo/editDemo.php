<div id="app" style="width: 800px">
    <el-row style="width:800px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" :rules="rules" v-model="school">
                                        <el-form-item label="姓名" prop="name">
                            <el-input class="form-input" autofocus="true" placeholder="姓名" v-model="demo.name"></el-input>
                        </el-form-item>
                                        <el-form-item label="年龄" prop="age">
                            <el-input class="form-input" autofocus="true" placeholder="年龄" v-model="demo.age"></el-input>
                        </el-form-item>
                                        <el-form-item label="HOME" prop="home">
                            <el-input class="form-input" autofocus="true" placeholder="HOME" v-model="demo.home"></el-input>
                        </el-form-item>
                                        <el-form-item label="TELPHONE" prop="telphone">
                            <el-input class="form-input" autofocus="true" placeholder="TELPHONE" v-model="demo.telphone"></el-input>
                        </el-form-item>
                                        <el-form-item label="SHOWFLAG" prop="showFlag">
                            <el-switch
                                    v-model="demo.showFlag"
                                    active-color="#13ce66"
                                    inactive-color="#aaaaaa">
                            </el-switch>
                        </el-form-item>
                                        </el-form>
        </template>
    </el-row>
</div>

<script>
    window.appFrameObject = AppFrame({
        data:{
            demo:{"name":"","age":"","home":"","telphone":"","showFlag":""},
            demoId:''
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var demo = this.demo;
                var demoId = this.demoId;
                if (!demoId) {
                    AjaxLoader.post(AppCommon.getUrl('/demo/addDemo'),{'demo':this.demo},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/demo/updateDemo'),{'demoId':demoId,'demo':demo},function(res){
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },

            reloadForm:function(){
                location.reload();
            },

            getDemoInfo:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/demo/getDemoInfo'),{'demoId':this.demoId},function(data){
                    that.demo = data;
                    AppCommon.run(callback,data);
                });
            },


        },
        mounted:function(){
            var demoId = AppCommon.getUrlParam('demoId');
            if (demoId) {
                this.demoId = demoId;
                this.getDemoInfo();
            }
        },

    })
</script>
