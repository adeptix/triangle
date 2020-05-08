<?php

namespace App;

/**
 * Class Validator
 * @package App
 *
 * Класс валидации ввода
 */
class Validator
{

    //массив с обозначениями ошибок
    public $errors = ['Invalid input', 'Values must be positive', 'Not enough data', 'Incorrect data', 'Incorrect sides'];


    /**
     * @param $input - ввод
     * @param $place - конечная переменная
     *
     * Проверяет, является ли ввод неотрицательным числом
     * Выводит текст ошибки и возвращает статус.
     *
     * @return bool - пройдена ли валидация
     */
    public function validate($input, &$place)
    {
        $r = trim($input);

        if (!empty($r) && !is_numeric($r)) {
            echo $this->errors[0];
            return false;
        }

        $num = doubleval($r);
        if ($num < 0) {
            echo $this->errors[1];
            return false;
        }
        $place = $num;

        return true;
    }

    /**
     * @param array $sides
     * Проверяет првильность сторон
     * @return bool
     */

    public function checkSides($sides){
        if($sides[0] < $sides[1] + $sides[2] &&
           $sides[1] < $sides[0] + $sides[2] &&
           $sides[2] < $sides[1] + $sides[0]){
            return true;
        }else{
            echo $this->errors[4];
            return false;
        }
    }


}