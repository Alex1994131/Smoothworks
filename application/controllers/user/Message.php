<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message extends CI_Controller
{
    public $data;

    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
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

        $this->data['title'] = 'Smoothworks';
        $this->data['page_title'] = 'Message';
        $this->data['theme'] = 'user';
        $this->data['module'] = 'message';
        $this->load->model('user_panel_model');
        $this->data['client_list'] = $this->user_panel_model->get_client_list();
        $this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();
        $this->data['logo'] = $this->user_panel_model->get_logo();
        $this->data['slogan'] = $this->user_panel_model->get_slogan();
        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();
        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();
        $this->data['system_setting'] = $this->user_panel_model->system_setting();
        $this->data['policy_setting'] = $this->user_panel_model->policy_setting();

        $this->load->model('gigs_model');
        $this->data['recent_gigs'] = $this->gigs_model->recent_gigs(1);
        $this->data['gigs_country'] = $this->gigs_model->gigs_country();

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

        if ($this->session->userdata('SESSION_USER_ID') == '') {
            redirect(base_url(''));
        }
    }

    public function index($group_id='')
    {
        $this->load->model('api_user_model');
        $session_user_data = $this->api_user_model->getUserRecord($this->session->userdata('SESSION_USER_ID'));

        $this->data['session_user_data'] = $session_user_data;
        $this->data['page'] = 'index';

        if($group_id == '' || $group_id == null) {
            $group_id = '';
        }

        $this->data['group_id'] = $group_id;
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
}

?>