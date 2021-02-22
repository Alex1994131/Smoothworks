<style>
    select.input-sm {
        line-height: 20px;
    }
</style>
<div class="">
    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb menu-breadcrumb">
                        <li>
                            <a href="#">
                                <?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?>
                            </a>
                            <i class="fa fa fa-chevron-right"></i>
                        </li>
                        <li class="active">
                            transaction
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">Transaction History</h3>
                </div>
            </div>
        </div>
    </section>
    <div class="tab-section grey-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">               
                    <div class="tab-list payments-tabs">
                        <ul>
                            <li class="active">
                                <a href="javascript:;">
                                    <span class="visible-xxs">
                                        <i class="fa fa-money" aria-hidden="true"></i> 
                                        <?php if ($wallet_order_count > 0) { ?>
                                            <span class="badge badge-white position-right">
                                                <?php echo $wallet_order_count; ?>
                                            </span>
                                        <?php } ?>
                                    </span>
                                    <span class="hidden-xxs">
                                        All Transactions
                                        <?php if ($wallet_order_count > 0) { ?>
                                            <span class="badge badge-white position-right">
                                                <?php echo $wallet_order_count; ?>
                                            </span>
                                        <?php } ?>
                                    </span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="<?php echo base_url() . 'purchases'; ?>">
                                    <span class="visible-xxs">
                                        <i class="fa fa-credit-card" aria-hidden="true"></i> 
                                        <?php if ($order_count > 0) { ?>
                                            <span class="badge badge-white position-right">
                                            <?php echo $order_count; ?>
                                            </span>
                                        <?php } ?>
                                    </span>

                                    <span class="hidden-xxs">
                                        Milestones
                                        <?php if ($order_count > 0) { ?>
                                            <span class="badge badge-white position-right">
                                                <?php echo $order_count; ?>
                                            </span>
                                        <?php } ?>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() . 'sales'; ?>">
                                    <span class="visible-xxs">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> 
                                        <?php if ($sell_order_count > 0) { ?>
                                            <span class="badge badge-white position-right">
                                                <?php echo $sell_order_count; ?>
                                            </span>
                                        <?php } ?>
                                    </span>
                                    <span class="hidden-xxs">
                                        Memberships
                                        <?php if ($sell_order_count > 0) { ?>
                                            <span class="badge badge-white position-right">
                                                <?php echo $sell_order_count; ?>
                                            </span>
                                        <?php } ?>
                                    </span>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content grey-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" placeholder="From Date" class="form-control" id="from_date" name="from_date" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" placeholder="To Date" value="" class="form-control" id="to_date" name="to_date">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" name="transaction_status" id="transaction_status">
                            <option value="">Select Status</option>
                            <option value="1">Request Sent </option>
                            <option value="2">Payments Received</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" name="currency_type" id="currency_type">
                            <option value="">All Currency</option>
                            <?php for($i=0; $i<count($all_currencies); $i++) { ?>
                                <option value="<?php echo $all_currencies[$i]['currency']; ?>"><?php echo $all_currencies[$i]['currency']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button id="search_btn" class="btn btn-primary" style="width: 100%;">Search</button>
                    </div>
                </div>                        
                <div class="col-md-2">
                    <div class="form-group">
                        <button id="reset_btn" class="btn btn-default" style="width: 100%;">Reset</button>
                    </div>
                </div>                        
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <div class="table-responsive order-table">                    
                        <table class="table table-actions-bar" id="all_transactions">
                            <thead>
                                <tr>
                                    <th>No</th>        
                                    <th>Date</th>
                                    <th>Transaction</th>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>