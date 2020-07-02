<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Integer;
use yii\base\Model;

class TestWork extends Model
{
    /**
     * вывод разницы веса 2х строк
     * return Left - левая строка тяжелее правой
     * return Right - правая строка тяжелее правой
     * return Balance - строки равны
     */
    public function getBalance($left, $right): String
    {
        $leftWeight = $this->getWeight($left);
        $rightWeight = $this->getWeight($right);

        if ($leftWeight > $rightWeight) {
            return 'Left';
        } elseif ($leftWeight < $rightWeight) {
            return 'Right';
        } else {
            return 'Balance';
        }
    }


    public function getWeight($str): Integer
    {
        $weight = 0;
        $strArray = str_split($str);
        foreach ($strArray as $value) {
            if ($value == '!'){
                $weight = $weight + 2;
            } elseif ($value == '?') {
                $weight = $weight + 3;
            }
        }

        return $weight;
    }
}
