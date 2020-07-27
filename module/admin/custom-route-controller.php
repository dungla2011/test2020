<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AdminModule;

use Base\ClassDBConnect;
use Base\ModelUserCms;
use Base\clsValidate;
use Base\ModelDemoViDu;
use Base\CReturnError;
use Base\ClassRoute;
use Base\ClassString;
use Base\ClassController;

class CustomRouteController extends ClassController{

    function __construct() {
        parent::__construct();
        $this->controllerFilePath = __FILE__;
        $this->templateName = "admin1";
        $this->templateLayoutFile = "index_admin.htm";
        $this->folderViewOfAction = "";
    }

    function indexAction($paramInput = null){
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $params = ClassRoute::$arrParams;

        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if(!file_exists($viewFile)){
            echo("Not found View File?".$viewFile);
        }
        else
            require_once $viewFile;
    }

}