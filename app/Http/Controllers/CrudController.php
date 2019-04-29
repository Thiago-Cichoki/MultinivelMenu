<?php

namespace App\Http\Controllers;

use App\BaseModel;
use Illuminate\Support\Facades\DB;


/**
 * Class CrudController
 * Responsável por realizar todas as operações CRUD.
 */

abstract class CrudController
{
    private $entity;
    private $table;
    public $DB;

    public function __construct()
    {
        $this->DB = new DB();
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table): void
    {
        $this->table = $table;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(BaseModel $entity): void
    {
        $this->entity = $entity;
    }

    public function AjaxSave(Array $attributes)
    {
        $this->entity->paramsToObject($attributes);

        $cols = [];
        $values = [];

        foreach ($this->entity as $key => $value)
        {
            /**
             * Esse foreach separa as chaves para o array cols e seus valores para o array values
             */
            $cols[] = $key;
            if (!($key == 'id'))
            {
                $values[] = (isset($value)) ? $value : null;
            }
        }

        (string) $query = "INSERT INTO $this->table (";

        for ((int) $i = 0; $i < count($cols); $i++)
        {
            /**
             * Este for insere na query para o insert todas as colunas
             */

            if (!($cols[$i] == "id"))
            {
                $query .= ($cols[$i] == end($cols)) ?  $cols[$i] . ")" : $cols[$i] . ", ";
            }
        }

        $query .= " VALUES (";

        for ((int) $i = 0; $i < count($cols); $i++)
        {
            /**
             * This for inserts all the values into the query to insert data into the database
             */
            if (!($cols[$i] == "id"))
            {
                $query .= ($cols[$i] == end($cols)) ? "?" . ")" : "?" . ", ";
            }

        }

        $insert = DB::insert($query, $values);

        if (!$insert)
        {
            throw new \Exception("Error while trying to save data");
        }

        return json_encode(['status' => 200, 'message' => "Data was successfully saved"]);

    }

    public function AjaxList()
    {
        return DB::select("SELECT * FROM $this->table;");
    }

    public function AjaxUpdate(array $attributes)
    {
        $this->entity->paramsToObject($attributes);

        $id = $this->entity->id;

        unset($this->entity->id);

        $this->entity = get_object_vars($this->entity);


        $update = DB::table($this->table)->where('id', $id)->update($this->entity);

        if (!$update)
        {
            throw new \Exception("Error while trying to update data");
        }

        return json_encode(['status' => 200, 'message' => "the data was changed successfully"]);

    }

    public function AjaxRemove($id)
    {

        $delete = DB::table($this->table)->where("id", "=", $id)->orWhere("idParentCategory", "=", $id)->delete();

        if (!$delete)
        {
            throw new \Exception("Error while trying to delete data");
        }

        return json_encode(['status' => 200, 'message' => "the data was successfully removed"]);
    }
}
