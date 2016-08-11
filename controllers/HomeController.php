<?php

class HomeController extends Controller
{
    function index()
    {
        $this->view("choose");
    }

    function btAction()
    {
        $name = $_POST['searchName'];
        $money = $_POST['money'];
        $browseItem = $this->model("User");

        if (isset($_POST['expend'])) {
            $countBalance = $browseItem->countExpend($money, $updateBalabce, $nowBalance, $now, $name);

            $this->view("echo", $countBalance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if (isset($_POST['income'])) {
            $countBalance = $browseItem->countIncome($money, $updateBalabce, $nowBalance, $now, $name);

            $this->view("echo", $countBalance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if (isset($_POST['btSearch'])) {
            $item = $browseItem->getAllDetial($name);
            $balance = $browseItem->getBalance($name);
            $data[] = $item;
            $data[] = $balance;

            $this->view("index", $data);
        }
    }
}
