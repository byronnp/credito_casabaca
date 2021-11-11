<?php
/**
 * Created by PhpStorm.
 * User: ZBOOK
 * Date: 10/11/2021
 * Time: 17:39
 */

namespace App\Helpers;


class Calculo
{

    public static function porcentajetaTasaInteres(float $porcentaje)
    {
        return ($porcentaje / 100) + 1;
    }
}