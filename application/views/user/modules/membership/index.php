<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb menu-breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a>
                        <i class="fa fa fa-chevron-right"></i>
                    </li>
                    <li class="active">
                        <?php echo (!empty($user_language[$user_selected]['lg_membership'])) ? $user_language[$user_selected]['lg_membership'] : $default_language['en']['lg_membership']; ?>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="header-title">
                    <?php echo (!empty($user_language[$user_selected]['lg_membership'])) ? $user_language[$user_selected]['lg_membership'] : $default_language['en']['lg_membership']; ?>
                </h3>
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="my_balance" name="my_balance" value="<?php echo $my_balance; ?>">
<input type="hidden" id="margin_price" name="margin_price" value="<?php echo $margin_price; ?>">
<div class="tab-content">
    <div class="container">
        <div class="row">
            <?php if ($this->session->userdata('message')) { ?>
                <div class="alert alert-success text-center fade in" id="flash_succ_message"><?php echo $this->session->userdata('message'); ?></div>
                <?php $this->session->unset_userdata('message');
            } ?>
        </div>
        <input type="hidden" id="my_balance" name="my_balance" value="<?php echo $my_balance; ?>">
        <input type="hidden" id="margin_price" name="margin_price" value="<?php echo $margin_price; ?>">
        <div class="row">
            <div class="membership_container">
                <ul class="membership_list">
                <?php if($account_type == 1) {
                    foreach ($membership_freelancer as $membership) {
                        $title = $membership['title'];
                        $contents = $membership['memberships']; ?>
                        <li class="membership_item col-md-3">
                            <div class="membership_item_header">
                                <h3 class="title"><?php echo $title; ?></h3>
                                <div class="price" id="price_<?php echo $membership['id']?>">
                                    <?php
                                    $price = 0;
                                    $contents_arr = explode(',', $contents);
                                    for($i=0; $i<count($contents_arr); $i++) {
                                        for($j=0; $j<count($membership_details); $j++) {
                                            if($contents_arr[$i] == $membership_details[$j]['id'] && $membership_details[$j]['group'] == 1) {
                                                $monthly_price = $membership_details[$j]['key'];
                                            }
                                            else if($contents_arr[$i] == $membership_details[$j]['id'] && $membership_details[$j]['group'] == 2) {
                                                $quarterly_price = $membership_details[$j]['key'];
                                            }
                                            else if($contents_arr[$i] == $membership_details[$j]['id'] && $membership_details[$j]['group'] == 3) {
                                                $yearly_price = $membership_details[$j]['key'];
                                            }
                                        }
                                    }
                                    $primary = floor($monthly_price);
                                    $decimal = number_format(floatval($monthly_price - $primary), 2);
                                    $decimal_arr = explode('.', $decimal);
                                    $decimal = $decimal_arr[1];
                                    ?>
                                    <span id="main_price_<?php echo $membership['id']?>">$<?php echo $primary; ?></span>
                                    <span class="decimal_price" id="decimal_price_<?php echo $membership['id']?>">.<?php echo $decimal; ?></span>
                                    <input type="hidden" id="price_value_<?php echo $membership['id']?>" value="<?php echo $monthly_price; ?>" />

                                    <input type="hidden" id="monthly_price_<?php echo $membership['id']?>" value="<?php echo $monthly_price; ?>">
                                    <input type="hidden" id="quarterly_price_<?php echo $membership['id']?>" value="<?php echo $quarterly_price; ?>">
                                    <input type="hidden" id="yearly_price_<?php echo $membership['id']?>" value="<?php echo $yearly_price; ?>">
                                </div>
                                <div class="form-group">
                                    <?php if($membership_level == $membership['level']) { ?>
                                        <select class="form-control" id="price_kind_<?php echo $membership['id']?>">
                                            <option value="1" <?php if($membership_type == 1) echo 'selected'; ?>>per month</option>
                                            <option value="2" <?php if($membership_type == 2) echo 'selected'; ?>>per quarter</option>
                                            <option value="3" <?php if($membership_type == 3) echo 'selected'; ?>>per year</option>
                                        </select>
                                    <?php } else if($membership_level > $membership['level']) { ?>
                                        <select class="form-control" id="price_kind_<?php echo $membership['id']?>">
                                            <option value="1">per month</option>
                                            <option value="2">per quarter</option>
                                            <option value="3">per year</option>
                                        </select>
                                    <?php } else  { ?>
                                        <select class="form-control" id="price_kind_<?php echo $membership['id']?>">
                                            <?php
                                            $mark = ['per month', 'per quarter', 'per year'];
                                            for($i = 1; $i<4; $i++) { ?>
                                                <?php if($i >= $membership_type) { ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $mark[$i-1]; ?></option>
                                                <?php } ?>
                                            <?php  }?>
                                        </select>
                                    <?php } ?>
                                </div>
                                <div class="downgrade">
                                    <?php
                                    if($membership_id == $membership['id']) {
                                        $button_title = 'Current Plan';
                                        ?>
                                        <a href="javascript:void(0)" class="btn btn-primary downgrade_btn" disabled="disabled"><?php echo $button_title; ?></a>
                                        <?php
                                    }
                                    else {
                                        if($membership_level > $membership['level']) {
                                            $button_title = 'Downgrade'; ?>
                                            <a href="javascript:void(0)" class="btn btn-primary downgrade_btn" onclick="membership_up_downgrade('<?php echo $membership['id']; ?>', '<?php echo $membership['title']; ?>', '<?php echo $membership_level; ?>', '<?php echo $account_type; ?>');"><?php echo $button_title; ?></a>
                                        <?php }
                                        else {
                                            $button_title = 'Upgrade'; ?>
                                            <a href="javascript:void(0)" class="btn btn-primary downgrade_btn" onclick="membership_up_downgrade('<?php echo $membership['id']; ?>', '<?php echo $membership['title']; ?>', '<?php echo $membership_level; ?>', '<?php echo $account_type; ?>');"><?php echo $button_title; ?></a>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="membership_item_content">
                                <?php
                                $contents_arr = explode(',', $contents);
                                for($i=0; $i<count($contents_arr); $i++) {
                                    for($j=0; $j<count($membership_details); $j++) {
                                        if($contents_arr[$i] == $membership_details[$j]['id'] && $membership_details[$j]['group'] != 1 && $membership_details[$j]['group'] != 2 && $membership_details[$j]['group'] != 3) {
                                            ?>
                                            <div class="membership_detail"><?php echo $membership_details[$j]['name']; ?></div>
                                            <?php
                                            break;
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </li>
                    <?php }
                } else {
                    foreach ($membership_client as $membership) {
                            $title = $membership['title'];
                            $price = $membership['price'];
                            $contents = $membership['memberships'];
                            ?>
                        <li class="membership_item col-md-3">
                                <div class="membership_item_header">
                                    <h3 class="title"><?php echo $title; ?></h3>
                                    <div class="price" id="price_<?php echo $membership['id']?>">
                                        <?php
                                        $price = 0;
                                        $contents_arr = explode(',', $contents);
                                        for($i=0; $i<count($contents_arr); $i++) {
                                            for($j=0; $j<count($membership_details); $j++) {
                                                if($contents_arr[$i] == $membership_details[$j]['id'] && $membership_details[$j]['group'] == 1) {
                                                    $monthly_price = $membership_details[$j]['key'];
                                                }
                                                else if($contents_arr[$i] == $membership_details[$j]['id'] && $membership_details[$j]['group'] == 2) {
                                                    $quarterly_price = $membership_details[$j]['key'];
                                                }
                                                else if($contents_arr[$i] == $membership_details[$j]['id'] && $membership_details[$j]['group'] == 3) {
                                                    $yearly_price = $membership_details[$j]['key'];
                                                }
                                            }
                                        }
                                        $primary = floor($monthly_price);
                                        $decimal = number_format(floatval($monthly_price - $primary), 2);
                                        $decimal_arr = explode('.', $decimal);
                                        $decimal = $decimal_arr[1];
                                        ?>
                                        <span id="main_price_<?php echo $membership['id']?>">$<?php echo $primary; ?></span>
                                        <span class="decimal_price" id="decimal_price_<?php echo $membership['id']?>">.<?php echo $decimal; ?></span>
                                        <input type="hidden" id="price_value_<?php echo $membership['id']?>" value="<?php echo $monthly_price?>" />

                                        <input type="hidden" id="monthly_price_<?php echo $membership['id']?>" value="<?php echo $monthly_price; ?>">
                                        <input type="hidden" id="quarterly_price_<?php echo $membership['id']?>" value="<?php echo $quarterly_price; ?>">
                                        <input type="hidden" id="yearly_price_<?php echo $membership['id']?>" value="<?php echo $yearly_price; ?>">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="price_kind_<?php echo $membership['id']?>">
                                            <option value="1">per month</option>
                                            <option value="2">per quarter</option>
                                            <option value="3">per year</option>
                                        </select>
                                    </div>
                                    <div class="downgrade">
                                        <?php
                                        if($membership_id == $membership['id']) {
                                            $button_title = 'Downgrade'; ?>
                                            <a href="javascript:void(0)" class="btn btn-primary downgrade_btn" onclick="membership_up_downgrade('<?php echo $membership['id']; ?>', '<?php echo $membership['title']; ?>', '<?php echo $membership_level; ?>', '<?php echo $account_type; ?>');"><?php echo $button_title; ?></a>
                                        <?php }
                                        else {
                                            $button_title = 'Upgrade'; ?>
                                            <a href="javascript:void(0)" class="btn btn-primary downgrade_btn" onclick="membership_up_downgrade('<?php echo $membership['id']; ?>', '<?php echo $membership['title']; ?>', '<?php echo $membership_level; ?>', '<?php echo $account_type; ?>');"><?php echo $button_title; ?></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="membership_item_content">
                                    <?php $contents_arr = explode(',', $contents);
                                    for($i=0; $i<count($contents_arr); $i++) {
                                        for($j=0; $j<count($membership_details); $j++) {
                                            if($contents_arr[$i] == $membership_details[$j]['id'] && $membership_details[$j]['group'] != 1 && $membership_details[$j]['group'] != 2 && $membership_details[$j]['group'] != 3) { ?>
                                                <div class="membership_detail"><?php echo $membership_details[$j]['name']; ?></div>
                                                <?php
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </li>
                    <?php }
                } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="checkout-popup" class="modal fade custom-popup order-popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-header text-center">
                <h4 class="sign-title">Buy Membership</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url() . 'user/membership/payment'; ?>" method="post" id="payment_formid" name="payment_submit">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="membership_id" id="membership_id" />
                            <div id="membership_title" style="font-size: 18px; color: #777; font-weight: 500;"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="membership_price_text" style="font-size: 14px; color: #777; font-weight: 300;"></div>
                            <input type="hidden" name="membership_price" id="membership_price" />
                        </div>
                        <div class="col-md-4">
                            <div id="membership_type_text" style="font-size: 14px; color: #777; font-weight: 300;"></div>
                            <input type="hidden" name="membership_type" id="membership_type" />
                        </div>

                        <input type="hidden" name="account_type" id="account_type" value="">
                        <input type="hidden" name="membership_level" id="membership_level" value="">
                        <input type="hidden" name="access_token" id="access_token" value="">
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