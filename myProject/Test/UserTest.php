<?php

require_once 'myProject/User.php';

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAllDetial()
    {
        $name = "apple";

        $user = new User();
        $user->getAllDetial($name);
    }
    public function testGetBalance()
    {
        $name = "apple";

        $user = new User();
        $user->getBalance($name);
    }

    public function testCountDeposit()
    {
        $name = "apple";
        $add = 5000;
        $now = "2016-08-12 15:31:00";
        $money = 600;

        $user = new User();
        $user->countDeposit($money, $add, $now, $name);
    }

    public function testCountWithdrawal()
    {
        $name = "apple";
        $reduce = 5000;
        $now = "2016-08-12 15:31:00";
        $money = 600;

        $user = new User();
        $user->countWithdrawal($money, $reduce, $now, $name);
    }

}

?>