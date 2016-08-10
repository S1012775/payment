<?php

class HomeController extends Controller
{
    function index()
    {
        $this->view("choose");
    }

    function item()
    {
        $name = $_POST['searchName'];
        $browseItem = $this->model("User");
        $item = $browseItem->item($name);
        $balance = $browseItem->showBalance($name);
        $data[] = $item;
        $data[] = $balance;

        $this->view("index", $data);

    }

    function btIncome()
    {
        $name = $_POST['searchName'];
        $incomeMoney = $_POST['incomemoney'];
        $browseItem = $this->model("User");
        $countBalance = $browseItem->countIncome($incomeMoney, $updateBalabce, $nowBalance, $now, $name);
        $this->view("echo", $countBalance);
        header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
    }

    function btExpend()
    {
        //支出
        $name = $_POST['searchName'];
        $expendMoney = $_POST['expendmoney'];
        $browseItem = $this->model("User");
        $countExpend = $browseItem->countExpend($expendMoney, $updateBalabce, $nowBalance, $now, $name);
        $this->view("echo", $countExpend);
        header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
    }
}
