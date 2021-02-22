<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="page-title m-b-20 m-t-0">Membership Group</h4>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')) { ?>
                <?php echo $this->session->userdata('message'); ?>
            <?php }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box m-b-0">
                        <form id="admin_add_membership_group" action="<?php echo base_url() . 'admin/membership/save_membership_group'; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="membership_group">Title</label>
                                <input type="text" name="membership_group" placeholder="Enter Membership Group Name"
                                       class="form-control" id="membership_group" required>
                            </div>
                            <div class="form-group m-b-0 m-t-30">
                                <button class="btn btn-primary" name="membership_group_submit" value="submit" type="submit">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>