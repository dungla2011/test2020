<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AdminModule;

use Base\ModelUserCms;
use Base\CReturnError;
use Base\ClassRoute;
use Base\ClassString;
use Base\ClassController;

class CloudController extends ClassController{
    
     
    function __construct() {
        parent::__construct();
        $this->controllerFilePath = __FILE__;
        $this->templateName = "admin1";
        $this->folderViewOfAction = "";

        $this->templateLayoutFile = "index_admin.htm";
        if(isAdmin_()){
        //    $this->templateLayoutFile = "index_member1.htm";
        }


        $this->title = "User Profile";
    }
    
    function indexAction($paramInput = null){


        $this->loadViewFile(__FUNCTION__, DEFAULT_TEMPLATE_NAME_PUBLIC);

    }

   
}