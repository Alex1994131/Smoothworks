<style>
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        padding: 3px 10px!important;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        height: 37px!important;
    }
</style>
<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="page-title m-b-20 m-t-0">Membership</h4>
                </div>
                <div class="col-sm-8 text-right m-b-20">
                    <a href="<?php echo base_url() . 'admin/membership'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Go to List</a>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')) { ?>
                <?php echo $this->session->userdata('message'); ?>
            <?php }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box m-b-0">
                        <form id="membership_form" name="membership_name" action="<?php echo base_url() . 'admin/membership/save_membership'; ?>" method="post">
                            <input type="hidden" id="membership_id" name="membership_id" value="<?php echo $membership_record['id']; ?>">
                            <div class="form-group">
                                <label for="membership_title">Title</label>
                                <input type="text" name="membership_title" class="form-control only_alphabets" id="membership_title" value="<?php echo $membership_record['title']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="membership_kind">Classification</label>
                                <select id="membership_kind" name="membership_kind" class="form-control">
                                    <?php if($membership_record['kind'] == 1) { ?>
                                        <option value="1" selected >Freelancer</option>
                                        <option value="2">Client</option>
                                    <?php } else { ?>
                                        <option value="1">Freelancer</option>
                                        <option value="2" selected>Client</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="membership_level">Level</label>
                                <input type="number" name="membership_level" class="form-control only_alphabets" id="membership_level" value="<?php echo $membership_record['level']; ?>" required min="1" step="1" max="3">
                            </div>
                            <div class="form-group">
                                <label for="memberships">Memberships</label>
                                <?php
                                    $memberships = explode(',', $membership_record['memberships']);
                                ?>
                                <select id="memberships" name="memberships[]" class="form-control select2-multiple" multiple="multiple" required>
                                    <?php foreach ($membership_detail as $detail) { ?>
                                        <?php $flag = 0; ?>
                                        <?php foreach($memberships as $membership) {?>
                                            <?php if($membership == $detail['id']) {
                                                $flag = 1;
                                                break;
                                            } ?>
                                        <?php } ?>
                                        <?php if($flag == 1) { ?>
                                            <option value="<?php echo $detail['id'] ?>" selected><?php echo $detail['name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $detail['id'] ?>"><?php echo $detail['name']; ?></option>
                                        <?php  } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group m-b-0 m-t-30">
                                <button class="btn btn-primary" name="membership_submit" id="membership_submit"  value="submit" type="submit">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>