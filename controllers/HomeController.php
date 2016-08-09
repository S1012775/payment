<?php

class HomeController extends Controller
{
    function item()
    {
        $browseItem = $this->model("User");
        $item = $browseItem->item();
        $balance = $browseItem->showBalance();
        $data[] = $item;
        $data[] = $balance;

        //收入
        if (isset($_POST['addincome'])) {
            $incomeMoney = $_POST['incomemoney'];
            $countBalance = $browseItem->countIncome($incomeMoney, $balanceNum);
            $this->view("echo", $countBalance);
            header("location:/bankSystem/Home/item");
        }

        //支出
        if (isset($_POST['expend'])) {
            $expendMoney = $_POST['expendmoney'];
            $countExpend = $browseItem->countExpend($balanceNum, $expendmoney);
            $this->view("echo", $countExpend);
            header("location:/bankSystem/Home/item");
        }

        $this->view("index", $data);
    }
}
