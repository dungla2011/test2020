<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AdminModule;

use Base\ClassDBConnect;
use Base\ModelNewsFile;
use Base\ModelUserCms;
use Base\clsValidate;
use Base\ModelDemoViDu;
use Base\CReturnError;
use Base\ClassRoute;
use Base\ClassString;
use Base\ClassController;

class NewsIndexController extends ClassController{

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


    function addMgAction(){
        $this->loadViewFile(__FUNCTION__);
    }

    function addAction($retVal = 0){
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $params = ClassRoute::$arrParams;
        $this->loadViewFile(__FUNCTION__);
    }

    function viewMgAction(){
        $this->loadViewFile(__FUNCTION__);
    }
    function editAction(){
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $params = ClassRoute::$arrParams;

        $id = @$params['id'];
        if(!qqCheckIdRandValid($id)){
            loi("Not valid ID ? ($id)");
        }

        $obj = new ModelNewsFile;
        if($obj->getOne($id))
            $content = $obj->content;
        else
            $obj = null;

        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if(!file_exists($viewFile)){
            echo("Not found View File?".$viewFile);
        }
        else
            require_once $viewFile;
    }

    function viewAction(){
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $params = ClassRoute::$arrParams;
        $this->loadViewFile(__FUNCTION__);
    }

    function crawleAction($retVal = 0){

        $this->loadViewFile(__FUNCTION__);
    }

    function indexMgAction(){
        $this->loadViewFile(__FUNCTION__);
    }

}