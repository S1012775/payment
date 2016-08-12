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
    public function countBalance($money, $add, $reduce, $now, $name, $withdrawal, $deposit, $version)
    {
        date_default_timezone_set('Asia/Taipei');
        $now = date("Y-m-d H:i:s");

        try {
            $this->db->beginTransaction();

            //撈出總共餘額
            $sql = "SELECT * FROM `Balance` WHERE `name` = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $count = $stmt->fetch();
            $balance = $count['balance'];
            $version = $count['version'];
            $add = $balance + $money;
            $reduce = $balance - $money;
            //判斷出款或是存款
            if ($deposit == "deposit") {
                $sql = "UPDATE `Balance` SET `balance` = :balance, `version` = `version` + 1
                    WHERE `name` = :name && `version` = :version";
                $result = $this->db->prepare("$sql");
                $result->bindParam(':balance', $add);
                $result->bindParam(':name', $name);
                $result->bindParam(':version', $version);

                if (!$result->execute()) {
                    throw new Exception("更新失敗");
                }

                $sql = "INSERT INTO `bankSystem` (`name`, `income`, `total`, `nowTime`)
                  VALUES (:name, :money, :balance, :now)";
                $result = $this->db ->prepare($sql);
                $result->bindParam(':name', $name);
                $result->bindParam(':money', $money);
                $result->bindParam(':balance', $add);
                $result->bindParam(':now', $now);
                $result->execute();

            } elseif ($withdrawal == "withdrawal") {
                if ($balance < $money) {
                    throw new Exception("餘額不足");
                }

                $sql = "UPDATE `Balance` SET `balance` = :balance, `version` = `version` + 1
                        WHERE `name` = :name && `version` = :version";
                $result = $this->db->prepare("$sql");
                $result->bindParam(':balance', $reduce);
                $result->bindParam(':name', $name);
                $result->bindParam(':version', $version);

                if (!$result->execute()) {
                    throw new Exception("更新失敗");
                }

                $sql = "INSERT INTO `bankSystem` (`name`, `expend`, `total`, `nowTime`)
                        VALUES (:name, :money, :balance, :now)";
                $result = $this->db->prepare($sql);
                $result->bindParam(':money', $money);
                $result->bindParam(':now', $now);
                $result->bindParam(':balance', $reduce);
                $result->bindParam(':name', $name);
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
