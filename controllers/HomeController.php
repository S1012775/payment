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
        $detial = $this->model("User");

        if (isset($_POST['expend'])) {
            $withdrawal = $_POST['money'];
            $deposit = 0;
            $money = $withdrawal;
            $balance = $detial->countBalance($update, $now, $name, $withdrawal, $deposit, - $money);

            $this->view("echo", $balance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if (isset($_POST['income'])) {
            $deposit = $_POST['money'];
            $withdrawal = 0;
            $money = $deposit;
            $balance = $detial->countBalance($update, $now, $name, $withdrawal, $deposit, $money);

            $this->view("echo", $balance);
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if (isset($_POST['btSearch'])) {
            $item = $detial->getAllDetial($name);
            $balance = $detial->getBalance($name);
            $data[] = $item;
            $data[] = $balance;

            $this->view("index", $data);
        }
    }
}
