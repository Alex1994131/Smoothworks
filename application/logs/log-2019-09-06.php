<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

ERROR - 2019-09-06 00:26:52 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 01:34:33 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 02:28:08 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 02:39:34 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 04:19:14 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 04:36:44 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 04:52:54 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 04:53:03 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 04:56:51 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 04:56:57 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '455')
ERROR - 2019-09-06 05:07:17 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 05:07:35 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 05:14:56 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 05:50:58 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 05:50:59 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 05:51:10 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 06:20:37 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '454')
ERROR - 2019-09-06 06:20:39 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '454')
ERROR - 2019-09-06 06:20:40 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 06:59:05 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 07:46:30 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 07:47:47 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 07:54:07 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 07:57:33 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 07:58:25 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '458')
ERROR - 2019-09-06 07:59:46 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 08:00:41 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 08:01:59 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 08:13:30 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 08:14:45 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:02:49 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:03:05 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '26')
ERROR - 2019-09-06 09:16:51 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:31:28 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:31:29 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:31:33 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '26')
ERROR - 2019-09-06 09:33:50 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:33:52 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:34:37 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:34:40 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:35:43 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:36:11 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 12:38:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND seller_status >=1 AND seller_status <=6 AND YEAR(created_at)=2019 GROUP BY(s' at line 10 - Invalid query: SELECT COUNT(*) as gigs_count,seller_status,
CASE
WHEN seller_status = 1 THEN "New"
WHEN seller_status = 2 THEN "Pending"
WHEN seller_status = 3 THEN "Processing"
WHEN seller_status = 4 THEN "Refunded"
WHEN seller_status = 5 THEN "Decline"
WHEN seller_status = 6 THEN "Completed"
ELSE "Inactive"
END AS gigs_status FROM `payments`WHERE seller_id= AND seller_status >=1 AND seller_status <=6 AND YEAR(created_at)=2019 GROUP BY(seller_status)
ERROR - 2019-09-06 12:38:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND Month(created_at)=1 && YEAR(created_at)=2019' at line 1 - Invalid query: SELECT COUNT(*)AS gigs_sales FROM `payments`WHERE `seller_status`=6 AND seller_id= AND Month(created_at)=1 && YEAR(created_at)=2019
ERROR - 2019-09-06 12:38:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND Month(created_at)=1 && YEAR(created_at)=2019' at line 1 - Invalid query: SELECT IFNULL(SUM(item_amount),0)AS gigs_sales_amount FROM `payments`WHERE `seller_status`=6 AND `payment_status`=2 AND seller_id= AND Month(created_at)=1 && YEAR(created_at)=2019
ERROR - 2019-09-06 09:38:57 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:39:06 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:40:18 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:41:30 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:46:40 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:49:27 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:52:54 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:53:11 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:53:21 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:54:21 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '471')
ERROR - 2019-09-06 09:55:32 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:55:38 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '471')
ERROR - 2019-09-06 09:57:20 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:57:28 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:58:19 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 09:58:21 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:12:55 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:14:19 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:14:28 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '451')
ERROR - 2019-09-06 10:43:54 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:43:56 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:44:11 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:45:16 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:45:26 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:45:27 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:45:29 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:45:38 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:46:11 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:46:15 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:48:35 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:51:23 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:54:01 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 10:55:45 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '446')
ERROR - 2019-09-06 10:55:52 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '453')
ERROR - 2019-09-06 10:56:03 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 11:09:59 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 11:10:03 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 11:16:54 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 11:24:51 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 11:26:51 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 11:26:56 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 11:27:01 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 11:33:04 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 11:34:14 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 11:57:46 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 12:08:52 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 12:08:57 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 12:15:18 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 12:15:19 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 12:49:48 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 12:49:58 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '458')
ERROR - 2019-09-06 13:01:28 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:09:28 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:09:37 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:09:50 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:10:17 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:11:21 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:11:32 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:12:28 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:12:29 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:30:00 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:32:06 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:32:25 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:32:33 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:39:28 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:57:44 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:57:46 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 13:58:03 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 14:21:15 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 14:21:27 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 14:30:23 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 14:31:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SET  `admin_notification_status` = 0 WHERE `id` = 1423' at line 1 - Invalid query: UPDATE   SET  `admin_notification_status` = 0 WHERE `id` = 1423
ERROR - 2019-09-06 14:37:33 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 14:37:45 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '471')
ERROR - 2019-09-06 14:43:00 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 14:46:11 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 15:00:16 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 15:00:38 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 15:01:25 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '471')
ERROR - 2019-09-06 15:01:47 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '453')
ERROR - 2019-09-06 15:02:35 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '471')
ERROR - 2019-09-06 15:25:01 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 15:47:27 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 15:47:33 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 15:48:04 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '26')
ERROR - 2019-09-06 15:53:07 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 15:53:41 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '471')
ERROR - 2019-09-06 15:53:58 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 15:55:17 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 16:03:25 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 16:04:04 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 16:04:10 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 16:04:19 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 16:04:40 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 16:33:40 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 16:41:32 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 17:03:08 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 17:14:23 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 18:43:08 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 18:43:50 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '458')
ERROR - 2019-09-06 18:44:11 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:18:38 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:19:29 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '461')
ERROR - 2019-09-06 19:19:29 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:19:44 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:19:51 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 19:19:52 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 19:23:27 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:24:41 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:28:23 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:30:18 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:33:16 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:34:22 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:35:00 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:36:46 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:36:57 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:37:51 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:50:48 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:50:53 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:51:14 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '461')
ERROR - 2019-09-06 19:51:16 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:52:13 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:52:13 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:52:17 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '471')
ERROR - 2019-09-06 19:55:24 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:56:07 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 19:56:46 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:07:28 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:07:58 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:24:34 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:24:41 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 20:25:02 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:25:03 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:31:54 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:32:23 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:32:26 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 20:37:05 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:06:18 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:06:18 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:07:09 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:07:20 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:10:01 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:12:30 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:13:44 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:13:47 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:14:04 --> 404 Page Not Found: Uploads/profile_images
ERROR - 2019-09-06 21:14:07 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 21:15:08 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:01:10 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:01:21 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:02:18 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:02:36 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:15:47 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:28:15 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:29:23 --> 404 Page Not Found: Assets/css
ERROR - 2019-09-06 22:34:59 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:37:05 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:37:22 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:38:43 --> 404 Page Not Found: Assets/css
ERROR - 2019-09-06 22:38:54 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '293')
ERROR - 2019-09-06 22:40:21 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:40:21 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:41:20 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:41:21 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:43:51 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:45:31 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:46:02 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:46:25 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:47:07 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:47:41 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:47:50 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 22:47:55 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 22:48:21 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 23:26:24 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 23:29:29 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 23:29:42 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '471')
ERROR - 2019-09-06 23:36:41 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 23:36:43 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 23:37:17 --> 404 Page Not Found: Odesk/index
ERROR - 2019-09-06 23:37:24 --> 404 Page Not Found: Craigslist/index
ERROR - 2019-09-06 23:37:30 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 23:37:53 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '118')
ERROR - 2019-09-06 23:38:27 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '69')
ERROR - 2019-09-06 23:38:31 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '252')
ERROR - 2019-09-06 23:40:14 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 23:41:23 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `views` (`user_id`, `gig_id`) VALUES (NULL, '452')
ERROR - 2019-09-06 23:47:11 --> 404 Page Not Found: Uploads/gig_images
ERROR - 2019-09-06 23:57:23 --> 404 Page Not Found: Uploads/gig_images
