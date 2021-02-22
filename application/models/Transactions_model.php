<?php

class Transactions_model extends CI_Model
{
    public function get_all_transaction_data($user_id, $from_date, $to_date, $status, $currency)
    {
        $search_sql = "";
        if (isset($from_date) && $from_date != '') {
            $fromdate = date('Y-m-d', strtotime($from_date));
            $search_sql .= "AND date(created_date) >= '" . $fromdate . "' ";
        }
        if (isset($todate) && $todate != '') {
            $todate = date('Y-m-d', strtotime($to_date));
            $search_sql .= "AND date(created_date) <= '" . $todate . "' ";
        }

        if (isset($status) && $status != '') {
            $search_sql .= "AND type= '" . $status . "' ";
        }

        if(isset($currency) && $currency != '') {
            $search_sql .= "AND currency = '" . $currency . "' ";
        }

        $query = $this->db->query("
            SELECT 
            payments.*,
            projects.title,
            members.fullname,
            members.username
			FROM `payments`
	        LEFT JOIN projects ON projects.id = payments.item_id
	        LEFT JOIN members ON members.USERID = payments.user_id
			WHERE payments.`user_id` = $user_id " . $search_sql . " ORDER BY payments.`created_date` DESC");

        $result = $query->result_array();
        return $result;
    }

    ////////////
    public function get_user_orders_count($id)
    {
        $data = 0;
        $query = $this->db->query("SELECT id FROM `payments` WHERE `user_id` = $id");
        $num_of_rows = $query->num_rows();
        if ($num_of_rows > 0) {
            $data = $query->num_rows();
        }
        return $data;
    }

    public function get_selluser_orders_count($id)
    {
        $data = 0;
        $query = $this->db->query("SELECT id FROM `payments` WHERE `seller_id` = $id");
        $num_of_rows = $query->num_rows();
        if ($num_of_rows > 0) {
            $data = $query->num_rows();
        }
        return $data;
    }

    public function get_wallets_orders_count($id)
    {
        $data = 0;
        $query = $this->db->query("SELECT id FROM `payments` WHERE `seller_id` = $id AND seller_status=6");
        $num_of_rows = $query->num_rows();
        if ($num_of_rows > 0) {
            $data = $query->num_rows();
        }
        return $data;
    }

    public function get_selluser_details($id, $type, $start, $end)
    {
        $append_sql = '';
        if ($type == 1) {
            $append_sql = " LIMIT $start , $end ";
        }

        $search_sql = '';

        if ($this->input->post('form_submit')) {
            $search_sql = "";

            if (isset($_POST["fromdate"]) && !empty($_POST["fromdate"])) {
                $fromdate = date('Y-m-d', strtotime($_POST["fromdate"]));

                $search_sql .= "AND date(created_at) >= '" . $fromdate . "' ";
            }

            if (isset($_POST["todate"]) && !empty($_POST["todate"])) {
                $todate = date('Y-m-d', strtotime($_POST["todate"]));

                $search_sql .= "AND date(created_at) <= '" . $todate . "' ";
            }

            if (isset($_POST["orderstatus"]) && !empty($_POST["orderstatus"])) {
                $search_sql .= "AND seller_status= '" . $_POST["orderstatus"] . "' ";
            }

        }


        $query = $this->db->query("
            SELECT 
            py.*,
            sg.title,
            sg.delivering_time,
            sg.user_id,
            m.fullname,
            m.username,
			(SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id
	        LEFT JOIN members as m ON m.USERID = sg.user_id
			WHERE py.`seller_id` = $id " . $search_sql . " ORDER BY py.`created_at` DESC " . $append_sql);
        if ($type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function getuser_wallets_details($id, $type, $start, $end)
    {
        //$data =array();
        $append_sql = '';
        if ($type == 1) {
            $append_sql = " LIMIT $start , $end ";
        }
        $search_sql = '';

        if ($this->input->post('form_submit')) {
            $search_sql = "";

            if (isset($_POST["fromdate"]) && !empty($_POST["fromdate"])) {
                $fromdate = date('Y-m-d', strtotime($_POST["fromdate"]));

                $search_sql .= "AND date(created_at) >= '" . $fromdate . "' ";
            }

            if (isset($_POST["todate"]) && !empty($_POST["todate"])) {
                $todate = date('Y-m-d', strtotime($_POST["todate"]));

                $search_sql .= "AND date(created_at) <= '" . $todate . "' ";
            }

            if (isset($_POST["orderstatus"]) && !empty($_POST["orderstatus"])) {
                $search_sql .= "AND payment_status= '" . $_POST["orderstatus"] . "' ";
            }
        }

        $query = $this->db->query("
            SELECT 
            py.*,
            sg.title,
            sg.user_id,
            m.fullname,
            m.username, 
			(SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
	        LEFT JOIN members as m ON m.USERID = sg.user_id
			WHERE py.`seller_id` = '".$id."' AND seller_status=6  " . $search_sql . "  ORDER BY py.`created_at` DESC " . $append_sql . " ");
        if ($type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_payment_details($id)
    {
        $data = array();
        $query = $this->db->query("
            SELECT 
            py.*,
            sg.title, 
            sg.user_id
            sg.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.super_fast_delivery_date, gi.image_path,gi.gig_image_thumb,m.fullname,m.username,m.user_thumb_image,cu.country,cu.sortname FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.seller_id
			LEFT JOIN country as cu ON cu.id = m.country
			WHERE py.`id` = $id");
        $num_of_rows = $query->num_rows();
        if ($num_of_rows > 0) {
            $data = $query->row_array();
        }
        return $data;
    }

    public function get_salespayment_details($id)
    {
        $data = array();
        $query = $this->db->query("
            SELECT 
            py.*,
            sg.title,
            sg.user_id
            sg.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.super_fast_delivery_date,gi.image_path,gi.gig_image_thumb,m.fullname,m.username,m.user_thumb_image,cu.country,cu.sortname FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.USERID
			LEFT JOIN country as cu ON cu.id = m.country
			WHERE py.`id` = $id");
        $num_of_rows = $query->num_rows();
        if ($num_of_rows > 0) {
            $data = $query->row_array();
        }
        return $data;
    }
}

?>