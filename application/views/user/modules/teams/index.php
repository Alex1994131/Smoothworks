<script>
   var main_list = <?php
       $temp_list = array();
       for($i=0; $i<count($main_list); $i++) {
           $temp_list[$main_list[$i]['USERID']] = $main_list[$i];
       }
       echo json_encode($temp_list);
   ?>;

   var base_url = "<?php echo base_url(); ?>";
</script>

<style>
    select.input-sm {
        line-height: 20px;
    }
</style>

<?php 
    $user_id = $this->session->userdata('SESSION_USER_ID');
        
    $query = $this->db->query("select * from members where USERID = $user_id");
    $user_record = $query->result_array();
    $user_record = $user_record[0];
    $user_name = $user_record['fullname'];
    $user_avatar = $user_record['user_thumb_image'];

    $query = $this->db->query("select * from teams where id = $team_id");
    $result = $query->result_array();
    $leader_id = $result[0]['leader_id'];

    $query = $this->db->query("select * from members where USERID = $leader_id");
    $leader_record = $query->result_array();
    $leader_name = $leader_record[0]['fullname'];
    $leader_avatar = $leader_record[0]['user_thumb_image'];
?>
<input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" id="user_name" value="<?php echo $user_name; ?>">
<input type="hidden" id="user_avatar" value="<?php echo $user_avatar; ?>">
<input type="hidden" id="leader_id" value="<?php echo $leader_id; ?>">
<input type="hidden" id="leader_name" value="<?php echo $leader_name; ?>">
<input type="hidden" id="leader_avatar" value="<?php echo $leader_avatar; ?>">

<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb menu-breadcrumb">
                    <li>
                        <a href="#"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a>
                        <i class="fa fa fa-chevron-right"></i></li>

                    <li class="active"><?php echo (!empty($user_language[$user_selected]['lg_team_management'])) ? $user_language[$user_selected]['lg_team_management'] : $default_language['en']['lg_team_management']; ?></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h3 class="header-title"><?php echo (!empty($user_language[$user_selected]['lg_team_management'])) ? $user_language[$user_selected]['lg_team_management'] : $default_language['en']['lg_team_management']; ?></h3>
            </div>
            <div class="col-md-4">
                <a href="javascript:void(0)" onclick="invite_modal()" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> Invite Developer
                </a>
            </div>
        </div>
    </div>
</section>
<div class="tab-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-actions-bar table-striped releasetable" id="team_members">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>PHOTO</th>
                            <th>NAME</th>
                            <th>E-mail</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($main_list) != 0) {
                            $i = 1;
                            foreach ($main_list as $item) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <a href="javascript:;" onclick="">
                                            <?php
                                                if($item['user_thumb_image'] == '') {
                                            ?>
                                            <img class="img-circle" src="<?php echo base_url(); ?>/assets/images/avatar2.jpg" alt="" width="35" height="34">
                                            <?php } else { ?>
                                            <img class="img-circle" src="<?php echo base_url() . $item['user_thumb_image']; ?>" alt="" width="35" height="34">
                                            <?php } ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $item['username']; ?>
                                    </td>
                                    <td>
                                        <?php echo $item['email']; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" onclick="exit_person('<?php echo $item['USERID']; ?>')" class="table-action-btn" title="EXit">
                                            <i class="fa fa-close text-danger"></i>
                                        </a>
                                         <a href="#" onclick="detail_user('<?php echo $item['USERID'] ?>')" class="table-action-btn" title="Detail">
                                             <i class="fa fa-search text-success"></i>
                                         </a>
                                    </td>
                                </tr>

                                <?php
                                $i = $i + 1;
                            }
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

<div id="detail_modal" class="modal  fade in" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title">Developer Detail </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="detail_avatar" src="" class="rounded" width="200" height="200">
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">Name:</div>
                            <div class="col-md-8" id="detail_name"></div>
                            <div class="col-md-4">Email</div>
                            <div class="col-md-8" id="detail_email"></div>
                            <div class="col-md-4">Main Skill</div>
                            <div class="col-md-8" id="detail_skill"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="invite_modal" class="modal  fade in" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title">Developer Invite </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive order-table">
                            <table class="table table-actions-bar table-striped releasetable" id="freelancers_list">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PHOTO</th>
                                    <th>NAME</th>
                                    <th>E-mail</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (count($developer_list) != 0) {
                                    $i = 1;
                                    foreach ($developer_list as $item) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                <a href="javascript:;" onclick="">
                                                    <?php
                                                    if($item['user_thumb_image'] == '') {
                                                        ?>
                                                        <img class="img-circle" src="<?php echo base_url(); ?>/assets/images/avatar2.jpg" alt="" width="35" height="34">
                                                    <?php } else { ?>
                                                        <img class="img-circle" src="<?php echo base_url(). $item['user_thumb_image']; ?>" alt="" width="50" height="34">
                                                    <?php } ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $item['username']; ?>
                                            </td>
                                            <td>
                                                <?php echo $item['email']; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" onclick="invite_person('<?php echo $item['USERID']; ?>')" class="table-action-btn" title="Invite">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <?php
                                        $i = $i + 1;
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan="5"><p class="text-danger text-center m-b-0">No Records Found</p></td>
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
