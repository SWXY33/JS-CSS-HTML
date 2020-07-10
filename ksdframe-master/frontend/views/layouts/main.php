<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <title><?= Html::encode($this->title) ?></title>
    <link href="<?=Yii::$app->params['baseUrl']?>/public/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"  href="<?=Yii::$app->params['baseUrl']?>/static/css/font-awesome.min.css">
    <link rel="stylesheet"  href="<?=Yii::$app->params['baseUrl']?>/static/css/vant.min.1.6.css">
    <link rel="stylesheet"  href="<?=Yii::$app->params['baseUrl']?>/static/css/style.css">

    <script src="<?=Yii::$app->params['baseUrl']?>/public/vue2.6.10.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/public/jquery-3.2.1.min.js"></script>
    <script src="<?=Yii::$app->params['baseUrl']?>/js/common.js?v=20170915"></script>

    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?=Yii::$app->params['baseUrl']?>/public/jquery-3.2.1.min.js"></script>

    <?php $this->head() ?>
    <script>

        var baseUrl = '<?=Yii::$app->params['baseUrl']?>';
        var shopUrl = '<?=SHOP_URL?>';

        Vue.config.devtools = false;
        Vue.config.productionTip = false;

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
</head>
<body style="background: #F7F8FA;">
<?php $this->beginBody() ?>
<div class="container-fluid">
    <?=$content?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>