<?php
$query = $this->db->query("select * from system_settings WHERE status = 1");
$result = $query->result_array();
$gigs_payment_option = '';
if (!empty($result)) {
    foreach ($result as $data) {

        if ($data['key'] == 'gigs_payment_option') {
            $gigs_payment_option = $data['value'];
        }
    }
}


$active = $this->uri->segment(2);
?>
<div class="side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="<?php echo base_url() . 'admin'; ?>"
                       class="<?php echo (empty ($active)) ? 'active' : ''; ?>"><i class="mdi mdi-view-dashboard"></i>
                        <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'admin/category'; ?>"
                       class="<?php echo ($active == 'category') ? 'active' : ''; ?>"><i class="mdi mdi-buffer"></i>
                        <span>Category</span> </a>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'admin/gigs'; ?>"
                       class="<?php echo ($active == 'gigs') ? 'active' : ''; ?>"><i class="mdi mdi-cart"></i> <span>Gigs</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'admin/projects'; ?>"
                       class="<?php echo ($active == 'projects') ? 'active' : ''; ?>"><i class="mdi mdi-file"></i> <span>Projects</span>
                    </a>
                </li>
                <li class="has_sub">
                    <a href="#" class="">
                        <i class="mdi mdi-account"></i><span>Membership</span><span class="menu-arrow"></span>
                    </a>
                    <ul class="list-unstyled" <?php if ($module == 'membership') { ?> style="display:block" <?php } ?>>
                        <li>
                            <a href="<?php echo base_url() . 'admin/membership'; ?>" class="<?php echo ($active == 'membership') ? 'active' : ''; ?>">
                                Membership
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/membership_detail'; ?>" class="<?php echo ($active == 'membership_detail') ? 'active' : ''; ?>">
                                Detail
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/membership_group'; ?>" class="<?php echo ($active == 'membership_group') ? 'active' : ''; ?>">
                                Group
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="#" class="">
                        <i class="mdi mdi-repeat"></i>
                        <span>Transactions</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="sub-menu" <?php if ($module == 'orders' || $module == 'completed_orders' || $module == 'pending_orders' || $module == 'cancel_orders' || $module == 'decline_orders') { ?> style="display:block" <?php } ?>>
                        <li>
                            <a href="<?php echo base_url() . 'admin/orders'; ?>" class="<?php echo ($active == 'orders') ? 'active' : ''; ?>">
                                Total Transactions
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/completed_orders'; ?>" class="<?php echo ($active == 'completed_orders') ? 'active' : ''; ?>">
                                Complete Transactions
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/pending_orders'; ?>" class="<?php echo ($active == 'pending_orders') ? 'active' : ''; ?>">
                                Pending Transactions
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/cancel_orders'; ?>" class="<?php echo ($active == 'cancel_orders') ? 'active' : ''; ?>">
                                Cancelled Transactions
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/decline_orders'; ?>" class="<?php echo ($active == 'decline_orders') ? 'active' : ''; ?>">
                                Declined Transactions
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="<?php echo base_url() . 'admin/financial/affiliate'; ?>"
                       class="<?php echo ($active == 'financial') ? 'active' : ''; ?>"><i class="mdi mdi-gesture"></i> <span>Financial</span>
                    </a>
                </li>

                <?php $active_1 = $this->uri->segment(3); ?>
                <li class="has_sub">
                    <a href="#" class="">
                        <i class="mdi mdi-settings"></i>
                        <span>Settings</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="sub-menu" <?php if ($module == 'settings' || $module == 'seo_settings' || $module == 'policy_settings' || $module == 'profession') { ?> style="display:block" <?php } ?>>
                        <li>
                            <a href="<?php echo base_url() . 'admin/settings'; ?>" class="<?php echo ($active == 'settings' && $active_1 != 'smtp_config' && $active_1 != 'color') ? 'active' : ''; ?>">
                                General Settings
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/emailsettings'; ?>" class="<?php echo ($active == 'emailsettings') ? 'active' : ''; ?>">
                                Email Settings
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/settings/smtp_config'; ?>" class="<?php echo ($active_1 == 'smtp_config') ? 'active' : ''; ?>">
                                Smtp Config
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/policy_settings'; ?>" class="<?php echo ($active == 'policy_settings') ? 'active' : ''; ?>">
                                Policy Settings
                            </a>
                        </li>
                        <?php if ($this->session->userdata('id') != 2) { ?>
                        <li>
                            <a href="<?php echo base_url() . 'admin/new_updates'; ?>" class="<?php echo ($active == 'new_updates') ? 'active' : ''; ?>">
                                Updates
                            </a>
                        </li>
                        <?php } ?>

                    </ul>
                </li>

                <li>
                    <a href="<?php echo base_url() . 'admin/dashboard/terms'; ?>" class="<?php echo ($this->uri->segment(3) == 'terms') ? 'active' : ''; ?>">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>Terms</span>
                    </a>
                </li>
                <li class="has_sub">
                    <a href="#" class="">
                        <i class="mdi mdi-flag"></i>
                        <span>Language Settings</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="sub-menu" <?php if ($module == 'add_keyword') { ?> style="display:block" <?php } ?>>
                        <li>
                            <a href="<?php echo base_url() . 'admin/language/languages'; ?>" class="<?php echo ($this->uri->segment(3) == 'languages') ? 'active' : ''; ?>">
                                <span>Add Languages</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'language/keywords'; ?>" class="<?php echo ($this->uri->segment(2) == 'keywords') ? 'active' : ''; ?>">
                                Web Language Keywords
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'language/pages'; ?>" class="<?php echo ($this->uri->segment(2) == 'pages') ? 'active' : ''; ?>">
                                App Language Keywords
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="#" class="">
                        <i class="mdi mdi-cash-multiple"></i>
                        <span>Payment Settings</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="sub-menu" <?php if ($module == 'paypal_settings') { ?> style="display:block" <?php } ?>>
                        <li>
                            <a href="<?php echo base_url() . 'admin/paypal_settings'; ?>" class="<?php echo ($active == 'paypal_settings') ? 'active' : ''; ?>">
                                Paypal
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'admin/emailtemplate'; ?>" class="<?php echo ($active == 'emailtemplate') ? 'active' : ''; ?>">
                        <i class="mdi mdi-email"></i>
                        <span>Email Template</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'admin/user'; ?>" class="<?php echo ($active == 'user') ? 'active' : ''; ?>">
                        <i class="mdi mdi-account-multiple"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'admin/review'; ?>" class="<?php echo ($active == 'review') ? 'active' : ''; ?>">
                        <i class="mdi mdi-star"></i>
                        <span>Reviews</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'admin/client'; ?>" class="<?php echo ($active == 'client') ? 'active' : ''; ?>">
                        <i class="mdi mdi-account"></i>
                        <span>Our Clients</span>
                    </a>
                </li>
                <li class="has_sub">
                    <a href="#" class="">
                        <i class="mdi mdi-book-multiple"></i>
                        <span>Footer</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="sub-menu" <?php if ($module == 'footer_menu' || $module == 'footer_submenu') { ?> style="display:block" <?php } ?>>
                        <li>
                            <a href="<?php echo base_url() . 'admin/footer_menu'; ?>" class="<?php echo ($active == 'footer_menu') ? 'active' : ''; ?>">
                                Footer Widget
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/footer_submenu'; ?>" class="<?php echo ($active == 'footer_submenu') ? 'active' : ''; ?>">
                                Footer Menu
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>