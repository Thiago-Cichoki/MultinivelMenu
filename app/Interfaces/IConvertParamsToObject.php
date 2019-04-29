<?php
/**
 * Created by PhpStorm.
 * User: Thiago Cichoki
 * Date: 26/04/2019
 * Time: 17:11
 */

namespace App\Interfaces;


interface IConvertParamsToObject
{
    function paramsToObject(Array $attributes);
}
