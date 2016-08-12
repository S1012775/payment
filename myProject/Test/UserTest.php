<?php

namespace myProject\Test;

use myProject\Tool;

class UserTest extends \PHPUnit_Framework_TestCase
{

    /**
    * @param int $paramCount
    * @param string $paramWhat
    * @param string $expectedResult
    *
    * @dataProvider providerTestRepeatString
    */
    public function testgetAllDetial($paramCount, $paramWhat, $expectedResult)
    {
        $tool = new Tool();
        $result = $tool->repeatString($paramCount, $paramWhat);
        $this->assertEquals($expectedResult, $result);
    }


}

?>