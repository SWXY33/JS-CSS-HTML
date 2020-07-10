<?php
namespace common\components;

use common\components\phpqrcode;

include dirname(__FILE__).'/phpqrcode/phpqrcode.php';

class QR {

    public static function generate($type, $content, $config) {

        // 初始化参数
        $config = self::init($config);

        //
        switch ($type) {
            case '1': // 普通二维码
                self::codeCommon($content, $config);
                break;
            case '2': // 带 Logo 二维码
                self::codeWithlogo($content, $config);
                break;
            case '3': // 带文字二维码
                self::codeWithText($content, $config);
                break;
            case '4': // 带背景二维码
                self::codeWithBg($content, $config);
                break;
            default:
                die('无效的操作类型！');
                break;
        }

    }

    /**
     * 初始化生成二维码的配置参数
     * @param $config 重新定义的配置
     * @return array
     */
    private static function init($config) {

        // 设置可配置的初始化参数
        $initConfig = array(
            'file' => false, // 保存的文件路径+文件名
            'logo' => false,
            'size' => 3, // 生成二维码图片大小，
            'level' => 'L', // 纠错级别
            'padding' => 2, // 边距
            'outType' => 1 // 输出类型：1 直接输出；2 保存文件
        );

        // 根据用户的设置，重置初始化参数
        if(!empty($config) && count($config) > 0) {
            foreach ($config as $k => $v) {
                $initConfig[$k] = $v;
            }
        }

        return $initConfig;
    }

    /**
     * 创建普通二维码
     * @param $content 待编码的内容
     * @param $config 自定义的配置参数
     * @return 生成的二维码图片资源
     */
    private static function codeCommon($content, $config) {
        header("Content-type: image/png");
        phpqrcode\QRcode::png($content, $config['file'], $config['level'], $config['size'], $config['padding']);
    }

    /**
     * 创建中间带 Logo 的二维码
     * @param $content 待编码的内容
     * @param $config 自定义的配置参数
     * @return 生成的二维码图片资源
     */
    private static function codeWithLogo($content, $config) {
        // 检查是否设置 Logo
        if (empty($config['logo'])) die('Invalid parameter logo !');

        // 判断是否要导出文件
        $filename = null;
        if (!empty($config['file'])) {
            $filename = $config['file'];
        } else {
            $filename=tempnam('','').'.png'; // 生成临时文件
        }
        // 生成二维码
        phpqrcode\QRcode::png($content, $filename, $config['level'], $config['size'], $config['padding']);

        // 组合 Logo 与 二维码
        $QR = imagecreatefromstring(file_get_contents($filename));
        $logo = imagecreatefromstring(file_get_contents($config['logo']));
        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);
        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);
        $logo_qr_width = $QR_width / 4;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;
        $from_width = ($QR_width - $logo_qr_width) / 1;
        $from_height = ($QR_height - $logo_qr_height) / 1;
        imagecopyresampled($QR, $logo, $from_width, $from_height, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        header("Content-type: image/png");
        imagepng($QR);

    }

    /**
     * 创建带背景的二维码
     * @param $content 待编码的内容
     * @param $config 自定义的配置参数
     * @return 生成的二维码图片资源
     */
    private static function codeWithBg($content, $config) {

        if (empty($config['bg'])) die('Invalid parameter bg !');

        // 判断是否要导出文件
        $filename = null;
        if (!empty($config['file'])) {
            $filename = $config['file'];
        } else {
            $filename=tempnam('','').'.png'; // 生成临时文件
        }
        // 生成二维码
        phpqrcode\QRcode::png($content, $filename, $config['level'], $config['size'], $config['padding']);

        $QR = imagecreatefromstring(file_get_contents($filename));
        $bg = imagecreatefromstring(file_get_contents($config['bg']));
        imagecopyresampled($bg, $QR,  260, 420, 30, 0, 200, 200, 617, 617);

        header("Content-type: image/png");
        imagepng($bg);

    }


}
