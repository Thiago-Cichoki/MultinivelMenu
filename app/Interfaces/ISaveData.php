<?php
/**
 * Created by PhpStorm.
 * User: Thiago Cichoki
 * Date: 26/04/2019
 * Time: 17:23
 */

namespace App\Interfaces;

/**
 Função para salvar os dados
 */

interface ISaveData
{
    function AjaxSave(Array $attributes);
}
