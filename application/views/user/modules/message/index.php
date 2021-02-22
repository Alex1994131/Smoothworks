<div class="msg-section">

    <input type="hidden" id="session_user_id" value="<?php echo $session_user_data['USERID']; ?>">
    <input type="hidden" id="session_user_name" value="<?php echo $session_user_data['fullname']; ?>">
    <input type="hidden" id="session_user_avatar" value="<?php echo $session_user_data['user_thumb_image']; ?>">

    <input type="hidden" id="group_id" value="<?php echo($group_id); ?>">

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb menu-breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a>
                            <i class="fa fa fa-chevron-right"></i></li>
                        <li class="active"><?php echo (!empty($user_language[$user_selected]['lg_my_profile'])) ? $user_language[$user_selected]['lg_my_profile'] : $default_language['en']['lg_my_profile']; ?></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title"><?php echo (!empty($user_language[$user_selected]['lg_my_messages'])) ? $user_language[$user_selected]['lg_my_messages'] : $default_language['en']['lg_my_messages']; ?></h3>
                </div>
            </div>
        </div>
    </section>
    <div class="tab-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-list">
                        <ul>
                            <li class="active">
                                <a href="#"><?php echo (!empty($user_language[$user_selected]['lg_inbox'])) ? $user_language[$user_selected]['lg_inbox'] : $default_language['en']['lg_inbox']; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="container">
            <div class="row" id="messages_pan">
                <div class="col-sm-4 message-user" id="message_user">
                    <a href="#" id="close_btn"><i class="fa fa-close"></i></a>
                    <div id="msglist" class="list-group msg-list student_chat_list"></div>
                </div>
                <div class="col-sm-4 mobile-chat">
                    <a id="chat_btn" href="#">
                        <span class="btn btn-sm btn-primary">
                            <i class="fa fa-list"></i> <?php echo (!empty($user_language[$user_selected]['lg_chats_list'])) ? $user_language[$user_selected]['lg_chats_list'] : $default_language['en']['lg_chats_list']; ?>
                        </span>
                    </a>
                </div>
                <div class="col-sm-8 chat-contents">
                    <div class="panel m-b-0">
                        <div class="panel-heading" id="headuser_details_set"></div>
                        <div class="panel-body">
                            <div id="chat-box" class="chat-box slimscrollleft">
                                <div class="chats" id="chat_details_appnd"></div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="message-bar">
                                <div class="message-inner">
                                    <input name="new_message_image[]" id="new_message_image" type="file" style="display:none" size="2000000" onchange="get_file(event)">
                                    <a class="link icon-only" href="javascript:;"
                                       title="<?php echo (!empty($user_language[$user_selected]['lg_click_to_upload_images'])) ? $user_language[$user_selected]['lg_click_to_upload_images'] : $default_language['en']['lg_click_to_upload_images']; ?>"
                                       onclick="$('#new_message_image').focus().trigger('click');">
                                        <i class="fa fa-paperclip"></i>
                                    </a>

                                    <input type="hidden" name="to_user_id" id="to_user_id" value=""/>
                                    <input type="hidden" name="to_user_name" id="to_user_name" value=""/>
                                    <input type="hidden" name="to_user_avatar" id="to_user_avatar" value=""/>

                                    <input type="hidden" name="group_id" id="group_id" value=""/>
                                    <input type="hidden" name="temp_chat_tz" id="temp_chat_tz" value=""/>
                                    <div class="message-area">
                                        <input type="text" name="chat_message_content" id="chat_message_content"
                                               placeholder="<?php echo (!empty($user_language[$user_selected]['lg_write_message'])) ? $user_language[$user_selected]['lg_write_message'] : $default_language['en']['lg_write_message']; ?>..."
                                               class="form-control msg-type">
                                    </div>
                                    <a class="link" href="javascript:void(0);">
                                        <button onclick="save_chat()"><span><i class="fa fa-paper-plane"></i></span></button>
                                    </a>
                                </div>
                            </div>
                            <div class="progress msg-progress" style="display:none">
                                <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                            </div>
                            <div id="new_status_attaches"></div>
                        </div>
                    </div>
                </div>
<!--                <div class="col-sm-12">-->
<!--                    <p class="text-center">Sorry! No Messages</p>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>