</div>
<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <?php foreach ($footer_main_menu as $main_menu) { ?>
                    <div class="footer-widget">
                        <h4 class="widget-title"><?php echo str_replace('_', ' ', $main_menu['title']); ?></h4>
                        <div class="footer-line">
                            <span></span>
                        </div>
                        <div class="about">
                            <div class="contactdet">
                                <ul>
                                    <?php foreach ($footer_sub_menu as $sub_menu) {
                                        if ($main_menu['id'] == $sub_menu['footer_menu']) { ?>
                                            <li>
                                                <a href="<?php echo base_url() . 'pages/' . $sub_menu['footer_submenu']; ?>"><?php echo str_replace('_', ' ', $sub_menu['footer_submenu']); ?></a>
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="footer-widget">
                    <h4 class="widget-title text-right"><?php echo (!empty($user_language[$user_selected]['lg_follow_us'])) ? $user_language[$user_selected]['lg_follow_us'] : $default_language['en']['lg_follow_us']; ?></h4>
                    <div class="footer-line">
                        <span></span>
                    </div>
                    <ul class="social-list">
                        <?php foreach ($system_setting as $settings) { ?>
                            <?php if ($settings['key'] == 'facebook' && !empty($settings['value']) && !empty($settings['visible'])) { ?>
                                <li><a target="_blank" href="<?php echo $settings['value']; ?>"><i class="fa fa-facebook"></i></a></li>
                            <?php } ?>

                            <?php if ($settings['key'] == 'twitter' && !empty($settings['value']) && !empty($settings['visible'])) { ?>
                                <li><a target="_blank" href="<?php echo $settings['value']; ?>"><i class="fa fa-twitter"></i></a></li>
                            <?php } ?>

                            <?php if ($settings['key'] == 'google_plus' && !empty($settings['value']) && !empty($settings['visible'])) { ?>
                                <li><a target="_blank" href="<?php echo $settings['value']; ?>"><i class="fa fa-google-plus"></i></a></li>
                            <?php } ?>

                            <?php if ($settings['key'] == 'linkedIn' && !empty($settings['value']) && !empty($settings['visible'])) { ?>
                                <li><a target="_blank" href="<?php echo $settings['value']; ?>"><i class="fa fa-linkedin"></i></a></li>
                            <?php } ?>

                            <?php if ($settings['key'] == 'instagram' && !empty($settings['value']) && !empty($settings['visible'])) { ?>
                                <li><a target="_blank" href="<?php echo $settings['value']; ?>"><i class="fa fa-instagram"></i></a></li>
                            <?php } ?>

                            <?php if ($settings['key'] == 'android' && !empty($settings['value']) && !empty($settings['visible'])) { ?>
                                <li><a target="_blank" href="<?php echo $settings['value']; ?>"><i class="fa fa-android"></i></a></li>
                            <?php } ?>

                            <?php if ($settings['key'] == 'ios' && !empty($settings['value']) && !empty($settings['visible'])) { ?>
                                <li><a target="_blank" href="<?php echo $settings['value']; ?>"><i class="fa fa-ios"></i></a></li>
                            <?php } ?>
                        <?php } ?>

                    </ul>
                    <ul class="download-list">
                        <?php foreach ($system_setting as $settings) {
                            if ($settings['key'] == 'android' && !empty($settings['value'])) { ?>
                                <li>
                                    <a target="_blank" href="<?php echo $settings['value']; ?>">
                                        <img src="<?php echo base_url(); ?>assets/images/googleplaystore-image.png" class="img-responsive">
                                    </a>
                                </li>
                            <?php }
                            if ($settings['key'] == 'ios' && !empty($settings['value'])) { ?>
                                <li>
                                    <a target="_blank" href="<?php echo $settings['value']; ?>">
                                        <img src="<?php echo base_url(); ?>assets/images/appstore-image.png" class="img-responsive">
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 copyright text-center">
                    <?php

                    $query = $this->db->query("select * from system_settings WHERE status = 1");
                    $result = $query->result_array();
                    $website_name = '';

                    if (!empty($result)) {
                        $sitename = $meta_keywords = $meta_description = '';
                        foreach ($result as $data) {
                            if ($data['key'] == 'website_name') {
                                $website_name = $data['value'];
                            }

                            if ($data['key'] == 'google_analytics_code') {
                                $google_analytics_code = $data['value'];
                            }
                        }
                    }

                    if (!empty($google_analytics_code)) {
                        echo $google_analytics_code;
                    }
                    ?>

                    <p>
                        &copy;<?php echo date('Y'); ?>
                        <span>
                            <a href="<?php echo base_url(); ?>"><?php echo (!empty($user_language[$user_selected]['lg_copyright'])) ? $user_language[$user_selected]['lg_copyright'] : $default_language['en']['lg_copyright']; ?></a>.
                        </span>
                        <?php echo (!empty($user_language[$user_selected]['lg_all_rights_reserved'])) ? $user_language[$user_selected]['lg_all_rights_reserved'] : $default_language['en']['lg_all_rights_reserved']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="to-top" id="to-top" style="bottom: 15px;"><i class="fa fa-angle-up"></i></div>

</div>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/theia-sticky-sidebar.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tokenfield.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/star_rating.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/rating.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cropper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tokens.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.cropit.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/morris.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/morris-data.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/raphael-min.js"></script>

<script>
    function change_account(account_state) {
        $.ajax({
            url: base_url + 'welcome/change_account',
            data: {
                account_state: account_state
            },
            type: 'POST',
            success: function(response) {
                location.reload();
            }
        })
    }
    function dev_check() {
        $("#client_check").removeClass('active');
        $("#developer_check").addClass('active');
        $("#account_type_id").val(1);
    }

    function cli_check() {
        $("#developer_check").removeClass('active');
        $("#client_check").addClass('active');
        $("#account_type_id").val(2);
    }
</script>

<script>
    $(document).ready(function () {
        var stickyNavTop = $('.menu-bar').offset().top;

        var stickyNav = function () {
            var scrollTop = $(window).scrollTop();

            if (scrollTop > stickyNavTop) {
                $('.menu-bar').addClass('sticky');
            } else {
                $('.menu-bar').removeClass('sticky');
            }
        };

        stickyNav();

        $(window).scroll(function () {
            stickyNav();
        });

        $('#stars').on('starrr:change', function (e, value) {
            $('#count').html(value);
        });

        $('#stars-existing').on('starrr:change', function (e, value) {
            $('#count-existing').html(value);
            $('#rating_input').val(value);
        });
    });

</script>

<script>
    function add_seller_feedbacks() {
        $('#feedbackmodel').modal('show');
    }
</script>

<script>
    setTimeout(function () {
        $('#flash_succ_message, #flash_error_message').hide();
    }, 3000);
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jstz-1.0.4.min.js"></script>
<!-- <script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>   -->

<script type="text/javascript">
    $(document).ready(function () {
        var tz = jstz.determine();

        var timezone = tz.name();
        var ip_city = '';

        $.post('<?php echo base_url(); ?>ajax', {timezone: timezone, ip_city: ip_city}, function (res) {

        })
    });

    function change_language(e) {
        var lg = $(e).attr('lang');
        var tag = $(e).attr('lang_tag');

        $.post(
            '<?php echo base_url(); ?>ajax/change_language',
            {
                lg: lg,
                tag: tag
            },
            function (res) {
                location.reload();
            })
    }

    function change_language_new(e) {
        var lg = $(e).attr('lang');
        $.post('<?php echo base_url(); ?>ajax/change_language', {lg: lg}, function (res) {
            location.reload();
        });

    }
</script>

<script>
    setTimeout(function () {
        $('.alert-dismissable').hide();
    }, 2000);
</script>

<script>
    $(document).on("keydown", ".numberonly", function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }

        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>

<?php if ($module == "profile" || $module == "password" || $module == "payment_settings") { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/cropper_main.js"></script>
<?php } ?>

<?php if ($this->session->userdata('SESSION_USER_ID')) { ?>
<script>
    $(document).ready(function () {
        get_all_new_messages();
        get_all_new_notification();
    });

    function show_usermessage(group_id) {
        window.location = base_url + 'message/'+ group_id;
    }

    function show_usernotificatioin(notification_id) {
        window.location = base_url + 'notification';
    }

    function generate_group_id(user_id1, user_id2) {
        if(parseInt(user_id1) > parseInt(user_id2)) {
            return 'group_'+user_id1+'_'+user_id2;
        }
        else {
            return 'group_'+user_id2+'_'+user_id1;
        }
    }

    function save_newchat() {

        var session_user_id = $("#session_user_id").val();
        var session_user_name = $("#session_user_name").val();
        var session_user_avatar = $("#session_user_avatar").val();

        var to_user_id = $('#to_user_id').val();
        var to_user_name = $('#to_user_name').val();
        var to_user_avatar = $('#to_user_avatar').val();

        var message = $('textarea#messageone').val();
        $("#_error_").html('');

        if (to_user_id) {
            if (message.length > 0) {
                var group_id = 0;
                var general_group_id = generate_group_id(session_user_id, to_user_id);

                firebase.firestore().collection('group').where('group_id', '==', general_group_id).get()
                .then(function(querySnapshot) {
                    querySnapshot.forEach(function(doc) {
                        group_id = doc.id;
                        return;
                    });

                    if(group_id != '') {
                        firebase.firestore().collection('group').doc(group_id).update({
                            last_type: 'text',
                            last_content: message,
                            last_time: firebase.firestore.FieldValue.serverTimestamp(),
                        })

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
                            $('textarea#messageone').val('');
                            $('textarea#messageone').text('');
                            $('#message-popup').modal('toggle');
                            $('#form_messagecontent_id')[0].reset();
                        });
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
                            last_time: firebase.firestore.FieldValue.serverTimestamp(),
                        })
                        .then((ref) => {
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
                                $('textarea#messageone').val('');
                                $('textarea#messageone').text('');
                                $('#message-popup').modal('toggle');
                                $('#form_messagecontent_id')[0].reset();
                            });
                        });
                    }

                });

            } else {
                $("#_error_").html('<div class="account-error">Please enter message content</div>');
            }

            return false;

        } else {
            $("#_error_").html('Please select Users.....');
            return false;
        }
    }

    function get_all_new_messages() {
        var session_user_id = $("#session_user_id").val();

        firebase.firestore().collection("messages").orderBy('send_time', 'desc').onSnapshot(function(querySnapshot) {
                var message_html = '';
                var total_count = 0
                querySnapshot.forEach(function(doc) {
                    var document = doc.data();

                    if(document.read_by == session_user_id && document.flag == '0') {
                        if(document.created_avatar == '') {
                            document.created_avatar = base_url + 'assets/images/avatar2.jpg';
                        }
                        else {
                            document.created_avatar = base_url + document.created_avatar;
                        }

                        var now = firebase.firestore.Timestamp.now();

                        var different_time = (now.seconds+150) - document.send_time.seconds;

                        var differenct_time_string = '';

                        var min = (different_time/60).toFixed(0);
                        var minutes = min%60;

                        var hour  = (min/60).toFixed(0);
                        var hours = hour%24;

                        var day = (hour/24).toFixed(0);

                        if(day != 0) {
                            differenct_time_string += day + 'd ';
                        }

                        if(hours != 0) {
                            differenct_time_string += hours + 'h ';
                        }

                        if(minutes != 0) {
                            differenct_time_string += minutes + 'min ';
                        }

                        differenct_time_string += ' ago';

                        message_html += '<li class="media notification-message">'+
                            '<a href="javascript:;" onclick="show_usermessage(\''+ document.group_id +'\');">'+
                            '<div class="media-left">'+
                            '<img width="32" class="img-circle" src="' + document.created_avatar +'" alt="' + document.created_name + '">'+
                            '<span>'+ document.created_name +'</span>'+
                            '</div>'+
                            '<div class="media-body">'+
                            '<h4 class="notification-heading text-ellipsis"><span class="text-gray">' + document.content+ ' </span></h4>'+
                            '<span class="notification-time">'+ differenct_time_string +'</span>'+
                            '</div>'+
                            '</a>'+
                            '</li>';

                        total_count ++;
                    }
                });

                if(total_count != 0) {
                    $("#message_notification").empty();
                    $("#new_message_count").html(total_count);
                    $("#new_message_count").show();
                    var ts = '<div class="dropdown-menu notifications msg-noti" >';
                    ts += '<div class="topnav-dropdown-header"><span>Messages</span></div>';
                    ts += '<div class="scroll-pane"><ul class="media-list scroll-content" id="new_chat_content">' + message_html + '</ul></div>';
                    ts += '<div class="topnav-dropdown-footer"><a href="' + base_url + 'message">See all messages</a></div>';
                    ts += '</div>';
                    $("#message_notification").html(ts);
                }
            });
    }

    function get_all_new_notification() {
        var session_user_id = $("#session_user_id").val();

        firebase.firestore().collection("notification").orderBy('send_time', 'desc').onSnapshot(function(querySnapshot) {
                var notification_html = '';
                var total_count = 0

                querySnapshot.forEach(function(doc) {
                    var document = doc.data();

                    if(document.to_user_id == session_user_id && document.flag == '0') {
                        if(document.from_user_avatar == '') {
                            document.from_user_avatar = base_url + 'assets/images/avatar2.jpg';
                        }
                        else {
                            document.from_user_avatar = base_url + document.from_user_avatar;
                        }

                        var now = firebase.firestore.Timestamp.now();

                        var different_time = (now.seconds+150) - document.send_time.seconds;

                        var differenct_time_string = '';

                        var min = (different_time/60).toFixed(0);
                        var minutes = min%60;

                        var hour  = (min/60).toFixed(0);
                        var hours = hour%24;

                        var day = (hour/24).toFixed(0);

                        if(day != 0) {
                            differenct_time_string += day + 'd ';
                        }

                        if(hours != 0) {
                            differenct_time_string += hours + 'h ';
                        }

                        if(minutes != 0) {
                            differenct_time_string += minutes + 'min ';
                        }

                        differenct_time_string += ' ago';

                        if(document.kind == 'payment') {
                            notification_html += '<li class="media notification-message">'+
                                '<a onclick="show_usernotificatioin();" href="javascript:;">'+
                                '<div class="media-left">'+
                                '<img width="32" class="img-circle" src="' + document.from_user_avatar + '" alt="' + document.from_user_name + '">'+
                                '</div>'+
                                '<div class="media-body">'+
                                '<p class="m-0 noti-details"><span class="noti-title">' + document.message + '</span></p>'+
                                '<p class="m-0"><span class="notification-time">' + differenct_time_string + '</span></p>'+
                                '</div>'+
                                '</a>'+
                                '</li>';
                        }
                        else {
                            notification_html += '<li class="media notification-message">'+
                                '<a onclick="propose_accept( \'' + doc.id + '\' , \'' + document.kind + '\' , \'' + document.from_user_id + '\', \'' + document.message + '\' );" href="javascript:;">'+
                                '<div class="media-left">'+
                                '<img width="32" class="img-circle" src="' + document.from_user_avatar + '" alt="' + document.from_user_name + '">'+
                                '</div>'+
                                '<div class="media-body">'+
                                '<p class="m-0 noti-details"><span class="noti-title">' + document.message + '</span></p>'+
                                '<p class="m-0"><span class="notification-time">' + differenct_time_string + '</span></p>'+
                                '</div>'+
                                '</a>'+
                                '</li>';
                        }

                        total_count ++;
                    }
                });

                if(total_count != 0) {
                    $("#notification_notification").empty();
                    $("#notification_count").html(total_count);
                    $("#notification_count").show();
                    var ts = '<div class="dropdown-menu notifications msg-noti" >';
                    ts += '<div class="topnav-dropdown-header"><span>Notification</span></div>';
                    ts += '<div class="scroll-pane"><ul class="media-list scroll-content" id="new_chat_content">' + notification_html + '</ul></div>';
                    ts += '<div class="topnav-dropdown-footer"><a href="' + base_url + 'message">See all messages</a></div>';
                    ts += '</div>';
                    $("#notification_notification").html(ts);
                }
            });
    }

</script>
<?php } ?>

<?php if ($module == "notification") { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/notification.js"></script>
<?php } ?>

<?php if ($module == "message") { ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/message.js"></script>
    <?php } ?>

<?php if ($module == "sell_gigs" || $module == "sell_project") { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/cropper_main_gig.js"></script>

    <script>
        $(document).ready(function () {
            $("#upload_image_btn").click(function () {
                $("#avatar-gig-modal").css('display', 'block');
                $("#avatar-gig-modal").modal('show');
            });
        });
    </script>

<?php } ?>

<?php if ($module == "transactions") { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/transactions.js"></script>
<?php } ?>

<?php if ($module == "balances") { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/balances.js"></script>
<?php } ?>

<?php if ($module == "membership") { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/membership.js"></script>
<?php } ?>

<?php if ($module == "my_dashboard") { ?>
    <script type="text/javascript">
        $(document).ready(function () {

            var jsonData = $.getJSON(base_url + 'user/my_dashboard/gigs_sales', function (jsonData) {

                Morris.Bar({
                    element: 'morris-bar-chart',
                    data: jsonData,
                    xkey: 'month',
                    ykeys: ['sales'],
                    labels: ['Gigs Sales'],
                    barRatio: 0,
                    xLabelAngle: 34,
                    continuousLine: false,
                    yLabelFormat: function (y) {
                        return y != Math.round(y) ? '' : y;
                    },
                    hideHover: 'auto',
                    resize: true
                });

            });

            var jsonData1 = $.getJSON(base_url + 'user/my_dashboard/my_gigs_status', function (jsonData1) {
                Morris.Donut({
                    element: 'morris-donut-chart',
                    data: jsonData1,
                    resize: true
                });
            });

            var jsonData2 = $.getJSON(base_url + 'user/my_dashboard/my_gigs_amount', function (jsonData2) {
                Morris.Line({
                    element: 'morris-line-chart',
                    data: jsonData2,
                    xkey: 'month',
                    ykeys: ['amount'],
                    labels: ['Amount'],
                    smooth: false,
                    parseTime: false,
                    resize: true
                });
            });
        });

    </script>
<?php } ?>

<?php

$default_language_select = default_language();

if ($this->session->userdata('user_select_language') == '') {
    if ($default_language_select['tag'] == 'ltr' || $default_language_select['tag'] == '') {

        echo '<script type="text/javascript" src="' . base_url() . 'assets/js/app.js"></script>';

    } elseif ($default_language_select['tag'] == 'rtl') {

        echo '<script type="text/javascript" src="' . base_url() . 'assets/js/app-rtl.js"></script>';
    }

} else {
    if ($this->session->userdata('tag') == 'ltr' || $this->session->userdata('tag') == '') {
        echo '<script type="text/javascript" src="' . base_url() . 'assets/js/app.js"></script>';
    } elseif ($this->session->userdata('tag') == 'rtl') {
        echo '<script type="text/javascript" src="' . base_url() . 'assets/js/app-rtl.js"></script>';
    }
}
?>

<?php

$uri = $this->uri->segment(1);

if ($uri == 'add-gigs') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/add_gigs.js"></script>
<?php }

if ($uri == 'add-project') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/add_project.js"></script>
<?php }

if ($uri == 'edit-gigs') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/edit_gigs.js"></script>
<?php }

if ($uri == 'edit-project') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/edit_project.js"></script>
<?php }

if ($uri == 'my-gigs') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/my_gigs.js"></script>
<?php }

if ($uri == 'my-project') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/my_project.js"></script>
<?php }


if ($uri == 'team_management') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/team_management.js"></script>
<?php }

if ($uri == "project-preview") { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/user/project_preview.js"></script>
<?php } ?>
    
<!-- <script src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript">
    $(function () {
        var $form = $("#payment_formid");

        var handler = StripeCheckout.configure({
            key: '<?php //echo $publishable_key;?>',
            image: '<?php //if (!empty($logo['value'])) {
                //echo base_url() . $logo['value'];
            //} else {
                //echo base_url() . "assets/images/logo.png";
            //}?>',
            locale: 'auto',
            token: function (token, args) {
                $('#access_token').val(token.id);
                $form.submit();
            }
        });

        $form.submit(function (e) {
            //e.preventDefault()
            var option = $('input[name=group2]:checked').val();
            if (option == 'stripe') {
                final_gig_amount = (final_gig_amount * 100); //  dollar to cent
                var cur = $('#currency_type').val();
                striep_currency = 'USD';
                if (cur == '$') {
                    striep_currency = 'USD';
                }
                if (cur == '€') {
                    striep_currency = 'EUR';
                }
                if (cur == '£') {
                    striep_currency = 'GBP';
                }

                handler.open({
                    name: base_url,
                    description: 'My Gigs Purchase',
                    amount: final_gig_amount,
                    currency: striep_currency
                });
                return false;
            }
        });
    });
</script> -->

<script src="https://apis.google.com/js/api:client.js"></script>
<script>
    var googleUser = {};
    var startApp = function () {
        gapi.load('auth2', function () {
            auth2 = gapi.auth2.init({
                client_id: '<?php echo $website_google_client_ids;?>',
                cookiepolicy: 'single_host_origin',
            });
            attachSignin(document.getElementById('customBtn'));
        });
    };

    function attachSignin(element) {
        auth2.attachClickHandler(element, {},
            function (googleUser) {

                var profileid = googleUser.getBasicProfile().getId();
                var fullname = googleUser.getBasicProfile().getName();
                var firstname = googleUser.getBasicProfile().getGivenName();
                var profileurl = googleUser.getBasicProfile().getImageUrl();
                var email = googleUser.getBasicProfile().getEmail();
                var auth = 'Google';
                var selected_menu = $('#selected_menu').val();

                $.post(base_url + 'user/dashboard/sociallogin_registration', {
                    'profileid': profileid,
                    'fullname': fullname,
                    'profileurl': profileurl,
                    'email': email,
                    'auth': auth,
                    'firstname': firstname
                }, function (response) {
                    if (response == 1) {
                        if (selected_menu != '') {
                            window.location.href = base_url + selected_menu;
                        } else {
                            location.reload();
                        }
                    }
                    if (response == 0) {
                        $('#register_errtext').html('<div class="account-error">Login failed wrong user credentials</div>');
                        $('#users_login').bootstrapValidator('resetForm', true);
                    }
                });

            }, function (error) {

            });
    }
</script>
<script>
    startApp();
</script>
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '<?php echo $website_facebook_app_ids;?>', // FB App ID
            cookie: true,  // enable cookies to allow the server to access the session
            xfbml: true,  // parse social plugins on this page
            version: 'v2.8' // use graph api version 2.8
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
    }(document, 'script', 'facebook-jssdk'));

    function fbLogin() {
        FB.login(function (response) {
            if (response.authResponse) {
                getFbUserData();
            } else {

                $('#register_errtext').html('User cancelled login or did not fully authorize');
            }
        }, {scope: 'email'});
    }

    function getFbUserData() {
        FB.api('/me', {locale: 'en_US', fields: 'id,name,first_name,last_name,email,link,gender,locale,picture'},
            function (response) {

                var profileid = response.id;
                var fullname = response.name;
                var firstname = response.first_name;
                var lastname = response.last_name;
                var profileurl = response.picture.data.url;
                var email = response.email;
                var auth = 'Facebook';

                var selected_menu = $('#selected_menu').val();

                $.post(base_url + 'user/dashboard/sociallogin_registration', {
                    'profileid': profileid,
                    'fullname': fullname,
                    'profileurl': profileurl,
                    'email': email,
                    'auth': auth,
                    'firstname': firstname
                }, function (response) {
                    if (response == 1) {
                        if (selected_menu != '') {
                            window.location.href = base_url + selected_menu;
                        } else {
                            location.reload();
                        }
                    }
                    if (response == 0) {
                        $('#register_errtext').html('<div class="account-error">Login failed wrong user credentials</div>');
                        $('#users_login').bootstrapValidator('resetForm', true);
                    }
                });
            });
    }
</script>

<script type="text/javascript">
    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    specialKeys.push(9); //Tab
    specialKeys.push(46); //Delete
    specialKeys.push(36); //Home
    specialKeys.push(35); //End
    specialKeys.push(37); //Left
    specialKeys.push(39); //Right
    function IsAlphaNumeric(e) {
        var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
        var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
        return ret;
    }
</script>

<script>
    $('.switch').on('click', function (e) {
        $('.main-menu .navbar-static-top').toggleClass("hide-icons"); //you can list several class names
        e.preventDefault();
    });
</script>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.1.2/firebase.js"></script>
<script src="https://cdn.firebase.com/libs/firechat/3.0.1/firechat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/firebase-init.js"></script>

</body>
</html>