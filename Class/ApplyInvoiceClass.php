                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ApplyInvoiceClass {

    private $Id; //
    private $ProCode; //项目编码
    private $ProName; //项目名称
    private $UnitId; //单位ID
    private $UnitName; //单位名称
    private $ReceiveAmount; //应收款金额
    private $InvoicedAmount; //已开票金额
    private $PaidAmount; //已收款金额
    private $ThisAmount; //本次申请开票金额
    private $InvoiceSubId; //
    private $InvoiceSub; //开票主体
    private $Market; //单位所属市场人员
    private $ThisDesc; //说明
    private $InvoiceType; //申请开票类型
    private $InvoiceContent; //申请开票内容
    private $Applicant; //申请人
    private $ApplicationTime; //申请时间
    private $Enclosure; //附件
    private $InvoiceStatus; //状态
    private $ThisStudentIds; //本次申请开票学员列表

    public function __construct() {
        require (DT_ROOT . "/data/dbClass.php"); //包含配置信息.
        $this->db = $db;
        $this->columns = $this->db->getColumn("applyinvoice", null);
    }

    function getInfo($id) {
        $sql = "select a.Id, a.ProCode, a.ProName, a.UnitId, a.UnitName, a.ReceiveAmount, a.InvoicedAmount, a.PaidAmount, a.ThisAmount,
 a.InvoiceSubId, a.InvoiceSub, a.Market, a.ThisDesc, a.InvoiceType, 
a.InvoiceContent, a.Applicant, a.ApplicationTime, a.Enclosure, a.InvoiceStatus, a.ThisStudentIds,
b.CreditCode CustomerCreditCode,b.CustomerAddress,b.CustomerPhone,b.OpenBank CustomerOpenBank,b.BankAccount CustomerBankAccount,
c.CreditCode OrgCreditCode,c.OrgAddress OrgOrgAddress,c.OrgPhone OrgOrgPhone,c.OpenBank OrgOpenBank,c.BankAccount OrgBankAccount
,e.`Name` SubTrainingName,f.`Name` SubTypeName
from applyinvoice a
left join customerinfo b on a.UnitId=b.CustomerId
left join organization c on a.InvoiceSub=c.OrgName
left join projectsinfo d on a.ProCode=d.ProjectCode
left join projecttype e on d.SubTraining=e.Id
left join projecttype f on d.SubType=f.Id where a.Id=$id limit 0,1";
        $result = $this->db->row($sql); //返回查询结果到数组
        $condition = $result["ThisStudentIds"];
        $result["rmb"] = $this->num_to_rmb($result["ThisAmount"]);
        $stu_sql = "select * from studentinfo where Id in ($condition)";
        $result["studentinfo"] = $this->db->query($stu_sql);

        return $result;
    }

    function setInfo($id) {
        $sql = "select * from applyinvoice where Id=$id";
        $result = $this->db->row($sql); //返回查询结果到数组
        foreach ($this->columns as $column) {
            $aa = "set" . "$column";
            $this->$aa($result["$column"]);
        }
        return $result;
    }

    function updateInfo($param) {
        $condition = '';
        foreach ($this->columns as $column) {
            if (isset($param[$column])) {
                if (empty($condition)) {
                    $condition = $column . "='" . $param[$column] . "'";
                } else {
                    $condition = $condition . "," . $column . "='" . $param[$column] . "'";
                }
            }
        }
        $sql = "update applyinvoice set $condition where Id=$this->Id";
        return $this->db->query($sql);
    }

    function insertInfo($param) {
        $condition = '';
        foreach ($this->columns as $column) {
            if (isset($param[$column])) {
                if (empty($condition)) {
                    $condition = $column . "='" . $param[$column] . "'";
                } else {
                    $condition = $condition . "," . $column . "='" . $param[$column] . "'";
                }
            }
        }
        $sql = "insert into applyinvoice set $condition ";
        $this->db->query($sql);
        // return $sql;
        return $this->db->lastInsertId();
    }

    function getId() {
        return $this->Id;
    }

    function getProCode() {
        return $this->ProCode;
    }

    function getProName() {
        return $this->ProName;
    }

    function getUnitId() {
        return $this->UnitId;
    }

    function getUnitName() {
        return $this->UnitName;
    }

    function getReceiveAmount() {
        return $this->ReceiveAmount;
    }

    function getInvoicedAmount() {
        return $this->InvoicedAmount;
    }

    function getPaidAmount() {
        return $this->PaidAmount;
    }

    function getThisAmount() {
        return $this->ThisAmount;
    }

    function getInvoiceSubId() {
        return $this->InvoiceSubId;
    }

    function getInvoiceSub() {
        return $this->InvoiceSub;
    }

    function getMarket() {
        return $this->Market;
    }

    function getThisDesc() {
        return $this->ThisDesc;
    }

    function getInvoiceType() {
        return $this->InvoiceType;
    }

    function getInvoiceContent() {
        return $this->InvoiceContent;
    }

    function getApplicant() {
        return $this->Applicant;
    }

    function getApplicationTime() {
        return $this->ApplicationTime;
    }

    function getEnclosure() {
        return $this->Enclosure;
    }

    function getInvoiceStatus() {
        return $this->InvoiceStatus;
    }

    function getThisStudentIds() {
        return $this->ThisStudentIds;
    }

    function setId($Id) {
        $this->Id = $Id;
        return $this;
    }

    function setProCode($ProCode) {
        $this->ProCode = $ProCode;
        return $this;
    }

    function setProName($ProName) {
        $this->ProName = $ProName;
        return $this;
    }

    function setUnitId($UnitId) {
        $this->UnitId = $UnitId;
        return $this;
    }

    function setUnitName($UnitName) {
        $this->UnitName = $UnitName;
        return $this;
    }

    function setReceiveAmount($ReceiveAmount) {
        $this->ReceiveAmount = $ReceiveAmount;
        return $this;
    }

    function setInvoicedAmount($InvoicedAmount) {
        $this->InvoicedAmount = $InvoicedAmount;
        return $this;
    }

    function setPaidAmount($PaidAmount) {
        $this->PaidAmount = $PaidAmount;
        return $this;
    }

    function setThisAmount($ThisAmount) {
        $this->ThisAmount = $ThisAmount;
        return $this;
    }

    function setInvoiceSubId($InvoiceSubId) {
        $this->InvoiceSubId = $InvoiceSubId;
        return $this;
    }

    function setInvoiceSub($InvoiceSub) {
        $this->InvoiceSub = $InvoiceSub;
        return $this;
    }

    function setMarket($Market) {
        $this->Market = $Market;
        return $this;
    }

    function setThisDesc($ThisDesc) {
        $this->ThisDesc = $ThisDesc;
        return $this;
    }

    function setInvoiceType($InvoiceType) {
        $this->InvoiceType = $InvoiceType;
        return $this;
    }

    function setInvoiceContent($InvoiceContent) {
        $this->InvoiceContent = $InvoiceContent;
        return $this;
    }

    function setApplicant($Applicant) {
        $this->Applicant = $Applicant;
        return $this;
    }

    function setApplicationTime($ApplicationTime) {
        $this->ApplicationTime = $ApplicationTime;
        return $this;
    }

    function setEnclosure($Enclosure) {
        $this->Enclosure = $Enclosure;
        return $this;
    }

    function setInvoiceStatus($InvoiceStatus) {
        $this->InvoiceStatus = $InvoiceStatus;
        return $this;
    }

    function setThisStudentIds($ThisStudentIds) {
        $this->ThisStudentIds = $ThisStudentIds;
        return $this;
    }

    function num_to_rmb($num) {
        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角元拾佰仟万拾佰仟亿";
        //精确到分后面就不要了，所以只留两个小数位
        $num = round($num, 2);
        //将数字转化为整数
        $num = $num * 100;
        if (strlen($num) > 10) {
            return "金额太大，请检查";
        }
        $i = 0;
        $c = "";
        while (1) {
            if ($i == 0) {
                //获取最后一位数字
                $n = substr($num, strlen($num) - 1, 1);
            } else {
                $n = $num % 10;
            }
            //每次将最后一位数字转化为中文
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            //去掉数字最后一位了
            $num = $num / 10;
            $num = (int) $num;
            //结束循环
            if ($num == 0) {
                break;
            }
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            //utf8一个汉字相当3个字符
            $m = substr($c, $j, 6);
            //处理数字中很多0的情况,每次循环去掉一个汉字“零”
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j - 3;
                $slen = $slen - 3;
            }
            $j = $j + 3;
        }
        //这个是为了去掉类似23.0中最后一个“零”字
        if (substr($c, strlen($c) - 3, 3) == '零') {
            $c = substr($c, 0, strlen($c) - 3);
        }
        //将处理的汉字加上“整”
        if (empty($c)) {
            return "零元整";
        } else {
            return $c . "整";
        }
    }

}
