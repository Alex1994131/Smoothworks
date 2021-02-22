<?php

class Gigs extends CI_Controller
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
        $this->data['module'] = 'gigs';
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

        // $this->data['secret_key'] = '';
        // $this->data['publishable_key'] = '';

        // $secret_key = '';
        // $publishable_key = '';
        // $live_secret_key = '';
        // $live_publishable_key = '';

        //stripe
        // $this->secret_key = '';
        // $this->publishable_key = '';

        //paypal
        $this->paypal_id = '';

        //paytab
        // $this->paytabs_email = '';
        // $this->paytabs_secretkey = '';

        // $stripe_option = '';
        $paypal_option = '';
        // $paytabs_option = '';


        // $this->data['paypal_allow'] = '';
        // $this->data['paytabs_allow'] = '';
        // $this->data['stripe_allow'] = '';

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

                // if ($data['key'] == 'stripe_option') {
                //     $stripe_option = $data['value'];
                // }
                if ($data['key'] == 'paypal_option') {
                    $paypal_option = $data['value'];
                }
                // if ($data['key'] == 'paytabs_option') {
                //     $paytabs_option = $data['value'];
                // }

                if ($data['key'] == 'paypal_allow') {
                    $this->data['paypal_allow'] = $data['value'];
                }
                // if ($data['key'] == 'paytabs_allow') {
                //     $this->data['paytabs_allow'] = $data['value'];
                // }
                // if ($data['key'] == 'stripe_allow') {
                //     $this->data['stripe_allow'] = $data['value'];
                // }

                // if ($data['key'] == 'secret_key') {
                //     $secret_key = $data['value'];
                // }
                // if ($data['key'] == 'publishable_key') {
                //     $publishable_key = $data['value'];
                // }
                // if ($data['key'] == 'live_secret_key') {
                //     $live_secret_key = $data['value'];
                // }
                // if ($data['key'] == 'live_publishable_key') {
                //     $live_publishable_key = $data['value'];
                // }

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

            // if ($stripe_option == 1) {
            //     $this->publishable_key = $publishable_key;
            //     $this->secret_key = $secret_key;
            // }

            // if ($stripe_option == 2) {
            //     $this->publishable_key = $live_publishable_key;
            //     $this->secret_key = $live_secret_key;
            // }

            // if ($stripe_option == 1) {
            //     $this->data['publishable_key'] = $publishable_key;
            //     $this->data['secret_key'] = $secret_key;
            // }

            // if ($stripe_option == 2) {
            //     $this->data['publishable_key'] = $live_publishable_key;
            //     $this->data['secret_key'] = $live_secret_key;
            // }

            if ($paypal_option == 1) {
                $this->paypal_id = $this->db->select('sandbox_email')->get('paypal_details')->row()->sandbox_email;
            }

            if ($paypal_option == 2) {
                $this->paypal_id = $this->db->select('email')->get('paypal_details')->row()->email;
            }

            // if ($paytabs_option == 1) {
            //     $this->paytabs_email = $this->db->select('sandbox_email')->get('paytabs_details')->row()->sandbox_email;
            //     $this->paytabs_secretkey = $this->db->select('sandbox_secretkey')->get('paytabs_details')->row()->sandbox_secretkey;
            // }

            // if ($paytabs_option == 2) {
            //     $this->paytabs_email = $this->db->select('email')->get('paytabs_details')->row()->email;
            //     $this->paytabs_secretkey = $this->db->select('secretkey')->get('paytabs_details')->row()->secretkey;
            // }
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

        if (($this->session->userdata('time_zone'))) {     // Getting timezone from session
            $this->data['time_zone'] = $this->session->userdata('time_zone');
        } else {
            if ($this->session->userdata('LAST_ACTIVITY') == '') {
                $this->session->set_userdata('LAST_ACTIVITY', time());
            }
        }

        // $config['publishable_key'] = $this->publishable_key;
        // $config['secret_key'] = $this->secret_key;

        // $this->load->library('stripe', $config);

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

    function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude, $t)
    {
        $json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");
        $data = json_decode($json, true);
        $tzone = $data['timeZoneId'];
        return $tzone;

    }

    public function add_gigs()
    {
        if(!$this->session->userdata('SESSION_USER_ID')) {
            $message = "Access Denied.";
            $this->session->set_flashdata('error_message', $message);
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

        $this->load->helper('ckeditor');
        $this->data['ckeditor_editor'] = array
        (
            'id' => 'gig_details',
            'path' => 'assets/js/ckeditor',
            'config' => array
            (
                'toolbar' => "Full"
            )
        );

        $this->data['ckeditor_editor_one'] = array
        (
            'id' => 'requirements',
            'path' => 'assets/js/ckeditor',
            'config' => array
            (
                'toolbar' => "Full"
            )
        );

        $this->data['page_title'] = 'Add Gigs';
        $this->data['module'] = 'sell_gigs';
        $this->data['page'] = 'add_gigs';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }

    public function edit_gigs($title)
    {
        $title = urldecode($title);

        $query = $this->db->query("select * from system_settings WHERE status = 1");

        $result = $query->result_array();

        $this->email_tittle = 'Gigs';

        if (!empty($result)) {
            foreach ($result as $datas) {
                if ($datas['key'] == 'site_name' || $datas['key'] == 'website_name') {
                    $this->site_name = $datas['value'];
                    $this->data['site_name'] = $this->site_name;
                }
            }
        }

        if ($this->session->userdata('SESSION_USER_ID')) {
            $this->load->helper('ckeditor');
            $this->data['ckeditor_editor'] = array
            (
                'id' => 'gig_details',
                'path' => 'assets/js/ckeditor',
                'config' => array
                (
                    'toolbar' => "Full"
                )
            );

            $this->data['ckeditor_editor_one'] = array
            (
                'id' => 'requirements',
                'path' => 'assets/js/ckeditor',
                'config' => array
                (
                    'toolbar' => "Full"
                )
            );

            $basic_details = $this->gigs_model->gig_basic_details($title);

            $this->data['basic_details'] = $basic_details;

            $this->data['extra_gig_details'] = $this->gigs_model->extra_gig_details($basic_details['id']);

            $gig_image_details = $this->gigs_model->gig_image_details($basic_details['id']);

            $gig_video_details = $this->gigs_model->gig_video_details($basic_details['id']);

            $this->data['gig_image_details'] = $gig_image_details;

            $image_details = array();

            foreach ($gig_image_details as $img_details) {

                $file_name = explode('/', $img_details['gig_image_tile']);

                $image_details[] = $file_name[2];

            }

            $this->data['images_value'] = $image_details;

            $this->data['gig_video_details'] = $gig_video_details;

            $image_details = array();

            $this->data['video_detail'] = '';

            if (!empty($gig_video_details)) {

                foreach ($gig_video_details as $video_details) {

                    $file_name = explode('/', $video_details['video_path']);

                    $video_detail[] = $file_name[2];

                }

                $this->data['video_detail'] = $video_detail;

            }

            $this->data['gig_details'] = $this->gigs_model->get_gig_details($title);
    
            $this->data['page_title'] = 'Edit Gig';
            $this->data['module'] = 'sell_gigs';
            $this->data['page'] = 'edit_gigs';

            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');

        } else {
            redirect(base_url());
        }
    }

    public function delete_gigs() {
        $gigs_id = $this->input->post('gigs_id');
        
        if ($this->session->userdata('SESSION_USER_ID')) {
            $this->db->where('id', $gigs_id);
            
            if($this->db->delete('sell_gigs')) {
                $this->db->where('gigs_id', $gigs_id);
                $this->db->delete('extra_gigs');

                $this->db->where('gig_id', $gigs_id);
                $this->db->delete('gigs_image');

                $this->db->where('gig_id', $gigs_id);
                $this->db->delete('gigs_video');

                $this->db->where('gig_id', $gigs_id);
                $this->db->delete('super_fast_delivery_option');

                echo 'success';
            }
        }
        else {
            echo 'failure';
        }
    }

    public function save_gigs() {
        $gigs_id = $this->input->post('gig_id');
        if($gigs_id == null || $gigs_id == 0) {
            $user_id = $this->session->userdata('SESSION_USER_ID');
            $account_state = $this->session->userdata('account_state');

            if($account_state == 1) {
                $person_id = $user_id;
            }
            else {
                $this->load->model('team_management_model');
                $team_id = $this->team_management_model->get_teamID($user_id);
                $leader_id = $this->team_management_model->get_leaderinfo($team_id);   
                $person_id = $leader_id;
            }

            $this->load->model('api_user_model');
            $person_record = $this->api_user_model->getUserRecord($person_id);

            $service = $person_record['service'];
            if($service == 0) {
                $message = 'Update your membership.';
                $this->session->set_flashdata('error_message', $message);
                redirect(base_url());
            }

            $service--;
            $this->db->where('USERID', $person_id);
            $this->db->update('members', array(
                'service' => $service
            ));
            
            $gig_tags = ucfirst($this->input->post('gig_tags'));
            if (!empty($gig_tags)) {
                $data['gig_tags'] = $gig_tags;
            }

            $data['user_id'] = $person_id;
            $title = strtolower($this->input->post('gig_title'));
            $data['title'] = url_title($title, '-');
            $data['gig_price'] = $this->input->post('gig_price');
            $data['time_zone'] = $time_zone = $this->session->userdata('time_zone');
            $data['delivering_time'] = $this->input->post('delivering_time');
            $data['category_id'] = $this->input->post('gig_category_id');
            $data['gig_details'] = ucfirst($this->input->post('gig_details'));
            $super_fast_charges = $this->input->post('super_fast_charges');
            $super_fast_delivery = $this->input->post('super_fast_delivery');
            $super_fast_delivery_date = $this->input->post('super_fast_delivery_date');

            if (!empty($super_fast_delivery)) {

                $data['super_fast_charges'] = $this->input->post('super_fast_charges');
                $data['super_fast_delivery'] = $this->input->post('super_fast_delivery');
                $data['super_fast_delivery_desc'] = ucfirst($this->input->post('super_fast_delivery_desc'));
                $data['super_fast_delivery_date'] = $this->input->post('super_fast_delivery_date');
            }

            $data['work_option'] = $this->input->post('work_option');
            $data['requirements'] = ucfirst($this->input->post('requirements'));
            $data['country_name'] = $this->input->post('full_country_name');
            $country_name = $this->session->userdata('country_name');

            if ($country_name == 'IN') {
                $data['currency_type'] = 1;
            } else {
                $data['currency_type'] = 2;
            }

            date_default_timezone_set($time_zone);

            $current_time = date('Y-m-d H:i:s');

            $data['created_date'] = $current_time;
            $data['youtube_url'] = $this->input->post('youtube_url');
            $data['vimeo_url'] = $this->input->post('vimeo_url');
            $data['vimeo_video_id'] = $this->input->post('vimeo_video_id');
            $data['status'] = 1; // 0 - Active , 1 - Inactive

            $data['currency_type'] = $this->data['currency_option'];

            $this->db->select('value');
            $this->db->where('key', 'price_option');
            $price_by = $this->db->get('system_settings')->row_array();
            $cost_type = ($price_by['value'] == 'dynamic') ? 1 : 0;
            $data['cost_type'] = $cost_type;

            if ($this->db->insert('sell_gigs', $data)) {

                $gigs_id = $this->db->insert_id();
                $message = (!empty($this->user_language[$this->user_selected]['lg_gig_added_successfully_once_get_admin_approval_gigs_will_be_shown_in_buy_service_page'])) ? $this->user_language[$this->user_selected]['lg_gig_added_successfully_once_get_admin_approval_gigs_will_be_shown_in_buy_service_page'] : $this->default_language['en']['lg_gig_added_successfully_once_get_admin_approval_gigs_will_be_shown_in_buy_service_page'];
                $this->session->set_flashdata('message', $message);
                $images = $this->input->post('image_array');
                $videos = $this->input->post('video_array');

                $images = explode(',', $images);
                $videos = explode(',', $videos);

                for ($i = 0; $i < sizeof($images); $i++) {
                    $data1['gig_id'] = $gigs_id;
                    $data1['image_path'] = 'uploads/gig_images/680_460_' . $images[$i];
                    $data1['gig_image_thumb'] = 'uploads/gig_images/50_34_' . $images[$i];
                    $data1['gig_image_tile'] = 'uploads/gig_images/100_68_' . $images[$i];
                    $data1['gig_image_medium'] = 'uploads/gig_images/240_162_' . $images[$i];

                    $this->db->insert('gigs_image', $data1);
                }

                $videos = array_filter($videos);

                if (!empty($videos)) {

                    for ($i = 0; $i < sizeof($videos); $i++) {

                        $data2['gig_id'] = $gigs_id;

                        $data2['video_path'] = 'uploads/gigs_videos/' . $videos[$i];

                        $this->db->insert('gigs_video', $data2);

                    }

                }

                $extra_gigs = $this->input->post('extra_gigs');

                if (!empty($extra_gigs)) {

                    $extra_gigs = array_filter($extra_gigs);
                }

                if (!empty($extra_gigs)) {

                    $data3['extra_gigs'] = $this->input->post('extra_gigs');

                    $data3['extra_gigs_delivery'] = $this->input->post('extra_gigs_delivery');

                    $data3['extra_gigs_amount'] = $this->input->post('extra_gigs_amount');


                    for ($i = 0; $i < sizeof($data3['extra_gigs']); $i++) {

                        if ($data3['extra_gigs'][$i] != '') {

                            $data4['gigs_id'] = $gigs_id;

                            $data4['extra_gigs'] = $data3['extra_gigs'][$i];

                            $data4['currency_type'] = $data['currency_type'];

                            $data4['extra_gigs_amount'] = $data3['extra_gigs_amount'][$i];

                            $data4['extra_gigs_delivery'] = $data3['extra_gigs_delivery'][$i];

                            $this->db->insert('extra_gigs', $data4);

                            $message = (!empty($this->user_language[$this->user_selected]['lg_gig_added_successfully_once_get_admin_approval_gigs_will_be_shown_in_buy_service_page'])) ? $this->user_language[$this->user_selected]['lg_gig_added_successfully_once_get_admin_approval_gigs_will_be_shown_in_buy_service_page'] : $this->default_language['en']['lg_gig_added_successfully_once_get_admin_approval_gigs_will_be_shown_in_buy_service_page'];

                            $this->session->set_flashdata('message', $message);

                        }

                    }

                }

                redirect(base_url());
            }

        }
        else {
            $gig_tags = ucfirst($this->input->post('gig_tags'));

            if (!empty($gig_tags)) {
                $data['gig_tags'] = $gig_tags;
            }

            $data['user_id'] = $this->session->userdata('SESSION_USER_ID');
            $title = strtolower($this->input->post('gig_title'));
            $data['title'] = url_title($title, '-');
            $data['gig_price'] = $this->input->post('gig_price');
            $data['time_zone'] = $this->session->userdata('time_zone');
            $data['delivering_time'] = $this->input->post('delivering_time');
            $data['category_id'] = $this->input->post('gig_category_id');
            $data['gig_details'] = ucfirst($this->input->post('gig_details'));
            $super_fast_charges = $this->input->post('super_fast_charges');
            $super_fast_delivery = $this->input->post('super_fast_delivery');
            $super_fast_delivery_date = $this->input->post('super_fast_delivery_date');

            if (!empty($super_fast_delivery)) {
                $data['super_fast_charges'] = $this->input->post('super_fast_charges');
                $data['super_fast_delivery'] = $this->input->post('super_fast_delivery');
                $data['super_fast_delivery_desc'] = ucfirst($this->input->post('super_fast_delivery_desc'));
                $data['super_fast_delivery_date'] = $this->input->post('super_fast_delivery_date');
            } else {
                $data['super_fast_charges'] = 0;
                $data['super_fast_delivery'] = '';
                $data['super_fast_delivery_desc'] = '';
                $data['super_fast_delivery_date'] = '';
            }

            $youtube_url = $this->input->post('youtube_url');
            $data['youtube_url'] = $youtube_url;
            $vimeo_url = $this->input->post('vimeo_url');
            $data['vimeo_url'] = $vimeo_url;
            $vimeo_video_id = $this->input->post('vimeo_video_id');
            $data['vimeo_video_id'] = $vimeo_video_id;
            $data['work_option'] = $this->input->post('work_option');
            $data['requirements'] = ucfirst($this->input->post('requirements'));
            $data['country_name'] = $this->input->post('full_country_name');
            $country_name = $this->session->userdata('country_name');
            $data['currency_type'] = $this->data['currency_option'];
            $from_timezone = $this->session->userdata('time_zone');
            date_default_timezone_set($from_timezone);
            $current_time = date('Y-m-d H:i:s');
            $data['created_date'] = $current_time;

            $this->db->where('id', $gigs_id);
            $this->db->update('sell_gigs', $data);

            $to_delete_images = $this->input->post('deleted_image_array');

            if (!empty($to_delete_images)) {
                $to_delete_images = explode(",", $this->input->post('deleted_image_array'));
                $delete_data = array();

                foreach ($to_delete_images as $delete_images) {

                    $file_path = FCPATH . $delete_images;

                    unlink($file_path);

                    $delete_data['gig_id'] = $gigs_id;

                    $delete_data['gig_image_tile'] = $delete_images;

                    $this->db->where($delete_data);

                    $this->db->delete('gigs_image');
                }
            }
            $to_delete_video = $this->input->post('deleted_video_array');

            if (!empty($to_delete_video)) {

                $to_delete_video = explode(",", $this->input->post('deleted_video_array'));

                $delete_data = array();

                foreach ($to_delete_video as $delete_videos) {

                    $file_path = FCPATH . $delete_videos;

                    unlink($file_path);

                    $delete_data['gig_id'] = $gigs_id;

                    $delete_data['video_path'] = $delete_videos;

                    $this->db->where($delete_data);

                    $this->db->delete('gigs_video');

                }

            }


            $images = $this->input->post('image_array');

            $videos = $this->input->post('video_array');


            $images = explode(',', $images);

            $videos = explode(',', $videos);

            $images = array_filter($images);

            if (!empty($images)) {

                for ($i = 0; $i < sizeof($images); $i++) {

                    $data1['gig_id'] = $gigs_id;

                    $data1['image_path'] = 'uploads/gig_images/680_460_' . $images[$i];

                    $data1['gig_image_thumb'] = 'uploads/gig_images/50_34_' . $images[$i];

                    $data1['gig_image_tile'] = 'uploads/gig_images/100_68_' . $images[$i];

                    $data1['gig_image_medium'] = 'uploads/gig_images/240_162_' . $images[$i];

                    $this->db->insert('gigs_image', $data1);

                }

            }

            $videos = array_filter($videos);

            if (!empty($videos)) {

                for ($i = 0; $i < sizeof($videos); $i++) {

                    $data2['gig_id'] = $gigs_id;

                    $data2['video_path'] = 'uploads/gigs_videos/' . $videos[$i];

                    $this->db->insert('gigs_video', $data2);

                }

            }


            if (!empty($this->input->post('extra_gigs'))) {
                $extra_gigs = array_filter($this->input->post('extra_gigs'));
            } else {
                $extra_gigs = array();
            }


            if (!empty($extra_gigs) && is_array($extra_gigs)) {

                $extra_gigs = array_filter($extra_gigs);

                $this->db->where('gigs_id', $gigs_id);

                $this->db->delete('extra_gigs');

                if (!empty($extra_gigs) && is_array($extra_gigs)) {

                    $data3['extra_gigs'] = $this->input->post('extra_gigs');

                    $data3['extra_gigs_delivery'] = $this->input->post('extra_gigs_delivery');

                    $data3['extra_gigs_amount'] = $this->input->post('extra_gigs_amount');

                    for ($i = 0; $i < sizeof($data3['extra_gigs']); $i++) {

                        if ($data3['extra_gigs'][$i] != '') {

                            $data4['gigs_id'] = $gigs_id;

                            $data4['extra_gigs'] = $data3['extra_gigs'][$i];

                            $data4['currency_type'] = $data['currency_type'];

                            $data4['extra_gigs_amount'] = $data3['extra_gigs_amount'][$i];

                            $data4['extra_gigs_delivery'] = $data3['extra_gigs_delivery'][$i];

                            $this->db->insert('extra_gigs', $data4);


                        }

                    }

                }

            }

            $this->session->set_flashdata('message', 'Gig Update success');

            redirect(base_url() . 'gig-preview/' . $data['title']);

        }
    }

    public function my_gigs($start = 0)
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

        $this->data['gigs_country'] = $this->gigs_model->gigs_country();
        $this->data['gigs_price'] = $this->gigs_model->gig_price();

        $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];
        $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

        if ($this->session->userdata('SESSION_USER_ID')) {

            $user_id = $this->session->userdata('SESSION_USER_ID');

            $this->load->library('pagination');
            $config['base_url'] = base_url("my-gigs/");
            $config['per_page'] = 16;
            $config['uri_segment'] = 2;
            $config['total_rows'] = $this->gigs_model->my_gigs(0, $user_id, 0, 0);
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
            $this->data['list'] = $this->gigs_model->my_gigs(1, $user_id, $start, $config['per_page']);
            $this->data['search_value'] = "My Gigs";
            $this->data['total_results'] = $config['total_rows'];
            $this->data['search_type'] = 'Location';
            $this->data['searched_value'] = " ";
            $this->data['selected_category_value'] = '';

            $this->data['page_title'] = 'My Gigs';
            $this->data['module'] = 'my_gigs';
            $this->data['page'] = 'my_gigs';

            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');

        } else {
            redirect(base_url());
        }
    }

    public function gig_preview($title = '')
    {
        $this->data['gigs_country'] = $this->gigs_model->gigs_country();
        $title = urldecode($title);

        /* Stripe Library in CI Start */
        // $stripe_config = array();
        // $stripe_config['publishable_key'] = "pk_test_Js15CigEZPZH69hjS2hgXjBx";
        // $stripe_config['secret_key'] = "sk_test_OVXvseuWuLVp2w0XOWvGKDQJ";
        // $stripe_config['stripe_name'] = "Dreams Gigs";
        // $stripe_config['stripe_logo'] = base_url() . "assets/images/logo.png";
        // $stripe_config['stripe_description'] = "This Gigs Payments";
        // $stripe_config['server_side_coding'] = base_url() . "user/buy_service/stripe_token_payment";
        // $this->load->library('stripe', $stripe_config);
        /* Stripe Library in CI End */

        if (empty($title)) {
            $title = str_replace(" ", "-", $this->input->post('selected_category'));
        }

        $gig_details = $this->gigs_model->get_gig_details($title);

        if (empty($gig_details['id'])) {
            redirect(base_url());
        }

        $this->data['gig_tags'] = $gig_details['gig_tags'];
        $gig_id = $gig_details['id'];
        $userid = $this->session->userdata('SESSION_USER_ID');

        $this->db->select('id');
        $this->db->from('views');
        $this->db->where('user_id', $userid);
        $this->db->where('gig_id', $gig_id);
        $check_views = $this->db->count_all_results();

        $this->db->select('id');
        $this->db->from('sell_gigs');
        $this->db->where('user_id',$userid);
        $this->db->where('id',$gig_id);
        $check_self_gig = $this->db->count_all_results();

        if ($check_views == 0 && $check_self_gig == 0) {
            $this->db->insert('views', array('user_id' => $userid, 'gig_id' => $gig_id));

            $this->db->set('total_views', 'total_views+1', FALSE);
            $this->db->where('id', $gig_id);
            $this->db->update('sell_gigs');
        }


        $this->data['gig_id'] = $gig_id;
        $user_id = $gig_details['user_id'];
        $this->data['gig_user_id'] = $user_id;

        $profile = $this->user_panel_model->profile($user_id);

        $result = array();

        $this->data['user_country_shortname'] = '';

        $this->data['user_country_name'] = '';

        if (!empty($profile['country'])) {

            $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =" . $profile['country'] . " ");

            $result = $query->row_array();

            $this->data['user_country_shortname'] = $result['sortname'];

            $this->data['user_country_name'] = $result['country'];

        }

        $this->data['user_profile'] = $profile;

        $this->data['gig_time_zone'] = $gig_details['time_zone'];

        $this->data['gig_time_posted'] = $gig_details['created_date'];

        $this->data['username'] = $gig_details['username'];

        $this->data['user_name'] = $gig_details['fullname'];

        if ($gig_details['parent'] == 0) {

            $category_id = $gig_details['category_id'];

            $this->data['category_based_gigs'] = $this->gigs_model->similar_gigs($category_id, $title);

        } else {

            $query = $this->db->query(" SELECT `parent` FROM `categories` WHERE `CATID` = " . $gig_details['category_id'] . "");

            $result = $query->row_array();

            $category_id = $gig_details['parent'];

            $this->data['category_based_gigs'] = $this->gigs_model->similar_gigs($category_id, $title);

            if (empty($this->data['category_based_gigs'])) {

                $this->data['category_based_gigs'] = $this->gigs_model->similar_gigs($gig_details['category_id'], $title);

            }

        }

        $this->data['gig_details'] = $gig_details;

        $this->data['user_all_gigs'] = $this->gigs_model->user_all_gigs($gig_id, $user_id);

        $this->data['feedbacks'] = $this->gigs_model->gigs_feedbacks($gig_id, $user_id);

        $query_feed = $this->db->query("SELECT AVG(rating) FROM `feedback` WHERE `to_user_id` = '".$user_id."' and `gig_id` = '".$gig_id."';");

        $fe_count = $query_feed->row_array();

        $rat = 0;

        if ($fe_count['AVG(rating)'] != '') {
            $rat = round($fe_count['AVG(rating)']);
        }

        $this->data['super_fast_delivery'] = $this->gigs_model->super_fast_delivery($gig_id, $user_id);

        $this->data['user_feedback'] = $rat;

        $this->data['gig_user_id'] = $user_id;

        $user_id = $this->session->userdata('SESSION_USER_ID');

        $this->load->model('api_user_model');
        $session_user_data = $this->api_user_model->getUserRecord($user_id);

        $this->data['session_user_data'] = $session_user_data;

        $this->data['page_title'] = 'Gig Preview';
        $this->data['module'] = 'buy_gigs';
        $this->data['page'] = "preview_gigs";

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');

    }

    public function buy_gigs($offset = 0)
    {
        $uid = '';
        if (isset($this->session->userdata)) {
            $userid = $this->session->userdata;
            if (isset($userid['SESSION_USER_ID'])) {
                $uid = $userid['SESSION_USER_ID'];
            }
        }

        $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];
        $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'buy-service';
        $config['per_page'] = 16;
        $config['total_rows'] = $this->gigs_model->buy_service(0, 0, 0, $uid);
        $this->data['total_records'] = $config['total_rows'];
        $config['uri_segment'] = 2;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        //$config['reuse_query_string'] = TRUE;
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
        $this->data['list'] = $this->gigs_model->buy_service(1, $offset, $config['per_page'], $uid);
        $this->data['user_favorites'] = $this->gigs_model->add_favourites();
        $this->data['search_value'] = 'Buy Service';
        $this->data['search_type'] = 'Location';
        $this->data['total_results'] = count($this->data['list']);

        $this->data['page_title'] = 'Buy Service';
        $this->data['module'] = 'buy_gigs';
        $this->data['page'] = 'buy_gigs';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function image_resize($width = 0, $height = 0, $image_url, $filename)
    {
        $source_path = $image_url;

        list($source_width, $source_height, $source_type) = getimagesize($source_path);

        switch ($source_type) {

            case IMAGETYPE_GIF:

                $source_gdim = imagecreatefromgif($source_path);

                break;

            case IMAGETYPE_JPEG:

                $source_gdim = imagecreatefromjpeg($source_path);

                break;

            case IMAGETYPE_PNG:

                $source_gdim = imagecreatefrompng($source_path);

                break;

        }

        $source_aspect_ratio = $source_width / $source_height;


        $desired_aspect_ratio = $width / $height;


        if ($source_aspect_ratio > $desired_aspect_ratio) {

            /*

            * Triggered when source image is wider

            */


            $temp_height = $height;

            $temp_width = ( int )($height * $source_aspect_ratio);

        } else {

            /*

            * Triggered otherwise (i.e. source image is similar or taller)

            */

            $temp_width = $width;

            $temp_height = ( int )($width / $source_aspect_ratio);

        }


            /*

            * Resize the image into a temporary GD image

            */

        $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);

        imagecopyresampled(

            $temp_gdim,

            $source_gdim,

            0, 0,

            0, 0,

            $temp_width, $temp_height,

            $source_width, $source_height

        );


        /*

        * Copy cropped region from temporary image into the desired GD image

        */


        $x0 = ($temp_width - $width) / 2;

        $y0 = ($temp_height - $height) / 2;

        $desired_gdim = imagecreatetruecolor($width, $height);

        imagecopy(

            $desired_gdim,

            $temp_gdim,

            0, 0,

            $x0, $y0,

            $width, $height

        );


        /*

        * Render the image

        * Alternatively, you can save the image in file-system or database

        */

        //$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);


        $image_url = "uploads/gig_images/" . $width . "_" . $height . "_" . $filename . "";

        imagepng($desired_gdim, $image_url);


        return $image_url;


        /*

        * Add clean-up code here

        */

    }

    public function file_upload()
    {
        $file_type = $this->input->post('file_type');

        $form_data = $_FILES['gig_files']['name'];

        $row_id = $this->input->post('row_id');

        if (isset($_FILES['gig_files']['name']) && !empty($_FILES['gig_files']['name'])) {

            $html = '';

            $uploaded_file_name = $_FILES['gig_files']['name'];

            $uploaded_file_name_arr = explode('.', $uploaded_file_name);

            $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

            $filename = time() . $filename;

            $this->load->library('common');

            if ($file_type == 'image') {

                $upload_sts = $this->common->global_file_upload('uploads/gig_images/', 'gig_files', $filename);

            } else if ($file_type == 'video') {

                $upload_sts = $this->common->global_file_upload('uploads/gigs_videos/', 'gig_files', $filename);

            }

            $uploaded_files = array();

            if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {

                //	print_r($upload_sts);

                $uploaded_file_name = $upload_sts['data']['file_name'];

                if (isset($upload_sts['data']['file_ext']) && trim($upload_sts['data']['file_ext']) == ".mp4") {

                    // print_r($upload_sts);

                    // $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    //print_r($_SERVER);

                    $file = FCPATH . 'uploads/gigs_videos/' . $upload_sts['data']['file_name'];

                    $newfile = FCPATH . 'uploads/gigs_videos/' . $upload_sts['data']['raw_name'] . ".ogg";

                    copy($file, $newfile);
                }

                $file_name = $uploaded_file_name;

                $uploaded_files[] = $file_name;

                if ($file_type == 'image') {

                    //$file_path =   base_url().'uploads/gig_images/'.$file_name;

                    //$this->image_resize(50,34,$file_path,$file_name);

                    //$this->image_resize(100,68,$file_path,$file_name);

                    //$this->image_resize(680,460,$file_path,$file_name);

                } else if ($file_type == 'video') {
                    $file_path = base_url() . 'uploads/gigs_videos/' . $file_name;
                }


                $row_id = $row_id + 1;

                if ($file_type == 'image') {

                    $html = "<div id=\"remove_image_div_$row_id\" class=\"uploaded-img\"> "

                        . "<img  height='100px' width='100px' class=\"imageThumb\" src=\"" . $file_path . "\" title=\"" . $file_name . "\"/>" .

                        "<a onclick=\"remove_files('$file_name','$row_id','image')\"  href=\"javascript:;\" class=\"uploaded-remove pull-right\">

				<i class=\"fa fa-times\"></i>

				</a></div>";

                } else if ($file_type == 'video') {

                    $html = " <div
				id=\"remove_video_div_$row_id\" class=\"uploaded-img\"> "

                        . "<video  class=\"img-responsive\"  style=\"height:100px !important; \">"

                        . "<source  src=\"" . $file_path . "\"; type=\"video/mp4\" codecs=\"avc1.4D401E, mp4a.40.2\">"

                        . "<source  src=\"" . $file_path . "\"; type=\'video/webm; codecs=\"vp8.0, vorbis\"'>"

                        . "<source  src=\"" . $file_path . "\";type='video/ogg; codecs=\"theora, vorbis\"'>"

                        . "<source  src=\"" . $file_path . "\";type='video/mp4; codecs=\"avc1.4D401E, mp4a.40.2\"'>    </video>  "

                        . "<a href=\"javascript:;\"  onclick=\"remove_files('$file_name','$row_id','video')\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";

                }

            }

            echo json_encode(array('html' => $html, 'sub_html' => $uploaded_files, 'row_id' => $row_id));

        }

    }

    public function extra_gig_calculations()
    {

        $extra_gigs_details = $this->input->post('extra_gigs_details');

        $gig_id = $this->input->post('gig_id');

        $user_id = $this->session->userdata('SESSION_USER_ID');

        $currency_type = $this->input->post('currency_type');

        $gig_details = $this->gigs_model->extra_gig_calculations($gig_id);

        $rupee_rate = $this->session->userdata('rupee_rate');

        $country_name = $this->session->userdata('country_name');

        $dollar_rate = $this->session->userdata('dollar_rate');


        $super_fast_delivery = $this->input->post('super_fast_delivery');

        $super_fast_delivery_charges = $this->input->post('super_fast_delivery_charges');

        $super_fast_desc = $this->input->post('super_fast_desc');

        $extra_gig_rate_symbol = $this->input->post('rate_symbol');

        $super_fast_delivery_date = $this->input->post('super_fast_delivery_date');


        $gig_price = $this->gigs_model->gig_price();

        $gig_price1 = $gig_price['value'];

        $gig_price1 = $gig_details['gig_price']; // Dynmic Price

        //	 echo $super_fast_delivery  . $super_fast_delivery_charges . $super_fast_desc . $rate_symbol . $super_fast_delivery_date  ;


        $currency_option = (!empty($gig_details['currency_type'])) ? $gig_details['currency_type'] : 'USD';
        $rate_symbol = currency_sign($currency_option);
        $rate = $gig_details['gig_price'];
        if ($super_fast_delivery == 'yes') {
            $super_fast_delivery_charges = ($super_fast_delivery_charges);
        }

        $item = (!empty($this->user_language[$this->user_selected]['lg_item'])) ? $this->user_language[$this->user_selected]['lg_item'] : $this->default_language['en']['lg_item'];

        $product_name = (!empty($this->user_language[$this->user_selected]['lg_product_name'])) ? $this->user_language[$this->user_selected]['lg_product_name'] : $this->default_language['en']['lg_product_name'];

        $quantity = (!empty($this->user_language[$this->user_selected]['lg_quantity'])) ? $this->user_language[$this->user_selected]['lg_quantity'] : $this->default_language['en']['lg_quantity'];

        $to_tal = (!empty($this->user_language[$this->user_selected]['lg_total'])) ? $this->user_language[$this->user_selected]['lg_total'] : $this->default_language['en']['lg_total'];

        $html = '';

        $html_table_header = '<div class="table-responsive">

						<table class="table table-bordered">

							<thead>

								<tr>

									<th>' . $item . '</th>

                  <th>' . $product_name . '</th>

                  <th class="text-center">' . $quantity . '</th>

                  <th class="text-right">' . $to_tal . '</th>

								</tr>

							</thead>

							<tbody>

								<tr>

									<td><img src="' . base_url() . $gig_details['gig_image'] . '" width="50" height="34"></td>

									<td>

										<a class="product_name text-ellipsis" href="javascript:;">' . ucfirst(str_replace("-", " ", $gig_details['title'])) . '</a>

									</td>

									<td> 1 </td>

									<td class="total">' . $rate_symbol . $gig_price1 . '</td>

								</tr>';

        $html_table_contents = '';

        $html_table_footer = '

		</tbody>

								</table>

								</div>';

        //$exisiting_rows = $this->gigs_model->check_existing_extra_gig($user_id,$gig_id);

        $extra_gig_inserted_id = array();

        $calculation_table = '';

        if (($super_fast_delivery == 'yes')) {
            if (empty($super_fast_desc)) {
                $super_fast_desc = "super fast delivery";
            }
            $html_table_contents .= '<tr><td> <span class="super-fast">Super Fast</span> </td>
									<td>' . $super_fast_desc . '</td><td>1</td><td class="total">' . $rate_symbol . $super_fast_delivery_charges . '</td>
                  </tr>';
        }

        $calculation_table = $html_table_header . $html_table_contents . $html_table_footer;

        echo json_encode(array('html' => $calculation_table, 'sub_html' => $extra_gig_inserted_id, 'rate_symbol' => $rate_symbol, 'super_fast_delivery' => $super_fast_delivery,

            'super_fast_delivery_charges' => $super_fast_delivery_charges));

    }

    public function delete_uploaded_file()
    {
        $file_name = $this->input->post('filename');
        $file_type = $this->input->post('file_type');

        if ($file_type == 'image') {
            $file_path = FCPATH . 'uploads/gig_images/' . $file_name;
        } else if ($file_type == 'video') {
            $file_path = FCPATH . 'uploads/gigs_videos/' . $file_name;
        }

        $html = '';
        if (unlink($file_path)) {
            $html = 1;
        }

        echo json_encode(array('html' => $html, 'sub_html' => $file_name));
    }

    public function prf_crop()
    {
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '-1');

        $html = $error_msg = $shop_ad_id = '';
        $error_sts = 0;
        $row_id = $this->input->post('select_row_id');
        $image_data = $this->input->post('img_data');

        $base64string = str_replace('data:image/png;base64,', '', $image_data);
        $base64string = str_replace(' ', '+', $base64string);

        $data = base64_decode($base64string);

        $img_name = time();

        $file_name_final = 'gig_' . $img_name . ".png";

        $img_name2 = "680_460_".$file_name_final;

        file_put_contents('uploads/gig_images/'.$img_name2, $data);

        $source_image = 'uploads/gig_images/' . $img_name2;

        $blog_themb = $this->image_resize(100, 68, $source_image, $file_name_final);
        $blog_themb_one = $this->image_resize(50, 34, $source_image, $file_name_final);
        $gigs_medium = $this->image_resize(240, 162, $source_image, $file_name_final);

        $html = "<div id=\"remove_image_div_$row_id\" class=\"uploaded-img\">"
            ."<img  height='68' width='100' class=\"imageThumb\" src=\"" . base_url() . $blog_themb . "\" title=\"" . $blog_themb . "\"/>".
            "<a onclick=\"remove_files('$img_name2','$row_id','image')\"  href=\"javascript:;\" class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i>
                    </a></div>";

        $row_id = $row_id + 1;

        $response = array(
            'state' => 200,
            'message' => $error_msg,
            'result' => $html,
            'row_id' => $row_id,
            'sub_html' => $file_name_final,
            'sts' => $error_sts
        );

        echo json_encode($response);

    }

    public function prf_crop_call($image_name, $av_data, $new_name, $t_width, $t_height)
    {

        $path = 'uploads/gig_images/';

        $w = $av_data['width'];

        $h = $av_data['height'];

        $x1 = $av_data['x'];

        $y1 = $av_data['y'];

        list($imagewidth, $imageheight, $imageType) = getimagesize('uploads/gig_images/' . $image_name);

        $imageType = image_type_to_mime_type($imageType);

        $ratio = ($t_width / $w);

        $ratio_one = ($t_height / $h);

        $nw = ceil($w * $ratio);

        $nh = ceil($h * $ratio_one);

        $newImage = imagecreatetruecolor($nw, $nh);

        switch ($imageType) {

            case "image/gif"  :
                $source = imagecreatefromgif('uploads/gig_images/' . $image_name);

                break;

            case "image/pjpeg":

            case "image/jpeg" :

            case "image/jpg"  :
                $source = imagecreatefromjpeg('uploads/gig_images/' . $image_name);

                break;

            case "image/png"  :

            case "image/x-png":
                $source = imagecreatefrompng('uploads/gig_images/' . $image_name);

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

    public function you_tube_links()
    {
        $youtube_url = $this->input->post('youtube_url');
        $result = preg_match_all('~https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'"][^<>]*>|</a>))[?=&+%\w.-]*~ix', $youtube_url, $matchs);

        if ($result > 0) {
            foreach ($matchs as $key => $vals) {
                if (filter_var($vals[0], FILTER_VALIDATE_URL) === false) {
                    $url = $vals[0];
                    break;
                }
            }
            $width = '200px';
            $height = '100px';

            $html = " <div id=\"remove_youtube_div\" class=\"uploaded-img\"> "
                . '<iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $url . '" frameborder="0" allowfullscreen></iframe>'
                . "<a  onclick=\"remove_third_party_link('remove_youtube_div')\" href=\"javascript:;\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";
            echo $html;
        }
    }

    public function vimeo_links()
    {
        $vimeo_url = $this->input->post('vimeo_video_id');
        $width = '200px';
        $height = '100px';
        $html = " <div id=\"remove_vimeo_div\" class=\"uploaded-img\"> "
            . "<iframe src=\"//player.vimeo.com/video/$vimeo_url?portrait=0&color=333\" width=\"$width\" height=\"$height\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>"
            . "<a  onclick=\"remove_third_party_link('remove_vimeo_div')\" href=\"javascript:;\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";
        echo $html;
    }

    public function load_more_feedbacks()
    {
        if (($this->session->userdata('time_zone'))) {
            $time_zone = $this->session->userdata('time_zone');
        } else {
            $user_ip = getenv('REMOTE_ADDR');
            $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
            $geoplugin_latitude = $geo["geoplugin_latitude"];
            $geoplugin_longitude = $geo["geoplugin_longitude"];
            $t = time();
            $result = $this->getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude, $t);
            $time_zone = $result;
        }
        $start = $this->input->post('start');
        $userid = $this->input->post('userid');
        $g_id = $this->input->post('g_id');
        $limit = 2;
        $html = '';
        $status = 0;
        $html_count = intval($start) + intval($limit);
        $result_set = $this->gigs_model->more_gigs_feedbacks($g_id, $userid, $start, $limit);
        if (count($result_set) > 0) {
            $status = 1;
        }
        foreach ($result_set as $key => $feedback) {
            if ($time_zone != $feedback['time_zone']) {
                $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));
                $date->setTimezone(new DateTimeZone($time_zone));
                $time = $date->format('Y-m-d H:i:s');
                date_default_timezone_set($time_zone);
                $date1 = date('Y-m-d H:i:s');
                $now = new DateTime($date1);
                $ref = new DateTime($time);
                $diff = $now->diff($ref);
            } else {
                date_default_timezone_set($time_zone);
                $now = new DateTime(date('Y-m-d H:i:s'));
                $ref = new DateTime($feedback['created_date']);
                $diff = $now->diff($ref);
            }
            $total_seconds = 0;
            $days = $diff->days;
            $hours = $diff->h;
            $mins = $diff->i;
            if (!empty($days) && ($days > 0)) {
                $days_to_seconds = $diff->days * 24 * 60 * 60;
                $total_seconds = $total_seconds + $days_to_seconds;
            }

            if (!empty($hours) && ($hours > 0)) {
                $hours_to_seconds = $diff->h * 60 * 60;
                $total_seconds = $total_seconds + $hours_to_seconds;
            }

            if (!empty($mins) && ($mins > 0)) {
                $min_to_seconds = $mins * 60;
                $total_seconds = $total_seconds + $min_to_seconds;
            }

            $intervals = array(
                'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
            );

            $time_difference = '';

            if ($total_seconds == 0) {
                $time_difference = 'just now';
            }

            if ($total_seconds < 60) {
                $time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';
            }
            if ($total_seconds >= 60 && $total_seconds < $intervals['hour']) {
                $total_seconds = floor($total_seconds / $intervals['minute']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';
            }

            if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day']) {
                $total_seconds = floor($total_seconds / $intervals['hour']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';
            }

            if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week']) {
                $total_seconds = floor($total_seconds / $intervals['day']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';
            }

            if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month']) {
                $total_seconds = floor($total_seconds / $intervals['week']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';
            }

            if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year']) {
                $total_seconds = floor($total_seconds / $intervals['month']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';
            }

            if ($total_seconds >= $intervals['year']) {
                $total_seconds = floor($total_seconds / $intervals['year']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';
            }


            $rat_ing = $feedback['rating'];
            $u_images = base_url() . 'assets/images/avatar2.jpg';
            if ($feedback['user_thumb_image'] != '') {
                $u_images = base_url() . $feedback['user_thumb_image'];
            }

            $html .= '<li class="media">
                    <a href="' . base_url() . 'user-profile/' . $feedback['username'] . '" class="pull-left"><img width="26" height="26" alt="' . $feedback['fullname'] . '" src="' . $u_images . '"></a>
                    <div class="media-body">
                      <div class="feedback-info">
                      <div class="feedback-author">
                       <a href="' . base_url() . 'user-profile/' . $feedback['username'] . '">' . $feedback['fullname'] . '</a>
                       </div>
                       <span class="feedback-time">' . $time_difference . '</span>
                     </div>
                     <script type="text/javascript" src="' . base_url() . 'assets/js/rating.js"></script>
                     <div class="feedback-area" ><p>' . $feedback['comment'] . '  <span  class="starrr" data-rating="' . $rat_ing . '"></span></p></div>';


            $query = $this->db->query("SELECT feedback.*,members.* FROM `feedback`

              LEFT JOIN members ON members.USERID = feedback.`from_user_id`
            
              WHERE feedback.`from_user_id` = $userid AND feedback.`to_user_id` = " . $feedback['from_user_id'] . " AND feedback.`order_id` = " . $feedback['order_id'] . " AND feedback.`status` = 1");

            $result = $query->row_array();

            if (!empty($result)) {
                $u_imagesone = base_url() . 'assets/images/avatar2.jpg';
                if ($result['user_thumb_image'] != '') {
                    $u_imagesone = base_url() . $result['user_thumb_image'];
                }

                if ($time_zone != $feedback['time_zone']) {
                    $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));
                    $date->setTimezone(new DateTimeZone($time_zone));
                    $time = $date->format('Y-m-d H:i:s');

                    date_default_timezone_set($time_zone);
                    $date1 = date('Y-m-d H:i:s');
                    $now = new DateTime($date1);
                    $ref = new DateTime($time);
                    $diff = $now->diff($ref);
                } else {
                    date_default_timezone_set($time_zone);
                    $now = new DateTime(date('Y-m-d H:i:s'));
                    $ref = new DateTime($feedback['created_date']);
                    $diff = $now->diff($ref);
                }

                $total_seconds = 0;
                $days = $diff->days;
                $hours = $diff->h;
                $mins = $diff->i;

                if (!empty($days) && ($days > 0)) {
                    $days_to_seconds = $diff->days * 24 * 60 * 60;
                    $total_seconds = $total_seconds + $days_to_seconds;
                }

                if (!empty($hours) && ($hours > 0)) {
                    $hours_to_seconds = $diff->h * 60 * 60;
                    $total_seconds = $total_seconds + $hours_to_seconds;
                }

                if (!empty($mins) && ($mins > 0)) {
                    $min_to_seconds = $mins * 60;
                    $total_seconds = $total_seconds + $min_to_seconds;
                }

                $intervals = array(
                    'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
                );

                $time_difference = '';
                if ($total_seconds == 0) {
                    $time_difference = 'just now';
                }

                if ($total_seconds < 60) {
                    $time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';
                }

                if ($total_seconds >= 60 && $total_seconds < $intervals['hour']) {
                    $total_seconds = floor($total_seconds / $intervals['minute']);
                    $time_difference = $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';
                }

                if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day']) {
                    $total_seconds = floor($total_seconds / $intervals['hour']);
                    $time_difference = $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';
                }

                if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week']) {
                    $total_seconds = floor($total_seconds / $intervals['day']);
                    $time_difference = $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';
                }

                if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month']) {
                    $total_seconds = floor($total_seconds / $intervals['week']);
                    $time_difference = $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';
                }

                if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year']) {
                    $total_seconds = floor($total_seconds / $intervals['month']);
                    $time_difference = $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';
                }

                if ($total_seconds >= $intervals['year']) {
                    $total_seconds = floor($total_seconds / $intervals['year']);
                    $time_difference = $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';
                }

                $html .= '<div class="media">
                    <a href="' . base_url() . 'user-profile/' . $result['username'] . '" class="pull-left"><img width="26" height="26" alt="' . $result['fullname'] . '" src="' . $u_imagesone . '"></a>
                    <div class="media-body">
                      <div class="feedback-info">
                        <div class="feedback-author">
                         <a href="' . base_url() . 'user-profile/' . $result['username'] . '">' . $result['fullname'] . '</a>
                       </div>
                       <span class="feedback-time">' . $time_difference . '</span>
                     </div>
                     <p>' . $result['comment'] . '</p>
                    </div>
                    </div>';
            }

            $html .= ' </div></li>';
        }

        echo json_encode(array('more_data' => $html, 'start_count' => $html_count, 'status' => $status));

    }

    public function load_more_userfeedbacks()
    {
        if (($this->session->userdata('time_zone'))) {
            $time_zone = $this->session->userdata('time_zone');
        } else {
            $user_ip = getenv('REMOTE_ADDR');
            $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
            $geoplugin_latitude = $geo["geoplugin_latitude"];
            $geoplugin_longitude = $geo["geoplugin_longitude"];
            $t = time();
            $result = $this->getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude, $t);
            $time_zone = $result;
        }

        $start = $this->input->post('start');
        $userid = $this->input->post('userid');
        $limit = 2;
        $html = '';
        $status = 0;
        $html_count = intval($start) + intval($limit);
        $limit_cond = " LIMIT " . (int)$start . ", " . (int)$limit;

        $query_feed = $this->db->query("SELECT feedback.*,sell_gigs.title,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`
            left join members on members.USERID = feedback.`from_user_id`
            left join sell_gigs on sell_gigs.id = feedback.`gig_id`
            WHERE sell_gigs.user_id = $userid AND feedback.to_user_id = $userid AND feedback.`status` = 1 " . $limit_cond);

        $result_set = $query_feed->result_array();
        if (count($result_set) > 0) {
            $status = 1;
        }

        foreach ($result_set as $key => $feedback) {
            if ($time_zone != $feedback['time_zone']) {
                $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));
                $date->setTimezone(new DateTimeZone($time_zone));
                $time = $date->format('Y-m-d H:i:s');
                date_default_timezone_set($time_zone);
                $date1 = date('Y-m-d H:i:s');
                $now = new DateTime($date1);
                $ref = new DateTime($time);
                $diff = $now->diff($ref);
            } else {
                date_default_timezone_set($time_zone);
                $now = new DateTime(date('Y-m-d H:i:s'));
                $ref = new DateTime($feedback['created_date']);
                $diff = $now->diff($ref);
            }

            $total_seconds = 0;
            $days = $diff->days;
            $hours = $diff->h;
            $mins = $diff->i;
            if (!empty($days) && ($days > 0)) {
                $days_to_seconds = $diff->days * 24 * 60 * 60;
                $total_seconds = $total_seconds + $days_to_seconds;
            }

            if (!empty($hours) && ($hours > 0)) {
                $hours_to_seconds = $diff->h * 60 * 60;
                $total_seconds = $total_seconds + $hours_to_seconds;
            }

            if (!empty($mins) && ($mins > 0)) {
                $min_to_seconds = $mins * 60;
                $total_seconds = $total_seconds + $min_to_seconds;
            }

            $intervals = array(
                'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
            );

            $time_difference = '';
            if ($total_seconds == 0) {
                $time_difference = 'just now';
            }

            if ($total_seconds < 60) {
                $time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';
            }

            if ($total_seconds >= 60 && $total_seconds < $intervals['hour']) {
                $total_seconds = floor($total_seconds / $intervals['minute']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';
            }

            if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day']) {
                $total_seconds = floor($total_seconds / $intervals['hour']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';
            }

            if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week']) {
                $total_seconds = floor($total_seconds / $intervals['day']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';
            }

            if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month']) {
                $total_seconds = floor($total_seconds / $intervals['week']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';
            }

            if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year']) {
                $total_seconds = floor($total_seconds / $intervals['month']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';
            }

            if ($total_seconds >= $intervals['year']) {
                $total_seconds = floor($total_seconds / $intervals['year']);
                $time_difference = $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';
            }

            $rat_ing = $feedback['rating'];
            $u_images = base_url() . 'assets/images/avatar2.jpg';
            if ($feedback['user_thumb_image'] != '') {
                $u_images = base_url() . $feedback['user_thumb_image'];
            }

            $html .= '<li class="media">
                    <a href="' . base_url() . 'user-profile/' . $feedback['username'] . '" class="pull-left"><img width="26" height="26" alt="' . $feedback['fullname'] . '" src="' . $u_images . '"></a>
                    <div class="media-body">
                      <div class="feedback-info">
                       <div class="feedback-author">
                         <a href="' . base_url() . 'user-profile/' . $feedback['username'] . '">' . $feedback['fullname'] . '</a>
                         <span> - </span>
                         <a href="' . base_url() . 'gig_preview/' . $feedback['title'] . '">' . str_replace("-", " ", $feedback['title']) . '</a>
                       </div>
                       <span class="feedback-time">' . $time_difference . '</span>
                     </div>
                     <script type="text/javascript" src="' . base_url() . 'assets/js/rating.js"></script>
                     <div class="feedback-area" ><p>' . $feedback['comment'] . '  <span  class="starrr" data-rating="' . $rat_ing . '"></span></p></div>';

            $query = $this->db->query("SELECT feedback.*,members.* FROM `feedback`
                      LEFT JOIN members ON members.USERID = feedback.`from_user_id`
                      WHERE feedback.`gig_id` = " . $feedback['gig_id'] . " AND feedback.`from_user_id` = " . $feedback['to_user_id'] . " AND feedback.`to_user_id` = " . $feedback['from_user_id'] . " AND feedback.`order_id` = " . $feedback['order_id'] . " AND feedback.`status` = 1");

            $result = $query->row_array();
            if (!empty($result)) {
                $u_imagesone = base_url() . 'assets/images/avatar2.jpg';
                if ($result['user_thumb_image'] != '') {
                    $u_imagesone = base_url() . $result['user_thumb_image'];
                }

                if ($time_zone != $feedback['time_zone']) {
                    $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));
                    $date->setTimezone(new DateTimeZone($time_zone));
                    $time = $date->format('Y-m-d H:i:s');
                    date_default_timezone_set($time_zone);
                    $date1 = date('Y-m-d H:i:s');
                    $now = new DateTime($date1);
                    $ref = new DateTime($time);
                    $diff = $now->diff($ref);
                } else {
                    date_default_timezone_set($time_zone);
                    $now = new DateTime(date('Y-m-d H:i:s'));
                    $ref = new DateTime($feedback['created_date']);
                    $diff = $now->diff($ref);
                }

                $total_seconds = 0;
                $days = $diff->days;
                $hours = $diff->h;
                $mins = $diff->i;

                if (!empty($days) && ($days > 0)) {
                    $days_to_seconds = $diff->days * 24 * 60 * 60;
                    $total_seconds = $total_seconds + $days_to_seconds;
                }

                if (!empty($hours) && ($hours > 0)) {
                    $hours_to_seconds = $diff->h * 60 * 60;
                    $total_seconds = $total_seconds + $hours_to_seconds;
                }

                if (!empty($mins) && ($mins > 0)) {
                    $min_to_seconds = $mins * 60;
                    $total_seconds = $total_seconds + $min_to_seconds;
                }

                $intervals = array(
                    'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
                );

                $time_difference = '';

                if ($total_seconds == 0) {

                    $time_difference = 'just now';

                }


                if ($total_seconds < 60) {

                    $time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';

                }


                if ($total_seconds >= 60 && $total_seconds < $intervals['hour']) {

                    $total_seconds = floor($total_seconds / $intervals['minute']);

                    $time_difference = $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';

                }


                if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day']) {

                    $total_seconds = floor($total_seconds / $intervals['hour']);

                    $time_difference = $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';

                }


                if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week']) {

                    $total_seconds = floor($total_seconds / $intervals['day']);

                    $time_difference = $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';

                }


                if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month']) {

                    $total_seconds = floor($total_seconds / $intervals['week']);

                    $time_difference = $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';

                }


                if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year']) {


                    $total_seconds = floor($total_seconds / $intervals['month']);

                    $time_difference = $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';

                }


                if ($total_seconds >= $intervals['year']) {

                    $total_seconds = floor($total_seconds / $intervals['year']);

                    $time_difference = $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';

                }

                $html .= '<div class="media">

                    <a href="' . base_url() . 'user-profile/' . $result['username'] . '" class="pull-left"><img width="26" height="26" alt="' . $result['fullname'] . '" src="' . $u_imagesone . '"></a>
                    
                    <div class="media-body">
                    
                      <div class="feedback-info">
                    
                        <div class="feedback-author">
                    
                         <a href="' . base_url() . 'user-profile/' . $result['username'] . '">' . $result['fullname'] . '</a>
                    
                       </div>
                    
                       <span class="feedback-time">' . $time_difference . '</span>
                    
                    
                    
                     </div>
                    
                     <p>' . $result['comment'] . '</p>
                    
                    </div>
                    
                    </div>';

            }

            $html .= ' </div>
                </li>';

        }

        echo json_encode(array('more_data' => $html, 'start_count' => $html_count, 'status' => $status));
    }

    public function remove_favourites()
    {
        $gig_id = $this->input->post('gig_id');

        $user_id = $this->input->post('user_id');

        $data = array('user_id' => $gig_id, 'gig_id' => $user_id);

        if ($this->db->query("DELETE FROM `favourites` WHERE `user_id` = $user_id AND `gig_id` = $gig_id")) {
            echo 1;
        }
    }

    public function add_favourites()
    {
        $data['gig_id'] = $this->input->post('gig_id');

        $data['user_id'] = $this->input->post('user_id');

        if ($this->db->insert('favourites', $data)) {
            echo 1;
        }
    }

    public function get_country_list()
    {
        $country_name = $this->input->get('term');


        $query = $this->db->query("SELECT id,country FROM `country` WHERE `country` LIKE '%$country_name%';");

        $result = $query->result_array();

        $final_array = array();

        foreach ($result as $row) {

            $final_array[] = $row['country'];

        }

        echo json_encode($final_array);
    }

    public function update_language()
    {
        $data['lang_speaks'] = $this->input->post('updated_name');

        if (($this->session->userdata('SESSION_USER_ID'))) {

            $user_id = $this->session->userdata('SESSION_USER_ID');

        }

        $this->db->where('USERID', $user_id);

        if ($this->db->update('members', $data)) {
            echo 1;
        }
    }

    public function language_list()
    {
        $lang_name = $this->input->get('term');

        $query = $this->db->query("SELECT DISTINCT(`Language`) FROM `language` WHERE `Language` LIKE'%$lang_name%'; ");

        $result = $query->result_array();

        $final_array = array();

        foreach ($result as $row) {

            $final_array[] = str_replace(" ", "-", $row['Language']);//build an array

        }
        echo json_encode($final_array);
    }

    public function all_categories()
    {
        $caegory_name = $this->input->get('term');
        $query = $this->db->query("SELECT name FROM `categories` WHERE `name` LIKE '%$caegory_name%' AND `status` = 0 ;");
        $result = $query->result_array();
        $final_array = array();

        foreach ($result as $row) {
            $final_array[] = $row['name'];//build an array
        }

        echo json_encode($final_array);
    }

    public function common_search($selected_category_id = '')
    {
        $common_search = str_replace(" ", "-", $this->input->get('term'));
        $query_append = '';
        if (!empty($selected_category_id)) {
            $query_append = ' AND `category_id` = ' . $selected_category_id;
        }

        $query = $this->db->query("SELECT * FROM  `sell_gigs` WHERE  `title` LIKE  '%$common_search%' AND `status` = 0 " . $query_append . ";");
        $result = $query->result_array();
        if (!empty($result)) {
            $final_array = array();
            foreach ($result as $row) {
                $final_array[] = str_replace("-", " ", $row['title']);//build an array
            }
        } else {
            $final_array = array();
            $final_array[] = "No Results Found";
        }
        echo json_encode($final_array);
    }

    public function search($start = 0)
    {
        $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];
        $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

        $search_value = $this->input->post('common_search');
        $category_id = $this->input->post('changecatetext');

        $this->data['page_title'] = 'Search';

        if (empty($search_value) && !empty($category_id)) {

            $this->load->library('pagination');

            $config['base_url'] = base_url("gigs/search/");

            $config['per_page'] = 15;

            $config['total_rows'] = $this->gigs_model->common_search_category($category_id, 0, 0, 0);

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

            $this->data['page'] = 'index';

            $this->data['links'] = $this->pagination->create_links();
            $this->data['list'] = $this->gigs_model->common_search_category($category_id, $start, $config['per_page'], 1);

            $name = '';

            foreach ($this->data['categories_subcategories'] as $value) {

                if ($value['CATID'] == $category_id) {

                    $name = $value['name'];
                    break;
                }
            }

            $this->data['title'] = 'Gigs';

            $this->data['module'] = 'search';

            $this->data['page'] = 'index';

            $this->data['search_value'] = $name;

            $this->data['search_type'] = 'Location';

            $this->data['total_results'] = $config['total_rows'];

            $this->load->vars($this->data);

            $this->load->view($this->data['theme'] . '/template');
        }

        $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];

        $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

        if (!empty($search_value) && !empty($category_id)) {

            $this->load->library('pagination');

            $config['base_url'] = base_url("gigs/search/");

            $config['per_page'] = 15;

            if (($this->session->userdata('SESSION_USER_ID'))) {
                $user_id = $this->session->userdata('SESSION_USER_ID');
            }

            $config['total_rows'] = $this->gigs_model->common_search($category_id, $search_value, 0, 0, 0);

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

            $this->data['page'] = 'index';

            $this->data['links'] = $this->pagination->create_links();


            $this->data['list'] = $this->gigs_model->common_search($category_id, $search_value, $start, $config['per_page'], 1);

            $this->data['title'] = 'Gigs';

            $this->data['module'] = 'search';

            $this->data['page'] = 'index';

            $this->data['search_value'] = $search_value;

            $this->data['search_type'] = 'Location';

            $this->data['total_results'] = $config['total_rows'];

            $this->load->vars($this->data);

            $this->load->view($this->data['theme'] . '/template');

        } else {

            if ($this->uri->segment(4) == '' && $this->uri->segment(5) == '') {

                $search_type = $this->input->post('search_type');

                $selected_value = $this->input->post('selected_category');

                $selected_value = str_replace(" ", "_", $selected_value);

            } else {

                $search_type = $this->uri->segment(5);

                $selected_value = $this->uri->segment(4);

                $selected_value = str_replace(" ", "_", $selected_value);

            }

            if ((!empty($search_type)) && (!empty($selected_value))) {

                $this->load->library('pagination');

                $config['base_url'] = base_url("dashboard/search/");

                $config['per_page'] = 15;

                if ($search_type == 1) {

                    $config['total_rows'] = $this->gigs_model->location_base_gigs($selected_value, 2, 0, 0);

                    $config['suffix'] = "/" . $selected_value . "/" . $search_type;

                } else if ($search_type == 2) {

                    $config['total_rows'] = $this->gigs_model->category_base_gigs($selected_value, 2, 0, 0);

                    $config['suffix'] = "/" . $selected_value . "/" . $search_type;

                }

                $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];

                $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

                $config['full_tag_open'] = '<ul class="pagination">';

                $config['full_tag_close'] = '</ul>';

                $config['first_link'] = $first;

                $config['first_tag_open'] = '<li>';

                $config['first_tag_close'] = '</li>';

                $config['first_url'] = $config['base_url'] . "/0/" . $config['suffix'];

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

                $this->data['page'] = 'index';

                $this->data['links'] = $this->pagination->create_links();

                if ($search_type == 1) {

                    $this->data['list'] = $this->gigs_model->location_base_gigs($selected_value, 1, $start, $config['per_page']);

                    $this->data['search_type'] = 'Location';

                } else if ($search_type == 2) {

                    $this->data['list'] = $this->gigs_model->category_base_gigs($selected_value, 1, $start, $config['per_page']);

                    $this->data['search_type'] = 'Category';
                }

                $this->data['title'] = 'Gigs';

                $this->data['module'] = 'search';

                $this->data['search_value'] = str_replace("_", " ", $selected_value);

                $this->data['total_results'] = $config['total_rows'];

                $this->load->vars($this->data);

                $this->load->view($this->data['theme'] . '/template');

            } else {

                redirect(base_url());
            }
        }
    }

    public function favourites($offset = 0)
    {
        if(!$this->session->userdata('SESSION_USER_ID')) {
            $message = "Access Denied.";
            redirect(base_url());
        }
        if($this->session->userdata('account_type') != 2) {
            $message = "Access Denied.";
            $this->session->set_flashdata('error_message', $message);
            redirect(base_url());
        }
        if($this->session->userdata('membership_id') == 0) {
            $message = "Your Membership Period is expired. Please buy membership.";
            $this->session->set_flashdata('error_message', $message);
            redirect(base_url());
        }

        $this->data['gigs_country'] = $this->gigs_model->gigs_country();
        if (($this->session->userdata('SESSION_USER_ID'))) {

            $this->load->library('pagination');

            $config['base_url'] = base_url("dashboard/reminder/");

            $config['per_page'] = 16;

            if (($this->session->userdata('SESSION_USER_ID'))) {
                $user_id = $this->session->userdata('SESSION_USER_ID');
            }

            $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];

            $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

            $config['total_rows'] = $this->gigs_model->favourites($user_id, 0, 0, 0);

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

            $this->data['page'] = 'index';

            $this->data['links'] = $this->pagination->create_links();

            $this->data['list'] = $this->gigs_model->favourites($user_id, 1, $offset, $config['per_page']);

            $this->data['page_title'] = 'Favorites';
            $this->data['module'] = 'my_gigs';
            $this->data['page'] = 'my_favourites';

            $this->load->vars($this->data);

            $this->load->view($this->data['theme'] . '/template');

        } else {
            redirect(base_url());
        }
    }

    public function get_state_list()
    {

        $country_id = $this->input->post('country_id');

        $query = $this->db->query("SELECT * FROM `states` WHERE `country_id` = $country_id AND `state_status` = 1");

        $result = $query->result_array();

        $html = '<option value ="">--Select State--</option>';

        foreach ($result as $state_list) {

            $html .= "<option value = '" . $state_list['state_id'] . "'>" . $state_list['state_name'] . "</option>";

        }

        echo $html;

    }

    public function check_gig_title()
    {
        $title = str_replace(" ", "-", trim($this->input->post('gig_title')));
        $append_sql = '';
        $gig_id = $this->input->post('gig_id');
        if (!empty($gig_id)) {
            $append_sql = "AND id != " . $gig_id . "";
        }
        $query = $this->db->query("SELECT * FROM `sell_gigs` WHERE `title` = '$title' " . $append_sql . ";");
        $result = $query->num_rows();
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

    public function devicedetails()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $this->gigs_model->save_device_id($data);
            return 1;
        }
    }

    // public function payment()
    // {
    //     if ($this->input->post('submit')) {

    //         $token = $this->input->post('access_token');
    //         $currency_symbol = $this->input->post('currency_type');

    //         if ($currency_symbol == "$") {
    //             $currency_type = 'USD';
    //         }

    //         if ($currency_symbol == "€") {
    //             $currency_type = 'EUR';
    //         }

    //         if ($currency_symbol == "£") {
    //             $currency_type = 'GBP';
    //         }

    //         $data['user_id'] = $this->session->userdata('SESSION_USER_ID');
    //         $data['item_id'] = $this->input->post('gigs_id');
    //         $data['currency'] = $currency_type;
    //         $data['time_zone'] = $this->session->userdata('time_zone');
    //         $data['price'] = $this->input->post('gigs_rate');
    //         $data['fee'] = 0;
    //         $data['type'] = 0;
    //         $data['remark'] = 'gigs';
    //         $data['status'] = 0;
    //         $data['pay_method'] = $this->input->post('group2');
    //         $data['txn_id'] = 0;
    //         $data['created_date'] = date('Y-m-d H:i:s');
    //         $data['updated_date'] = date('Y-m-d H:i:s');

    //         if ($this->db->insert('payments', $data)) {
    //             $insert_id = $this->db->insert_id();
    //             $this->buy($insert_id, $data, $token);
    //         }
    //     }
    // }

    // function buy($id, $data, $token)
    // {
    //     $pay_method = $data['pay_method'];
    //     if($pay_method == 'paypal') {
    //         $returnURL = base_url() . 'user/gigs/paypal_success/';
    //         $cancelURL = base_url() . 'user/gigs/paypal_cancel';
    //         $notifyURL = base_url() . 'user/gigs/ipn';

    //         $item_name = $data['item_id'];
    //         $custom = $data['user_id'];
    //         $item_number = $id;
    //         $amount = $data['price'] + $data['fee'];
    //         $amount = intval(($amount * 100)) / 100;
    //         $currency_type = $data['currency'];

    //         $this->paypal_lib->add_field('return', $returnURL);
    //         $this->paypal_lib->add_field('cancel_return', $cancelURL);
    //         $this->paypal_lib->add_field('notify_url', $notifyURL);
    //         $this->paypal_lib->add_field('item_name', $item_name);
    //         $this->paypal_lib->add_field('custom', $custom);
    //         $this->paypal_lib->add_field('item_number', $item_number);
    //         $this->paypal_lib->add_field('amount', $amount);
    //         $this->paypal_lib->add_field('currency_code', $currency_type);
    //         $this->paypal_lib->add_field('business', $this->paypal_id);
    //         $this->paypal_lib->paypal_auto_form();
    //     }
    //     else if($pay_method == 'paytab') {
    //         $amount = $data['price'] + $data['fee'];
    //         $item_name = $data['item_id'];
    //         $currency_type = $data['currency'];

    //         $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    //         $USERID = $this->session->userdata('SESSION_USER_ID');
    //         $userdetails = $this->db->query('select m.email,m.fullname,m.phone,c.sortname,c.country,s.state_name from members as m 
	// 										   LEFT JOIN country as c on c.id=m.country
	// 										   LEFT JOIN states as s on s.state_id=m.state
	// 										   WHERE USERID=' . $USERID)->row_array();


    //         $details = array("merchant_email" => $this->paytabs_email,
    //             "secret_key" => $this->paytabs_secretkey,
    //             "site_url" => base_url($this->data['theme']),
    //             "return_url" => base_url() . 'user/gigs/paytabs_success/',
    //             "title" => $item_name,
    //             "cc_first_name" => $userdetails['fullname'],
    //             "cc_last_name" => "Not Mentioned",
    //             "cc_phone_number" => !empty($userdetails['phone']) ? $userdetails['phone'] : '0000',
    //             "phone_number" => !empty($userdetails['phone']) ? $userdetails['phone'] : '0000',
    //             "email" => $userdetails['email'],
    //             "products_per_title" => $item_name,
    //             "unit_price" => $amount,
    //             "quantity" => "1",
    //             "other_charges" => "0",
    //             "amount" => $amount,
    //             "discount" => "0",
    //             "currency" => $currency_type,
    //             "reference_no" => $id,
    //             "ip_customer" => $ip,
    //             "ip_merchant" => $ip,
    //             "billing_address" => 'Not Mentioned',
    //             "city" => 'Not Mentioned',
    //             "state" => !empty($userdetails['state_name']) ? $userdetails['state_name'] : 'Not Mentioned',
    //             "postal_code" => 'Not Mentioned',
    //             "country" => !empty($userdetails['sortname']) ? $userdetails['sortname'] : 'IND',
    //             "shipping_first_name" => $userdetails['fullname'],
    //             "shipping_last_name" => "Not Mentioned",
    //             "address_shipping" => 'Not Mentioned',
    //             "state_shipping" => !empty($userdetails['state_name']) ? $userdetails['state_name'] : 'Not Mentioned',
    //             "city_shipping" => 'Not Mentioned',
    //             "postal_code_shipping" => 'Not Mentioned',
    //             "country_shipping" => !empty($userdetails['sortname']) ? $userdetails['sortname'] : 'IND',
    //             "msg_lang" => "English",
    //             "cms_with_version" => "CodeIgniter 3.1.9"
    //         );

    //         $ch = curl_init();

    //         curl_setopt($ch, CURLOPT_URL, "https://www.paytabs.com/apiv2/create_pay_page");
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($details));
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         $response = curl_exec($ch);
    //         curl_close($ch);
    //         $pay_tabs_response = json_decode($response);

    //         if (!empty($pay_tabs_response->payment_url)) {
    //             $this->db->where('id', $id)->update('payments', array('status' => 1));
    //             redirect(urldecode($pay_tabs_response->payment_url));
    //         } else {
    //             $message = str_replace('_', ' ', $pay_tabs_response->result);
    //             $this->session->set_flashdata('message', $message);
    //             redirect(base_url() . 'purchase-success/' . $id);
    //         }
    //     }
    //     else if($pay_method == 'stripe') {
    //         $amount = $data['price'] + $data['fee'];

    //         $chargeArr = array(
    //             "amount" => $amount . '00',
    //             "currency" => $data['currency'],
    //             "source" => $token,
    //             "description" => "Stripe Payment"
    //         );

    //         $response = $this->stripe->stripe_charges($chargeArr);

    //         if (!empty($response)) {

    //             $response = json_decode($response, true);
    //             $transactionID = $response['balance_transaction'];

    //             if (!empty($response['id'])) {
    //                 $charge_id = $response['id'];
    //             } else {
    //                 $charge_id = 0;
    //             }

    //             if($charge_id == 1) {
    //                 $this->db->where('id', $id);

    //                 $update_data = array(
    //                     'txn_id' => $transactionID,
    //                     'status' => 1
    //                 );
    //                 $this->db->update('payments', $update_data);
    //             }

    //         }

    //         $this->stripe_success($id, $transactionID);
    //     }
    // }

    // function paypal_success()
    // {
    //     if (isset($_POST["txn_id"]) && !empty($_POST["txn_id"])) {
    //         $paypalInfo = $this->input->post();
    //         $txn_id = $paypalInfo['txn_id'];
    //         $item_number = $paypalInfo['item_number'];
    //     } else {
    //         $paypalInfo = $this->input->get();
    //         $txn_id = $paypalInfo['tx'];
    //         $item_number = $paypalInfo['item_number'];
    //     }

    //     $uid = $item_number;
    //     $table_data['txn_id'] = $txn_id;
    //     $table_data['status'] = 1;

    //     $this->db->where('id', $uid);
    //     $this->db->update('payments', $table_data);

    //     $email_details = $this->gigs_model->gig_purchase_requirements($uid);

    //     $title = $email_details['title'];
    //     $gig_preview_link = base_url() . 'gig-preview/' . $title;
    //     $img_path = base_url() . $email_details['gig_image_thumb'];
    //     $toemail = $email_details['email'];
    //     $currency = (!empty($email_details['currency'])) ? $email_details['currency'] : 'USD';
    //     $sign = currency_sign($currency);
    //     $gig_price = $sign . $email_details['price'];
    //     $user_profile_link = base_url() . 'user-profile/' . $email_details['buyer_username'];

    //     $tot_al = (!empty($this->user_language[$this->user_selected]['lg_total'])) ? $this->user_language[$this->user_selected]['lg_total'] : $this->default_language['en']['lg_total'];

    //     $h_all = '<tr>
	// 		<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">' . $tot_al . '</td>
	// 		<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">' . $sign . ' ' . $email_details['price'] . '</td>
	// 		</tr>';

    //     $request_link = base_url() . 'sales';
    //     $this->load->model('templates_model');
    //     $bodyid = 22;
    //     $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
    //     $body = $tempbody_details['template_content'];

    //     $body = str_replace('{base_url}', $this->base_domain, $body);
    //     $body = str_replace('{gig_owner}', $email_details['seller_name'], $body);
    //     $body = str_replace('{buyer_name}', $email_details['buyer_name'], $body);
    //     $body = str_replace('{title}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{title_url}', $title, $body);
    //     $body = str_replace('{PAYPAL_ID}', $txn_id, $body);
    //     $body = str_replace('{ITEM_NAME}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{PRICE}', $gig_price, $body);
    //     $body = str_replace('{BUYER_LINK}', $user_profile_link, $body);
    //     $body = str_replace('{TEABLE_ROW}', $h_all, $body);
    //     $body = str_replace('{IMG_SRC}', $img_path, $body);
    //     $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
    //     $body = str_replace('{request_link}', $request_link, $body);
    //     $body = str_replace('{site_name}', $this->site_name, $body);

    //     $seller_message = $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
	// 		<tr>
	// 		<td></td>
	// 		<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
	// 		<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
	// 		<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
	// 		<tr>
	// 		<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
	// 		<table width="100%" cellpadding="0" cellspacing="0">
	// 		<tr>
	// 		<td style="text-align:center;">
	// 		<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
	// 		</td>
	// 		</tr>
	// 		<tr>
	// 		<td>' . $body . '</td>
	// 		</tr>
	// 		</table>
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
	// 		<table width="100%">
	// 		<tr>
	// 		<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
	// 		&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		</div>
	// 		</div>
	// 		</td>
	// 		</tr>
	// 		</table>';

    //     $this->load->helper('file');

    //     $this->load->library('email');
    //     $this->email->initialize($this->smtp_config);
    //     $this->email->set_newline("\r\n");
    //     $this->email->from($this->email_address, $this->email_tittle);
    //     $this->email->to($toemail);
    //     $this->email->subject('New order from ' . $email_details['buyer_name']);
    //     $this->email->message($seller_message);
    //     $this->email->send();

    //     //admin mail function
    //     $from_timezone = $this->session->userdata('time_zone');
    //     date_default_timezone_set($from_timezone);
    //     $current_time = date('Y-m-d H:i:s');
    //     $bodyid = 19;
    //     $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
    //     $body = $tempbody_details['template_content'];
    //     $body = str_replace('{base_url}', $this->base_domain, $body);
    //     $body = str_replace('{PAYPAL_ID}', $txn_id, $body);
    //     $body = str_replace('{CREATED_ON}', $current_time, $body);
    //     $body = str_replace('{buyer_name}', $email_details['buyername'], $body);
    //     $body = str_replace('{seller_name}', $email_details['sellername'], $body);
    //     $body = str_replace('{ITEM_NAME}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{PRICE}', '' . $gig_price, $body);
    //     $body = str_replace('{IMG_SRC}', $img_path, $body);
    //     $body = str_replace('{site_name}', $this->site_name, $body);
    //     $body = str_replace('{TEABLE_ROW}', $h_all, $body);
    //     $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
	// 		<tr>
	// 		<td></td>
	// 		<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
	// 		<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
	// 		<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
	// 		<tr>
	// 		<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
	// 		<table width="100%" cellpadding="0" cellspacing="0">
	// 		<tr>
	// 		<td style="text-align:center;">
	// 		<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
	// 		</td>
	// 		</tr>
	// 		<tr>
	// 		<td>' . $body . '</td>
	// 		</tr>
	// 		</table>
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
	// 		<table width="100%">
	// 		<tr>
	// 		<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
	// 		&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		</div>
	// 		</div>
	// 		</td>
	// 		</tr>
	// 		</table>';

    //     $this->load->helper('file');

    //     $this->load->library('email');
    //     $this->email->initialize($this->smtp_config);
    //     $this->email->set_newline("\r\n");

    //     $this->email->from($this->email_address, $this->email_tittle);
    //     $this->email->to($this->email_address);
    //     $this->email->subject('Create New Order');
    //     $this->email->message($message);

    //     if ($this->email->send()) {
    //         redirect(base_url() . 'purchase-success/' . $uid);
    //     } else {
    //         redirect(base_url() . 'purchase-success/' . $uid);
    //     }
    // }

    // function paypal_cancel()
    // {
    //     redirect(base_url() . 'purchase-success');
    // }

    // function ipn(){
    //     // Retrieve transaction data from PayPal IPN POST
    //     $paypalInfo = $this->input->post();

    //     if(!empty($paypalInfo)){
    //         // Validate and get the ipn response
    //         $ipnCheck = $this->paypal_lib->validate_ipn($paypalInfo);

    //         // Check whether the transaction is valid
    //         if($ipnCheck){
    //             // Check whether the transaction data is exists
    //             $id = $paypalInfo["item_number"];
    //             $this->db->where('id', $id);

    //             $data = array(
    //                 'txn_id' => $paypalInfo["txn_id"]
    //             );

    //             $this->db->update('payment', $data);
    //         }
    //     }
    // }

    // public function stripe_success($uid, $txn_id)
    // {
    //     $email_details = $this->gigs_model->gig_purchase_requirements($uid);

    //     $title = $email_details['title'];
    //     $gig_preview_link = base_url() . 'gig-preview/' . $title;
    //     $img_path = base_url() . $email_details['gig_image_thumb'];
    //     $toemail = $email_details['email'];
    //     $currency = (!empty($email_details['currency'])) ? $email_details['currency'] : 'USD';
    //     $sign = currency_sign($currency);
    //     $gig_price = $sign . $email_details['price'];
    //     $user_profile_link = base_url() . 'user-profile/' . $email_details['buyer_username'];

    //     $tot_al = (!empty($this->user_language[$this->user_selected]['lg_total'])) ? $this->user_language[$this->user_selected]['lg_total'] : $this->default_language['en']['lg_total'];

    //     $h_all = '<tr>
	// 		<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">' . $tot_al . '</td>
	// 		<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">' . $sign . ' ' . $email_details['price'] . '</td>
	// 		</tr>';

    //     $request_link = base_url() . 'sales';
    //     $this->load->model('templates_model');
    //     $bodyid = 22;
    //     $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
    //     $body = $tempbody_details['template_content'];

    //     $body = str_replace('{base_url}', $this->base_domain, $body);
    //     $body = str_replace('{gig_owner}', $email_details['seller_name'], $body);
    //     $body = str_replace('{buyer_name}', $email_details['buyer_name'], $body);
    //     $body = str_replace('{title}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{title_url}', $title, $body);
    //     $body = str_replace('{PAYPAL_ID}', $txn_id, $body);
    //     $body = str_replace('{ITEM_NAME}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{PRICE}', $gig_price, $body);
    //     $body = str_replace('{BUYER_LINK}', $user_profile_link, $body);
    //     $body = str_replace('{TEABLE_ROW}', $h_all, $body);
    //     $body = str_replace('{IMG_SRC}', $img_path, $body);
    //     $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
    //     $body = str_replace('{request_link}', $request_link, $body);
    //     $body = str_replace('{site_name}', $this->site_name, $body);

    //     $seller_message = $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
	// 		<tr>
	// 		<td></td>
	// 		<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
	// 		<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
	// 		<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
	// 		<tr>
	// 		<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
	// 		<table width="100%" cellpadding="0" cellspacing="0">
	// 		<tr>
	// 		<td style="text-align:center;">
	// 		<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
	// 		</td>
	// 		</tr>
	// 		<tr>
	// 		<td>' . $body . '</td>
	// 		</tr>
	// 		</table>
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
	// 		<table width="100%">
	// 		<tr>
	// 		<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
	// 		&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		</div>
	// 		</div>
	// 		</td>
	// 		</tr>
	// 		</table>';

    //     $this->load->helper('file');

    //     $this->load->library('email');
    //     $this->email->initialize($this->smtp_config);
    //     $this->email->set_newline("\r\n");
    //     $this->email->from($this->email_address, $this->email_tittle);
    //     $this->email->to($toemail);
    //     $this->email->subject('New order from ' . $email_details['buyer_name']);
    //     $this->email->message($seller_message);
    //     $this->email->send();

    //     //admin mail function
    //     $from_timezone = $this->session->userdata('time_zone');
    //     date_default_timezone_set($from_timezone);
    //     $current_time = date('Y-m-d H:i:s');
    //     $bodyid = 19;
    //     $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
    //     $body = $tempbody_details['template_content'];
    //     $body = str_replace('{base_url}', $this->base_domain, $body);
    //     $body = str_replace('{PAYPAL_ID}', $txn_id, $body);
    //     $body = str_replace('{CREATED_ON}', $current_time, $body);
    //     $body = str_replace('{buyer_name}', $email_details['buyername'], $body);
    //     $body = str_replace('{seller_name}', $email_details['sellername'], $body);
    //     $body = str_replace('{ITEM_NAME}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{PRICE}', '' . $gig_price, $body);
    //     $body = str_replace('{IMG_SRC}', $img_path, $body);
    //     $body = str_replace('{site_name}', $this->site_name, $body);
    //     $body = str_replace('{TEABLE_ROW}', $h_all, $body);
    //     $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
	// 		<tr>
	// 		<td></td>
	// 		<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
	// 		<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
	// 		<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
	// 		<tr>
	// 		<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
	// 		<table width="100%" cellpadding="0" cellspacing="0">
	// 		<tr>
	// 		<td style="text-align:center;">
	// 		<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
	// 		</td>
	// 		</tr>
	// 		<tr>
	// 		<td>' . $body . '</td>
	// 		</tr>
	// 		</table>
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
	// 		<table width="100%">
	// 		<tr>
	// 		<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
	// 		&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		</div>
	// 		</div>
	// 		</td>
	// 		</tr>
	// 		</table>';

    //     $this->load->helper('file');

    //     $this->load->library('email');
    //     $this->email->initialize($this->smtp_config);
    //     $this->email->set_newline("\r\n");

    //     $this->email->from($this->email_address, $this->email_tittle);
    //     $this->email->to($this->email_address);
    //     $this->email->subject('Create New Order');
    //     $this->email->message($message);

    //     if ($this->email->send()) {
    //         redirect(base_url() . 'purchase-success/' . $uid);
    //     } else {
    //         redirect(base_url() . 'purchase-success/' . $uid);
    //     }
    // }

    // public function paytabs_success()
    // {
    //     $referenceno = $_REQUEST['payment_reference'];

    //     $details = array("merchant_email" => $this->paytabs_email,
    //         "secret_key" => $this->paytabs_secretkey,
    //         "payment_reference" => $referenceno
    //     );

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, "https://www.paytabs.com/apiv2/verify_payment");
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($details));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     $pay_success_response = json_decode($response);

    //     $table_data['txn_id'] = $pay_success_response->transaction_id;
    //     $table_data['status'] = 1;

    //     $uid = $pay_success_response->reference_no;
    //     $this->db->where('id', $uid);
    //     $this->db->update('payments', $table_data);

    //     $txn_id = $pay_success_response->transaction_id;

    //     $email_details = $this->gigs_model->gig_purchase_requirements($uid);

    //     $title = $email_details['title'];
    //     $gig_preview_link = base_url() . 'gig-preview/' . $title;
    //     $img_path = base_url() . $email_details['gig_image_thumb'];
    //     $toemail = $email_details['email'];
    //     $currency = (!empty($email_details['currency'])) ? $email_details['currency'] : 'USD';
    //     $sign = currency_sign($currency);
    //     $gig_price = $sign . $email_details['price'];
    //     $user_profile_link = base_url() . 'user-profile/' . $email_details['buyer_username'];

    //     $tot_al = (!empty($this->user_language[$this->user_selected]['lg_total'])) ? $this->user_language[$this->user_selected]['lg_total'] : $this->default_language['en']['lg_total'];

    //     $h_all = '<tr>
	// 		<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">' . $tot_al . '</td>
	// 		<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">' . $sign . ' ' . $email_details['price'] . '</td>
	// 		</tr>';

    //     $request_link = base_url() . 'sales';
    //     $this->load->model('templates_model');

    //     $bodyid = 22;

    //     $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);

    //     $body = $tempbody_details['template_content'];

    //     $body = str_replace('{base_url}', $this->base_domain, $body);
    //     $body = str_replace('{gig_owner}', $email_details['seller_name'], $body);
    //     $body = str_replace('{buyer_name}', $email_details['buyer_name'], $body);
    //     $body = str_replace('{title}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{title_url}', $title, $body);
    //     $body = str_replace('{PAYPAL_ID}', $txn_id, $body);
    //     $body = str_replace('{ITEM_NAME}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{PRICE}', $gig_price, $body);
    //     $body = str_replace('{BUYER_LINK}', $user_profile_link, $body);
    //     $body = str_replace('{TEABLE_ROW}', $h_all, $body);
    //     $body = str_replace('{IMG_SRC}', $img_path, $body);
    //     $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
    //     $body = str_replace('{request_link}', $request_link, $body);
    //     $body = str_replace('{site_name}', $this->site_name, $body);

    //     $seller_message = $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
	// 		<tr>
	// 		<td></td>
	// 		<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
	// 		<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
	// 		<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
	// 		<tr>
	// 		<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
	// 		<table width="100%" cellpadding="0" cellspacing="0">
	// 		<tr>
	// 		<td style="text-align:center;">
	// 		<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
	// 		</td>
	// 		</tr>
	// 		<tr>
	// 		<td>' . $body . '</td>
	// 		</tr>
	// 		</table>
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
	// 		<table width="100%">
	// 		<tr>
	// 		<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
	// 		&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		</div>
	// 		</div>
	// 		</td>
	// 		</tr>
	// 		</table>';

    //     $this->load->helper('file');

    //     $this->load->library('email');
    //     $this->email->initialize($this->smtp_config);
    //     $this->email->set_newline("\r\n");
    //     $this->email->from($this->email_address, $this->email_tittle);
    //     $this->email->to($toemail);
    //     $this->email->subject('New order from ' . $email_details['buyer_name']);
    //     $this->email->message($seller_message);
    //     $this->email->send();

    //     //admin mail function

    //     $from_timezone = $this->session->userdata('time_zone');
    //     date_default_timezone_set($from_timezone);
    //     $current_time = date('Y-m-d H:i:s');
    //     $bodyid = 19;
    //     $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);
    //     $body = $tempbody_details['template_content'];
    //     $body = str_replace('{base_url}', $this->base_domain, $body);
    //     $body = str_replace('{PAYPAL_ID}', $txn_id, $body);
    //     $body = str_replace('{CREATED_ON}', $current_time, $body);
    //     $body = str_replace('{buyer_name}', $email_details['buyername'], $body);
    //     $body = str_replace('{seller_name}', $email_details['sellername'], $body);
    //     $body = str_replace('{ITEM_NAME}', str_replace("-", " ", $title), $body);
    //     $body = str_replace('{PRICE}', '' . $gig_price, $body);
    //     $body = str_replace('{IMG_SRC}', $img_path, $body);
    //     $body = str_replace('{site_name}', $this->site_name, $body);
    //     $body = str_replace('{TEABLE_ROW}', $h_all, $body);

    //     $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
	// 		<tr>
	// 		<td></td>
	// 		<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
	// 		<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
	// 		<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
	// 		<tr>
	// 		<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
	// 		<table width="100%" cellpadding="0" cellspacing="0">
	// 		<tr>
	// 		<td style="text-align:center;">
	// 		<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
	// 		</td>
	// 		</tr>
	// 		<tr>
	// 		<td>' . $body . '</td>
	// 		</tr>
	// 		</table>
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
	// 		<table width="100%">
	// 		<tr>
	// 		<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
	// 		&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
	// 		</td>
	// 		</tr>
	// 		</table>
	// 		</div>
	// 		</div>
	// 		</td>
	// 		</tr>
	// 		</table>';

    //     $this->load->helper('file');

    //     $this->load->library('email');
    //     $this->email->initialize($this->smtp_config);
    //     $this->email->set_newline("\r\n");
    //     $this->email->from($this->email_address, $this->email_tittle);
    //     $this->email->to($this->email_address);
    //     $this->email->subject('Create New Order');
    //     $this->email->message($message);

    //     if ($this->email->send()) {
    //         redirect(base_url() . 'purchase-success/' . $uid);
    //     } else {
    //         redirect(base_url() . 'purchase-success/' . $uid);
    //     }
    // }

    // public function purchase_success($payment_id)
    // {
    //     $this->data['purchase_details'] = $purchase_details = $this->gigs_model->purchase_completed($payment_id);

    //     $seller_id = $purchase_details['seller_id'];
    //     $title = $purchase_details['title'];
    //     $title = str_replace('-', ' ', $title);

    //     $this->load->model('api_gigs_model', 'gigs');
    //     $this->gigs->order_status_notification($seller_id, $title, 'Your gig has been purchased');

    //     $this->data['page_title'] = 'Thanks for purchasing';
    //     $this->data['module'] = 'purchase_success';
    //     $this->data['page'] = 'index';
    //     $this->load->vars($this->data);
    //     $this->load->view($this->data['theme'] . '/template');
    // }

}
?>