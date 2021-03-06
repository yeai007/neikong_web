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
require("../../common.php");
require DT_ROOT . '/Class/ContractClass.php';
$info = new ContractClass();
$type = _post("type");
if ($type == "delete") {
    $info->setInfo(_post("id"));
    $arr = array();
    $arr["ContractStatus"] = 1;
    $result = $info->updateInfo($arr);
    echo returnResult($result, 1);
    exit();
}
if (isset($_POST ["add"])) {
    $arr = array();
    $arr["ContractCode"] = _post("contract_code");
    $arr["ContractName"] = _post("contract_name");
    $arr["ContractCustomerId"] = _post("customer_id");
    $arr["ContractCustomerName"] = _post("contract_customer_name");
    $arr["ContractSub"] = _post("contract_sub");
    $arr["ContractAmount"] = _post("contract_amount");
    $arr["ContractLimitDate"] = _post("contract_limit_date");
    $arr["ContractIntroduct"] = _post("contract_introduct");
    $arr["ContractSignDate"] = _post("contract_signdate");
    $arr["WritePersonId"] = $user["UserId"];
    $arr["WriteDate"] = _post("writedate");
    $result = $info->insertInfo($arr);
    if ($result > 0) {
        $result = "添加成功";
    }
    echo returnResult($result, 1);
    exit();
} elseif (isset($_POST ["modify"])) {
    $info->setInfo(_post("id"));
    $arr = array();
    $arr["ContractCode"] = _post("contract_code");
    $arr["ContractName"] = _post("contract_name");
    $arr["ContractCustomerId"] = _post("customer_id");
    $arr["ContractCustomerName"] = _post("contract_customer_name");
    $arr["ContractSub"] = _post("contract_sub");
    $arr["ContractAmount"] = _post("contract_amount");
    $arr["ContractLimitDate"] = _post("contract_limit_date");
    $arr["ContractIntroduct"] = _post("contract_introduct");
    $arr["ContractSignDate"] = _post("contract_signdate");
    $result = $info->updateInfo($arr);
    if ($result > -1) {
        $result = "修改成功";
    } else {
        $result = "修改失败，请重试！";
    }

    echo returnResult($result, 1);
    exit();
}