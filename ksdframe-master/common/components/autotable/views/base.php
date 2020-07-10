<?='<?php'?>

namespace common\models;

use common\components\RecordModel;

class <?=ucfirst($name)?> extends RecordModel {

    public static function primaryColumn(){
        return '<?=$config['primaryKey']?>';
    }

    public static function add<?=ucfirst($name)?>($data){
        //仅供简化使用，建议重写该方法
        return self::create($data);
    }

<?php foreach( $config['showCols'] as $col ) :
    if($col == $primaryKey) continue;
    $returnResult = in_array($col,$config['tableCols'])?"\$this->{$col}":"'[EMPTY]'";
?>

    public function get<?=ucfirst($col)?>(){
        return <?=$returnResult?>;
    }

<?php endforeach; ?>
}
