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
                        <i class="fa fa fa-chevron-right"></i>
                    </li>
                    <li class="active">
                        User Registeration
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="header-title">
                    User Registeration
                </h3>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin: 30px 0;">
            <form id="affiliate_users_register" class="form-horizontal">
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
                <input type="hidden" id="affiliate_user_id" name="affiliate_user_id" value="<?php echo $affiliate_user_id; ?>">

                <div class="form-group">
                    <label class="col-lg-2">
                        <?php echo (!empty($user_language[$user_selected]['lg_name'])) ? $user_language[$user_selected]['lg_name'] : $default_language['en']['lg_name']; ?>
                    </label>
                    <div class="col-lg-10">
                        <input type="text" 
                            placeholder="<?php echo (!empty($user_language[$user_selected]['lg_name'])) ? $user_language[$user_selected]['lg_name'] : $default_language['en']['lg_name']; ?>"
                            id="affiliate_name" name='name' class="form-control alphaonly" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2"><?php echo (!empty($user_language[$user_selected]['lg_email'])) ? $user_language[$user_selected]['lg_email'] : $default_language['en']['lg_email']; ?></label>
                    <div class="col-lg-10">
                        <input type="email"
                            placeholder="<?php echo (!empty($user_language[$user_selected]['lg_email'])) ? $user_language[$user_selected]['lg_email'] : $default_language['en']['lg_email']; ?>"
                            id="affiliate_email" name='email' class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2">
                        <?php echo (!empty($user_language[$user_selected]['lg_username'])) ? $user_language[$user_selected]['lg_username'] : $default_language['en']['lg_username']; ?>
                    </label>
                    <div class="col-lg-10">
                        <input type="text" name="username" minlength=5 id="affiliate_username"
                            class="form-control alphaonly noSpacesField"
                            placeholder="<?php echo (!empty($user_language[$user_selected]['lg_username'])) ? $user_language[$user_selected]['lg_username'] : $default_language['en']['lg_username']; ?>"
                            autocomplete="off" required>
                    </div>
                    <div id="username_suggestion" style="display: none;">
                        <input type="hidden" name="hidden_field">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2">
                        <?php echo (!empty($user_language[$user_selected]['lg_password'])) ? $user_language[$user_selected]['lg_password'] : $default_language['en']['lg_password']; ?>
                    </label>
                    <div class="col-lg-10">
                        <input type="password"
                            placeholder="<?php echo (!empty($user_language[$user_selected]['lg_password'])) ? $user_language[$user_selected]['lg_password'] : $default_language['en']['lg_password']; ?>"
                            class="form-control" id="affiliate_reg_password" name="Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2">
                        <?php echo (!empty($user_language[$user_selected]['lg_repeat_password'])) ? $user_language[$user_selected]['lg_repeat_password'] : $default_language['en']['lg_repeat_password']; ?>
                    </label>
                    <div class="col-lg-10">
                        <input type="password"
                            placeholder="<?php echo (!empty($user_language[$user_selected]['lg_repeat_password'])) ? $user_language[$user_selected]['lg_repeat_password'] : $default_language['en']['lg_repeat_password']; ?>"
                            class="form-control" id="affiliate_repeatpassword" name="RepeatPassword" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2">
                        <?php echo (!empty($user_language[$user_selected]['lg_country'])) ? $user_language[$user_selected]['lg_country'] : $default_language['en']['lg_country']; ?>
                    </label>
                    <div class="col-lg-10">
                        <select name="country_id" id="affiliate_country_id" class="form-control" required>
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
                    <label class="col-lg-2">
                        <?php echo (!empty($user_language[$user_selected]['lg_state'])) ? $user_language[$user_selected]['lg_state'] : $default_language['en']['lg_state']; ?>
                    </label>
                    <div class="col-lg-10">
                        <select name="state_id" id="affiliate_state_id" class="form-control" required>
                            <option value=""><?php echo (!empty($user_language[$user_selected]['lg_select_state'])) ? $user_language[$user_selected]['lg_select_state'] : $default_language['en']['lg_select_state']; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group text-center">
                    <input type="hidden" id="affiliate_account_type_id" name="account_type_id" value="1">
                    <button type="button" class="btn btn-default active" onclick="affiliate_dev_check();" id="affiliate_developer_check">
                        Register as Freelancer
                    </button>

                    <button type="button" class="btn btn-default" onclick="affiliate_cli_check();" id="affiliate_client_check">
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
                <span id="affiliate_register_success"> </span>
            </form>
        </div>
    </div>
</div>
<script>
    function affiliate_dev_check() {
        $("#affiliate_client_check").removeClass('active');
        $("#affiliate_developer_check").addClass('active');
        $("#affiliate_account_type_id").val(1);
    }

    function affiliate_cli_check() {
        $("#affiliate_developer_check").removeClass('active');
        $("#affiliate_client_check").addClass('active');
        $("#affiliate_account_type_id").val(2);
    }
</script>