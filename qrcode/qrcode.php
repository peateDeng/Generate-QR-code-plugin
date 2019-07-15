<?php
/**
 * Created by PhpStorm.
 * User: DL
 * Date: 2018/9/6
 * Time: 14:16
 * email:chinatophp@163.com
 */
include("./phpqrcode/phpqrcode.php");

class Code {

    /**
     * @param array $content 二维码携带参数
     * @param string $logo 二维码底部logo图
     *
     */
    public static function gCode($content=array(),$logo=null){
        $content = json_encode($content); //qrcode content
        $errors=array();
        $tpgs='png';//image format
        //如果文件夹不存在要先创建文件夹，下面创建文件夹可能失败、涉及权限问题
        $qrcode_bas_path=$_SERVER['DOCUMENT_ROOT'].'/images/';
        if(!is_dir($qrcode_bas_path)){
            mkdir($qrcode_bas_path, 777, true);
        }
        $uniqid_rand=time().uniqid(). rand(1,1000);//rand number get
        $qrcode_path=$qrcode_bas_path.$uniqid_rand. ".".$tpgs;
        $qrcode_path_new=$qrcode_bas_path.$uniqid_rand.".".$tpgs;
        if(empty($errors)){
            $errorCorrectionLevel = 'M';//容错级别
            $matrixPointSize = 10;//生成图片大小
            $matrixMarginSize = 2;//边距大小
            //生成二维码图片
            QRcode::png($content,$qrcode_path_new, $errorCorrectionLevel, $matrixPointSize, $matrixMarginSize);
            $QR = $qrcode_path_new;//已经生成的原始二维码图
            if (file_exists($logo)) {
                $QR = imagecreatefromstring(file_get_contents($QR));
                $logo = imagecreatefromstring(file_get_contents($logo));
                $QR_width = imagesx($QR);//二维码图片宽度
                $QR_height = imagesy($QR);//二维码图片高度
                $logo_width = imagesx($logo);//logo图片宽度
                $logo_height = imagesy($logo);//logo图片高度
                $logo_qr_width = $QR_width / 4;
                $scale = $logo_width/$logo_qr_width;
                $logo_qr_height = $logo_height/$scale;
                $from_width = ($QR_width - $logo_qr_width) / 2;
                //重新组合图片并调整大小
                imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                    $logo_qr_height, $logo_width, $logo_height);
                //输出图片
                //header("Content-type: image/png");
                imagepng($QR,$qrcode_path);
                imagedestroy($QR);
            }else{
                $qrcode_path=$qrcode_path_new;
            }
        }else{
            $qrcode_path='';
        }
        if(!empty($qrcode_path)){
            $arr=explode('/',$qrcode_path);
            $qrcode_path=$arr[(count($arr)-1)];
        }
        return $qrcode_path;//返回图片名

    }


}