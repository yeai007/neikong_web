<?php

/**
 * @author  PVer
 * @date    2018-4-16 17:49:23
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
$userid = $user["UserId"];
require( "../../../common.php");
require (DT_ROOT . "/data/dbClass.php");
$pagetype = _post("pagetype");
$data = array();
$list = "select bb.Id,aa.*,(aa.ReimAmount+aa.HeadMasterAmount) ZCAmount,(aa.ApplyAmount-aa.ReimAmount-aa.HeadMasterAmount) MAmount ,
bb.KnotDate,bb.KnotPerson,bb.KnotPersonId,bb.`Status`
from (select a.ProjectId,a.ProjectCode,a.ProjectName,
(select sum(ChargeAmount)  from studentinfo where ProjectCode =a.ProjectCode) ReceiveAmount,
(select sum(ThisAmount) from applyinvoice where ProCode=a.ProjectCode) ApplyAmount,
(select sum(Amount) from projectknotex where  ProCode=a.ProjectCode) ReimAmount,
(select sum(AchAmount) from headermasterach where  ProCode=a.ProjectCode) HeadMasterAmount,
(select count(*) from studentinfo where ProjectCode=a.ProjectCode) StuCount
from projectsinfo a) aa
left join projectknot bb on aa.ProjectCode=bb.ProCode";
$data["list"] = $db->query($list);
$data["json_list"] = json_encode($data["list"]);
$data["pagetype"] = $pagetype;
echo $twig->render('settlement/project_knot_list.twig', $data);

