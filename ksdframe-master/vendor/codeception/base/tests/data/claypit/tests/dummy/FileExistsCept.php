<?php
require '_bootstrap.php';

$I = new DumbGuy($scenario);
$I->wantTo('weiXin config exists');
$I->seeFileFound($codeception);