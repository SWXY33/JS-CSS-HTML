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
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?=Yii::$app->params['baseUrl']?>/public/jquery-3.2.1.min.js"></script>
    <script>
        var baseUrl = '<?=Yii::$app->params['baseUrl']?>';
        //var AppCommon = {};
        AppCommon.baseurl = '<?=Yii::$app->params['baseUrl']?>';
    </script>
    <?php $this->head() ?>
<body>
<?php $this->beginBody() ?>
<div class="container-fluid">
    <?=$content?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>