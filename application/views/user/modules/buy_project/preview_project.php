<div class="">
    <section class="product-header">
        <div class="container">
            <?php
            $i = 0;
            if ($this->session->flashdata('message')) { ?>
                <div class="alert alert-success text-center fade in alert-dismissable"
                     id="flash_succ_message"><?php echo $this->session->flashdata('message'); ?></div>
                <?php
                $i = 1;
            } ?>

            <?php if ($this->session->userdata('message') && $i == 0) { ?>
                <div class="alert alert-success text-center fade in alert-dismissable"
                     id="flash_succ_message"><?php echo $this->session->userdata('message'); ?></div>

                <?php $this->session->unset_userdata('message');
            } ?>

            <?php
                $item_project_price = 0;
                if (!empty($project_details['project_price'])) {
                    $item_project_price = $project_details['project_price'];
                }
            ?>
            <script type="text/javascript">
                var projects_amount = <?php echo (!empty($project_details['project_price'])) ? $project_details['project_price'] : 0; ?>;
            </script>
            <?php
            if ($project_details['parent'] == 0) {
                $main_category = ' <a href="javascript:;" onclick = "category_search(\'' . str_replace(' ', '-', $project_details['name']) . '\')" >' . $project_details['name'] . '</a>';
                $breadcumbs = '<a href="javascript:;" onclick = "category_search(\'' . str_replace(' ', '-', $project_details['name']) . '\')" >' . $project_details['name'] . '</a> <i class=" fa fa fa-chevron-right"></i>';
            } else {
                $query = $this->db->query("SELECT CATID , `name` FROM categories WHERE `CATID` = (SELECT `parent` FROM `categories` WHERE `CATID` = " . $project_details['category_id'] . ")");
                $result = $query->row_array();
                $main_category = '<a href="javascript:;" onclick = "category_search(\'' . str_replace(' ', '-', $result['name']) . '\')" >' . $result['name'] . '</a> <span>></span> <a href="javascript:;"  onclick = "category_search(\'' . str_replace(' ', '-', $project_details['name']) . '\')" >' . $project_details['name'] . '</a>';

                $breadcumbs = '<a href="javascript:;"  onclick = "category_search(\'' . str_replace(' ', '-', $result['name']) . '\')" >' . $result['name'] . '</a> <i class="fa fa fa-chevron-right"></i>
                <a href="javascript:;" onclick = "category_search(\'' . str_replace(' ', '-', $project_details['name']) . '\')" >' . $project_details['name'] . '</a>';
            }
            ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs">
                        <a href="<?php echo base_url(); ?>"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a>
                        <i class="fa fa fa-chevron-right"></i>
                        <?php echo $breadcumbs; ?>
                    </div>
                    <?php
                    $rate = $project_details['project_price'];
                    $currency_option = (!empty($project_details['currency_type'])) ? $project_details['currency_type'] : 'USD';
                    $rate_symbol = currency_sign($currency_option);
                    $rate = $project_details['project_price'];
                    ?>
                    <h2 class="header-title"><?php echo ucfirst(str_replace("-", " ", $project_details['title'])); ?></h2>
                    <?php
                    $time_zone = '';
                    $time_zone = ($time_zone) ? $time_zone : 'Asia/kolkata';
                    $time = date($project_details['created_date']);

                    date_default_timezone_set($time_zone);

                    $date1 = date('Y-m-d H:i:s');
                    $now = new DateTime($date1);
                    $ref = new DateTime($time);
                    $diff = $now->diff($ref);
                    $total_seconds = 0;
                    $days = $diff->days;
                    $hours = $diff->h;
                    $mins = $diff->i;

                    if (!empty($days) && ($days > 0)) {
                        $days_to_seconds = $diff->days * 24 * 60 * 60;
                        $total_seconds = $total_seconds + $days_to_seconds;
                    }

                    if (!empty($hours) && ($hours > 0)) {
                        $hours_to_seconds = $diff->h * 60 * 60;
                        $total_seconds = $total_seconds + $hours_to_seconds;
                    }

                    if (!empty($mins) && ($mins > 0)) {
                        $min_to_seconds = $mins * 60;
                        $total_seconds = $total_seconds + $min_to_seconds;
                    }

                    $intervals = array(
                        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
                    );

                    $time_taken = '';
                    $just_now = (!empty($this->user_language[$this->user_selected]['lg_just_now'])) ? $this->user_language[$this->user_selected]['lg_just_now'] : $this->default_language['en']['lg_just_now'];

                    if ($total_seconds < 60 || $total_seconds == 0) {
                        $time_taken = $just_now;
                        //$time_taken = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';
                    }

                    $minutes_ago = (!empty($this->user_language[$this->user_selected]['lg_minutes_ago'])) ? $this->user_language[$this->user_selected]['lg_minutes_ago'] : $this->default_language['en']['lg_minutes_ago'];

                    if ($total_seconds >= 60 && $total_seconds < $intervals['hour']) {
                        $total_seconds = floor($total_seconds / $intervals['minute']);
                        $time_taken = $total_seconds == 1 ? $total_seconds . ' ' . $minutes_ago : $total_seconds . ' ' . $minutes_ago;
                    }

                    $hours_ago = (!empty($this->user_language[$this->user_selected]['lg_hours_ago'])) ? $this->user_language[$this->user_selected]['lg_hours_ago'] : $this->default_language['en']['lg_hours_ago'];

                    if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day']) {
                        $total_seconds = floor($total_seconds / $intervals['hour']);
                        $time_taken = $total_seconds == 1 ? $total_seconds . ' ' . $hours_ago : $total_seconds . ' ' . $hours_ago;
                    }

                    $day_ago = (!empty($this->user_language[$this->user_selected]['lg_day_ago'])) ? $this->user_language[$this->user_selected]['lg_day_ago'] : $this->default_language['en']['lg_day_ago'];

                    if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week']) {
                        $total_seconds = floor($total_seconds / $intervals['day']);
                        $time_taken = $total_seconds == 1 ? $total_seconds . ' ' . $day_ago : $total_seconds . ' ' . $day_ago;
                    }

                    $week_ago = (!empty($this->user_language[$this->user_selected]['lg_week_ago'])) ? $this->user_language[$this->user_selected]['lg_week_ago'] : $this->default_language['en']['lg_week_ago'];

                    if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month']) {
                        $total_seconds = floor($total_seconds / $intervals['week']);
                        $time_taken = $total_seconds == 1 ? $total_seconds . ' ' . $week_ago : $total_seconds . ' ' . $week_ago;
                    }

                    $months_ago = (!empty($this->user_language[$this->user_selected]['lg_months_ago'])) ? $this->user_language[$this->user_selected]['lg_months_ago'] : $this->default_language['en']['lg_months_ago'];

                    if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year']) {
                        $total_seconds = floor($total_seconds / $intervals['month']);
                        $time_taken = $total_seconds == 1 ? $total_seconds . ' ' . $months_ago : $total_seconds . ' ' . $months_ago;
                    }

                    $years_ago = (!empty($this->user_language[$this->user_selected]['lg_years_ago'])) ? $this->user_language[$this->user_selected]['lg_years_ago'] : $this->default_language['en']['lg_years_ago'];

                    if ($total_seconds >= $intervals['year']) {
                        $total_seconds = floor($total_seconds / $intervals['year']);
                        $time_taken = $total_seconds == 1 ? $total_seconds . ' ' . $years_ago : $total_seconds . ' ' . $years_ago;
                    }

                    ?>

                    <p class="gig-detail"><?php echo (!empty($user_language[$user_selected]['lg_created'])) ? $user_language[$user_selected]['lg_created'] : $default_language['en']['lg_created']; ?><?php echo $time_taken; ?></p>

                    <input type="hidden" name="rate_symbol" id="rate_symbol" value="<?php echo $rate_symbol; ?>">
                </div>
            </div>
        </div>
    </section>
    <div class="gig-info">
        <div class="info-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 sos-menu-bar">
                        <a class="sos-menu-item active">
                            <?php
                            echo (!empty($user_language[$user_selected]['lg_details'])) ? $user_language[$user_selected]['lg_details'] : $default_language['en']['lg_details'];
                            ?>
                        </a>
                        <a href="<?php echo base_url() . "project-proposals/view/" . $project_id ?>"
                           class="sos-menu-item">
                            <?php
                            echo (!empty($user_language[$user_selected]['lg_proposals'])) ? $user_language[$user_selected]['lg_proposals'] : $default_language['en']['lg_proposals'];
                            ?>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="gig-info-list">
                            <?php $days = $project_details['delivering_time'];
                            $days = (!empty($user_language[$user_selected]['lg_days'])) ? $user_language[$user_selected]['lg_days'] : $default_language['en']['lg_days'];
                            $day = (!empty($user_language[$user_selected]['lg_day'])) ? $user_language[$user_selected]['lg_day'] : $default_language['en']['lg_day'];
                            if ($days > 1) {
                                $display_days = $project_details['delivering_time'] . ' ' . $days;
                            } else {
                                $display_days = $project_details['delivering_time'] . ' ' . $day;
                            }
                            ?>
                            <span class="gig-deliver">
                                <?php echo (!empty($user_language[$user_selected]['lg_will_deliver_in'])) ? $user_language[$user_selected]['lg_will_deliver_in'] : $default_language['en']['lg_will_deliver_in']; ?> <?php echo $display_days; ?>
                                <span class="gig-count"></span>
                            </span>
                            <div class="gig-share">
                                <?php
                                if (!empty($project_details['project_details'])) {
                                    $des = strip_tags($project_details['project_details']);
                                } else {
                                    $des = '';
                                }
                                $image_path_one = explode("#", $project_details['image_path']);
                                $facebook = '<a href="http://www.facebook.com/share.php?u=' . base_url() . 'project-preview/' . $project_details['title'] . '&title=' . $project_details['title'] . '&picture=' . base_url() . $image_path_one[0] . '&description=' . $des . '" target="_blank"></a>';
                                $twitter = '<a href="http://twitter.com/share?text=' . $project_details['title'] . '&url=' . base_url() . 'project-preview/' . $project_details['title'] . '&image-url=' . base_url() . $image_path_one[0] . '" target="_blank"> </a>';
                                $linkedin = '<a href="http://www.linkedin.com/shareArticle?mini=true&url=' . base_url() . 'project-preview/' . $project_details['title'] . '&title=' . $project_details['title'] . '&summary=' . $des . '" target="_blank"> </a>	';
                                $pinterest = '<a href="http://pinterest.com/pin/create/button/?url=' . base_url() . 'project-preview/' . $project_details['title'] . '&description=' . $project_details['title'] . '" target="_blank"> </a>	';
                                $google = '<a href="https://plus.google.com/share?url=' . base_url() . 'project-preview/' . $project_details['title'] . '&title=' . $project_details['title'] . '" target="_blank"> </a>	';

                                ?>
                                <ul>
                                    <li class="facebook-share"><?php echo $facebook; ?></li>
                                    <li class="twitter-share"><?php echo $twitter; ?></li>
                                    <li class="pinterest-share"><?php echo $pinterest; ?></li>
                                    <li class="google-share"><?php echo $google; ?></li>
                                    <li class="linkedin-share"><?php echo $linkedin; ?></li>
                                </ul>
                            </div>
                            <span class="gig-save-btn">
                                <?php
                                if (($this->session->userdata('SESSION_USER_ID'))) {
                                    $already_marked = '';
                                    $user_id = $this->session->userdata('SESSION_USER_ID');
                                    foreach ($user_favorites as $value) {
                                        if (($project_id == $value['project_id']) && ($user_id == $value['user_id'])) {
                                            $already_marked = TRUE;
                                            break;
                                        } else {
                                            $already_marked = FALSE;
                                        }
                                    }
                                    if ($project_user_id == $this->session->userdata('SESSION_USER_ID')) {
                                        echo  " Your project "     ;
                                    } else {
                                        if ($already_marked == TRUE) { ?>
                                            <a href="javascript:" onclick="remove_favourites('<?php echo $project_id; ?>','<?php echo $user_id; ?>')"> Saved </a>
                                        <?php } else { ?>
                                            <a href="javascript:" onclick="add_favourites('<?php echo $project_id; ?>','<?php echo $user_id; ?>')">
                                                <?php echo (!empty($user_language[$user_selected]['lg_save'])) ? $user_language[$user_selected]['lg_save'] : $default_language['en']['lg_save']; ?>
                                            </a>
                                        <?php }
                                    }
                                } else { ?>
                                    <a href="javascript:" onclick="selected_menu('sell_service')">
                                        <?php echo (!empty($user_language[$user_selected]['lg_save'])) ? $user_language[$user_selected]['lg_save'] : $default_language['en']['lg_save']; ?>
                                    </a>
                                <?php } ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="view-gig-area">
        <div class="container">
            <form id="bid" action="<?php echo base_url() . "project-preview/" . $project_id; ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="view-left">
                            <div class="gig-information">
                                <div class="sos-bid-info-up">
                                    <div>
                                        <h3 class="gig-desc-title"><?php echo (!empty($user_language[$user_selected]['lg_description'])) ? $user_language[$user_selected]['lg_description'] : $default_language['en']['lg_description']; ?></h3>
                                        <span><?php echo ucfirst($project_details['project_details']); ?></span>
                                    </div>
                                </div>
                                <div class="sos-bid-info-down">
                                    <div>
                                        <h3 class="gig-desc-title"><?php echo (!empty($user_language[$user_selected]['lg_attached_files'])) ? $user_language[$user_selected]['lg_attached_files'] : $default_language['en']['lg_attached_files']; ?></h3>
                                        <?php
                                        foreach ($project_files as $file) {
                                            ?>
                                            <a href="<?php echo base_url() . $file ?>" style="display:block" download>
                                                <i class="fa fa-paperclip"></i> <?php echo array_pop(explode('/', $file)); ?>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($feedbacks)) { ?>
                                <div class="feedback-section">
                                    <div class="view-header clearfix">
                                        <h3 class="gig-view-title feedback-area">
                                            <?php echo (!empty($user_language[$user_selected]['lg_latest_feedbacks'])) ? $user_language[$user_selected]['lg_latest_feedbacks'] : $default_language['en']['lg_latest_feedbacks']; ?>
                                            <span class="starrr" data-rating="<?php echo $user_feedback; ?>"> </span>
                                            (<?php echo count($feedbacks); ?>)
                                        </h3>
                                    </div>
                                    <ul class="feedback-list">
                                        <?php foreach ($feedbacks as $key => $feedback) {
                                            if ($time_zone != $feedback['time_zone']) {
                                                $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));
                                                $date->setTimezone(new DateTimeZone($time_zone));
                                                $time = $date->format('Y-m-d H:i:s');
                                                date_default_timezone_set($time_zone);
                                                $date1 = date('Y-m-d H:i:s');
                                                $now = new DateTime($date1);
                                                $ref = new DateTime($time);
                                                $diff = $now->diff($ref);
                                            } else {
                                                $project_time_zone = !empty($project_time_zone) ? $project_time_zone : 'Asia/Kolkata';
                                                date_default_timezone_set($project_time_zone);
                                                $now = new DateTime(date('Y-m-d H:i:s'));
                                                $ref = new DateTime($feedback['created_date']);
                                                $diff = $now->diff($ref);
                                            }
                                            $total_seconds = 0;
                                            $days = $diff->days;
                                            $hours = $diff->h;
                                            $mins = $diff->i;

                                            if (!empty($days) && ($days > 0)) {
                                                $days_to_seconds = $diff->days * 24 * 60 * 60;
                                                $total_seconds = $total_seconds + $days_to_seconds;
                                            }

                                            if (!empty($hours) && ($hours > 0)) {
                                                $hours_to_seconds = $diff->h * 60 * 60;
                                                $total_seconds = $total_seconds + $hours_to_seconds;
                                            }

                                            if (!empty($mins) && ($mins > 0)) {
                                                $min_to_seconds = $mins * 60;
                                                $total_seconds = $total_seconds + $min_to_seconds;
                                            }

                                            $intervals = array(
                                                'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
                                            );

                                            $time_difference = '';
                                            //now we just find the difference
                                            $just_now = (!empty($this->user_language[$this->user_selected]['lg_just_now'])) ? $this->user_language[$this->user_selected]['lg_just_now'] : $this->default_language['en']['lg_just_now'];

                                            if ($total_seconds == 0) {
                                                $time_difference = $just_now;
                                            }

                                            $seconds_ago = (!empty($this->user_language[$this->user_selected]['lg_seconds_ago'])) ? $this->user_language[$this->user_selected]['lg_seconds_ago'] : $this->default_language['en']['lg_seconds_ago'];
                                            if ($total_seconds < 60) {
                                                $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $seconds_ago : $total_seconds . ' ' . $seconds_ago;
                                            }

                                            $minutes_ago = (!empty($this->user_language[$this->user_selected]['lg_minutes_ago'])) ? $this->user_language[$this->user_selected]['lg_minutes_ago'] : $this->default_language['en']['lg_minutes_ago'];

                                            if ($total_seconds >= 60 && $total_seconds < $intervals['hour']) {

                                                $total_seconds = floor($total_seconds / $intervals['minute']);

                                                $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $minutes_ago : $total_seconds . ' ' . $minutes_ago;

                                            }

                                            $hours_ago = (!empty($this->user_language[$this->user_selected]['lg_hours_ago'])) ? $this->user_language[$this->user_selected]['lg_hours_ago'] : $this->default_language['en']['lg_hours_ago'];

                                            if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day']) {

                                                $total_seconds = floor($total_seconds / $intervals['hour']);

                                                $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $hours_ago : $total_seconds . ' ' . $hours_ago;

                                            }

                                            $days_ago = (!empty($this->user_language[$this->user_selected]['lg_days_ago'])) ? $this->user_language[$this->user_selected]['lg_days_ago'] : $this->default_language['en']['lg_days_ago'];

                                            if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week']) {

                                                $total_seconds = floor($total_seconds / $intervals['day']);

                                                $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $days_ago : $total_seconds . ' ' . $days_ago;

                                            }

                                            $weeks_ago = (!empty($this->user_language[$this->user_selected]['lg_weeks_ago'])) ? $this->user_language[$this->user_selected]['lg_weeks_ago'] : $this->default_language['en']['lg_weeks_ago'];

                                            if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month']) {

                                                $total_seconds = floor($total_seconds / $intervals['week']);

                                                $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $weeks_ago : $total_seconds . ' ' . $weeks_ago;

                                            }

                                            $months_ago = (!empty($this->user_language[$this->user_selected]['lg_months_ago'])) ? $this->user_language[$this->user_selected]['lg_months_ago'] : $this->default_language['en']['lg_months_ago'];

                                            if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year']) {

                                                $total_seconds = floor($total_seconds / $intervals['month']);

                                                $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $months_ago : $total_seconds . ' ' . $months_ago;

                                            }

                                            $years_ago = (!empty($this->user_language[$this->user_selected]['lg_years_ago'])) ? $this->user_language[$this->user_selected]['lg_years_ago'] : $this->default_language['en']['lg_years_ago'];

                                            if ($total_seconds >= $intervals['year']) {

                                                $total_seconds = floor($total_seconds / $intervals['year']);

                                                $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $years_ago : $total_seconds . ' ' . $years_ago;

                                            }


                                            $rat_ing = $feedback['rating'];

                                            $u_images = base_url() . 'assets/images/avatar2.jpg';

                                            if ($feedback['user_thumb_image'] != '') {

                                                $u_images = base_url() . $feedback['user_thumb_image'];

                                            }

                                            ?>
                                            <li class="media">
                                                <a href="<?php echo base_url() . 'user-profile/' . $feedback['username']; ?>" class="pull-left">
                                                    <img width="26" height="26" alt="" src="<?php echo $u_images; ?>">
                                                </a>

                                                <div class="media-body">
                                                    <div class="feedback-info">
                                                        <div class="feedback-author">
                                                            <a href="<?php echo base_url() . 'user-profile/' . $feedback['username']; ?>"><?php echo $feedback['fullname']; ?></a>
                                                        </div>
                                                        <span class="feedback-time"><?php echo $time_difference; ?></span>
                                                    </div>
                                                    <div class="feedback-area">
                                                        <p><?php echo $feedback['comment']; ?>
                                                            <span class="starrr" data-rating="<?php echo $rat_ing; ?>"></span>
                                                        </p>
                                                    </div>
                                                    <?php
                                                    $query = $this->db->query("SELECT feedback.*,members.* FROM `feedback` 
                                                                        LEFT JOIN members ON members.USERID = feedback.`from_user_id`
                                                                        WHERE feedback.`from_user_id` = $project_user_id AND feedback.`to_user_id` = " . $feedback['from_user_id'] . " AND feedback.`order_id` = " . $feedback['order_id'] . " AND feedback.`status` = 1");
                                                    $result = $query->row_array();

                                                    if (!empty($result)) {

                                                        $u_imagesone = base_url() . 'assets/images/avatar2.jpg';

                                                        if ($result['user_thumb_image'] != '') {

                                                            $u_imagesone = base_url() . $result['user_thumb_image'];

                                                        }

                                                        if ($time_zone != $feedback['time_zone']) {

                                                            $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));

                                                            $date->setTimezone(new DateTimeZone($time_zone));

                                                            $time = $date->format('Y-m-d H:i:s');

                                                            //   echo "posted time :" .$time ;


                                                            date_default_timezone_set($time_zone);

                                                            $date1 = date('Y-m-d H:i:s');

                                                            //     echo " Current_time ".$date1;


                                                            $now = new DateTime($date1);

                                                            $ref = new DateTime($time);

                                                            $diff = $now->diff($ref);

                                                        } else {

                                                            date_default_timezone_set($project_time_zone);

                                                            $now = new DateTime(date('Y-m-d H:i:s'));

                                                            //$now = new DateTime($feedback['created_date']);

                                                            $ref = new DateTime($feedback['created_date']);

                                                            $diff = $now->diff($ref);

                                                        }

                                                        $total_seconds = 0;

                                                        $days = $diff->days;

                                                        $hours = $diff->h;

                                                        $mins = $diff->i;

                                                        if (!empty($days) && ($days > 0)) {

                                                            $days_to_seconds = $diff->days * 24 * 60 * 60;

                                                            $total_seconds = $total_seconds + $days_to_seconds;

                                                        }

                                                        if (!empty($hours) && ($hours > 0)) {

                                                            $hours_to_seconds = $diff->h * 60 * 60;

                                                            $total_seconds = $total_seconds + $hours_to_seconds;

                                                        }

                                                        if (!empty($mins) && ($mins > 0)) {

                                                            $min_to_seconds = $mins * 60;

                                                            $total_seconds = $total_seconds + $min_to_seconds;

                                                        }

                                                        $intervals = array(

                                                            'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60

                                                        );

                                                        $time_difference = '';

                                                        //now we just find the difference
                                                        $just_now = (!empty($this->user_language[$this->user_selected]['lg_just_now'])) ? $this->user_language[$this->user_selected]['lg_just_now'] : $this->default_language['en']['lg_just_now'];

                                                        if ($total_seconds == 0) {

                                                            $time_difference = $just_now;

                                                        }

                                                        $seconds_ago = (!empty($this->user_language[$this->user_selected]['lg_seconds_ago'])) ? $this->user_language[$this->user_selected]['lg_seconds_ago'] : $this->default_language['en']['lg_seconds_ago'];

                                                        if ($total_seconds < 60) {

                                                            $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $seconds_ago : $total_seconds . ' ' . $seconds_ago;

                                                        }

                                                        $minutes_ago = (!empty($this->user_language[$this->user_selected]['lg_minutes_ago'])) ? $this->user_language[$this->user_selected]['lg_minutes_ago'] : $this->default_language['en']['lg_minutes_ago'];

                                                        if ($total_seconds >= 60 && $total_seconds < $intervals['hour']) {

                                                            $total_seconds = floor($total_seconds / $intervals['minute']);

                                                            $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $minutes_ago : $total_seconds . ' ' . $minutes_ago;

                                                        }

                                                        $hours_ago = (!empty($this->user_language[$this->user_selected]['lg_hours_ago'])) ? $this->user_language[$this->user_selected]['lg_hours_ago'] : $this->default_language['en']['lg_hours_ago'];

                                                        if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day']) {

                                                            $total_seconds = floor($total_seconds / $intervals['hour']);

                                                            $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $hours_ago : $total_seconds . ' ' . $hours_ago;

                                                        }

                                                        $day_ago = (!empty($this->user_language[$this->user_selected]['lg_day_ago'])) ? $this->user_language[$this->user_selected]['lg_day_ago'] : $this->default_language['en']['lg_day_ago'];

                                                        if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week']) {

                                                            $total_seconds = floor($total_seconds / $intervals['day']);

                                                            $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $day_ago : $total_seconds . ' ' . $day_ago;

                                                        }

                                                        $week_ago = (!empty($this->user_language[$this->user_selected]['lg_week_ago'])) ? $this->user_language[$this->user_selected]['lg_week_ago'] : $this->default_language['en']['lg_week_ago'];

                                                        if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month']) {

                                                            $total_seconds = floor($total_seconds / $intervals['week']);

                                                            $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $week_ago : $total_seconds . ' ' . $week_ago;

                                                        }

                                                        $months_ago = (!empty($this->user_language[$this->user_selected]['lg_months_ago'])) ? $this->user_language[$this->user_selected]['lg_months_ago'] : $this->default_language['en']['lg_months_ago'];

                                                        if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year']) {

                                                            $total_seconds = floor($total_seconds / $intervals['month']);

                                                            $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $months_ago : $total_seconds . ' ' . $months_ago;

                                                        }

                                                        $years_ago = (!empty($this->user_language[$this->user_selected]['lg_years_ago'])) ? $this->user_language[$this->user_selected]['lg_years_ago'] : $this->default_language['en']['lg_years_ago'];

                                                        if ($total_seconds >= $intervals['year']) {

                                                            $total_seconds = floor($total_seconds / $intervals['year']);

                                                            $time_difference = $total_seconds == 1 ? $total_seconds . ' ' . $years_ago : $total_seconds . ' ' . $years_ago;

                                                        }


                                                        ?>
                                                        <div class="media">
                                                            <a href="<?php echo base_url() . 'user-profile/' . $result['username']; ?>" class="pull-left">
                                                                <img width="26" height="26" alt="" src="<?php echo $u_imagesone; ?>">
                                                            </a>

                                                            <div class="media-body">
                                                                <div class="feedback-info">
                                                                    <div class="feedback-author">
                                                                        <a href="<?php echo base_url() . 'user-profile/' . $result['username']; ?>"><?php echo $result['fullname']; ?></a>
                                                                    </div>
                                                                    <span class="feedback-time"><?php echo $time_difference; ?></span>
                                                                </div>
                                                                <p><?php echo $result['comment']; ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                            <?php if ($key == 1) {
                                                break;
                                            }
                                        } ?>
                                    </ul>

                                    <?php if (count($feedbacks) > 2) { ?>

                                        <div class="more-feedback">

                                            <input type="hidden" id="load_more_feedid" name="load_more_feedid"
                                                   value="2"/>

                                            <input type="hidden" id="load_more_projectid" name="load_more_projectid"
                                                   value="<?php echo $project_id; ?>"/>

                                            <input type="hidden" id="load_more_project_userid"
                                                   name="load_more_project_userid"
                                                   value="<?php echo $project_user_id; ?>"/>

                                            <a href="javascript:"
                                               onclick="load_more_feedbacks();"><?php echo (!empty($user_language[$user_selected]['lg_more_feedbacks'])) ? $user_language[$user_selected]['lg_more_feedbacks'] : $default_language['en']['lg_more_feedbacks']; ?></a>

                                        </div>

                                    <?php } ?>

                                </div>

                            <?php } ?>

                            <?php if (($this->session->userdata('SESSION_USER_ID'))) {
                                if (($this->session->userdata('SESSION_USER_ID')) != $user_profile['USERID'] && (!$bid_data['bidded'] || $is_edit) && $my_account_type == 1 && $project_details['project_progress_flag'] < 2) {?>
                                    <div class="sos-bid-info-up">
                                        <h3 class="gig-desc-title">
                                            <?php echo (!empty($user_language[$user_selected]['lg_place_a_bid_here'])) ? $user_language[$user_selected]['lg_place_a_bid_here'] : $default_language['en']['lg_place_a_bid_here']; ?>
                                        </h3>
                                    </div>

                                    <div class="seller-info" name="bid-area">
                                        <div class="bid-container">
                                            <div class="bid-description">
                                                <label class="label-title"><?php echo (!empty($user_language[$user_selected]['lg_describe_your_proposal'])) ? $user_language[$user_selected]['lg_describe_your_proposal'] : $default_language['en']['lg_describe_your_proposal']; ?>
                                                    <span class="required" style="color:red">*</span>
                                                </label>
                                                <textarea rows="5"
                                                      placeholder="<?php echo (!empty($user_language[$user_selected]['lg_explain_in_more_detail_what_exactly_you_can_do'])) ? $user_language[$user_selected]['lg_explain_in_more_detail_what_exactly_you_can_do'] : $default_language['en']['lg_explain_in_more_detail_what_exactly_you_can_do']; ?>..."
                                                      name="bid_proposal" id="bid_proposal"
                                                      class="form-control"><?php echo $my_bid["proposal"] ?></textarea>
                                                <small class="error_msg help-block" id="desc_err"></small>
                                                <small class="error_msg help-block  bid_proposal_error" style="display: none;">
                                                    <?php echo (!empty($user_language[$user_selected]['lg_please_enter_about_your_project_details'])) ? $user_language[$user_selected]['lg_please_enter_about_your_project_details'] : $default_language['en']['lg_please_enter_about_your_project_details']; ?>
                                                </small>
                                            </div>
                                            <div class="bid-character">
                                                <div class="bid-input-group">
                                                    <label class="label-title"><?php echo (!empty($user_language[$user_selected]['lg_bid_amount'])) ? $user_language[$user_selected]['lg_bid_amount'] : $default_language['en']['lg_bid_amount']; ?>
                                                        <span class="required" style="color:red">*</span>
                                                    </label>
                                                    <div class="bid-input">
                                                        <input placeholder="<?php echo (!empty($user_language[$user_selected]['lg_enter_bid_amount'])) ? $user_language[$user_selected]['lg_enter_bid_amount'] : $default_language['en']['lg_enter_bid_amount']; ?>..."
                                                               type="number" min="0" name="bid_amount" id="bid_amount"
                                                               class="form-control"
                                                               value="<?php echo $my_bid["amount"] ?>">
                                                        <label><?php echo $rate_symbol ?></label>
                                                    </div>
                                                    <small class="error_msg help-block" id="desc_err"></small>
                                                    <small class="error_msg help-block  bid_amount_error" style="display: none;">
                                                        <?php echo (!empty($user_language[$user_selected]['lg_please_enter_about_your_project_details'])) ? $user_language[$user_selected]['lg_please_enter_about_your_project_details'] : $default_language['en']['lg_please_enter_about_your_project_details']; ?>
                                                    </small>
                                                </div>
                                                <div class="bid-input-group">
                                                    <label class="label-title"><?php echo (!empty($user_language[$user_selected]['lg_deliver_in'])) ? $user_language[$user_selected]['lg_deliver_in'] : $default_language['en']['lg_deliver_in']; ?>
                                                        <span class="required" style="color:red">*</span>
                                                    </label>

                                                    <div class="bid-input">
                                                        <input placeholder="<?php echo (!empty($user_language[$user_selected]['lg_enter_number_of_day'])) ? $user_language[$user_selected]['lg_enter_number_of_day'] : $default_language['en']['lg_enter_number_of_day']; ?>..."
                                                               type="number" name="delivery_day" id="delivery_day"
                                                               class="form-control"
                                                               value="<?php echo $my_bid["day"] ?>">
                                                        <label>
                                                            <?php echo (!empty($user_language[$user_selected]['lg_days'])) ? $user_language[$user_selected]['lg_days'] : $default_language['en']['lg_days']; ?>
                                                        </label>
                                                    </div>
                                                    <small class="error_msg help-block" id="desc_err"></small>
                                                    <small class="error_msg help-block  delivery_day_error" style="display: none;">
                                                        <?php echo (!empty($user_language[$user_selected]['lg_please_enter_about_your_project_details'])) ? $user_language[$user_selected]['lg_please_enter_about_your_project_details'] : $default_language['en']['lg_please_enter_about_your_project_details']; ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                if ($bid_data['bidded'] && !$is_edit) {
                                ?>
                                    <div class="preview-box">
                                        <h3 class="gig-desc-title">
                                         <?php echo (!empty($user_language[$user_selected]['lg_you_have_already_bidded'])) ? $user_language[$user_selected]['lg_you_have_already_bidded'] : $default_language['en']['lg_you_have_already_bidded']; ?>
                                        </h3>
                                    </div>
                                <?php
                                }

                                if($project_details['project_progress_flag'] > 1 && $my_account_type == 1) { ?>
                                    <div class="preview-box">
                                        <h3 class="gig-desc-title">
                                            This project is already awarded. Please bid another project.
                                        </h3>
                                    </div>
                                <?php } ?>

                            <?php } ?>
                        </div>

                    </div>

                    <div class="col-sm-4 rightsidebar">
                        <div class="view-right">
                            <div class="order-btn theiaStickySidebar">
                                <?php if (($this->session->userdata('SESSION_USER_ID'))) {
                                    if (($this->session->userdata('SESSION_USER_ID')) != $user_profile['USERID'] && (!$bid_data['bidded'] || $is_edit) && $my_account_type == 1 && $project_details['project_progress_flag'] < 2) {
                                        $my_project_rate = $rate;
                                        ?>
                                        <input type="hidden" name="form_submit" value="add">
                                        <button type="button" onclick="project_preview_bid()" class="btn">
                                            <?php echo $is_edit ? ((!empty($user_language[$user_selected]['lg_update_bid'])) ? $user_language[$user_selected]['lg_update_bid'] : $default_language['en']['lg_update_bid']) : ((!empty($user_language[$user_selected]['lg_place_bid'])) ? $user_language[$user_selected]['lg_place_bid'] : $default_language['en']['lg_place_bid']); ?>
                                        </button>
                                    <?php } else if (($this->session->userdata('SESSION_USER_ID')) != $user_profile['USERID'] && $bid_data['bidded']) { ?>


                                    <?php } else if (($this->session->userdata('SESSION_USER_ID')) == $user_profile['USERID'] && $my_account_type == 2) { ?>
                                        <a href="<?php echo base_url() . "edit-project/" . $project_details['id']; ?>" class="btn">
                                            <?php echo (!empty($user_language[$user_selected]['lg_edit_project'])) ? $user_language[$user_selected]['lg_edit_project'] : $default_language['en']['lg_edit_project']; ?>
                                        </a>
                                    <?php }
                                } ?>
                                <div class="seller-info2">
                                    <span class="seller-arrow"></span>
                                    <ul class="project-stats seller-stats">
                                        <li class="media seller-det">
                                            <?php
                                            $i_d = $user_profile['USERID'];
                                            $username = $user_profile['username'];
                                            $user_image = base_url() . 'assets/images/avatar-lg.jpg';
                                            if (!empty($user_profile['user_profile_image'])) {
                                                $user_image = base_url() . $user_profile['user_profile_image'];
                                            }
                                            if (!empty($user_profile['fullname'])) {
                                                $name = $user_profile['fullname'];
                                            }
                                            $result_count = array();
                                            if ($i_d != '') {
                                                $query_res = $this->db->query("SELECT AVG(feedback.rating) FROM `feedback`
                                                                   left join projects on projects.id = feedback.`gig_id`
                                                                    WHERE projects.user_id = $i_d AND feedback.`to_user_id` = $i_d;");
                                                $result_count = $query_res->row_array();
                                            }
                                            $rat_ing = 0;
                                            if (!empty($result_count)) {
                                                if ($result_count['AVG(feedback.rating)'] != '') {
                                                    $rat_ing = round($result_count['AVG(feedback.rating)']);
                                                }
                                            }
                                            ?>
                                            <div class="media-body">
                                                <div class="seller-country">
                                                    <img alt="" src="<?php echo $project_details['flag_icon']; ?>"
                                                         width="34" height="34">
                                                    <span class="ppcn country <?php echo $user_country_shortname; ?>"></span> <?php echo $user_country_name; ?>
                                                </div>
                                                <div class="seller-feedback feedback-area">
                                                    <span class="starrr" data-rating="<?php echo $rat_ing; ?>"></span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="seller-info">
                                <ul class="gig-stats seller-stats">
                                    <li class="seller-views">
                                        <img alt="views"
                                          src="<?php echo base_url() . "assets/images/view.png" ?>"
                                          width="34" height="34">
                                        <h5>
                                            <?php echo $project_details['total_views']; ?><?php echo (!empty($user_language[$user_selected]['lg_views'])) ? $user_language[$user_selected]['lg_views'] : $default_language['en']['lg_views']; ?>
                                        </h5>
                                    </li>
                                    <li class="seller-orders">
                                        <img alt="views"
                                           src="<?php echo base_url() . "assets/images/orders.png"; ?>"
                                           width="36" height="36">
                                        <h5>
                                            <?php echo $bid_data['count']; ?><?php echo (!empty($user_language[$user_selected]['lg_bids_in_queue'])) ? $user_language[$user_selected]['lg_bids_in_queue'] : $default_language['en']['lg_bids_in_queue']; ?>
                                        </h5>
                                    </li>

                                    <li class="seller-speaks">
                                        <img alt="views"
                                           src="<?php echo base_url() . "assets/images/speaks.png"; ?>"
                                           width="34" height="34">
                                        <h5>
                                            <?php echo (!empty($user_language[$user_selected]['lg_speaks'])) ? $user_language[$user_selected]['lg_speaks'] : $default_language['en']['lg_speaks']; ?>
                                            : <?php echo ucfirst($user_profile['language']); ?>
                                        </h5>
                                    </li>

                                    <?php

                                    if (!empty($project_tags)) { ?>
                                        <li class="related-topics">
                                            <div>
                                                <img alt="views" src="<?php echo base_url() . "assets/images/topics.png"; ?>">
                                                <h5><?php echo (!empty($user_language[$user_selected]['lg_related_topics'])) ? $user_language[$user_selected]['lg_related_topics'] : $default_language['en']['lg_related_topics']; ?></h5>
                                            </div>
                                            <p class="tags">
                                                <?php
                                                $tags = explode(',', $project_tags);
                                                foreach ($tags as $tag) { ?>
                                                    <a href="javascript:" onclick="tag_search('<?php echo $tag; ?>')"><?php echo ucfirst($tag); ?></a>
                                                <?php }
                                                ?>
                                            </p>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script type="text/javascript">
        var publishable_key = "<?php echo $publishable_key; ?>";
        function check_payment_type(e) {
            $('#payment_btn').show();
        }
    </script>





