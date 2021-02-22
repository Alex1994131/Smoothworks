<?php

class Membership extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'membership';
        $this->load->model('Membership_model', 'membership_model');
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
    }

    public function index()
    {
        $this->data['page'] = 'index';
        $this->data['list'] = $this->membership_model->all_membership();
        $this->data['membership_detail'] = $this->membership_model->get_membership_detail();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function create_membership() {
        $this->data['page'] = 'membership_form';
        $this->data['membership_detail'] = $this->membership_model->get_membership_detail();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function edit_membership($membership_id) {
        $this->data['page'] = 'membership_form';
        $this->data['membership_record'] = $this->membership_model->get_membership_record($membership_id);
        $this->data['membership_detail'] = $this->membership_model->get_membership_detail();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function save_membership(){

        if($this->input->post("membership_submit")){
            $id = $this->input->post('membership_id');

            if($id == '') {
                $data['title'] = $this->input->post('membership_title');
                $data['kind'] = $this->input->post('membership_kind');
                $data['level'] = $this->input->post('membership_level');

                $memberships = implode(',', $this->input->post('memberships'));

                $data['memberships'] = $memberships;

                if ($this->db->insert('memberships', $data)) {
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Successfully Added</div>";
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/membership');
            }
            else{
                $data['title'] = $this->input->post('membership_title');
                $data['kind'] = $this->input->post('membership_kind');
                $data['level'] = $this->input->post('membership_level');
                $memberships = implode(',', $this->input->post('memberships'));

                $data['memberships'] = $memberships;

                $this->db->where('id', $id);
                if($this->db->update('memberships', $data)){
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Successfully Updated</div>";
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/membership');
            }
        }
    }

    public function delete_membership()
    {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/membership');

        } else {
            $id = $this->input->post('tbl_id');
            $this->db->where('id', $id);
            if ($this->db->delete('memberships')) {
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Successfully Deleted.</div>";
                echo 1;
            }
            $this->session->set_flashdata('message', $message);
        }
    }

    public function multiple_delete()
    {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/membership');

        } else {
            $id = explode(',', $this->input->post('multi_Delete'));
            for ($i = 0; $i < count($id); $i++) {
                $this->db->where('id', $id[$i]);
                $result = $this->db->delete('memberships');
            }

            if ($result) {
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Successfully Deleted.</div>";
                echo 1;
            }
            $this->session->set_flashdata('message', $message);
            redirect(base_url() . 'admin/membership');
        }
    }

    public function membership_detail() {
        $this->data['page'] = 'membership_detail';
        $this->data['list'] = $this->membership_model->get_membership_detail_group();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function create_detail() {
        $this->data['page'] = 'detail_form';
        $this->data['membership_group'] = $this->membership_model->get_membership_group();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function edit_detail($detail_id) {
        $this->data['page'] = 'detail_form';
        $this->data['membership_group'] = $this->membership_model->get_membership_group();
        $this->data['detail_record'] = $this->membership_model->get_membership_detail_record($detail_id);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function save_membership_detail()
    {
        if($this->input->post("membership_detail_submit")){

            $id = $this->input->post('membership_detail_id');

            if($id == '') {
                $name = $this->input->post("membership_detail_title");
                $key = $this->input->post("membership_detail_key");
                $group = $this->input->post("membership_detail_group");

                if ($this->db->insert('membership_detail', array(
                    'name' => $name,
                    'key' => $key,
                    'group' =>  $group
                ))) {
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Key Successfully Generated</div>";
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/membership_detail');
            }
            else {
                $name = $this->input->post("membership_detail_title");
                $key = $this->input->post("membership_detail_key");
                $group = $this->input->post("membership_detail_group");

                $this->db->where('id', $id);
                $this->db->update('membership_detail', array(
                    'name' => $name,
                    'key' => $key,
                    'group' => $group
                ));
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Key Successfully Updated</div>";
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/membership_detail');
            }
        }

        redirect(base_url() . 'admin/membership');
    }

    public function delete_membership_detail() {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/membership_detail');

        } else {
            $id = $this->input->post('tbl_id');
            $this->db->where('id', $id);
            if ($this->db->delete('membership_detail')) {
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Detail Successfully Deleted.</div>";
                echo 1;
            }
            $this->session->set_flashdata('message', $message);
        }
    }

    public function multiple_delete_detail() {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/membership_detail');

        } else {
            $id = explode(',', $this->input->post('multi_Delete'));
            for ($i = 0; $i < count($id); $i++) {
                $this->db->where('id', $id[$i]);
                $result = $this->db->delete('membership_detail');
            }

            if ($result) {
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Successfully Deleted.</div>";
                echo 1;
            }
            $this->session->set_flashdata('message', $message);
            redirect(base_url() . 'admin/membership_detail');
        }
    }

    public function membership_group() {
        $this->data['page'] = 'membership_group';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function membershipgroupcheck()
    {
        $membership_group = $this->input->post('membership_group');

        $result = $this->membership_model->membershipgroupcheck($membership_group);
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            )
        );
    }

    public function save_membership_group()
    {
        if($this->input->post("membership_group_submit")){

            $name = $this->input->post("membership_group");

            $data = array(
                'name' => $name
            );

            if ($this->db->insert('membership_group', $data)) {
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Membership Key Successfully Generated</div>";
            }
            $this->session->set_flashdata('message', $message);
            redirect(base_url() . 'admin/membership_group');
        }

        redirect(base_url() . 'admin/membership_group');
    }
}

?>