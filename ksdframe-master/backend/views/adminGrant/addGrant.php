<div id="app" style="width: 800px">
    <el-row style="width:800px;padding:20px;" >
        <template>
            <el-form :model="addBase" label-width="100px" ref="addBase">
                <el-form-item label="权限名称" prop="name">
                    <el-input v-model="addBase.name" class="agent-input" v-on:blur="checkGrantName(addBase.name)"></el-input>
                </el-form-item>
                <el-form-item label="权限类型" prop="type">
                    <el-select v-model="addBase.type" placeholder="请选择">
                        <el-option label="菜单权限" value="1"></el-option>
                        <el-option label="字段权限" value="2"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="上级模块" prop="parentId">
                    <el-select v-model="addBase.parentId" placeholder="请选择" >
                        <el-option
                          v-for="item in topList"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                    </el-select>
                    <span class="input-tip"><i>*</i>字段权限不允许选择顶级</span>
                </el-form-item>
                <el-form-item label="标签" prop="tag">
                    <el-input v-model="addBase.tag" class="agent-input" v-on:blur="checkGrantTag(addBase.tag)"></el-input>
                    <span class="input-tip"><i>*</i>必填，不能重复</span>
                </el-form-item>
                <el-form-item label="路径" prop="url">
                    <el-input v-model="addBase.url" class="agent-input"></el-input>
                </el-form-item>
                <el-form-item label="排序" prop="orderby">
                    <el-input v-model="addBase.orderby" class="agent-input"></el-input>
                </el-form-item>
                <el-form-item label="模块图标" prop="icon">
                    <el-input v-model="addBase.icon" class="agent-input"></el-input>
                </el-form-item>
            </el-form>
        </template>
    </el-row>
</div>

    <script>
        window.appFrameObject = AppFrame({
        data:{
            adminGrantId:'',
            addBase: {
                name:'',
                parentId:'',
                orderby:'',
                tag:'',
                url:'',
                icon:'',
                type:"1"
            },
            topList: AppData.adminGrantTopList
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                if (!this.adminGrantId) {
                    if (this.addBase.name ==''|| this.addBase.tag ==''||this.addBase.type =='') {
                        return that.msgError('请填写必填参数');
                    }
                    AjaxLoader.post(AppCommon.getUrl('/adminGrant/addGrantData'),{'addBase':this.addBase},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/adminGrant/updateGrantData'),{'adminGrantId':this.adminGrantId,'addBase':this.addBase},function(res){
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },
            checkGrantName:function(name){
                    var that = this;
                    AjaxLoader.post(AppCommon.getUrl('/adminGrant/checkGrantName'),{'name':name},function(data){
                        if(data){
                            that.msgError('模块名已存在，请重新填写');
                            that.addBase.name = '';
                        }
                    });
            },
            getGrantInfo:function(){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/adminGrant/getGrantDataInfo'),{'adminGrantId':this.adminGrantId},function(res){
                    that.addBase = res;
                });
            },
            checkGrantTag:function(tag){
                    var that = this;
                    AjaxLoader.post(AppCommon.getUrl('/adminGrant/checkGrantTag'),{'tag':tag},function(data){
                        if(data){
                            that.msgError('标签已存在，请重新填写');
                            that.addBase.tag = '';
                        }
                    });
            },

            reloadForm:function(){
                location.reload();
            },
        },
        mounted:function(){
            var adminGrantId = AppCommon.getUrlParam('adminGrantId');
            if (adminGrantId) {
                this.adminGrantId = adminGrantId;
                this.getGrantInfo();
            }
        }
    })
</script>
