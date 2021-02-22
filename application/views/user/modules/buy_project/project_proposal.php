<div class="">

    <?php //$this->load->view('user/includes/search_include');
        $select_project = $project_id;
    ?>
    <input type="hidden" id="session_user_id" value="<?php echo $session_user_data['USERID']; ?>">
    <input type="hidden" id="session_user_name" value="<?php echo $session_user_data['fullname']; ?>">
    <input type="hidden" id="session_user_avatar" value="<?php echo $session_user_data['user_thumb_image']; ?>">
    <section class="product-header">
        <div class="container">
            <?php
            $i = 0;
            if ($this->session->flashdata('message')) { ?>
                <div class="alert alert-success text-center fade in alert-dismissable" id="flash_succ_message">
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
                <?php
                $i = 1;
            } ?>

            <?php if ($this->session->userdata('message') && $i == 0) { ?>

                <div class="alert alert-success text-center fade in alert-dismissable" id="flash_succ_message">
                    <?php echo $this->session->userdata('message'); ?>
                </div>

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

                    <h2><?php echo ucfirst(str_replace("-", " ", $project_details['title'])); ?></h2>

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

                    <p class="gig-detail"><?php echo (!empty($user_language[$user_selected]['lg_created'])) ? $user_language[$user_selected]['lg_created'] : $default_language['en']['lg_created']; ?> <?php echo $time_taken; ?></p>

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
                            <a href="<?php echo base_url()."project-preview/".$project_id?>"class="sos-menu-item">
                            <?php
                                echo (!empty($user_language[$user_selected]['lg_details'])) ? $user_language[$user_selected]['lg_details'] : $default_language['en']['lg_details'];
                            ?>
                            </a>
                            <a href="javascript:;" class="sos-menu-item active">
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

                                            //  echo  " Your project "     ;

                                        } else {

                                            if ($already_marked == TRUE) { ?>

                                                <a href="javascript:;" onclick="remove_favourites('<?php echo $project_id; ?>','<?php echo $user_id; ?>')"> Saved </a>

                                            <?php } else { ?>

                                                <a href="javascript:;" onclick="add_favourites('<?php echo $project_id; ?>','<?php echo $user_id; ?>')">
                                                    <?php echo (!empty($user_language[$user_selected]['lg_save'])) ? $user_language[$user_selected]['lg_save'] : $default_language['en']['lg_save']; ?>
                                                </a>

                                            <?php }
                                        }
                                    } else { ?>

                                        <a href="javascript:;" onclick="selected_menu('sell_service')">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="top-pagination">
                        <ul class="pagination pagination-sm">
                            <li><?php echo $links; ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php
                        if (!empty($bid_datas)) {
                            foreach ($bid_datas as $item) {
                            ?>
                                <div class="sos-bid-info-up">
                                    <?php
                                    if($item['img_url'] == '') {
                                        $item['img_url'] = base_url() .'assets/images/avatar2.jpg';
                                    }
                                    else {
                                        $item['img_url'] = base_url() . $item['img_url'];
                                    }
                                    ?>
                                    <div class="sub-form-left">
                                        <input type="hidden" value = "<?php echo $item['user_id'] ?>">
                                        <input type="hidden" value = "<?php echo $item['user_name'] ?>">
                                        <input type="hidden" value = "<?php echo $item['user_avatar'] ?>">
                                        <input type="hidden" value = "<?php echo $item['img_url']; ?>">
                                        <input type="hidden" value = "<?php echo $item['user_name'] ?>">
                                        <input type="hidden" value = "<?php echo $item['country'] ?>">

                                        <div class="pro_img">
                                            <img src="<?php echo $item['img_url']; ?>" alt="" width="50" height="50"></a>
                                        </div>
                                        <div class="pull-left">
                                            <h4 class=""><?php echo $item['user_name'] ?></h4>
                                            <span class="order_date"><?php echo $item['date']; ?></span>
                                        </div>
                                        <div class="pull-left contact-container">
                                            <?php
                                            if($my_account_type == 2)
                                            {
                                             if($user_id == $project_details['user_id']) {
                                                if($project_details['award_bid'] > 0 )
                                                {
                                                    if($project_details['award_bid'] == $item['bid_id']){ ?>

                                                    <?php }
                                                }
                                                else { ?>
                                                    <a onclick="prepare_chat(this)" class="contact-title" href="javascript:;" >
                                                        <p><?php echo (!empty($user_language[$user_selected]['lg_contact_developer'])) ? $user_language[$user_selected]['lg_contact_developer'] : $default_language['en']['lg_contact_developer']; ?></p>
                                                    </a>
                                                <?php }
                                            }}?>
                                        </div>
                                    </div>
                                    <div class="sub-form-right">
                                        <h5 class="pull-right"><?php echo $item['amount'].$rate_symbol ?></h5>
                                        <h5 class="pull-right">In <?php echo $item['day']?>Days</h5>
                                    </div>
                                </div>
                                <div class="sos-bid-info-down">
                                    <div class="sos-form-detail">
                                        <h4 class="gig-desc-title"><?php echo (!empty($user_language[$user_selected]['lg_details'])) ? $user_language[$user_selected]['lg_details'] : $default_language['en']['lg_details']; ?></h4>
                                        <p><?php echo $item['proposal']?></p>
                                    </div>
                                    <div class="sos-form-button-container">
                                        <?php if($user_id == $project_details['user_id'] && $my_account_type ==2) {
                                            if($project_details['award_bid'] > 0 )
                                            {
                                                if($project_details['award_bid'] == $item['bid_id']){
                                                    if($item['bid_status'] == constant('PROJ_STAT_AWARD')){?>
                                                    <button disabled type="button" onclick="create_milestone_bid(<?php echo $item['bid_id'].','.$project_id; ?>)" class="btn btn-primary sos-form-button"><?php echo (!empty($user_language[$user_selected]['lg_create_milestone'])) ? $user_language[$user_selected]['lg_create_milestone'] : $default_language['en']['lg_create_milestone']; ?>
                                                    </button>
                                                <?php }
                                                    else if($item['bid_status'] == constant('PROJ_STAT_ACCEPT') || $item['bid_status'] == constant('PROJ_STAT_REQUEST_MILESTONE')){?>
                                                        <button type="button" onclick="create_milestone_bid(<?php echo $item['bid_id'].','.$project_id.', \''.$project_details['title'].'\' , \''.$project_details['currency_type'].'\'' ; ?>)" class="btn btn-primary sos-form-button"><?php echo (!empty($user_language[$user_selected]['lg_create_milestone'])) ? $user_language[$user_selected]['lg_create_milestone'] : $default_language['en']['lg_create_milestone']; ?>
                                                        </button>
                                                <?php }
                                                    else if($item['bid_status'] == constant('PROJ_STAT_CREATE_MILESTONE')){?>
                                                        <button type="button" onclick="release_bid(<?php echo $item['bid_id'].','.$project_id; ?>)" class="btn btn-primary sos-form-button"><?php echo (!empty($user_language[$user_selected]['lg_release'])) ? $user_language[$user_selected]['lg_release'] : $default_language['en']['lg_release']; ?></button>
                                                        <button type="button" onclick="cancel_bid(<?php echo $item['bid_id'].','.$project_id; ?>)" class="btn btn-primary sos-form-button">Cancel Project</button>
                                                <?php }
                                                }
                                            }
                                            else{?>
                                                <button type="button" onclick="award_bid(<?php echo $item['bid_id'].','.$project_id; ?>)" class="btn btn-primary sos-form-button"><?php echo (!empty($user_language[$user_selected]['lg_award'])) ? $user_language[$user_selected]['lg_award'] : $default_language['en']['lg_award']; ?>
                                                </button>
                                            <?php }
                                        }
                                        else if($my_account_type == 1){
                                            if($user_id == $item['user_id']){
                                                if($item['bid_status'] == NULL || $item['bid_status'] == constant('PROJ_STAT_AWARD')){?>
                                                <a href="<?php echo base_url()."project-preview/".$project_id."/true"?>" class="btn btn-primary sos-form-button"><?php echo (!empty($user_language[$user_selected]['lg_edit'])) ? $user_language[$user_selected]['lg_edit'] : $default_language['en']['lg_edit']; ?>
                                                </a>
                                            <?php }
                                            if($item['bid_status'] == constant('PROJ_STAT_AWARD')){?>
                                                <button type="button" onclick="accept_bid(<?php echo $item['bid_id'].','.$project_id; ?>)" class="btn btn-primary sos-form-button"><?php echo (!empty($user_language[$user_selected]['lg_accept'])) ? $user_language[$user_selected]['lg_accept'] : $default_language['en']['lg_accept']; ?>
                                                </button>
                                            <?php }
                                            else if($item['bid_status'] == constant('PROJ_STAT_ACCEPT') || $item['bid_status'] == constant('PROJ_STAT_REQUEST_MILESTONE')){?>
                                                <button type="button" onclick="request_milestone_bid(<?php echo $item['bid_id'].','.$project_id; ?>)" class="btn btn-primary sos-form-button"><?php echo (!empty($user_language[$user_selected]['lg_request_milestone'])) ? $user_language[$user_selected]['lg_request_milestone'] : $default_language['en']['lg_request_milestone']; ?>
                                                </button>
                                            <?php }
                                            }
                                        }?>
                                    </div>
                                </div>
                            <?php
                            } 
                        } else { 
                        ?>
                            <div class="preview-box">
                                <h3 class="gig-desc-title"><?php echo (!empty($user_language[$user_selected]['lg_nobody_bidded'])) ? $user_language[$user_selected]['lg_nobody_bidded'] : $default_language['en']['lg_nobody_bidded']; ?>
                                </h3>
                            </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="bottom-pagination">
                        <ul class="pagination pagination-sm">
                            <li><?php echo $links; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="checkout-popup" class="modal fade custom-popup order-popup" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-header text-center">
                    <h4 class="sign-title">Buy Membership</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url() . 'user/projects/payment'; ?>" method="post" id="payment_formid" name="payment_submit">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <input type="hidden" name="project_id" id="project_id" />
                                <div id="project_title" style="font-size: 18px; color: #777; font-weight: 500;"></div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="project_price" id="project_price" value="" placeholder="Enter Price" min="0" required />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <input type="hidden" name="project_currency" id="project_currency" value=""/>
                                <div id="project_currency_title" style="font-size: 18px; color: #777; font-weight: 500;"></div>
                            </div>
                            <input type="hidden" name="bid_id" id="bid_id" value="">
                            <input type="hidden" name="access_token" id="" value="">
                            <div class="col-md-12">
                                <div id="payment-method">
                                    <h4 class="clearfix">
                                        <?php echo (!empty($user_language[$user_selected]['lg_select_your_payment_method'])) ? $user_language[$user_selected]['lg_select_your_payment_method'] : $default_language['en']['lg_select_your_payment_method']; ?>
                                    </h4>
                                    <div class="payment-method">
                                        <?php if ($paypal_allow == 1) { ?>
                                            <label class="radio-inline bold">
                                                <input class="le-radio" type="radio" onchange="check_payment_type(this)" name="group2" value="paypal">
                                                <img src="<?php echo base_url(); ?>assets/images/paypal-icon.png"
                                                     alt="Paypal" width="24"
                                                     height="22">
                                                <?php echo (!empty($user_language[$user_selected]['lg_paypal'])) ? $user_language[$user_selected]['lg_paypal'] : $default_language['en']['lg_paypal']; ?>
                                            </label>
                                        <?php } ?>

                                    </div>
                                </div>
                                <div>
                                    <button type="submit" id="payment_btn" style="display: none;" class="btn btn-green buyitnow-btn" value="true" name="submit">
                                        <?php echo (!empty($user_language[$user_selected]['lg_buy_it_now'])) ? $user_language[$user_selected]['lg_buy_it_now'] : $default_language['en']['lg_buy_it_now']; ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer text-left">
                    <div class="media secure-money">
                        <div class="media-left">
                            <img width="46" height="40" src="<?php echo base_url(); ?>assets/images/secure-money.png" alt="">
                        </div>
                        <div class="media-body">
                            <span><?php echo (!empty($user_language[$user_selected]['lg_your_deposit_will_be_securely_held_in_escrow_until_you_are_happy_to_release_it_to_the_seller_upon_hourlie_completion'])) ? $user_language[$user_selected]['lg_your_deposit_will_be_securely_held_in_escrow_until_you_are_happy_to_release_it_to_the_seller_upon_hourlie_completion'] : $default_language['en']['lg_your_deposit_will_be_securely_held_in_escrow_until_you_are_happy_to_release_it_to_the_seller_upon_hourlie_completion']; ?>.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="message-popup" class="modal fade custom-popup" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="modal-body">
                    <div class="msg-user-details">
                        <div class="pull-left user-img m-r-10">
                            <img id="message_img" src="" alt="" class="w-40 img-circle" width="50" height="50">
                            <span class="online"></span>
                        </div>
                        <div class="user-info pull-left">
                            <div class="dropdown">
                                <a id="message_name" href="javascript:;"></a>
                            </div>
                            <p id="message_country" class="text-muted m-0"></p>
                        </div>
                    </div>
                    <div class="new-message">
                        <div id="_error_" class="text-danger"></div>
                        <form id="form_messagecontent_id" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="to_user_id" id="to_user_id" value=""/>
                            <input type="hidden" name="to_user_name" id="to_user_name" value=""/>
                            <input type="hidden" name="to_user_avatar" id="to_user_avatar" value=""/>
                            <div class="form-group">
                                <label class="form-label">
                                    <?php echo (!empty($user_language[$user_selected]['lg_your_message'])) ? $user_language[$user_selected]['lg_your_message'] : $default_language['en']['lg_your_message']; ?>
                                </label>
                                <textarea name="chat_message_content" placeholder="Message to <?php echo $name; ?>" required="" id="messageone" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-style" onclick="save_newchat();">
                        <?php echo (!empty($user_language[$user_selected]['lg_send'])) ? $user_language[$user_selected]['lg_send'] : $default_language['en']['lg_send']; ?>
                    </button>
                </div>

            </div>

        </div>

    </div>

<script type="text/javascript">
    var BASE_URL = "<?php echo base_url(); ?>";

    function award_bid(bid_id, project_id) {
        swal({
            text: "Are you sure you want to award this Proposal?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                $.post(BASE_URL + 'project-proposals/award', {bid_id: bid_id, project_id: project_id}, function (result) {
                    if (result) {
                        location.reload();
                    }
                });
            }
        })
    }

    function accept_bid(bid_id, project_id) {
        swal({
            text: "Are you sure you want to accept this Proposal?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                $.post(BASE_URL + 'project-proposals/accept', {bid_id: bid_id, project_id: project_id}, function (result) {
                    if (result) {
                        location.reload();
                    }
                });
            }
        })
    }

    function create_milestone_bid(bid_id, project_id, project_title, project_currency) {

        $currency_balance = 0;
        $.ajax({
            type: 'POST',
            url: BASE_URL + 'project-proposals/validate_balances',
            data: {
                bid_id: bid_id,
                project_id: project_id,
                project_currency: project_currency
            }
            datatype: 'json',
            success: function(result) {
                if($result = 1) {
                    $.post(BASE_URL + 'project-proposals/create_milestone', {bid_id: bid_id, project_id: project_id}, function (result) {
                        if (result) {
                            location.reload();
                        }
                    });
                }
                else {
                    $("#bid_id").val(bid_id);
                    $("#project_id").val(project_id);
                    $("#project_title").text(project_title);
                    $("#project_currency").val(project_currency);
                    $("#project_currency_title").text(project_currency);

                    $("#checkout-popup").modal();
                }
            }
        })
    }

    function request_milestone_bid(bid_id, project_id) {
        swal({
            text: "Are you sure you are going to request Milestone?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                $.post(BASE_URL + 'project-proposals/request_milestone', {bid_id: bid_id, project_id: project_id}, function (result) {
                    if (result == 'success') {
                        location.reload();
                    }
                });
            }
        })
    }

    function release_bid(bid_id, project_id) {
        swal({
            text: "Are you sure you are going to release project?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                $.post(BASE_URL + 'project-proposals/release', {bid_id: bid_id, project_id: project_id}, function (result) {
                    if (result) {
                        location.reload();
                    }
                });
            }
        })
    }

    function cancel_bid(bid_id, project_id) {
        swal({
            text: "Are you sure you are going to cancel this project?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                $.post(BASE_URL + 'project-proposals/cancel', {bid_id: bid_id, project_id: project_id}, function (result) {
                    if (result) {
                        location.reload();
                    }
                });
            }
        })
    }

    function prepare_chat(eChat_Button)
    {
        var eDiv = eChat_Button.closest(".sub-form-left");
        document.getElementById("to_user_id").value = eDiv.children[0].value;
        document.getElementById("to_user_name").value = eDiv.children[1].value;
        document.getElementById("to_user_avatar").value = eDiv.children[2].value;

        document.getElementById("message_img").setAttribute("src", eDiv.children[3].value);
        document.getElementById("message_name").innerHTML = eDiv.children[4].value;
        document.getElementById("message_country").innerHTML = eDiv.children[5].value;
        $("#message-popup").modal();
    }

    function check_payment_type(e) {
        $('#payment_btn').show();
    }
</script>
