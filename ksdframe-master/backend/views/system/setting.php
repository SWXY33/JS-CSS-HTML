<div id="app">
    <el-row class="container main-content" >
        <el-col :span="24" class="main">
            <section class="content-container fix-content">
                <div class="content">
                    <template>
                        <el-tabs v-model="activeName" class="setting" v-loading.fullscreen.lock="fullScreenLoading">
                            <el-tab-pane label="基本设置" name="base">
                                <div class="tab-content">
                                    <el-form ref="shopData" :model="shopData" label-width="120px">
                                        <el-form-item label="项目名称">
                                            <el-input v-model="shopData.sys_title" class="default-input-width"></el-input>
                                            <el-tooltip placement="right" >
                                                <div slot="content">此名称用于后台展示等。</div>
                                                <i class="fa fa-question-circle-o content-tip"></i>
                                            </el-tooltip>
                                        </el-form-item>
<!--                                         <el-form-item label="商城名称">
                                            <el-input v-model="shopData.shop_name" class="default-input-width"></el-input>
                                            <el-tooltip placement="right" >
                                                <div slot="content">此名称用于公众号及APP。</div>
                                                <i class="fa fa-question-circle-o content-tip"></i>
                                            </el-tooltip>
                                        </el-form-item> -->
                                        <!-- <el-form-item label="商城LOGO">
                                            <div class="imgBox" v-if="shopData.shop_logo">
                                                <img  v-bind:src="'../upload/images/'+shopData.shop_logo" class="showImg" >
                                            </div>
                                            <div class="upload-img">
                                                <el-upload
                                                action="/file/add"
                                                name='shop_logo'
                                                ref='shop_logo'
                                                v-model="shopData.shop_logo"
                                                :on-success="fileSet"
                                                :on-remove="fileRmove"
                                                >
                                                <el-button size="small" type="primary">上传LOGO</el-button>
                                                </el-upload>
                                            </div>
                                        </el-form-item> -->
                                        <el-form-item label="数据连接密码">
                                            <el-input value="20190903" class="default-input-width" disabled></el-input>
                                            <el-tooltip placement="right" >
                                                <div slot="content">暂不支持修改。</div>
                                                <i class="fa fa-question-circle-o content-tip"></i>
                                            </el-tooltip>
                                        </el-form-item>
                                        <el-form-item label="暂时关闭系统">
                                            <el-switch
                                                v-model="shopData.shop_closed"
                                                on-text=""
                                                off-text="">
                                            </el-switch>
                                            <el-tooltip placement="right" >
                                                <div slot="content">关闭系统，必须填写关闭系统原因。</div>
                                                <i class="fa fa-question-circle-o content-tip"></i>
                                            </el-tooltip>
                                        </el-form-item>
                                        <el-form-item label="关闭系统原因">
                                            <el-input
                                                type="textarea"
                                                :rows="2"
                                                placeholder="关闭系统原因"
                                                v-model="shopData.close_comment"
                                                class="default-input-width">
                                            </el-input>
                                        </el-form-item>
                                        <el-form-item>
                                            <el-button type="primary" @click="shopSubmit">保 存</el-button>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="微信参数" name="weixin">
                                <div class="tab-content">
                                    <el-form ref="shopData" :model="shopData" label-width="120px">
                                        <el-form-item label="微信APPID">
                                            <el-input v-model="shopData.appid" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item label="微信秘钥APPSecret">
                                            <el-input v-model="shopData.app_secret" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item label="微信支付MCH_ID">
                                            <el-input v-model="shopData.mch_id" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item label="微信支付MCH_Key">
                                            <el-input v-model="shopData.mch_key" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item>
                                            <el-button type="primary" @click="shopSubmit">保 存</el-button>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="第三方接口参数" name="third">
                                <div class="tab-content">
                                    <el-form ref="shopData" :model="shopData" label-width="120px">
                                        <el-form-item label="聚合短信KEY">
                                            <el-input v-model="shopData.juhe_sms_key" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item label="聚合短信发送模板ID">
                                            <el-input v-model="shopData.juhe_sms_template_id" class="small-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item label="聚合身份证验证KEY">
                                            <el-input v-model="shopData.juhe_idcard_key" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item label="聚合银行卡验证KEY">
                                            <el-input v-model="shopData.juhe_bankcard_key" class="default-input-width"></el-input>
                                        </el-form-item>
                                        <el-form-item>
                                            <el-button type="primary" @click="shopSubmit">保 存</el-button>
                                        </el-form-item>
                                    </el-form>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </template>
                </div>
            </section>
        </el-col>
    </el-row>
</div>

<script>
    var frame = AppFrame({
        data:{
            fullScreenLoading: true,
            activeName:'base',
            shopData: {}
        },
        methods: {
            fileSet:function(response) {
                this.shopData[response.data.keyName] = response.data.fileName;
            },
            fileRmove:function(file){
                this.shopData[file.response.data.keyName] = '';
            },
            getShopInfo:function(){
                var self = this;
                AjaxLoader.post(AppCommon.getUrl('/system/getShopConfig'),{},function(data){
                    self.fullScreenLoading = false;
                    self.shopData = data;
                    self.shopData.reg_close = data.reg_close == "0" ? false : true;
                    self.shopData.shop_closed = data.shop_closed == "0" ? false : true;
                    self.shopData.withdraw = data.withdraw == "0" ? false : true;
                    self.shopData.transfer = data.transfer == "0" ? false : true;
                    self.shopData.withdraw_weekday = data.withdraw_weekday == "0" ? false : true;
                    self.shopData.paypassword = data.paypassword == "0" ? false : true;
                });
            },
            shopSubmit:function(){ 
                var shopData = Object.assign({}, this.shopData);
                shopData.reg_close = shopData.reg_close ? 1 : 0;
                shopData.shop_closed = shopData.shop_closed ? 1 : 0;
                shopData.withdraw = shopData.withdraw ? 1 : 0;
                shopData.transfer = shopData.transfer ? 1 : 0;
                shopData.withdraw_weekday = shopData.withdraw_weekday ? 1 : 0;
                shopData.paypassword = shopData.paypassword ? 1 : 0;
                var self = this;

                if (shopData.shop_closed && shopData.close_comment!==undefined && shopData.close_comment.length === 0) {
                    return self.msgError('关闭网站，必须填写关闭原因！');
                }
                AjaxLoader.post(AppCommon.getUrl('/system/updateParam'),{shopData},function(res){
                    self.getShopInfo();        
                    self.msgSuccess('保存成功！');
                });
            },
        },
        mounted:function() {
            this.getShopInfo();
            var tableHeight = document.documentElement.clientHeight - 160;
            this.tableHeight = tableHeight;
        }

    })
</script>
