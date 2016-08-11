<?php

class User extends Connect
{
    public function getAllDetial($name)
    {
        $sql = "SELECT * FROM `bankSystem` WHERE `name` = :name";
        $result = $this->db->prepare($sql);
        $result->bindParam(":name", $name);
        $result->execute();
        $detial = $result->fetchAll(PDO::FETCH_ASSOC);

        return $detial;
    }

    public function getBalance($name)
    {
        $sql = "SELECT * FROM `Balance` WHERE `name` = :name";
        $result = $this->db->prepare($sql);
        $result->bindParam(":name", $name);
        $result->execute();
        $balance = $result->fetchAll(PDO::FETCH_ASSOC);

        return $balance;
    }

    // 寫入存款金額與計算餘額
    public function countBalance($money, $update, $add, $reduce, $now, $name, $withdrawal, $deposit)
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
            $add = $balance + $money;
            $reduce = $balance - $money;

            if ($balance < $money) {
                throw new Exception("餘額不足");
            }

            //判斷出款或是存款
            if ($deposit == "deposit") {
                $sql = "INSERT INTO `bankSystem` (`name`, `income`, `total`, `nowTime`)
                            VALUES (:name, :money, :balance, :now)";
                $result = $this->db ->prepare($sql);
                $result->bindParam(":name", $name);
                $result->bindParam(":money", $money);
                $result->bindParam(":balance", $add);
                $result->bindParam(":now", $now);
                $result->execute();

                $update = $balance + $money;
                $result = $this->db->prepare("UPDATE `Balance` SET `balance` = :balance WHERE `name` = :name");
                $result->bindParam(':balance', $update);
                $result->bindParam(":name", $name);
                $result->execute();
            } elseif ($withdrawal == "withdrawal") {
                $sql="INSERT INTO `bankSystem` ( `name`, `expend`, `total`, `nowTime`)
                    VALUES (:name, :money, :balance, :now)";
                $result = $this->db->prepare($sql);
                $result->bindParam(":money", $money);
                $result->bindParam(":now", $now);
                $result->bindParam(":balance", $reduce);
                $result->bindParam(":name", $name);
                $result->execute();

                $update = $balance - $money;
                $result = $this->db->prepare("UPDATE `Balance` SET `balance` = :balance WHERE `name` = :name");
                $result->bindParam(':balance', $update);
                $result->bindParam(":name", $name);
                $result->execute();
            }

            $this->db->commit();

        } catch (Exception $err) {
            $this->db->rollBack();
            $msg = $err->getMessage();
        }

        return $msg;
    }
}
