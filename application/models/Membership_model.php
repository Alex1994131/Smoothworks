<?php

class Membership_model extends CI_Model
{
    public function all_membership()
    {
        $query = $this->db->query("SELECT * FROM memberships");
        $result = $query->result_array();
        return $result;
    }

    public function get_membership_detail()
    {
        $query = $this->db->query('select * from membership_detail');
        $result = $query->result_array();
        return $result;
    }

    public function get_membership_detail_group()
    {
        $query = $this->db->query('select membership_detail.*, membership_group.name as group_name from membership_detail left join membership_group on membership_detail.`group` = membership_group.`id` order by membership_detail.`group`');
        $result = $query->result_array();
        return $result;
    }

    public function get_membership_record($membership_id) {
        $query = $this->db->query("select * from memberships where id = $membership_id");
        $result = $query->result_array();
        $result = $result[0];
        return $result;
    }

    public function get_membership_detail_record($detail_id) {
        $query = $this->db->query("select * from membership_detail where id = $detail_id");
        $result = $query->result_array();
        $result = $result[0];
        return $result;
    }

    public function get_membership_group() {
        $query = $this->db->query("select * from membership_group");
        $result = $query->result_array();
        return $result;
    }

    public function get_membershipFreelancer() {
        $query = "SELECT * FROM memberships WHERE kind=1 order by level asc";
        $query = $this->db->query($query);
        $result = $query->result_array();
        return $result;
    }

    public function get_membershipClient() {
        $query = "SELECT * FROM memberships WHERE kind=2 and level > 1 order by level asc";
        $query = $this->db->query($query);
        $result = $query->result_array();
        return $result;
    }

    public function get_membershipID($user_id) {
        $query = "select membership_id from members where USERID = $user_id";
        $query = $this->db->query($query);
        $result = $query->result_array();
        return $result[0]['membership_id'];
    }

    public function get_membershiplevel($membership_id) {
        $query = $this->db->query("select level from memberships where id = $membership_id");
        $result = $query->result_array();
        return $result[0]['level'];
    }

    public function membershipgroupcheck($name) {
        $query = $this->db->query("select * from membership_group where name = '$name'");
        $result = $query->num_rows();
        return $result;
    }

    public function up_downgrade_membership($user_id, $membership_id, $membership_type, $account_type, $price){
        if($account_type == 2) {
            $query = $this->db->query("select * from members where USERID = $user_id");
            $result = $query->result_array();
            $my_membership_id = $result[0]['membership_id'];

            $query = $this->db->query("select * from memberships where id <> $my_membership_id and kind = $account_type");
            $result = $query->result_array();
            $membership_id = $result[0]['id'];

            if($membership_level == 1) {
                $membership_date = date_create(date("Y-m-d"));
                date_add($membership_date, date_interval_create_from_date_string("30 days"));
                $membership_date = date_format($membership_date, "Y-m-d");

                $update_balances_data = array(
                    'amount' => $price
                );

                $this->db->where('user_id', $user_id);
                $this->db->where('currency_type', 'USD');
                $this->db->update('balances', $update_balances_data);
                
                $update_data = array(
                    'membership_id' => $membership_id,
                    'membership_type' => 1,
                    'membership_date' => $membership_date,
                    'membership_item_date' => $membership_date,
                    'general_bid' => 0,
                    'special_bid' => 0,
                    'ongoing_project' => 1,
                    'service' => 0,
                    'newsletter' => 0,
                    'withdrawl_count' => 1,
                    'withdrawl_date' => date('Y-m-d')
                );

                $this->db->where('USERID', $user_id);
                $this->db->update('members', $update_data);
                return 'success';
            }
            else {
                $membership_date = date_create(date("Y-m-d"));

                if($membership_type == 1) {
                    date_add($membership_date, date_interval_create_from_date_string("30 days"));
                }
                else if($membership_type == 2) {
                    date_add($membership_date, date_interval_create_from_date_string("90 days"));
                }
                else if($membership_type == 3) {
                    date_add($membership_date, date_interval_create_from_date_string("365 days"));
                }

                $membership_item_date = date_create(date("Y-m-d"));
                date_add($membership_item_date, date_interval_create_from_date_string("30 days"));

                $membership_date = date_format($membership_date, "Y-m-d");

                $withdrawal = 0;
                $ongoing_project = 0;

                $membership_data = $this->get_membership_record($membership_id);
                $membership_content = $membership_data['memberships'];
                $membership_content = explode(',', $membership_content);
                for($i=0; $i<count($membership_content); $i++) {
                    $membership_detail = $this->get_membership_detail_record($membership_content[$i]);
                    if($membership_detail['group'] == 6) {
                        $ongoing_project = $membership_detail['key'];
                    }
                    else if($membership_detail['group'] == 12) {
                        $withdrawal = $membership_detail['key'];
                    }
                }

                $update_balances_data = array(
                    'amount' => $price
                );

                $this->db->where('user_id', $user_id);
                $this->db->where('currency_type', 'USD');
                $this->db->update('balances', $update_balances_data);

                $update_data = array(
                    'membership_id' => $membership_id,
                    'membership_type' => $membership_type,
                    'membership_date' => $membership_date,
                    'membership_item_date' => $membership_item_date,
                    'general_bid' => 0,
                    'special_bid' => 0,
                    'ongoing_project' => $ongoing_project,
                    'service' => 0,
                    'newsletter' => 0,
                    'withdrawl_count' => $withdrawal,
                    'withdrawl_date' => date('Y-m-d')
                );

                $this->db->where('USERID', $user_id);
                $this->db->update('members', $update_data);
                return 'success';
            }
        }
        else {
            $query = $this->db->query("select * from memberships where id=$membership_id");
            $result_membership = $query->result_array();
            $membership_level = $result_membership[0]['level'];

            $query = $this->db->query('select * from teams where leader_id = '.$user_id);
            $result = $query->result_array();

            if($membership_level == 1) {
                if(count($result) > 0) {
                    $this->db->where('leader_id', $user_id);
                    $this->db->delete('teams');
                }
                $team_id = 0;
            }
            else {
                if(empty($result)) {
                    $insert_data = array(
                        'leader_id' => $user_id
                    );
                    $this->db->insert('teams', $insert_data);
                    $team_id = $this->db->insert_id();
                }
                else {
                    $team_id = $result[0]['id'];
                }
            }

            $membership_date = date_create(date("Y-m-d"));

            if($membership_type == 1) {
                date_add($membership_date, date_interval_create_from_date_string("30 days"));
            }
            else if($membership_type == 2) {
                date_add($membership_date, date_interval_create_from_date_string("90 days"));
            }
            else if($membership_type == 3) {
                date_add($membership_date, date_interval_create_from_date_string("365 days"));
            }

            $membership_item_date = date_create(date("Y-m-d"));
            date_add($membership_item_date, date_interval_create_from_date_string("30 days"));

            $membership_date = date_format($membership_date, "Y-m-d");
            $membership_item_date = date_format($membership_item_date, "Y-m-d");

            $general_bid = 0;
            $special_bid = 0;
            $ongoing_project = 0;
            $service = 0;
            $withdrawal = 0;
            $newsletter = 0;

            $membership_data = $this->get_membership_record($membership_id);
            $membership_content = $membership_data['memberships'];
            $membership_content = explode(',', $membership_content);
            for($i=0; $i<count($membership_content); $i++) {
                $membership_detail = $this->get_membership_detail_record($membership_content[$i]);
                if($membership_detail['group'] == 7) {
                    $general_bid = $membership_detail['key'];
                }
                else if($membership_detail['group'] == 8) {
                    $special_bid = $membership_detail['key'];
                }
                else if($membership_detail['group'] == 6) {
                    $ongoing_project = $membership_detail['key'];
                }
                else if($membership_detail['group'] == 9) {
                    $service = $membership_detail['key'];

                    $this->load->model('api_user_model');
                    $user_record = $this->api_user_model->getUserRecord($user_id);
                    $origin_team_id = $user_record['team_id'];

                    $query = $this->db->query("select * from members where team_id = $origin_team_id");
                    $result = $query->result_array();

                    $team_persons = count($result);

                    $additional_service = round($team_persons / 3);
                    $service += $additional_service;
                }
                else if($membership_detail['group'] == 21) {
                    $newsletter = $membership_detail['key'];
                }
                else if($membership_detail['group'] == 12) {
                    $withdrawal = $membership_detail['key'];
                }
            }

            $price = number_format($price, 2);

            $update_balances_data = array(
                'amount' => $price
            );

            $this->db->where('user_id', $user_id);
            $this->db->where('currency_type', 'USD');
            $this->db->update('balances', $update_balances_data);

            $update_data = array(
                'team_id' => $team_id,
                'membership_id' => $membership_id,
                'membership_type' => $membership_type,
                'membership_date' => $membership_date,
                'membership_item_date' => $membership_item_date,
                'general_bid' => $general_bid,
                'special_bid' => $special_bid,
                'ongoing_project' => $ongoing_project,
                'service' => $service,
                'newsletter' => $newsletter,
                'withdrawl_count' => $withdrawal,
                'withdrawl_date' => date('Y-m-d')
            );

            $this->db->where('USERID', $user_id);
            $this->db->update('members', $update_data);
            return 'success';
        }
    }
}

?>