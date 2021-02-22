<div class="content-page">
    <?php
    if ($details['status'] == 1) {
        $checkced2 = 'checked="checked"';
        $checkced1 = '';
    } else {
        $checkced1 = 'checked="checked"';
        $checkced2 = '';
    }

    $project_id = (!empty($details['id'])) ? $details['id'] : '0';

    $currency = (!empty($details['currency_type'])) ? $details['currency_type'] : 'USD';
    $currency_sign = currency_sign($currency);
    ?>
    <div class="content">
        <div class="container">
            <div class="row">
                <section class="product-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8"><h2
                                        class="text-left"><?php echo (!empty($details['title'])) ? ucfirst(str_replace('-', ' ', $details['title'])) : ''; ?></h2>
                            </div>
                            <div class="col-md-4">
                                <h4 class="btn btn-success"><?php echo (!empty($details['project_price'])) ? 'Price ' . $currency_sign . ' ' . $details['project_price'] : ''; ?></h4>
                            </div>
                        </div>


                    </div>
                </section>
                <div class="gig-info">
                    <div class="info-top">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="gig-info-list">
                                        <span class="gig-deliver">Will deliver in <?php if ($details['delivering_time'] > 1) {
                                                echo $details['delivering_time'] . ' Days';
                                            } else {
                                                echo $details['delivering_time'] . ' Day';
                                            } ?><span class="gig-count">  </span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="view-gig-area" style="transform: none;">
                    <div class="container" style="transform: none;">
                        <div class="row" style="transform: none;">
                            <div class="col-sm-8">
                                <div class="view-left">
                                    <div class="gig-information">
                                        <?php if (!empty($details['project_details'])) { ?>
                                            <h3 class="gig-desc-title">Description</h3>
                                            <p> <?php
                                                echo $details['project_details'];
                                                ?> </p>
                                        <?php } ?>
                                        <h3 class="gig-desc-title">Attached files</h3>
                                        <?php
                                            foreach($details['project_files'] as $file)
                                            {
                                                ?>
                                                <a href="<?php echo base_url(). $file['file_path'] ?>" style="display:block" download><i class="fa fa-paperclip"></i> <?php echo array_pop(explode('/',$file['file_path'])); ?></a>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
