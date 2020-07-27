<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AdminModule;
use Base\CReturnError;
use Base\ClassRoute;
use Base\ClassString;
use Base\ClassController;

class IndexController extends ClassController{
    
    
    function __construct() {
        parent::__construct();
        $this->controllerFilePath = __FILE__;
        
        $this->templateName = "admin1";
        $this->templateLayoutFile = "index_admin.htm";
        $this->folderViewOfAction = "";
    }

    function indexAction($paramInput = null){
        //echo "<br/> AdminCmsUser:index ".__FUNCTION__;
        $param = " Chuỗi từ Index đây";
        $ret = str_replace("system boot ","", shell_exec("who -b"));

        $t1 = strtotime($ret);

        if(isAdmin_()) {
            echo " &nbsp STARTTIME : " . \ClassDateTime::secondsToTime(time() - $t1);
            echo "\n | <a href='/tool/_site/filemng.php' target='_blank'> File </a> ";

            $mDisk = ['/', "/mnt/glx"];
            foreach ($mDisk AS $disk){
                $freeDisk = \CDisk::getFreeDiskInFilePath("$disk");
                $totalDisk = \CDisk::getTotalDiskSizeInFilePath($disk);
                $percent = round(100* $freeDisk/$totalDisk);
                if($percent < 30){
                    $percent = "<span style='color: red; font-size: x-large'>$percent</span>";
                }
                echo "\n | FreeDisk ($disk) = ". ByteSize($freeDisk). " ($percent %) ";
            }
        }

        $this->loadViewFile(__FUNCTION__, DEFAULT_TEMPLATE_NAME_PUBLIC);
    }
    
    function test1Action(){
        
        
        
        
        $viewFile = $this->getFileViewPath(__FUNCTION__);
        if(!file_exists($viewFile)){
            echo("Not found View File?".$viewFile);
        }
        else
            require_once $viewFile;
    }

}