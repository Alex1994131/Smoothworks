<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title m-b-20 m-t-0">Financial </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <ul class="nav nav-tabs navtab-bg nav-justified">
                                <li class="tab"><a href="<?php echo base_url() . 'admin/financial/affiliate'; ?>">Affiliate</a></li>
                                <li class="active tab"><a href="<?php echo base_url() . 'admin/financial/membership'; ?>">Membership</a></li>
                                <li class="tab"><a href="<?php echo base_url() . 'admin/financial/commission'; ?>">Commission</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="membership" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4 class="page-title m-b-20 m-t-0">Membership</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4 class="page-title m-b-20 m-t-0 m-r-10" style="text-align: right; ">
                                                All Membership: $
                                                <?php 
                                                    $all_membership_amount = 0;
                                                    for($i = 0; $i<count($list); $i++) { 
                                                        $all_membership_amount += $list[$i]['price'];
                                                    }
                                                    
                                                    echo $all_membership_amount;
                                                ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card-box m-b-0">
                                                <div class="table-responsive">
                                                    <table class="table table-actions-bar table-striped releasetable m-b-0">
                                                        <thead>
                                                        <tr>
                                                            <th>Order Date</th>
                                                            <th>User</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        if (!empty($list)) {
                                                            foreach ($list as $item) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $item['created_date']; ?></td>
                                                                    <td><?php echo $item['buyer_name']; ?></td>
                                                                    <td>
                                                                        <?php 
                                                                            $membership_id = $item['item_id'];
                                                                            $user_id = $item['user_id'];
                                                                            
                                                                            $query = $this->db->query("select * from members where USERID = $user_id");
                                                                            $result = $query->result_array();
                                                                            $membership_type = $result['membership_type'];

                                                                            $membership_type_label = '';
                                                                            if($membership_type == 1) {
                                                                                $membership_type_label = 'Monthly';
                                                                            }
                                                                            else if($membership_type == 2) {
                                                                                $membership_type_label = 'Quarterly';
                                                                            }
                                                                            else {
                                                                                $membership_type_label = 'Annually';
                                                                            }
                                                                            
                                                                            echo 'User purchased ' . $item['membership_title'] .' membership(' . $membership_type_label . ').';
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $item['currency_sign'] . $item['price']; ?></td>
                                                                </tr>
                                                            <?php }
                                                        } else { ?>
                                                            <tr>
                                                                <td colspan="5"><p class="text-danger text-center m-b-0">No Records Found</p>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
