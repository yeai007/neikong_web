<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require( "../../common.php");
require (DT_ROOT . "/data/dbClass.php");
$data = array();
$data = array();
$readonly = false;
$data["btn"] = "add";
$chargeperson = "select UserId,UserName,UserCode,UserDepart from users";
$data["chargeperson"] = $db->query($chargeperson);
$data["marketperson"] = $db->query($chargeperson);
$request_id = _post("id");
$request_type = _post("type");
if (isset($request_id) && $request_id > 0 && isset($request_type)) {
    if ($request_type == "see") {
        require DT_ROOT . '/Class/CustomerClass.php';
        $info = new CustomerClass();
        $result = $info->getInfo($request_id);
        $data["info"] = $result;
        $data["btn"] = "see";
        $readonly = "disabled='disabled'";
    } elseif ($request_type == "modify") {
        require DT_ROOT . '/Class/CustomerClass.php';
        $info = new CustomerClass();
        $result = $info->getInfo($request_id);
        $data["info"] = $result;
        $data["btn"] = "modify";
    } elseif ($request_type == "delete") {
        require DT_ROOT . '/Class/CustomerClass.php';
        $info = new CustomerClass();
        $result = $info->getInfo($request_id);
        $data["info"] = $result;
    }
}

$data["readonly"] = $readonly;
echo $twig->render('market/setcustomer.html', $data);
