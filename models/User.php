<?php

class User extends Connect
{
    //回傳全部的明細
    function item()
    {
        $sql = "SELECT * FROM `bankSystem`";
        $result = $this->db->prepare($sql);
        $result->execute();
        foreach ($result as $row){
            $id = $row['id'];
            $name = $row['name'];
            $expend = $row['expend'];
            $income = $row['income'];
            $total = $row['total'];
            $nowTime = $row['nowTime'];
            $arrayItem[] = array ("$id", "$name", "$expend", "$income", "$total","$nowTime");
        }
        return  $arrayItem;
    }

    //回傳餘額
    function showBalance()
    {
        $sql = "SELECT * FROM `Balance`";
        $result = $this->db->prepare($sql);
        $result->execute();
        foreach ($result as $row){
            $blalnce = $row['balance'];
            $arrayBalance[] = array ("$blalnce");
        }
        return  $arrayBalance;
    }

    // 寫入存款金額與計算餘額
    function countIncome($incomeMoney, $balanceNum, $nowBalance, $now)
    {
        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d H:i:s");
        $incomeMoney = $_POST['incomemoney'];
        try {

            $this->db->beginTransaction();

            //撈出總共餘額
            $sql = "SELECT * FROM `Balance` WHERE `id` = '1' FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $nowBalance = $balance + $incomeMoney;

            //存入明細表
            $sqlSave = "INSERT INTO `bankSystem` ( `name`, `income`, `total`, `nowTime`) VALUES ('apple', :incomeMoney, :nowBalance, :now)";
            $result = $this->db ->prepare($sqlSave);
            $result->bindParam(":incomeMoney", $incomeMoney);
            $result->bindParam(":nowBalance", $nowBalance);
            $result->bindParam(":now", $now);
            $result->execute();

            //更新餘額
            $balanceNum = $balance + $incomeMoney;
            $inBalanceData = $this->db->prepare("UPDATE `Balance` SET `balance` = :balanceNum WHERE `id` = '1'");
            $inBalanceData->bindParam(':balanceNum', $balanceNum);
            $inBalanceData->execute();

            $this->db->commit();

        } catch (Exception $err) {
            $this->db->rollBack();
            $msg = $err->getMessage();
        }
        return $msg;
    }

    // 寫入出款金額與計算餘額
    function countExpend($expendMoney, $balanceNum, $nowBalance, $now)
    {
        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d H:i:s");
        $expendMoney = $_POST['expendmoney'];
        try {
            $this->db->beginTransaction();

            //撈出餘額
            $sql = "SELECT * FROM `Balance` WHERE `id` = '1' FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $nowBalance = $balance - $expendMoney;

            if ($balance < $expendMoney) {
                throw new Exception("餘額不足");
            }

            //存入明細表
            $sql="INSERT INTO `bankSystem` ( `name`, `expend`, `total`, `nowTime`) VALUES ( 'apple', :expendMoney, :nowBalance, :now)";
            $result = $this->db->prepare($sql);
            $result->bindParam(":expendMoney", $expendMoney);
            $result->bindParam(":now", $now);
            $result->bindParam(":nowBalance", $nowBalance);
            $result->execute();


            //更新餘額
            $balanceNum = $balance - $expendMoney;
            $inBalanceData = $this->db->prepare("UPDATE `Balance` SET `balance` = :balanceNum WHERE `id` = '1'");
            $inBalanceData->bindParam(':balanceNum', $balanceNum);
            $inBalanceData->execute();

            $this->db->commit();

        } catch (Exception $err) {
            $this->db->rollBack();
            $msg = $err->getMessage();
        }
        return $msg;
    }
}
