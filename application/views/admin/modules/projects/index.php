<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php if ($this->session->flashdata('message')) { ?>
                        <p class="bg-success"><?php echo $this->session->flashdata('message'); ?></p>
                    <?php } ?>
                    <h4 class="page-title m-b-20 m-t-0">Manage Projects</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <div class="table-responsive">
                            <table class="table table-actions-bar table-striped releasetable m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Projects</th>
                                        <th>Category</th>
                                        <th>Posted User</th>
                                        <th>Price</th>
                                        <th>Created Date</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($list)) {
                                    $i = 1;
                                    $admin_country_name = $this->session->userdata('admin_country_name');

                                    foreach ($list as $item) {
                                        $rate = $item['project_price']; // Dynamic Price
                                        $currency = (!empty($item['currency_type'])) ? $item['currency_type'] : 'USD';
                                        $sign = currency_sign($currency);
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                <h2 class="text-ellipsis">
                                                    <a href="javascript:;" onclick="detail_view(<?php echo '\'pro_'.$item['project_id'].'_\''?>);"><?php echo ucfirst(str_replace('-', ' ', $item['title'])); ?></a>
                                                </h2>
                                                <input type="hidden" id="<?php echo 'pro_'.$item['project_id'].'_title'?>" value="<?php echo $item['title']?>">
                                                <input type="hidden" id="<?php echo 'pro_'.$item['project_id'].'_days'?>" value="Will deliver in <?php if ($item['project_day'] > 1) {
                                                    echo $item['project_day'] . ' Days';
                                                } else {
                                                    echo $item['project_day'] . ' Day';
                                                } ?>">
                                                <input type="hidden" id="<?php echo 'pro_'.$item['project_id'].'_files'?>" value="<?php echo $item['file_paths']?>">
                                                <input type="hidden" id="<?php echo 'pro_'.$item['project_id'].'_details'?>" value="<?php echo $item['project_details']?>">
                                                <input type="hidden" id="<?php echo 'pro_'.$item['project_id'].'_price'?>" value="<?php echo $sign . $rate?>">
                                            </td>
                                            <td><?php echo $item['category_name']; ?></td>
                                            <td><?php echo $item['fullname']; ?></td>
                                            <td><?php echo $sign . $rate; ?></td>
                                            <td><?php echo date('d M Y', strtotime(str_replace('-', '/', $item['created_date']))); ?></td>
                                            <td class="text-right">
                                                <a href="javascript:void(0)"
                                                   onclick="admin_delete_projects(<?php echo $item['project_id']; ?>)"
                                                   class="table-action-btn" title="Delete">
                                                    <i class="mdi mdi-window-close text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $i = $i + 1;
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan="10"><p class="text-danger text-center m-b-0">No Records Found</p></td>
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

<div class="modal fade" id="detail_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Project Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <section class="product-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 class="text-left" id="modal_title"></h2>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="btn btn-success" id="modal_price"></h4>
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
                                            <span class="gig-deliver" id="modal-day"></span>
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
                                            <h3 class="gig-desc-title">Description</h3>
                                            <p id="modal_details"></p>
                                            <h3 class="gig-desc-title">Attached files</h3>
                                            <div id="modal_files">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var BASE_URL = "<?php echo base_url(); ?>";
    function admin_delete_projects(id) {
        if (confirm("Are you sure you want ot delete this Project?")) {
            $.post(BASE_URL + 'admin/admin_delete_projects', {id: id}, function (result) {
                if (result) {
                    location.reload();
                }
            });

        }
    }

    function detail_view(prefix){
        document.getElementById('modal_title').innerHTML = document.getElementById(prefix+'title').value;
        document.getElementById('modal_price').innerHTML = document.getElementById(prefix+'price').value;
        document.getElementById('modal-day').innerHTML = document.getElementById(prefix+'days').value;
        document.getElementById('modal_details').innerHTML = document.getElementById(prefix+'details').value;
        strFiles = document.getElementById(prefix+'files').value;
        strInnerHTML="";
        if(strFiles != '')
        {
            listFiles = strFiles.split('#');
            for(strFile of listFiles)
            {
                strInnerHTML += "<a href=" + BASE_URL + strFile + " style='display:block' download><i class='fa fa-paperclip'></i> " + strFile.split('/').pop() + "</a>";
            }
        }
        else
        {
            strInnerHTML="No file attached"
        }
        document.getElementById('modal_files').innerHTML = strInnerHTML;
        $("#detail_modal").modal();
    }
</script>