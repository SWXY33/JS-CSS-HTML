<div id="app" v-loading.fullscreen.lock="fullScreenLoading">
    <section class="content-right">
        <div class="content-main-right">
            <div class="right-tip-title" style="padding-top:50px;"><i class="el-icon-notebook-2"></i>操作流程</div>
            <div class="right-tip-content">
                <img width="100%" src="/images/operation/line.png">
            </div>
        </div>
    </section>
</div>
<script>
    var frame = AppFrame({
        data:{
            fullScreenLoading:true,
        },
        methods: {
            batchAddCard:function(){
                var that = this;
                var frameId = '';
                var buttonList = [
                    {
                        label:'保存',
                        callback:function(contentWindow){
                            contentWindow.appFrameObject.onSubmit(function(data){
                                that.msgSuccess('批量添加完成');
                                that.getCardList();
                                AppDialog.close(frameId);
                            });
                        }
                    },
                    {
                        label:'取消',
                        callback:function(contentWindow){
                            AppDialog.close(frameId);
                        }
                    }
                ];
                frameId = AppDialog.openFrame(AppCommon.getUrl('/card/batchAddCardList'),'添加电话卡',buttonList);
            },

        },
        mounted:function(){
        },

    })
</script>

