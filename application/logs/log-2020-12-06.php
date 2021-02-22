<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-12-06 10:43:52 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2020-12-06 11:44:12 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 11:44:29 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 12:13:21 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 12:13:41 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 12:13:44 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 12:27:25 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 12:27:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.sup' at line 5 - Invalid query: 
            SELECT 
            py.*,
            sg.title, 
            sg.user_id
            sg.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.super_fast_delivery_date, gi.image_path,gi.gig_image_thumb,m.fullname,m.username,m.user_thumb_image,cu.country,cu.sortname FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.seller_id
			LEFT JOIN country as cu ON cu.id = m.country
			WHERE py.`id` = 8
ERROR - 2020-12-06 12:27:56 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.sup' at line 5 - Invalid query: 
            SELECT 
            py.*,
            sg.title, 
            sg.user_id
            sg.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.super_fast_delivery_date, gi.image_path,gi.gig_image_thumb,m.fullname,m.username,m.user_thumb_image,cu.country,cu.sortname FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.seller_id
			LEFT JOIN country as cu ON cu.id = m.country
			WHERE py.`id` = 7
ERROR - 2020-12-06 12:30:46 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 16:41:57 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 16:42:09 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 16:44:18 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 16:44:21 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 16:44:27 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 16:44:29 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-06 16:44:46 --> 404 Page Not Found: Assets/css
