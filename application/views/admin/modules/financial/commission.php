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
                                <li class="tab"><a href="<?php echo base_url() . 'admin/financial/membership'; ?>">Membership</a></li>
                                <li class="active tab"><a href="<?php echo base_url() . 'admin/financial/commission'; ?>">Commission</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="affiliate" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4 class="page-title m-b-20 m-t-0">All Project Commission</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4 class="page-title m-b-20 m-t-0 m-r-10" style="text-align: right; ">
                                                All Commission fee: $
                                                <?php 
                                                    $all_commission_fee = 0;
                                                    for($i = 0; $i<count($list); $i++) {
                                                        if($list[$i]['remark'] == 'project fee') {
                                                            $all_commission_fee += $list[$i]['price'];
                                                        }
                                                        else {
                                                            $query = $this->db->query("select * from projects where id = " . $list[$i]['item_id']);
                                                            $result = $query->result_array();
                                                            $award_bid_id = $result[0]['award_bid'];

                                                            $query = $this->db->where("select * from bids where id = $award_bid_id");
                                                            $result = $query->result_array();
                                                            $bid_amount = $result[0]['amount'];

                                                            $fee = $list[$i]['price'] - $bid_amount;
                                                            $all_commission_fee += $fee;
                                                        }
                                                        
                                                    }
                                                    
                                                    echo $all_commission_fee;
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
                                                                            echo 'User paied fee for project(' . $item['project_title'] . ')';
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                            if($item['remark'] == 'project fee') {
                                                                                echo $item['currency_sign'] . $item['price']; 
                                                                            }
                                                                            else {
                                                                                $query = $this->db->query("select * from projects where id = " . $item['item_id']);
                                                                                $result = $query->result_array();
                                                                                $award_bid_id = $result[0]['award_bid'];
                    
                                                                                $query = $this->db->where("select * from bids where id = $award_bid_id");
                                                                                $result = $query->result_array();
                                                                                $bid_amount = $result[0]['amount'];
                    
                                                                                $fee = $item['price'] - $bid_amount;

                                                                                echo $item['currency_sign'] . $fee;
                                                                            }
                                                                        ?>
                                                                    </td>
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
                                <div id="membership" class="tab-pane active">
                                
                                </div>
                                <div id="commission" class="tab-pane active">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
