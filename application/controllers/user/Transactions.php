<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Transactions extends CI_Controller
{
    public $data;

    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->helper('currency');
        $this->load->library('paypal_lib');
        $this->load->model('projects_model');
        $this->load->model('gigs_model');
        $this->load->model('transactions_model');
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
        $this->data['module'] = 'transactions';
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

    public function index($offset = 0)
    {
        if(!$this->session->userdata('SESSION_USER_ID')) {
            $message = "Access Denied.";
            redirect(base_url());
        }
        if($this->session->userdata('membership_id') == 0) {
            $message = "Your Membership Period is expired. Please buy membership.";
            $this->session->set_flashdata('error_message', $message);
            redirect(base_url());
        }

        $this->data['userid'] = $this->session->userdata('SESSION_USER_ID');
        $this->data['all_transaction_count'] = $this->transactions_model->get_user_orders_count($this->session->userdata('SESSION_USER_ID'));

        $this->load->model('api_gigs_model');
        $this->data['all_currencies'] = $this->api_gigs_model->get_currencies();
        
        $this->data['page_title'] = 'Transaction History';
        $this->data['page'] = 'index';
        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');
    }

    public function all_transaction_data() {
        $user_id = $this->session->userdata("SESSION_USER_ID");

        $from_date = $this->input->post("from_date");
        $to_date = $this->input->post("to_date");
        $status = $this->input->post("status");
        $currency = $this->input->post("currency");

        $result = $this->transactions_model->get_all_transaction_data($user_id, $from_date, $to_date, $status, $currency);
        $data = array(
            'data' => $result,
        );

        echo json_encode($data);
    }
}

?>