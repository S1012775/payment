<?php

class HomeController extends Controller
{
    //搜尋帳號明細
    function item()
    {
        $searchName = $_POST['searchName'];
        $browseItem = $this->model("User");
        $item = $browseItem->item();
        $balance = $browseItem->showBalance();
        $data[] = $item;
        $data[] = $balance;

        $this->view("index", $data);
    }

    function btIncome()
    {
        //收入
        if (isset($_POST['addincome'])) {
            $browseItem = $this->model("User");
            $countBalance = $browseItem->countIncome($incomeMoney, $balanceNum,  $nowBalance, $now);
            $this->view("echo", $countBalance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/item");
        }
    }

    function btExpend()
    {
        //支出
        if (isset($_POST['expend'])) {
            $browseItem = $this->model("User");
            $countExpend = $browseItem->countExpend($balanceNum, $expendmoney, $nowBalance, $now);
            $this->view("echo", $countExpend);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/item");
        }
    }
}
