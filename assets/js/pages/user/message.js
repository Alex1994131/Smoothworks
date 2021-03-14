var group_data = [];
$(document).ready(function () {
    var group_id = $("#group_id").val();

    if(group_id != '') {
        get_all_chats(group_id);
    }
    else {
        get_all_chats('');
    }

    get_new_message();
    $("#chat_message_content").on('keyup', function(e) {
        if(e.keyCode == 13) {
            save_chat();
        }
    })
});

function get_all_chats(group_id) {
    var session_user_id = $("#session_user_id").val();
    var html = '';
    var i = 0
    firebase.firestore().collection("group").where('members', 'array-contains', session_user_id).get().then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var document = doc.data();
            var avatar = base_url + 'assets/images/avatar2.jpg';

            group_data.push(document.group_id);

            var display_name = document.from_user_name;
            var display_avatar = document.from_user_avatar;

            if(document.from_id == session_user_id) {
                display_name = document.to_user_name;
                display_avatar = document.to_user_avatar;
            }

            if(display_avatar == '') {
                display_avatar = avatar;
            }
            else {
                display_avatar = base_url + display_avatar;
            }

            var time = new Date(document.last_time.seconds*1000);
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

            if(group_id == '') {
                if(i==0) {
                    html += '<a href="javascript:;" class="list-group-item active" id="'+ document.group_id +'" onClick="chat_details(\''+ document.group_id +'\');">'+
                        '<img src="'+ display_avatar +'" class="pull-left w-40 m-r img-circle" alt="">'+
                        '<div class="clear">'+
                        '<span class="msg-user-name">'+ display_name +'</span>'+
                        '<span>'+
                        '<span class="time-text pull-right">'+ time_html +'</span>'+
                        '<span class="clear text-ellipsis text-xs msg-text">'+ document.last_content +'</span>'+
                        '</span>'+
                        '</div>'+
                        '</a>';

                    chat_details(document.group_id)
                }
                else {
                    html += '<a href="javascript:;" class="list-group-item" id="'+ document.group_id +'" onClick="chat_details(\''+ document.group_id +'\');">'+
                        '<img src="'+ display_avatar +'" class="pull-left w-40 m-r img-circle" alt="">'+
                        '<div class="clear">'+
                        '<span class="msg-user-name">'+ display_name +'</span>'+
                        '<span>'+
                        '<span class="time-text pull-right">'+ time_html +'</span>'+
                        '<span class="clear text-ellipsis text-xs msg-text">'+ document.last_content +'</span>'+
                        '</span>'+
                        '</div>'+
                        '</a>';
                }
            }
            else {
                if(document.group_id == group_id) {
                    html += '<a href="javascript:;" class="list-group-item active" id="'+ document.group_id +'" onClick="chat_details(\''+ document.group_id +'\');">'+
                        '<img src="'+ display_avatar +'" class="pull-left w-40 m-r img-circle" alt="">'+
                        '<div class="clear">'+
                        '<span class="msg-user-name">'+ display_name +'</span>'+
                        '<span>'+
                        '<span class="time-text pull-right">'+ time_html +'</span>'+
                        '<span class="clear text-ellipsis text-xs msg-text">'+ document.last_content +'</span>'+
                        '</span>'+
                        '</div>'+
                        '</a>';

                    chat_details(document.group_id)
                }
                else {
                    html += '<a href="javascript:;" class="list-group-item" id="'+ document.group_id +'" onClick="chat_details(\''+ document.group_id +'\');">'+
                        '<img src="'+ display_avatar +'" class="pull-left w-40 m-r img-circle" alt="">'+
                        '<div class="clear">'+
                        '<span class="msg-user-name">'+ display_name +'</span>'+
                        '<span>'+
                        '<span class="time-text pull-right">'+ time_html +'</span>'+
                        '<span class="clear text-ellipsis text-xs msg-text">'+ document.last_content +'</span>'+
                        '</span>'+
                        '</div>'+
                        '</a>';
                }
            }

            i++;
        });

        $("#msglist").html(html);
    });
}

function chat_details(group_id) {

    var session_user_id = $("#session_user_id").val();

    $(".list-group-item.active").removeClass('active');
    $("#"+group_id).addClass('active');

    var all_chart_data = [];

    $("#chat_details_appnd").empty();

    firebase.firestore().collection("messages").where('group_id', '==', group_id).get()
        .then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var document = doc.data();
            all_chart_data.push(document);

            if(document.created_by == session_user_id) {
                $("#to_user_id").val(document.read_by);
                $("#to_user_name").val(document.read_name);
                $("#to_user_avatar").val(document.read_avatar);
            }
            else{
                $("#to_user_id").val(document.created_by);
                $("#to_user_name").val(document.created_name);
                $("#to_user_avatar").val(document.created_avatar);
            }

            firebase.firestore().collection("messages").doc(doc.id).update({
                flag: 1
            })
        });

        var temp = '';

        for(var i=0; i<all_chart_data.length-1; i++) {
            for(var j=i+1; j < all_chart_data.length; j++) {
                if(all_chart_data[i].send_time.seconds > all_chart_data[j].send_time.seconds ) {
                    temp = all_chart_data[i];
                    all_chart_data[i] = all_chart_data[j];
                    all_chart_data[j] = temp;
                }
            }
        }

        var html = '';
        for(var i=0; i<all_chart_data.length; i++) {
            var avatar = all_chart_data[i].created_avatar;
            if(avatar == '') {
                avatar = base_url + 'assets/images/avatar2.jpg';
            }
            else {
                avatar = base_url + avatar;
            }

            var time = new Date(all_chart_data[i].send_time.seconds*1000);
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

            if(all_chart_data[i].created_by == session_user_id) {
                if(all_chart_data[i].type != 'text') {
                    if(all_chart_data[i].type.indexOf('image') === -1) {
                        var file_src = 'data:' + all_chart_data[i].type + ';base64' + all_chart_data[i].file_content;

                        html += '<div class="chat chat-right">'+
                            '<div class="chat-body">'+
                            '<div class="chat-time">' + time_html + '</div>'+
                            '<div class="chat-content" style="width:200px;">'+
                            '<a href="'+ file_src +'" download="'+ all_chart_data[i].content +'">'+ all_chart_data[i].content +'<a>'+
                            '<a href="'+ file_src +'" download="'+ all_chart_data[i].content +'">'+ all_chart_data[i].file_size + '(KB)</a>'+
                            '</div>'+
                            '</div>'+
                            '</div>';
                    }
                    else {
                        var img_src = 'data:' + all_chart_data[i].type + ';base64' + all_chart_data[i].file_content;
                        html += '<div class="chat chat-right">'+
                            '<div class="chat-body">'+
                            '<div class="chat-time">' + time_html + '</div>'+
                            '<div class="chat-content" style="background: url('+ img_src + '); width:200px; background-repeat: no-repeat; background-position-x: center; background-position-y: center;">'+
                            '<a href="'+ img_src +'" download="'+ all_chart_data[i].content +'">'+ all_chart_data[i].content +'<a>'+
                            '<a href="'+ img_src +'" download="'+ all_chart_data[i].content +'">'+ all_chart_data[i].file_size + '(KB)</a>'+
                            '</div>'+
                            '</div>'+
                            '</div>';
                    }
                }
                else {
                    html += '<div class="chat chat-right">'+
                        '<div class="chat-body">'+
                            '<div class="chat-time">' + time_html + '</div>'+
                            '<div class="chat-content">'+
                                '<p>' + all_chart_data[i].content + '</p>'+
                            '</div>'+
                        '</div>'+
                        '</div>';
                }
            }
            else {
                if(all_chart_data[i].type != 'text') {
                    if(all_chart_data[i].type.indexOf('image') === -1) {
                        var file_src = 'data:' + all_chart_data[i].type + ';base64' + all_chart_data[i].file_content;

                        html += '<div class="chat chat-left">'+
                            '<div class="chat-body">'+
                            '<div class="chat-time">' + time_html + '</div>'+
                            '<div class="chat-content" style="width:200px;">'+
                            '<a href="'+ file_src +'" download="'+ all_chart_data[i].content +'">'+ all_chart_data[i].content +'<a>'+
                            '<a href="'+ file_src +'" download="'+ all_chart_data[i].content +'">'+ all_chart_data[i].file_size + '(KB)</a>'+
                            '</div>'+
                            '</div>'+
                            '</div>';
                    }
                    else {
                        var img_src = 'data:' + all_chart_data[i].type + ';base64' + all_chart_data[i].file_content;
                        html += '<div class="chat chat-left">'+
                            '<div class="chat-body">'+
                            '<div class="chat-time">' + time_html + '</div>'+
                            '<div class="chat-content" style="background: url('+ img_src + '); width:200px; background-repeat: no-repeat; background-position-x: center; background-position-y: center;">'+
                            '<a href="'+ img_src +'" download="'+ all_chart_data[i].content +'">'+ all_chart_data[i].content +'<a>'+
                            '<a href="'+ img_src +'" download="'+ all_chart_data[i].content +'">'+ all_chart_data[i].file_size + '(KB)</a>'+
                            '</div>'+
                            '</div>'+
                            '</div>';
                    }
                }
                else {
                    html += '<div class="chat chat-left">'+
                        '<div class="chat-avatar">'+
                            '<img width="30" class="img-responsive img-circle" alt="Image" src="'+ avatar +'">'+
                        '</div>'+
                        '<div class="chat-body">'+
                        '<div class="chat-time">' + time_html  + '</div>'+
                        '<div class="chat-content">'+
                        '<p>' + all_chart_data[i].content + '</p>'+
                        '</div>'+
                        '</div>'+
                        '</div>';
                }
            }
        }

        $("#chat_details_appnd").html(html);
        $('.slimscrollleft').scrollTop($('.slimscrollleft')[0].scrollHeight);
    });

    $("#chat_message_content").val('');
}

function save_chat() {
    var session_user_id = $("#session_user_id").val();
    var session_user_name = $("#session_user_name").val();
    var session_user_avatar = $("#session_user_avatar").val();

    var to_user_id = $("#to_user_id").val();
    var to_user_name = $("#to_user_name").val();
    var to_user_avatar = $("#to_user_avatar").val();

    var group_id = 0;

    var general_group_id = generate_group_id(session_user_id, to_user_id);

    var message = $('#chat_message_content').val();

    if(message != '') {
        firebase.firestore().collection('group').where('group_id', '==', general_group_id).get()
            .then(function(querySnapshot) {

                querySnapshot.forEach(function(doc) {
                    group_id = doc.id;
                    return;
                });

                var time = new Date();
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

                if(group_id != 0) {
                    firebase.firestore().collection("group").doc(group_id).update({
                        last_type: 'text',
                        last_content: message,
                        last_time: firebase.firestore.FieldValue.serverTimestamp(),
                    });

                    firebase.firestore().collection("messages").add({
                        group_id: general_group_id,
                        type: 'text',
                        content: message,
                        created_by: session_user_id,
                        created_name: session_user_name,
                        created_avatar: session_user_avatar,
                        read_by: to_user_id,
                        read_name: to_user_name,
                        read_avatar: to_user_avatar,
                        send_time: firebase.firestore.FieldValue.serverTimestamp(),
                        flag: 0,
                    })
                    .then((ref) => {
                        var html = '<div class="chat chat-right">'+
                            '<div class="chat-body">'+
                            '<div class="chat-time">' + time_html + '</div>'+
                            '<div class="chat-content">'+
                            '<p>' + message + '</p>'+
                            '</div>'+
                            '</div>'+
                            '</div>';

                        $("#chat_details_appnd").append(html);
                        $("#chat_message_content").val('');

                        $('.list-group-item.active .msg-text').text(message);
                        $('.list-group-item.active .time-text').text(time_html);

                        $('.slimscrollleft').scrollTop($('.slimscrollleft')[0].scrollHeight);
                    })
                }
                else {
                    firebase.firestore().collection("group")
                        .add({
                            group_id: general_group_id,
                            members: [session_user_id, to_user_id],
                            from_id: session_user_id,
                            from_user_name: session_user_name,
                            from_user_avatar: session_user_avatar,
                            to_id: to_user_id,
                            to_user_name: to_user_name,
                            to_user_avatar: to_user_avatar,
                            last_type: 'text',
                            last_content: message,
                            last_time: firebase.firestore.FieldValue.serverTimestamp()
                        })
                        .then((ref) => {
                            console.log("Added doc with ID: ", ref.id);

                            firebase.firestore().collection('messages').add({
                                group_id: general_group_id,
                                type: 'text',
                                content: message,
                                created_by: session_user_id,
                                created_name: session_user_name,
                                created_avatar: session_user_avatar,
                                read_by: to_user_id,
                                read_name: to_user_name,
                                read_avatar: to_user_avatar,
                                send_time: firebase.firestore.FieldValue.serverTimestamp(),
                                flag: 0,
                            })
                            .then((ref) => {
                                var html = '<div class="chat chat-right">'+
                                    '<div class="chat-body">'+
                                    '<div class="chat-time">' + time_html  + '</div>'+
                                    '<div class="chat-content">'+
                                    '<p>' + message + '</p>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>';

                                $('.list-group-item.active  .msg-text').text(message);
                                $('.list-group-item.active .time-text').text(time_html);
                                $("#chat_message_content").val('');

                                $("#chat_details_appnd").append(html);
                                $('.slimscrollleft').scrollTop($('.slimscrollleft')[0].scrollHeight);
                            });
                        });
                }
            });
    }
}

function get_new_message() {
    var session_user_id = $("#session_user_id").val();

    firebase.firestore().collection("messages").orderBy('send_time', 'desc').onSnapshot(function(querySnapshot) {

        querySnapshot.forEach(function(doc) {
            var document = doc.data();

            if(document.read_by == session_user_id && document.flag == '0') {

                if(document.created_avatar == '') {
                    document.created_avatar = base_url + 'assets/images/avatar2.jpg';
                }
                else {
                    document.created_avatar = base_url + document.created_avatar;
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

                if(!group_data.includes(document.group_id)){

                    var html = '<a href="javascript:;" class="list-group-item" id="'+ document.group_id +'" onClick="chat_details(\''+ document.group_id +'\');">'+
                        '<img src="'+ document.created_avatar +'" class="pull-left w-40 m-r img-circle" alt="">'+
                        '<div class="clear">'+
                        '<span class="msg-user-name">'+ document.created_name +'</span>'+
                        '<span>'+
                        '<span class="time-text pull-right">'+ time_html + '</span>'+
                        '<span class="clear text-ellipsis text-xs msg-text">'+ document.content +'</span>'+
                        '</span>'+
                        '</div>'+
                        '</a>';

                    $("#msglist").append(html);

                    group_data.push(document.group_id);
                }
                else {
                    var group_id = $(".list-group-item.active").attr('id');

                    if(group_id == document.group_id) {

                        if(document.type != 'text') {
                            if(document.type.indexOf('image') === -1) {
                                var file_src = 'data:' + document.type + ';base64' + document.file_content;

                                var message_html = '<div class="chat chat-left">'+
                                    '<div class="chat-body">'+
                                    '<div class="chat-time">' + time_html + '</div>'+
                                    '<div class="chat-content" style="width:200px;">'+
                                    '<a href="'+ file_src +'" download="'+ document.content +'">'+ document.content +'<a>'+
                                    '<a href="'+ file_src +'" download="'+ document.content +'">'+ document.file_size + '(KB)</a>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>';
                            }
                            else {
                                var img_src = 'data:' + document.type + ';base64' + document.file_content;
                                var message_html = '<div class="chat chat-left">'+
                                    '<div class="chat-body">'+
                                    '<div class="chat-time">' + time_html + '</div>'+
                                    '<div class="chat-content" style="background: url('+ img_src + '); width:200px; background-repeat: no-repeat; background-position-x: center; background-position-y: center;">'+
                                    '<a href="'+ img_src +'" download="'+ document.content +'">'+ document.content +'<a>'+
                                    '<a href="'+ img_src +'" download="'+ document.content +'">'+ document.file_size + '(KB)</a>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>';
                            }
                        }
                        else {
                            var message_html = '<div class="chat chat-left">'+
                                '<div class="chat-avatar">'+
                                '<a class="avatar" href="">'+
                                '<img width="30" class="img-responsive img-circle" alt="Image" src="'+ document.created_avatar +'">'+
                                '</a>'+
                                '</div>'+
                                '<div class="chat-body">'+
                                '<div class="chat-time">' + time_html + '</div>'+
                                '<div class="chat-content">'+
                                '<p>' + document.content + '</p>'+
                                '</div>'+
                                '</div>'+
                                '</div>';
                        }

                        $("#chat_details_appnd").append(message_html);

                        firebase.firestore().collection("messages").doc(doc.id).update({
                            flag: 1
                        });
                    }
                    $('.slimscrollleft').scrollTop($('.slimscrollleft')[0].scrollHeight);
                    $("#"+ document.group_id +" .msg-text").text(document.content);
                    $("#"+ document.group_id +" .time-text").text(time_html);
                }
            }
        });
    });
}

function get_file(event) {
    var file = event.target.files;

    var file_name = file[0].name;
    var file_size = file[0].size;
    var file_type = file[0].type;


    const reader = new FileReader();
    reader.addEventListener('load', (event) => {
        const file_content = event.target.result;

        var session_user_id = $("#session_user_id").val();
        var session_user_name = $("#session_user_name").val();
        var session_user_avatar = $("#session_user_avatar").val();

        var to_user_id = $("#to_user_id").val();
        var to_user_name = $("#to_user_name").val();
        var to_user_avatar = $("#to_user_avatar").val();

        var group_id = 0;
        var general_group_id = generate_group_id(session_user_id, to_user_id);

        if(file_content != '') {
            firebase.firestore().collection('group').where('group_id', '==', general_group_id).get()
                .then(function(querySnapshot) {

                    querySnapshot.forEach(function(doc) {
                        group_id = doc.id;
                        return;
                    });

                    var time = new Date();
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

                    if(group_id != 0) {
                        firebase.firestore().collection("group").doc(group_id).update({
                            last_type: file_type,
                            last_content: file_name,
                            last_time: firebase.firestore.FieldValue.serverTimestamp(),
                        });

                        firebase.firestore().collection("messages").add({
                            group_id: general_group_id,
                            type: file_type,
                            content: file_name,
                            file_content: file_content,
                            file_size: file_size,
                            created_by: session_user_id,
                            created_name: session_user_name,
                            created_avatar: session_user_avatar,
                            read_by: to_user_id,
                            read_name: to_user_name,
                            read_avatar: to_user_avatar,
                            send_time: firebase.firestore.FieldValue.serverTimestamp(),
                            flag: 0,
                        })
                        .then((ref) => {
                            if(file_type.indexOf('image') === -1) {
                                var file_src = 'data:' + file_type + ';base64' + file_content;

                                var html = '<div class="chat chat-right">'+
                                    '<div class="chat-body">'+
                                    '<div class="chat-time">' + time_html + '</div>'+
                                    '<div class="chat-content" style="width:200px;">'+
                                    '<a href="'+ file_src +'" download="'+ file_name +'">'+ file_name +'<a>'+
                                    '<a href="'+ file_src +'" download="'+ file_name +'">'+ file_size + '(KB)</a>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>';
                            }
                            else {
                                var img_src = 'data:' + file_type + ';base64' + file_content;
                                html = '<div class="chat chat-right">'+
                                    '<div class="chat-body">'+
                                    '<div class="chat-time">' + time_html + '</div>'+
                                    '<div class="chat-content" style="background: url('+ img_src + '); width:200px;">'+
                                    '<a href="'+ img_src +'" download="'+ file_name +'">'+ file_name +'<a>'+
                                    '<a href="'+ img_src +'" download="'+ file_name +'">'+ file_size + '(KB)</a>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>';
                            }

                            $("#chat_details_appnd").append(html);
                            $("#chat_message_content").val('');
                            $('.list-group-item.active .msg-text').text(file_name);
                            $('.list-group-item.active  .time-text').text(time_html);

                            $('.slimscrollleft').scrollTop($('.slimscrollleft')[0].scrollHeight);
                        })
                    }
                    else {
                        firebase.firestore().collection("group")
                            .add({
                                group_id: general_group_id,
                                members: [session_user_id, to_user_id],
                                from_id: session_user_id,
                                from_user_name: session_user_name,
                                from_user_avatar: session_user_avatar,
                                to_id: to_user_id,
                                to_user_name: to_user_name,
                                to_user_avatar: to_user_avatar,
                                last_type: file_type,
                                last_content: file_name,
                                last_time: firebase.firestore.FieldValue.serverTimestamp(),
                            })
                            .then((ref) => {

                                firebase.firestore().collection('messages').add({
                                    group_id: general_group_id,
                                    type: file_type,
                                    content: file_name,
                                    file_content: file_content,
                                    file_size: file_size,
                                    created_by: session_user_id,
                                    created_name: session_user_name,
                                    created_avatar: session_user_avatar,
                                    read_by: to_user_id,
                                    read_name: to_user_name,
                                    read_avatar: to_user_avatar,
                                    send_time: firebase.firestore.FieldValue.serverTimestamp(),
                                    flag: 0,
                                })
                                .then((ref) => {

                                    if(file_type.indexOf('image') === -1) {
                                        var file_src = 'data:' + file_type + ';base64' + file_content;

                                        var html = '<div class="chat chat-right">'+
                                            '<div class="chat-body">'+
                                            '<div class="chat-time">' + time_html + '</div>'+
                                            '<div class="chat-content" style="width:200px;">'+
                                            '<a href="'+ file_src +'" download="'+ file_name +'">'+ file_name +'<a>'+
                                            '<a href="'+ file_src +'" download="'+ file_name +'">'+ file_size + '(KB)</a>'+
                                            '</div>'+
                                            '</div>'+
                                            '</div>';
                                    }
                                    else {
                                        var img_src = 'data:' + file_type + ';base64' + file_content;
                                        var html = '<div class="chat chat-right">'+
                                            '<div class="chat-body">'+
                                            '<div class="chat-time">' + time_html + '</div>'+
                                            '<div class="chat-content" style="background: url('+ img_src + '); width:200px; background-repeat: no-repeat; background-position-x: center; background-position-y: center;">'+
                                            '<a href="'+ img_src +'" download="'+ file_name +'">'+ file_name +'<a>'+
                                            '<a href="'+ img_src +'" download="'+ file_name +'">'+ file_size + '(KB)</a>'+
                                            '</div>'+
                                            '</div>'+
                                            '</div>';
                                    }

                                    $('.list-group-item.active  .msg-text').text(file_name);
                                    $('.list-group-item.active  .time-text').text(time_html);
                                    $("#chat_message_content").val('');

                                    $("#chat_details_appnd").append(html);
                                    $('.slimscrollleft').scrollTop($('.slimscrollleft')[0].scrollHeight);
                                });
                            });
                    }
                });
        }
    });
    reader.readAsDataURL(file[0]);
}
