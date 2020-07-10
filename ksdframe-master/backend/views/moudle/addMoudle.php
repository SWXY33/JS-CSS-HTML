<div id="app" style="width: 800px">
    <el-row style="width:800px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" v-model="moudle">
                                        <el-form-item label="MOUDLEKEY" prop="moudleKey">
                            <el-input class="form-input" autofocus="true" placeholder="MOUDLEKEY" v-model="moudle.moudleKey"></el-input>
                        </el-form-item>
                                        <el-form-item label="模块名" prop="moudleName">
                            <el-input class="form-input" autofocus="true" placeholder="模块名" v-model="moudle.moudleName"></el-input>
                        </el-form-item>
                                        <el-form-item label="表字段" prop="tableCols">
                            <el-input class="form-input" autofocus="true" placeholder="表字段" v-model="moudle.tableCols"></el-input>
                        </el-form-item>
                                        <el-form-item label="显示字段" prop="showCols">
                            <el-input class="form-input" autofocus="true" placeholder="显示字段" v-model="moudle.showCols"></el-input>
                        </el-form-item>
                                        <el-form-item label="主键" prop="primaryKey">
                            <el-input class="form-input" autofocus="true" placeholder="主键" v-model="moudle.primaryKey"></el-input>
                        </el-form-item>
                                        <el-form-item label="字段名" prop="colsNames">
                                            <el-button type="success" plain icon="el-icon-edit" size="small" @click="fillColNamesEditor()">用所有字段填充</el-button>
                            <div id="colsNamesEditor"></div>
                        </el-form-item>
                                        <el-form-item label="字段类型" prop="colsTypes">
                                            <div id="colsTypesEditor"></div>
                        </el-form-item>
                            </el-form>
        </template>
    </el-row>
</div>
<link rel='stylesheet' href='//cdn.jsdelivr.net/foundation/5.0.2/css/foundation.min.css'>
<script language="JavaScript" src="<?=Yii::$app->params['baseUrl']?>/js/json-editor/dist/jsoneditor.min.js"></script>
<script>
    JSONEditor.defaults.theme = 'foundation5';
    JSONEditor.defaults.iconlib = 'fontawesome4';
    var colsNamesEditor = null;
    var colsTypesEditor = null;
    window.appFrameObject = AppFrame({
        data:{
            moudle:{"moudleKey":"","moudleName":"","tableCols":"","showCols":"","primaryKey":"","colsNames":"","colsTypes":""},
            moudleId:''
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                that.moudle.colsNames = colsNamesEditor.getValue();
                that.moudle.colsTypes = colsTypesEditor.getValue();
                if (!that.moudleId) {
                    AjaxLoader.post(AppCommon.getUrl('/moudle/addMoudle'),{'moudle':that.moudle},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/moudle/updateMoudle'),{'moudleId':that.moudleId,'moudle':that.moudle},function(res){
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },
            fillColNamesEditor:function(){
                var obj = {};
                var showCols = this.moudle.showCols.split(',');
                var tableCols = this.moudle.tableCols.split(',');
                for( i in showCols ){
                    obj[showCols[i]] = showCols[i];
                }
                for( j in tableCols ){
                    obj[tableCols[j]] = tableCols[j];
                }
                colsNamesEditor.setValue(obj);
            },
            reloadForm:function(){
                location.reload();
            },

            getMoudleInfo:function(){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/moudle/getMoudleInfo'),{'moudleId':this.moudleId},function(data){
                    that.moudle = data;
                    colsNamesEditor.setValue($.parseJSON(data.colsNames));
                });
            },


        },
        mounted:function(){
            var that = this;
            var moudleId = AppCommon.getUrlParam('moudleId');
            if (moudleId) {
                this.moudleId = moudleId;
                this.getMoudleInfo();
            }
            colsNamesEditor = new JSONEditor(document.getElementById('colsNamesEditor'),{
                schema: {
                    type: "object",
                    title:"字段对应的名字",
                    properties:{},
                }
            });

            colsTypesEditor = new JSONEditor(document.getElementById('colsTypesEditor'),{
                schema: {
                    type: "object",
                    title:"字段对应的类型",
                    properties:{},
                }
            });
        },

    })
</script>
