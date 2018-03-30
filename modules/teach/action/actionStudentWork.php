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
require DT_ROOT . '/Class/StudentWorkClass.php';
$info = new StudentWorkClass();
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
    $arr["ProCode"] = _post("pro_code");
    $arr["ProName"] = _post("pro_name");
    $arr["StudentId"] = _post("student_id");
    $arr["ShouldDays"] = _post("should_days");
    $arr["RealDays"] = _post("real_days");
    $arr["WorkDescribe"] = _post("describe");
    $arr["WriteDate"] = _post("write_date");
    $arr["WritePerson"] = $user["UserId"];
    $result = $info->insertInfo($arr);
    if ($result > 0) {
        $result = "添加成功";
    }
    echo returnResult($result, 1);
    exit();
} elseif (isset($_POST ["modify"])) {
    $info->setInfo(_post("id"));
    $arr = array();
    $arr["ProCode"] = _post("pro_code");
    $arr["ProName"] = _post("pro_name");
    $arr["StudentId"] = _post("student_id");
    $arr["ShouldDays"] = _post("should_days");
    $arr["RealDays"] = _post("real_days");
    $arr["WorkDescribe"] = _post("describe");
    $arr["WriteDate"] = _post("write_date");
    $result = $info->updateInfo($arr);
    if ($result > -1) {
        $result = "修改成功";
    } else {
        $result = "修改失败，请重试！";
    }

    echo returnResult($result, 1);
    exit();
}