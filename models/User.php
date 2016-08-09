<?php

class User extends Connect
{
    //顯示全部的明細
    function item()
    {
        $sql = "SELECT * FROM `bankSystem`";
        $result = $this->db->prepare($sql);
        $result->execute();
        foreach($result as $row){
            $id = $row['id'];
            $name = $row['name'];
            $expend = $row['expend'];
            $income = $row['income'];
            $total = $row['total'];
            $arrayitem[] = array("$id", "$name", "$expend", "$income", "$total");
        }
        return  $arrayitem;
    }
    
    //顯示餘額
    function showBalance()
    {
        $sql = ("SELECT * FROM `Balance`");
        $result = $this->db->prepare($sql);
        $result->execute();
        foreach($result as $row){
            $blalnce = $row['balance'];
            $arraybalance[] = array("$blalnce");
        }
        return  $arraybalance;
        
    }
    
    // 寫入存款金額與計算餘額
    function countIncome($incomemoney, $balanceNum)
    {
        try{

            $this->db->beginTransaction(); 

            //撈出餘額
            $sql = "SELECT * FROM `Balance` WHERE `id` = '1' FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            
            sleep(3);

            //存入明細表
            $sqlSave = "INSERT INTO `bankSystem` ( `name`, `income` ) VALUES ('apple', :incomemoney)";
            $result = $this->db ->prepare($sqlSave);
            $result->bindParam(":incomemoney", $incomemoney);
            $result->execute();

            //更新餘額
            $balanceNum = $balance + $incomemoney;
            $inBalanceData = $this->db->prepare("UPDATE `Balance` SET `balance` = :balanceNum WHERE `id` = '1'");
            $inBalanceData->bindParam(':balanceNum', $balanceNum);
            $inBalanceData->execute();
            
            $this->db->commit();

        } catch (Exception $err)
        {
            $this->db->rollBack();
            $msg = $err->getMessage();
        } 
    return $msg;
    }
    
    // 寫入出款金額與計算餘額
     function countExpend($expendmoney, $balanceNum)
    {
        try{

            $this->db->beginTransaction(); 

            //撈出餘額
            $sql = "SELECT * FROM `Balance` WHERE `id` = '1' FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            sleep(3);

            if($balance < $expendmoney) {
                throw new Exception("餘額不足");
            }

            //存入明細表
            $sql=("INSERT INTO `bankSystem` ( `name`, `expend`) VALUES ( 'apple', :expendmoney)");
            $result = $this->db->prepare($sql);
            $result->bindParam(":expendmoney", $expendmoney);
            $result->execute();
            $expendmoney = $_POST['expendmoney'];


            //更新餘額
            $balanceNum = $balance - $expendmoney;
            $inBalanceData = $this->db->prepare("UPDATE `Balance` SET `balance` = :balanceNum WHERE `id` = '1'");
            $inBalanceData->bindParam(':balanceNum', $balanceNum);
            $inBalanceData->execute();

            $this->db->commit();

        }catch (Exception $err)
        {
            $this->db->rollBack();
            $msg = $err->getMessage();
        } 
    return $msg;
    }
}