<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" id="admin_avatar" value="<?php echo $admin_avatar; ?>">
                    <div class='alert alert-success text-center fade in'>
                        Your Withdraw Approve Success.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var user_id = $("#user_id").val();
        var admin_avatar = $("#admin_avatar").val();

        firebase.firestore().collection("notification").add({
            from_user_id: 'admin',
            from_user_name: 'ADMIN',
            from_user_avatar: admin_avatar,
            to_user_id: user_id,
            message: "System accept your withdraw request. Recently your balances is empty.",
            flag: '0',
            kind: 'payment',
            send_time: firebase.firestore.FieldValue.serverTimestamp()
        })
        .then((ref) => {
            console.log("Added doc with ID: ", ref.id);
        });
    });
</script>