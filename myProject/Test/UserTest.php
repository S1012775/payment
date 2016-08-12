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

    public function testCountBalance()
    {
        $name = "apple";
        $add = 5000;
        $reduce = 5000;
        $now = "2016-08-12 15:31:00";
        $money = 600;
        $withdrawal = "withdrawal";
        $deposit = "deposit";

        $user = new User();
        $user->countBalance($money, $add, $reduce, $now, $name, $withdrawal, $deposit);
    }


}

?>