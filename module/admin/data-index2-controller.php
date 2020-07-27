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

class DataIndex2Controller extends ClassController{

    function __construct() {
        parent::__construct();
        $this->controllerFilePath = __FILE__;
        $this->templateName = "admin1";
        $this->templateLayoutFile = "index_admin.htm";
        $this->folderViewOfAction = "";
    }

    function index_width_treeAction(){
        $this->loadViewFile(__FUNCTION__);
    }

    function indexAction($paramInput = null){
        $this->loadViewFile(__FUNCTION__);
    }

    function treeAction(){
        $this->loadViewFile(__FUNCTION__);
    }

    function add2Action(){
        $this->loadViewFile(__FUNCTION__);
    }

    function addAction($retVal = 0){
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $params = ClassRoute::$arrParams;
        $this->loadViewFile(__FUNCTION__);
    }

    function view2Action(){
        $this->loadViewFile(__FUNCTION__);
    }
    function editAction(){
        $this->loadViewFile(__FUNCTION__);
    }

    function viewAction(){
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $params = ClassRoute::$arrParams;
        $this->loadViewFile(__FUNCTION__, DEFAULT_TEMPLATE_NAME_PUBLIC);
    }

    function crawleAction($retVal = 0){

        $this->loadViewFile(__FUNCTION__);
    }

    function index2Action(){
        $this->loadViewFile(__FUNCTION__);
    }



}