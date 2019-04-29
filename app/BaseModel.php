<?php
/**
 * Created by PhpStorm.
 * User: Thiago Cichoki
 * Date: 26/04/2019
 * Time: 17:09
 */

namespace App;


use App\Interfaces\IConvertParamsToObject;

/**
    Esta classe contém a função paramsToObject, que é responsável por converter o array de
    parâmetros no objeto da classe. Atribuindo cada chave ao seu respectivo valor dentro da classe.
 */

abstract class BaseModel implements IConvertParamsToObject
{
    public function paramsToObject(array $attributes)
    {
        foreach ($attributes as $key => $value)
        {
            if (isset($attributes[$key]))
            {
                $this->$key = $attributes[$key];
            }
        }
    }

    public function valueDefault($key, $value)
    {
        $this->$key = $value;
    }

}
