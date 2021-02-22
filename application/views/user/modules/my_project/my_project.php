<?php
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
                    <li class="active">
                        <?php echo (!empty($user_language[$user_selected]['lg_my_projects'])) ? $user_language[$user_selected]['lg_my_projects'] : $default_language['en']['lg_my_projects']; ?>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="header-title">
                    <?php echo (!empty($user_language[$user_selected]['lg_my_projects'])) ? $user_language[$user_selected]['lg_my_projects'] : $default_language['en']['lg_my_projects']; ?>
                </h3>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="post" autocomplete="off" action="<?php echo base_url(); ?>my-project">
                <div class="search-area">
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
            <?php if($my_account_type == 1) { ?>
            <table class="table-area">
                <thead>
                <tr>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_title'])) ? $user_language[$user_selected]['lg_title'] : $default_language['en']['lg_title']; ?> </th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_total_bids'])) ? $user_language[$user_selected]['lg_total_bids'] : $default_language['en']['lg_total_bids']; ?></th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_average_budget'])) ? $user_language[$user_selected]['lg_average_budget'] : $default_language['en']['lg_average_budget']; ?></th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_my_budget'])) ? $user_language[$user_selected]['lg_my_budget'] : $default_language['en']['lg_my_budget']; ?></th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_bid_time'])) ? $user_language[$user_selected]['lg_bid_time'] : $default_language['en']['lg_bid_time']; ?></th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_action'])) ? $user_language[$user_selected]['lg_action'] : $default_language['en']['lg_action']; ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($project_data)) {
                    foreach ($project_data as $item) { ?>
                        <tr>
                            <td>
                                <h4 class="product-name2">
                                    <a href="<?php echo base_url().'project-proposals/view/'.$item['project_id']; ?>">
                                        <?php echo ucfirst(str_replace("-", " ", $item['title'])); ?>
                                    </a>
                                </h4>
                            </td>
                            <td>
                                <span><?php echo $item['total_bids']; ?></span>
                            </td>
                            <td>
                                <span><?Php echo $item['average_amount'].$rate_symbol; ?></span>
                            </td>
                            <td>
                                <span><?Php echo $item['my_amount'].$rate_symbol; ?></span>
                            </td>
                            <td>
                                <span><?Php echo $item['date']; ?></span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php echo (!empty($user_language[$user_selected]['lg_action'])) ? $user_language[$user_selected]['lg_action'] : $default_language['en']['lg_action']; ?>
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url()."project-preview/".$item['project_id']."/true"?>"><?php echo (!empty($user_language[$user_selected]['lg_edit'])) ? $user_language[$user_selected]['lg_edit'] : $default_language['en']['lg_edit']; ?></a></li>
                                        <li><a href="javascript:void(0)" onclick="delete_project(<?php echo $item['project_id']; ?>)">Delete</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                </div>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5">
                            <p class="text-center text-danger m-b-0"><?php echo (!empty($user_language[$user_selected]['lg_no_bids_found'])) ? $user_language[$user_selected]['lg_no_bids_found'] : $default_language['en']['lg_no_bids_found']; ?></p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
            <table class="table-area">
                <thead>
                <tr>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_title'])) ? $user_language[$user_selected]['lg_title'] : $default_language['en']['lg_title']; ?> </th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_category'])) ? $user_language[$user_selected]['lg_category'] : $default_language['en']['lg_category']; ?></th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_price'])) ? $user_language[$user_selected]['lg_price'] : $default_language['en']['lg_price']; ?></th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_status'])) ? $user_language[$user_selected]['lg_status'] : $default_language['en']['lg_status']; ?></th>
                    <th><?php echo (!empty($user_language[$user_selected]['lg_action'])) ? $user_language[$user_selected]['lg_action'] : $default_language['en']['lg_action']; ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($project_data)) {
                    foreach ($project_data as $item) {
                        ?>
                        <tr>
                            <td>
                                <div class="product-group">
                                    <div class="pull-left">
                                        <h4 class="product-name2">
                                            <a href="<?php echo base_url().'project-preview/'.$item['id']; ?>" onclick=""><?php echo ucfirst(str_replace("-", " ", $item['title'])); ?></a>
                                        </h4>
                                        <span class="order_date"><?php echo $item['date']; ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span><?php echo $item['category']; ?></span>
                            </td>
                            <td>
                                <span><?Php echo $item['price'].$rate_symbol; ?></span>
                            </td>
                            <td>
                                <span class="text-dark"><b><?php echo ucfirst($item['status']); ?></b></span>
                            </td>
                            <td>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5">
                            <p class="text-center text-danger m-b-0"><?php echo (!empty($user_language[$user_selected]['lg_no_projects_found'])) ? $user_language[$user_selected]['lg_no_projects_found'] : $default_language['en']['lg_no_projects_found']; ?></p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
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
