    <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/element.min.css">
    <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/csshake.css">
    <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/layx.min.css">
        <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/style.css">

    <script src="<?=Yii::$app->params['baseUrl']?>/public/vue2.6.10.js"></script>    
    <script src="<?=Yii::$app->params['baseUrl']?>/public/element.min.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/layx.min.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/jquery-3.2.1.min.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/echarts.min.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/walden.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/china.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/shine.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/js/common.js?v=20170915"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/index/jsData"></script>

    <script>

        var baseUrl = '<?=Yii::$app->params['baseUrl']?>';
        AppCommon.baseurl = '<?=Yii::$app->params['baseUrl']?>';

        Vue.config.devtools = false;//配置是否允许 vue-devtools 检查代码。
        Vue.config.productionTip = false;//设置为 false 以阻止 vue 在启动时生成生产提示。
        var AppFrame = function(data){
            data.el = '#app';
            data.data.tableHeight = document.documentElement.clientHeight - 130;
            data.methods.msgError = function(msg){
                return AppDialog.error(msg);
            }
            data.methods.msgSuccess = function(msg){
                return AppDialog.success(msg);// 在backemd/web/js/common.js的window.AppDialog中的 
				//success:function( message ){
                //layx.msg(message,{dialogIcon:'success'});
                // },
            }
            var vm = new Vue(data);
            return vm;
        }

        $(document).ready(function(){
            $('#app').show();
        });
    </script>
    <style>
        #app{
             display: none; 
        }
    </style>
