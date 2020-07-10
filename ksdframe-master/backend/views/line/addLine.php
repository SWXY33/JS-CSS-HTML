<div id="app" style="width: 800px">
    <el-row style="width:800px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" v-model="line">
              <el-form-item label="线路名称">
                  <el-input class="form-input" v-model="line.lineName"></el-input><span style="color: #ff0000;"> *</span>
              </el-form-item>
              <el-form-item label="线路前缀">
                  <el-input class="form-input" v-model="line.linePrefix"></el-input><span style="color: #ff0000;"> *</span>
              </el-form-item>
              <el-form-item label="标准资费/分钟">
                  <el-input class="form-input" v-model="line.baseFee" type="number"></el-input><span style="color: #ff0000;"> *</span>
              </el-form-item>
              <el-form-item label="线路IP">
                  <el-input class="form-input" v-model="line.lineIP"></el-input><span style="color: #ff0000;"> *</span>
              </el-form-item>
              <el-form-item label="剩余通话时间">
                  <el-input class="form-input" v-model="line.leftMins" type="number"></el-input>
              </el-form-item>
              <el-form-item label="线路号码">
                  <el-input type="textarea" v-model="line.lineNumber" style="width: 500px;" placeholder="多个请使用','隔开"></el-input>
              </el-form-item>
              <el-form-item label="套餐">
                  <el-select v-model="line.planId" placeholder="选择套餐">
                      <el-option
                            v-for="item in planList"
                            :key="item.planId"
                            :label="item.planName"
                            :value="item.planId">
                      </el-option>
                  </el-select>
              </el-form-item>
              <el-form-item label="备注">
                  <el-input type="textarea" v-model="line.content" style="width: 300px;"></el-input>
              </el-form-item>
            </el-form>
        </template>
    </el-row>
</div>

<script>
    window.appFrameObject = AppFrame({
        data:{
            line:{
                lineName:'',
                linePrefix:'',
                baseFee:'',
                lineIP:'',
                leftMins:'',
                lineNumber:'',
                content:'',
                planId:'',
            },
            planList:[]
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var line = this.line;
                var lineId = this.lineId;
                if(line.lineName==''){
                    this.msgError("线路名称不能为空");
                    return;
                }
                if(line.linePrefix==''){
                    this.msgError("线路前缀不能为空");
                    return;
                }
                if(line.baseFee==''||parseFloat(line.baseFee)<=0){
                    this.msgError("线路标准资费不能为空且必须大于0");
                    return;
                }
                if(line.lineIP==''){
                    this.msgError("线路IP不能为空");
                    return;
                }
                if (!lineId) {
                    AjaxLoader.post(AppCommon.getUrl('/line/addLine'),{'line':line},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/line/updateLine'),{'lineId':lineId,'line':line},function(res){
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },

            getLineInfo:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/line/getLineInfo'),{'lineId':this.lineId},function(data){
                    if(data.planId==0){
                        data.planId='';
                    }
                    that.line = data;
                    AppCommon.run(callback,data);
                });
            },

            getPlanList:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/plan/getSelectPlanList'),{},function(data){
                    that.planList = data;
                    AppCommon.run(callback,data);
                });
            },

            reloadForm:function(){
                location.reload();
            },
        },
        mounted:function(){
            this.getPlanList();
            var lineId = AppCommon.getUrlParam('lineId');
            if (lineId) {
                this.lineId = lineId;
                this.getLineInfo();
            }
        },

    })
</script>
