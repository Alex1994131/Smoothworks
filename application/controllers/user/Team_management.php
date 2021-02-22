<?php

class Team_management extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        error_reporting(0);

        $this->load->library('Encryption', 'encrypt');
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

        $this->load->helper('favourites');
        $common_settings = gigs_settings();
        $default_currency = 'USD';
        if (!empty($common_settings)) {
            foreach ($common_settings as $datas) {
                if ($datas['key'] == 'currency_option') {
                    $default_currency = $datas['value'];
                }
            }
        }

        $this->load->helper('currency');
        $this->default_currency = $default_currency;
        $this->default_currency_sign = currency_sign($default_currency);
        $this->smtp_config = smtp_mail_config();

        $this->data['theme'] = 'user';

        $this->data['module'] = 'teams';

        $this->load->model('user_panel_model');

        $this->data['client_list'] = $this->user_panel_model->get_client_list();

        $this->data['categories_subcategories'] = $this->user_panel_model->categories();

        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();

        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();

        $this->data['system_setting'] = $this->user_panel_model->system_setting();

        $this->data['policy_setting'] = $this->user_panel_model->policy_setting();

        $query = $this->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        $this->email_address = 'mail@example.com';
        $this->email_tittle = 'Smoothworks';
        $this->logo_front = base_url() . 'assets/images/logo.png';
        $this->site_name = 'Smoothworks';
        $this->base_domain = base_url();

        if (!empty($result)) {
            foreach ($result as $data) {
                if ($data['key'] == 'email_address') {
                    $this->email_address = !empty($data['value']) ? $data['value'] : 'mail@example.com';
                }

                if ($data['key'] == 'email_tittle') {
                    $this->email_tittle = !empty($data['value']) ? $data['value'] : 'Gigs';
                }

                if ($data['key'] == 'logo_front') {
                    $this->logo_front = base_url() . $data['value'];
                }

                if ($data['key'] == 'site_name' || $data['key'] == 'website_name') {
                    $this->site_name = $data['value'];
                }

                $this->data['currency_option'] = 'USD';

                if ($data['key'] == 'currency_option') {
                    $this->data['currency_option'] = $data['value'];
                }
            }
        }
    }

    public function index()
    {
        if(!$this->session->userdata('SESSION_USER_ID')) {
            $message = "Access Denied.";
            redirect(base_url());
        }
        if($this->session->userdata('account_type') != 1) {
            $message = "Access Denied.";
            $this->session->set_flashdata('error_message', $message);
            redirect(base_url());
        }
        if($this->session->userdata('membership_id') == 0) {
            $message = "Your Membership Period is expired. Please buy membership.";
            $this->session->set_flashdata('error_message', $message);
            redirect(base_url());
        }

        

        $user_id = $this->session->userdata('SESSION_USER_ID');
        $this->load->model('team_management_model');

        $this->data['team_id'] = $this->team_management_model->get_teamID($user_id);
        
        if($this->data['team_id'] == 0) {
            $message = "You are not team member.";
            $this->session->set_flashdata('error_message', $message);
            redirect(base_url());
        }

        $this->data['main_list'] = $this->team_management_model->get_team_persons($this->data['team_id']);
        $this->data['developer_list'] = $this->team_management_model->get_developers($this->data['team_id']);

        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function accept_action_ok() {
        $user_id = $this->input->post('user_id');
        $flag = $this->input->post('flag');

        $this->load->model('team_management_model');
        $result = $this->team_management_model->accept_ok($user_id, $flag);

        if($result == 1) {
            echo 'success';
        }
        else {
            echo 'failure';
        }
    }
}

?>