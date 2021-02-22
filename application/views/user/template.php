<?php


if ($this->session->userdata('SESSION_USER_ID')) {

    $unique_code = $this->session->userdata('unique_code');
    $this->db->where('unique_code', $unique_code);
    $is_valid = $this->db->count_all_results('members');
    if ($is_valid == 0) {
        redirect(base_url() . 'logout');
    }

    $actionpage = $this->uri->segment(1);
    if ($this->session->userdata('user_role') == 1 && $actionpage != 'gig-preview') {
        redirect(base_url() . 'admin');
    }
    $this->load->view($theme . '/includes/header');
    $this->load->view($theme . '/modules/' . $module . '/' . $page);
    $this->load->view($theme . '/includes/footer');

} else {
    $this->load->view($theme . '/includes/header');
    if ($module == "buy_gigs" || $module == "buy_project" || $module == "search" || $module == "user_profile" || $module == "terms" || $module == "forget_password" || $module == "pages" || $module == "affiliate_user") {
        $this->load->view($theme . '/modules/' . $module . '/' . $page);
    }
    else {
        $this->load->view('user/modules/welcome/index');
    }

    $this->load->view($theme . '/includes/footer');
}
?>