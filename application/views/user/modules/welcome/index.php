<section class="home-banner parallax">
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

            <div class="alert alert-success text-center fade in alert-dismissable" id="flash_succ_message">
                <?php echo $this->session->userdata('message'); ?>
            </div>
            <?php $this->session->unset_userdata('message');
        } ?>

        <?php if ($this->session->flashdata('error_message')) { ?>

            <div class="alert alert-danger text-center fade in alert-dismissable" id="flash_error_message">
                <?php echo $this->session->flashdata('error_message'); ?>
            </div> <?php
        } ?>

        <?php if ($this->session->userdata('user_registeration') == "success") { ?>

            <div class="alert alert-success register_success">

                <strong><?php echo (!empty($user_language[$user_selected]['lg_success'])) ? $user_language[$user_selected]['lg_success'] : $default_language['en']['lg_success']; ?>
                    !</strong> <?php echo (!empty($user_language[$user_selected]['lg_you_have_successfully_registered'])) ? $user_language[$user_selected]['lg_you_have_successfully_registered'] : $default_language['en']['lg_you_have_successfully_registered']; ?>
                . <?php echo (!empty($user_language[$user_selected]['lg_please_check_registered_email'])) ? $user_language[$user_selected]['lg_please_check_registered_email'] : $default_language['en']['lg_please_check_registered_email']; ?>
                .

            </div>

            <?php
            $this->session->unset_userdata('user_registeration');

        } ?>

        <?php if ($this->session->userdata('users_account_activate') == "success") { ?>

            <div class="alert alert-success register_success">

                <strong><?php echo (!empty($user_language[$user_selected]['lg_success'])) ? $user_language[$user_selected]['lg_success'] : $default_language['en']['lg_success']; ?>
                    !</strong> <?php echo (!empty($user_language[$user_selected]['lg_you_have_successfully_verified'])) ? $user_language[$user_selected]['lg_you_have_successfully_verified'] : $default_language['en']['lg_you_have_successfully_verified']; ?>
                . <?php echo (!empty($user_language[$user_selected]['lg_please_login_now'])) ? $user_language[$user_selected]['lg_please_login_now'] : $default_language['en']['lg_please_login_now']; ?>
                .

            </div>

            <?php

            $this->session->unset_userdata('users_account_activate');

        } ?>

        <div class="row banner-box">
            <div class="col-md-12 banner-content">
                <div class="newsletter-banner-left-img">
                    <h2><?php echo (!empty($user_language[$user_selected]['lg_find_the_best'])) ? $user_language[$user_selected]['lg_find_the_best'] : $default_language['en']['lg_find_the_best']; ?>
                        <?php echo (!empty($user_language[$user_selected]['lg_instant_a_services_marketplace'])) ? $user_language[$user_selected]['lg_instant_a_services_marketplace'] : $default_language['en']['lg_instant_a_services_marketplace']; ?>
                    </h2>
                    <form action="<?php echo base_url() . "search"; ?>" method="post" class="newsletter-form">
                        <div class="input-group">
                            <input type="text" class="form-control gig-services" name="common_search" id="gig-services" autocomplete="off" placeholder="">
                            <span class="input-group-btn">
                                <button type="submit" class="btn">
                                    <img src="assets/images/Icon awesome-long-arrow-alt-left.png" style="height: 10px; width: 12px; margin-bottom: 4px"/>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="daily-figure">

    <div class="container">

        <div class="custom-feature-box row">
<?php $i = 1;?>
<?php foreach ($policy_setting as $policy) { ?>                           

                <div class="col-md-3 col-sm-6 col-xs-12">

                    <div class="feature-box fbox_1">

                        <h4 class="title"><?php echo ucfirst($policy['policy_name']); ?></h4>
                        <?php
                            $url = base_url()."assets"."/images"."/".$i.".png";
                            $i ++;
                            
                        ?>
                        <div style="width: 100%; text-align: center; padding-bottom: 5px;">
                            <img class="logo-img" src=<?php echo $url?>>
                        </div>
                        <p><?php echo ucfirst($policy['policy_terms']); ?></p>

                    </div>

                </div>

<?php } ?>

        </div>

    </div>	

</section>

<?php

if (($this->session->userdata('SESSION_USER_ID'))) {

    $user_id = $this->session->userdata('SESSION_USER_ID');

    $favorites_list = array();

    foreach ($user_favorites as $value) {

        $favorites_list[] = $value['gig_id'];

    }

} ?>

<section class="location-gigs">

    <div class="container">

        <div class="row">

            <div class="col-md-9">

                <h3 class="latest-title">

                    <span> <?php echo (!empty($user_language[$user_selected]['lg_popular_gigs'])) ? $user_language[$user_selected]['lg_popular_gigs'] : $default_language['en']['lg_popular_gigs']; ?><?php // echo $full_country_name; ?> &nbsp;&nbsp;

						<span id="uniquename" style="display:none;">

							<span class="ui-widget">

							   <input type="text" name="country_name" id="full_country_name">

							</span>

						</span>

					</span>

                </h3>

                <span class="loca-dd"></span>

            </div>

            <div class="col-md-3">

                <div class="see-all">

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <?php


                $popular_gigs_count = 0;

                if (!empty($popular_gigs)) { ?>

                    <div class="popular-products">

                        <div class="owl-carousel" id="popular-products">

                            <?php


                            foreach ($popular_gigs as $location_gigs) {


                                $currency_option = (!empty($location_gigs['currency_type'])) ? $location_gigs['currency_type'] : 'USD';
                                $rate_symbol = currency_sign($currency_option);
                                //$rate = $gig_price; // Fixed Rate
                                $rate = $location_gigs['gig_price']; // Dynamic
                                $image = "assets/images/2.jpg";
                                if (!empty($location_gigs['gig_image'])) {
                                    $image = base_url() . $location_gigs['gig_image'];
                                }
                                $user_img = base_url() . "assets/images/avatar2.jpg";
                                if (!empty($location_gigs['user_thumb_image'])) {
                                    $user_img = base_url() . $location_gigs['user_thumb_image'];

                                }

                                $name = $location_gigs['fullname'];

                                $username = $location_gigs['username'];

                                $g_rating = 0;

                                $g_rating1 = 0;

                                if (!empty($location_gigs['gig_rating'])) {

                                    $g_rating1 = round($location_gigs['gig_rating']);

                                    $g_rating = $g_rating1 * 2;

                                }

                                $gig_usercount = 0;

                                if (!empty($location_gigs['gig_usercount'])) {

                                    $gig_usercount = $location_gigs['gig_usercount'];

                                }

                                $gig_idone = $location_gigs['id'];

                                ?>

                                <div class="product">

                                    <div class="product-img">

                                        <a href="<?php echo base_url() . 'gig-preview/' . $location_gigs['title']; ?>"><img
                                                    width="240" height="250"
                                                    alt="<?php echo ucfirst($location_gigs['title']); ?>"
                                                    src="<?php echo $image; ?>"></a>

                                        <?php if (($this->session->userdata('SESSION_USER_ID'))) {

                                            $user_id = $this->session->userdata('SESSION_USER_ID');

                                            if ($location_gigs['user_id'] != $user_id) {

                                                if (in_array($gig_idone, $favorites_list)) { ?>

                                                    <div id="favourite_area_list"><a href="javascript:;"
                                                                                     class="favourite favourited"
                                                                                     title="Remove Favourite"
                                                                                     onclick="remove_favourites_list('<?php echo $gig_idone; ?>','<?php echo $user_id; ?>', this)"><i
                                                                    class="fa fa-heart"></i></a></div>

                                                <?php } else { ?>

                                                    <div id="favourite_area_list"><a href="javascript:;"
                                                                                     class="favourite"
                                                                                     title="Add Favourite"
                                                                                     onclick="add_favourites_list('<?php echo $gig_idone; ?>','<?php echo $user_id; ?>', this)"><i
                                                                    class="fa fa-heart"></i></a></div>

                                                <?php }
                                            }
                                        } ?>


                                    </div>

                                    <div class="product-detail">

                                        <div class="product-name"><a
                                                    href="<?php echo base_url() . 'gig-preview/' . $location_gigs['title']; ?>"><?php echo ucfirst(str_replace("-", " ", $location_gigs['title'])); ?></a>
                                        </div>

                                        <div class="author">

									<span class="author-img">

										<a href="<?php echo base_url() . "user-profile/" . $username; ?>"><img
                                                    src="<?php echo $user_img; ?>"
                                                    title="<?php echo $location_gigs['fullname']; ?>" width="50"
                                                    height="50"></a>

										<a class="author-name"
                                           href="<?php echo base_url() . "user-profile/" . $username; ?>"><?php echo ucfirst($name); ?></a>

									</span>

                                            <div class="ratings">

                                                <span class="stars-block star-<?php echo $g_rating; ?>"></span><span
                                                        class="ratings-count">(<?php echo $gig_usercount; ?>)</span>

                                            </div>

                                        </div>


                                        <div class="price-box2">

                                            <div class="price-inner">

                                                <div class="rectangle">

                                                    <h2><?php echo $rate_symbol . $rate; ?></h2>

                                                </div>

                                                <div class="triangle"></div>

                                            </div>

                                        </div>

                                        <div class="product-det">

                                            <div class="user-country text-ellipsis"><?php echo ucfirst($location_gigs['state_name']); ?><?php if ($location_gigs['state_name'] != '') {
                                                    echo ', ';
                                                } ?><?php echo ucfirst($location_gigs['country']); ?></div>


                                            <div class="product-currency">


                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <?php

                                $popular_gigs_count = $popular_gigs_count + 1;

                            } ?>

                        </div>

                    </div>

                <?php } else { ?>

                    <p><?php echo (!empty($user_language[$user_selected]['lg_no_gigs_found'])) ? $user_language[$user_selected]['lg_no_gigs_found'] : $default_language['en']['lg_no_gigs_found']; ?></p>

                    <?php

                }

                ?>

                <input type="hidden" name="popular_gigs_count" id="popular_gigs_count"
                       value="<?php echo $popular_gigs_count; ?>"/>

            </div>

        </div>

    </div>

</section>

<section class="latest-gigs">

    <div class="container">

        <div class="row">

            <div class="col-md-9">

                <div class="ui-widget">

                    <input type="text" name="search_category_name" id="search_category_name" style="display: none">

                </div>

                <h4 class="latest-title"><?php echo (!empty($user_language[$user_selected]['lg_latest_gigs'])) ? $user_language[$user_selected]['lg_latest_gigs'] : $default_language['en']['lg_latest_gigs']; ?>
                    &nbsp;&nbsp;

                </h4>

                <input type="hidden" name="country_name" id="country_name" value="">

            </div>

            <div class="col-md-3">

                <div class="see-all"></div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <?php

                $latest_gigs = 0;

                if (!empty($recent_gigs)) { ?>

                    <div class="latest-products">

                        <div class="owl-carousel" id="latest-products">


                            <?php foreach ($recent_gigs as $gigs) {

                                $currency_option = (!empty($gigs['currency_type'])) ? $gigs['currency_type'] : 'USD';
                                $rate_symbol = currency_sign($currency_option);
                                // $rate = $gig_price; // Fixed Price
                                $rate = $gigs['gig_price'];  // Dyanamic Price
                                //$rate = number_format((float)$rate, 2, '.', '');
                                $image = "assets/images/2.jpg";

                                if (!empty($gigs['gig_image'])) {


                                    $image = base_url() . $gigs['gig_image'];

                                }

                                $user_img = base_url() . "assets/images/avatar2.jpg";

                                if (!empty($gigs['user_thumb_image'])) {

                                    $user_img = base_url() . $gigs['user_thumb_image'];

                                }

                                $name = $gigs['fullname'];

                                $username = $gigs['username'];

                                $gig_rating = 0;

                                $gig_rating1 = 0;

                                if (!empty($gigs['gig_rating'])) {

                                    $gig_rating1 = round($gigs['gig_rating']);

                                    $gig_rating = $gig_rating1 * 2;

                                }

                                $gig_usercount1 = 0;

                                if (!empty($gigs['gig_usercount'])) {

                                    $gig_usercount1 = $gigs['gig_usercount'];

                                }

                                $gig_one = $gigs['id'];

                                ?>

                                <div class="product">

                                    <div class="product-img">

                                        <a href="<?php echo base_url() . 'gig-preview/' . $gigs['title']; ?>"><img
                                                    width="240" height="250" alt="<?php echo $gigs['title']; ?>"
                                                    src="<?php echo $image; ?>"></a>

                                        <?php if (($this->session->userdata('SESSION_USER_ID'))) {

                                            $user_id = $this->session->userdata('SESSION_USER_ID');

                                            if ($gigs['user_id'] != $user_id) {

                                                if (in_array($gig_one, $favorites_list)) { ?>

                                                    <div id="favourite_area_list"><a href="javascript:;"
                                                                                     class="favourite favourited"
                                                                                     title="Remove Favourite"
                                                                                     onclick="remove_favourites_list('<?php echo $gig_one; ?>','<?php echo $user_id; ?>', this)"><i
                                                                    class="fa fa-heart"></i></a></div>

                                                <?php } else { ?>

                                                    <div id="favourite_area_list"><a href="javascript:;"
                                                                                     class="favourite"
                                                                                     title="Add Favourite"
                                                                                     onclick="add_favourites_list('<?php echo $gig_one; ?>','<?php echo $user_id; ?>', this)"><i
                                                                    class="fa fa-heart"></i></a></div>

                                                <?php }
                                            }
                                        } ?>

                                    </div>

                                    <div class="product-detail">

                                        <div class="product-name"><a
                                                    href="<?php echo base_url() . 'gig-preview/' . $gigs['title']; ?>"><?php echo ucfirst(str_replace("-", " ", $gigs['title'])); ?></a>
                                        </div>

                                        <div class="author">

									<span class="author-img">

										<a href="<?php echo base_url() . "user-profile/" . $username; ?>"><img
                                                    src="<?php echo $user_img; ?>"
                                                    title="<?php echo $gigs['fullname']; ?>" width="50" height="50"></a>

										<a class="author-name"
                                           href="<?php echo base_url() . "user-profile/" . $username; ?>"><?php echo $name; ?></a>

									</span>

                                            <div class="ratings">

                                                <span class="stars-block star-<?php echo $gig_rating; ?>"></span><span
                                                        class="ratings-count">(<?php echo $gig_usercount1; ?>)</span>

                                            </div>

                                        </div>


                                        <div class="price-box2">

                                            <div class="price-inner">

                                                <div class="rectangle">

                                                    <h2><?php echo $rate_symbol . $rate; ?></h2>

                                                </div>

                                                <div class="triangle"></div>

                                            </div>

                                        </div>

                                        <div class="product-det">

                                            <div class="user-country text-ellipsis"><?php echo ucfirst($gigs['state_name']); ?><?php if ($gigs['state_name'] != '') {
                                                    echo ', ';
                                                } ?><?php echo ucfirst($gigs['country']); ?></div>


                                            <div class="product-currency">


                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <?php

                                $latest_gigs = $latest_gigs + 1;

                            } ?>

                        </div>

                    </div>

                <?php } else { ?>

                    <p><?php echo (!empty($user_language[$user_selected]['lg_no_gigs_found'])) ? $user_language[$user_selected]['lg_no_gigs_found'] : $default_language['en']['lg_no_gigs_found']; ?></p>

                <?php }

                ?>

                <input type="hidden" name="latest_gigs_count" id="latest_gigs_count"
                       value="<?php echo $latest_gigs; ?>"/>

            </div>

        </div>

    </div>

</section>
<section class="clients-area">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <h3 class="client-title">

                    <span><?php echo (!empty($user_language[$user_selected]['lg_clients'])) ? $user_language[$user_selected]['lg_clients'] : $default_language['en']['lg_clients']; ?></span>

                </h3>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <?php
                $clients_count = 0;

                if (!empty($client_list)) {
                    ?>

                    <div class="partners-carousel">

                        <div class="owl-carousel" id="partners">

                            <?php foreach ($client_list as $client) { ?>

                                <div><a target="_blank" href="<?php echo $client['client_name'];?>"><img src="<?php echo base_url() . $client['client_cropped_image']; ?>" alt="" width="170" height="90" /></a></div>                                 <?php
                                $clients_count = $clients_count + 1;
                            }
                            ?>

                        </div>

                    </div>

<?php } else { ?><p><?php echo (!empty($user_language[$user_selected]['lg_no_clients_found'])) ? $user_language[$user_selected]['lg_no_clients_found'] : $default_language['en']['lg_no_clients_found']; ?></p>  <?php } ?>

                <input type="hidden" name="clients_count" id="clients_count" value="<?php echo $clients_count; ?>" />

            </div>

        </div>

    </div>

</section>