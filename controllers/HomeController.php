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
        $detial = $this->model("User");

        if (isset($_POST['expend'])) {
            $withdrawal = "withdrawal";
            $countBalance = $detial->countBalance($money, $update, $add, $reduce, $now, $name, $withdrawal, $deposit);

            $this->view("echo", "出款成功");
            header("refresh:0, url=https://payment-annyke.c9users.io/bankSystem/Home/index");
        }

        if (isset($_POST['income'])) {
            $deposit = "deposit";
            $countBalance = $detial->countBalance($money, $update, $add, $reduce, $now, $name, $withdrawal, $deposit);

            $this->view("echo", "存款成功");
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
