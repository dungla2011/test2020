<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace A_p_iModule;

use Base\ClassControllerApiHasIndex;
use Base\ClassDBConnect;
use Base\ModelLogAdmin;
use Base\ModelUserCms;
use Base\clsValidate;
use Base\ModelLogUser;
use Base\CReturnError;
use Base\ClassRoute;
use Base\ClassString;
use Base\ClassController;

class AdminAdsMngController extends ClassController
{

    function __construct(){
        parent::__construct();
        $this->isAdmin = true;
    }

    function saveAction()
    {
        $params = \Base\ClassRoute::getArrParams();

        $obj = new \modelAdsMng();

//        echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
//        print_r($params);
//        echo "</pre>";


        if(!$obj->getOneId($params['_id'])){
            $obj->loadFromArray($params);
            $obj->insert();
            die("Insert done!");
        }
        else{
            $obj->loadFromArray($params);
            $obj->updateMe();
            die("Update done!");
        }
        die();
    }

}