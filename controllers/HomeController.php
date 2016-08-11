<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->view("choose");
    }

    public function btAction()
    {
        $name = $_POST['searchName'];
        $money = $_POST['money'];
        $browseDetial = $this->model("User");

        if (isset($_POST['expend'])) {
            $countBalance = $browseDetial->countExpend($money, $updateBalabce, $nowBalance, $now, $name);

            $this->view("echo", $countBalance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if (isset($_POST['income'])) {
            $countBalance = $browseDetial->countIncome($money, $updateBalabce, $nowBalance, $now, $name);

            $this->view("echo", $countBalance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if (isset($_POST['btSearch'])) {
            $item = $browseDetial->getAllDetial($name);
            $balance = $browseDetial->getBalance($name);
            $data[] = $item;
            $data[] = $balance;

            $this->view("index", $data);
        }
    }
}
