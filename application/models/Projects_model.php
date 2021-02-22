<?php

class Projects_model extends CI_Model
{
    public function purchase_completed($id)
    {
        $query = $this->db->query(" SELECT payments.*,projects.title,members.fullname,members.username,
									FROM `payments` 
									INNER JOIN projects ON projects.id = payments.`gigs_id`
									INNER JOIN members ON members.USERID = payments.seller_id
									WHERE payments.`id` = $id ");
        $result = $query->row_array();
        return $result;
    }

    public function project_purchase_requirements($id)
    {
        $query = $this->db->query("SELECT members.email , (members.fullname) as seller_name , (members.username) as seller_username , projects.`title`, payments.extra_gig_ref, payments.payment_super_fast_delivery, projects.super_fast_delivery_desc,
								   (SELECT (members.fullname)  
									FROM members WHERE USERID =  payments.`USERID` ) as buyer_name,(SELECT (members.username)  
									FROM members WHERE USERID =  payments.`USERID` ) as buyer_username  FROM `payments` 
									INNER JOIN projects ON projects.id = payments.`gigs_id`
									INNER JOIN members ON members.USERID = payments.`seller_id` 
									WHERE payments.`id` = $id ");
        $result = $query->row_array();
        return $result;
    }

    public function latest_projects()
    {
        $query = $this->db->query(
            "SELECT 
                projects.*,
                members.`fullname`,
                members.`username`,
                members.`user_thumb_image`,
                members.`user_profile_image`,
                states.`state_name`,
                (SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
                (SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
                LEFT JOIN members ON members.USERID = projects.user_id 
                LEFT JOIN country ON members.`country` = country.id
                LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                ORDER BY projects.id DESC LIMIT 0 , 10 ");
        $result = $query->result_array();
        return $result;
    }

    public function recent_projects($param = '')
    {

        $query = $this->db->query(
            "SELECT 
                projects.*,
                members.`fullname`,
                members.`username`,
                members.`user_thumb_image`,
                members.`user_profile_image` , 
                states.`state_name` , 
                (SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
                (SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating 
            FROM `projects`
            LEFT JOIN members ON members.USERID = projects.user_id 
            LEFT JOIN country ON members.`country` = country.id
            LEFT JOIN states ON `states`.`state_id` = `members`.`state`
            GROUP BY id
            ORDER BY projects.id DESC LIMIT 0, 10");


        if ($param == 1) {
            $result = $query->result_array();
        } else {
            $result = $query->num_rows();
        }
        return $result;
    }

    public function popular_projects($param = '')
    {

        $query = $this->db->query(
            "SELECT 
                projects.*,
                members.`fullname`,
                members.`username`,
                members.`user_thumb_image`,
                members.`user_profile_image` , 
                states.`state_name` , 
                country.country , members.`state`,
                (SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id) AS project_usercount,
                (SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id) AS project_rating FROM `projects` 
                LEFT JOIN members ON members.USERID = projects.user_id 
                LEFT JOIN country ON members.`country` = country.id
                LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                WHERE members.status = 0
                ORDER BY projects.total_views DESC LIMIT 0 , 10  ");
        if ($param == 1) {
            $result = $query->result_array();
        } else {
            $result = $query->num_rows();
        }

        return $result;
    }

    public function popular_category()
    {
        $query = $this->db->query("SELECT projects.category_id,categories.name FROM `projects` LEFT JOIN categories ON categories.CATID = projects.category_id WHERE  name IS NOT null GROUP BY projects.category_id ORDER BY projects.total_views DESC LIMIT 0 , 4");
        $result = $query->result_array();
        return $result;
    }

    public function get_setting_price_option()
    {
        $query = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'price_option' ");
        $result = $query->row_array();
        return $result;
    }

    public function project_price()
    {
        $query = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'project_price' ");
        $result = $query->row_array();
        return $result;
    }

    public function last_visited($user_id, $return_type, $start, $end)
    {
        $append_sql = "";
        if ($start > 0 || $end > 0) {
            $append_sql = " LIMIT $start , $end";
        }
        $query = $this->db->query("
                    SELECT 
                    projects.*,
                    members.`fullname`,
                    members.`username`, 
                    `members`.`user_thumb_image`,
                    `members`.`user_profile_image` , 
                    `states`.`state_name` , 
                    country.country , 
                    members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
                    LEFT JOIN members ON members.USERID = projects.user_id 
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE members.status = 0 AND projects.id IN ( SELECT `gig_id` FROM `last_visited` WHERE `user_id` = $user_id  and is_gig = 0 ORDER BY  `last_visited`.`created_date` DESC  )" . $append_sql . " ");
        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;

    }

    // public function location_base_projects($full_country_name, $param, $start, $end)
    // {
    //     $full_country_name = str_replace("_", " ", $full_country_name);
    //     $append_sql = "";
    //     if ($start > 0 || $end > 0) {
    //         $append_sql = " LIMIT $start , $end";
    //     }
    //     $query = $this->db->query("
    //                 SELECT 
    //                 projects.*,
    //                 members.fullname,
    //                 members.username, 
    //                 members.user_thumb_image,
    //                 members.user_profile_image, 
    //                 `states`.`state_name` , 
    //                 country.country , 
    //                 members.`state`,
	// 				(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
	// 				(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
    //                 LEFT JOIN members ON members.USERID = projects.user_id 
    //                 LEFT JOIN country ON members.`country` = country.id
    //                 LEFT JOIN states ON `states`.`state_id` = `members`.`state`
    //                 WHERE projects.country_name = '$full_country_name'
	// 				ORDER BY projects.id ASC" . $append_sql . " ;");
    //     if ($param == 1) {
    //         $result = $query->result_array();
    //     } else {
    //         $result = $query->num_rows();
    //     }
    //     return $result;
    // }

    // public function username_base_projects($username, $param, $start, $end)
    // {
    //     $append_sql = "";
    //     if ($start > 0 || $end > 0) {
    //         $append_sql = " LIMIT $start , $end";
    //     }
    //     $query = $this->db->query("
    //                 SELECT 
    //                 projects.*,
    //                 members.`fullname,
    //                 members.`username, 
    //                 members.user_thumb_image,
    //                 members.user_profile_image, 
    //                 `states`.`state_name` ,
    //                 country.country , members.`state`,
	// 				(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
	// 				(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
    //                 LEFT JOIN members ON members.USERID = projects.user_id 
    //                 LEFT JOIN country ON members.`country` = country.id
    //                 LEFT JOIN states ON `states`.`state_id` = `members`.`state`
    //                 WHERE members.`username` = '$username'
	// 				ORDER BY projects.id ASC" . $append_sql . " ;");
    //     //echo 	$this->db->last_query().'<br>';

    //     if ($param == 1) {
    //         $result = $query->result_array();
    //     } else {
    //         $result = $query->num_rows();
    //     }
    //     return $result;
    // }

    // public function category_base_projects($category_name, $param, $start, $end)
    // {
    //     $category_name = str_replace("_", " ", $category_name);
    //     $append_sql = "";
    //     if ($start > 0 || $end > 0) {
    //         $append_sql = " LIMIT $start , $end";
    //     }
    //     $query = $this->db->query("
    //                     SELECT 
    //                     projects.*,
    //                     members.`fullname`,
    //                     members.`username`, 
    //                     members.`user_thumb_image`,
    //                     `members`.`user_profile_image` , 
    //                     `states`.`state_name` , 
    //                     country.country , 
    //                     members.`state`,
	// 					(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
	// 					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
    //                     LEFT JOIN members.USERID = projects.user_id 
    //                     LEFT JOIN country ON members.`country` = country.id
    //                     LEFT JOIN states ON `states`.`state_id` = `members`.`state`
    //                     WHERE projects.category_id = (SELECT `CATID` FROM `categories` WHERE `name` = '$category_name' AND `status` = 0) AND projects.user_id not in (select USERID from members where  status=1)  
    //                     ORDER BY projects.id DESC" . $append_sql . " ;");
    //     if ($param == 1) {
    //         $result = $query->result_array();
    //     } else {
    //         $result = $query->num_rows();
    //     }
    //     return $result;
    // }

    public function get_project_details($project_id)
    {
        $query_string = "SELECT  
        projects.*, 
        members.fullname, 
        members.username,
        members.`user_thumb_image`,
        members.`user_profile_image` , 
        country.country ,
        country.flag_icon,
        states.`state_name` , 
        members.`state`,
        categories.name,
        categories.parent , 
        GROUP_CONCAT( projects_files.file_path SEPARATOR '#') as file_paths
        FROM `projects` 
        LEFT JOIN members ON members.USERID = projects.user_id
        LEFT JOIN categories ON categories.CATID = projects.category_id
        LEFT JOIN country ON members.`country` = country.id
        LEFT JOIN states ON `states`.`state_id` = `members`.`state`
        LEFT JOIN projects_files ON projects_files.project_id = projects.id
        WHERE projects.id =  '$project_id' GROUP BY projects.id ;";
        $query = $this->db->query($query_string);
        $result = $query->row_array();
        return $result;
    }

    // public function search_project_details($title)
    // {
    //     $query = $this->db->query("SELECT  projects.*,members.`fullname`, `members`.`user_thumb_image`,`members`.`user_profile_image` , country.country ,   `states`.`state_name` , members.`state`,
    //                 categories.name,categories.parent , GROUP_CONCAT(projects_files.file_path SEPARATOR '#') as file_paths 
    //                 FROM `projects` 
    //                 LEFT JOIN members ON members.USERID = projects.user_id 
    //                 LEFT JOIN categories ON categories.CATID = projects.category_id
    //                 LEFT JOIN country ON members.`country` = country.id
    //                 LEFT JOIN states ON `states`.`state_id` = `members`.`state`
	// 				WHERE projects.user_id not in (select user_id from members where  status=1)  
    //                 AND projects.title LIKE '%$title%';");
    //     $result = $query->row_array();
    //     return $result;
    // }

    // public function user_all_projects($project_id, $user_id)
    // {
    //     $query = $this->db->query("
    //                 SELECT projects.*,
    //                 members.`fullname`, 
    //                 `members`.username, 
    //                 `members`.`user_thumb_image`,
    //                 `members`.`user_profile_image` , 
    //                 `states`.`state_name` ,
    //                 country.country , members.`state`,
	// 				(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
	// 				(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
    //                 LEFT JOIN members ON members.USERID = projects.user_id 
    //                 LEFT JOIN country ON members.`country` = country.id
    //                 LEFT JOIN states ON `states`.`state_id` = `members`.`state`
    //                 WHERE members.USERID = $user_id AND projects.id != $project_id AND projects.user_id not in (select user_id from members where  status=1)  
    //                 ORDER BY projects.id DESC ");
    //     $result = $query->result_array();
    //     return $result;
    // }

    public function category_based_projects($cat_id, $title = '')
    {
        $append_sql = "";
        if (!empty($title)) {
            $append_sql = " AND `title` != '$title'";
        }
        $query = $this->db->query("
                    SELECT projects.*,
                    members.`fullname`, 
                    `members`.`user_thumb_image`,
                    `members`.`user_profile_image` , 
                    `states`.`state_name` , 
                    country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id) AS project_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id) AS project_rating FROM `projects` 
                    LEFT JOIN members ON members.USERID = projects.user_id 
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE projects.category_id = $cat_id " . $append_sql . "
					
                    ORDER BY projects.id DESC ");
        $result = $query->result_array();
        return $result;
    }


    public function similar_projects($cat_id, $title = '')
    {
        $append_sql = "";
        if (!empty($title)) {
            $append_sql = " AND `title` != '$title'";
        }
        $query = $this->db->query("
                    SELECT 
                    projects.*,
                    members.`fullname`, 
                    `members`.`user_thumb_image`,
                    `members`.`user_profile_image` , 
                    `states`.`state_name` , 
                    country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
                    LEFT JOIN members ON members.USERID = projects.user_id 
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE projects.category_id = $cat_id " . $append_sql . "					
                    ORDER BY projects.id DESC LIMIT 0 , 3 ");
        $result = $query->result_array();
        return $result;
    }

    // public function project_file_details($id)
    // {
    //     $user_id = $this->session->userdata('SESSION_USER_ID');
    //     $query = $this->db->query("SELECT * FROM `projects_files` WHERE `project_id` = $id ");
    //     $result = $query->result_array();
    //     return $result;
    // }

    public function common_search($cat_id, $title, $start, $end, $return_type)
    {
        $append_sql = '';
        if ($cat_id != '') {
            $append_sql = " AND projects.category_id = $cat_id ";
        }
        $last_append = '';
        if ($start || $end != 0) {
            $last_append = " LIMIT $start , $end";
        }
        $query = $this->db->query("
                    SELECT 
                    projects.*,
                    members.`fullname`,
                    members.`username`, 
                    `members`.`user_thumb_image`,
                    `members`.`user_profile_image` , 
                    `states`.`state_name` , 
                    country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
                    LEFT JOIN members ON members.USERID = projects.user_id 
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE projects.`title` LIKE '%$title%' " . $append_sql . "
                    ORDER BY projects.id DESC " . $last_append . " ");
        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function common_search_category($cat_id, $start, $end, $return_type)
    {
        $last_append = '';
        if ($start || $end != 0) {
            $last_append = " LIMIT $start , $end";
        }
        $query = $this->db->query("
                    SELECT projects.*,
                    members.`fullname`,
                    members.`username`, 
                    `members`.`user_thumb_image`,
                    `members`.`user_profile_image` ,
                    `states`.`state_name` ,
                    country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = projects.id and to_user_id = projects.user_id and is_gig = 0) AS project_rating FROM `projects` 
                    LEFT JOIN members ON members.USERID = projects.user_id 
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE projects.category_id = $cat_id
					ORDER BY projects.id DESC " . $last_append . " ");
        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }


    public function my_projects($user_id, $type, $start, $end)
    {
        $append_sql = '';
        if ($type == 1) {
            $append_sql = " LIMIT $start , $end ";
        }

        $search_sql = '';

        if ($this->input->post('form_submit')) {
            $search_sql = "";

            if (isset($_POST["keyword"]) && !empty($_POST["keyword"])) {
                $keyword = $_POST["keyword"];
                $search_sql .= "AND title like '%" . $keyword . "%'";
            }
        }

        if (isset($_POST["search_category"]) && !empty($_POST["search_category"])) {
            $category = $_POST["search_category"];
            if($category != 0)
            {
                $search_sql .= " AND projects.category_id = " . $category . " ";
            }
        }

        $query_string = "
        SELECT 
        projects.id as id, 
        projects.title as title, 
        categories.name as category, 
        projects.project_price as price, 
        projects.created_date as date, 
        GROUP_CONCAT( projects_files.file_path SEPARATOR '#') as file_paths, 
        CASE projects.project_progress_flag
        WHEN 0 THEN (SELECT CONCAT(count(id),'Bids') FROM bids WHERE project_id = projects.id)
        WHEN 1 THEN 'Awarded'
        WHEN 2 THEN 'Accepted' 
        WHEN 3 THEN 'Milestone Requested' 
        WHEN 4 THEN 'Milestone Created' 
        WHEN 5 THEN 'Released' 
        END AS statues
        FROM projects 
        LEFT JOIN categories ON projects.category_id = categories.CATID 
        LEFT JOIN projects_files ON projects.id = projects_files.project_id
        WHERE projects.user_id = ".$user_id." ". $search_sql . " GROUP BY projects.id ORDER BY projects.created_date DESC " . $append_sql;

        $query = $this->db->query($query_string);
        if ($type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function my_bids( $user_id, $type,$start, $end)
    {
        $append_sql = '';
        if ($type == 1) {
            $append_sql = " LIMIT $start , $end ";
        }

        $search_sql = '';

        if ($this->input->post('form_submit')) {
            $search_sql = "";

            if (isset($_POST["keyword"]) && !empty($_POST["keyword"])) {
                $keyword = $_POST["keyword"];

                $search_sql .= "AND title like '%" . $keyword . "%'";
            }

            if (isset($_POST["search_category"]) && !empty($_POST["search_category"])) {
                $category = $_POST["search_category"];
                if($category != 0)
                {
                    $search_sql .= " AND projects.category_id = " . $category . " ";
                }
            }
        }

        $query_string = "SELECT projects.id as project_id, projects.title AS title, bids.`amount` AS my_amount,
        (SELECT COUNT(bids.`id`) FROM bids WHERE bids.`project_id` = projects.id) AS total_bids,
        (SELECT SUM(bids.`amount`)/ COUNT(bids.id) FROM bids WHERE bids.`project_id` = projects.id) AS average_amount,
        bids.created_date as date
        FROM bids
        LEFT JOIN projects ON bids.`project_id` = projects.`id`
        WHERE bids.`user_id` = ".$user_id." ".$search_sql."
        ORDER BY bids.created_date DESC " . $append_sql;

        $query = $this->db->query($query_string);
        if ($type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function all_projects( $type, $start, $end)
    {
        $append_sql = '';
        if ($type == 1) {
            $append_sql = " LIMIT $start , $end ";
        }

        $search_sql = '';

        if ($this->input->post('form_submit')) {
            $search_sql = "";

            if (isset($_POST["keyword"]) && !empty($_POST["keyword"])) {
                $keyword = $_POST["keyword"];

                $search_sql .= "title like '%" . $keyword . "%'";
            }
        }

        if (isset($_POST["search_category"]) && !empty($_POST["search_category"])) {
            $category = $_POST["search_category"];
            if($category != 0)
            {
                if($search_sql == '') {
                    $search_sql .= "projects.category_id = " . $category . " ";
                }
                else {
                    $search_sql .= "and projects.category_id = " . $category . " ";
                }
            }
        }

        if($search_sql == '') {
            $query_string = "
            SELECT projects.id as id, projects.title as title, projects.project_details as detail, categories.name as category, projects.project_price as price, projects.created_date as date, GROUP_CONCAT( projects_files.file_path SEPARATOR '#') as file_paths, 
            members.user_thumb_image as user_avatar,
            (SELECT count(id) FROM bids WHERE bids.project_id = projects.id) as bids
            FROM projects 
            LEFT JOIN members ON members.USERID = projects.user_id
            LEFT JOIN categories ON projects.category_id = categories.CATID 
            LEFT JOIN projects_files ON projects.id = projects_files.project_id 
            GROUP BY projects.id ORDER BY projects.created_date DESC " . $append_sql;
        }
        else {
            $query_string = "
            SELECT projects.id as id, projects.title as title, projects.project_details as detail, categories.name as category, projects.project_price as price, projects.created_date as date, GROUP_CONCAT( projects_files.file_path SEPARATOR '#') as file_paths, 
            members.user_thumb_image as user_avatar,
            (SELECT count(id) FROM bids WHERE bids.project_id = projects.id) as bids
            FROM projects 
            LEFT JOIN members ON members.USERID = projects.user_id
            LEFT JOIN categories ON projects.category_id = categories.CATID 
            LEFT JOIN projects_files ON projects.id = projects_files.project_id 
            WHERE ". $search_sql . " GROUP BY projects.id ORDER BY projects.created_date DESC " . $append_sql;
        }

        $query = $this->db->query($query_string);
        if ($type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function projects_feedbacks($project_id, $user_id)
    {
        $query = $this->db->query("SELECT feedback.*,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`
                    left join members on members.USERID = feedback.`from_user_id`
                    WHERE feedback.`gig_id` = $project_id AND from_user_id != $user_id AND feedback.`status` = 1  and is_gig = 0");
        $result = $query->result_array();
        return $result;
    }

    public function projects_country()
    {
        $query = $this->db->query("SELECT id,country FROM country WHERE id in (SELECT DISTINCT(country) as country_id  FROM members)");
        return $query->result_array();
    }

    public function projects_state($country_id)
    {
        if (!empty($country_id) && ($country_id != 0)) {
            $query = $this->db->query("SELECT state_id as id ,state_name as state FROM states WHERE country_id = $country_id");
            $records = $query->result_array();
            return $records;
        } else {
            return array();
        }
    }

    public function get_bid_mini_data($project_id, $user_id)
    {
        $this->db->select('count(id) as bid_count');
        $this->db->from('bids');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get();
        $bid_mini_data['count'] = $query->first_row()->bid_count;

        $this->db->select('count(id) as is_exist');
        $this->db->from('bids');
        $this->db->where('project_id', $project_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $bid_mini_data['bidded'] = $query->first_row()->is_exist>0 ? true : false;

        return $bid_mini_data;
    }

    public function get_bid_project_data($project_id, $user_id, $start, $count, $return_type)
    {
        $append_sql = "";
        if ($start > 0 || $end > 0) {
            $append_sql = " LIMIT $start , $end";
        }
        $query = $this->db->query("
                    SELECT
                    bids.id as bid_id, 
                    bids.user_id as user_id,
                    bids.proposal as proposal,
                    bids.amount as amount,
                    bids.day as day,
                    (SELECT project_progress_flag FROM projects WHERE bid_id = projects.award_bid ORDER BY id DESC LIMIT 1) as bid_status,
                    members.user_thumb_image as img_url,
                    members.fullname as user_name,
                    members.user_thumb_image as user_avatar,
                    country.country as country,
                    bids.created_date as date,
                    CASE bids.user_id WHEN ".$user_id." THEN 1 ELSE 0 END as is_mine
                    FROM bids
                    LEFT JOIN members ON members.USERID = bids.user_id 
                    LEFT JOIN country ON members.country = country.id
                    WHERE bids.project_id = ".$project_id." ORDER BY  is_mine DESC, bids.created_date ASC " . $append_sql . " ");
        if ($return_type == 0) {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_bid($project_id, $user_id)
    {
        $query = $this->db->query("
            SELECT * FROM bids WHERE bids.user_id = ".$user_id." AND bids.project_id = ".$project_id);
        $result = $query->result_array()[0];
        return $result;
    }
}

?>