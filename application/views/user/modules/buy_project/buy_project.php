<?php
//$this->load->view('user/includes/search_include');
$rate_symbol = currency_sign($currency_option);
?>
<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb menu-breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a>
                        <i class="fa fa fa-chevron-right"></i></li>
                    <li class="active"><?php echo (!empty($user_language[$user_selected]['lg_buy'])) ? $user_language[$user_selected]['lg_buy'] : $default_language['en']['lg_buy']; ?></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="header-title">
                    <?php echo (!empty($user_language[$user_selected]['lg_buy_project'])) ? $user_language[$user_selected]['lg_buy_project'] : $default_language['en']['lg_buy_project']; ?>
                    <span>
                        <?php echo $total_records; ?>
                        <?php echo (!empty($user_language[$user_selected]['lg_projects_found'])) ? $user_language[$user_selected]['lg_projects_found'] : $default_language['en']['lg_projects_found']; ?>
                    </span>
                </h3>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="project-container">
                <form method="post" autocomplete="off" action="<?php echo base_url(); ?>buy-project">
                    <div class="search-body" style="display: flex; align-items: center; justify-content: space-between; margin: 30px 0;">
                        <input value="<?php if (isset($_POST["keyword"]) && !empty($_POST["keyword"])) echo $_POST["keyword"]; ?>"
                            type="text" placeholder="Project Title" class="form-control search-condition"
                            name="keyword">
                        <select class="form-control search-category" id="changecatetext" name="search_category">
                            <option value="0"><?php echo (!empty($user_language[$user_selected]['lg_all_categories'])) ? $user_language[$user_selected]['lg_all_categories'] : $default_language['en']['lg_all_categories']; ?></option>
                            <?php
                            foreach ($categories_subcategories as $cat) {
                                if ($cat['parent'] == 0) {
                                    $query = $this->db->query("SELECT `CATID` , `name` FROM `categories` WHERE `parent` = " . $cat['CATID'] . " and status=0 and delete_sts = 0");
                                    $result = $query->result_array();
                                    $result_count = $query->num_rows();
                                    ?>
                                    <option class="category_main_menu" value="<?php echo $cat['CATID']; ?>"
                                        <?php if ($cat['CATID'] == $selected_category_value) {
                                            echo "selected";
                                        } ?> > <?php echo $cat['name']; ?>
                                    </option>

                                <?php
                                    if ($result_count > 0) {
                                        foreach ($result as $sub_category_list) { ?>
                                            <option class="sub_category_menu" value="<?php echo $sub_category_list['CATID']; ?>"
                                                <?php if ($sub_category_list['CATID'] == $selected_category_value) {
                                                    echo "selected";
                                                } ?>> <?php echo $sub_category_list['name']; ?>
                                            </option>
                                        <?php }
                                    }
                                }
                            }
                            ?>
                        </select>
                        <button name="form_submit" value="true" type="submit" class="btn btn-primary search_btn">Search</button>
                    </div>
                </form>
                <?php
                if (!empty($project_data)) {

                foreach ($project_data as $item) {

                        ?>
                        <a class="project-area" href="<?php echo base_url().'project-preview/'.$item['id']; ?>">
                            <div class="project-icon">
                                <i class="fa fa-tasks" style="font-size:32px;"></i>
                            </div>
                            <div class="project-content">
                                <h3 class="project-title"><?php echo ucfirst(str_replace("-", " ", $item['title'])); ?></h3>
                                <p class="project-detail">
                                    <?php echo $item['detail']; ?>
                                </p>
                                <div class="project-state">
                                    <span><i class="fa fa-history" style="font-size:16px;"></i> <?php echo $item['date'];?></span>
                                    <span class="text-dark"><i class="fa fa-envelope" style="font-size:16px;"></i>  <b><?php echo $item['bids'].'-'.((!empty($user_language[$user_selected]['lg_bids'])) ? $user_language[$user_selected]['lg_bids'] : $default_language['en']['lg_bids']); ?></b></span>
                                </div>
                                <span class="project-category"><i class="fa fa-sitemap" style="font-size:16px;"></i> <?php echo $item['category']; ?></span>
                            </div>
                            <h3 class="project-price"><?Php echo $item['price'].$rate_symbol;?></h3>
                        </a>
                    <?php }

                } else { ?>
                    <div class="search-area">
                        <p class="text-center text-danger m-b-0"><?php echo (!empty($user_language[$user_selected]['lg_no_projects_found'])) ? $user_language[$user_selected]['lg_no_projects_found'] : $default_language['en']['lg_no_projects_found']; ?></p>
                    </div>
                <?php } ?>
            </div>
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
