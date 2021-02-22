<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-12-09 16:08:24 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 16:12:38 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 16:12:46 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 16:30:28 --> 404 Page Not Found: Message/uploads
ERROR - 2020-12-09 16:30:29 --> 404 Page Not Found: Message/uploads
ERROR - 2020-12-09 16:32:01 --> 404 Page Not Found: Message/uploads
ERROR - 2020-12-09 16:32:01 --> 404 Page Not Found: Message/uploads
ERROR - 2020-12-09 16:54:30 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 17:20:57 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 17:21:14 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 17:21:19 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 17:21:50 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 19:12:32 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2020-12-09 19:12:32 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 19:12:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.sup' at line 5 - Invalid query: 
            SELECT 
            py.*,
            sg.title,
            sg.user_id
            sg.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.super_fast_delivery_date,gi.image_path,gi.gig_image_thumb,m.fullname,m.username,m.user_thumb_image,cu.country,cu.sortname FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.USERID
			LEFT JOIN country as cu ON cu.id = m.country
			WHERE py.`id` = 2
ERROR - 2020-12-09 19:13:20 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2020-12-09 19:13:20 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-09 21:32:34 --> Severity: error --> Exception: Unable to locate the model you have specified: Message_model E:\xampp\htdocs\smoothworks\system\core\Loader.php 315
ERROR - 2020-12-09 21:32:45 --> Severity: error --> Exception: Unable to locate the model you have specified: Message_model E:\xampp\htdocs\smoothworks\system\core\Loader.php 315
