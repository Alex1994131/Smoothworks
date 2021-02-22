<?php

class Team_management_model extends CI_Model
{
    public function get_teamID($user_id)
    {
        $query = $this->db->query("SELECT * FROM `members` WHERE `USERID` = '". $user_id ."' AND `status` = 0 LIMIT 0, 1;");
        $result = $query->result_array();
        $team_id = $result[0]['team_id'];
        return $team_id;
    }


    public function get_team_persons($team_id){
        $query = "SELECT * FROM members WHERE team_id = '". $team_id ."' AND status = 0 AND account_type = 1";
        $query = $this->db->query($query);
        $result = $query->result_array();
        return $result;
    }

    public function get_developers($team_id){
        $query = "SELECT * FROM members WHERE status = 0 AND account_type = 1 AND team_id <> $team_id";
        $query = $this->db->query($query);
        $result = $query->result_array();
        return $result;
    }

    public function get_inviteteamID($user_id)
    {
        $query = $this->db->query("SELECT * FROM `members` WHERE `USERID` = '". $user_id ."' AND `status` = 0 LIMIT 0, 1;");
        $result = $query->result_array();
        $team_id = $result[0]['invite_team_id'];
        return $team_id;
    }

    public function get_leaderinfo($team_id){
        $query = $this->db->query("select leader_id from teams where id = $team_id");
        $query_result = $query->result_array();
        $leader_id = $query_result[0]['leader_id'];
        return $leader_id;
    }

    public function accept_ok($user_id, $flag){
        if($flag == 'exit-101' || $flag == 'exit-102') {
            $data = array(
                'team_id' => 0
            );

            $this->db->where('USERID', $user_id);
            if($this->db->update('members', $data)){
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            
            $query = "select id from teams where leader_id = ". $user_id;
            $query = $this->db->query($query);
            $result = $query->result_array();

            $team_id = $result[0]['id'];

            $data = array(
                'team_id' => $team_id
            );

            $session_user_id = $this->session->userdata('SESSION_USER_ID');
            $this->db->where('USERID', $session_user_id);
            if($this->db->update('members', $data)){
                return 1;
            }
            else {
                return 0;
            }
        }
    }
}
?>