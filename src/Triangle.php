<?php

namespace App;
//require('Validator.php');


Class Triangle
{
    private $sides = [];
    private $angles = [];
    private $P = 0;
    private $S = 0;

    private $c_sides = 0;
    private $c_angles = 0;


    /**
     * @var Validator $validator
     */
    private $validator;

    /**
     * @param array $sides
     * @param array $angles
     * @param double $P
     * @param double $S
     *
     * Функция для тестирования с уже заданными данными
     */
    public function startWithData($sides, $angles, $P, $S)
    {
        $this->validator = new Validator();

        $this->sides = $sides;
        $this->angles = $angles;
        $this->P = $P;
        $this->S = $S;

        $this->my();
    }

    /**
     * Начало программы
     *
     * Происходит консольный ввод с валидацией
     */
    function start()
    {

        $this->validator = new Validator();


        echo "Enter sides\n";
        $this->fill_arrays($this->sides, $this->c_sides);
        echo "Enter angles\n";
        $this->fill_arrays($this->angles, $this->c_angles);

        echo "Enter perimeter\n";
        if (!$this->validator->validate(readline(), $this->P)) exit;
        echo "Enter area\n";
        if (!$this->validator->validate(readline(), $this->S)) exit;


        $this->my();
    }

    /**
     * @param array $array
     *
     * Заполнение массива.
     * @param integer $counter счетчик ненулевых сторон или углов
     */
    function fill_arrays(&$array, &$counter)
    {
        for ($i = 0; $i < 3; $i++) {
            if (!$this->validator->validate(readline(), $array[])) exit;
            if ($array[$i] != 0) $counter++;
        }
    }


    function findNoAngleIndex()
    {
        foreach ($this->angles as $i => &$angle) {
            if ($angle == 0) return $i;
        }

        return -1;
    }

    function findFirstIndex($array)
    {
        foreach ($array as $i => &$item) {
            if ($item != 0) return $i;
        }
        return -1;
    }


    function my()
    {
        $a_sum = array_sum($this->angles);
        if ($a_sum > 180) {
            echo $this->validator->errors[3];
            return;
        }


        if ($this->c_angles == 2) {
            $i = $this->findNoAngleIndex();
            $this->angles[$i] = 180 - $a_sum;
            if ($this->angles[$i] == 0) {
                echo $this->validator->errors[3];
                return;
            }
        }

        if ($this->countSides() == 3) {
            $this->thereThreeSides();
            return;
        }


        if ($this->sides[0] != 0) {
            if ($this->sides[1] != 0) {
                 //110
                $this->thereTwoSides(0, 1, 2);

            } elseif ($this->sides[2] != 0) {
                //101
                $this->thereTwoSides(0, 2, 1);
            }
        } elseif ($this->sides[1] != 0) {
            if ($this->sides[2] != 0) {
                //011
                $this->thereTwoSides(1, 2, 0);
            } else {
                //010
            }
        } elseif ($this->sides[2] != 0) {
            //001
        } else {
            //000
        }

        if ($this->countSides() == 3) {
            $this->thereThreeSides();
            return;
        }
    }

    function countSides(){
        $c = 0;
        foreach ($this->sides as $side){
            if ($side != 0) $c++;
        }
        return $c;
    }

    function thereThreeSides(){
        if (!$this->validator->checkSides($this->sides)) return;
        $this->angles[0] = $this->calcAngleCos($this->sides[1], $this->sides[2], $this->sides[0]);
        $this->angles[1] = $this->calcAngleCos($this->sides[0], $this->sides[2], $this->sides[1]);
        $this->angles[2] = 180 - ($this->angles[0] + $this->angles[1]);
        $this->P = array_sum($this->sides);
        $this->calcS($this->sides[0], $this->sides[1], $this->angles[2]);
        $this->answer();
    }

    function thereTwoSides($i1, $i2, $need_i)
    {

        if ($this->P != 0) {
            $this->sides[$need_i] = $this->P - $this->sides[$i1] - $this->sides[$i2];
            return;
        }

        if ($this->angles[$i1] != 0) {
            $this->angles[$need_i] = 180 - $this->calcAngleSin($this->sides[$i2], $this->sides[$i1], $this->angles[$i1]) - $this->angles[$i1];
        } elseif ($this->angles[$i2] != 0) {
            $this->angles[$need_i] = 180 - $this->calcAngleSin($this->sides[$i1], $this->sides[$i2], $this->angles[$i2]) - $this->angles[$i2];
        }
        if ($this->S != 0) {
            $this->angles[$need_i] = $this->calcAngleFromS($this->sides[$i1], $this->sides[$i2]);
        }

        $this->sides[$need_i] = $this->calcSideCos($this->sides[$i1], $this->sides[$i2], $this->angles[$need_i]);
    }

    function thereOneSide()
    {

    }

    function answer()
    {
        echo "\nSides : ";
        foreach ($this->sides as $side) echo $side . ' | ';
        echo "\nAngles : ";
        foreach ($this->angles as $angle) echo $angle . ' | ';
        echo "\nP : " . $this->P;
        echo "\nS : " . $this->S;
    }

    /**
     * @param double $sideA
     * @param double $sideB
     * @param double $angle
     * Расчет площади
     */

    function calcS($sideA, $sideB, $angle)
    {
        $this->S = 0.5 * $sideA * $sideB * sin($angle * pi() / 180);
    }

    function calcAngleFromS($sideA, $sideB)
    {
        return asin(2 * $this->S / ($sideA * $sideB)) / pi() * 180;
    }

    function calcSideSin($sideA, $angleA, $angleB)
    {
        return $sideA * sin($angleB * pi() / 180) / sin($angleA * pi() / 180);
    }

    function calcAngleSin($sideA, $sideB, $angleB)
    {
        return asin($sideA / $sideB * sin($angleB * pi() / 180)) / pi() * 180;
    }

    function calcAngleCos($side1, $side2, $sideX)
    {
        return acos(($side1 * $side1 + $side2 * $side2 - $sideX * $sideX) / (2 * $side1 * $side2)) / pi() * 180;
    }

    function calcSideCos($side1, $side2, $angleX)
    {
        return sqrt($side1 * $side1 + $side2 * $side2 - 2 * $side1 * $side2 * cos($angleX * pi() / 180));
    }


}




