<?php

class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);

        $this->load->helper('currency');
        $this->data['title'] = 'Gigs';
        $this->data['theme'] = 'user';
        $this->data['module'] = 'welcome';
        $this->load->model('user_panel_model');
        $this->load->model('gigs_model');
        $this->load->helper('custom_language');

        $default_language_select = default_language();
        if ($this->session->userdata('user_select_language') == '') {
            $this->data['user_selected'] = $default_language_select['language_value'];
        } else {
            $this->data['user_selected'] = $this->session->userdata('user_select_language');
        }

        $this->data['active_language'] = $active_lang = active_language();
        $lg = custom_language($this->data['user_selected']);
        $this->data['default_language'] = $lg['default_lang'];
        $this->data['user_language'] = $lg['user_lang'];
        $this->user_selected = (!empty($this->data['user_selected'])) ? $this->data['user_selected'] : 'en';
        $this->default_language = (!empty($this->data['default_language'])) ? $this->data['default_language'] : '';
        $this->user_language = (!empty($this->data['user_language'])) ? $this->data['user_language'] : '';

        $common_settings = gigs_settings();
        $default_currency = 'USD';
        if (!empty($common_settings)) {
            foreach ($common_settings as $datas) {
                if ($datas['key'] == 'currency_option') {
                    $default_currency = $datas['value'];
                }
            }
        }

        $this->default_currency = $default_currency;
        $this->default_currency_sign = currency_sign($default_currency);

        $this->load->helper('favourites');
        $this->smtp_config = smtp_mail_config();

        $this->email_address = 'mail@example.com';
        $this->email_tittle = 'Smoothworks';
        $this->logo_front = base_url() . 'assets/images/logo.png';
        $this->site_name = 'Smoothworks';

        //paypal
        $this->paypal_id = '';
        $paypal_option = '';
        $this->data['paypal_allow'] = '';

        $this->data['website_facebook_app_ids'] = '';
        $this->data['website_google_client_ids'] = '';

        if (!empty($common_settings)) {
            foreach ($common_settings as $data) {
                if ($data['key'] == 'email_address') {
                    $this->email_address = !empty($data['value']) ? $data['value'] : 'mail@example.com';
                }
                if ($data['key'] == 'email_tittle') {
                    $this->email_tittle = !empty($data['value']) ? $data['value'] : 'Gigs';
                }
                if ($data['key'] == 'admin_commision') {
                    $this->admin_commision = !empty($data['value']) ? $data['value'] : '0';
                }
                if ($data['key'] == 'base_domain') {
                    $this->base_domain = $data['value'];
                }
                if ($data['key'] == 'logo_front') {
                    $this->logo_front = base_url() . $data['value'];
                }
                if ($data['key'] == 'site_name' || $data['key'] == 'website_name') {
                    $this->site_name = $data['value'];
                }

                if ($data['key'] == 'paypal_option') {
                    $paypal_option = $data['value'];
                }

                if ($data['key'] == 'paypal_allow') {
                    $this->data['paypal_allow'] = $data['value'];
                }

                if ($datas['key'] == 'website_facebook_app_id') {
                    $this->data['website_facebook_app_ids'] = $datas['value'];
                }
                if ($datas['key'] == 'website_google_client_id') {
                    $this->data['website_google_client_ids'] = $datas['value'];
                }

                $this->data['currency_option'] = 'USD';
                if ($data['key'] == 'currency_option') {
                    $this->data['currency_option'] = $data['value'];
                }
            }

            if ($paypal_option == 1) {
                $this->paypal_id = $this->db->select('sandbox_email')->get('paypal_details')->row()->sandbox_email;
            }

            if ($paypal_option == 2) {
                $this->paypal_id = $this->db->select('email')->get('paypal_details')->row()->email;
            }
        }

        $this->data['client_list'] = $this->user_panel_model->get_client_list();
        $this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();
        $this->data['logo'] = $this->user_panel_model->get_logo();
        $this->data['slogan'] = $this->user_panel_model->get_slogan();
        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();
        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();
        $this->data['system_setting'] = $this->user_panel_model->system_setting();
        $this->data['policy_setting'] = $this->user_panel_model->policy_setting();
        $this->data['country_list'] = $this->user_panel_model->country_list();
        $this->data['gig_price'] = $this->gigs_model->gig_price();
        $this->data['extra_gig_price'] = $this->gigs_model->extra_gig_price();
        $this->data['price_option'] = $this->gigs_model->get_setting_price_option();

        $user_id = $this->session->userdata('SESSION_USER_ID');
        if ($user_id != '') {
            $settings = $this->gigs_model->settings();
            if (!empty($settings)) {
                foreach ($settings as $key => $value) {
                    $this->data[$key] = $value;
                }
            }
            $this->data['one_signal_user_id'] = $user_id;
        }

        $LAST_ACTIVITY = $this->session->userdata('LAST_ACTIVITY');

        if (isset($LAST_ACTIVITY) && (time() - $LAST_ACTIVITY > 86400)) {
            session_unset();     // unset $_SESSION variable for the run-time
            session_destroy();   // destroy session data in storage
            redirect(base_url());
        }

        if (($this->session->userdata('time_zone'))) {     // Getting timezone from session
            $this->data['time_zone'] = $this->session->userdata('time_zone');
        } else {
            if ($this->session->userdata('LAST_ACTIVITY') == '') {
                $this->session->set_userdata('LAST_ACTIVITY', time());
            }
        }

        if ($this->session->userdata('SESSION_USER_ID')) {
            $this->data['user_favorites'] = $this->gigs_model->add_favourites();
        }

        if ($this->session->userdata('SESSION_USER_ID')) {
            $user_id = $this->session->userdata('SESSION_USER_ID');
            $this->data['my_account_type'] = $this->session->userdata('account_type');
        }
        else {
            $this->data['my_account_type'] = 0;
        }
    }

    public function index()
    {
        $this->data['page_title'] = 'Home Page';

        $this->data['popular_gigs'] = $this->gigs_model->popular_gigs(1);

        $this->data['popular_category'] = $this->gigs_model->popular_category();

        $this->data['user_favorites'] = $this->gigs_model->add_favourites();

        $this->data['recent_gigs'] = $this->gigs_model->recent_gigs(1);

        $this->data['gigs_country'] = $this->gigs_model->gigs_country();

        $this->data['gigs_state_id'] = 0;

        $this->data['gigs_country_id'] = 0;

        $this->data['page'] = 'index';

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');
    }

    public function is_valid_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->load->model('user_login_model');
        
        $result = $this->user_login_model->check_login($username, $password);
        if (!empty($result)) {
            if ($result['verified'] == 0 && $result['status'] == 0) {

                $now_time = strtotime(date("Y-m-d"));
                $membership_expiration_date_time = strtotime($result['membership_date']);

                if($now_time >= $membership_expiration_date_time) {

                    if($result['account_type'] == 1) {
                        $this->db->where('USERID', $result['USERID']);

                        $this->db->update('members', array(
                            'membership_id' => 0,
                            'membership_type' => 0,
                            'membership_item_date' => 0,
                            'membership_date' => '0000-00-00'
                        ));
                    }
                    else {
                        $this->db->where('USERID', $result['USERID']);

                        $now = date("Y-m-d");
                        $membership_date = date_create($now);
                        date_add($membership_date, date_interval_create_from_date_string("30 days"));

                        $membership_date = date_format($membership_date, "Y-m-d");

                        $this->db->update('members', array(
                            'membership_id' => 19,
                            'membership_type' => 1,
                            'membership_item_date' => $membership_date,
                            'membership_date' => $membership_date
                        ));
                    }

                    $message = "Your Membership Period is expired. Please buy membership.";
                    $this->session->set_flashdata('error_message', $message);

                    $this->session->set_userdata('SESSION_USER_ID', $result['USERID']);
                    $this->session->set_userdata('account_type', $result['account_type']);
                    $this->session->set_userdata('account_state', 1);
                    $this->session->set_userdata('team_id', $result['team_id']);
                    $this->session->set_userdata('membership_id', 0);
                    $this->session->set_userdata('user_role', 2);
                    $this->session->set_userdata('old_timezone', $result['user_timezone']);
                    $this->session->set_userdata('unique_code', $result['unique_code']);
                    echo 'membership';
                    exit(1);
                }

                $membership_item_expiration_date = strtotime($result['membership_item_date']);
                if($now_time >= $membership_item_expiration_date) {

                    $membership_id = $result['membership_id'];

                    $this->load->model('membership_model');
                    $membership_item_date = date_create($result['membership_item_date']);
                    date_add($membership_item_date, date_interval_create_from_date_string("30 days"));

                    $membership_date = date_format($membership_date, "Y-m-d");
                    $membership_item_date = date_format($membership_item_date, "Y-m-d");
                    
                    $general_bid = 0;
                    $special_bid = 0;
                    $ongoing_project = 0;
                    $service = 0;
                    $withdrawal = 0;
                    $newsletter = 0;

                    $membership_data = $this->membership_model->get_membership_record($membership_id);
                    $membership_content = $membership_data['memberships'];
                    $membership_content = explode(',', $membership_content);
                    
                    for($i=0; $i<count($membership_content); $i++) {
                        $membership_detail = $this->membership_model->get_membership_detail_record($membership_content[$i]);
                        if($membership_detail['group'] == 7) {
                            $general_bid = $membership_detail['key'];
                        }
                        else if($membership_detail['group'] == 8) {
                            $special_bid = $membership_detail['key'];
                        }
                        else if($membership_detail['group'] == 6) {
                            $ongoing_project = $membership_detail['key'];
                        }
                        else if($membership_detail['group'] == 9) {
                            $service = $membership_detail['key'];

                            $this->load->model('api_user_model');
                            $user_record = $this->api_user_model->getUserRecord($user_id);
                            $origin_team_id = $user_record['team_id'];

                            $team_persons = 0;
                            if(!empty($origin_team_id)) {
                                $query = $this->db->query("select * from members where team_id = $origin_team_id");
                                $ret = $query->result_array();
                                $team_persons = count($ret);
                            }

                            $additional_service = round($team_persons / 3);
                            $service += $additional_service;
                        }
                        else if($membership_detail['group'] == 21) {
                            $newsletter = $membership_detail['key'];
                        }
                        else if($membership_detail['group'] == 12) {
                            $withdrawal = $membership_detail['key'];
                        }
                    }

                    $update_data = array(
                        'membership_item_date' => $membership_item_date,
                        'general_bid' => $general_bid,
                        'special_bid' => $special_bid,
                        'ongoing_project' => $ongoing_project,
                        'service' => $service,
                        'newsletter' => $newsletter,
                        'withdrawl_count' => $withdrawal
                    );

                    $this->db->where('USERID', $user_id);
                    $this->db->update('members', $update_data);
                }

                $this->session->set_userdata('SESSION_USER_ID', $result['USERID']);
                $this->session->set_userdata('account_type', $result['account_type']);
                $this->session->set_userdata('membership_id', $result['membership_id']);
                $this->session->set_userdata('account_state', 1);
                $this->session->set_userdata('team_id', $result['team_id']);
                $this->session->set_userdata('membership_date', $result['membership_date']);
                $this->session->set_userdata('user_role', 2);
                $this->session->set_userdata('old_timezone', $result['user_timezone']);
                $this->session->set_userdata('unique_code', $result['unique_code']);

                echo 1;

            } else {
                if ($result['status'] == 1 && $result['verified'] == 0) {
                    echo 3;
                } else {
                    echo 2;
                }
            }
        } else {
            echo 0;
        }
    }

    public function users_registeration()
    {
        if (($this->session->userdata('time_zone'))) {
            $this->data['time_zone'] = $this->session->userdata('time_zone');
            $this->data['full_country_name'] = $this->session->userdata('full_country_name');;
            $this->data['country_name'] = $this->session->userdata('country_name');;
        } else {
            $user_ip = getenv('REMOTE_ADDR');
            $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
            $geoplugin_latitude = $geo["geoplugin_latitude"];
            $geoplugin_longitude = $geo["geoplugin_longitude"];
            $t = time();

            $result = $this->getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude, $t);

            $this->data['time_zone'] = $result;
            $this->data['full_country_name'] = $geo['geoplugin_countryName'];
            $this->data['country_name'] = $geo['geoplugin_countryCode'];
            $this->data['dollar_rate'] = 67.08;
            $this->data['rupee_rate'] = (1 / $this->data['dollar_rate']);
            $newdata = array(
                'country_name' => $geo['geoplugin_countryCode'],
                'time_zone' => $result,
                'full_country_name' => $geo['geoplugin_countryName']
            );
            $this->session->set_userdata($newdata);
        }

        $account_type = $this->input->post('account_type_id');

        $query = $this->db->query("select * from memberships where kind = $account_type order by id asc");
        $result = $query->result_array();
        $trial_membership_id = $result[0]['id'];

        $data['username'] = $this->input->post('username');
        $data['fullname'] = ucfirst($this->input->post('name'));
        $data['email'] = $this->input->post('email');
        $data['password'] = md5($this->input->post('password'));

        if($this->input->post('affiliate_user_id')) {
            $data['affiliate_user_id'] = $this->input->post('affiliate_user_id');
        }
        else {
            $data['affiliate_user_id'] = 0;
        }
        
        $data['affiliate_url'] = base_url() . 'get/' . $this->input->post('username') . '/f=give';
        $data['account_type'] = $this->input->post('account_type_id');
        $data['membership_id'] = $trial_membership_id;
        $data['membership_type'] = 1;

        $data['verified'] = 1;
        $data['status'] = 1;

        $trial_membership_date = date_create(date("Y-m-d"));
        date_add($trial_membership_date, date_interval_create_from_date_string("30 days"));
        $trial_membership_date = date_format($trial_membership_date, "Y-m-d");

        $data['membership_date'] = $trial_membership_date;
        $data['membership_item_date'] = $trial_membership_date;

        $data['team_id'] = 0;
        
        $data['general_bid'] = 0;

        if($data['account_type'] == 1) {
            $data['general_bid'] = 5;

        }

        $data['special_bid'] = 0;
        $data['ongoing_project'] = 1;
        $data['service'] = 0;
        $data['newsletter'] = 0;

        $data['withdrawl_count'] = 1;
        $data['withdrawl_date'] = $trial_membership_date;

        $data['country'] = $this->input->post('country_id');
        $data['state'] = $this->input->post('state_id');
        $data['user_timezone'] = $this->data['time_zone'];
        date_default_timezone_set($data['user_timezone']);
        $data['created_date'] = date('Y-m-d H:i:s');

        if ($this->db->insert('members', $data)) {
            $username = $data['username'];
            $url_encypted = urlencode($this->encryptor('encrypt', $username));
            $url = base_url() . 'activate_account/' . $url_encypted;
            $this->load->model('templates_model');
            $bodyid = 13;
            $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
            $body = $tempbody_details['template_content'];
            $body = str_replace('{base_url}', $this->base_domain, $body);
            $body = str_replace('{base_image}', $this->base_domain . '/' . $this->logo_front, $body);
            $body = str_replace('{USER_NAME}', $username, $body);
            $body = str_replace('{sitetitle}', $this->site_name, $body);
            $body = str_replace('{SUBMIT_LINK}', $url, $body);
            $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
                <tr>
                    <td></td>
                    <td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                        <div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                                <tr>
                                    <td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="text-align:center;">
                                                    <a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>' . $body . '</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
                                <table width="100%">
                                    <tr>
                                        <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
                                            &copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>';

            $this->load->helper('file');
            $this->load->library('email');
            $this->email->initialize($this->smtp_config);
            $this->email->set_newline("\r\n");
            $this->email->from($this->email_address, $this->email_tittle);
            $this->email->to($data['email']);
            $this->email->subject('Welcome and thank you for joining ' . $this->site_name);
            $this->email->message($message);

            if ($this->input->server('HTTP_HOST') != 'localhost') {
                if ($this->email->send()) {
                    $this->session->set_userdata("user_registeration", "Success");
                    echo 1;
                }
            } else {
                echo 1;
            }
        } else {
            echo 2;
        }
    }

    public function change_account() {
        $account_state = $this->input->post('account_state');

        $this->load->model('api_user_model');
        $result = $this->api_user_model->change_account($account_state);
        $this->session->set_userdata('account_state', $result);
        $message = 'Change Account Successfully';
        $this->session->set_flashdata('message', $message);
        echo $result;
    }

    public function check_password()
    {
        $current_password = $this->input->post('current_password');
        if (($this->session->userdata('SESSION_USER_ID'))) {
            $user_id = $this->session->userdata('SESSION_USER_ID');
            $query = $this->db->query("SELECT `password` FROM `members` WHERE `USERID` = $user_id ;");
            $result = $query->row_array();

            if (!empty($result)) {
                if ($result['password'] == md5($current_password)) {
                    $isAvailable = TRUE;
                } else {
                    $isAvailable = FALSE;
                }
            } else {
                $isAvailable = TRUE;
            }
            echo json_encode(array('valid' => $isAvailable));
        } else {
            redirect(base_url());
        }
    }

    public function prf_crop()
    {
        $error_msg = '';
        $av_src = $this->input->post('avatar_src');
        $av_data = json_decode($this->input->post('avatar_data'), true);
        $av_file = $_FILES['avatar_file'];
        $src = 'uploads/profile_images/' . $av_file['name'];
        $imageFileType = pathinfo($src, PATHINFO_EXTENSION);
        $src2 = 'uploads/profile_images/user_' . $this->session->userdata('SESSION_USER_ID') . '_original.' . $imageFileType;
        move_uploaded_file($av_file['tmp_name'], $src2);
        $image_name = 'user_' . $this->session->userdata('SESSION_USER_ID') . '_original.' . $imageFileType;
        $new_name1 = "profile_image_" . $this->session->userdata('SESSION_USER_ID') . "_200x200." . $imageFileType;
        $data['user_profile_image'] = 'uploads/profile_images/' . $new_name1;
        $image1 = $this->prf_crop_call($image_name, $av_data, $new_name1, 200, 200);
        $new_name2 = "profile_image_" . $this->session->userdata('SESSION_USER_ID') . "_150x150." . $imageFileType;
        $image2 = $this->prf_crop_call($image_name, $av_data, $new_name2, 150, 150);
        $new_name3 = "profile_image_" . $this->session->userdata('SESSION_USER_ID') . "_50x50." . $imageFileType;
        $data['user_thumb_image'] = 'uploads/profile_images/' . $new_name3;
        $image3 = $this->prf_crop_call($image_name, $av_data, $new_name3, 50, 50);
        $rand = rand(100, 999);
        $user_id = $this->session->userdata('SESSION_USER_ID');
        $this->db->where('USERID', $user_id);
        $this->db->update('members', $data);

        $response = array(
            'state' => 200,
            'message' => $error_msg,
            'result' => 'uploads/profile_images/' . $new_name1 . '?dummy=' . $rand,
            'img_name1' => $new_name1
        );

        echo json_encode($response);
    }

    public function prf_crop_call($image_name, $av_data, $new_name, $t_width, $t_height)
    {

        $path = 'uploads/profile_images/';

        $w = $av_data['width'];

        $h = $av_data['height'];

        $x1 = $av_data['x'];

        $y1 = $av_data['y'];

        list($imagewidth, $imageheight, $imageType) = getimagesize('uploads/profile_images/' . $image_name);

        $imageType = image_type_to_mime_type($imageType);

        $ratio = ($t_width / $w);

        $nw = ceil($w * $ratio);

        $nh = ceil($h * $ratio);

        $newImage = imagecreatetruecolor($nw, $nh);

        switch ($imageType) {

            case "image/gif"  :
                $source = imagecreatefromgif('uploads/profile_images/' . $image_name);
                break;
            case "image/pjpeg":
            case "image/jpeg" :
            case "image/jpg"  :
                $source = imagecreatefromjpeg('uploads/profile_images/' . $image_name);
                break;
            case "image/png"  :
            case "image/x-png":
                $source = imagecreatefrompng('uploads/profile_images/' . $image_name);
                break;
        }

        imagecopyresampled($newImage, $source, 0, 0, $x1, $y1, $nw, $nh, $w, $h);

        switch ($imageType) {

            case "image/gif"  :
                imagegif($newImage, $path . $new_name);
                break;
            case "image/pjpeg":
            case "image/jpeg" :
            case "image/jpg"  :
                imagejpeg($newImage, $path . $new_name, 100);
                break;
            case "image/png"  :
            case "image/x-png":
                imagepng($newImage, $path . $new_name);
                break;
        }

    }

    public function profile()
    {
        if (($this->session->userdata('SESSION_USER_ID'))) {

            $user_id = $this->session->userdata('SESSION_USER_ID');

            if ($this->input->post('form_submit')) {

                $data['phone'] = $this->input->post('phone');
                $data['description'] = $this->input->post('user_desc');
                $data['country'] = $this->input->post('country_id');
                $data['state'] = $this->input->post('state_id');
                $data['fullname'] = $this->input->post('user_name');
                $data['language'] = $this->input->post('language_tags');

                $this->db->where('USERID', $user_id);

                if ($this->db->update('members', $data)) {
                    $message = (!empty($this->user_language[$this->user_selected]['lg_profile_updated_successfully'])) ? $this->user_language[$this->user_selected]['lg_profile_updated_successfully'] : $this->default_language['en']['lg_profile_updated_successfully'];
                    $this->session->set_flashdata('message', $message);
                    redirect(base_url() . 'profile', 'refresh');
                }
            }

            $this->data['page_title'] = 'Profile Page';
            $this->data['country_list'] = $this->user_panel_model->country_list();
            $this->data['module'] = 'profile';
            $this->data['page'] = 'index';

            $profile = $this->user_panel_model->profile($user_id);
            $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =" . $profile['country'] . "");
            $result = $query->row_array();
            $this->data['country_shortname'] = $result['sortname'];
            $this->data['country_name'] = $result['country'];
            $this->data['profile'] = $profile;
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');
        } else {
            redirect(base_url());
        }
    }

    public function password()
    {
        if (($this->session->userdata('SESSION_USER_ID'))) {

            $user_id = $this->session->userdata('SESSION_USER_ID');

            if ($this->input->post('form_submit')) {

                $data['password'] = md5($this->input->post('repeat_password'));

                $this->db->where('USERID', $user_id);

                if ($this->db->update('members', $data)) {

                    $message = (!empty($this->user_language[$this->user_selected]['lg_password_updated_successfully'])) ? $this->user_language[$this->user_selected]['lg_password_updated_successfully'] : $this->default_language['en']['lg_password_updated_successfully'];
                    $this->session->set_flashdata('message', $message);

                    redirect(base_url() . 'password');

                }
            }

            $user_id = $this->session->userdata('SESSION_USER_ID');

            $this->data['module'] = 'password';

            $this->data['page'] = 'index';

            $profile = $this->user_panel_model->profile($user_id);

            $query = $this->db->query("SELECT `sortname`, country FROM `country` WHERE `id` =".$profile['country']);

            $result = $query->row_array();

            $this->data['country_shortname'] = $result['sortname'];

            $this->data['country_name'] = $result['country'];

            $this->data['profile'] = $profile;

            $this->data['page_title'] = 'Password';

            $this->load->vars($this->data);

            $this->load->view($this->data['theme'] . '/template');

        } else {
            redirect(base_url());
        }

    }

    public function payment()
    {
        if (($this->session->userdata('SESSION_USER_ID'))) {
            $user_id = $this->session->userdata('SESSION_USER_ID');

            if ($this->input->post('form_submit')) {

                $data['paypal_email'] = $this->input->post('paypal_email');

                $this->db->where('USERID', $user_id);
                if ($this->db->update('members', $data)) {

                    $message = (!empty($this->user_language[$this->user_selected]['lg_your_paypal_id_successfully_updated'])) ? $this->user_language[$this->user_selected]['lg_your_paypal_id_successfully_updated'] : $this->default_language['en']['lg_your_paypal_id_successfully_updated'];

                    $this->session->set_flashdata('message', $message);

                    redirect(base_url() . 'payment-settings');
                }
            }

            $this->data['module'] = 'payment';
            $this->data['page'] = 'index';

            $profile = $this->user_panel_model->profile($user_id);
            $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =" . $profile['country']);
            $result = $query->row_array();

            $this->data['country_shortname'] = $result['sortname'];
            $this->data['country_name'] = $result['country'];
            $this->data['profile'] = $profile;
            $this->data['page_title'] = 'Payment Settings';
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');

        } else {
            redirect(base_url());
        }
    }

    public function user_profile($username, $start = 0)
    {
        $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];
        $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

        $this->data['gigs_country'] = $this->gigs_model->gigs_country();
        $this->load->library('pagination');
        $username = urldecode($username);

        $config['base_url'] = base_url("user-profile/" . $username);
        $config['per_page'] = 8;
        $config['total_rows'] = $this->gigs_model->username_base_gigs($username, 0, 0, 0);
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = $first;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_link'] = $last;
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $this->data['links'] = $this->pagination->create_links();
        $this->data['list'] = $this->gigs_model->username_base_gigs($username, 1, $start, $config['per_page']);
        $this->data['user_favorites'] = $this->gigs_model->add_favourites();

        $profile = $this->gigs_model->profile($username);

        $result = array();
        if (empty($profile)) {
            redirect(base_url());
        }

        $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =" . $profile['country'] . " ");
        $result = $query->row_array();
        $this->data['user_created'] = date('Y-m-d H:i:s', strtotime($profile['created_date']));
        $this->data['time_zone'] = $profile['user_timezone'];
        $this->data['completed_gigs'] = 0;

        $query1 = $this->db->query("SELECT * FROM `payments` WHERE user_id = " . $profile['USERID'] . " AND `status` = 2 ");
        $result1 = $query1->num_rows();

        if (!empty($result1)) {
            $this->data['completed_gigs'] = $result1;
        }

        $suser_id = $profile['USERID'];

        $query_feed = $this->db->query("
            SELECT 
            feedback.*,
            sell_gigs.title,
            members.fullname,
            members.username,
            members.USERID,
            members.`user_thumb_image`,
            members.`user_profile_image`
            FROM `feedback`
            left join members on members.USERID = feedback.`from_user_id`
            left join sell_gigs on sell_gigs.id = feedback.`gig_id`
            WHERE  sell_gigs.user_id = $suser_id AND feedback.to_user_id = $suser_id AND feedback.`status` = 1 ");

        $result_feed = $query_feed->result_array();

        $this->data['feedbacks'] = $result_feed;

        $query_feed = $this->db->query("
            SELECT 
                AVG(feedback.rating),
                count(feedback.id) 
            FROM `feedback`
            left join sell_gigs on sell_gigs.id = feedback.`gig_id`
            WHERE sell_gigs.user_id = $suser_id AND feedback.`to_user_id` = $suser_id;");

        $fe_count = $query_feed->row_array();
        $rat = 0;
        $rat_count = 0;

        if ($fe_count['AVG(feedback.rating)'] != '') {
            $rat = round($fe_count['AVG(feedback.rating)']);
            $rat_count = round($fe_count['count(feedback.id)']);
        }

        $this->data['user_feedback'] = $rat;
        $this->data['user_feedbackcount'] = $rat_count;
        $this->data['country_shortname'] = $result['sortname'];
        $this->data['country_name'] = $result['country'];
        $this->data['user_id'] = $profile['USERID'];
        $this->data['profile_user_id'] = $profile['USERID'];
        $this->data['profile'] = $profile;
        $this->data['user_gigs'] = $this->gigs_model->username_base_gigs($username, 1, 0, 0);


        $user_id = $this->session->userdata('SESSION_USER_ID');

        $this->load->model('api_user_model');
        $session_user_data = $this->api_user_model->getUserRecord($user_id);

        $this->data['session_user_data'] = $session_user_data;

        $this->data['module'] = 'user_profile';
        $this->data['page'] = 'index';
        $this->data['page_title'] = 'User Profile';

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');

    }

    public function terms()
    {
        $this->load->model('admin_panel_model');

        $this->data['lists'] = $this->admin_panel_model->get_terms();

        $this->data['page_title'] = 'Terms of condition';

        $this->data['module'] = 'terms';

        $this->data['page'] = 'index';

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');
    }

    public function multiple_delete()
    {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/dashboard/terms');

        } else {
            $id = explode(',', $this->input->post('multi_Delete'));
            for ($i = 0; $i < count($id); $i++) {
                $this->db->where('id', $id[$i]);
                $result = $this->db->delete('term');
            }

            if ($result) {
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Terms Successfully Deleted.</div>";
                //echo 1;
            }
            $this->session->set_flashdata('message', $message);
            redirect(base_url() . 'admin/dashboard/terms');
        }
    }

    public function tandc()
    {
        $this->load->model('admin_panel_model');

        $this->data['lists'] = $this->admin_panel_model->get_terms();

        $this->data['page_title'] = 'Terms of condition';

        $this->data['module'] = 'tandc';

        $this->data['page'] = 'index';

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');
    }

    public function check_username_availability()
    {

        $username = $this->input->get('username');

        $result = $this->user_panel_model->check_username($username);

        if ($result > 0) {

            $isAvailable = FALSE;

        } else {
            $isAvailable = TRUE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            ));
    }

    public function check_registered_email()
    {
        $email = $this->input->post('forget_email');

        $result = $this->user_panel_model->check_email($email);

        if ($result > 0) {

            $isAvailable = TRUE;

        } else {
            $isAvailable = FALSE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            ));

    }

    public function check_username()
    {
        $username = $this->input->post('username');
        $result = $this->user_panel_model->check_username($username);
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }

        echo json_encode(

            array(

                'valid' => $isAvailable

            ));

    }

    public function update_name()
    {
        $data['fullname'] = $this->input->post('updated_name');

        if (($this->session->userdata('SESSION_USER_ID'))) {
            $user_id = $this->session->userdata('SESSION_USER_ID');
        }

        $this->db->where('USERID', $user_id);
        if ($this->db->update('members', $data)) {
            echo 1;
        }
    }

    public function check_available_email()
    {

        $email = $this->input->post('forget_email');
        $result = $this->user_panel_model->check_email($email);
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            ));

    }

    public function activate_account()
    {
        if ($this->uri->segment(2))
            $user_name = $this->uri->segment(2);

        $username = $this->encryptor('decrypt', $user_name);

        if (!empty($username)) {
            $data['verified'] = 0;
            $data['status'] = 0;
            $this->db->update('members', $data, array('username' => $username));
            $this->session->set_userdata('users_account_activate', "success");
            redirect(base_url());
        }

        redirect(base_url());
    }

    public function change_password()
    {
        if ($this->uri->segment(2))
            $user_name = trim($this->uri->segment(2));
            
        $query = $this->db->query("select forget from `members` where forget='$user_name'");

        $num = $query->num_rows();

        if ($num != 0) {

            $username = $this->encryptor('decrypt', $user_name);

            if ($this->input->post('form_submit')) {

                $data['password'] = md5($this->input->post('new_password'));

                $data['forget'] = '';

                $username = $this->input->post('user_name');

                $this->db->where('username', $username);

                $this->db->update('members', $data);

                $message = (!empty($this->user_language[$this->user_selected]['lg_the_password_updated__successfully_please_login_again'])) ? $this->user_language[$this->user_selected]['lg_the_password_updated__successfully_please_login_again'] : $this->default_language['en']['lg_the_password_updated__successfully_please_login_again'];

                $this->session->set_flashdata('message', $message);

                redirect(base_url());

            }

        } else {

            $message = (!empty($this->user_language[$this->user_selected]['lg_the_email_has_been_expired'])) ? $this->user_language[$this->user_selected]['lg_the_email_has_been_expired'] : $this->default_language['en']['lg_the_email_has_been_expired'];

            $this->session->set_flashdata('message', $message);

            redirect(base_url());

        }


        if (!empty($username)) {

            $this->data['title'] = $this->email_tittle;

            $this->data['page_title'] = 'Change Password';

            $this->data['username'] = $username;

            $this->data['page'] = 'forget_password';

            $this->data['module'] = 'forget_password';

            $this->load->vars($this->data);

            $this->load->view($this->data['theme'] . '/template');

        }

    }

    function encryptor($action, $string)
    {

        $output = false;

        $encrypt_method = "AES-256-CBC";

        //pls set your unique hashing key

        $secret_key = 'muni';

        $secret_iv = 'muni123';


        // hash

        $key = hash('sha256', $secret_key);


        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning

        $iv = substr(hash('sha256', $secret_iv), 0, 16);


        //do the encyption given text/string/number

        if ($action == 'encrypt') {

            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

            $output = base64_encode($output);

        } else if ($action == 'decrypt') {

            //decrypt the given text/string/number

            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        }


        return $output;

    }

//    private function randomPassword()
//    {
//        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*_-";
//        $pass = array(); //remember to declare $pass as an array
//        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
//        for ($i = 0; $i < 8; $i++) {
//            $n = rand(0, $alphaLength);
//            $pass[] = $alphabet[$n];
//        }
//        return implode($pass); //turn the array into a string
//    }

//    public function sociallogin_registration()
//    {
//        if (($this->session->userdata('time_zone'))) {
//
//            $this->data['time_zone'] = $this->session->userdata('time_zone');
//
//            $this->data['full_country_name'] = $this->session->userdata('full_country_name');;
//
//            $this->data['country_name'] = $this->session->userdata('country_name');;
//
//        } else {
//
//            $user_ip = getenv('REMOTE_ADDR');
//
//            $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
//
//            $geoplugin_latitude = $geo["geoplugin_latitude"];
//
//            $geoplugin_longitude = $geo["geoplugin_longitude"];
//
//            $t = time();
//
//            $result = $this->getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude, $t);
//
//            $this->data['time_zone'] = $result;
//
//            $this->data['full_country_name'] = $geo['geoplugin_countryName'];
//
//            $this->data['country_name'] = $geo['geoplugin_countryCode'];
//
//            $this->data['dollar_rate'] = 67.08;
//
//            $this->data['rupee_rate'] = (1 / $this->data['dollar_rate']);
//
//            $newdata = array(
//
//                'country_name' => $geo['geoplugin_countryCode'],
//
//                'time_zone' => $result,
//
//                'full_country_name' => $geo['geoplugin_countryName']
//
//            );
//
//            $this->session->set_userdata($newdata);
//
//        }
//
//        $password = $this->randomPassword();
//
//        $email = $this->input->post('email');
//        $auth = $this->input->post('auth');
//        $profileurl = $this->input->post('profileurl');
//
//        $emails = strstr($email, '@', true);
//        $username = str_replace(' ', '-', $emails);
//        if ($auth == 'Google') {
//            $username = preg_replace('/[^A-Za-z0-9\-]/', '', $username . 'gp');
//        }
//
//        if ($auth == 'Facebook') {
//            $username = preg_replace('/[^A-Za-z0-9\-]/', '', $username . 'fb');
//        }
//
//        if (!empty($profileurl)) {
//            $content = file_get_contents($profileurl);
//            $fp = fopen("uploads/profile_images/" . $username . "", "w");
//            fwrite($fp, $content);
//        }
//
//        $already_social_login = $this->user_login_model->check_already_social_login($this->input->post('email'), $this->input->post('profileid'));
//
//        if ($already_social_login) {
//            $data['fullname'] = ucfirst($this->input->post('fullname'));
//            if ($auth == 'Google') {
//                $data['google_id'] = $this->input->post('profileid');
//            }
//
//            if ($auth == 'Facebook') {
//                $data['facebook_id'] = $this->input->post('profileid');
//            }
//
//            if (!empty($profileurl)) {
//
//                $data['profileurl'] = $this->input->post('profileurl');
//
//                $data['user_profile_image'] = 'uploads/profile_images/' . $username;
//
//                $data['user_thumb_image'] = 'uploads/profile_images/' . $username;
//
//            }
//
//            $data['user_timezone'] = $this->data['time_zone'];
//
//            date_default_timezone_set($data['user_timezone']);
//
//            $data['created_date'] = date('Y-m-d H:i:s');
//
//            $data['verified'] = 0;
//
//            $data['status'] = 0;
//            $this->db->where('USERID', $already_social_login['USERID']);
//            if ($this->db->update('members', $data)) {
//                $results = $this->user_login_model->check_social_login($already_social_login['USERID']);
//                $this->session->set_userdata('SESSION_USER_ID', $results['USERID']);
//                $this->session->set_userdata('user_role', 2);
//                $this->session->set_userdata('old_timezone', $results['user_timezone']);
//                $this->session->set_userdata('unique_code', $results['unique_code']);
//                echo 1;
//            } else {
//
//                echo 0;
//
//            }
//        } else {
//            $data['username'] = $username;
//
//            $data['password'] = md5($password);
//
//            $data['email'] = $this->input->post('email');
//
//            $data['fullname'] = ucfirst($this->input->post('fullname'));
//
//            if ($auth == 'Google') {
//                $data['google_id'] = $this->input->post('profileid');
//            }
//
//            if ($auth == 'Facebook') {
//                $data['facebook_id'] = $this->input->post('profileid');
//            }
//
//            if (!empty($profileurl)) {
//
//                $data['profileurl'] = $this->input->post('profileurl');
//
//                $data['user_profile_image'] = 'uploads/profile_images/' . $username;
//
//                $data['user_thumb_image'] = 'uploads/profile_images/' . $username;
//
//            }
//
//            $data['user_timezone'] = $this->data['time_zone'];
//
//            date_default_timezone_set($data['user_timezone']);
//
//            $data['created_date'] = date('Y-m-d H:i:s');
//
//            $data['verified'] = 0;
//
//            $data['status'] = 0;
//
//            if ($this->db->insert('members', $data)) {
//
//                $last_update_id = $this->db->insert_id();
//                $results = $this->user_login_model->check_social_login($last_update_id);
//                $this->session->set_userdata('SESSION_USER_ID', $results['USERID']);
//                $this->session->set_userdata('user_role', 2);
//                $this->session->set_userdata('old_timezone', $results['user_timezone']);
//                $this->session->set_userdata('unique_code', $results['unique_code']);
//
//                $this->load->model('templates_model');
//
//                $message = '';
//
//                $welcomemessage = '';
//
//                $bodyid = 35;
//
//                $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
//
//                $body = $tempbody_details['template_content'];
//
//
//                $body = str_replace('{USER_NAME}', $username, $body);
//
//                $body = str_replace('{sitetitle}', $this->site_name, $body);
//
//                $body = str_replace('{full_name}', ucfirst($this->input->post('fullname')), $body);
//
//                $body = str_replace('{password}', $password, $body);
//
//
//                $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
//
//                      <tr>
//
//                        <td></td>
//
//                        <td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
//
//                          <div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
//
//                            <table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
//
//                              <tr>
//
//                                <td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
//
//                                  <table width="100%" cellpadding="0" cellspacing="0">
//
//                                    <tr>
//
//                                      <td style="text-align:center;">
//
//                                        <a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
//
//                                      </td>
//
//                                    </tr>
//
//                                    <tr>
//
//                                      <td>' . $body . '</td>
//
//                                    </tr>
//
//                                  </table>
//
//                                </td>
//
//                              </tr>
//
//                            </table>
//
//                            <div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
//
//                              <table width="100%">
//
//                                <tr>
//
//                                  <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
//
//                                    &copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
//
//                                  </td>
//
//                                </tr>
//
//                              </table>
//
//                            </div>
//
//                          </div>
//
//                        </td>
//
//                      </tr>
//
//                    </table>';
//
//                $this->load->helper('file');
//
//                $this->load->library('email');
//                $this->email->initialize($this->smtp_config);
//                $this->email->set_newline("\r\n");
//
//                $this->email->from($this->email_address, $this->email_tittle);
//
//                $this->email->to($data['email']);
//
//                $this->email->subject('Welcome and thank you for joining ' . $this->site_name);
//
//                $this->email->message($message);
//                if ($this->input->server('HTTP_HOST') != 'localhost') {
//                    $this->email->send();
//
//                }
//
//
//                echo 1;
//
//            } else {
//
//                echo 0;
//
//            }
//        }
//
//
//    }

    function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude, $t)
    {
        $json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");

        $data = json_decode($json, true);

        $tzone = $data['timeZoneId'];

        return $tzone;
    }

    public function forgot_password()
    {
        $email_id = $this->input->post('forget_email');
        $query = $this->db->query("SELECT username FROM  `members` WHERE  `email` =  '$email_id'");
        $username = $query->row_array();
        $username = trim($username['username']);
        $url_encypted = urlencode($this->encryptor('encrypt', $username));
        $query = $this->db->query("Update  `members` SET forget='$url_encypted' WHERE `email` =  '$email_id'");
        $url = base_url() . 'change_password/' . $url_encypted;
        $this->load->model('templates_model');
        $message = '';
        $bodyid = 14;
        $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
        $body = $tempbody_details['template_content'];
        $body = str_replace('{sitetitle}', $this->site_name, $body);
        $body = str_replace('{base_url}', $this->base_domain, $body);
        $body = str_replace('{base_image}', $this->base_domain . '/' . $this->logo_front, $body);
        $body = str_replace('{USER_NAME}', $username, $body);
        $body = str_replace('{SUBMIT_LINK}', $url, $body);

        $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
                        <tr>
                            <td></td>
                            <td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                                <div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                                        <tr>
                                            <td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="text-align:center;">
                                                            <a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>' . $body . '</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
                                        <table width="100%">
                                            <tr>
                                                <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
                                                    &copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>';
        $this->load->helper('file');
        $this->load->library('email');
        $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");
        $this->email->from($this->email_address, $this->email_tittle);
        $this->email->to($email_id);
        $this->email->subject('Forgot Password on ' . $this->site_name);
        $this->email->message($message);

        if ($this->email->send()) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function pages($param)
    {
        $param = rawurldecode(utf8_decode($param));

        $query = $this->db->query("SELECT * FROM `footer_submenu` WHERE `footer_submenu` = '$param'; ");

        $this->data['list'] = $query->row_array();

        $this->data['module'] = 'pages';

        $this->data['page'] = 'page';

        $this->data['page_title'] = $param;

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');
    }

    public function invite_friend() {

        $this->data['module'] = 'invite_friend';
        $this->data['page'] = 'index.php';
        $this->data['page_title'] = 'Invite Friend';

        $this->load->model('api_user_model');
        $user_id = $this->session->userdata('SESSION_USER_ID');
        $user_record = $this->api_user_model->getUserRecord($user_id);

        $this->data['affiliate_url'] = $user_record['affiliate_url'];

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function affiliate($username, $param) {
        
        if($param != 'f=give') {
            redirect(base_url());
        }

        $query = $this->db->query("select * from members where username = '$username'");
        $result = $query->result_array();
        $user_id = $result[0]['USERID'];

        $this->data['affiliate_user_id'] = $user_id;

        $this->data['module'] = 'affiliate_user';
        $this->data['page'] = 'index';
        $this->data['page_title'] = "User Registeration";
        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');

    }

    public function logout()
    {
        $data = array('LAST_ACTIVITY', 'dollar_rate', 'rupee_rate', 'country_name', 'time_zone', 'full_country_name', 'SESSION_USER_ID', 'old_timezone', 'user_role');

        $this->session->unset_userdata($data);

        $this->session->sess_destroy();

        redirect(base_url());
    }
}

?>