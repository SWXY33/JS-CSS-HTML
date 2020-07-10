<div id="app" style="width: 800px">
    <el-row style="width:800px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" :rules="rules" v-model="school">
                                        <el-form-item label="名字" prop="name">
                            <el-input class="form-input" autofocus="true" placeholder="名字" v-model="apple.name"></el-input>
                        </el-form-item>
                                        <el-form-item label="颜色" prop="color">
                            <el-input class="form-input" autofocus="true" placeholder="颜色" v-model="apple.color"></el-input>
                        </el-form-item>
                                        <el-form-item label="价格" prop="price">
                            <el-input class="form-input" autofocus="true" placeholder="价格" v-model="apple.price"></el-input>
                        </el-form-item>
                                        <el-form-item label="重量" prop="weight">
                            <el-input class="form-input" autofocus="true" placeholder="重量" v-model="apple.weight"></el-input>
                        </el-form-item>
                            </el-form>
        </template>
    </el-row>
</div>

<script>
    window.appFrameObject = AppFrame({
        data:{
            apple:{"name":"","color":"","price":"","weight":""},
            appleId:''
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var apple = this.apple;
                var appleId = this.appleId;
                if (!appleId) {
                    AjaxLoader.post(AppCommon.getUrl('/apple/addApple'),{'apple':this.apple},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/apple/updateApple'),{'appleId':appleId,'apple':apple},function(res){
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },

            reloadForm:function(){
                location.reload();
            },

            getAppleInfo:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/apple/getAppleInfo'),{'appleId':this.appleId},function(data){
                    that.apple = data;
                    AppCommon.run(callback,data);
                });
            },


        },
        mounted:function(){
            var appleId = AppCommon.getUrlParam('appleId');
            if (appleId) {
                this.appleId = appleId;
                this.getAppleInfo();
            }
        },

    })
</script>
