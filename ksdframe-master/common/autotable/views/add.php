<div id="app" style="width: 800px">
    <el-row style="width:800px;padding:20px;" >
        <template>
            <el-form ref="form" label-width="100px" :rules="rules" v-model="school">
                <?php foreach( $config['tableCols'] as $col ):
                        $colName = isset($config['colsNames'][$col])?$config['colsNames'][$col]:strtoupper($col);
                        if( substr($col,-4)=='Flag' ) {
                            ?>
                        <el-form-item label="<?=$colName?>" prop="<?=$col?>">
                            <el-switch
                                    v-model="<?=$name?>.<?=$col?>"
                                    active-color="#13ce66"
                                    inactive-color="#aaaaaa">
                            </el-switch>
                        </el-form-item>
                            <?php
                        } else {
                    ?>
                        <el-form-item label="<?=$colName?>" prop="<?=$col?>">
                            <el-input class="form-input" autofocus="true" placeholder="<?=$colName?>" v-model="<?=$name?>.<?=$col?>"></el-input>
                        </el-form-item>
                <?php } endforeach; ?>
            </el-form>
        </template>
    </el-row>
</div>

<script>
    window.appFrameObject = AppFrame({
        data:{
            <?=$name?>:<?=json_encode($config['tableValues'])?>,
            <?=$config['primaryKey']?>:''
        },
        methods: {
            onSubmit:function(callback){
                var that = this;
                var <?=$name?> = this.<?=$name?>;
                var <?=$config['primaryKey']?> = this.<?=$config['primaryKey']?>;
                if (!<?=$config['primaryKey']?>) {
                    AjaxLoader.post(AppCommon.getUrl('/<?=$name?>/add<?=ucfirst($name)?>'),{'<?=$name?>':this.<?=$name?>},function(res){
                        that.msgSuccess('保存成功');
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }else{
                    AjaxLoader.post(AppCommon.getUrl('/<?=$name?>/update<?=ucfirst($name)?>'),{'<?=$config['primaryKey']?>':<?=$config['primaryKey']?>,'<?=$name?>':<?=$name?>},function(res){
                        that.reloadForm();
                        AppCommon.run(callback,res);
                    });
                }
            },

            reloadForm:function(){
                location.reload();
            },

            get<?=ucfirst($name)?>Info:function(callback){
                var that = this;
                AjaxLoader.post(AppCommon.getUrl('/<?=$name?>/get<?=ucfirst($name)?>Info'),{'<?=$config['primaryKey']?>':this.<?=$config['primaryKey']?>},function(data){
                    that.<?=$name?> = data;
                    AppCommon.run(callback,data);
                });
            },


        },
        mounted:function(){
            var <?=$config['primaryKey']?> = AppCommon.getUrlParam('<?=$config['primaryKey']?>');
            if (<?=$config['primaryKey']?>) {
                this.<?=$config['primaryKey']?> = <?=$config['primaryKey']?>;
                this.get<?=ucfirst($name)?>Info();
            }
        },

    })
</script>
