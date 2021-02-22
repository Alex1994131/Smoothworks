<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-12-26 03:37:30 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 03:37:30 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 03:37:39 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 03:38:26 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 03:38:26 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 03:38:26 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 03:38:42 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 03:38:42 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 03:45:40 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 03:45:43 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 03:45:45 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:16:31 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:16:31 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 04:16:39 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 04:16:39 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:16:58 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 04:16:58 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:17:17 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:17:17 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 04:17:17 --> 404 Page Not Found: Assets/js
ERROR - 2020-12-26 04:17:18 --> 404 Page Not Found: user/Payment/all_transaction_data
ERROR - 2020-12-26 04:18:06 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:18:07 --> 404 Page Not Found: user/Payment/all_transaction_data
ERROR - 2020-12-26 04:18:31 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:18:31 --> 404 Page Not Found: user/Payments/all_transaction_data
ERROR - 2020-12-26 04:18:57 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:18:58 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
' at line 6 - Invalid query: 
            SELECT 
            payment.*,
            sg.title,
            m.fullname,
            m.username,
			FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
	        LEFT JOIN members ON members.USERID = payments.user_id
			WHERE payments.`user_id` =   ORDER BY py.`created_at` DESC  
ERROR - 2020-12-26 04:19:37 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:19:38 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
' at line 6 - Invalid query: 
            SELECT 
            payment.*,
            sell_gigs.title,
            members.fullname,
            members.username,
			FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
	        LEFT JOIN members ON members.USERID = payments.user_id
			WHERE payments.`user_id` =   ORDER BY py.`created_at` DESC  
ERROR - 2020-12-26 04:20:09 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:20:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
' at line 6 - Invalid query: 
            SELECT 
            payment.*,
            sell_gigs.title,
            members.fullname,
            members.username,
			FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
	        LEFT JOIN members ON members.USERID = payments.user_id
			WHERE payments.`user_id` =   ORDER BY py.`created_date` DESC  
ERROR - 2020-12-26 04:20:32 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:20:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
' at line 6 - Invalid query: 
            SELECT 
            payments.*,
            sell_gigs.title,
            members.fullname,
            members.username,
			FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
	        LEFT JOIN members ON members.USERID = payments.user_id
			WHERE payments.`user_id` =   ORDER BY payments.`created_date` DESC  
ERROR - 2020-12-26 04:21:14 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:21:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY payments.`created_date` DESC' at line 9 - Invalid query: 
            SELECT 
            payments.*,
            sell_gigs.title,
            members.fullname,
            members.username
			FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
	        LEFT JOIN members ON members.USERID = payments.user_id
			WHERE payments.`user_id` =   ORDER BY payments.`created_date` DESC  
ERROR - 2020-12-26 04:21:45 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:21:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'ORDER BY payments.`created_date` DESC' at line 9 - Invalid query: 
            SELECT 
            payments.*,
            sell_gigs.title,
            members.fullname,
            members.username
			FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
	        LEFT JOIN members ON members.USERID = payments.user_id
			WHERE payments.`user_id` =   ORDER BY payments.`created_date` DESC
ERROR - 2020-12-26 04:22:26 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:22:27 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: 
            SELECT 
            payments.*,
            sell_gigs.title,
            members.fullname,
            members.username
			FROM `payments`
	        LEFT JOIN sell_gigs ON sell_gigs.id = payments.item_id
	        LEFT JOIN members ON members.USERID = payments.user_id
			WHERE payments.`user_id` = Array  ORDER BY payments.`created_date` DESC
ERROR - 2020-12-26 04:22:54 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:26:51 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:27:19 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:27:21 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:27:33 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:27:50 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:37:00 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:39:49 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:51:22 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:54:37 --> 404 Page Not Found: Purchases/index
ERROR - 2020-12-26 04:54:39 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:54:43 --> 404 Page Not Found: Sales/index
ERROR - 2020-12-26 04:54:44 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:55:49 --> 404 Page Not Found: Balance/index
ERROR - 2020-12-26 04:55:50 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 04:56:15 --> 404 Page Not Found: user/Wallets/index
ERROR - 2020-12-26 05:00:25 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 05:00:29 --> 404 Page Not Found: user/Notification/index
ERROR - 2020-12-26 05:03:01 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 07:22:34 --> Severity: error --> Exception: syntax error, unexpected '}', expecting identifier (T_STRING) E:\xampp\htdocs\smoothworks\application\views\user\includes\footer.php 399
ERROR - 2020-12-26 07:23:02 --> Severity: error --> Exception: syntax error, unexpected '}', expecting identifier (T_STRING) E:\xampp\htdocs\smoothworks\application\views\user\includes\footer.php 399
ERROR - 2020-12-26 07:24:08 --> Severity: error --> Exception: syntax error, unexpected '}', expecting identifier (T_STRING) E:\xampp\htdocs\smoothworks\application\views\user\includes\footer.php 399
ERROR - 2020-12-26 07:24:51 --> Severity: error --> Exception: syntax error, unexpected '}', expecting identifier (T_STRING) E:\xampp\htdocs\smoothworks\application\views\user\includes\footer.php 399
ERROR - 2020-12-26 07:25:44 --> Severity: error --> Exception: syntax error, unexpected '}', expecting identifier (T_STRING) E:\xampp\htdocs\smoothworks\application\views\user\includes\footer.php 399
ERROR - 2020-12-26 07:25:45 --> Severity: error --> Exception: syntax error, unexpected '}', expecting identifier (T_STRING) E:\xampp\htdocs\smoothworks\application\views\user\includes\footer.php 399
ERROR - 2020-12-26 08:04:21 --> Severity: error --> Exception: syntax error, unexpected '}' E:\xampp\htdocs\smoothworks\application\controllers\user\Balances.php 336
ERROR - 2020-12-26 08:10:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '0, 1) VALUES ('28', 0, 'USD', 'Asia/Tokyo', NULL, 0, 1, 'withdraw', 'paypal', 0,' at line 1 - Invalid query: INSERT INTO `payments` (`user_id`, `item_id`, `currency`, `time_zone`, `price`, `fee`, `type`, `remark`, `pay_method`, `txn_id`, 0, 1) VALUES ('28', 0, 'USD', 'Asia/Tokyo', NULL, 0, 1, 'withdraw', 'paypal', 0, '2020-12-26 08:10:34', '2020-12-26 08:10:34')
ERROR - 2020-12-26 08:11:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '0, 1) VALUES ('28', 0, 'USD', 'Asia/Tokyo', '255', 0, 1, 'withdraw', 'paypal', 0' at line 1 - Invalid query: INSERT INTO `payments` (`user_id`, `item_id`, `currency`, `time_zone`, `price`, `fee`, `type`, `remark`, `pay_method`, `txn_id`, 0, 1) VALUES ('28', 0, 'USD', 'Asia/Tokyo', '255', 0, 1, 'withdraw', 'paypal', 0, '2020-12-26 08:11:07', '2020-12-26 08:11:07')
ERROR - 2020-12-26 08:11:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '0, 1) VALUES ('28', 0, 'USD', 'Asia/Tokyo', 255, 0, 1, 'withdraw', 'paypal', 0, ' at line 1 - Invalid query: INSERT INTO `payments` (`user_id`, `item_id`, `currency`, `time_zone`, `price`, `fee`, `type`, `remark`, `pay_method`, `txn_id`, 0, 1) VALUES ('28', 0, 'USD', 'Asia/Tokyo', 255, 0, 1, 'withdraw', 'paypal', 0, '2020-12-26 08:11:27', '2020-12-26 08:11:27')
ERROR - 2020-12-26 08:11:57 --> Severity: error --> Exception: syntax error, unexpected '=', expecting ')' E:\xampp\htdocs\smoothworks\application\controllers\user\Balances.php 338
ERROR - 2020-12-26 13:09:02 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 13:17:06 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 13:19:03 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 13:19:34 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 13:25:54 --> 404 Page Not Found: Payments/index
ERROR - 2020-12-26 13:25:56 --> 404 Page Not Found: Payments/index
ERROR - 2020-12-26 13:28:13 --> Severity: error --> Exception: Unable to locate the model you have specified: Payment_model E:\xampp\htdocs\smoothworks\system\core\Loader.php 315
ERROR - 2020-12-26 13:28:22 --> Severity: error --> Exception: Unable to locate the model you have specified: Payment_model E:\xampp\htdocs\smoothworks\system\core\Loader.php 315
ERROR - 2020-12-26 13:33:14 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 13:33:19 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:05:49 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:17:34 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:20:29 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:20:44 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:25:30 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:25:48 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:25:50 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:26:04 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:26:17 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:26:26 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:26:58 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:33:08 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:34:35 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:35:56 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:36:56 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:38:20 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:38:41 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:39:38 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:39:50 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:40:07 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:44:23 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:50:28 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:52:09 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:54:42 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 14:57:10 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 15:01:44 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 15:02:21 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 15:03:05 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:03:10 --> Query error: Table 'smoothworks.bank_account' doesn't exist - Invalid query: SELECT a.* , a.id as newid, g.*, gi.*, s.fullname as buyer_name,s.user_thumb_image as buyerimage, s.description ,s.user_profile_image as sellerimage, sm.fullname as seller_name ,sm.user_thumb_image,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
									LEFT JOIN members as s ON s.USERID = a.USERID	
									LEFT JOIN sell_gigs as g ON g.user_id =a.seller_id
									LEFT JOIN gigs_image as gi ON gi.gig_id =g.id
									LEFT JOIN members as sm ON sm.USERID = a.seller_id group by a.id  LIMIT 0 , 15 
ERROR - 2020-12-26 15:03:15 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:03:35 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:03:56 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:04:15 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:04:35 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:04:55 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:05:14 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:05:35 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:05:55 --> Query error: Table 'smoothworks.buyer_rejected_list' doesn't exist - Invalid query: SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list` 
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID` 
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0
			
			) a ORDER BY a.created_date DESC 
ERROR - 2020-12-26 15:19:15 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 15:19:20 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 15:20:25 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 15:59:14 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 15:59:52 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 16:00:05 --> 404 Page Not Found: Assets/css
ERROR - 2020-12-26 16:00:07 --> 404 Page Not Found: Assets/css
