<?php

class Financial extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        error_reporting(0);

        $this->data['theme'] = 'admin';

        $this->data['module'] = 'financial';
        $this->load->helper('currency');
        $this->load->model('admin_panel_model');
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;

        $this->load->helper('favourites');
        $this->load->helper('currency');
    }

    public function affiliate($start = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/financial/affiliate");

        $config['total_rows'] = $this->admin_panel_model->all_affiliate(0, 0, 0);
        
        $config['uri_segment'] = 3;
        $config['per_page'] = 15;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
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
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $this->data['page'] = 'affiliate';
        $this->data['links'] = $this->pagination->create_links();
        $start = (int)$this->uri->segment(3);
        $this->data['list'] = $this->admin_panel_model->all_affiliate(1, $start, $config['per_page']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function membership($start = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/financial/membership");

        $config['total_rows'] = $this->admin_panel_model->all_membership(0, 0, 0);
        
        $config['uri_segment'] = 3;
        $config['per_page'] = 15;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
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
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $this->data['page'] = 'membership';
        $this->data['links'] = $this->pagination->create_links();
        $start = (int)$this->uri->segment(3);
        $this->data['list'] = $this->admin_panel_model->all_membership(1, $start, $config['per_page']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function commission($start = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/financial/commission");

        $config['total_rows'] = $this->admin_panel_model->all_commission(0, 0, 0);
        
        $config['uri_segment'] = 3;
        $config['per_page'] = 15;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
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
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $this->data['page'] = 'commission';
        $this->data['links'] = $this->pagination->create_links();
        $start = (int)$this->uri->segment(3);
        $this->data['list'] = $this->admin_panel_model->all_commission(1, $start, $config['per_page']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
}

?>