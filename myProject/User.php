<?php

require_once 'Connect.php';

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
    public function countDeposit($money, $add, $now, $name)
    {
        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d H:i:s");

        try {
            $this->db->beginTransaction();

            $sql = "SELECT * FROM `Balance` WHERE `name` = :name FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $add = $balance + $money;

            $sql = "UPDATE `Balance` SET `balance` = :balance WHERE `name` = :name";
            $result = $this->db->prepare("$sql");
            $result->bindParam(':balance', $add);
            $result->bindParam(':name', $name);

            $sql = "INSERT INTO `bankSystem` (`name`, `income`, `total`, `nowTime`)
              VALUES (:name, :money, :balance, :now)";
            $result = $this->db ->prepare($sql);
            $result->bindParam(':name', $name);
            $result->bindParam(':money', $money);
            $result->bindParam(':balance', $add);
            $result->bindParam(':now', $now);
            $result->execute();

            $this->db->commit();


        } catch (Exception $err) {
            $this->db->rollBack();
            $msg = $err->getMessage();
        }

        return $msg;
    }

    public function countWithdrawal($money, $reduce, $now, $name)
    {
        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d H:i:s");

            $this->db->beginTransaction();

            //撈出總共餘額
            $sql = "SELECT * FROM `Balance` WHERE `name` = :name FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $reduce = $balance - $money;

            $sql = "UPDATE `Balance` SET `balance` = :balance WHERE `name` = :name";
            $result = $this->db->prepare("$sql");
            $result->bindParam(':balance', $reduce);
            $result->bindParam(':name', $name);

            $sql = "INSERT INTO `bankSystem` (`name`, `expend`, `total`, `nowTime`)
                    VALUES (:name, :money, :balance, :now)";
            $result = $this->db->prepare($sql);
            $result->bindParam(':money', $money);
            $result->bindParam(':now', $now);
            $result->bindParam(':balance', $reduce);
            $result->bindParam(':name', $name);
            $result->execute();

            $this->db->commit();

        }

    public function noMoney($money, $name)
    {
        try {
            $this->db->beginTransaction();

            //撈出總共餘額
            $sql = "SELECT * FROM `Balance` WHERE `name` = :name FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $reduce = $balance - $money;

            if ($balance < $money || $money = 0) {
                throw new Exception("餘額不足");
            }

            $this->db->commit();

        } catch (Exception $err) {
            $this->db->rollBack();
            $msg = $err->getMessage();
        }

        return $msg;
    }
}
