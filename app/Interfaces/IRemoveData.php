<?php
/**
 * Created by PhpStorm.
 * User: Thiago Cichoki
 * Date: 26/04/2019
 * Time: 17:28
 */

namespace App\Interfaces;

/**
    Função para remover os dados
 */

interface IRemoveData
{
    public function AjaxRemove(Array $attributes);
}
