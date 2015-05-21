<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Model {

    function __construct() {
        parent::__construct();
        $ci = & get_instance();
        $this->lang->load('tank_auth');
        $this->load->library('tank_auth');
        $this->load->helper(array('form', 'url'));
    }

    /**
     * Get users
     *
     */
    function get_users($orderBy = 'email', $aOrD = 'asc', $limitFrom = NULL, $rowsperpage = NULL) {
        if ($limitFrom != NULL && is_numeric($limitFrom)) {
            $limitQuery = ' LIMIT ' . $limitFrom . ' ';
        } else {
            $limitQuery = ' LIMIT 0 ';
        }

        if ($rowsperpage != NULL && is_numeric($rowsperpage)) {
            $limitQuery .= ' ,' . $rowsperpage . ' ';
        }

        $sql = "SELECT  us.id
        ,       us.username
        ,       us.email
        ,       us.activated
        ,       us.created
        ,       us.last_login
        ,       ro.role
        ,       us.role_id 
        FROM users us
        inner join roles ro on ro.id = us.role_id
        order by " . $orderBy . " " . $aOrD . $limitQuery;
        //echo $sql;
        $query = $this->db->query($sql);

        return $query->result();
    }

    function get_total_rows() {
        $query = $this->db->query("SELECT  us.id FROM users us inner join roles ro on ro.id = us.role_id");
        return sizeof($query->result());
    }

    function get_user($uid) {
        if (!$uid || !is_numeric($uid))
            return false;

        $sql = 'SELECT u.*, r.role FROM `users` u, `roles` r WHERE u.id = ' . $uid . ' AND u.role_id = r.id LIMIT 1';
        $query = $this->db->query($sql);
        return $query->row();
    }

    /**
     * Add user
     *
     * @param   user array()
     */
    function adduser($user) {
        return true;
    }

    /**
     * Update user
     *
     * @param   user array()
     */
    function updateuser($user) {
        return true;
    }

    /**
     * Delete user
     *
     * @param   id int
     */
    function deleteuser($id) {
        return true;
    }

    /**
     * Get user role
     *
     * @param   id int
     */
    function getrolebyuserid($id) {
        $query = $this->db->query("SELECT  
        ro.role_name
        ,       us.role 
        FROM users us
        inner join roles ro on ro.id = us.role
        WHERE us.id = " . $id
        );
        if ($query->num_rows() == 1)
            return $query->row();
        return NULL;
    }

    /**
     * Get roles
     *
     * @param   bool
     */
    function get_roles() {
        $query = $this->db->query("select * from roles order by id asc");
        return $query->result();
    }

    function active_user_requested_asset($uid, $aid, $hash) {
        if (!$uid || !is_numeric($uid))
            return false;
        if (!$aid || !is_numeric($aid))
            return false;

        //--------------------validate check-----------------\
        $this->load->model('user');

        $userData = $this->get_user($uid);
        if (!$userData)
            return 'active_user_requested_asset -> user id ' . $uid . ' does not exist';
        if (!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
            return 'active_user_requested_asset -> Email address "' . $userData->email . '" of user "' . $userData->username . '" is invalid.';
        }
        $this->load->model('asset');
        $assetData = $this->asset->get_asset($aid);
        if ($assetData == false || $assetData == NULL)
            return 'active_user_requested_asset -> video id ' . $aid . ' does not exist';;
        //---------------------------------------------------/

        $userRequestAsset = $this->get_user_requested_asset($uid, $aid);
        if ($userRequestAsset == null || $userRequestAsset == false) {
            return false;
        } else {
            if ($userRequestAsset->auth_hash == $hash) {
                $auth_datetime = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 7 days'));
                $sql = 'UPDATE `user_download_request` SET `auth_datetime` = "' . $auth_datetime . '" WHERE `id` = ' . $userRequestAsset->id . '';
                $query = $this->db->query($sql);
                if ($query > 0) {
                    $this->config->load('email');
                    if ($this->config->item('smtp_from')) {
                        $from = $this->config->item('smtp_from');
                    } else {
                        $from = "support@e-cast.co.nz";
                    }
                    $to = $userData->email;

                    $baseURL = $this->config->base_url();
                    $baseURL = rtrim($baseURL, "/"); //url without trail slash


                    $this->load->library('email');
                    $this->email->set_newline("\r\n");
                    $this->email->from($from, 'e-cast support');
                    $this->email->to($to);
                    $this->email->subject('Media view video "' . $assetData->title . '" download request was actived');
                    $data['username'] = $userData->username;
                    $data['aid'] = $aid;
                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');
                    $this->email->message($this->load->view('email/download_actived-html', $data, TRUE));
                    if ($this->email->send()) {
                        //if (true) {
                        return true;
                    } else {
                        return 'active_user_requested_asset -> send email from ' . $from . ' to ' . $to . ' failed!';
                    }
                } else {
                    return null;
                }
            } else {
                return "Incorrect hash code. The new hash code may send to your mailbox when user request video download again. Please check your mailbox.";
            }
        }
    }

    function reject_user_requested_asset($uid, $aid, $hash) {
        if (!$uid || !is_numeric($uid))
            return false;
        if (!$aid || !is_numeric($aid))
            return false;

        //--------------------validate check-----------------\
        $this->load->model('user');
        $userData = $this->get_user($uid);
        if (!$userData)
            return 'reject_user_requested_asset -> user id ' . $uid . ' does not exist';
        if (!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
            return 'reject_user_requested_asset -> Email address "' . $userData->email . '" of user "' . $userData->username . '" is invalid.';
        }
        $this->load->model('asset');
        $assetData = $this->asset->get_asset($aid);
        if ($assetData == false || $assetData == NULL)
            return 'reject_user_requested_asset -> video id ' . $aid . ' does not exist';;
        //---------------------------------------------------/

        $userRequestAsset = $this->get_user_requested_asset($uid, $aid);
        if ($userRequestAsset == null || $userRequestAsset == false) {
            return false;
        } else {
            if ($userRequestAsset->auth_hash == $hash) {
                $this->config->load('email');
                if ($this->config->item('smtp_from')) {
                    $from = $this->config->item('smtp_from');
                } else {
                    $from = "support@e-cast.co.nz";
                }
                $to = $userData->email;

                $baseURL = $this->config->base_url();
                $baseURL = rtrim($baseURL, "/"); //url without trail slash


                $this->load->library('email');
                $this->email->set_newline("\r\n");
                $this->email->from($from, 'e-cast support');
                $this->email->to($to);
                $this->email->subject('Media view video "' . $assetData->title . '" download request was rejected');
                $data['username'] = $userData->username;
                $data['site_name'] = $this->config->item('website_name', 'tank_auth');
                $this->email->message($this->load->view('email/download_rejected-html', $data, TRUE));
                if ($this->email->send()) {
                    //if (true) {
                    return true;
                } else {
                    return 'reject_user_requested_asset -> send email from ' . $from . ' to ' . $to . ' failed!';
                }
            } else {
                return "Incorrect hash code. The new hash code may send to your mailbox when user request video download again. Please check your mailbox.";
            }
        }
    }

    function get_user_requested_asset($uid, $aid) {  //user filed video download request before
        if (!$uid || !is_numeric($uid))
            return false;
        if (!$aid || !is_numeric($aid))
            return false;

        $sql = "SELECT udr.* FROM `user_download_request` udr WHERE udr.uid = " . $uid . " AND udr.asset_id = " . $aid . " LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            $rows = $query->row();
            return $rows;
        } else {
            return null;
        }
    }

    function can_user_download_asset($uid, $aid) {
        if (!$uid || !is_numeric($uid))
            return false;
        if (!$aid || !is_numeric($aid))
            return false;

        $userRequestAsset = $this->get_user_requested_asset($uid, $aid);
        if ($userRequestAsset != null && $userRequestAsset != false) {  //user submited download request
            if (time() <= (strtotime($userRequestAsset->auth_datetime))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function request_download_asset($uid, $aid, $requestDetailArr) {
        if (!$uid || !is_numeric($uid))
            return false;
        if (!$aid || !is_numeric($aid))
            return false;

        if (!sizeof($requestDetailArr)) {
            return false;
        }

        $userRequestedAssetData = $this->get_user_requested_asset($uid, $aid);
        if ($userRequestedAssetData == false || $userRequestedAssetData == null) {
            $action = "insert";
        } else {
            $action = "update";
            if (strtotime($userRequestedAssetData->request_datetime) + 60 >= time()) {
                return -60;
            }
        }

        $userData = $this->get_user($uid);
        $this->load->model('asset');
        $assetData = $this->asset->get_asset($aid);
        if ($assetData == false || $assetData == NULL)
            return false;

        if (filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
            if ($userData) {
                $request_datetime = date("Y-m-d H:i:s");
                $this->load->helper('string');
                $hash = random_string('alnum', 16);

                if ($action == "insert") {
                    $sql = 'INSERT INTO `user_download_request` (`uid`, `asset_id`, `request_datetime`, `auth_hash`) VALUES (' . $uid . ',' . $aid . ',"' . $request_datetime . '", "' . $hash . '")';
                } else {
                    $sql = 'UPDATE `user_download_request` SET `request_datetime` = "' . $request_datetime . '", `auth_uid` = 0, `auth_datetime` = NULL, `auth_hash` = "' . $hash . '" WHERE `id` = ' . $userRequestedAssetData->id . '';
                }
                $query = $this->db->query($sql);
                if ($query > 0) {
                    //because of my local machine can not properly install smtp server, I choose not to waste too much time on it but 
                    //using smtp service form provider. So put some provider information into application/config/development/email.php and
                    //here to check if using provider serivce or local machine
                    $this->config->load('email');
                    if ($this->config->item('smtp_from')) {
                        $from = $this->config->item('smtp_from');
                    } else {
                        $from = "support@e-cast.co.nz";
                    }
                    if ($this->config->item('smtp_to')) {
                        $to = $this->config->item('smtp_to');
                    } else {
                        $to = "support@e-cast.co.nz";
                    }

                    $this->load->library('email');
                    $this->email->set_newline("\r\n");
                    $this->email->from($from, 'e-cast support');
                    $this->email->to($to);
                    $this->email->subject('Media view video download request from "' . $userData->username . '"');
                    $data['username'] = $userData->username;
                    $data['user_id'] = $userData->id;
                    $data['asset_title'] = $assetData->title;
                    $data['request_details'] = $requestDetailArr;
                    $data['aid'] = $aid;
                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');
                    $data['hash'] = $hash;
                    $this->email->message($this->load->view('email/download_request_received-html', $data, TRUE));
                    if ($this->email->send()) {
                        //if (true) {
                    } else {
                        log_message('error', 'request_download_asset -> send email from ' . $from . ' to ' . $to . ' failed!');
                    }

                    return true;
                } else {
                    return null;
                }
            } else {
                log_message('error', 'request_download_asset -> User does not exist for id [' . $uid . ']');
            }
        } else {
            log_message('error', 'request_download_asset -> Email address "' . $userData->email . '" of user "' . $userData->username . '" is invalid.');
        }

        return false;
    }

    function send_help_desk($requestDetailArr) {
        if (!sizeof($requestDetailArr)) {
            return false;
        }

        if (filter_var($requestDetailArr['email'], FILTER_VALIDATE_EMAIL)) {
            $this->config->load('email');
            if ($this->config->item('smtp_from')) {
                $from = $this->config->item('smtp_from');
            } else {
                $from = "support@e-cast.co.nz";
            }
            if ($this->config->item('smtp_to')) {
                $to = $this->config->item('smtp_to');
            } else {
                $to = "support@e-cast.co.nz";
            }
            $cc = "wildwindfeng@hotmail.com";
            $requestDetailArr['site_name'] = $this->config->item('website_name', 'tank_auth');
            $requestDetailArr['description'] = nl2br($requestDetailArr['description']);

            $this->load->library('email');

            //---------send email to Media view people------------\
            $this->email->set_newline("\r\n");
            $this->email->from($from, 'e-cast support');
            $this->email->to($to);
            $this->email->cc($cc);
            $this->email->subject('Media view help desk request from "' . $requestDetailArr['name'] . '"');
            $this->email->message($this->load->view('email/help_desk_to_admin-html', $requestDetailArr, TRUE));
            if ($this->email->send()) {
                
            } else {
                log_message('error', 'send_help_desk -> send email from ' . $from . ' to ' . $to . ' failed!');
            }
            //--------------------------------------------------/

            $this->email->clear();

            //----------send email to sender--------------\
            $this->email->set_newline("\r\n");
            $this->email->from($from, 'e-cast support');
            $this->email->to($requestDetailArr['email']);
            $this->email->subject('Request received: ' . $requestDetailArr['subject']);
            $this->email->message($this->load->view('email/help_desk_to_sender-html', $requestDetailArr, TRUE));
            if ($this->email->send()) {
                
            } else {
                log_message('error', 'send_help_desk -> send email from ' . $from . ' to ' . $requestDetailArr['email'] . ' failed!');
            }
            //--------------------------------------------/

            return true;
        } else {
            log_message('error', 'send_help_desk -> Email address "' . $requestDetailArr['email'] . '" for "' . $requestDetailArr['name'] . '" is invalid.');
            return -1;
        }

        return false;
    }

    function check_expiry($uid = NULL) {
        /*
          - Employee role:
          - Needs to expire 3 months (90 days) after creation (check expiry_basetime column)
          - Warning email should be sent 5 days (and each day following) before expiry prompting a re-login is needed
          - If the email bounces, send email to Izzy
          - Guest role:
          - Expires after 1 month (30 days) after creation
          - No warning email
          - Account is archived and can be reactivated at a later stage
         */
        if ($uid === NULL || !$uid || $uid == '' || !is_numeric($uid)) {  //select all users
            $sql = 'SELECT u.id, u.username, u.email, u.last_login, u.expiry_basetime, u.role_id FROM `users` u WHERE (u.role_id = 3 OR u.role_id = 4) AND u.activated = 1';
        } else {                //only uid select
            $sql = 'SELECT u.id, u.username, u.email, u.last_login, u.expiry_basetime, u.role_id FROM `users` u WHERE u.id = ' . $uid . ' LIMIT 1';
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            $userRows = $query->result();
            if (sizeof($userRows)) {
                $currentTime = time();
                $warningDays = 5;
                foreach ($userRows AS $i => $thisUser) {
                    /*
                      for those whose expiry_basetime is '0000-00-00 00:00:00', those are the users who come to the website before expiry function applied.
                      the system should set their expiry time to the default, which is the current time
                     */
                    if ($thisUser->expiry_basetime == '0000-00-00 00:00:00' || strtotime($thisUser->expiry_basetime) <= 0) {
                        $sql = 'UPDATE `users` SET `expiry_basetime` = "' . date('Y-m-d H:i:s') . '" WHERE `id` = ' . $thisUser->id . ' LIMIT 1';
                        $this->db->query($sql);
                        $thisUser->expiry_basetime = date('Y-m-d H:i:s');
                    }

                    if ($thisUser->role_id == 3) {  //employee
                        $expiryTime = strtotime($thisUser->expiry_basetime . ' + 90 days');

                        $warningStartTime = strtotime($thisUser->expiry_basetime . ' + ' . (90 - $warningDays) . ' days');

                        if ($currentTime < $warningStartTime) {
                            
                        } else if ($currentTime < $expiryTime && $currentTime >= $warningStartTime) {
                            $daysBeforeDeactive = 5 - floor(($currentTime - $warningStartTime) / 86400);
                            $this->send_expiry_warning_email($thisUser, $daysBeforeDeactive);
                        } else if ($currentTime >= $expiryTime) {
                            echo "Employee " . $thisUser->username . " expiried. Expire date was " . date("Y-m-d H:i:s", $expiryTime) . "<br />";
                            $this->set_user_active($thisUser->id, 0);
                        }
                    } else if ($thisUser->role_id == 4) {  //guest
                        $expiryTime = strtotime($thisUser->expiry_basetime . ' + 30 days');
                        if ($currentTime >= $expiryTime) {
                            echo "Guest    " . $thisUser->username . " expiried. Expire date was " . date("Y-m-d H:i:s", $expiryTime) . "<br />";
                            $this->set_user_active($thisUser->id, 0);
                        }
                    }
                }
            }
        } else {
            return NULL;
        }
    }

    function set_user_active($uid, $setTo) {
        if (!$uid || !is_numeric($uid))
            return false;
        if ($setTo != 0 && $setTo != 1)
            return false;

        if ($setTo == 0) {
            $mysql = ' , `new_email_key` = "' . md5(rand() . microtime()) . '" ';
        }

        $sql = 'UPDATE `users` SET `activated` = ' . $setTo . ' ' . $mysql . ' WHERE `id` = ' . $uid . ' LIMIT 1';
        $query = $this->db->query($sql);
        if ($query > 0) {
            return TRUE;
        } else {
            return NULL;
        }
    }

    function send_expiry_warning_email($userData, $daysBeforeDeactive) {
        $this->config->load('email');
        $this->config->load('tank_auth');


        if ($this->config->item('smtp_from')) {
            $from = $this->config->item('smtp_from');
        } else {
            $from = "support@e-cast.co.nz";
        }
        if ($this->config->item('smtp_to')) {
            $to = $this->config->item('smtp_to');
        } else {
            $to = $userData->email;
        }

        $data['username'] = $userData->username;
        $data['daysBeforeDeactive'] = $daysBeforeDeactive;
        $data['site_name'] = $this->config->item('website_name');

        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->from($from, $data['site_name']);
        $this->email->to($to);
        $this->email->subject('' . $userData->username . ', your account in the ' . $data['site_name'] . ' will be expiried in ' . $daysBeforeDeactive . ' ' . ($daysBeforeDeactive > 1 ? 'days' : 'day'));
        $this->email->message($this->load->view('email/expiry_warning-html', $data, TRUE));
        $this->email->set_alt_message($this->load->view('email/expiry_warning-txt', $data, TRUE));
        if ($this->email->send()) {
            //if (true) {
            return TRUE;
        } else {
            $this->email->clear();
            if ($this->config->item('smtp_from')) {
                $from = $this->config->item('smtp_from');
            } else {
                $from = "support@e-cast.co.nz";
            }
            if ($this->config->item('smtp_to')) {
                $to = $this->config->item('smtp_to');
            } else {
                $to = "support@e-cast.co.nz";
            }
            $this->email->set_newline("\r\n");
            $this->email->from($from, 'e-cast support');
            $this->email->to($to);
            $this->email->subject('Notifiction of email bounced for :"' . $userData->username . ', your account in the Media view will be expiried in ' . $daysBeforeDeactive . ' ' . ($daysBeforeDeactive > 1 ? 'days' : 'day') . '"');
            $message = '
		    				There was an email that should have sent to ' . $userData->email . '<br />
		    				Original email body: <br />
		    				<div style="padding:8px; margin:8px; color:grey; font-style:italic;">' . $message . '</div><br />
		    				The email address may no longer exist in the Media view<br />
		    				Please contact with Media view to establish whether or not the person still works there.<br />
		    				
		    ';
            $this->email->message($message);
            $this->email->send();
            return FALSE;
        }
    }

    public function update_expiry_time($uid, $role_id) {
        if ($role_id == 3) {   //only emplyee role get expiry_basetime updated, guest mustn't do this
            $sql = 'UPDATE `users` u SET `expiry_basetime` = "' . date('Y-m-d H:i:s') . '" WHERE `id` = ' . $uid . '';
            $query = $this->db->query($sql);
            if ($query > 0) {
                return TRUE;
            } else {
                return NULL;
            }
        }
    }

    public function get_all_user_name_id() {

//        $sql = "select id, username from users";
        $sql = "select id, email, first_name, last_name from users  where users.activated=1";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function get_userid($email) {
        $sql = "select id from users  where users.email='" . $email . "'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function active_user($id) {
        $sql = "update users set activated=1 where id=$id";
        $query = $this->db->query($sql);
         if ($query > 0) {
            return TRUE;
        } else {
            return NULL;
        }
    }



} //end of class
