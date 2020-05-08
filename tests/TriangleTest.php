<?php

namespace Tests;

use App\Triangle;
use PHPUnit\Framework\TestCase;


class TriangleTest extends TestCase
{
    private $triangle;

    protected function setUp()
    {
        parent::setUp();
        $this->triangle = new Triangle();
    }

    public function testIncorrectSides()
    {
        $this->expectOutputString('Incorrect sides');
        $this->triangle->startWithData([20, 1, 1], [0, 0, 0], 0, 0);

    }

//    public function testSolveTriangle()
//    {
//
//        $this->triangle->startWithData([3, 4, 5], [0, 0, 0], 0, 0);
//
//    }
}
