<?php

namespace common\models;


use common\components\Model;

class ExcelModel extends Model {

    /**
     * 导出CSV文件
     * @param array $data        数据
     * @param array $header_data 首行数据
     * @param string $file_name  文件名称
     * @return string
     */

    public function orderExport($data){
        $header = array('订单号','商品名称','购买数量','付款金额','收件人', '收件人电话','收货地址','购买人','创建时间');
        $filename = date("Y-m-d_H:i",time()).'业务单导出.csv';
        $this->exportCsv($businessData,$header,$filename);
    }

    public function exportCsv($data = [], $header_data = [], $file_name = ''){

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$file_name);
        header('Cache-Control: max-age=0');
        $fp = fopen('php://output', 'a');
        if (!empty($header_data)) {
            foreach ($header_data as $key => $value) {
                $header_data[$key] = iconv('utf-8','GB2312//IGNORE', $value);
            }
            fputcsv($fp, $header_data);
        }
        $num = 0;
        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;
        //逐行取出数据，不浪费内存
        $count = count($data);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $num++;
                //刷新一下输出buffer，防止由于数据过多造成问题
                if ($limit == $num) {
                    ob_flush();
                    flush();
                    $num = 0;
                }
                $row = $data[$i];
                foreach ($row as $key => $value) {
                    $row[$key] = iconv('utf-8','GB2312//IGNORE', $value);
                }
                fputcsv($fp, $row);

            }
        }
        fclose($fp);
    }

}