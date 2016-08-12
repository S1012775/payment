<?php

require_once 'myProject/User.php';

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAllDetial()
    {
        $name = "test";

        $user = new User();
        $user->getAllDetial($name);
    }
    public function testGetBalance()
    {
        $name = "test";

        $user = new User();
        $user->getBalance($name);
    }

    public function testCountDeposit()
    {
        $name = "test";
        $add = 0;
        $now = "2016-08-12 15:31:00";
        $money = 600;

        $user = new User();
        $user->countDeposit($money, $add, $now, $name);
    }

    public function testCountWithdrawal()
    {
        $name = "test";
        $reduce = 0;
        $now = "2016-08-12 15:31:00";
        $money = 600;

        $user = new User();
        $user->countWithdrawal($money, $reduce, $now, $name);
    }

}

?>