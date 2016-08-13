<?php

class User extends Connect
{
    public function getAllDetial($name)
    {
        $sql = "SELECT * FROM `bankSystem` WHERE `name` = :name";
        $result = $this->db->prepare($sql);
        $result->bindParam(':name', $name);
        $result->execute();

        return $result->fetchAll();
    }

    public function getBalance($name)
    {
        $sql = "SELECT * FROM `Balance` WHERE `name` = :name";
        $result = $this->db->prepare($sql);
        $result->bindParam(':name', $name);
        $result->execute();

        return $result->fetchAll();
    }

    // 寫入存款金額與計算餘額
    public function countBalance($update, $now, $name, $withdrawal, $deposit, $money)
    {
        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d H:i:s");

        try {
            $this->db->beginTransaction();

            //撈出總共餘額
            $sql = "SELECT * FROM `Balance` WHERE `name` = :name FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $update = $balance + $money;

            if ($balance < $money) {
                throw new Exception("餘額不足");
            }

            $sql = "UPDATE `Balance` SET `balance` = :balance WHERE `name` = :name";
            $result = $this->db->prepare("$sql");
            $result->bindParam(':balance', $update);
            $result->bindParam(':name', $name);
            $result->execute();

            $sql = "INSERT INTO `bankSystem` (`name`, `expend`, `income`, `total`, `nowTime`)
              VALUES (:name, :expend, :income, :balance, :now)";
            $result = $this->db ->prepare($sql);
            $result->bindParam(':name', $name);
            $result->bindParam(':expend', $withdrawal);
            $result->bindParam(':income', $deposit);
            $result->bindParam(':balance', $update);
            $result->bindParam(':now', $now);
            $result->execute();

            $this->db->commit();

        } catch (Exception $err) {
            $this->db->rollBack();
            $msg = $err->getMessage();
        }

        return $msg;
    }
}
