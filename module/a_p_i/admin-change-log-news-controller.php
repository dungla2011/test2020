<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace A_p_iModule;

use Base\ClassControllerApiHasIndex;
use Base\ClassDBConnect;
use Base\ModelChangeLog;
use Base\ModelUserCms;
use Base\clsValidate;
use Base\ModelDemoViDu;
use Base\CReturnError;
use Base\ClassRoute;
use Base\ClassString;
use Base\ClassController;

class AdminChangeLogNewsController extends ClassControllerApiHasIndex
{
    function __construct()
    {
        parent::__construct();
        $this->isAdmin = true;
    }

    function indexAction($paramInput = null)
    {
        parent::indexAction($paramInput);
    }

    function getClassModelFolder(){
        return null;
    }

    function getClassModelItem(){
        return get_class(new ModelChangeLog());
    }


}