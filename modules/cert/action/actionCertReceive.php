<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
require("../../../common.php");
require DT_ROOT . '/Class/CertReceiveClass.php';
$info = new CertReceiveClass();
$type = _post("type");
if ($type == "delete") {
    $info->setInfo(_post("id"));
    $arr = array();
    $arr["Flag"] = 1;
    $result = $info->updateInfo($arr);
    echo returnResult($result, 1);
    exit();
}
if (isset($_POST ["add"])) {
    $arr = array();
    $arr["CertId"] = _post("certid");
    $arr["ReceivePerson"] = _post("receive_person");
    $arr["ReceiveDate"] = _post("receive_date");
    $arr["RecievePhone"] = _post("recieve_phone");
    $arr["SignForm"] = _post("sign_form");
    $arr["ReceiveWritePerson"] = _post("write_person");
    $arr["ReceiveWriteDate"] = _post("write_date");
    $result = $info->insertInfo($arr);
    if ($result > 0) {
        $result = "添加成功";
    }
    echo returnResult($result, 1);
    exit();
} elseif (isset($_POST ["modify"])) {
    $info->setInfo(_post("id"));
    $arr = array();
    $arr["CertId"] = _post("certid");
    $arr["ReceivePerson"] = _post("receive_person");
    $arr["ReceiveDate"] = _post("receive_date");
    $arr["RecievePhone"] = _post("recieve_phone");
    $arr["SignForm"] = _post("sign_form");
    $arr["ReceiveWritePerson"] = _post("write_person");
    $arr["ReceiveWriteDate"] = _post("write_date");
    $result = $info->updateInfo($arr);
    if ($result > -1) {
        $result = "修改成功";
    } else {
        $result = "修改失败，请重试！";
    }
    echo returnResult($result, 1);
    exit();
}