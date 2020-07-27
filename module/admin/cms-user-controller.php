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
use \Base\ClassDBConnect;
use Base\ModelPermission;
use \Base\ModelPrivilege;
use Base\CReturnError;
use Base\ModelUserCms;
use Base\ClassString;

class CmsUserController extends ClassController {

    function __construct() {
        parent::__construct();
        $this->controllerFilePath = __FILE__;

        $this->templateName = "admin1";
        $this->templateLayoutFile = "index_admin.htm";
        $this->folderViewOfAction = "";
        $this->title = "User management";
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

    function addAction($retVal = 0){

        $params = ClassRoute::$arrParams;


        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if(!file_exists($viewFile)){
            echo("Not found View File?".$viewFile);
        }
        else
            require_once $viewFile;

    }

    function saveAction(){

        $params = ClassRoute::$arrParams;


    }

    function deleteAction(){

        $params = ClassRoute::$arrParams;
        if(isset($params['id']) && is_numeric($params['id'])) {

        }
        else
            rtErrorApi("Not valid ID to delete? ");
    }

    function unDeleteAction(){

        $params = ClassRoute::$arrParams;
        if(isset($params['id']) && is_numeric($params['id'])) {

        }
        else
            rtErrorApi("Not valid ID to un-delete? ");
    }


    function multiDeleteAction(){

        $params = ClassRoute::$arrParams;


    }
    function multiUndeleteAction(){

        $params = ClassRoute::$arrParams;


    }

    function changeStatusAction(){
        $params = ClassRoute::$arrParams;

    }




    function indexDelAction() {
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $params = ClassRoute::$arrParams;


        $param = " Chuỗi từ Index đây";





        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if (!file_exists($viewFile)) {
            echo("Not found View File?".$viewFile);
        } else
            require_once $viewFile;
    }

    function addUserAction() {




        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if (!file_exists($viewFile)) {
            echo ("Not found View File?" . $viewFile);
        } else
            require_once $viewFile;
    }

    function test1Action() {




        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if (!file_exists($viewFile)) {
            echo("Not found View File?".$viewFile);
        } else
            require_once $viewFile;
    }



}


