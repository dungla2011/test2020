<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//use Base\ClassController;

namespace AdminModule;

use \Base\ClassController;
use \Base\ClassRoute;
use \Base\ModelBase;
use \Base\ModelPrivilege;
use Base\ModelUserGroup;
use Base\CReturnError;
use Base\ModelUserCms;
use Base\ClassString;

class CmsPermissionController extends ClassController {

    function __construct() {
        parent::__construct();
        $this->controllerFilePath = __FILE__;

        $this->templateName = "admin1";
        $this->templateLayoutFile = "index_admin.htm";
        $this->folderViewOfAction = "";
    }


    function indexAction($paramInput = null) {

        $params = ClassRoute::$arrParams;

        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if (!file_exists($viewFile)) {
            echo("Not found View File?".$viewFile);
        } else
            require_once $viewFile;
        
    }

    function saveAction() {

        $params = ClassRoute::$arrParams;

        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if (!file_exists($viewFile)) {
            echo("Not found View File?".$viewFile);
        } else
            require_once $viewFile;
    }

}
