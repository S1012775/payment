<?php
mb_internal_encoding('utf-8');
class HomeController extends Controller
{
    function item()
    {
        $browseitem = $this->model("User");
        // 顯示明細項目
        $item = $browseitem->item();
        $balance = $browseitem->showBalance();
        $data[] = $item;
        $data[] = $balance;

            //收入
        if (isset($_POST['addincome'])) {
            $incomemoney = $_POST['incomemoney'];
            $countbalance = $browseitem->countIncome($incomemoney, $balanceNum);
            $this->view("echo", $countbalance);
            header("location:/EasyMVC/Home/item");
        }
            //支出
        if (isset($_POST['expend'])) {
            $expendmoney = $_POST['expendmoney'];
            $countexpend=$browseitem->countExpend($balanceNum, $expendmoney);
            $this->view("echo",$countexpend);
            header("location:/EasyMVC/Home/item");
        }
        $this->view("index", $data);
    }

}