<?php
/**
 * Created by PhpStorm.
 * User: Thiago Cichoki
 * Date: 26/04/2019
 * Time: 17:27
 */

namespace App\Interfaces;

/**
 Função para alterar os dados
 */

interface IUpdateData
{
    public function AjaxUpdate(Array $attributes);
}
