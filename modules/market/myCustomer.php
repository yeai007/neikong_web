<?php

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
require (DT_ROOT . "/data/dbClass.php");
$data = array();
$customerlevel = "select Id,LevelCode,LevelName from CustomerLevelInfo ";
$data["customerlevel"] = $db->query($customerlevel);
$PerformanceLevel = "select Id,PerformanceLevelName,PerformanceLevelCode from PerformanceLevelInfo ";
$data["PerformanceLevel"] = $db->query($PerformanceLevel);
$market = "select UserId,UserName,UserCode from Users where UserRoleId=1";
$data["market"] = $db->query($market);
//$customerlist = "select CustomerId,CustomerName,Customerlevel,CreditCode,CustomerAddress,CustomerPhone,OpenBank,BankAccount,PerformanceLevel,
//ChargePerson,DATE_FORMAT(WriteDate,'%Y-%m-%e') WriteDate,CustomerStatus,VisitCount,MarketPerson ,b.PerformanceLevelCode,b.PerformanceLevelName,c.LevelCode,c.LevelName
//from customerinfo a
//left join performancelevelinfo b on a.PerformanceLevel=b.Id
//left join customerlevelinfo c on a.Customerlevel=c.Id where a.Flag=0";
//$data["customerlist"] = $db->query($customerlist);
echo $twig->render('market/my_customer.twig', $data);
