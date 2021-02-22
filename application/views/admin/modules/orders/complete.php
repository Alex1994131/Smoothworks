<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title m-b-20 m-t-0">Completed Orders</h4>
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
                                    <th>Payment Gateway</th>
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
                                                if($item['remark'] == 'membership') {
                                                    echo 'User purhcased membership.';
                                                }
                                                else if($item['remark'] == 'milestone') {
                                                    echo 'User create Milestone and pay price for the project.';
                                                }
                                                else if($item['remark'] == 'project fee') {
                                                    echo 'User pay the fee of project during accept the project award.';
                                                }
                                                else if($item['remark'] == 'withdraw') {
                                                    echo 'User suggest the withdraw of his balances';
                                                }
                                                else if($item['remark'] == 'project commission') {
                                                    echo 'User obtained project commission as complete the project.';
                                                }
                                                else if($item['remark'] == 'affiliate fee') {
                                                    echo 'User obtained affiliate fee, user you suggested get the project commission.';
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $item['currency_sign'] . $item['price']; ?></td>
                                        <td><?php echo $item['pay_method']; ?></td>
                                    </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4"><p class="text-danger text-center m-b-0">No Records Found</p>
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
<script>
    function change_payments_status(id, ele) {
        bootbox.confirm("Are you sure want to UPDATE ? ", function (result) {
            //alert(result)
            if (result == true) {
                var url = BASE_URL + 'admin/request/update_payment_status';
                $.ajax({
                    url: url,
                    data: {id: id},
                    type: "POST",
                    success: function (res) {
                        if (res == 1) {
                            $("#" + ele).html('<span class="label label-info">Paid</span>');
                        }
                    }
                });
            }
        });
    }
</script>