<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/ico" href="<?=Yii::$app->params['baseUrl']?>/images/favicon.ico">
    <title><?= CONFIG('sys_title') ?>管理中心</title>
    <?php include dirname(__FILE__).'/header.php';?>
</head>
<body>
    <?=$content?>
<?php include dirname(__FILE__).'/footer.php';?>
</body>
</html>