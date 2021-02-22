<style>
    select.input-sm {
        line-height: 20px;
    }
</style>

<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb menu-breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a>
                        <i class="fa fa fa-chevron-right"></i></li>
                    <li class="active">
                        my balances
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="header-title">
                    My Balances
                </h3>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
            <?php if ($this->session->userdata('message')) { ?>
                <div class="alert alert-success text-center fade in" id="flash_succ_message"><?php echo $this->session->userdata('message'); ?></div>
                <?php $this->session->unset_userdata('message');
            } ?>
        </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div style="display: flex; align-items: center; justify-content: flex-end;">
                <input type="hidden" id="my_balances" name="my_balances" value="<?php echo $my_balances; ?>">
                <!-- <button id="deposit_btn" class="btn btn-green" style="margin-right: 20px;">Deposit</button> -->
                <button id="withdraw_btn" class="btn btn-green">Withdraw My Balance</button>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="table-responsive order-table">                    
                <table class="table table-actions-bar" id="my_balances_table">
                    <thead>
                        <tr>
                            <th>No</th>        
                            <th>Currency</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="withdraw-popup" class="modal fade custom-popup order-popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-header text-center">
                <h4 class="sign-title">Withdraw</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url() . 'user/balances/withdraw'; ?>" method="post" id="withdraw_form" name="withdraw_form">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="real_balances" id="real_balances" />
                            <div id="balances_title" style="font-size: 18px; color: #777; font-weight: 500;"></div>
                        </div>
                        <input type="hidden" name="access_token" id="access_token" value="">
                        <div class="col-md-12">
                            <div id="payment-method">
                                <h4 class="clearfix">
                                    <?php echo (!empty($user_language[$user_selected]['lg_select_your_payment_method'])) ? $user_language[$user_selected]['lg_select_your_payment_method'] : $default_language['en']['lg_select_your_payment_method']; ?>
                                </h4>
                                <div class="payment-method">
                                    <?php if ($paypal_allow == 1) { ?>
                                        <label class="radio-inline bold">
                                            <input class="le-radio" type="radio" onchange="check_withdraw_type(this)" name="group2" value="paypal">
                                            <img src="<?php echo base_url(); ?>assets/images/paypal-icon.png"
                                                 alt="Paypal" width="24"
                                                 height="22">
                                            <?php echo (!empty($user_language[$user_selected]['lg_paypal'])) ? $user_language[$user_selected]['lg_paypal'] : $default_language['en']['lg_paypal']; ?>
                                        </label>
                                    <?php } ?>

                                </div>
                            </div>
                            <div>
                                <button type="submit" id="withdraw_submit_btn" style="display: none;" class="btn btn-green buyitnow-btn" value="true" name="submit">
                                    Withdarw
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

<div id="deposit-popup" class="modal fade custom-popup order-popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-header text-center">
                <h4 class="sign-title">Deposit</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url() . 'user/balances/deposit'; ?>" method="post" id="deposit_form" name="deposit_form">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="number" placeholder="Please Enter the Deposit Amount" id="deposit_amount" name="deposit_amount" class="form-control" min="0" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="deposit_currency" name="deposit_currency" class="form-control" required>
                                    <?php for($i=0; $i<count($all_currencies); $i++) { ?>
                                        <option value="<?php echo $all_currencies[$i]['currency']; ?>"><?php echo $all_currencies[$i]['currency']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="access_token" id="access_token" value="">
                        <div class="col-md-12">
                            <div id="payment-method">
                                <h4 class="clearfix">
                                    <?php echo (!empty($user_language[$user_selected]['lg_select_your_payment_method'])) ? $user_language[$user_selected]['lg_select_your_payment_method'] : $default_language['en']['lg_select_your_payment_method']; ?>
                                </h4>
                                <div class="payment-method">
                                    <?php if ($paypal_allow == 1) { ?>
                                        <label class="radio-inline bold">
                                            <input class="le-radio" type="radio" onchange="check_deposit_type(this)" name="group2" value="paypal">
                                            <img src="<?php echo base_url(); ?>assets/images/paypal-icon.png"
                                                 alt="Paypal" width="24"
                                                 height="22">
                                            <?php echo (!empty($user_language[$user_selected]['lg_paypal'])) ? $user_language[$user_selected]['lg_paypal'] : $default_language['en']['lg_paypal']; ?>
                                        </label>
                                    <?php } ?>

                                </div>
                            </div>
                            <div>
                                <button type="submit" id="deposit_submit_btn" style="display: none;" class="btn btn-green buyitnow-btn" value="true" name="submit">
                                    Deposit
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