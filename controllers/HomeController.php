<?php

class HomeController extends Controller
{
    function index()
    {
        $this->view("choose");
    }

    function btAction()
    {
        if(isset($_POST['expend'])) {
            $name = $_POST['searchName'];
            $money = $_POST['money'];
            $browseItem = $this->model("User");
            $countBalance = $browseItem->countIncome($money, $updateBalabce, $nowBalance, $now, $name);
            $this->view("echo", $countBalance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if(isset($_POST['income'])) {
            $name = $_POST['searchName'];
            $money = $_POST['money'];
            $browseItem = $this->model("User");
            $countBalance = $browseItem->countIncome($money, $updateBalabce, $nowBalance, $now, $name);
            $this->view("echo", $countBalance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if(isset($_POST['btSearch'])) {
            $name = $_POST['searchName'];
            $browseItem = $this->model("User");
            $item = $browseItem->item($name);
            $balance = $browseItem->showBalance($name);
            $data[] = $item;
            $data[] = $balance;

            $this->view("index", $data);
        }
    }
}
