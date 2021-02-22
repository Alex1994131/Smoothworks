$(document).ready(function () {
    get_all_notifications();
});

function get_all_notifications() {
    var user_id = $("#user_id").val();
    var html = '';
    var i = 0
    firebase.firestore().collection("notification").where('to_user_id', '==', user_id).get().then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var document = doc.data();
            var avatar = base_url + 'assets/images/avatar2.jpg';

            var display_name = document.from_user_name;
            var display_avatar = document.from_user_avatar;

            if(display_avatar == '') {
                display_avatar = avatar;
            }

            else {
                display_avatar = base_url + display_avatar;
            }

            var time = new Date(document.send_time.seconds*1000);

            var time_year = time.getFullYear();
            var time_month = time.getMonth()+1;
            if(time_month < 10) {
                time_month = '0'+time_month;
            }
            var time_day = time.getDate();
            if(time_day < 10) {
                time_day = '0' + time_day;
            }

            var time_hour = time.getHours();
            if(time_hour < 10) {
                time_hour = '0' + time_hour;
            }
            var time_minutes = time.getMinutes();
            if(time_minutes < 10) {
                time_minutes = '0' + time_minutes;
            }
            var time_seconds = time.getSeconds();
            if(time_seconds < 10) {
                time_seconds = '0' + time_seconds;
            }

            var time_html = time_year + '-' + time_month + '-'+ time_day + ' ' + time_hour + ':'+ time_minutes + ':' +time_seconds;

            var notification_kind = document.kind;
            
            var additional_html = '';
            if(notification_kind == 'invite' || notification_kind == 'exit-101' || notification_kind == 'exit-102') {
                additional_html = '<div style="display: flex; align-items: center; justify-content: space-around; width: 15%;">' +
                                    '<button onClick="accept_ok(\''+ doc.id + '\', \''+ notification_kind+ '\',' + document.from_user_id +'); " class="btn btn-primary">Accept</button>'+
                                    '<button onClick="accept_ok(\''+ doc.id + '\');" class="btn btn-danger">Cancel</button>'+
                                '</div>'
            }
            else if(notification_kind == 'accepted') {
                additional_html = '<div style="display: flex; align-items: center; justify-content: space-around; width: 15%;">' +
                    '<div style="color: #37a000;">Accepted</div>'
                '</div>';
            }
            else if(notification_kind == 'canceled') {
                additional_html = '<div style="display: flex; align-items: center; justify-content: space-around; width: 15%;">' +
                    '<div style="color: #777;">Canceld</div>'
                '</div>';
            }

            html += '<li class="list-group-item" style="display: flex;  align-items: center; justify-content: space-between;">'+
                        '<div class="notify-content" style="display:flex; align-items: center;">'+
                            '<div style="text-align: center; margin-right: 10px;">'+
                                '<img width="32" class="img-circle" src="' + display_avatar + '" alt="' + display_name + '">'+
                                '<div>' + display_name + '</div>'+
                            '</div>'+
                            '<div class="grey-text">'+
                                '<div>'+ document.message +'</div>'+
                                '<div class="time">'+ time_html +'</div>'+
                            '</div>'+
                        '</div>'+
                        additional_html+ 
                    '</li>';

            i++;

            firebase.firestore().collection("notification").doc(doc.id).update({
                flag: "1"
            })
        });

        $("#notification_list").html(html);
    });
}

function accept_ok(notification_id, notification_flag, notification_user) {

    $.ajax({
        url: base_url + 'user/team_management/accept_action_ok',
        type: 'post',
        data: {
            user_id: notification_user,
            flag: notification_flag
        },
        success: function(message) {
            if(message == 'success') {
                firebase.firestore().collection("notification").doc(notification_id).update({
                    kind: "accepted"
                });
                location.reload();
            }
        }
    })
}

function accept_cancel(notification_id) {
    
    firebase.firestore().collection("notification").doc(notification_id).update({
        kind: "canceled"
    });
    location.reload();
}