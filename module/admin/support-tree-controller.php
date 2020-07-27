<?php
/**
 * Created by PhpStorm.
 * User: lad
 * Date: 14/12/2017
 * Time: 2:24 PM
 */
namespace AdminModule;

use Base\ModelUserCms;
use Base\clsValidate;
use Base\CReturnError;
use Base\ClassRoute;
use Base\ClassString;
use Base\ClassController;

class SupportTreeController extends ClassController{

    function __construct() {
        parent::__construct();
        $this->controllerFilePath = __FILE__;
        $this->templateName = "admin1";
        $this->folderViewOfAction = "";
        $this->templateLayoutFile = "index_admin.htm";
    }

    function indexAction($paramInput = null){
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $param = " Chuỗi từ Index đây";
        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if(!file_exists($viewFile)){
            echo("Not found View File?".$viewFile);
        }
        else
            require_once $viewFile;

    }



}