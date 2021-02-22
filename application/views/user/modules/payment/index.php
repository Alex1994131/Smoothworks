<?php //$this->load->view('user/includes/search_include'); ?>
<section class="profile-section">
    <div class="container">
        <?php if ($this->session->userdata('message')) { ?>
            <div class="alert alert-success text-center fade in alert-dismissable"
                 id="flash_succ_message"><?php echo $this->session->userdata('message'); ?></div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb menu-breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a>
                        <i class="fa fa fa-chevron-right"></i></li>
                    <li class="active"><?php echo (!empty($user_language[$user_selected]['lg_my_profile'])) ? $user_language[$user_selected]['lg_my_profile'] : $default_language['en']['lg_my_profile']; ?></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="user-block">
                    <div class="user-image">
                        <div id="crop-avatar">
                            <div id="profile-avatar">
                                <div class="avatar-view" id="img_view">
                                    <?php $image = base_url() . 'assets/images/avatar-lg.jpg';
                                    if (!empty($profile['user_profile_image'])) {
                                        $image = base_url() . $profile['user_profile_image'];
                                    }
                                    ?>
                                    <img style="cursor:pointer;" src="<?php echo $image; ?>" alt="Avatar">
                                    <div class="change-img-text"><?php echo (!empty($user_language[$user_selected]['lg_change_image'])) ? $user_language[$user_selected]['lg_change_image'] : $default_language['en']['lg_change_image']; ?></div>
                                </div>
                                <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                            </div>
                            <!-- Cropping modal -->
                            <div class="modal fade" id="avatar-modal" aria-hidden="true"
                                 aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="avatar-form" action="<?php echo base_url() . 'prf_crop'; ?>"
                                              enctype="multipart/form-data" method="post">
                                            <div class="modal-header">
                                                <button class="close" data-dismiss="modal" type="button">&times;
                                                </button>
                                                <h4 class="modal-title"
                                                    id="avatar-modal-label"><?php echo (!empty($user_language[$user_selected]['lg_change_avatar'])) ? $user_language[$user_selected]['lg_change_avatar'] : $default_language['en']['lg_change_avatar']; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="avatar-body">

                                                    <!-- Upload image and data -->
                                                    <div class="avatar-upload">
                                                        <input class="avatar-src" name="avatar_src" type="hidden">
                                                        <input class="avatar-data" name="avatar_data" type="hidden">
                                                        <label for="avatarInput"><?php echo (!empty($user_language[$user_selected]['lg_local_upload'])) ? $user_language[$user_selected]['lg_local_upload'] : $default_language['en']['lg_local_upload']; ?></label>
                                                        <input class="avatar-input" id="avatarInput" name="avatar_file"
                                                               type="file">
                                                    </div>

                                                    <!-- Crop and preview -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="avatar-wrapper"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row avatar-btns">
                                                        <div class="col-md-3 pull-right">
                                                            <button class="btn btn-primary btn-block avatar-save"
                                                                    type="submit"><?php echo (!empty($user_language[$user_selected]['lg_done'])) ? $user_language[$user_selected]['lg_done'] : $default_language['en']['lg_done']; ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- /.modal -->
                            <!-- Loading state -->
                            <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>

                        </div>

                    </div>
                    <div class="user-details">
                        <div class="user-name-block">
                            <input type="text" name="show_user_name" id="show_user_name"
                                   value="<?php echo $profile['fullname']; ?>" style="display: none">
                            <input type="button" name="save" id="save" value="save" style="display: none"> <input
                                    type="button" name="cancel" id="cancel" value="cancel" style="display: none">
                            <h3 id="uname-edit" class="user-name"><?php echo ucfirst($profile['fullname']); ?></h3>
                            <input type="hidden" name="hidden_user_name" id="hidden_user_name"
                                   value="<?php echo $profile['fullname']; ?>">
                        </div>
                        <div class="user-contact">
                            <ul class="list-inline">
                                <?php
                                $query_feed = $this->db->query("SELECT AVG(rating),count(id) FROM `feedback` WHERE rating !=0 AND `to_user_id` = " . $profile['USERID']);
                                $fe_count = $query_feed->row_array();
                                $rat = 0;
                                $rat_count = 0;
                                if ($fe_count['AVG(rating)'] != '') {
                                    $rat = round($fe_count['AVG(rating)']);
                                    $rat_count = $fe_count['count(id)'];
                                }
                                ?>
                                <li class="user-rating feedback-area">
                                    <span id="stars-existing" class="starrr" data-rating="<?php echo $rat; ?>"></span>(<?php echo $rat_count; ?>)
                                </li>
                                <?php if (!empty($country_name)) { ?>
                                    <li class="user-country2">FROM <?php echo $country_name; ?>
                                        <span class="ppcn country <?php echo $country_shortname; ?>"></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="user-description">
                            <p class="user-desc">
                                <?php echo ucfirst($profile['description']); ?>
                                <span class="more-desc"></span>
                            </p>
                        </div>
                        <?php if (!empty($profile['language'])) { ?>
                            <div class="user-language">
                                <span>
                                    <img src="<?php echo base_url(); ?>assets/images/li-world.png">
                                </span>
                                Speaks: <span id="language_list"><?php echo ucfirst($profile['language']); ?></span>
                                <input type="hidden" value="" id="lang_speaks">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="tab-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-list">
                    <ul>
                        <li>
                            <a href="<?php echo base_url() . 'password'; ?>">
                                <span class="visible-xxs"><i class="fa fa-key" aria-hidden="true"></i></span>
                                <span class="hidden-xxs"><?php echo (!empty($user_language[$user_selected]['lg_password'])) ? $user_language[$user_selected]['lg_password'] : $default_language['en']['lg_password']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'profile'; ?>">
                                <span class="visible-xxs"><i class="fa fa-user" aria-hidden="true"></i></span>
                                <span class="hidden-xxs"><?php echo (!empty($user_language[$user_selected]['lg_profile'])) ? $user_language[$user_selected]['lg_profile'] : $default_language['en']['lg_profile']; ?></span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="javascript:;">
                                <span class="visible-xxs"><i class="fa fa-money" aria-hidden="true"></i></span>
                                <span class="hidden-xxs"><?php echo (!empty($user_language[$user_selected]['lg_payment_settings'])) ? $user_language[$user_selected]['lg_payment_settings'] : $default_language['en']['lg_payment_settings']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="add_payment_details" action="<?php echo base_url() . 'payment-settings'; ?>" method="post">
                    <div class="row">
                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                <div class="col-md-6 col-sm-9">
                                    <label>
                                        <?php echo (!empty($user_language[$user_selected]['lg_paypal_email_id'])) ? $user_language[$user_selected]['lg_paypal_email_id'] : $default_language['en']['lg_paypal_email_id']; ?>:
                                    </label>
                                    <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                                           name="paypal_email" id="paypal_email" value="<?php echo $profile['paypal_email']; ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="text-left">
                                <button type="submit" name="form_submit" value="true" class="btn btn-primary save-btn">
                                    <?php echo (!empty($user_language[$user_selected]['lg_save'])) ? $user_language[$user_selected]['lg_save'] : $default_language['en']['lg_save']; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>