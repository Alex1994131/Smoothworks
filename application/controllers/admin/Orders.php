<?php

class Orders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'orders';
        $this->load->model('admin_panel_model');

        $this->email_address = 'mail@example.com';
        $this->email_tittle = 'Gigs';
        $this->logo_front = base_url() . 'assets/images/logo.png';
        $this->site_name = 'gigs';

        $this->paytabs_email = '';
        $this->paytabs_secretkey = '';
        $paytabs_option = '';

        if ($paytabs_option == 1) {
            $this->paytabs_email = $this->db->select('sandbox_email')->get('paytabs_details')->row()->sandbox_email;
            $this->paytabs_secretkey = $this->db->select('sandbox_secretkey')->get('paytabs_details')->row()->sandbox_secretkey;
        }

        if ($paytabs_option == 2) {
            $this->paytabs_email = $this->db->select('email')->get('paytabs_details')->row()->email;
            $this->paytabs_secretkey = $this->db->select('secretkey')->get('paytabs_details')->row()->secretkey;
        }

        $this->load->helper('favourites');
        $result = gigs_settings();

        if (!empty($result)) {

            foreach ($result as $data) {
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
                if ($data['key'] == 'paytabs_option') {
                    $paytabs_option = $data['value'];
                }
            }
        }

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
    }

    public function index($start = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/orders/");
        $config['total_rows'] = $this->db->count_all('payments');
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
        $this->data['list'] = $this->admin_panel_model->get_allpayment_list($start, $config['per_page']);
        $this->data['links'] = $this->pagination->create_links();
        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function completed_orders($st = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/completed_orders/");
        $config['per_page'] = 15;
        $config['total_rows'] = $this->admin_panel_model->get_completepayment_list(0, $st, $config['per_page']);
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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'complete';
        $this->data['list'] = $this->admin_panel_model->get_completepayment_list(1, $st, $config['per_page']);
        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function pending_orders($st = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/pending_orders/");
        $config['per_page'] = 15;
        $config['total_rows'] = $this->admin_panel_model->get_Pendingpayment_list(0, $st, $config['per_page']);
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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'pending';
        $this->data['list'] = $this->admin_panel_model->get_Pendingpayment_list(1, $st, $config['per_page']);
        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function approve_payment() {
        $transaction_id = $this->input->post('transaction_id');

        $query = $this->db->query("select * from payments where id = $transaction_id");
        $result = $query->result_array();
        $result = $result[0];

        $remark = $result['remark'];
        $item_id = $result['item_id'];
        $price = $result['price'];
        $currency = $result['currency'];
        $user_id = $result['user_id'];
        $pay_method = $result['pay_method'];
        $status = $result['status'];
        
        if($remark == 'membership') {
            $membership_data = explode('-', $item_id);
            $membership_id = $membership_data[0];
            $membership_type = $membership_data[1];

            $flag = $this->update_membership($user_id, $membership_id, $membership_type, $price);
            if($flag == 'success') {
                $message_data = array();
                $query = $this->db->query("select * from administrators");
                $admin_info = $query->result_array();
                $admin_info = $admin_info[0];
                $admin_avatar = $admin_info['profile_thumb'];
                
                $update_data = array(
                    'status' => 3
                );

                $this->db->where('id', $transaction_id);
                $this->db->update('payments', $update_data);

                $this->load->model('membership_model');
                $membership_record = $this->membership_model->get_membership_record($membership_id);
                $membership_title = $membership_record['title'];

                if($membership_type == 1) {
                    $type="Monthly";
                }
                else if($membership_type == 2) {
                    $type = "Quarterly";
                }
                else if($membership_type == 3) {
                    $type = "Annually";
                }

                $message = 'Your Membership Updated. Your membership is ' . $membership_title . ' and type is ' . $type;

                $data = array(
                    'flag' => 'success',
                    'user_id' => $user_id,
                    'admin_avatar' => $admin_avatar,
                    'message' => $message
                );

                array_push($message_data, $data);
                echo json_encode($message_data);
            }
        }
        else if($remark == 'milestone') {
            if($status == 2) {
                $message_data = array();

                $query = $this->db->query("select * from administrators");
                $admin_info = $query->result_array();
                $admin_info = $admin_info[0];
    
                $admin_avatar = $admin_info['profile_thumb'];

                $update_data = array(
                    'status' => 3
                );
    
                $this->db->where('id', $transaction_id);
                $this->db->update('payments', $update_data);
    
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
    
                $fee = $price * ($escrow/100);
                $fee = round($fee);
    
                $real_price = $price - $fee;

                $project_id = $item_id;
                $query = $this->db->query("select * from projects where id = $project_id");
                $result = $query->result_array();
    
                $project_title = $result[0]['title'];
                $project_bid_id = $result[0]['award_bid'];
    
                $query = $this->db->query("select * from bids where id = $project_bid_id");
                $result = $query->result_array();
                $bid_user_id = $result[0]['user_id'];
                $bid_user_account = $result[0]['account_state'];

                if($bid_user_account == 2) {
                    $this->load->model('team_management_model');
                    $team_id = $this->team_management_model->get_teamID($bid_user_id);
                    $leader_id = $this->team_management_model->get_leaderinfo($team_id);   
                    $bid_user_id = $leader_id;
                }

                $recent_amount_qry = $this->db->query("select * from balances where user_id = $bid_user_id and currency_type = '" .$currency."'");
                $recent_amount = $recent_amount_qry->result_array();
                $recent_amount = $recent_amount[0];

                if($recent_amount == null) {
                    $real_amount = $real_price;
                    $insert_data = array(
                        'user_id' => $bid_user_id,
                        'currency_type' => $currency,
                        'amount' => $real_amount
                    );

                    $this->db->insert('balances', $insert_data);
                }
                else {
                    $real_amount = $recent_amount['amount'] + $real_price;
                    $balances_update = array(
                        'amount' => $real_amount
                    );
        
                    $this->db->where('user_id', $bid_user_id);
                    $this->db->where('currency_type', $currency);
                    $this->db->update('balances', $balances_update);                
                }

                $project_commission_data = array(
                    'user_id' => $bid_user_id,
                    'item_id' => $item_id,
                    'currency' => $currency,
                    'time_zone' => $this->session->userdata('time_zone'),
                    'price' => $real_amount,
                    'remark' => 'project commission',
                    'status' => 3,
                    'payment_method' => 'onsite',
                    'created_date' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s")
                );

                $this->db->insert('payments', $project_commission_data);

                $this->load->model('api_user_model');
                $user_record = $this->api_user_model->getUserRecord($bid_user_id);
                $buyer_name = $user_record[0]['fullname'];
                $affiliate_user_id = $user_record[0]['affiliate_user_id'];

                $commission_message = 'Milestone('. $project_title .') is Released. So '. $realamount.'('. $currency .') is added to your balances';
    
                $data = array(
                    'flag' => 'success',
                    'user_id' => $bid_user_id,
                    'admin_avatar' => $admin_avatar,
                    'message' => $commission_message
                );

                array_push($message_data, $data);

                //////////////// affiliate fee
                if($affiliate_user_id != 0) {
                    $rec = $this->api_user_model->getUserRecord($bid_user_id);
                    $membership_id = $rec['membership_id'];
                    $this->load->model('membership_model');
                    $membership_record = $this->membership_model->get_membership_record($membership_id);
        
                    $membership_content = $membership_record['memberships'];
                    $affiliate_fee = 0;

                    $membership_content = explode(',', $membership_content);
                    for($i=0; $i<count($membership_content); $i++) {
                        $membership_detail_id = $membership_content[$i];
                        $query = $this->db->query("select * from membership_detail where id = $membership_detail_id");
                        $membership_detail = $query->result_array();
                        $membership_detail = $membership_detail[0];
                        
                        if($membership_detail['group'] == 13) {
                            $affiliate_fee = $membership_detail['key'];
                        }
                    }

                    $affiliate_fee = $fee * ($affiliate_fee/100);

                    $affiliate_balances_query = $this->db->query("select * from balances where user_id = $affiliate_user_id and currency_type = 'USD'");
                    $affiliate_amount = $affiliate_balances_query->result_array();
                    $affiliate_amount = $affiliate_amount[0];

                    if($affiliate_amount == null) {
                        $affiliate_amount = $affiliate_fee;
                        $insert_data = array(
                            'user_id' => $affiliate_user_id,
                            'currency_type' => 'USD',
                            'amount' => $affiliate_amount
                        );
    
                        $this->db->insert('balances', $insert_data);
                    }
                    else {
                        $affiliate_amount = $affiliate_amount['amount'] + $affiliate_fee;
                        $affiliate_balances_update = array(
                            'amount' => $affiliate_amount
                        );
            
                        $this->db->where('user_id', $affiliate_user_id);
                        $this->db->where('currency_type', 'USD');
                        $this->db->update('balances', $affiliate_balances_update);                
                    }
                    
                    $affiliate_data = array(
                        'user_id' => $affiliate_user_id,
                        'item_id' => $item_id,
                        'currency' => 'USD',
                        'time_zone' => $this->session->userdata('time_zone'),
                        'price' => $affiliate_fee,
                        'remark' => 'affiliate fee',
                        'status' => '3',
                        'pay_method' => 'onsite',
                        'txn_id' => '',
                        'created_date' => date("Y-m-d H:i:s"),
                        'updated_date' => date("Y-m-d H:i:s")
                    );

                    $this->db->insert('payments', $affiliate_data);
                    
                    $affiliate_message = $buyer_name . 'who you invite complete project('. $project_title .'). so '. $affiliate_fee .'(USD) deposit to your balances';
                    $data = array(
                        'flag' => 'success',
                        'user_id' => $affiliate_user_id,
                        'admin_avatar' => $admin_avatar,
                        'message' => $affiliate_message
                    );

                    array_push($message_data, $data);
                }
    
                $message = 'Your Milestone is Released with $'. $price .'. Your Milestone('. $project_title .') is sent to' . $buyer_name;
                $data = array(
                    'flag' => 'success',
                    'user_id' => $user_id,
                    'admin_avatar' => $admin_avatar,
                    'message' => $message
                );

                array_push($message_data, $data);
                echo json_encode($message_data);
            }
            else {
                $message_data = array();
                $query = $this->db->query("select * from administrators");
                $admin_info = $query->result_array();
                $admin_info = $admin_info[0];
                $admin_avatar = $admin_info['profile_thumb'];
                
                $update_data = array(
                    'status' => -3
                );
    
                $this->db->where('id', $transaction_id);
                $this->db->update('payments', $update_data);
    
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
    
                $fee = $price * ($escrow/100);
                $fee = round($fee);
    
                $recent_amount_qry = $this->db->query("select * from balances where user_id = $user_id and currency_type = '" . $currency . "'");
                $recent_amount = $recent_amount_qry->result_array();
                $recent_amount = $recent_amount[0];
    
                $real_amount = $recent_amount['amount'] + $fee;
    
                $balances_update = array(
                    'amount' => $real_amount
                );
    
                $this->db->where('user_id', $user_id);
                $this->db->where('currency_type', $currency);
                $this->db->update('balances', $balances_update);

                $cancel_project_data = array(
                    'user_id' => $user_id,
                    'item_id' => $item_id,
                    'currency' => $currency,
                    'time_zone' => $this->session->userdata('time_zone'),
                    'price' => $real_amount,
                    'remark' => 'project cancel',
                    'status' => 3,
                    'payment_method' => 'onsite',
                    'created_date' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s")
                );

                $this->db->insert('payments', $cancel_project_data);
    
                $project_id = $item_id;
    
                $query = $this->db->query("select * from projects where id = $project_id");
                $result = $query->result_array();
    
                $project_title = $result[0]['title'];
                $project_bid_id = $result[0]['award_bid'];
    
                $query = $this->db->query("select * from bids where id = $project_bid_id");
                $result = $query->result_array();
                $bid_user_id = $result[0]['user_id'];
    
                $this->load->model('api_user_model');
                $user_record = $this->api_user_model->getUserRecord($bid_user_id);
                $buyer_name = $user_record[0]['fullname'];
    
                $this->db->where('id', $project_id);
                $this->db->delete('projects');

                $this->db->where('project_id', $project_id);
                $this->db->delete('projects_files');

                $this->db->where('project_id', $project_id);
                $this->db->delete('bids');
    
                $message = 'Your Milestone('. $project_title .') is Canceled with $'. $price .'. Your Project is not completed by' . $buyer_name;
                $data = array(
                    'flag' => 'success',
                    'user_id' => $user_id,
                    'admin_avatar' => $admin_avatar,
                    'message' => $message
                );

                array_push($message_data, $data);

                echo json_encode($message_data);
            }
        }
    }

    public function update_membership($user_id, $membership_id, $membership_type, $price) {
        $this->load->model('api_user_model');
        $record = $this->api_user_model->getUserRecord($user_id);
        $account_type = $record[0]['account_type'];
        
        $usd_balances = $this->api_user_model->get_my_usd_balances($user_id);

        $this->load->model('membership_model');
        $result = $this->membership_model->up_downgrade_membership($user_id, $membership_id, $membership_type, $account_type, $usd_balances);
        return $result;
    }
 
    public function cancel_orders($st = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/cancel_orders/");
        $config['per_page'] = 15;
        $config['total_rows'] = $this->admin_panel_model->get_cancelpayment_list(0, $st, $config['per_page']);

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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'cancel';
        $this->data['list'] = $this->admin_panel_model->get_cancelpayment_list(1, $st, $config['per_page']);
        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function decline_orders($st = 0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/decline_orders/");
        $config['per_page'] = 15;
        $config['total_rows'] = $this->admin_panel_model->get_declinepayment_list(0, $st, $config['per_page']);
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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'decline';
        $this->data['list'] = $this->admin_panel_model->get_declinepayment_list(1, $st, $config['per_page']);
        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function payment() {
        
        $transactioin_id = $this->input->post('transaction_id');
        $access_token = $this->input->post('access_token');

        $query = $this->db->query("select * from payments where id = $transaction_id");
        $result = $query->result_array();
        $result = $result[0];
        
        $this->buy($transactioin_id, $result, $access_token);
    }

    function buy($id, $data, $token)
    {
        $pay_method = $data['pay_method'];
        if($pay_method == 'paypal') {

            $this->load->model('api_user_model');
            $user_record = $this->api_user_model->getUserRecord($data['user_id']);
            $paypal_email = $user_record['paypal_email'];

            if(empty($paypal_email)) {
                $message = "User Paypal email non existing";
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/orders/pending_orders');
            }

            $returnURL = base_url() . 'admin/orders/paypal_success/';
            $cancelURL = base_url() . 'admin/orders/paypal_cancel';
            $notifyURL = base_url() . 'adminn/orders/ipn';

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
            $this->paypal_lib->add_field('business', $paypal_email);
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
        $table_data['status'] = 3;

        $this->db->where('id', $uid);
        $this->db->update('payments', $table_data);

        $query = $this->db->query("select * from payments where id = $uid");
        $result = $query->result_array();
        $user_id = $result[0]['user_id'];

        $this->db->where('user_id', $user_id);
        $this->db->delete('balances');

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
        //     $message = 'Membership Updated Successfully';
        //     $this->session->set_flashdata('message', $message);
        // }  
        // else {
        //     $message = 'Email Send Failure';
        //     $this->session->set_flashdata('error_message', $message);
        // }
        $message = 'Membership Updated Successfully';
        $this->session->set_flashdata('message', $message);
        redirect(base_url() . 'approve_success? transaction_id = ' . $uid);
    }

    function paypal_cancel()
    {
        redirect(base_url() . 'admin/orders/pending_orders');
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

                $this->db->update('payment', $data);
            }
        }
    }

    public function approve_success($transaction_id) {
        $query = $this->db->query("select * from payments where id = $transaction_id");

        $result = $query->result_array();
        $user_id = $result[0]['user_id'];
        $this->data['page'] = 'approve_success';
        $this->data['user_id'] = $user_id;

        $query = $this->db->query("select * from administrators");
        $admin_info = $query->result_array();
        $admin_info = $admin_info[0];

        $admin_avatar = $admin_info['profile_thumb'];

        $this->data['admin_avatar'] = $admin_avatar;
        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
}

?>