<?php

class User extends Connect{
    function item(){
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
    
}

?>