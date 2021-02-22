<?php

class Projects extends CI_Controller
{

    public $project_data = array();
    
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->helper('currency');
        $this->load->library('paypal_lib');
        $this->load->model('projects_model');
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
        $this->data['module'] = 'project';
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

    public function add_project()
    {
        if(!$this->session->userdata('SESSION_USER_ID')) {
            $message = "Access Denied.";
            $this->session->set_flashdata('error_message', $message);
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

        $query = $this->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        $this->email_tittle = 'Projects';

        if (!empty($result)) {
            foreach ($result as $data) {
                if ($data['key'] == 'site_name' || $data['key'] == 'website_name') {
                    $this->site_name = $data['value'];
                    $this->data['site_name'] = $this->site_name;
                }
            }
        }

        if ($this->session->userdata('SESSION_USER_ID')) {

            $this->data['page_title'] = 'Post Project';
            $this->data['module'] = 'sell_project';
            $this->data['page'] = 'add_project';
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');

        } else {
            redirect(base_url());
        }

    }

    public function edit_project($project_id)
    {
        $project_details = $this->projects_model->get_project_details($project_id);
        if (empty($project_details['id'])) {
            redirect(base_url());
        }

        $userid = $this->session->userdata('SESSION_USER_ID');

        $this->data['project_details'] = $project_details;

        $this->data['page_title'] = 'Edit Project';
        $this->data['module'] = 'sell_project';
        $this->data['page'] = "edit_project";

        $this->data['project_files'] = explode('#', $project_details['file_paths']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function delete_project() {
        $project_id = $this->input->post('project_id');

        if ($this->session->userdata('SESSION_USER_ID')) {
            $this->db->where('id', $project_id);
            
            if($this->db->delete('projects')) {
                $this->db->where('project_id', $project_id);
                $this->db->delete('projects_files');

                $this->db->where('project_id', $project_id);
                $this->db->delete('bids');

                echo 'success';
            }
        }
        else {
            echo 'failure';
        }
    }

    public function save_project()
    {
        $project_id = $this->input->post('project_id');

        if($project_id == null || $project_id == 0) {
            $project_tags = ucfirst($this->input->post('project_tags'));

            if (!empty($project_tags)) {
                $data['project_tags'] = $project_tags;
            }

            $data['user_id'] = $this->session->userdata('SESSION_USER_ID');
            $data['title'] = $this->input->post('project_title');
            $data['project_price'] = $this->input->post('project_price');
            $data['time_zone'] = $time_zone = $this->session->userdata('time_zone');
            $data['delivering_time'] = $this->input->post('delivering_time');
            $data['category_id'] = $this->input->post('project_category_id');
            $data['project_details'] = $this->input->post('project_details');
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

            $data['currency_type'] = $this->data['currency_option'];

            $this->db->select('value');
            $this->db->where('key', 'price_option');
            $price_by = $this->db->get('system_settings')->row_array();
            $cost_type = ($price_by['value'] == 'dynamic') ? 1 : 0;
            $data['cost_type'] = $cost_type;

            if ($this->db->insert('projects', $data)) {
                $projects_id = $this->db->insert_id();

                $message = (!empty($this->user_language[$this->user_selected]['lg_project_added_successfully'])) ? $this->user_language[$this->user_selected]['lg_project_added_successfully'] : $this->default_language['en']['lg_project_added_successfully'];

                $this->session->set_flashdata('message', $message);
                $upload_files = $this->input->post('upload_files');

                $upload_filelist = explode('`',$upload_files);

                $upload_config['upload_path'] = 'uploads/project_files/'.$projects_id.'/';
                $upload_config['allowed_types'] = '*';
                $upload_config['remove_spaces'] = TRUE;
                $upload_config['overwrite'] = TRUE;

                $this->load->library('upload', $upload_config);
                $this->upload->initialize($upload_config);

                mkdir($upload_config['upload_path']);

                foreach($upload_filelist as $upload_filename)
                {
                    if($upload_filename == '')
                        continue;
                    $name = str_replace(array(' ', '!', '.','&'), '_', $upload_filename);
                    if ( $this->upload->do_upload($name) )
                    {
                        $file_data['project_id'] = $projects_id;
                        $file_data['file_path'] = str_replace(array(' ', '!','&'), '_', 'uploads/project_files/'.$projects_id.'/'.$upload_filename);
                        if($this->db->insert('projects_files', $file_data)){

                        }
                    }
                }

                $message = 'Project created successfully';
                $this->session->set_flashdata('message', $message);
                redirect(base_url());
            }
        }
        else {
            $project_tags = ucfirst($this->input->post('project_tags'));

            if (!empty($project_tags)) {
                $data['project_tags'] = $project_tags;
            }

            $data['user_id'] = $this->session->userdata('SESSION_USER_ID');
            $data['title'] = $this->input->post('project_title');
            $data['project_price'] = $this->input->post('project_price');
            $data['time_zone'] = $time_zone = $this->session->userdata('time_zone');
            $data['delivering_time'] = $this->input->post('delivering_time');
            $data['category_id'] = $this->input->post('project_category_id');
            $data['project_details'] = $this->input->post('project_details');
            $data['country_name'] = $this->input->post('full_country_name');
            $country_name = $this->session->userdata('country_name');

            if ($country_name == 'IN') {
                $data['currency_type'] = 1;
            }
            else {
                $data['currency_type'] = 2;
            }

            date_default_timezone_set($time_zone);
            $current_time = date('Y-m-d H:i:s');
            $data['created_date'] = $current_time;
            $data['currency_type'] = $this->data['currency_option'];
            $this->db->select('value');
            $this->db->where('key', 'price_option');
            $price_by = $this->db->get('system_settings')->row_array();
            $cost_type = ($price_by['value'] == 'dynamic') ? 1 : 0;
            $data['cost_type'] = $cost_type;

            $this->db->where('id', $project_id);
            if ($this->db->update('projects', $data)) {
                $upload_files = $this->input->post('upload_files');

                $upload_filelist = explode('`',$upload_files);

                $upload_config['upload_path'] = 'uploads/project_files/'.$project_id.'/';
                $upload_config['allowed_types'] = '*';
                $upload_config['remove_spaces'] = TRUE;
                $upload_config['overwrite'] = TRUE;

                $this->load->library('upload', $upload_config);
                $this->upload->initialize($upload_config);

                mkdir($upload_config['upload_path']);

                foreach($upload_filelist as $upload_filename)
                {
                    if($upload_filename == '')
                        continue;
                    $name = str_replace(array(' ', '!', '.','&'), '_', $upload_filename);
                    if ( $this->upload->do_upload($name) )
                    {
                        $file_data['project_id'] = $project_id;
                        $file_data['file_path'] = str_replace(array(' ', '!','&'), '_', 'uploads/project_files/'.$project_id.'/'.$upload_filename);
                        if($this->db->insert('projects_files', $file_data)){

                        }
                    }
                }

                $deleted_files = $this->input->post('deleted_files');
                $deleted_filelist = explode('#',$deleted_files);
                foreach($deleted_filelist as $deleted_file)
                {
                    if($deleted_file == '')
                        continue;
                    $this->db->where('project_id', $project_id);
                    $this->db->where('file_path', $deleted_file);
                    $this->db->delete('projects_files');
                    $this->load->helper('file');
                    unlink($deleted_file);
                }

                $message = 'Project Updated successfully';
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'project-preview/'. $project_id);
            }

        }
    }

    public function buy_project($offset = 0)
    {
        $query = $this->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        $this->email_tittle = 'Projects';
        if (!empty($result)) {
            foreach ($result as $data) {
                if ($data['key'] == 'site_name' || $data['key'] == 'website_name') {
                    $this->site_name = $data['value'];
                    $this->data['site_name'] = $this->site_name;
                }
            }
        }

        $category = $_POST["search_category"];
        if($category != 0)
        {
            $this->data['selected_category_value'] = $category;
        }

        $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];
        $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'buy-project';
        $config['per_page'] = 10;
        $config['total_rows'] = $this->projects_model->all_projects(0, 0, 0);
        $this->data['total_records'] = $config['total_rows'];

        $config['uri_segment'] = 2;
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
        $this->data['projects_country'] = $this->projects_model->projects_country();
        $this->data['project_data'] = $this->projects_model->all_projects(1, $offset, $config['per_page']);

        $this->data['page_title'] = 'Buy Project';
        $this->data['module'] = 'buy_project';
        $this->data['page'] = 'buy_project';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function my_project($offset = 0)
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

        $query = $this->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        $this->email_tittle = 'Projects';

        if (!empty($result)) {
            foreach ($result as $data) {
                if ($data['key'] == 'site_name' || $data['key'] == 'website_name') {
                    $this->site_name = $data['value'];
                    $this->data['site_name'] = $this->site_name;
                }
            }
        }

        $category = $_POST["search_category"];
        if($category != 0)
        {
            $this->data['selected_category_value'] = $category;
        }

        if ($this->session->userdata('SESSION_USER_ID')) {

            $my_account_type = $this->session->userdata('account_type');
            
            $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];
            $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];

            $this->load->library('pagination');
            $config['base_url'] = base_url() . 'my-project';
            $config['per_page'] = 10;

            if($my_account_type == 1) {
                $config['total_rows'] = $this->projects_model->my_bids($this->session->userdata('SESSION_USER_ID'), 0, 0, 0);
            }
            else {
                $config['total_rows'] = $this->projects_model->my_projects($this->session->userdata('SESSION_USER_ID'), 0, 0, 0);
            }
            
            $config['uri_segment'] = 2;
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
            $this->data['userid'] = $this->session->userdata('SESSION_USER_ID');

            if($my_account_type == 1) {
                $this->data['project_data'] = $this->projects_model->my_bids($this->session->userdata('SESSION_USER_ID'), 1, $offset, $config['per_page']);
            }
            else {
                $this->data['project_data'] = $this->projects_model->my_projects($this->session->userdata('SESSION_USER_ID'), 1, $offset, $config['per_page']);
            }
            
            $this->data['page_title'] = 'My Project';
            $this->data['module'] = 'my_project';
            $this->data['page'] = 'my_project';
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');

        } else {
            redirect(base_url());
        }
    }

    public function project_preview($project_id = 0, $is_edit = false)
    {
        $this->data['projects_country'] = $this->projects_model->projects_country();

        $project_details = $this->projects_model->get_project_details($project_id);
        if (empty($project_details['id'])) {
            redirect(base_url());
        }

        $this->data['project_tags'] = $project_details['project_tags'];
        $userid = $this->session->userdata('SESSION_USER_ID');

        $this->db->select('id');
        $this->db->from('views');
        $this->db->where('user_id', $userid);
        $this->db->where('gig_id', $project_id);
        $this->db->where('is_gig', 0);
        $check_views = $this->db->count_all_results();

        $this->db->select('id');
        $this->db->from('projects');
        $this->db->where('user_id',$userid);
        $this->db->where('id',$project_id);
        $check_self_project = $this->db->count_all_results();

        if ($check_views == 0 && $check_self_project == 0) {
            $this->db->insert('views', array('user_id' => $userid, 'gig_id' => $project_id, 'is_gig' => 0));
            $this->db->set('total_views', 'total_views+1', FALSE);
            $this->db->where('id', $project_id);
            $this->db->update('projects');
        }

        $this->data['project_id'] = $project_id;
        $user_id = $project_details['user_id'];
        $this->data['project_user_id'] = $user_id;

        $profile = $this->user_panel_model->profile($user_id);

        $this->data['user_country_shortname'] = '';
        $this->data['user_country_name'] = '';

        if (!empty($profile['country'])) {
            $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =" . $profile['country'] . " ");
            $result = $query->row_array();
            $this->data['user_country_shortname'] = $result['sortname'];
            $this->data['user_country_name'] = $result['country'];
        }

        $this->data['user_profile'] = $profile;

        if (($this->session->userdata('SESSION_USER_ID'))) {
            $user_id = $this->session->userdata('SESSION_USER_ID');
            $account_state = $this->session->userdata('account_state');

            if ($this->input->post('form_submit')) {
                $bid_id = 0;
                $this->db->select('id');
                $this->db->where('project_id', $project_id);
                $this->db->where('user_id', $user_id);
                $this->db->from('bids');
                $query = $this->db->get();
                $result = $query->result_array();

                if(count($result)>0)
                {
                    $bid_id = $result[0]['id'];
                }

                $bid_proposal = $this->input->post('bid_proposal');
                $bid_amount = $this->input->post('bid_amount');
                $bid_day = $this->input->post('delivery_day');

                if($bid_id == 0)
                {
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

                    $bid_count = $person_record['general_bid'];

                    if($bid_count == 0) {
                        $message = "You wasted all bid. Please buy membership to bid";
                        $this->session->set_flashdata('error_message', $message);
                        redirect(base_url());
                    }

                    $data['project_id'] = $project_id;
                    $data['user_id'] = $user_id;
                    $data['proposal'] = $bid_proposal;
                    $data['amount'] = $bid_amount;
                    $data['day'] = $bid_day;
                    $data['account_state'] = $account_state;

                    $this->db->insert('bids', $data);

                    if($bid_count != 0) {
                        $bid_count--;
                        $this->db->where('USERID', $person_id);
                        $this->db->update('members', array(
                            'general_bid' => $bid_count
                        ));
                    }
                }
                else
                {
                    $this->db->set('project_id', $project_id);
                    $this->db->set('user_id', $user_id);
                    $this->db->set('proposal', $bid_proposal);
                    $this->db->set('amount', $bid_amount);
                    $this->db->set('day', $bid_day);
                    $this->db->set('account_state', $account_state);
                    $this->db->where('id', $bid_id);
                    $this->db->update('bids');
                }
            }
        }

        $this->data['project_time_zone'] = $project_details['time_zone'];
        $this->data['project_time_posted'] = $project_details['created_date'];

        $this->data['username'] = $project_details['username'];
        $this->data['user_name'] = $project_details['fullname'];

        if ($project_details['parent'] == 0) {
            $category_id = $project_details['category_id'];
            $this->data['category_based_projects'] = $this->projects_model->similar_projects($category_id, $title);
        } else {
            $query = $this->db->query(" SELECT `parent` FROM `categories` WHERE `CATID` = " . $project_details['category_id'] . "");
            $result = $query->row_array();
            $category_id = $project_details['parent'];
            $this->data['category_based_projects'] = $this->projects_model->similar_projects($category_id, $title);
            if (empty($this->data['category_based_projects'])) {
                $this->data['category_based_projects'] = $this->projects_model->similar_projects($project_details['category_id'], $title);
            }
        }

        $this->data['project_details'] = $project_details;
        $this->data['feedbacks'] = $this->projects_model->projects_feedbacks($project_id, $user_id);
        $query_feed = $this->db->query("SELECT AVG(rating) FROM `feedback` WHERE `to_user_id` = '".$user_id."' and `gig_id` = '".$project_id."' and 'is_gig' = 0;");
        $fe_count = $query_feed->row_array();

        $rat = 0;

        if ($fe_count['AVG(rating)'] != '') {
            $rat = round($fe_count['AVG(rating)']);
        }

        $this->data['user_feedback'] = $rat;
        $this->data['project_user_id'] = $user_id;
        if($project_details['file_paths'] != '')
        {
            $this->data['project_files'] = explode('#', $project_details['file_paths']);
        }

        $this->data['bid_data'] = $this->projects_model->get_bid_mini_data($project_id, $this->session->userdata('SESSION_USER_ID'));
        if($is_edit)
        {
            $this->data['my_bid'] = $this->projects_model->get_bid($project_id, $this->session->userdata('SESSION_USER_ID'));
            $this->data['is_edit'] = true;
        }

        $this->data['page_title'] = 'Project Preview';
        $this->data['module'] = "buy_project";
        $this->data['page'] = "preview_project";
        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');

    }

    public function project_proposals($project_id = 0,$offset = 0)
    {
        $this->data['projects_country'] = $this->projects_model->projects_country();

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


        $this->data['project_id'] = $project_id;
        $project_details = $this->projects_model->get_project_details($project_id);
        if (empty($project_details['id'])) {
            redirect(base_url());
        }

        $this->data['project_details'] = $project_details;
        $user_id = $this->session->userdata('SESSION_USER_ID');

        $this->load->model('api_user_model');
        $session_user_data = $this->api_user_model->getUserRecord($user_id);
        $this->data['session_user_data'] = $session_user_data;

        $this->data['my_balance'] = $my_balances;

        if ($user_id) {
            $first = (!empty($this->user_language[$this->user_selected]['lg_first'])) ? $this->user_language[$this->user_selected]['lg_first'] : $this->default_language['en']['lg_first'];

            $last = (!empty($this->user_language[$this->user_selected]['lg_last'])) ? $this->user_language[$this->user_selected]['lg_last'] : $this->default_language['en']['lg_last'];
    
            $this->load->library('pagination');
            $config['base_url'] = base_url()."project-proposals/view/".$project_id;
            $config['per_page'] = 10;
            $config['total_rows'] = $this->projects_model->get_bid_project_data($project_id, $user_id, 0, 0, 0);
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

            $this->data['bid_datas'] = $this->projects_model->get_bid_project_data($project_id, $user_id, $offset, $config['per_page'], 1);
        }

        $this->data['page_title'] = 'Project Proposal';
        $this->data['module'] = "buy_project";
        $this->data['page'] = "project_proposal";
        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function proposal_award()
    {
        if ($this->input->post('bid_id') &&  $this->input->post('project_id')) {

            $bid_id = $this->input->post('bid_id');
            $project_id = $this->input->post('project_id');
    
            $this->session->set_flashdata('message', "The Proposal awarding faild");
    
            if (!empty($bid_id) && !empty($project_id)) {
                $update_data = array(
                    'award_bid'=>$bid_id,
                    'project_progress_flag' => constant('PROJ_STAT_AWARD'),
                    'updated_date' => date('Y-m-d')
                );
                $this->db->where('id', $project_id);
                $this->db->update('projects', $update_data);

                $this->session->set_flashdata('message', 'The Proposal has been awarded...');
                echo 1;
    
                die();
            }
        }
        echo 0;
        die();
    }

    public function proposal_accept()
    {
        if ($this->input->post('bid_id') &&  $this->input->post('project_id')) {

            $project_id = $this->input->post('project_id');
            $bid_id = $this->input->post('bid_id');
    
            $this->session->set_flashdata('message', "The Proposal accepting faild");

            $query = $this->db->query("select * from bids where id = $bid_id");
            $result = $query->result_array();
            $bid_amount = $result[0]['amount'];
            $acc_state = $result[0]['account_state'];
            $bid_user_id = $result[0]['user_id'];

            if($acc_state == 2) {
                $this->load->model('team_management_model');
                $team_id = $this->team_management_model->get_teamID($bid_user_id);
                $leader_id = $this->team_management_model->get_leaderinfo($team_id);   
                $bid_user_id = $leader_id;
            }

            $this->load->model('api_user_model');
            $rec = $this->api_user_model->getUserRecord($bid_user_id);
            $membership_id = $rec['membership_id'];
            $ongoing_project = $rec['ongoing_project'];

            if($ongoing_project == 0) {
                $message = "You can't accept this project. Please buy membership to bid";
                $this->session->set_flashdata('error_message', $message);
                echo 0;
                die();
            }
            else {
                $ongoing_project--;
            }

            $this->db->where('USERID', $bid_user_id);
            $this->db->update('members', array(
                'ongoing_project' => $ongoing_project
            ));

            $update_data = array(
                'award_bid'=>$bid_id,
                'project_progress_flag' => constant('PROJ_STAT_ACCEPT'),
                'updated_date' => date('Y-m-d')
            );

            $this->db->where('id', $project_id);
            $this->db->update('projects', $update_data);

            $this->load->model('membership_model');
            $membership_record = $this->membership_model->get_membership_record($membership_id);

            $membership_content = $membership_record['memberships'];
            $platform_commission = 0;

            $membership_content = explode(',', $membership_content);
            for($i=0; $i<count($membership_content); $i++) {
                $membership_detail_id = $membership_content[$i];
                $query = $this->db->query("select * from membership_detail where id = $membership_detail_id");
                $membership_detail = $query->result_array();
                $membership_detail = $membership_detail[0];
                
                if($membership_detail['group'] == 5) {
                    $platform_commission = $membership_detail['key'];
                }
            }

            $fee = $bid_amount * ($platform_commission / 100);
            $fee = round($fee);

            
            $query = $this->db->query("select * from projects where id = $project_id");
            $project_record = $query->result_array();
            $project_record = $project_record[0];

            $currency_type = $project_record['currency_type'];
            
            $data['user_id'] = $bid_user_id;
            $data['item_id'] = $project_id;
            $data['currency'] = $currency_type;
            $data['time_zone'] = $this->session->userdata('time_zone');
            $data['price'] = $fee;
            $data['type'] = 0;
            $data['remark'] = 'project fee';
            $data['status'] = 3;
            $data['pay_method'] = 'balances';
            $data['txn_id'] = 0;
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['updated_date'] = date('Y-m-d H:i:s');

            if ($this->db->insert('payments', $data)) {
                $now_balances_qry = $this->db->query("select * from balances where user_id = $bid_user_id and currency_type = '". $currency_type ."'");
                $now_balances = $now_balances_qry->result_array();
                $now_balances = $now_balances[0]['amount'];

                if($now_balances == null) {
                    $insert_data = array(
                        'user_id' => $bid_user_id,
                        'currency_type' => $currency_type,
                        'amount' => (0 - $fee)
                    );

                    $this->db->insert('balances', $insert_data);
                }
                else {
                    $new_balances = $now_balances - $fee;
                    $balances_update = array(
                        'amount' => $new_balances
                    );

                    $this->db->where('user_id', $bid_user_id);
                    $this->db->where('currency_type', $currency_type);
                    $this->db->update('balances', $balances_update);
                }

                $this->session->set_flashdata('message', 'The Proposal has been accepted...');
                echo 1;
                die();
            }
        }
        echo 0;
        die();
    }

    public function proposal_validate_balances() {

        $project_currency = $this->input->post('project_currency');
        $bid_id = $this->input->post('bid_id');
        $project_id = $this->input->post('project_id');

        $user_id = $this->session->userdata('SESSION_USER_ID');
        $this->load->model('api_user_model');
        
        $my_balances = $this->api_user_model->get_my_currency_balances($user_id, $project_currency);
        if(empty($my_balances)) {
            $my_balances = 0;
        }

        $query = $this->db->query("select * from bids where id = $bid_id");
        $result = $query->result_array();
        $bid_amount = $result[0]['amount'];

        $this->load->model('api_user_model');
        $rec = $this->api_user_model->getUserRecord($user_id);
        $membership_id = $rec['membership_id'];
        $this->load->model('membership_model');
        $membership_record = $this->membership_model->get_membership_record($membership_id);

        $membership_content = $membership_record['memberships'];
        $escrow_commission = 0;
        $membership_content = explode(',', $membership_content);
        for($i=0; $i<count($membership_content); $i++) {
            $membership_detail_id = $membership_content[$i];
            $query = $this->db->query("select * from membership_detail where id = $membership_detail_id");
            $membership_detail = $query->result_array();
            $membership_detail = $membership_detail[0];
            
            if($membership_detail['group'] == 14) {
                $escrow_commission = $membership_detail['key'];
            }
        }

        $fee = $bid_amount * ($escrow_commission / 100);
        $fee = round($fee);

        $bid_amount = $bid_amount + $fee;

        if($my_balances >= $bid_amount) {
            echo 1;
            exit(1);
        }
        else {
            echo 0;
            exit(1);
        }
    }

    public function proposal_create_milestone()
    {
        $bid_id = $this->input->post('bid_id');
        $project_id = $this->input->post('project_id');

        if (!empty($bid_id) && !empty($project_id)) {
            $query = $this->db->query("SELECT * FROM bids WHERE id = $bid_id");
            $result = $query->result_array();
            $bid_price = $result[0]['amount'];

            $query = $this->db->query("select * from projects where id = $project_id");
            $result = $query->result_array();
            $currency_type = $result[0]['currency_type'];
            
            $user_id = $this->session->userdata('SESSION_USER_ID');

            $this->load->model('api_user_model');
            $rec = $this->api_user_model->getUserRecord($user_id);
            $membership_id = $rec['membership_id'];
            $this->load->model('membership_model');
            $membership_record = $this->membership_model->get_membership_record($membership_id);

            $membership_content = $membership_record['memberships'];
            $escrow_commission = 0;
            $membership_content = explode(',', $membership_content);
            for($i=0; $i<count($membership_content); $i++) {
                $membership_detail_id = $membership_content[$i];
                $query = $this->db->query("select * from membership_detail where id = $membership_detail_id");
                $membership_detail = $query->result_array();
                $membership_detail = $membership_detail[0];
                
                if($membership_detail['group'] == 14) {
                    $escrow_commission = $membership_detail['key'];
                }
            }

            $fee = $bid_price * ($escrow_commission / 100);
            $fee = round($fee);

            $bid_price = $bid_price + $fee;

            $data['user_id'] = $this->session->userdata('SESSION_USER_ID');
            $data['item_id'] = $project_id;
            $data['currency'] = $currency_type;
            $data['time_zone'] = $this->session->userdata('time_zone');
            $data['price'] = $bid_price;
            $data['type'] = 0;
            $data['remark'] = 'milestone';
            $data['status'] = 0;
            $data['pay_method'] = 'balances';
            $data['txn_id'] = 0;
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['updated_date'] = date('Y-m-d H:i:s');

            if ($this->db->insert('payments', $data)) {
                $user_id = $this->session->userdata('SESSION_USER_ID');

                $now_balances_qry = $this->db->query("select * from balances where user_id = $user_id and currency_type = '" .$currency_type . "'");
                $now_balances = $now_balances_qry->result_array();
                $now_balances = $now_balances[0]['amount'];

                $real_balances = $now_balances - $bid_price;
                $update_data = array(
                    'amount' => $real_balances
                );

                $this->db->where('user_id', $user_id);
                $this->db->where('currency_type', $currency_type);
                $this->db->update('balances', $update_data);            
            }
        }
        else {
            $project_data = $this->project_data;
        
            $bid_id = $project_data['bid_id'];
            $project_id = $project_data['project_id'];
            $fee = $project_data['fee'];
            $currency_type = $project_data['currency_type'];
        }
        
        
        $this->session->set_flashdata('message', "The Creating milestone faild");

        if (!empty($bid_id) && !empty($project_id)) {
            $update_data = array(
                'award_bid'=>$bid_id,
                'project_progress_flag' => constant('PROJ_STAT_CREATE_MILESTONE'),
                'updated_date' => date('Y-m-d')
            );
            $this->db->where('id', $project_id);
            $this->db->update('projects', $update_data);

            $this->session->set_flashdata('message', 'The Milestone has been created...');
            return 'success';
        }
    }

    public function proposal_request_milestone()
    {
        $bid_id = $this->input->post('bid_id');
        $project_id = $this->input->post('project_id');

        if (!empty($bid_id) && !empty($project_id)) {

            $update_data = array(
                'award_bid'=>$bid_id,
                'project_progress_flag' => constant('PROJ_STAT_REQUEST_MILESTONE'),
                'updated_date' => date('Y-m-d')
            );

            $this->db->where('id', $project_id);
            $this->db->update('projects', $update_data);
            return true;
        }
        else{
            return false;
        }
    }

    public function proposal_release()
    {
        if ($this->input->post('bid_id') &&  $this->input->post('project_id')) {

            $bid_id = $this->input->post('bid_id');
            $project_id = $this->input->post('project_id');
    
            $this->session->set_flashdata('message', "The Project releasing faild");
    
            if (!empty($bid_id) && !empty($project_id)) {

                $update_data = array(
                    'award_bid'=>$bid_id,
                    'project_progress_flag' => constant('PROJ_STAT_RELEASE'),
                    'updated_date' => date('Y-m-d')
                );
                $this->db->where('id', $project_id);
                $this->db->update('projects', $update_data);

                $update_data = array(
                    'status' => 2
                );
        
                $this->db->where('item_id', $project_id);
                $this->db->where('remark', 'milestone');
                $this->db->update('payments', $update_data);
                
                $this->session->set_flashdata('message', 'The Project has been releaseed...');
                echo 1;
    
                die();
            }
        }
        echo 0;
        die();
    }

    public function proposa_cancel() {
        $bid_id = $this->input->post('bid_id');
        $project_id = $this->input->post('project_id');

        $this->db->where('id', $project_id);
        $this->db->delete('projects');

        $this->db->where('project_id', $project_id);
        $this->db->delete('projects_files');

        $this->db->where('id', $bid_id);
        $this->db->delete('bids');

        $update_data = array(
            'status' => -1
        );

        $this->db->where('item_id', $project_id);
        $this->db->where('remark', 'milestone');

        $this->db->update('payments', $update_data);
    }

    public function payment() {
        
        if ($this->input->post('submit')) {

            $project_id = $this->input->post('project_id');
            $bid_id = $this->input->post('bid_id');
            $project_price = $this->input->post('project_price');
            $currency_type = $this->input->post('project_currency');
            $pay_method = $this->input->post('group2');
            $access_token = $this->input->post('access_token');
            
            $user_id = $this->session->userdata('SESSION_USER_ID');

            $this->load->model('api_user_model');
            $rec = $this->api_user_model->getUserRecord($user_id);
            $membership_id = $rec['membership_id'];
            $this->load->model('membership_model');
            $membership_record = $this->membership_model->get_membership_record($membership_id);

            $membership_content = $membership_record['memberships'];
            $escrow_commission = 0;
            $membership_content = explode(',', $membership_content);
            for($i=0; $i<count($membership_content); $i++) {
                $membership_detail_id = $membership_content[$i];
                $query = $this->db->query("select * from membership_detail where id = $membership_detail_id");
                $membership_detail = $query->result_array();
                $membership_detail = $membership_detail[0];
                
                if($membership_detail['group'] == 14) {
                    $escrow_commission = $membership_detail['key'];
                }
            }

            $fee = $project_price * ($escrow_commission / 100);
            $fee = round($fee);

            $project_price = $project_price + $fee;

            $this->project_data = array(
                'bid_id' => $bid_id,
                'project_id' => $project_id,
                'fee' => $fee,
                'currency_type' => $currency_type
            );

            $data['user_id'] = $this->session->userdata('SESSION_USER_ID');
            $data['item_id'] = $project_id;
            $data['currency'] = $currency_type;
            $data['time_zone'] = $this->session->userdata('time_zone');
            $data['price'] = $project_price;
            $data['type'] = 0;
            $data['remark'] = 'milestone';
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

        $flag = $this->proposal_create_milestone();

        if(!$flag) {
            $message = 'Create Milestone Failure';
            $this->session->set_flashdata('error_message', $message);
            $project_data = $this->project_data;
            $project_id = $project_data['project_id'];
            redirect(base_url() . 'project-proposals/view/'. $project_id);
        }

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
        //     $message = 'Create Milestone Successfully';
        //     $this->session->set_flashdata('message', $message);
        // }  
        // else {
        //     $message = 'Email Send Failure';
        //     $this->session->set_flashdata('error_message', $message);
        // }

        $message = 'Create Milestone Successfully';
        $this->session->set_flashdata('message', $message);
        $project_data = $this->project_data;
        $project_id = $project_data['project_id'];
        redirect(base_url() . 'project-proposals/view/'.$project_id);
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

                $this->db->update('payments', $data);
            }
        }
    }
}

?>
