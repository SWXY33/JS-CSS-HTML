
    <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/element.min.css">
    <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/csshake.css">
    <link rel="stylesheet" href="<?=Yii::$app->params['baseUrl']?>/css/style.css">
    <script src="<?=Yii::$app->params['baseUrl']?>/public/vue.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/element.min.js"></script>

    <script src="<?=Yii::$app->params['baseUrl']?>/public/jquery-3.2.1.min.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/echarts.min.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/walden.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/china.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/shine.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/js/common.js?v=20170915"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/index/jsData"></script>

    <script>
        var baseUrl = '<?=Yii::$app->params['baseUrl']?>';
        var shopUrl = '<?=SHOP_URL?>';
        AppCommon.baseurl = '<?=Yii::$app->params['baseUrl']?>';
        Vue.config.devtools = false;
        Vue.config.productionTip = false;
        var AppFrame = function(){
            this.prototype = new Vue();
            return this;
        }
        
        var AppFrame = function(data){

            data.el = '#app';
            data.data.tableHeight = document.documentElement.clientHeight - 160;
            
            data.methods.msgError = function(msg){
                return this.$message.error(msg);
            }
            data.methods.msgSuccess = function(msg){
                return this.$message.success(msg);
            }

            var vm = new Vue(data);
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
