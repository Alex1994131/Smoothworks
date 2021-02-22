<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php

    $base_url = base_url();

    $fav = base_url() . 'assets/images/favicon.png';
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $meta_title = $meta_keywords = $meta_description = '';
    $gigs_payment_option = '';
    $website_email = 'admin@dreamguys.co.in';
    $this->site_name = '';
    if (!empty($result)) {
        $sitename = $meta_keywords = $meta_description = '';
        foreach ($result as $data) {
            if ($data['key'] == 'website_slogan') {
                $website_slogan = $data['value'];
            }

            if ($data['key'] == 'logo_front') {
                $logo_front = $data['value'];
            }

            if ($data['key'] == 'meta_title') {
                $meta_title = $data['value'];
            }
            if ($data['key'] == 'meta_keywords') {
                $meta_keywords = $data['value'];

            }
            if ($data['key'] == 'site_name' || $data['key'] == 'website_name') {
                $website_name = $data['value'];
                $this->site_name = $data['value'];
            }
            if ($data['key'] == 'meta_description') {
                $meta_description = $data['value'];
            }
            if ($data['key'] == 'favicon') {
                $favicon = $data['value'];
            }
            if ($data['key'] == 'website_email') {
                $website_email = $data['value'];
            }
            if ($data['key'] == 'website_contactno') {
                $website_contactno = $data['value'];
            }

            if ($data['key'] == 'website_facebook_app_id') {
                $website_facebook_app_id = $data['value'];
            }

            if ($data['key'] == 'website_google_client_id') {
                $website_google_client_id = $data['value'];
            }

            if ($data['key'] == 'website_google_client_id') {
                $website_google_client_id = $data['value'];
            }

            if ($data['key'] == 'gigs_payment_option') {
                $gigs_payment_option = $data['value'];
            }
        }
    }
    if (!empty($favicon)) {
        $fav = base_url() . 'uploads/logo/' . $favicon;
    }
    ?>
    <title><?php echo $meta_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="keywords" content="<?php echo $meta_keywords; ?>">
    <link rel="shortcut icon" href="<?php echo $fav; ?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.firebase.com/libs/firechat/3.0.1/firechat.min.css"/>

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/owl.theme.default.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/select2.min.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/sweetalert2.css" rel="stylesheet" type="text/css" >
    <link href="<?php echo base_url(); ?>assets/css/morris.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/cropper.min.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-tokenfield.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/tokenfield-typeahead.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-tagsinput.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/css/fix-home.css" rel="stylesheet" type="text/css"/>
    
    <?php
    $default_language_select = default_language();

    if ($this->session->userdata('user_select_language') == '') {
        if ($default_language_select['tag'] == 'ltr' || $default_language_select['tag'] == '') {
            echo '<link href="' . base_url() . 'assets/css/app.css" rel="stylesheet" />';
        } elseif ($default_language_select['tag'] == 'rtl') {
            echo '<link href="' . base_url() . 'assets/css/bootstrap-rtl.min.css" media="screen" rel="stylesheet" type="text/css" />';
            echo '<link href="' . base_url() . 'assets/css/app-rtl.css" rel="stylesheet" />';
        }
    } else {
        if ($this->session->userdata('tag') == 'ltr' || $this->session->userdata('tag') == '') {
            echo '<link href="' . base_url() . 'assets/css/app.css" rel="stylesheet" />';
        } elseif ($this->session->userdata('tag') == 'rtl') {
            echo '<link href="' . base_url() . 'assets/css/bootstrap-rtl.min.css" media="screen" rel="stylesheet" type="text/css" />';
            echo '<link href="' . base_url() . 'assets/css/app-rtl.css" rel="stylesheet" />';
        }
    }

    echo '<link href="' . base_url() . 'assets/css/custom.css" rel="stylesheet" />';
    ?>

    <?php include_once('script_message.php'); ?>

    <script src="<?php echo base_url(); ?>assets/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
    <script data-ad-client="ca-pub-4331142018966935" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
<div id="main-wrapper">
    <?php
    if ($this->session->userdata('SESSION_USER_ID')) {
        $user_id = $this->session->userdata('SESSION_USER_ID');
        $query = $this->db->query("SELECT `username` , user_thumb_image , fullname FROM `members` WHERE `USERID` = $user_id ");
        $result = $query->row_array();
        $header_username = $result['username'];
        $header_user_image = base_url() . "assets/images/avatar2.jpg";
        if ($result['user_thumb_image'] != '') {
            $header_user_image = base_url() . $result['user_thumb_image'];
        }
        $header_user_fullname = $result['fullname'];
        ?>
        <input type="hidden" name="session_user_id" id="session_user_id" value="<?php echo $user_id; ?>">
    <?php }
    ?>
    <header class="header" id="header">
        <div class="header-top">
            <div class="container hidden-xs">
                <div class="row">
                    <div class="col-sm-5 col-xs-8">
                        <div class="header-info">
                            <a href="javascript:void(0);">
                                <?php
                                if (!empty($website_contactno)) {
                                    echo '<i class="fa fa-phone"></i> <span><strong> ' . $website_contactno . '</strong></span>';
                                }
                                ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-7 col-xs-4">
                        <div class="lang-dropdown">
                            <div class="dropdown pull-right">
                                <?php
                                if ($this->session->userdata('user_select_language') == '') {
                                    $lang = $default_language_select['language_value'];
                                } else {
                                    $lang = $this->session->userdata('user_select_language');
                                }

                                ?>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $lang; ?>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($active_language as $active) { ?>
                                        <li>
                                            <a href="javascript:;" onclick="change_language(this)"
                                               lang_tag="<?php echo $active['tag']; ?>"
                                               lang="<?php echo $active['language_value']; ?>"
                                                <?php if ($active['language_value'] == $lang) {
                                                    echo "selected";
                                                } ?>>
                                                <img height=14 width=20 src=<?php echo $active['flag'] ?>>
                                                <?php echo ucfirst($active['language']); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-bar">
            <div class="container">
                <div class="header-style">
                    <div class="header-logo">
                        <a href="<?php echo base_url(); ?>">
                            <img class="img img-responsive" style="height: 30px" src="<?php echo $base_url . $logo_front ?>" alt="Brand Logo">
                        </a>
                    </div>
                    <nav id="menu-navigation" class="main-menu">
                        <input type="hidden" id="selected_menu" name="selected_menu" value="">
                        <ul class="nav navbar navbar-static-top">
                            <?php if (($this->session->userdata('SESSION_USER_ID'))) { ?>
                                <li id="menu-1" class="menu-1 <?php if ($module == 'welcome') echo 'active'; ?>">
                                    <a href="<?php echo base_url(); ?>">
                                        <?php echo (!empty($user_language[$user_selected]['lg_welcome'])) ? $user_language[$user_selected]['lg_welcome'] : $default_language['en']['lg_welcome']; ?>
                                    </a>
                                </li>

                                <?php 
                                    $user_id = $this->session->userdata('SESSION_USER_ID');
                                    $query = $this->db->query('select * from members where USERID = ' . $user_id);
                                    $result = $query->result_array();
                                    $service = $result[0]['service'];
                                ?>
                                
                                <?php if ($this->session->userdata('account_type') == 1 && $service != 0) { ?>
                                <li id="menu-2" class="dropdown menu-2 <?php if ($module == 'sell_gigs' || $module == 'sell_project') echo 'active'; ?>">
                                    <a href="javascript:void(0);">
                                        <?php echo (!empty($user_language[$user_selected]['lg_sell'])) ? $user_language[$user_selected]['lg_sell'] : $default_language['en']['lg_sell']; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ($this->session->userdata('account_type') == 1 && $this->session->userdata('membership_id') != 0) { ?>
                                            <li>
                                                <a href="<?php echo base_url() . 'add-gigs'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_sell_service'])) ? $user_language[$user_selected]['lg_sell_service'] : $default_language['en']['lg_sell_service']; ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('account_type') == 2 && $this->session->userdata('membership_id') != 0) { ?>
                                            <li>
                                                <a href="<?php echo base_url() . 'add-project'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_sell_project'])) ? $user_language[$user_selected]['lg_sell_project'] : $default_language['en']['lg_sell_project']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>

                                <li id="menu-3" class="dropdown menu-3 <?php if ($module == 'buy_gigs' || $module == 'buy_project') echo 'active'; ?>">
                                    <a href="javascript:void(0)">
                                        <?php echo (!empty($user_language[$user_selected]['lg_buy'])) ? $user_language[$user_selected]['lg_buy'] : $default_language['en']['lg_buy']; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo base_url() . 'buy-gigs'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_buy_service'])) ? $user_language[$user_selected]['lg_buy_service'] : $default_language['en']['lg_buy_service']; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() . 'buy-project'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_buy_project'])) ? $user_language[$user_selected]['lg_buy_project'] : $default_language['en']['lg_buy_project']; ?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="menu-4" class="dropdown menu-4 <?php if ($module == 'my_gigs' || $module == 'my_project') echo 'active'; ?>">
                                    <a href="javascript: void(0)">
                                        <?php echo (!empty($user_language[$user_selected]['lg_my_works'])) ? $user_language[$user_selected]['lg_my_works'] : $default_language['en']['lg_my_works']; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo base_url() . 'my-project'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_my_projects'])) ? $user_language[$user_selected]['lg_my_projects'] : $default_language['en']['lg_my_projects']; ?></a>
                                        </li>

                                        <?php if ($this->session->userdata('account_type') == 1) { ?>
                                            <li>
                                                <a href="<?php echo base_url() . 'my-gigs'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_my_gigs'])) ? $user_language[$user_selected]['lg_my_gigs'] : $default_language['en']['lg_my_gigs']; ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('account_type') == 2) { ?>
                                            <li>
                                                <a href="<?php echo base_url() . 'favourites'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_my_favorites_gigs'])) ? $user_language[$user_selected]['lg_my_favorites_gigs'] : $default_language['en']['lg_my_favorites_gigs']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li id="menu-5" class="dropdown menu-5 <?php if ($module == 'message') echo 'active'; ?>">
                                    <a href="<?php echo base_url() . 'message'; ?>">
                                        <?php echo (!empty($user_language[$user_selected]['lg_messages'])) ? $user_language[$user_selected]['lg_messages'] : $default_language['en']['lg_messages']; ?>
                                        <span class="badge badge-success pull-right" id="new_message_count" style="display: none;"></span>
                                    </a>
                                    <div id="message_notification"></div>
                                </li>
                                <li id="menu-6" class="dropdown menu-6 <?php if ($module == 'notification') echo 'active'; ?>">
                                    <a href="<?php echo base_url() . 'notification'; ?>">
                                        <?php echo (!empty($user_language[$user_selected]['lg_alerts'])) ? $user_language[$user_selected]['lg_alerts'] : $default_language['en']['lg_alerts']; ?>
                                        <span id="notification_count" class="badge badge-success pull-right" style="display: none"> </span>
                                    </a>
                                    <div id="notification_notification"></div>
                                </li>
                                <li id="menu-7" class="dropdown menu-7 <?php if ($module == 'password' || $module == 'profile' || $module == 'payment') echo 'active'; ?> ">
                                    <a href="<?php echo base_url() . 'password'; ?>">
                                        <?php echo (!empty($user_language[$user_selected]['lg_settings'])) ? $user_language[$user_selected]['lg_settings'] : $default_language['en']['lg_settings']; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo base_url() . 'password'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_account_settings'])) ? $user_language[$user_selected]['lg_account_settings'] : $default_language['en']['lg_account_settings']; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() . 'profile'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_profile_settings'])) ? $user_language[$user_selected]['lg_profile_settings'] : $default_language['en']['lg_profile_settings']; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() . 'payment'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_payment_settings'])) ? $user_language[$user_selected]['lg_payment_settings'] : $default_language['en']['lg_payment_settings']; ?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="menu-8" class="dropdown menu-8 <?php if ($module == 'transactions' || $module == 'user_profile' || $module == 'membership' || $module == 'team_management' || $module == 'invite_friend' || $module == 'balances') echo 'active'; ?> ">
                                    <a href="<?php echo base_url() . 'user-profile/' . $header_username; ?>">
                                        <img class="menu-pro-img" src="<?php echo $header_user_image; ?>" alt="<?php echo $header_user_fullname; ?>" title="<?php echo $header_user_fullname; ?>" width="50" height="50">
                                        <?php echo (!empty($user_language[$user_selected]['lg_profile'])) ? $user_language[$user_selected]['lg_profile'] : $default_language['en']['lg_profile']; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if($this->session->userdata('team_id') != 0 && $this->session->userdata('account_type') == 1) {
                                            if($this->session->userdata('account_state') == 1) {
                                                ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="change_account(1)">To Team Account</a>
                                                </li>
                                            <?php } else {?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="change_account(2)">To Freelancer Account</a>
                                                </li>
                                        <?php }} ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'user-profile/' . $header_username; ?>"><?php echo (!empty($user_language[$user_selected]['lg_my_profile'])) ? $user_language[$user_selected]['lg_my_profile'] : $default_language['en']['lg_my_profile']; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() . 'invite-friend'; ?>">Invite Friend</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() . 'transactions'; ?>">Transaction History</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() . 'balances'; ?>">My Balances</a>
                                        </li>
                                        <?php if ($this->session->userdata('account_type') == 1 && $this->session->userdata('membership_id') != 0 && $this->session->userdata('team_id') != 0) { ?>
                                            <li>
                                                <a href="<?php echo base_url() . 'team_management'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_team_management'])) ? $user_language[$user_selected]['lg_team_management'] : $default_language['en']['lg_team_management']; ?></a>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'membership'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_membership'])) ? $user_language[$user_selected]['lg_membership'] : $default_language['en']['lg_membership']; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() . 'logout'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_log_out'])) ? $user_language[$user_selected]['lg_log_out'] : $default_language['en']['lg_log_out']; ?></a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li id="menu-1" class="menu-1 <?php if ($module == 'welcome') echo 'active'; ?> ">
                                    <a href="<?php echo base_url(); ?>">
                                        <?php echo (!empty($user_language[$user_selected]['lg_welcome'])) ? $user_language[$user_selected]['lg_welcome'] : $default_language['en']['lg_welcome']; ?>
                                    </a>
                                </li>
                                <li id="menu-2" class="menu-2">
                                    <a href="javascript:;" onclick="selected_menu('sell-service')">
                                        <?php echo (!empty($user_language[$user_selected]['lg_sell'])) ? $user_language[$user_selected]['lg_sell'] : $default_language['en']['lg_sell']; ?>
                                    </a>
                                </li>
                                <li id="menu-3"
                                    class="dropdown menu-3 <?php if ($module == 'buy_gigs' || $module == 'buy_project') echo 'active'; ?>">
                                    <a href="javascript:;">
                                        <?php echo (!empty($user_language[$user_selected]['lg_buy'])) ? $user_language[$user_selected]['lg_buy'] : $default_language['en']['lg_buy']; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo base_url() . 'buy-gigs'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_buy_service'])) ? $user_language[$user_selected]['lg_buy_service'] : $default_language['en']['lg_buy_service']; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() . 'buy-project'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_buy_project'])) ? $user_language[$user_selected]['lg_buy_project'] : $default_language['en']['lg_buy_project']; ?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="menu-4" class="menu-4">
                                    <a href="javascript:;" onclick="selected_menu('mywork')">
                                        <?php echo (!empty($user_language[$user_selected]['lg_my_works'])) ? $user_language[$user_selected]['lg_my_works'] : $default_language['en']['lg_my_works']; ?>
                                    </a>
                                </li>
                                <li id="menu-5" class="menu-5">
                                    <a href="javascript:;" onclick="selected_menu('message')">
                                        <?php echo (!empty($user_language[$user_selected]['lg_messages'])) ? $user_language[$user_selected]['lg_messages'] : $default_language['en']['lg_messages']; ?>
                                    </a>
                                </li>
                                <li id="menu-6" class="dropdown menu-6">
                                    <a href="javascript:;" onclick="selected_menu('notification')">
                                        <?php echo (!empty($user_language[$user_selected]['lg_alerts'])) ? $user_language[$user_selected]['lg_alerts'] : $default_language['en']['lg_alerts']; ?>
                                    </a>
                                </li>
                                <li id="menu-7" class="menu-7">
                                    <a href="javascript:;" onclick="selected_menu('password')">
                                        <?php echo (!empty($user_language[$user_selected]['lg_settings'])) ? $user_language[$user_selected]['lg_settings'] : $default_language['en']['lg_settings']; ?>
                                    </a>
                                </li>
                                <li id="menu-8" class="dropdown menu-8 login-img">
                                    <a href="#" data-toggle="modal" data-target="#login-popup">
                                        <?php echo (!empty($user_language[$user_selected]['lg_log_in'])) ? $user_language[$user_selected]['lg_log_in'] : $default_language['en']['lg_log_in']; ?>
                                    </a>
                                </li>

                                <li id="menu-9" class="dropdown menu-9 login-img">
                                    <a href="#" data-toggle="modal" data-target="#register-popup"
                                       style="background-color: #37a000; color: white; border-radius: 4px; padding-top: 0px; padding-bottom: 0px; padding-right: 11px; padding-left: 11px; margin-top: 10px;">
                                        Sign Up
                                    </a>
                                </li>

                            <?php } ?>
                        </ul>
                    </nav>
                </div>
                <div class="sidebar">
                    <?php if (($this->session->userdata('SESSION_USER_ID'))) { ?>
                        <div class="sidebar-inner slimscroll">
                            <a href="#" id="close_menu"><i class="fa fa-close"></i></a>
                            <ul class="mobile-menu-wrapper">
                                <li class="<?php if ($module == 'welcome') echo 'active'; ?>">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="<?php echo base_url(); ?>">
                                            <?php echo (!empty($user_language[$user_selected]['lg_welcome'])) ? $user_language[$user_selected]['lg_welcome'] : $default_language['en']['lg_welcome']; ?>
                                        </a>
                                    </div>
                                </li>

                                <li class="<?php if ($module == 'sell_gigs' || $module == 'sell_project') echo 'active'; ?> ">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:void(0)">
                                            <?php echo (!empty($user_language[$user_selected]['lg_sell'])) ? $user_language[$user_selected]['lg_sell'] : $default_language['en']['lg_sell']; ?>
                                            <i class="fa fa-chevron-down menu-toggle"></i>
                                        </a>
                                    </div>
                                    <ul class="mobile-submenu-wrapper">
                                        <?php if ($this->session->userdata('account_type') == 1 && $this->session->userdata('membership_id') != 0) { ?>
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'sell-service'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_sell_service'])) ? $user_language[$user_selected]['lg_sell_service'] : $default_language['en']['lg_sell_service']; ?>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('account_type') == 2 && $this->session->userdata('membership_id') != 0) { ?>
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'sell-project'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_sell_project'])) ? $user_language[$user_selected]['lg_sell_project'] : $default_language['en']['lg_sell_project']; ?>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                <li class="<?php if ($module == 'buy_gigs' || $module == 'buy_gigs') echo 'active'; ?> ">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:void(0)">
                                            <?php echo (!empty($user_language[$user_selected]['lg_buy'])) ? $user_language[$user_selected]['lg_buy'] : $default_language['en']['lg_buy']; ?>
                                            <i class="fa fa-chevron-down menu-toggle"></i>
                                        </a>
                                    </div>
                                    <ul class="mobile-submenu-wrapper">
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'buy-gigs'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_buy_service'])) ? $user_language[$user_selected]['lg_buy_service'] : $default_language['en']['lg_buy_service']; ?>
                                            </a>
                                        </li>
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'buy-project'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_buy_project'])) ? $user_language[$user_selected]['lg_buy_project'] : $default_language['en']['lg_buy_project']; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="<?php if ($module == 'my_gigs' || $module == 'my_project') echo 'active'; ?>">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:void(0)">
                                            <?php echo (!empty($user_language[$user_selected]['lg_my_works'])) ? $user_language[$user_selected]['lg_my_works'] : $default_language['en']['lg_my_works']; ?>
                                            <i class="fa fa-chevron-down menu-toggle"></i>
                                        </a>
                                    </div>
                                    <ul class="mobile-submenu-wrapper">
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'my-project'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_my_projects'])) ? $user_language[$user_selected]['lg_my_projects'] : $default_language['en']['lg_my_projects']; ?></a>
                                        </li>

                                        <?php if ($this->session->userdata('account_type') == 1) { ?>
                                            <li class="nav-row">
                                                <a href="<?php echo base_url() . 'my-gigs'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_my_gigs'])) ? $user_language[$user_selected]['lg_my_gigs'] : $default_language['en']['lg_my_gigs']; ?></a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('account_type') == 2) { ?>
                                            <li class="nav-row">
                                                <a href="<?php echo base_url() . 'favourites'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_my_favorites_gigs'])) ? $user_language[$user_selected]['lg_my_favorites_gigs'] : $default_language['en']['lg_my_favorites_gigs']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="<?php if ($module == 'message') echo 'active'; ?>">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="<?php echo base_url() . 'message'; ?>">
                                            <?php echo (!empty($user_language[$user_selected]['lg_messages'])) ? $user_language[$user_selected]['lg_messages'] : $default_language['en']['lg_messages']; ?>
                                        </a>
                                    </div>
                                </li>
                                <li class="<?php if ($module == 'notification') echo 'active'; ?>">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="<?php echo base_url() . 'notification'; ?>">
                                            <?php echo (!empty($user_language[$user_selected]['lg_alerts'])) ? $user_language[$user_selected]['lg_alerts'] : $default_language['en']['lg_alerts']; ?>
                                        </a>
                                    </div>
                                </li>
                                <li class="<?php if ($module == 'password' || $module == 'profile') echo 'active'; ?>">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="<?php echo base_url() . 'password'; ?>">
                                            <?php echo (!empty($user_language[$user_selected]['lg_settings'])) ? $user_language[$user_selected]['lg_settings'] : $default_language['en']['lg_settings']; ?>
                                            <i class="fa fa-chevron-down menu-toggle"></i>
                                        </a>
                                    </div>
                                    <ul class="mobile-submenu-wrapper">
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'password'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_account_settings'])) ? $user_language[$user_selected]['lg_account_settings'] : $default_language['en']['lg_account_settings']; ?>
                                            </a>
                                        </li>
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'profile'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_profile_settings'])) ? $user_language[$user_selected]['lg_profile_settings'] : $default_language['en']['lg_profile_settings']; ?>
                                            </a>
                                        </li>
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'payment-settings'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_payment_settings'])) ? $user_language[$user_selected]['lg_payment_settings'] : $default_language['en']['lg_payment_settings']; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="<?php if ($module == 'transactions' || $module == 'user_profile' || $module == 'membership' || $module == 'team_management' || $module == 'invite_friend' || $module == 'balances') echo 'active'; ?>">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="<?php echo base_url() . 'user-profile/' . $header_username; ?>">
                                            <img class="mobile-user-img" src="<?php echo $header_user_image; ?>"
                                                 alt="<?php echo $header_user_fullname; ?>"
                                                 title="<?php echo $header_user_fullname; ?>" width="50"
                                                 height="50"> <?php echo (!empty($user_language[$user_selected]['lg_profile'])) ? $user_language[$user_selected]['lg_profile'] : $default_language['en']['lg_profile']; ?>
                                            <i class="fa fa-chevron-down menu-toggle"></i>
                                        </a>
                                    </div>
                                    <?php if ($this->session->userdata('SESSION_USER_ID')) {
                                        ?>
                                        <ul class="mobile-submenu-wrapper">
                                            <?php if($this->session->userdata('team_id') != 0 && $this->session->userdata('account_type') == 1) {
                                                if($this->session->userdata('account_state') == 1) {
                                            ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="change_account(1)">To Team Account</a>
                                                </li>
                                            <?php } else {?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="change_account(2)">To Freelancer Account</a>
                                                </li>
                                            <?php }} ?>
                                            <li>
                                                <a href="<?php echo base_url() . 'user-profile/' . $header_username; ?>"><?php echo (!empty($user_language[$user_selected]['lg_my_profile'])) ? $user_language[$user_selected]['lg_my_profile'] : $default_language['en']['lg_my_profile']; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url() . 'invite-friend'; ?>">Invite Friend</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url() . 'transactions'; ?>">Transaction History</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url() . 'balances'; ?>">My Balance</a>
                                            </li>
                                            <?php if ($this->session->userdata('account_type') == 1 && $this->session->userdata('membership_id') != 0) { ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'team_management'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_team_management'])) ? $user_language[$user_selected]['lg_team_management'] : $default_language['en']['lg_team_management']; ?></a>
                                                </li>
                                            <?php } ?>
                                            <li>
                                                <a href="<?php echo base_url() . 'membership'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_membership'])) ? $user_language[$user_selected]['lg_membership'] : $default_language['en']['lg_membership']; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url() . 'logout'; ?>"><?php echo (!empty($user_language[$user_selected]['lg_log_out'])) ? $user_language[$user_selected]['lg_log_out'] : $default_language['en']['lg_log_out']; ?></a>
                                            </li>
                                        </ul>

                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <div class="sidebar-inner slimscroll">
                            <a href="#" id="close_menu"><i class="fa fa-close"></i></a>
                            <ul class="mobile-menu-wrapper">
                                <li class="<?php if ($module == 'welcome') echo 'active'; ?>">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="<?php echo base_url(); ?>">
                                            <?php echo (!empty($user_language[$user_selected]['lg_welcome'])) ? $user_language[$user_selected]['lg_welcome'] : $default_language['en']['lg_welcome']; ?>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:;" onclick="selected_menu('sell-service')">
                                            <?php echo (!empty($user_language[$user_selected]['lg_sell'])) ? $user_language[$user_selected]['lg_sell'] : $default_language['en']['lg_sell']; ?>
                                        </a>
                                    </div>
                                </li>
                                <li class="<?php if ($module == 'buy_gigs' || $module == 'buy_project') echo 'active'; ?> ">
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:void(0)">
                                            <?php echo (!empty($user_language[$user_selected]['lg_buy'])) ? $user_language[$user_selected]['lg_buy'] : $default_language['en']['lg_buy']; ?>
                                            <i class="fa fa-chevron-down menu-toggle"></i>
                                        </a>
                                    </div>
                                    <ul class="mobile-submenu-wrapper">
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'buy-gigs'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_buy_service'])) ? $user_language[$user_selected]['lg_buy_service'] : $default_language['en']['lg_buy_service']; ?>
                                            </a>
                                        </li>
                                        <li class="nav-row">
                                            <a href="<?php echo base_url() . 'buy-project'; ?>">
                                                <?php echo (!empty($user_language[$user_selected]['lg_buy_project'])) ? $user_language[$user_selected]['lg_buy_project'] : $default_language['en']['lg_buy_project']; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:;" onclick="selected_menu('mywork')">
                                            <?php echo (!empty($user_language[$user_selected]['lg_my_works'])) ? $user_language[$user_selected]['lg_my_works'] : $default_language['en']['lg_my_works']; ?>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:;" onclick="selected_menu('message')">
                                            <?php echo (!empty($user_language[$user_selected]['lg_messages'])) ? $user_language[$user_selected]['lg_messages'] : $default_language['en']['lg_messages']; ?>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:;" onclick="selected_menu('notification')">
                                            <?php echo (!empty($user_language[$user_selected]['lg_alerts'])) ? $user_language[$user_selected]['lg_alerts'] : $default_language['en']['lg_alerts']; ?>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="mobile-menu-item clearfix">
                                        <a href="javascript:;" onclick="selected_menu('password')">
                                            <?php echo (!empty($user_language[$user_selected]['lg_settings'])) ? $user_language[$user_selected]['lg_settings'] : $default_language['en']['lg_settings']; ?>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="mobile-menu-item clearfix">
                                        <a href="#" data-toggle="modal" data-target="#login-popup">
                                            <?php echo (!empty($user_language[$user_selected]['lg_log_in'])) ? $user_language[$user_selected]['lg_log_in'] : $default_language['en']['lg_log_in']; ?>
                                        </a>
                                    </div>

                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <nav id="mobile-navigation">
                    <div class="mobile-menu-toggle clearfix">
                        <div class="mobile-menu-left-side">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-2 col-xs-2">
                                        <a id="mobile_btn" class="mobile_btn pull-left" href="javascript:void(0);">
                                            <i class="fa fa-bars" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <?php if ($module == "buy_service") { ?>
                                    <div class="mobile-menu-right-side">
                                        <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
    </header>
        <div id="login-popup" class="modal fade custom-popup" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-header text-center">
                        <h4 class="sign-title"><?php echo (!empty($user_language[$user_selected]['lg_log_in'])) ? $user_language[$user_selected]['lg_log_in'] : $default_language['en']['lg_log_in']; ?></h4>
                    </div>
                    <div class="modal-body">
                        <form id="users_login" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_email'])) ? $user_language[$user_selected]['lg_email'] : $default_language['en']['lg_email']; ?>
                                    / <?php echo (!empty($user_language[$user_selected]['lg_username'])) ? $user_language[$user_selected]['lg_username'] : $default_language['en']['lg_username']; ?>
                                    :</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="user_name" id="user_name"
                                           placeholder="<?php echo (!empty($user_language[$user_selected]['lg_username_or_email'])) ? $user_language[$user_selected]['lg_username_or_email'] : $default_language['en']['lg_username_or_email']; ?>"
                                           required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_password'])) ? $user_language[$user_selected]['lg_password'] : $default_language['en']['lg_password']; ?>
                                    :</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control"
                                           placeholder="<?php echo (!empty($user_language[$user_selected]['lg_password'])) ? $user_language[$user_selected]['lg_password'] : $default_language['en']['lg_password']; ?>"
                                           name="password" id="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6"><a href="#" class="pull-left forgot" data-toggle="modal"
                                                         data-target="#forgot-popup"><?php echo (!empty($user_language[$user_selected]['lg_forgot_password'])) ? $user_language[$user_selected]['lg_forgot_password'] : $default_language['en']['lg_forgot_password']; ?>
                                        ?</a></div>
                                <div class="col-lg-6">
                                    <button type="submit"
                                            class="btn btn-primary logon-btn pull-right"><?php echo (!empty($user_language[$user_selected]['lg_log_in'])) ? $user_language[$user_selected]['lg_log_in'] : $default_language['en']['lg_log_in']; ?></button>
                                </div>
                            </div>
                            <div id="register_errtext"></div>
                        </form>
                    </div>
                    <div class="modal-footer text-center">
                        <!--<div class="social-login">-->
                        <?php
                        //if (!empty($website_google_client_id)) {
                        ?>
                        <!--<a class="btn btn-default customGPlusSignIn" href="javascript:void();" id="customBtn">
                                    <img width="16" height="16" alt="Google Login"
                                         src="<?php /*echo base_url(); */ ?>/assets/images/google_plus.png"> CONNECT WITH GOOGLE
                                    +
                                </a>-->
                        <?php //}

                        //if (!empty($website_facebook_app_id)) {
                        ?>
                        <!--<a onclick="fbLogin()" class="btn btn-default" href="javascript:void();"
                                   data-original-title="google">
                                    <img width="16" height="16" alt="Facebook Login"
                                         src="<?php /*echo base_url(); */ ?>/assets/images/fb.png"> CONNECT WITH FACEBOOK
                                </a>-->
                        <?php //} ?>
                        <!--</div>-->
                        <div class="modal-footer-text"><?php echo (!empty($user_language[$user_selected]['lg_not_a_member_yet'])) ? $user_language[$user_selected]['lg_not_a_member_yet'] : $default_language['en']['lg_not_a_member_yet']; ?>
                            ? <a href="" data-toggle="modal"
                                 data-target="#register-popup"><?php echo (!empty($user_language[$user_selected]['lg_register_now'])) ? $user_language[$user_selected]['lg_register_now'] : $default_language['en']['lg_register_now']; ?></a>
                            - <?php echo (!empty($user_language[$user_selected]['lg_it'])) ? $user_language[$user_selected]['lg_it'] : $default_language['en']['lg_it']; ?>
                            ’<?php echo (!empty($user_language[$user_selected]['lg_s_fun_and_easy'])) ? $user_language[$user_selected]['lg_s_fun_and_easy'] : $default_language['en']['lg_s_fun_and_easy']; ?>
                            !
                        </div>
                        <!-- <ul class="brine-login-media">
                       <li onclick="fbLogin()"><a href="javascript:void();"><i class="fa fa-facebook"></i> Sign In with Facebook</a></li>
                        <li id="customBtn" class="customGPlusSignIn"><a href="javascript:void();" data-original-title="google"><i class="fa fa-google"></i> Sign In with Google</a></li>
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>
        
        <div id="register-popup" class="modal fade custom-popup" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" id="remove_popuptop" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-header text-center">
                    </div>
                    <div class="modal-body">
                        <form id="users_register" class="form-horizontal">
                            <p class="member-text">
                                <?php echo (!empty($user_language[$user_selected]['lg_already_a_member'])) ? $user_language[$user_selected]['lg_already_a_member'] : $default_language['en']['lg_already_a_member']; ?>
                                ? <a href="" data-toggle="modal" data-target="#login-popup">
                                    <?php echo (!empty($user_language[$user_selected]['lg_log_in'])) ? $user_language[$user_selected]['lg_log_in'] : $default_language['en']['lg_log_in']; ?>
                                </a>
                            </p>
                            <div class="login-or">
                                <hr class="hr-or">
                                <span class="span-or">
                                        <?php echo (!empty($user_language[$user_selected]['lg_or'])) ? $user_language[$user_selected]['lg_or'] : $default_language['en']['lg_or']; ?>
                                    </span>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_name'])) ? $user_language[$user_selected]['lg_name'] : $default_language['en']['lg_name']; ?></label>
                                <div class="col-lg-8">
                                    <input type="text" value=""
                                           placeholder="<?php echo (!empty($user_language[$user_selected]['lg_name'])) ? $user_language[$user_selected]['lg_name'] : $default_language['en']['lg_name']; ?>"
                                           id="name" name='name' class="form-control alphaonly" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_email'])) ? $user_language[$user_selected]['lg_email'] : $default_language['en']['lg_email']; ?></label>
                                <div class="col-lg-8">
                                    <input type="email" value=""
                                           placeholder="<?php echo (!empty($user_language[$user_selected]['lg_email'])) ? $user_language[$user_selected]['lg_email'] : $default_language['en']['lg_email']; ?>"
                                           id="email" name='email' class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_username'])) ? $user_language[$user_selected]['lg_username'] : $default_language['en']['lg_username']; ?></label>
                                <div class="col-lg-8">
                                    <input type="text" name="username" minlength=5 id="username"
                                           class="form-control alphaonly noSpacesField"
                                           placeholder="<?php echo (!empty($user_language[$user_selected]['lg_username'])) ? $user_language[$user_selected]['lg_username'] : $default_language['en']['lg_username']; ?>"
                                           autocomplete="off" required>
                                </div>
                                <div id="username_suggestion" style="display: none;">
                                    <input type="hidden" name="hidden_field">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_password'])) ? $user_language[$user_selected]['lg_password'] : $default_language['en']['lg_password']; ?></label>
                                <div class="col-lg-8">
                                    <input type="password"
                                           placeholder="<?php echo (!empty($user_language[$user_selected]['lg_password'])) ? $user_language[$user_selected]['lg_password'] : $default_language['en']['lg_password']; ?>"
                                           class="form-control" id="reg_password" name="Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_repeat_password'])) ? $user_language[$user_selected]['lg_repeat_password'] : $default_language['en']['lg_repeat_password']; ?></label>
                                <div class="col-lg-8">
                                    <input type="password"
                                           placeholder="<?php echo (!empty($user_language[$user_selected]['lg_repeat_password'])) ? $user_language[$user_selected]['lg_repeat_password'] : $default_language['en']['lg_repeat_password']; ?>"
                                           class="form-control" id="repeatpassword" name="RepeatPassword" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_country'])) ? $user_language[$user_selected]['lg_country'] : $default_language['en']['lg_country']; ?></label>
                                <div class="col-lg-8">
                                    <select name="country_id" id="country_id" class="form-control" required>
                                        <option value=""><?php echo (!empty($user_language[$user_selected]['lg_select_country'])) ? $user_language[$user_selected]['lg_select_country'] : $default_language['en']['lg_select_country']; ?></option>
                                        <?php if (!empty($country_list)) { ?>
                                            <?php foreach ($country_list as $countries) { ?>
                                                <option value="<?php echo $countries['id']; ?>"><?php echo $countries['country']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4"><?php echo (!empty($user_language[$user_selected]['lg_state'])) ? $user_language[$user_selected]['lg_state'] : $default_language['en']['lg_state']; ?></label>
                                <div class="col-lg-8">
                                    <select name="state_id" id="state_id" class="form-control" required>
                                        <option value=""><?php echo (!empty($user_language[$user_selected]['lg_select_state'])) ? $user_language[$user_selected]['lg_select_state'] : $default_language['en']['lg_select_state']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input type="hidden" id="account_type_id" name="account_type_id" value="1">
                                <button type="button" class="btn btn-default active" onclick="dev_check();" id="developer_check">
                                    Register as Freelancer
                                </button>

                                <button type="button" class="btn btn-default" onclick="cli_check();" id="client_check">
                                    Register as Employeer
                                </button>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="terms-text text-center">
                                        <?php echo (!empty($user_language[$user_selected]['lg_by_signing_up'])) ? $user_language[$user_selected]['lg_by_signing_up'] : $default_language['en']['lg_by_signing_up']; ?>
                                        , <?php echo (!empty($user_language[$user_selected]['lg_i_agree_to'])) ? $user_language[$user_selected]['lg_i_agree_to'] : $default_language['en']['lg_i_agree_to']; ?> <?php echo $this->site_name; ?>
                                        <a href="<?php echo base_url() . 'terms'; ?>"
                                           target="_blank"> <?php echo (!empty($user_language[$user_selected]['lg_terms_of_conditions'])) ? $user_language[$user_selected]['lg_terms_of_conditions'] : $default_language['en']['lg_terms_of_conditions']; ?></a>.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-primary logon-btn" id="registers">
                                        <?php echo (!empty($user_language[$user_selected]['lg_register'])) ? $user_language[$user_selected]['lg_register'] : $default_language['en']['lg_register']; ?>
                                    </button>
                                </div>
                            </div>
                            <span id="register_success"> </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="forgot-popup" class="modal fade custom-popup" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-header text-center">
                        <h4 class="sign-title"><?php echo (!empty($user_language[$user_selected]['lg_forgot_password'])) ? $user_language[$user_selected]['lg_forgot_password'] : $default_language['en']['lg_forgot_password']; ?></h4>
                        <span id="forgot_password_msg"></span>
                    </div>
                    <div class="modal-body">
                        <form id="forget_form" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-lg-4">
                                    <?php echo (!empty($user_language[$user_selected]['lg_email'])) ? $user_language[$user_selected]['lg_email'] : $default_language['en']['lg_email']; ?>
                                </label>
                                <div class="col-lg-8">
                                    <input type="email"
                                           placeholder="<?php echo (!empty($user_language[$user_selected]['lg_email'])) ? $user_language[$user_selected]['lg_email'] : $default_language['en']['lg_email']; ?>"
                                           id="forget_email" name="forget_email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6">
                                    <button type="submit"class="btn btn-primary logon-btn pull-right">
                                        <?php echo (!empty($user_language[$user_selected]['lg_submit'])) ? $user_language[$user_selected]['lg_submit'] : $default_language['en']['lg_submit']; ?>
                                        </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer text-center">
                        <div class="modal-footer-text"><?php echo (!empty($user_language[$user_selected]['lg_do_you_know_your_password'])) ? $user_language[$user_selected]['lg_do_you_know_your_password'] : $default_language['en']['lg_do_you_know_your_password']; ?>
                            ? <a href="" data-toggle="modal"
                                 data-target="#login-popup"><?php echo (!empty($user_language[$user_selected]['lg_login_now'])) ? $user_language[$user_selected]['lg_login_now'] : $default_language['en']['lg_login_now']; ?></a>
                            - <?php echo (!empty($user_language[$user_selected]['lg_it'])) ? $user_language[$user_selected]['lg_it'] : $default_language['en']['lg_it']; ?>
                            ’<?php echo (!empty($user_language[$user_selected]['lg_s_fun_and_easy'])) ? $user_language[$user_selected]['lg_s_fun_and_easy'] : $default_language['en']['lg_s_fun_and_easy']; ?>
                            !
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">