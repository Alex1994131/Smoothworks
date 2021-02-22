<?php

class Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'category';
        $this->load->model('admin_panel_model');
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
    }

    public function index()
    {
        $this->data['page'] = 'index';
        $this->data['list'] = $this->admin_panel_model->all_category();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function add_category()
    {
        $this->data['page'] = 'add_category';
        $this->data['parent_category'] = $this->admin_panel_model->parent_category();

        if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/category');

            } else {
                $data['parent'] = $this->input->post('parent_category');
                $data['name'] = $this->input->post('category_name');
                $data['status'] = 0;
                if ($this->db->insert('categories', $data)) {
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully Added</div>";
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/category');
            }
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function edit_category($category_id)
    {
        $this->data['page'] = 'edit_category';
        $this->data['parent_category'] = $this->admin_panel_model->parent_category();
        $this->data['list'] = $this->admin_panel_model->edit_category($category_id);
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/category');

        } else {
            if ($this->input->post('form_submit')) {
                $data['parent'] = $this->input->post('parent_category');
                $data['name'] = $this->input->post('category_name');
                $data['seo'] = $this->input->post('cat_seo_name');
                $data['details'] = $this->input->post('category_description');
                $data['mtitle'] = $this->input->post('page_title');
                $data['mdesc'] = $this->input->post('category_meta_desc');
                $data['mtags'] = $this->input->post('category_meta_keywords');
                $this->load->library('common');
                $data['status'] = $this->input->post('status');
                $this->db->where('CATID', $category_id);
                if ($this->db->update('categories', $data)) {
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Catagory Successfully updated.</div>";
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/category');
            }
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function delete_category()
    {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/category');

        } else {
            $id = $this->input->post('tbl_id');
            $this->db->where('CATID', $id);
            if ($this->db->delete('categories')) {
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Catagory Successfully Deleted.</div>";
                echo 1;
            }
            $this->session->set_flashdata('message', $message);
        }
    }

    public function multiple_delete()
    {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/category');

        } else {
            $id = explode(',', $this->input->post('multi_Delete'));
            for ($i = 0; $i < count($id); $i++) {
                $this->db->where('CATID', $id[$i]);
                $result = $this->db->delete('categories');
            }

            if ($result) {
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Catagory Successfully Deleted.</div>";
                echo 1;
            }
            $this->session->set_flashdata('message', $message);
            redirect(base_url() . 'admin/category');
        }
    }

}

?>