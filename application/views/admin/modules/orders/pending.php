<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title m-b-20 m-t-0">Pending Orders</h4>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')) { ?>
                <div class='alert alert-success text-center fade in' id='flash_succ_message'><?php echo $this->session->userdata('message'); ?></div>
            <?php }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box m-b-0">
                        <div class="table-responsive">
                            <table class="table table-actions-bar table-striped releasetable m-b-0">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Payment Gateway</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($list)) {
                                    foreach ($list as $item) {
                                ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    if($item['created_date'] == $item['updated_date']) {
                                                        echo $item['created_date']; 
                                                    }
                                                    else {
                                                        echo $item['updated_date']; 
                                                    }
                                                    
                                                ?>
                                            </td>
                                            <td><?php echo $item['buyer_name']; ?></td>
                                            <td>
                                                <?php 
                                                    if($item['remark'] == 'membership') {
                                                        echo 'User purhcased membership. but it is pending';
                                                    }
                                                    else if($item['remark'] == 'milestone') {
                                                        echo 'User create Milestone and pay price for the project. but it is pending. you must approve it.';
                                                    }
                                                    else if($item['remark'] == 'project fee') {
                                                        echo 'User pay the fee of project during accept the project award.';
                                                    }
                                                    else if($item['remark'] == 'withdraw') {
                                                        echo 'User suggest the withdraw of his balances. but it is pending. you must approve it.';
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
                                            <td style="text-align: center;">
                                                <button type="button" class="btn btn-primary" onclick="approve_payment('<?php echo $item['transaction_id']?>', '<?php echo $item['remark']; ?>')">Approve</button>
                                                <!-- <button type="button" class="btn btn-danger" onclick="decline_payment()">Decline</button> -->
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4"><p class="text-danger text-center m-b-0">No Records Found</p></td>
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

<div id="checkout-popup" class="modal fade custom-popup order-popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-header text-center">
                <h4 class="sign-title">Withdraw Deposit</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url() . 'admin/orders/payment'; ?>" method="post" id="payment_formid" name="payment_submit">
                    <div class="row">
                        <input type="hidden" name="transaction_id" id="transaction_id" value="">
                        <input type="hidden" name="access_token" id="access_token" value="">
                        <div class="col-md-12">
                            <div id="payment-method">
                                <h4 class="clearfix">
                                    Select Your Payment
                                </h4>
                                <div class="payment-method">
                                    <label class="radio-inline bold">
                                        <input class="le-radio" type="radio" onchange="check_payment_type(this)" name="group2" value="paypal">
                                        <img src="<?php echo base_url(); ?>assets/images/paypal-icon.png" alt="Paypal" width="24" height="22">
                                        Paypal
                                    </label>
                                    
                                </div>
                            </div>
                            <div>
                                <button type="submit" id="payment_btn" style="display: none;" class="btn btn-green buyitnow-btn" value="true" name="submit">
                                    Approve
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

<script>
    function approve_payment(transaction_id, remark) {

        if(remark != 'withdraw') {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok!',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: false,
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: BASE_URL + 'admin/orders/approve_payment',
                        type: 'post',
                        data: {
                            transaction_id: transaction_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            for(var i=0; i<response.length; i++) {
                                var result = response[i];
                                var flag = result.flag;

                                if(flag == 'success') {
                                    var user_id = result.user_id;
                                    var message = result.message;
                                    var admin_avatar = result.admin_avatar;

                                    firebase.firestore().collection("notification").add({
                                        from_user_id: 'admin',
                                        from_user_name: 'ADMIN',
                                        from_user_avatar: admin_avatar,
                                        to_user_id: user_id,
                                        message: message,
                                        flag: '0',
                                        kind: 'payment',
                                        send_time: firebase.firestore.FieldValue.serverTimestamp()
                                    })
                                    .then((ref) => {
                                        console.log("Added doc with ID: ", ref.id);
                                    });
                                }
                            }
                        }
                    })
                }
            })
        }
        else {
            $("#transaction_id").val(transaction_id);
            $("#checkout-popup").modal();
        }
    }

    function check_payment_type(e) {
        $('#payment_btn').show();
    }

    function decline_payment() {
        
    }
</script>