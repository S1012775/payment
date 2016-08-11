<?php

class User extends Connect
{
    public function getAllDetial($name)
    {
        $sql = "SELECT * FROM `bankSystem` WHERE `name` = :name";
        $result = $this->db->prepare($sql);
        $result->bindParam(":name", $name);
        $result->execute();

        foreach ($result as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $expend = $row['expend'];
            $income = $row['income'];
            $total = $row['total'];
            $nowTime = $row['nowTime'];
            $arrayItem[] = array("$id", "$name", "$expend", "$income", "$total","$nowTime");
        }

        return $arrayItem;
    }

    public function getBalance($name)
    {
        $sql = "SELECT * FROM `Balance` WHERE `name` = :name";
        $result = $this->db->prepare($sql);
        $result->bindParam(":name", $name);
        $result->execute();

        foreach ($result as $row) {
            $blalnce = $row['balance'];
            $arrayBalance[] = array("$blalnce");
        }

        return $arrayBalance;
    }

    // 寫入存款金額與計算餘額
    function countIncome($money, $updateBalabce, $nowBalance, $now, $name)
    {
        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d H:i:s");

        try {
            $this->db->beginTransaction();

            //撈出總共餘額
            $sql = "SELECT * FROM `Balance` WHERE `name` = :name FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $addBalance = $balance + $money;


            //存入明細表
            $sql = "INSERT INTO `bankSystem` (`name`, `income`, `total`, `nowTime`)
                        VALUES (:name, :money, :balance, :now)";
            $result = $this->db ->prepare($sql);
            $result->bindParam(":name", $name);
            $result->bindParam(":money", $money);
            $result->bindParam(":balance", $addBalance);
            $result->bindParam(":now", $now);
            $result->execute();

            //更新餘額
            $updateBalabce = $balance + $money;
            $result = $this->db->prepare("UPDATE `Balance` SET `balance` = :balance WHERE `name` = :name");
            $result->bindParam(':balance', $updateBalabce);
            $result->bindParam(":name", $name);
            $result->execute();

            $this->db->commit();

        } catch (Exception $err) {
            $this->db->rollBack();
            $msg = $err->getMessage();
        }

        return $msg;
    }

    // 寫入出款金額與計算餘額
    function countExpend($money, $updateBalabce, $nowBalance, $now, $name)
    {
        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d H:i:s");

        try {
            $this->db->beginTransaction();

            //撈出餘額
            $sql = "SELECT * FROM `Balance` WHERE `name` = :name FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $nowBalance = $balance - $money;

            if ($balance < $money) {
                throw new Exception("餘額不足");
            }

            //存入明細表
            $sql="INSERT INTO `bankSystem` ( `name`, `expend`, `total`, `nowTime`)
                    VALUES (:name, :money, :balance, :now)";
            $result = $this->db->prepare($sql);
            $result->bindParam(":money", $money);
            $result->bindParam(":now", $now);
            $result->bindParam(":balance", $nowBalance);
            $result->bindParam(":name", $name);
            $result->execute();

            //更新餘額
            $updateBalabce = $balance - $money;
            $result = $this->db->prepare("UPDATE `Balance` SET `balance` = :balance WHERE `name` = :name");
            $result->bindParam(':balance', $updateBalabce);
            $result->bindParam(":name", $name);
            $result->execute();

            $this->db->commit();

        } catch (Exception $err) {
            $this->db->rollBack();
            $msg = $err->getMessage();
        }

        return $msg;
    }
}
