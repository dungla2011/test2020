<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AdminModule;

use Base\ClassDBConnect;
use Base\ModelCloudUser;
use Base\ModelNewsFile;
use Base\ModelUserCms;
use Base\clsValidate;
use Base\ModelDemoViDu;
use Base\CReturnError;
use Base\ClassRoute;
use Base\ClassString;
use Base\ClassController;

class Mng4sController extends ClassController{

    function __construct() {
        parent::__construct();
        $this->controllerFilePath = __FILE__;
        $this->templateName = "admin1";
        $this->templateLayoutFile = "index_admin.htm";
        $this->folderViewOfAction = "";
    }

    function indexAction($paramInput = null){

        $this->loadViewFile(__FUNCTION__);

        $params = ClassRoute::$arrParams;
        if (isset($params['username']) && $params['username']) {

            $username = trim($params['username']);

            $userid = \ClassUser4S::getUserIdFromUsernameEmailOrRandId($username);
            if(!$userid){
                bl("Error: ". \ClassException::getLastError());
                return;
            }

            echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
            print_r($params);
            echo "</pre>";

            $obj = new ModelUserCms($userid);

            if (!isAdmin_())
                if ($userid == 1 || $obj->email == 'dungbkhn02@gmail.com') {
                    echo "<br/> NOT ALLOW!";
                    goto _END;
                }

            if (getCurrentUserId() <> 1)
                if ($userid == 1) {
                    die(" Not allow this user!");
                }

            if (!$userid) {
                echo " Không tồn tại user? $username";
                goto _END ;;
            }

            $objUser4S = new \ClassUser4S();
            $cret = $objUser4S->getAllInfo($userid);
            $userobj = new ModelUserCms();
            $cret = $userobj->getOne($userid);
            if (!$cret) {
                echo "   Không tồn tại user này?";
                goto _END ;;
            }

            if (isset($params['unlock_account'])) {
                //LogAdmin("unlock_account: $userobj->id, $userobj->username");
                $userobj->setBanned(0, '');
            }
            if (isset($params['lock_account'])) {
                $time_to_lock = $params['time_to_lock'];
                $reason_to_lock = $params['reason_to_lock'];
                //LogAdmin("lock_account: $userobj->id, $userobj->username, $time_to_lock, $reason_to_lock");

                echo "<br/>\n Lock Now: ";
                if (strtotime($time_to_lock) > time() + _NSECOND_DAY){

                    $userobj->setBanned($time_to_lock, $reason_to_lock);
                }
                else
                    echo " Thời gian khóa không hợp lệ, ít nhất sau ngày hôm nay 1 ngày!";
                goto _END ;;
            }

            if (isset($params['set_password']) && !empty($params['set_password']) && isset($userid)) {
                //LogAdmin(" SET PASSWORD user (id = $userid): $userobj->email/  $userobj->username ");
                SendMailToManagerBackGroundInfo(" SET PASSWORD user (id = $userid): $userobj->email/  $userobj->username");
                $password = $params['set_password'];
                $objUserCms = new ModelUserCms;
                $objUserCms->password = $password;

                if (!\clsValidate::isPassword($password)) {
                    loi(" Password not valid! ($password)");
                } else {
                    //bl(" Doi pw");
                    $update = new ModelUserCms();
                    $update->password = sha1PwGlx($password, $userid);
                    $update->updateDbMe(" id = $userid ");

                    bl("Đặt pw thành công!");

                }
            } else
                if (isset($params['insert_gold']) && !empty($params['insert_gold']) && isset($userid)) {

                    $nGold = $params['insert_gold'];

                    $userEmail = getCurrentUserEmail();
                    //LogAdmin("$userEmail InsertGold $nGold Gold, To user (id = $userid): $userobj->email/  $userobj->username");

                    SendMailToManagerBackGroundInfo("$userEmail InsertGold $nGold Gold, To user (id = $userid): $userobj->email/  $userobj->username");

                    if (!is_numeric($nGold)) {
                        echo(" Error:  Số gold không hợp lệ? $nGold");
                        goto _END ;;
                    }

                    if ($nGold > 2000) {
                        baoloi(" Error:  Tối đa chỉ được 2000 gold!");
                        goto _END ;
                    }

                    $reason = $params['insert_gold_reason'];

                    if (!$objUser4S->isSubUser()) {
                        $cret = $objUser4S->insertGold(0 ,$nGold, _GOLDTYPE_ADMIN_INSERT, 'Admin insert: ' . $reason);
                        bl(" Nạp gold thành công?");
                    } else {
                        $cret = $objUser4S->insertGold(0 ,$nGold, _GOLDTYPE_ADMIN_INSERT, 'Admin insert: ' . $reason);
                        tb("Sub user: $reason ");
                    }
                } elseif (isset($params['active_funny']) && !empty($params['active_funny']) && isset($userid)) {
                    $sub = strtolower($params['active_funny']);
                    $sub = trim($sub);
                    if (empty($sub)) {
                        echo "<br/> Empty sub name?";
                        return;
                    }

                    //LogAdmin("active_funny: $userobj->id, $userobj->username , SUB = $sub");

                    if ($objUser4S->isSubVT()) {
                        if ($sub == "fs10" || $sub == 'fs15') {

                            $username = $objUser4S->objUserCms->username;

                            $phonenumber = substr($username, 1);

                            bl("Kích hoạt funny!");

                            $arrSubReturn = SubActiveUser($phonenumber, $sub, 0, microtime(1), "6x00", 4);
//
//                            echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
//                            print_r($arrSubReturn);
//                            echo "</pre>";
                        }
                    } else {

                        $username = $objUser4S->objUserCms->username;

                        echo "<br/> Sub for mobile ($username)";
                        //die();

                        $phonenumber = trim("84" . substr($username, 2));
                        $chargeTime = date("YmdHis");

                        $url = "http://4share.vn:56666/tool/smglx/sms_sub_smedia_auto.html?msisdn=$phonenumber&requestid=-1&package=FS10&keyword=DK%20FSX&chargetime=$chargeTime&chargeresult=1&mode=ADMIN&username=smedia&password=43olj34l5jl3k45345345";
                        $ret = file_get_contents($url);
                        tb(" RET = '$ret'");
                    }
                }
        }
        _END:


    }

    function uploaderMoneyAction(){
        $this->loadViewFile(__FUNCTION__);
    }

    function uploaderAction(){
        $this->loadViewFile(__FUNCTION__);
    }

    function searchLogAction(){
        $this->loadViewFile(__FUNCTION__);
    }

    function editAction()
    {
        $this->loadViewFile(__FUNCTION__);
    }

    function addAction()
    {
        $this->loadViewFile(__FUNCTION__);

        $params = \Base\ClassRoute::getArrParams();

        if (isset($params['add_uploader'])) {

            $userOrEmail = trim($params['add_uploader']);

            echo "<br/> Add uploader: $userOrEmail ";

            $userComment = trim($params['user_uploader_info']);

            if (!\clsValidate::isEmail($userOrEmail)) {
                bl("User Bắt buộc phải là email ($userOrEmail)!");
                return;
            }
            $cret = $obj =ModelUserCms::getOneWhereSql_("email = '$userOrEmail'");

            if (!$obj) {
                bl(" NOT VALID USER?  $userOrEmail");
                return;
            }

            if($obj instanceof ModelUserCms);

            $userid = $obj->id;
            $cret = $email = $obj->email;
            $new = new ModelNewsFile(426);

            //Xem user đã có trong bảng uploader chưa

            $uploader = new \ClassUploader();
            $cret = $uploader->getOneWhereSql("userid = $userid");
            
            $chiDoiTrangThai = 0;
            if ($cret) {
                if ($uploader->status == 0) {
                    $uploader->status = 1;
                    $cret = $uploader->updateDbMe(" userid = $userid ");
                    if ($cret) {
                        $chiDoiTrangThai = 1;
                        bl("Đổi trạng thái uploader OK! ($email)");
                        SendMailAmazon("admin@4share.vn", " 4Share.vn ", $email, $new->name, $new->content, 1, "admin@4share.vn", 'support@4share.vn');
                        //LogAdmin("Đổi trạng thái thành uploader: $email");
                    }
                } else {
                    bl("Tài khoản này đã là uploader? ($email)");
                    return;
                }
            }


            //LogAdmin("add_uploader: Add uploader: $userOrEmail ");
            $objUser = new ModelUserCms;
            if ($objUser->gid <> GID_ADMIN) {
                //Update GID:
                $objUser->gid = GID_UPLOADER;
                $cret = $objUser->updateDbMe(" id = $userid");
                
            }

            $userCms = new ModelUserCms;
            if (!empty($userComment)) {
                $userCms->comment = $userComment;
                $cret = $userCms->updateDbMe("id = $userid");
            }

            $objCloud = new ModelCloudUser();
            $objCloud->glx_quota_folder_dung_luong_khong_xoa = 500 * _GB;
            $objCloud->glx_bytes_in_avail = 1000 * _GB;
            $objCloud->glx_files_in_avail = 10000;

            $cret = $objCloud->updateDbMe("userid = $userid");

            if ($chiDoiTrangThai)
                return;

            $username = ModelUserCms::getUserInfoEx($userid);

            $db = \MysqliDb::getInstance();

            $time = nowyh();
//            require_once 'condb.lib';
            $sql = "INSERT INTO tbl_userspec(userid, type, time, status) VALUES ('$userid', 'uploader', '$time', 1)";
            $ret = $db->rawQuery($sql);

            bl("Thêm thành công uploader!");

            SendMailAmazon("admin@4share.vn", " 4Share.vn ", $email, $new->name, $new->content, 1, "admin@4share.vn", 'support@4share.vn');
            $cret = \ClassUser4S::getUploaderArrayCache(1);

        } elseif (isset($params['remove_uploader'])) {

            $userOrEmail = trim($params['remove_uploader']);

            echo "<br/> Disable uploader: $userOrEmail ";

            //LogAdmin("remove_uploader: $userOrEmail ");

            $cret = $objUser = ModelUserCms::getOneWhereSql_("email = '$userOrEmail'");

            if (!$objUser) {
                bl(" NOT VALID USER?  $userOrEmail");
                return;
            }

            if($objUser instanceof ModelUserCms);

            $userid = $objUser->id;
            if ($objUser->gid <> GID_ADMIN) {
                //Update GID:
                $objUser->gid = GID_MEMBER;
                $cret = $objUser->updateDbMe(" id = $userid");
            }

            $objCloud = new ModelCloudUser();
            $objCloud->glx_quota_folder_dung_luong_khong_xoa = 50 * _GB;
            $objCloud->glx_bytes_in_avail = 100 * _GB;
            $objCloud->glx_files_in_avail = 1000;

            $cret = $objCloud->updateDbMe("userid = $userid");

            $username = ModelUserCms::getUserInfoEx($userid);
            $time = nowyh();
//            require_once 'condb.lib';
            $comment = "#DisableUploader|" . nowyh();
            $sql = "UPDATE tbl_userspec SET status = '0', comment_uploader = concat(comment_uploader,'$comment') WHERE userid = '$userid' AND status = '1' LIMIT 1";

            $db = \MysqliDb::getInstance();

            $ret = $db->rawQuery($sql);
            //LogAdmin("Remove uploader: $username");
            bl("Disable thành công uploader!");
            $cret = \ClassUser4S::getUploaderArrayCache(1);
        }


    }

    function payMoneyAction(){
        $this->loadViewFile(__FUNCTION__);
    }

    function payListMoneyAction(){
        $this->loadViewFile(__FUNCTION__);
    }
}