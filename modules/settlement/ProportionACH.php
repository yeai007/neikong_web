<?php

/**
 * @author  PVer
 * @date    2018-4-13 10:31:02
 * @version V1.0
 * @desc    
 */
if (!session_id()) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    $_SESSION['userurl'] = $_SERVER['REQUEST_URI'];
    header("location:../login.php?"); //重新定向到其他页面
    exit();
} else {
    $user = $_SESSION['user'][0];
}
require( "../../common.php");
$pagetype = _get("pagetype");
require (DT_ROOT . "/data/dbClass.php");
$data = array();
$per = "select * from performancelevelinfo";
$data["performance"] = $db->query($per);
$bus = "select * from bustype";
$data["bustype"] = $db->query($bus);
$list = "select * from achproportion";
$arr = array();



$data["list"] = $db->query($list);
$data["pagetype"] = $pagetype;
echo $twig->render('settlement/proportion_ach.twig', $data);
