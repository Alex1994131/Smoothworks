function detail_user(user_id) {
    var user_detail = main_list[user_id];

    var photourl = base_url;

    if(user_detail['profileurl'] != '') {
        photourl += user_detail['profileurl'];
    }
    else{
        photourl += 'assets/images/user.jpg';
    }
    $("#detail_avatar").attr('src', photourl);
    $("#detail_name").html(user_detail['username']);
    $("#detail_email").html(user_detail['email']);

    $("#detail_modal").modal();
}

function invite_modal() {
    $("#invite_modal").modal();
}

function exit_person(user_id) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete!',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger ml-1',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            var session_user_id = $("#user_id").val();

            if(session_user_id == user_id) {
                var user_name = $("#user_name").val();

                var message = user_name + " suggested to exit your team. Do you accept his suggestion?";

                firebase.firestore().collection("notification").add({
                    from_user_id: user_id,
                    from_user_name: $("#user_name").val(),
                    from_user_avatar: $("#user_avatar").val(),
                    to_user_id: $("#leader_id").val(),
                    message: message,
                    flag: '0',
                    kind: 'exit-101',
                    send_time: firebase.firestore.FieldValue.serverTimestamp()
                })
                .then((ref) => {
                    console.log("Added doc with ID: ", ref.id);
                });
            }
            else {
                var leader_id = $("#leader_id").val();
                var leader_name = $("#leader_name").val();
                var leader_avatar = $("#leader_avatar").val();

                var message = leader_name + " suggested you to exit your team. Do you accept his suggestion?";

                firebase.firestore().collection("notification").add({
                    from_user_id: leader_id,
                    from_user_name: leader_name,
                    from_user_avatar: leader_avatar,
                    to_user_id: user_id,
                    message: message,
                    flag: '0',
                    kind: 'exit-102',
                    send_time: firebase.firestore.FieldValue.serverTimestamp()
                })
                .then((ref) => {
                    console.log("Added doc with ID: ", ref.id);
                    location.reload();
                });
            }
        }
    })
}

function invite_person(user_id) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete!',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger ml-1',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            var leader_id = $("#leader_id").val();
            var leader_name = $("#leader_name").val();
            var leader_avatar = $("#leader_avatar").val();

            var message = leader_name + "suggested to take part in his team. Do you accept his suggestion?";

            firebase.firestore().collection("notification").add({
                from_user_id: leader_id,
                from_user_name: leader_name,
                from_user_avatar: leader_avatar,
                to_user_id: user_id,
                message: message,
                flag: '0',
                kind: 'invite',
                send_time: firebase.firestore.FieldValue.serverTimestamp()
            })
            .then((ref) => {
                console.log("Added doc with ID: ", ref.id);
                location.reload();
            });
        }
    })
}

$(document).ready(function() {
    var team_member_dataTable = $("#team_members").DataTable({});
    var freelancer_dataTable = $("#freelancers_list").DataTable({});
})