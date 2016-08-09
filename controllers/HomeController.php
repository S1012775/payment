<?php

class HomeController extends Controller
{
    
    function item()
    {
        $browseitem = $this->model("User");
       
            //顯示明細項目
        $item=$browseitem->item();
        $balance=$browseitem->showbalance();
        $data[]=$item;
        $data[]=$balance;
        
            //收入
        if(isset($_POST['addincome'])){
            $income= $_POST['incomemoney'];
            $countbalance=$browseitem->countbalance();
            $reslut=$browseitem->showincome($income);
            $this->view("echo",$countbalance,$reslut);
        }
            //支出
         if(isset($_POST['expend'])){
            $expend=$_POST['expendmoney'];
            $countbalance=$browseitem->countbalance();
            $reslut=$browseitem->showexpend($expend);
            $this->view("echo",$countbalance,$reslut);
        }
         $this->view("index",$data);
         
         
    }
    
}

?>
