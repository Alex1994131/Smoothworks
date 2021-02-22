<?php

class Membership extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->helper('currency');
        $this->load->library('paypal_lib');
        $this->load->model('gigs_model');
        $this->load->model('user_panel_model');
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

        $this->data['theme'] = 'user';
        $this->data['module'] = 'membership';
        $this->data['slogan'] = $this->user_panel_model->get_slogan();
        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();
        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();
        $this->data['system_setting'] = $this->user_panel_model->system_setting();
        $this->data['policy_setting'] = $this->user_panel_model->policy_setting();
        $this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();
        $this->data['country_list'] = $this->user_panel_model->country_list();

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

                if ($data['key'] == 'paypal_allow') {
                    $this->data['paypal_allow'] = $data['value'];
                }
                if ($data['key'] == 'paypal_option') {
                    $paypal_option = $data['value'];
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

        if (($this->session->userdata('time_zone'))) {
            $this->data['time_zone'] = $this->session->userdata('time_zone');
            $this->data['full_country_name'] = $this->session->userdata('full_country_name');
            $this->data['country_name'] = $this->session->userdata('country_name');
        } else {
            $user_ip = getenv('REMOTE_ADDR');
        }

        if ($this->session->userdata('SESSION_USER_ID')) {
            $this->data['my_account_type'] = $this->session->userdata('account_type');
        }
        else {
            $this->data['my_account_type'] = 0;
        }

        $gig_price = $this->gigs_model->gig_price();
        $this->data['gigs_country'] = $this->gigs_model->gigs_country();
        $this->data['gig_price'] = $gig_price['value'];
        $extra_gig_price = $this->gigs_model->gig_price();
        $this->data['extra_gig_price'] = $extra_gig_price['value'];
        $this->data['gigs_country'] = $this->gigs_model->gigs_country();
    }

    public function index()
    {
        $user_id = $this->session->userdata('SESSION_USER_ID');
        $this->load->model('membership_model');
        $this->load->model('api_user_model');

        $my_balances = $this->api_user_model->get_my_usd_balances($user_id);
        if(empty($my_balances)) {
            $my_balances = 0;
        }
        
        $this->data['my_balance'] = $my_balances;

        $record = $this->api_user_model->getUserRecord($user_id);

        $this->data['membership_id'] = $membership_id =  $this->membership_model->get_membershipID($user_id);

        
        $this->data['account_type'] = $this->session->userdata('account_type');
        $this->data['membership_freelancer'] = $this->membership_model->get_membershipFreelancer();
        $this->data['membership_client'] = $this->membership_model->get_membershipClient();
        $this->data['membership_details'] = $this->membership_model->get_membership_detail();
        
        if($membership_id == 0) {
            $this->data['margin_price'] = 0;
            $this->data['membership_type'] = 0;
        }
        else {
            $this->data['membership_type'] = $record['membership_type'];
            $this->data['membership_level'] = $this->membership_model->get_membershiplevel($membership_id);

            $origin_membership_id = $membership_id;
            $origin_membership_date = $record['membership_date'];
            $origin_membership_type = $record['membership_type'];

            $query = $this->db->query('select * from memberships where id = ' . $origin_membership_id);
            $result = $query->result_array();
            $membership_content = $result[0]['memberships'];
            $membership_content = explode(',', $membership_content);

            $origin_membership_price = 0;
            for($i=0; $i<count($membership_content); $i++) {
                $membership_detail = $this->membership_model->get_membership_detail_record($membership_content[$i]);
                if($origin_membership_type == 1) {
                    if($membership_detail['group'] == 1) {
                        $origin_membership_price = $membership_detail['key'];
                    }
                }
                else if($origin_membership_type == 2) {
                    if($membership_detail['group'] == 2) {
                        $origin_membership_price = $membership_detail['key'];
                    }
                }
                else if($origin_membership_type == 3) {
                    if($membership_detail['group'] == 3) {
                        $origin_membership_price = $membership_detail['key'];
                    }
                }
            }

            $today=date_create(date('Y-m-d'));
            $origin_membership_date=date_create($origin_membership_date);
            $diff=date_diff($today,$origin_membership_date);
            $diff = $diff->format("%a");

            $margin_price = 0;
            if($origin_membership_type == 1) {
                $unit = 5;
            }
            else if($origin_membership_type == 2) {
                $unit = 15;
            }
            else if($origin_membership_type == 3) {
                $unit = 60;
            }

            $margin_price = floor($diff/$unit)*$origin_membership_price/6;
            $this->data['margin_price'] = $margin_price;
        }
        
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function up_downgrade_membership() {
        $account_type = $this->input->post('account_type');
        $membership_price = $this->input->post('price');
        $membership_id = $this->input->post('membership_id');
        $membership_type = $this->input->post('membership_type');
        $user_id = $this->session->userdata('SESSION_USER_ID');

        $currency_type = 'USD';

        $data['user_id'] = $this->session->userdata('SESSION_USER_ID');
        $data['item_id'] = $membership_id;
        $data['currency'] = $currency_type;
        $data['time_zone'] = $this->session->userdata('time_zone');
        $data['price'] = $membership_price;
        $data['type'] = 0;
        $data['remark'] = 'membership';
        $data['status'] = 3;
        $data['pay_method'] = 'Balances';
        $data['txn_id'] = 0;
        $data['created_date'] = date('Y-m-d H:i:s');
        $data['updated_date'] = date('Y-m-d H:i:s');

        $this->load->model('api_user_model');
        $my_usd_balances = $this->api_user_model->get_my_usd_balances($user_id);

        $new_balances = $my_usd_balances - $membership_price;

        if ($this->db->insert('payments', $data)) {
            $this->load->model('membership_model');
            $result = $this->membership_model->up_downgrade_membership($user_id, $membership_id, $membership_type, $account_type, $new_balances);

            if($result == 'success') {
                $message = (!empty($this->user_language[$this->user_selected]['lg_account_upgrade_success_message'])) ? $this->user_language[$this->user_selected]['lg_account_upgrade_success_message'] : $this->default_language['en']['lg_account_upgrade_success_message'];
                $this->session->set_flashdata('message', $message);
            }
            else{
                $message = (!empty($this->user_language[$this->user_selected]['lg_account_upgrade_failure_message'])) ? $this->user_language[$this->user_selected]['lg_account_upgrade_failure_message'] : $this->default_language['en']['lg_account_upgrade_failure_message'];
                $this->session->set_flashdata('message', $message);
            }
            echo $result;   
        }
    }

    public function payment() {
        if ($this->input->post('submit')) {

            $membership_id = $this->input->post('membership_id');
            $membership_level = $this->input->post('membership_level');
            $membership_price = $this->input->post('membership_price');

            $membership_type = $this->input->post('membership_type');
            $account_type = $this->input->post('account_type');
            $access_token = $this->input->post('access_token');
            $pay_method = $this->input->post('group2');
            $currency_type = 'USD';

            $data['user_id'] = $this->session->userdata('SESSION_USER_ID');
            $data['item_id'] = $membership_id;
            $data['currency'] = $currency_type;
            $data['time_zone'] = $this->session->userdata('time_zone');
            $data['price'] = $membership_price;
            $data['type'] = 0;
            $data['remark'] = 'membership';
            $data['status'] = 0;
            $data['pay_method'] = $pay_method;
            $data['txn_id'] = 0;
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['updated_date'] = date('Y-m-d H:i:s');

            if ($this->db->insert('payments', $data)) {
                $insert_id = $this->db->insert_id();
                $this->buy($insert_id, $data, $access_token);
            }
        }
    }

    function buy($id, $data, $token)
    {
        $pay_method = $data['pay_method'];
        if($pay_method == 'paypal') {
            $returnURL = base_url() . 'user/membership/paypal_success/';
            $cancelURL = base_url() . 'user/membership/paypal_cancel';
            $notifyURL = base_url() . 'user/membership/ipn';

            $item_name = $data['item_id'];
            $custom = $data['user_id'];
            $item_number = $id;
            $amount = $data['price'];
            $amount = intval(($amount * 100)) / 100;
            $currency_type = $data['currency'];

            $this->paypal_lib->add_field('return', $returnURL);
            $this->paypal_lib->add_field('cancel_return', $cancelURL);
            $this->paypal_lib->add_field('notify_url', $notifyURL);
            $this->paypal_lib->add_field('item_name', $item_name);
            $this->paypal_lib->add_field('custom', $custom);
            $this->paypal_lib->add_field('item_number', $item_number);
            $this->paypal_lib->add_field('amount', $amount);
            $this->paypal_lib->add_field('currency_code', $currency_type);
            $this->paypal_lib->add_field('business', $this->paypal_id);
            $this->paypal_lib->paypal_auto_form();
        }
    }

    function paypal_success()
    {
        if (isset($_POST["txn_id"]) && !empty($_POST["txn_id"])) {
            $paypalInfo = $this->input->post();
            $txn_id = $paypalInfo['txn_id'];
            $item_number = $paypalInfo['item_number'];
        } else {
            $paypalInfo = $this->input->get();
            $txn_id = $paypalInfo['tx'];
            $item_number = $paypalInfo['item_number'];
        }

        $uid = $item_number;
        $table_data['txn_id'] = $txn_id;
        $table_data['status'] = 1;

        $this->db->where('id', $uid);
        $this->db->update('payments', $table_data);

        // $email_details = $this->gigs_model->gig_purchase_requirements($uid);

        // $title = $email_details['title'];
        // $gig_preview_link = base_url() . 'gig-preview/' . $title;
        // $img_path = base_url() . $email_details['gig_image_thumb'];
        // $toemail = $email_details['email'];
        // $currency = (!empty($email_details['currency'])) ? $email_details['currency'] : 'USD';
        // $sign = currency_sign($currency);
        // $gig_price = $sign . $email_details['price'];
        // $user_profile_link = base_url() . 'user-profile/' . $email_details['buyer_username'];

        // $tot_al = (!empty($this->user_language[$this->user_selected]['lg_total'])) ? $this->user_language[$this->user_selected]['lg_total'] : $this->default_language['en']['lg_total'];

        // $h_all = '<tr>
		// 	<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">' . $tot_al . '</td>
		// 	<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">' . $sign . ' ' . $email_details['price'] . '</td>
		// 	</tr>';

        // $request_link = base_url() . 'sales';
        // $this->load->model('templates_model');
        // $bodyid = 22;
        // $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
        // $body = $tempbody_details['template_content'];

        // $body = str_replace('{base_url}', $this->base_domain, $body);
        // $body = str_replace('{gig_owner}', $email_details['seller_name'], $body);
        // $body = str_replace('{buyer_name}', $email_details['buyer_name'], $body);
        // $body = str_replace('{title}', str_replace("-", " ", $title), $body);
        // $body = str_replace('{title_url}', $title, $body);
        // $body = str_replace('{PAYPAL_ID}', $txn_id, $body);
        // $body = str_replace('{ITEM_NAME}', str_replace("-", " ", $title), $body);
        // $body = str_replace('{PRICE}', $gig_price, $body);
        // $body = str_replace('{BUYER_LINK}', $user_profile_link, $body);
        // $body = str_replace('{TEABLE_ROW}', $h_all, $body);
        // $body = str_replace('{IMG_SRC}', $img_path, $body);
        // $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
        // $body = str_replace('{request_link}', $request_link, $body);
        // $body = str_replace('{site_name}', $this->site_name, $body);

        // $seller_message = $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
		// 	<tr>
		// 	<td></td>
		// 	<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
		// 	<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
		// 	<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
		// 	<tr>
		// 	<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
		// 	<table width="100%" cellpadding="0" cellspacing="0">
		// 	<tr>
		// 	<td style="text-align:center;">
		// 	<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
		// 	</td>
		// 	</tr>
		// 	<tr>
		// 	<td>' . $body . '</td>
		// 	</tr>
		// 	</table>
		// 	</td>
		// 	</tr>
		// 	</table>
		// 	<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
		// 	<table width="100%">
		// 	<tr>
		// 	<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
		// 	&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
		// 	</td>
		// 	</tr>
		// 	</table>
		// 	</div>
		// 	</div>
		// 	</td>
		// 	</tr>
		// 	</table>';

        // $this->load->helper('file');

        // $this->load->library('email');
        // $this->email->initialize($this->smtp_config);
        // $this->email->set_newline("\r\n");
        // $this->email->from($this->email_address, $this->email_tittle);
        // $this->email->to($toemail);
        // $this->email->subject('New order from ' . $email_details['buyer_name']);
        // $this->email->message($seller_message);
        // $this->email->send();

        // //admin mail function
        // $from_timezone = $this->session->userdata('time_zone');
        // date_default_timezone_set($from_timezone);
        // $current_time = date('Y-m-d H:i:s');
        // $bodyid = 19;
        // $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
        // $body = $tempbody_details['template_content'];
        // $body = str_replace('{base_url}', $this->base_domain, $body);
        // $body = str_replace('{PAYPAL_ID}', $txn_id, $body);
        // $body = str_replace('{CREATED_ON}', $current_time, $body);
        // $body = str_replace('{buyer_name}', $email_details['buyername'], $body);
        // $body = str_replace('{seller_name}', $email_details['sellername'], $body);
        // $body = str_replace('{ITEM_NAME}', str_replace("-", " ", $title), $body);
        // $body = str_replace('{PRICE}', '' . $gig_price, $body);
        // $body = str_replace('{IMG_SRC}', $img_path, $body);
        // $body = str_replace('{site_name}', $this->site_name, $body);
        // $body = str_replace('{TEABLE_ROW}', $h_all, $body);
        // $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
		// 	<tr>
		// 	<td></td>
		// 	<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
		// 	<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
		// 	<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
		// 	<tr>
		// 	<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
		// 	<table width="100%" cellpadding="0" cellspacing="0">
		// 	<tr>
		// 	<td style="text-align:center;">
		// 	<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
		// 	</td>
		// 	</tr>
		// 	<tr>
		// 	<td>' . $body . '</td>
		// 	</tr>
		// 	</table>
		// 	</td>
		// 	</tr>
		// 	</table>
		// 	<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
		// 	<table width="100%">
		// 	<tr>
		// 	<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
		// 	&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
		// 	</td>
		// 	</tr>
		// 	</table>
		// 	</div>
		// 	</div>
		// 	</td>
		// 	</tr>
		// 	</table>';

        // $this->load->helper('file');

        // $this->load->library('email');
        // $this->email->initialize($this->smtp_config);
        // $this->email->set_newline("\r\n");

        // $this->email->from($this->email_address, $this->email_tittle);
        // $this->email->to($this->email_address);
        // $this->email->subject('Create New Order');
        // $this->email->message($message);

        // if ($this->email->send()) {
        //     $message = 'Membership Updated Successfully';
        //     $this->session->set_flashdata('message', $message);
        // }  
        // else {
        //     $message = 'Email Send Failure';
        //     $this->session->set_flashdata('error_message', $message);
        // }
        $message = 'Membership Updated Successfully';
        $this->session->set_flashdata('message', $message);
        redirect(base_url() . 'membership');
    }

    function paypal_cancel()
    {
        redirect(base_url() . 'purchase-success');
    }

    function ipn(){
        // Retrieve transaction data from PayPal IPN POST
        $paypalInfo = $this->input->post();

        if(!empty($paypalInfo)){
            // Validate and get the ipn response
            $ipnCheck = $this->paypal_lib->validate_ipn($paypalInfo);

            // Check whether the transaction is valid
            if($ipnCheck){
                // Check whether the transaction data is exists
                $id = $paypalInfo["item_number"];
                $this->db->where('id', $id);

                $data = array(
                    'txn_id' => $paypalInfo["txn_id"]
                );

                $this->db->update('payment', $data);
            }
        }
    }
}

?>