<?php
/**
 * Created by PhpStorm.
 * User: Thiago Cichoki
 * Date: 26/04/2019
 * Time: 17:18
 */

namespace App\Http\Controllers;


use App\BaseModel;
use App\Interfaces\IListAllData;
use App\Interfaces\IRemoveData;
use App\Interfaces\ISaveData;
use App\Interfaces\IUpdateData;

class BaseController extends CrudController implements ISaveData, IRemoveData, IUpdateData, IListAllData
{
    public function BaseController($tableName, BaseModel $entity)
    {
        parent::setTable($tableName);
        parent::setEntity($entity);
    }
}
