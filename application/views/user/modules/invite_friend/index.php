<style>
    select.input-sm {
        line-height: 20px;
    }
</style>

<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb menu-breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a>
                        <i class="fa fa fa-chevron-right"></i></li>
                    <li class="active">
                        Invite Friends
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="header-title">
                    Invite Friends
                </h3>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin: 30px 0;">
            <div class="input-group">
                <input type="text" class="form-control" id="affiliate_url" value="<?php echo $affiliate_url; ?>" readonly>
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="button" id="copy_btn" onclick="copy_url()">Copy</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function copy_url() {
        var copyText = document.getElementById("affiliate_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
    }
</script>