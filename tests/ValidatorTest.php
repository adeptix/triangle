<?php

namespace Tests;

use App\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    protected function setUp()
    {
        $this->validator = new Validator();
    }

    /**
     * Тест на правильный ввод, в том числе и на его отсутствие,
     * ведь данные можно и не вводить.
     */
    public function testSuccess()
    {
        $data = '12.3';
        self::assertTrue($this->validator->validate($data, $a));

        $data = ' ';
        self::assertTrue($this->validator->validate($data, $a));
    }



    /**
     * Тест на некорректный ввод, например текст.
     *
     * Также проверяется текст ошибки
     */
    public function testInvalidInput()
    {
        $data = 'bug';

        $this->expectOutputString('Invalid input');
        self::assertFalse($this->validator->validate($data, $a));
    }

    /**
     * Тест на ввод отрицательных значений.
     * Данные треугольника такими быть не могут.
     *
     * Также проверяется текст ошибки
     */
    public function testNegativeInput()
    {
        $data = '-12';

        $this->expectOutputString('Values must be positive');
        self::assertFalse($this->validator->validate($data, $a));
    }




}
