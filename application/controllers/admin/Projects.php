<?php

class Projects extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        error_reporting(0);

        $this->data['theme'] = 'admin';

        $this->data['module'] = 'projects';
        $this->load->helper('currency');
        $this->load->model('admin_panel_model');
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;

        $this->load->helper('favourites');
        $this->load->helper('currency');
    }

    public function index($start = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/projects/");
        $config['total_rows'] = $this->db->count_all('projects');
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
        $this->data['page'] = 'index';
        $this->data['links'] = $this->pagination->create_links();
        $start = (int)$this->uri->segment(3);
        $this->data['list'] = $this->admin_panel_model->all_projects(1, $start, $config['per_page']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function admin_delete_projects()
    {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/projects');
        } else {
            if ($this->input->post('id')) {
                $id = $this->input->post('id');
                $this->session->set_flashdata('message', "The Project remove faild");
                if (!empty($id)) {
                    $this->db->where('id', $id);
                    $this->db->delete('projects');
                    $this->db->where('project_id', $id);
                    $this->db->delete('projects_files');
                    $this->load->helper('file');
                    delete_files('uploads/project_files/'.$id.'/');
                    $this->session->set_flashdata('message', 'The Project has been removed...');
                }
                echo 1;
                die();
            }
        }

    }

    public function project_preview()
    {
        $id = $this->uri->segment(4);
        $this->data['page'] = 'preview';
        $this->data['details'] = $this->admin_panel_model->project_preview($id);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
}

?>