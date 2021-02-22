<?php

class admin_panel_model extends CI_Model
{
    public function get_updates()
    {
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => 'https://www.dreamguys.co.in/gigs_updates/',
            CURLOPT_RETURNTRANSFER => true
        );

        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            $options[CURLOPT_FOLLOWLOCATION] = true;
        }
        curl_setopt_array($ch, $options);
        $output = curl_exec($ch);
        curl_close($ch);

        $updates = json_decode($output, TRUE);

        $where = array('build' => $updates['build']);
        $check_updates = $this->db->get_where('version_updates', $where)->num_rows();
        if ($check_updates != 0) {
            $this->session->set_userdata(array('updates' => 1));
        }
    }

    public function terms()
    {
        $query = $this->db->query(" SELECT * FROM `terms` WHERE `status` = 1");
        $result = $query->row_array();
        return $result;
    }

    public function get_terms()
    {
        $query = $this->db->query("SELECT * FROM `terms`");
        $result = $query->result_array();
        return $result;
    }

    public function edit_terms($id)
    {
        $query = $this->db->query("SELECT * FROM  terms WHERE id= $id ");
        $result = $query->result_array();
        return $result;
    }

    public function footercount()
    {
        $query = $this->db->query("SELECT id FROM  `footer_menu` WHERE STATUS =1");
        $result = $query->num_rows();
        return $result;
    }

    public function catagorycheck($category_name, $catagory_id)
    {
        $join = '';
        if ($catagory_id != '') {
            $join = "AND CATID != '" . $catagory_id . "'";
        }
        $query = $this->db->query("SELECT * FROM `categories` WHERE `name` ='" . $category_name . "' " . $join);

        $result = $query->num_rows();
        return $result;
    }

    public function admin_commision()
    {
        $query = $this->db->query(" SELECT `value` FROM `system_settings` WHERE `key` = 'admin_commision' ");
        $result = $query->row_array();
        return $result;
    }

    public function delete_seo_setting($seo_id)
    {
        $query = $this->db->query("DELETE FROM seo_details WHERE id	='" . $seo_id . "'");
        $result = 1;
        return $result;
    }

    public function gig_price()
    {
        $query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'gig_price' ");
        $result = $query->row_array();
        return $result;
    }

    public function get_rupee_dollar_rate()
    {
        $query = $this->db->query(" SELECT * FROM `currency` ORDER BY `created_date` DESC LIMIT 0 , 1  ;");
        $result = $query->row_array();
        return $result;
    }

    public function all_gigs($return_type, $start, $end)
    {
        $append_sql = "";
        if ($start > 0 || $end > 0) {
            $append_sql = " LIMIT $start , $end";
        }
        $query = $this->db->query("SELECT sell_gigs.id as gig_id , ( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image`   
		 WHERE gigs_image.gig_id = sell_gigs.id   LIMIT 0 , 1  ) AS gig_image ,  sell_gigs.`title`,  sell_gigs.`currency_type` , members.fullname , members.username , categories.name as         category_name , sell_gigs.`gig_price` , sell_gigs.`status`, sell_gigs.`created_date`  FROM `sell_gigs` 
    	INNER JOIN members ON members.USERID = sell_gigs.user_id 
		INNER JOIN categories ON categories.CATID = sell_gigs.category_id ORDER BY sell_gigs.`created_date` DESC " . $append_sql . " ");
        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();


        }
        return $result;
    }

    public function all_projects($return_type, $start, $end)
    {
        $append_sql = "";
        if ($start > 0 || $end > 0) {
            $append_sql = " LIMIT $start , $end";
        }
        $query = $this->db->query("SELECT projects.delivering_time as project_day, projects.project_details as project_details, projects.id as project_id ,  projects.`title`,  projects.`currency_type` , members.fullname , members.username , categories.name as category_name, projects.`project_price` , projects.`created_date`, GROUP_CONCAT( projects_files.file_path SEPARATOR '#') as file_paths
        FROM `projects` 
    	INNER JOIN members ON members.USERID = projects.user_id
        LEFT JOIN projects_files ON projects_files.project_id = projects.id
		INNER JOIN categories ON categories.CATID = projects.category_id GROUP BY projects.id  ORDER BY projects.`created_date` DESC " . $append_sql . " ");
        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function all_affiliate($return_type, $start, $end)
    {
        $append_sql = "";
        if ($start > 0 || $end > 0) {
            $append_sql = " LIMIT $start , $end";
        }

        $query = $this->db->query("SELECT 
                    a.* , a.id as transaction_id, p.title as project_title, s.fullname as buyer_name, s.user_thumb_image as buyerimage, c.currency_sign 
                    FROM  `payments`as a
                    LEFT JOIN members as s ON s.USERID = a.user_id
                    LEFT JOIN projects as p ON p.id = a.item_id
                    LEFT JOIN currencies as c ON c.currency = a.currency
                    where a.status = 3 and a.remark = 'affiliate fee' " . $append_sql);

        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function all_membership($return_type, $start, $end)
    {
        $append_sql = "";
        if ($start > 0 || $end > 0) {
            $append_sql = " LIMIT $start , $end";
        }

        $query = $this->db->query("SELECT 
                    a.* , a.id as transaction_id, g.title as membership_title, s.fullname as buyer_name, s.user_thumb_image as buyerimage, c.currency_sign 
                    FROM  `payments`as a
                    LEFT JOIN members as s ON s.USERID = a.user_id
                    LEFT JOIN memberships as g ON g.id = a.item_id
                    LEFT JOIN currencies as c ON c.currency = a.currency
                    where a.status = 3 and a.remark = 'membership' " . $append_sql);

        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function all_commission($return_type, $start, $end)
    {
        $append_sql = "";
        if ($start > 0 || $end > 0) {
            $append_sql = " LIMIT $start , $end";
        }

        $query = $this->db->query("SELECT 
                    a.* , a.id as transaction_id, p.title as project_title, s.fullname as buyer_name, s.user_thumb_image as buyerimage, c.currency_sign 
                    FROM  `payments`as a
                    LEFT JOIN members as s ON s.USERID = a.user_id
                    LEFT JOIN projects as p ON p.id = a.item_id
                    LEFT JOIN currencies as c ON c.currency = a.currency
                    where a.status = 3 and ( a.remark = 'project fee' or a.remark = 'milestone' ) " . $append_sql);

        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function copy_right_year()
    {
        $query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'copy_rit_year';");
        $result = $query->row_array();
        return $result;

    }

    public function dashboard_details()
    {
        $query = $this->db->query("SELECT * FROM ((SELECT COUNT( * ) AS total_gigs FROM  `sell_gigs`) AS total_gigs, 
		(SELECT COUNT( * ) AS total_user FROM  `members`) AS total_user, 
		(SELECT COUNT( * ) AS total_orders FROM  `payments`) AS total_orders , 
		(SELECT COUNT( * ) AS completed_orders FROM  `payments` WHERE  `status` = 2) AS completed_orders)");
        $result = $query->row_array();
        return $result;
    }

    public function dashboard_recent_gigs()
    {
        $query = $this->db->query("	SELECT gigs_image.`gig_image_thumb`, payments.txn_id, payments.price, payments.currency, payments.created_date
									FROM  `gigs_image` 
									INNER JOIN payments ON payments.item_id = gigs_image.`gig_id`
                                    WHERE remark = 'gigs'
                                    GROUP BY  payments.id
									ORDER BY payments.created_date DESC 
									LIMIT 0 , 6 ");
        $result = $query->result_array();
        return $result;
    }

    public function dashboard_popular_gigs()
    {
        $query = $this->db->query("SELECT sell_gigs.`title`, sell_gigs.`gig_price`,sell_gigs.currency_type,sell_gigs.`created_date`,sell_gigs.`total_views`,
        (SELECT gig_image_thumb FROM `gigs_image` WHERE `gig_id` = sell_gigs.id LIMIT 0 , 1 ) AS gig_image FROM `sell_gigs` ORDER BY `total_views` DESC  LIMIT 0 , 6  ");
        $result = $query->result_array();
        return $result;
    }


    public function get_policy_settings($start, $end)
    {
        $query = $this->db->query("SELECT * FROM  `policy_settings` LIMIT $start , $end  ");
        $result = $query->result_array();
        return $result;
    }

    public function get_seo_settings($start, $end)
    {
        $query = $this->db->query("SELECT * FROM `seo_details` LIMIT $start , $end  ");
        $result = $query->result_array();
        return $result;
    }

    public function edit_seo_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `seo_details` WHERE id = $id");
        $result = $query->row_array();
        return $result;
    }

    public function edit_paypal_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `paypal_details` WHERE id = $id");
        $result = $query->row_array();
        return $result;
    }

    public function edit_policy_settings($id)
    {
        $query = $this->db->query("SELECT * FROM  `policy_settings` WHERE `id` = $id ");
        $result = $query->row_array();
        return $result;
    }

    public function edit_client_list($client_id)
    {
        $query = $this->db->query("SELECT * FROM `client` WHERE `id` = '" . $client_id . "' ; ");
        $result = $query->row_array();
        return $result;
    }

    public function all_category()
    {
        $query = $this->db->query("SELECT c.*,(c2.`CATID`) as parent_id,(c2.name) as parent_name FROM categories c  
LEFT join `categories` as c2 ON c2.CATID = c.parent where c.delete_sts =0 ");
        $result = $query->result_array();
        return $result;
    }

    public function categories()
    {
        $query = $this->db->query(" SELECT * FROM `categories` WHERE `status` = 0 ");
        $result = $query->result_array();
        return $result;
    }

    public function edit_category($category_id)
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `CATID` = '" . $category_id . "' ; ");
        $result = $query->row_array();
        return $result;
    }

    public function parent_category()
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `parent` = 0 AND `status` = 0 ");
        $result = $query->result_array();
        return $result;
    }

    public function all_sub_category()
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `status` = 0");
        $result = $query->result_array();
        return $result;
    }

    public function get_setting_list()
    {
        $data = array();
        $stmt = "SELECT a.*"
            . " FROM system_settings AS a"
            . " ORDER BY a.`id` ASC";
        $query = $this->db->query($stmt);
        if ($query->num_rows()) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function get_static_page($end, $start)
    {
        $query = $this->db->query("SELECT * FROM  `page` LIMIT $start , $end");
        $result = $query->result_array();
        return $result;
    }

    public function edit_static_page($id)
    {
        $query = $this->db->query("SELECT * FROM  `page` WHERE page_id = $id ");
        $result = $query->result_array();
        return $result;
    }

    public function site_name()
    {
        $query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'website_name';");
        $result = $query->row_array();
        return $result;
    }

    public function check_ip($ip_address)
    {
        $query = $this->db->query("SELECT * FROM `bans_ips` WHERE `ip_addr` = '$ip_address';");
        $result = $query->num_rows();
        return $result;
    }

    public function is_valid_menu_name($menu_name)
    {
        $query = $this->db->query("SELECT * FROM `footer_menu` WHERE `title` =  '$menu_name';");
        $result = $query->num_rows();
        return $result;
    }

    public function is_valid_submenu($menu_name)
    {
        $query = $this->db->query("SELECT * FROM `footer_submenu` WHERE `title` =  '$menu_name';");
        $result = $query->num_rows();
        return $result;
    }

    public function edit_footer_menu($id)
    {
        $query = $this->db->query("SELECT * FROM `footer_menu` WHERE `id` =  $id;");
        $result = $query->result_array();
        return $result;
    }

    public function edit_ip($ip_address)
    {
        $query = $this->db->query("SELECT * FROM `bans_ips` WHERE `id` = '$ip_address';");
        $result = $query->row_array();
        return $result;
    }

    public function get_all_request()
    {
        $query = $this->db->query("
            SELECT req.*,members.fullname,(categories.name) AS main_category,sub_cat.name as sub_category FROM `request` as req
	    LEFT JOIN members ON members.USERID = req.posted_by	  
            LEFT JOIN categories ON categories.CATID = req.`main_cat`
            LEFT JOIN categories as sub_cat ON sub_cat.CATID = req.`sub_cat`;");
        $result = $query->result_array();
        return $result;
    }

    public function get_user()
    {
        $query = $this->db->query("SELECT `USERID`,`email`,`username`,`fullname`,`verified`,`status` FROM `members`  ;");
        $result = $query->result_array();
        return $result;
    }

    public function edit_user($id)
    {
        $query = $this->db->query("SELECT `USERID`,`email`,`username`,`fullname`,`verified`,`status` FROM `members`  WHERE `USERID` = $id ;");
        $result = $query->row_array();
        return $result;
    }

    public function get_review($start, $end)
    {
        $last_append = '';
        if ($start || $end != 0) {
            $last_append = " LIMIT $start , $end";
        }

        $query = $this->db->query("SELECT  feedback.*,members.fullname,sell_gigs.title FROM `feedback`
                                    INNER JOIN members ON members.USERID = feedback.`from_user_id`
                                    INNER JOIN sell_gigs ON sell_gigs.id = feedback.`gig_id`
									ORDER BY feedback.id DESC " . $last_append . " ");
        $result = $query->result_array();
        return $result;
    }

    public function edit_review($id)
    {
        $query = $this->db->query("SELECT gigs_reviews.review_id,gigs_reviews.`review`,members.fullname,gigs.gig_title,gigs_reviews.`created_date`,gigs_reviews.`status` FROM `gigs_reviews`
                                    INNER JOIN members ON members.USERID = gigs_reviews.`user_id`
                                    INNER JOIN gigs ON gigs.id = gigs_reviews.`gig_id`
                                    WHERE gigs_reviews.`review_id` = $id ");
        $result = $query->row_array();
        return $result;
    }

    public function get_admin_profile($id)
    {
        $query = $this->db->query("SELECT * FROM `administrators` WHERE `ADMINID` = $id");
        $result = $query->row_array();
        return $result;
    }

    public function get_client_list()
    {
        $query = $this->db->query("SELECT * FROM  `client` ");
        $result = $query->result_array();
        return $result;
    }

    public function get_footer_menu($end, $start)
    {
        $query = $this->db->query("SELECT * FROM  `footer_menu` LIMIT $start , $end ");
        $result = $query->result_array();
        return $result;
    }

    public function get_footer_submenu($end, $start)
    {
        $query = $this->db->query("SELECT footer_submenu.*,footer_menu.title FROM `footer_submenu`
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu`
                                    LIMIT $start , $end ");
        $result = $query->result_array();
        return $result;
    }

    public function get_all_footer_menu()
    {
        $query = $this->db->query("SELECT * FROM  `footer_menu` ");
        $result = $query->result_array();
        return $result;
    }

    public function get_all_footer_submenu()
    {
        $query = $this->db->query("SELECT footer_submenu.*,footer_menu.title FROM `footer_submenu`
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu` ");
        $result = $query->num_rows();
        return $result;
    }

    public function edit_submenu($id)
    {
        $query = $this->db->query("SELECT footer_submenu . * , footer_menu.title
                                    FROM  `footer_submenu` 
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu` 
                                    WHERE footer_submenu.id = $id ");
        $result = $query->result_array();
        return $result;
    }

    public function new_notification()
    {
        $query = $this->db->query("SELECT a.*  
                        FROM  `payments`as a
                        where ((a.status = 1 and (a.remark = 'membership' or a.remark = 'withdraw' or a.remark = 'deposit')) OR (a.remark = 'milestone' and (a.status = 2 or a.status = -1)))
                        ORDER BY a.created_date desc");

        $result = $query->result_array();
        return $result;
    }

    ////////////////// new
    public function get_allpayment_list($start, $end)
    {
        $last_append = '';
        if ($start || $end != 0) {
            $last_append = " LIMIT $start , $end";
        }

        $query = $this->db->query("SELECT a.* , a.id as transaction_id, g.title as membership_title, p.title as project_title, s.fullname as buyer_name, s.user_thumb_image as buyerimage, c.currency_sign
                FROM  `payments`as a
                LEFT JOIN members as s ON s.USERID = a.user_id	
                LEFT JOIN memberships as g ON g.id = a.item_id
                LEFT JOIN projects as p ON p.id = a.item_id
                LEFT JOIN currencies as c ON c.currency = a.currency
                group by a.id " . $last_append);
                                     
        $result = $query->result_array();
        return $result;
    }

    ////////////////////////////// new
    public function get_completepayment_list($type, $start, $end)
    {
        $last_append = '';
        if ($type == 1) {
            $last_append = "LIMIT $start , $end";
        }
        
        $query = $this->db->query("SELECT 
                a.* , a.id as transaction_id, g.title as membership_title, p.title as project_title, s.fullname as buyer_name, s.user_thumb_image as buyerimage, c.currency_sign
                FROM  `payments`as a
                LEFT JOIN members as s ON s.USERID = a.user_id	
                LEFT JOIN memberships as g ON g.id = a.item_id
                LEFT JOIN projects as p ON p.id = a.item_id
                LEFT JOIN currencies as c ON c.currency = a.currency
                where a.status = 3 " . $last_append);

        if ($type == 0) {
            $result = $query->num_rows();
        } else {

            $result = $query->result_array();
        }


        return $result;
    }

    ////////////////// new
    public function get_Pendingpayment_list($type, $start, $end)
    {
        $last_append = '';
        if ($type == 1) {
            $last_append = " LIMIT $start , $end";
        }
        
        $query = $this->db->query("SELECT 
                        a.* , a.id as transaction_id, g.title as gigs_title, p.title as project_title, s.fullname as buyer_name, s.user_thumb_image as buyerimage, c.currency_sign
                        FROM  `payments`as a
                        LEFT JOIN members as s ON s.USERID = a.user_id	
                        LEFT JOIN memberships as g ON g.id = a.item_id
                        LEFT JOIN projects as p ON p.id = a.item_id
                        LEFT JOIN currencies as c ON c.currency = a.currency
                        where ((a.status = 1 and (a.remark = 'membership' or a.remark = 'withdraw' or a.remark = 'deposit')) OR (a.remark = 'milestone' and (a.status = 2 or a.status = -1))) " . $last_append);

        if ($type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    /////////////////////// new
    public function get_declinepayment_list($type, $start, $end)
    {
        $last_append = '';
        if ($type == 1) {
            $last_append = " LIMIT $start , $end";
        }
        
        $query = $this->db->query("SELECT 
                        a.* , a.id as transaction_id, g.title as gigs_title, p.title as project_title, s.fullname as buyer_name, s.user_thumb_image as buyerimage, c.currency_sign
                        FROM  `payments`as a
                        LEFT JOIN members as s ON s.USERID = a.user_id
                        LEFT JOIN memberships as g ON g.id = a.item_id	
                        LEFT JOIN projects as p ON p.id = a.item_id
                        LEFT JOIN currencies as c ON c.currency = a.currency
                        where a.status = -2 " . $last_append);

        if ($type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    ///////////// new 
    public function get_cancelpayment_list($type, $start, $end)
    {
        $last_append = '';
        if ($type == 1) {
            $last_append = " LIMIT $start , $end";
        }
        
        $query = $this->db->query("SELECT 
                        a.* , a.id as transaction_id, g.title as gigs_title, p.title as project_title, s.fullname as buyer_name, s.user_thumb_image as buyerimage, c.currency_sign
                        FROM  `payments`as a
                        LEFT JOIN members as s ON s.USERID = a.user_id	
                        LEFT JOIN memberships as g ON g.id = a.item_id	
                        LEFT JOIN projects as p ON p.id = a.item_id
                        LEFT JOIN currencies as c ON c.currency = a.currency
                        where a.status = -3 " . $last_append);

        if ($type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function gig_preview($id)
    {

        $query = $this->db->query("SELECT * FROM  sell_gigs WHERE  md5(id) = '" . $id . "'");

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $gig_id = $data['id'];
            $data['extra_gigs'] = array();
            $data['gig_images'] = array();

            $query1 = $this->db->query("SELECT * FROM  extra_gigs WHERE   gigs_id = $gig_id");
            if ($query1->num_rows() > 0) {
                $extra_gig = $query1->result_array();
                $data['extra_gigs'] = $extra_gig;
            }
            $query2 = $this->db->query("SELECT * FROM gigs_image WHERE   gig_id = $gig_id");
            if ($query2->num_rows() > 0) {
                $gig_images = $query2->result_array();
                $data['gig_images'] = $gig_images;
            }
            return $data;
        } else {
            return FALSE;
        }

    }

    public function smtp_setting()
    {
        $data = array();
        $stmt = "SELECT * FROM system_settings ORDER BY id ASC";
        $query = $this->db->query($stmt);
        if ($query->num_rows()) {
            $data = $query->result_array();
        }
        return $data;
    }
}

?>