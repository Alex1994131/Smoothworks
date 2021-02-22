<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="page-title m-b-20 m-t-0">Membership Detail</h4>
                </div>
                <div class="col-sm-8 text-right m-b-20">
                    <a href="<?php echo base_url() . 'admin/membership_detail/create_detail'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Membership Detail</a>
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
                                    <th>name</th>
                                    <th>key</th>
                                    <th>group</th>
                                    <th class="text-right" width="100px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($list)) {
                                    foreach ($list as $item) {
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" class="checkBoxClass" value="<?php echo $item['id']; ?>"/></td>
                                            <td><?php echo $item['name'] ?></td>
                                            <td><?php echo $item['key'] ?></td>
                                            <td><?php echo $item['group_name']; ?></td>
                                            <td class="text-right">
                                                <a  href="<?php echo base_url() .'admin/membership_detail/edit_detail/'.$item['id'] ?>" class="table-action-btn" title="Edit">
                                                    <i class="mdi mdi-pencil text-success"></i>
                                                </a>
                                                <a href="#" onclick="delete_membership_detail(<?php echo $item['id'] ?>)" class="table-action-btn" title="Delete">
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
                                        <form method="post" id="multi_deletes_form" action="<?php echo base_url(); ?>admin/membership/multiple_delete_detail">
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