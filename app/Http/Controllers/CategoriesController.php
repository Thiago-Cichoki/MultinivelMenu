<?php
/**
 * Created by PhpStorm.
 * User: Thiago Cichoki
 * Date: 26/04/2019
 * Time: 17:43
 */
namespace App\Http\Controllers;

use App\Categorie;

class CategoriesController extends BaseController
{
    private $categories = [];
    private $indexes = [];

    public function __construct()
    {
        parent::BaseController("categories", new Categorie());
    }

    public function AjaxList()
    {
       $this->categories = parent::AjaxList();


       for ($i = 0; $i < count($this->categories); $i++)
       {
           $this->OrganizeMenu($this->categories, $this->categories[$i]);
       }

       foreach ($this->indexes as $index => $value)
       {
            unset($this->categories[$value]);
       };

       return json_encode($this->categories);
    }



    private function OrganizeMenu($categories, $parentMenu)
    {
        $keys = [];

        foreach ($categories as $menu)
        {
           if (isset($menu->idParentCategory))
           {
               if ($menu->idParentCategory == $parentMenu->id)
               {
                   $parentMenu->childs[] = $menu;
                   $this->indexes[] = array_search($menu, $this->categories, true);
               }
           }
        }

    }

}
