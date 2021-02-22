
<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="page-title m-b-20 m-t-0">Membership Detail</h4>
                </div>
                <div class="col-sm-8 text-right m-b-20">
                    <a href="<?php echo base_url() . 'admin/membership_detail'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Membership</a>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')) { ?>
                <?php echo $this->session->userdata('message'); ?>
            <?php }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box m-b-0">
                        <form id="admin_add_membership_detail" action="<?php echo base_url() . 'admin/membership/save_membership_detail'; ?>" method="post">
                            <input type="hidden" id="membership_detail_id" name="membership_detail_id" value="<?php echo $detail_record['id']; ?>">
                            <div class="form-group">
                                <label for="membership_detail_title">Name</label>
                                <input type="text" name="membership_detail_title" placeholder="Enter Membership Detail title" value="<?php echo $detail_record['name']; ?>"
                                       class="form-control only_alphabets" id="membership_detail_title" required>
                            </div>
                            <div class="form-group">
                                <label for="membership_detail_key">Key</label>
                                <input type="text" name="membership_detail_key" placeholder="Enter Membership Detail Key" class="form-control" id="membership_detail_key"  value="<?php echo $detail_record['key']; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="memberships">group</label>
                                <select id="membership_detail_group" name="membership_detail_group" class="form-control" required>
                                    <?php foreach ($membership_group as $group) { ?>
                                        <option value="<?php echo $group['id'] ?>" <?php echo $detail_record['group'] == $group['id']? 'selected': ''; ?>><?php echo $group['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group m-b-0 m-t-30">
                                <button class="btn btn-primary" name="membership_detail_submit" value="submit" type="submit">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>