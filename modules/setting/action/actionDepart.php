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
require DT_ROOT . '/Class/DepartMentClass.php';
$info = new DepartMentClass();
$type = _post("type");
if ($type == "delete") {
    $info->setInfo(_post("id"));
    $arr = array();
    $arr["ProjectStatus"] = 4;
    $result = $info->updateInfo($arr);
    echo returnResult($result, 1);
    exit();
}
if ($type == "add") {
    $checkedNodes = _post("checkedNodes");
    $arr = array();
    $arr["DepartName"] = _post("depart_name");
    $arr["DepartDesc"] = _post("depart_desc");
    $arr["DepartMenu"] = $checkedNodes;
    $result = $info->insertInfo($arr);
    if ($result > 0) {
        $result = "添加成功";
    } else {
        $result = "修改失败，请重试！";
    }
    echo returnResult($result, 1);
    exit();
} elseif ($type == "modify") {
    $info->setInfo(_post("id"));
    $checkedNodes = _post("checkedNodes");
    $arr = array();
    $arr["DepartName"] = _post("depart_name");
    $arr["DepartDesc"] = _post("depart_desc");
    $arr["DepartMenu"] = $checkedNodes;
    $result = $info->updateInfo($arr);
    if ($result > -1) {
        $result = "修改成功";
    } else {
        $result = "修改失败，请重试！";
    }

    echo returnResult($result, 1);
    exit();
} 