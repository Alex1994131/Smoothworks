
<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="page-title m-b-20 m-t-0">Membership</h4>
                </div>
                <div class="col-sm-8 text-right m-b-20">
                    <a href="<?php echo base_url() . 'admin/membership/create'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Membership</a>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')) { ?>
                <?php echo $this->session->userdata('message'); ?>
            <?php }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box m-b-0">
                        <div class="table-responsive">
                            <table class="table table-striped releasetable m-b-0">
                                <thead>
                                <tr>
                                    <th width="50px"><input type="checkbox" id="ckbCheckAll"/>#</th>
                                    <th width="100px">Title</th>
                                    <th width="100px">Classification</th>
                                    <th width="100px">Level</th>
                                    <th>Memberships</th>
                                    <th class="text-right" width="50px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($list)) {
                                    foreach ($list as $item) {
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" class="checkBoxClass" value="<?php echo $item['id']; ?>"/></td>
                                            <td><?php echo $item['title'] ?></td>
                                            <td>
                                                <?php
                                                $kind = $item['kind'] == 1? 'Freelancer': 'Client';
                                                echo $kind;
                                                ?>
                                            </td>
                                            <td>
                                                Level<?php echo $item['level']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $memberships = $item['memberships'];
                                                $membership_arr = explode(',', $memberships);

                                                $message = '';
                                                for($i=0; $i<count($membership_arr); $i++) {
                                                    for($j=0; $j<count($membership_detail); $j++) {
                                                        if($membership_arr[$i] == $membership_detail[$j]['id']) {
                                                            $message .= $membership_detail[$j]['name'];
                                                            $message .= ',';
                                                            break;
                                                        }
                                                    }
                                                }
                                                echo $message;
                                                ?>
                                            </td>
                                            <td class="text-right">
                                                <a href="<?php echo base_url() .'/admin/membership/edit/'.$item['id'] ?>" class="table-action-btn" title="Edit">
                                                    <i class="mdi mdi-pencil text-success"></i>
                                                </a>
                                                <a href="#" onclick="delete_membership(<?php echo $item['id'] ?>)" class="table-action-btn" title="Delete">
                                                    <i class="mdi mdi-window-close text-danger"></i>
                                                </a>
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
                                <?php
                                if (!empty($list)) {
                                    ?>
                                    <tfoot>
                                    <td colspan="5">
                                        <form method="post" id="multi_deletes_form" action="<?php echo base_url(); ?>admin/membership/multiple_delete">
                                            <input id="multi_Delete" type="hidden" name="multi_Delete">
                                            <input type="submit" name="" class="btn btn-primary btn-sm" value="Delete">
                                        </form>
                                    </td>
                                    </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>