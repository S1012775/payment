<?php

class User extends Connect{
    function item()
    {
        $sql=("SELECT * FROM `bankSystem`");
        $result = $this->db->prepare($sql);
        $result->execute();
        foreach($result as $row){
            $id=$row['id'];
            $name=$row['name'];
            $expend=$row['expend'];
            $income=$row['income'];
            $total=$row['total'];
            $arrayitem[]=array("$id","$name","$expend","$income","$total");
        }
        return  $arrayitem;
    }
    function showincome($income)
    {
        
            if($_POST['incomemoney']!= ""){
                $sql=("INSERT INTO `bankSystem` ( `name`, `income` ) VALUES ('apple', :income)");
                $result =$this->db ->prepare($sql);
                $result->bindParam(":income",$income);
                $result->execute(); 
                return "<script>alert('資料送出');</script>";
            }else{
                return "<script>alert('不可有空白');</script>";
            }
            
    }
    function showexpend($expend)
    {
         if($_POST['expendmoney']!=""){
            $sql=("INSERT INTO `bankSystem` ( `name`, `expend`) VALUES ( 'apple', :expend)");
            $result = $this->db->prepare($sql);
            $result->bindParam(":expend",$expend);
            $result->execute();  
            return "<script>alert('資料送出');</script>";
            }else{
                return "<script>alert('不可有空白');</script>";
            }
    }
    function showbalance()
    {
        $sql=("SELECT * FROM `Balance`");
        $result = $this->db->prepare($sql);
        $result->execute();
        foreach($result as $row){
            $blalnce=$row['balance'];
            $arraybalance[]=array("$blalnce");
        }
        return  $arraybalance;
        
    }
    function countbalance()
    {
        if($_POST['incomemoney']!= "" || $_POST['expendmoney']!="")
        {
            
        }
        try
        {
            $this->db->beginTransaction(); 
            
            sleep(3);
            
            $sql="SELECT * FROM `Balance` WHERE `id` = '1' FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $count = $stmt->fetch();
            $blalnce=$count['balance'];
            $incomemoney=$_POST['incomemoney'];
            $expendmoney=$_POST['expendmoney'];
            
            if($blalnce <$expendmoney){
                throw new Exception("餘額不足");
            }
            
            $sql="UPDATE `Balance` SET `balance` = balance -'expendmoney'+'incomemoney'   WHERE `id` = '1' " ; 
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute()){
                throw new Exception("更新失敗");
            }else{
                throw new Exception("更新成功");
            }
             $this->db->commit();
            
        }catch (Exception $err)
        {
            $this->db->rollBack();
            $msg = $err->getMessage();
        } 
    return $msg;
    }
}

?>