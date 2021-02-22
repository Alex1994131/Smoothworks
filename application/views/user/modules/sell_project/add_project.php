<?php
$currency_option = (!empty($currency_option)) ? $currency_option : 'USD';
$currency_sign = currency_sign($currency_option);
?>

<section class="post-gig-area">
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-sm-12">

                <h3 class="post-gig-title"><?php echo (!empty($user_language[$user_selected]['lg_post_a_project_in_few_seconds'])) ? $user_language[$user_selected]['lg_post_a_project_in_few_seconds'] : $default_language['en']['lg_post_a_project_in_few_seconds']; ?></h3>

                <p class="sub-title"></p>

                <input type="hidden" id="payment_option" value="<?php echo $price_option['value']; ?>">

                <input type="hidden" class="gig_title_valid" value="0">

                <form id="project" action="<?php echo base_url() . "save-project"; ?>" method="post" class="sell-service-form" enctype="multipart/form-data">

                    <input type="hidden" name="country_name" id="country_name" value="">

                    <input type="hidden" name="client_timezone" id="client_timezone" value="">

                    <input type="hidden" name="full_country_name" id="full_country_name" value="<?php echo @$full_country_name; ?>">

                    <input type="hidden" name="dollar_rate" id="dollar_rate" value="<?php echo $dollar_rate; ?>">

                    <input type="hidden" name="rupee_rate" id="rupee_rate" value="<?php echo $rupee_rate; ?>">

                    <div class="form-group clearfix">

                        <label class="label-title"><?php echo (!empty($user_language[$user_selected]['lg_title_for_your_project'])) ? $user_language[$user_selected]['lg_title_for_your_project'] : $default_language['en']['lg_title_for_your_project']; ?><span class="required">*</span></label>

                        <div class="name-block">
            				<span class="name-input">
								<input type="text" name="project_title" id="project_title"
                                       value="" class="form-control gig-name " maxlength="80"
                                       placeholder="<?php echo (!empty($user_language[$user_selected]['lg_require_a_website'])) ? $user_language[$user_selected]['lg_require_a_website'] : $default_language['en']['lg_require_a_website']; ?>">
							</span>

                            <span class="currency">
                                <?php echo (!empty($user_language[$user_selected]['lg_for'])) ? $user_language[$user_selected]['lg_for'] : $default_language['en']['lg_for']; ?>
                                <span class="currency-group">
                                    <?php
                                        $rate = $project_price['value'];
                                    ?>
                                    <?php echo $currency_sign; ?>
                                    <input type="text" class="form-control amount numberonly" name="project_price" onfocusout="inputfocusout(this)" id="project_price">
                                </span>
                            </span>

                        </div>

                        <small class="error_msg help-block project_title_error" style="display: none;">
                            <?php echo (!empty($user_language[$user_selected]['lg_please_enter_a_title'])) ? $user_language[$user_selected]['lg_please_enter_a_title'] : $default_language['en']['lg_please_enter_a_title']; ?>
                        </small>

                        <small class="error_msg help-block project_title_already_error" style="display: none;">
                            <?php echo (!empty($user_language[$user_selected]['lg_this_title_is_already_taken'])) ? $user_language[$user_selected]['lg_this_title_is_already_taken'] : $default_language['en']['lg_this_title_is_already_taken']; ?>
                        </small>

                        <small class="error_msg help-block project_price_error" style="display: none;">
                            <?php echo (!empty($user_language[$user_selected]['lg_please_enter_the_price_for_project'])) ? $user_language[$user_selected]['lg_please_enter_the_price_for_project'] : $default_language['en']['lg_please_enter_the_price_for_project']; ?>
                        </small>
                    </div>

                    <div class="form-group clearfix delivery-day">
                        <label class="label-title">
                            <?php echo (!empty($user_language[$user_selected]['lg_how_many_days_are_you_demand'])) ? $user_language[$user_selected]['lg_how_many_days_are_you_demand'] : $default_language['en']['lg_how_many_days_are_you_demand']; ?>
                            ? <span class="required">*</span>
                        </label>

                        <input type="text" name="delivering_time" id="delivering_time" class="form-control"
                            maxlength="2" onkeyup="max_length(this)" onblur="checkinput(this)"
                            onchange="max_length(this)"
                            placeholder="<?php echo (!empty($user_language[$user_selected]['lg_just_type_number_of_days'])) ? $user_language[$user_selected]['lg_just_type_number_of_days'] : $default_language['en']['lg_just_type_number_of_days']; ?> (<?php echo (!empty($user_language[$user_selected]['lg_ex'])) ? $user_language[$user_selected]['lg_ex'] : $default_language['en']['lg_ex']; ?>: 2 <?php echo (!empty($user_language[$user_selected]['lg_days'])) ? $user_language[$user_selected]['lg_days'] : $default_language['en']['lg_days']; ?>)">
                        <span class="actual_delivery_days" id="main_delivery_days"></span>

                        <small class="error_msg help-block main_delivery_days_error" style="display: none;">
                            <?php echo (!empty($user_language[$user_selected]['lg_please_enter_a_estimated_delivery_days'])) ? $user_language[$user_selected]['lg_please_enter_a_estimated_delivery_days'] : $default_language['en']['lg_please_enter_a_estimated_delivery_days']; ?>
                        </small>

                        <small class="error_msg help-block delivery_days_error" style="display: none;">
                            <?php echo (!empty($user_language[$user_selected]['lg_please_enter_a_days_1_to_29'])) ? $user_language[$user_selected]['lg_please_enter_a_days_1_to_29'] : $default_language['en']['lg_please_enter_a_days_1_to_29']; ?>.
                        </small>
                    </div>

                    <div class="form-group clearfix">

                        <label class="label-title">
                            <?php echo (!empty($user_language[$user_selected]['lg_pick_category'])) ? $user_language[$user_selected]['lg_pick_category'] : $default_language['en']['lg_pick_category']; ?>
                            <span class="required">*</span>
                        </label>

                        <div class="category-select">
                            <span class="">
                                <select class="select gig-category" id="project_category_id" name="project_category_id">
									<option value=""><?php echo (!empty($user_language[$user_selected]['lg_select_category'])) ? $user_language[$user_selected]['lg_select_category'] : $default_language['en']['lg_select_category']; ?></option>

										<?php foreach ($categories_subcategories as $cat) {

                                            if ($cat['parent'] == 0) {

                                                $query = $this->db->query("SELECT `CATID` , `name` FROM `categories` WHERE `parent` = " . $cat['CATID'] . " and status=0 and delete_sts = 0 ");

                                                $result = $query->result_array();

                                                $result_count = $query->num_rows();

                                                ?>
                                                <option class="categoryselected category_main_menu" value="<?php echo $cat['CATID']; ?>"> <?php echo $cat['name']; ?> </option>
										<?php
                                                if ($result_count > 0) {

                                                    foreach ($result as $sub_category_list) { ?>
                                                        <option class="sub_category_menu" value="<?php echo $sub_category_list['CATID']; ?>"> <?php echo $sub_category_list['name']; ?> </option>
                                                    <?php }
                                                }
                                            }
                                        }
                                        ?>
                                </select>
                            </span>
                            <small class="error_msg help-block project_category_id_error" style="display: none;">
                                <?php echo (!empty($user_language[$user_selected]['lg_please_select_a_category'])) ? $user_language[$user_selected]['lg_please_select_a_category'] : $default_language['en']['lg_please_select_a_category']; ?>
                            </small>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="label-title">
                            <?php echo (!empty($user_language[$user_selected]['lg_add_tags'])) ? $user_language[$user_selected]['lg_add_tags'] : $default_language['en']['lg_add_tags']; ?>
                            <span class="small-title">(<?php echo (!empty($user_language[$user_selected]['lg_separated_with_a_comma'])) ? $user_language[$user_selected]['lg_separated_with_a_comma'] : $default_language['en']['lg_separated_with_a_comma']; ?>)</span>
                        </label>

                        <input type="text"
                               placeholder="<?php echo (!empty($user_language[$user_selected]['lg_enter_your_tags'])) ? $user_language[$user_selected]['lg_enter_your_tags'] : $default_language['en']['lg_enter_your_tags']; ?>"
                               name="project_tags" id="project_tags" data-role="tagsinput" class="form-control">
                    </div>
                    <div class="form-group clearfix">
                        <label class="label-title">
                            <?php echo (!empty($user_language[$user_selected]['lg_attach_related_files'])) ? $user_language[$user_selected]['lg_attach_related_files'] : $default_language['en']['lg_attach_related_files'];?>
                        </label>
                        
                        <div class="file-upload-block">
                            <input type="hidden" id="upload_files" name="upload_files" value="">
                            <div class="col-md-3 pull-left">
                                <button class="btn btn-primary btn-block" type="button" onclick="add_file(this)"><?php echo (!empty($user_language[$user_selected]['lg_add_files'])) ? $user_language[$user_selected]['lg_add_files'] : $default_language['en']['lg_add_files']; ?></button>
                            </div>
                            <p>Drag one or more files to this Drop Zone ...</p>
                        </div>
                    </div>

                    <div class="form-group clearfix uploaded-section" style="display: none"></div>

                    <div class="form-group item-description clearfix">
                        <label class="label-title">
                            <?php echo (!empty($user_language[$user_selected]['lg_provide_more_details_about_your_project'])) ? $user_language[$user_selected]['lg_provide_more_details_about_your_project'] : $default_language['en']['lg_provide_more_details_about_your_project']; ?>
                            <span class="required">*</span>
                        </label>

                        <textarea rows="5"
                                  placeholder="<?php echo (!empty($user_language[$user_selected]['lg_explain_in_more_detail_what_exactly_you_require_from_developer'])) ? $user_language[$user_selected]['lg_explain_in_more_detail_what_exactly_you_require_from_developer'] : $default_language['en']['lg_explain_in_more_detail_what_exactly_you_require_from_developer']; ?>..."
                                  name="project_details" id="project_details" class="form-control"></textarea>

                        <small class="error_msg help-block" id="desc_err"></small>

                        <small class="error_msg help-block  project_details_error" style="display: none;">
                            <?php echo (!empty($user_language[$user_selected]['lg_please_enter_about_your_project_details'])) ? $user_language[$user_selected]['lg_please_enter_about_your_project_details'] : $default_language['en']['lg_please_enter_about_your_project_details']; ?>
                        </small>
                    </div>

                    <input type="hidden" name="form_submit" value="add">

                    <a href="javascript:void(0)" onclick="add_projects_add()"
                       class="btn btn-yellow sell_service_submit"><?php echo (!empty($user_language[$user_selected]['lg_post_your_project'])) ? $user_language[$user_selected]['lg_post_your_project'] : $default_language['en']['lg_post_your_project']; ?></a>
                </form>

            </div>

            <div class="col-md-4 hidden-xs hidden-sm">
                <div class="left-sidebar">
                    <div class="testimonials">
                        <p>
                            "<?php echo (!empty($user_language[$user_selected]['lg_if_people_understood_the_banking_system_they_would_revolt'])) ? $user_language[$user_selected]['lg_if_people_understood_the_banking_system_they_would_revolt'] : $default_language['en']['lg_if_people_understood_the_banking_system_they_would_revolt']; ?>."
                        </p>
                        <span class="client-name"><?php echo (!empty($user_language[$user_selected]['lg_henry_ford'])) ? $user_language[$user_selected]['lg_henry_ford'] : $default_language['en']['lg_henry_ford']; ?></span>
                    </div>
                    <div class="daily-figures">
                        <span>.</span><br>
                        <span><p class="figure-title">“<?php echo (!empty($user_language[$user_selected]['lg_latest'])) ? $user_language[$user_selected]['lg_latest'] : $default_language['en']['lg_latest']; ?><br><?php echo (!empty($user_language[$user_selected]['lg_daily_figures'])) ? $user_language[$user_selected]['lg_daily_figures'] : $default_language['en']['lg_daily_figures']; ?>”</p></span>
                        <span>.</span><br>
                        <span><i class="fa fa-chevron-down"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
