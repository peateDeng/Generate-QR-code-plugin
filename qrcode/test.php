<?php
/**
 * Created by PhpStorm.
 * User: DL
 * Date: 2018/9/7
 * Time: 14:26
 */
include_once 'qrcode.php';
//测试，记得引入文件
$data['code']=1;
$data['name']='peate@chinatophp@163.com';
$logo=$_SERVER['DOCUMENT_ROOT'].'/images/logo.png';
$path=Code::gCode($data,$logo);
var_dump($path);exit;