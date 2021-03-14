<?php

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);

        $this->data['theme'] = 'admin';
        $this->data['module'] = 'dashboard';
        $this->load->model('admin_login_model');
        $this->load->model('admin_panel_model');
        $this->load->model('templates_model');
        $this->load->helper('favourites');
        $this->smtp_config = smtp_mail_config();


        $query = $this->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        $this->email_address = 'mail@example.com';
        $this->email_tittle = 'Gigs';
        $this->base_domain = base_url();
        $this->logo_front = base_url() . 'assets/images/logo.png';
        if (!empty($result)) {
            foreach ($result as $data) {
                if ($data['key'] == 'email_address') {
                    $this->email_address = !empty($data['value']) ? $data['value'] : 'mail@example.com';
                }
                if ($data['key'] == 'email_tittle') {
                    $this->email_tittle = !empty($data['value']) ? $data['value'] : 'gigs';
                }
                if ($data['key'] == 'logo_front') {
                    $this->logo_front = base_url() . $data['value'];
                }
                if ($data['key'] == 'site_name' || $data['key'] == 'website_name') {
                    $this->site_name = $data['value'];
                }
                $this->data['currency_option'] = 'USD';
                if ($data['key'] == 'currency_option') {
                    $this->data['currency_option'] = $data['value'];
                }
            }
        }

        $this->data['rupee_dollar_rate'] = $this->admin_panel_model->get_rupee_dollar_rate();
        $this->data['price_of_gig'] = $this->admin_panel_model->gig_price();
        $rupee_dollar_rate = $this->data['rupee_dollar_rate'];
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
        $this->load->helper('ckeditor');
        $this->data['ckeditor_editor1'] = array
        (
            //id of the textarea being replaced by CKEditor
            'id' => 'ck_editor_textarea_id',
            // CKEditor path from the folder on the root folder of CodeIgniter
            'path' => 'assets/js/ckeditor',
            //theme/
            // optional settings
            'config' => array
            (
                'toolbar' => "Full",
                'filebrowserBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html',
                'filebrowserImageBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Images',
                'filebrowserFlashBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Flash',
                'filebrowserUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                'filebrowserImageUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                'filebrowserFlashUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            )
        );
        if (($this->session->userdata('admin_time_zone'))) {

            $this->data['time_zone'] = $this->session->userdata('admin_time_zone');
            $this->data['full_country_name'] = $this->session->userdata('admin_full_country_name');
            $this->data['country_name'] = $this->session->userdata('admin_country_name');
            $this->data['dollar_rate'] = $rupee_dollar_rate['dollar_rate'];
            $this->data['rupee_rate'] = $rupee_dollar_rate['indian_rate'];
            $this->session->set_userdata('dollar_rate', $this->data['dollar_rate']);
            $this->session->set_userdata('rupee_rate', $this->data['rupee_rate']);
        } else {
            $user_ip = getenv('REMOTE_ADDR');
            @$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
            $geoplugin_latitude = $geo["geoplugin_latitude"];
            $geoplugin_longitude = $geo["geoplugin_longitude"];
            $t = time();
            $result = $this->getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude, $t);
            $this->data['time_zone'] = $result;
            $this->data['full_country_name'] = $geo['geoplugin_countryName'];
            $this->data['country_name'] = $geo['geoplugin_countryCode'];
            $this->data['dollar_rate'] = $rupee_dollar_rate['dollar_rate'];
            $this->data['rupee_rate'] = $rupee_dollar_rate['indian_rate'];
            $this->session->set_userdata('dollar_rate', $this->data['dollar_rate']);
            $this->session->set_userdata('rupee_rate', $this->data['rupee_rate']);
            $newdata = array(
                'admin_country_name' => $geo['geoplugin_countryCode'],
                'admin_time_zone' => $result,
                'admin_full_country_name' => $geo['geoplugin_countryName']
            );
            $this->session->set_userdata($newdata);
        }
        if (!$this->session->userdata('copy_right_year')) {
            $result = $this->admin_panel_model->copy_right_year();
            $this->session->set_userdata('copy_right_year', $result['value']);
        }
    }

    function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude, $t)
    {
        @$json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");
        $data = json_decode($json, true);
        $tzone = $data['timeZoneId'];
        return $tzone;
    }

    public function delete_seo_setting()
    {
        $seo_id = $this->input->post('seo_id');
        $result = $this->admin_panel_model->delete_seo_setting($seo_id);
        if ($result > 0) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function terms()
    {
        $this->data['module'] = 'terms';
        $this->load->model('admin_panel_model');
        $this->data['lists'] = $this->admin_panel_model->get_terms();
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function termsedit($id)
    {

        $this->data['module'] = 'terms';
        $this->load->model('admin_panel_model');

        $this->data['datalist'] = $this->admin_panel_model->edit_terms($id);

        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/dashboard/terms/');

        } else {
            if ($this->input->post('form_submit')) {
                $value = $this->input->post('sub_menu');

                
                $data['footer_submenu'] = str_replace(' ', '_', $value);
                
                $data['page_desc'] = $this->input->post('page_desc');
                $this->db->where('id', $id);
                if ($this->db->update('terms', $data)) {
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Terms edited successfully.</div>";
                }

                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/dashboard/terms/');
            }
        }
        $this->data['page'] = 'edit';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function termcreate()
    {
        $this->data['module'] = 'terms';
        if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/dashboard/terms/');

            } else {
                $value = $this->input->post('sub_menu');
                $data['footer_submenu'] = str_replace(' ', '_', $value);
                $data['page_desc'] = $this->input->post('page_desc');
                if ($this->db->insert('terms', $data)) {
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>Terms created successfully.</div>";
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/dashboard/terms');
            }
        }
        $this->data['page'] = 'create';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function update_gig_status()
    {
        $id = $this->input->post('gig_id');
        $status = $this->input->post('update_status');
        $update_data['status'] = $status;
        if ($this->db->query(" UPDATE `sell_gigs` SET `status` = " . $status . " WHERE `id` = " . $id . " ")) {

            $query = $this->db->query("SELECT *, m.username,m.email,a.email as admin_email FROM sell_gigs s 
  										LEFT JOIN members m ON m.USERID = s.user_id 
    									LEFT JOIN administrators a on ADMINID = 1
    									Where s.id=$id");

            $data_one = $query->row_array();


            $title = $data_one['title'];

            $to_email = $data_one['email'];

            $from_email = $data_one['admin_email'];

            $username = $data_one['username'];

            if ($status == '0') {
                $gigstatus = 'Active';
            } else {
                $gigstatus = 'Inactive';
            }


            $bodyid = 36;

            $tempbody_details = $this->templates_model->get_usertemplate_data($bodyid);

            $body = $tempbody_details['template_content'];

            $mail_subject = $tempbody_details['template_title'];

            $message = '';

            $body = str_replace('{base_url}', $this->base_domain, $body);

            $body = str_replace('{base_image}', $this->base_domain . '/' . $this->logo_front, $body);

            $body = str_replace('{username}', $username, $body);

            $body = str_replace('{site_name}', $this->site_name, $body);

            $body = str_replace('{sitetitle}', $this->site_name, $body);

            $body = str_replace('{title}', str_replace("-", " ", $title), $body);

            $body = str_replace('{status}', $gigstatus, $body);

            $message = '<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
								<tr>
									<td></td>
									<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
										<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
											<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
												<tr>
													<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td style="text-align:center;">
																	<a href="{base_url}" target="_blank"><img src="' . $this->logo_front . '" style="width:90px" /></a>
																</td>
															</tr>
															<tr>
																<td>' . $body . '</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
												<table width="100%">
													<tr>
														<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
															&copy; ' . date("Y") . ' <a href="' . $this->base_domain . '" target="_blank" style="color:#bbadfc;" target="_blank">' . $this->site_name . '</a> All Rights Reserved.
														</td>
													</tr>
												</table>
											</div>
										</div>
									</td>
								</tr>
							</table>';

            $this->load->helper('file');
            $this->load->library('email');
            $this->email->initialize($this->smtp_config);
            $this->email->set_newline("\r\n");
            $this->email->from($from_email);
            $this->email->to($to_email);
            $this->email->subject($mail_subject);
            $this->email->message($message);
            
            if ($this->email->send()) {
                echo 1;
            } else {
                echo 1;
            }
        } else {
            echo 2;
        }
    }

    public function index()
    {
        $this->data['recent_orders'] = $this->admin_panel_model->dashboard_recent_gigs();
        $this->data['popular_orders'] = $this->admin_panel_model->dashboard_popular_gigs();
        $this->data['dashboard_details'] = $this->admin_panel_model->dashboard_details();
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function catagorycheck()
    {
        $category_name = $this->input->post('category_name');
        $catagory_id = $this->input->post('catagory_id');
        $result = $this->admin_panel_model->catagorycheck($category_name, $catagory_id);
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            ));
    }

    public function is_valid_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $result = $this->admin_login_model->is_valid_login($username, $password);
        if (!empty($result)) {
            $this->session->set_userdata('id', $result['ADMINID']);
            $this->session->set_userdata('SESSION_USER_ID', $result['ADMINID']);
            $this->session->set_userdata('user_role', $result['user_role']);
            $site_name = $this->admin_panel_model->site_name();
            $this->session->set_userdata('sitename', $site_name['value']);
            echo 1;
        } else {
            echo 2;
            $this->session->set_flashdata('message', 'wrong login credantiales.');
        }
    }

    public function check_existing_ip()
    {
        $ip_addr = $this->input->post('ip_addr');
        $result = $this->admin_panel_model->check_ip($ip_addr);
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            ));
    }

    public function check_old_password()
    {
        $id = $this->session->userdata['id'];
        $password = $this->input->post('old_password');
        $result = $this->admin_login_model->is_valid_password($id, $password);
        if ($result > 0) {
            $isAvailable = TRUE;
        } else {
            $isAvailable = FALSE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            ));
    }

    public function check_footer_menu()
    {
        $menu_name = $this->input->post('menu_name');
        $result = $this->admin_panel_model->is_valid_menu_name($menu_name);
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            ));
    }

    public function check_footer_submenu()
    {
        $menu_name = $this->input->post('menu_name');
        $result = $this->admin_panel_model->is_valid_submenu($menu_name);
        if ($result > 0) {
            $isAvailable = FALSE;
        } else {
            $isAvailable = TRUE;
        }

        echo json_encode(
            array(
                'valid' => $isAvailable
            ));
    }

    public function logout()
    {
        if (!empty($this->session->userdata['id'])) {
            $this->session->unset_userdata('id');
            $this->session->unset_userdata('user_role');
            $this->session->unset_userdata('SESSION_USER_ID');
        }
        redirect(base_url($this->data['theme']));
    }

    public function get_all_notification()
    {
        $result = $this->admin_panel_model->new_notification();

        

        $html = '';
        $total_count = 0;
        if (!empty($result)) {
            $total_count = count($result);
            for($i=0; $i<$total_count; $i++) {

                $user_id = $result[$i]['user_id'];
                $this->load->model('api_user_model');

                $user_record = $this->api_user_model->getUserRecord($user_id);
        
                $full_name = $user_record['fullname'];
                $user_thumb_img = $user_record['user_thumb_image'];

                if($user_thumb_img == '') {
                    $user_thumb_img = base_url() . 'assets/images/avatar2.jpg';
                }
                else {
                    $user_thumb_img = base_url() . $user_thumb_img;
                }

                if ($result[$i]['remark'] == 'membership') {

                    $membership_info = $result[$i]['item_id'];

                    $membership_id = explode('-', $membership_info)[0];
                    $membership_type = explode('-', $membership_info)[1];

                    $query = $this->db->query("select * from memberships where id=$membership_id");
                    $membership_result = $query->result_array();
                    $membership_result = $membership_result[0];

                    $membership_title = $membership_result['title'];

                    if($membership_type == 1) {
                        $type = 'Monthly';
                    }
                    else if($membership_type == 2) {
                        $type = 'Quarterly';
                    }
                    else if($membership_type == 3) {
                        $type = 'Annually';
                    }

                    $text = $full_name . ' suggested to buy the ' . $membership_title . ' as ' . $type . 'method';

                    $html .= '<a href="'. base_url() . 'admin/pending_orders'. '" class="list-group-item" style="height: 60px;">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="' . $user_thumb_img . '">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading" title="'. $text .'">' . $text . '</h5>
									 </div>
								  </div>
                               </a>';
                               
                               

                 } 
                 else if ($result[$i]['remark'] == 'milestone') {

                    $project_id = $result[$i]['item_id'];

                    $query = $this->db->query("select * from projects where id= $project_id");
                    $project_result = $query->result_array();
                    $project_result = $project_result[0];

                    $project_title = $project_result['title'];

                    $text = $full_name . ' suggested to release the project milestone(' . $project_title . ')';

                    $html .= '<a href="'. base_url() . 'admin/pending_orders'. '" class="list-group-item" style="height: 60px;">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="' . $user_thumb_img . '">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading" title="'. $text .'">' . $text . '</h5>
									 </div>
								  </div>
                               </a>';
                               
                } 
                else if ($result[$i]['remark'] == 'withdraw') {

                    $text = $full_name . ' suggested to withdraw his balances';

                    $html .= '<a href="'. base_url() . 'admin/pending_orders'. '" class="list-group-item" style="height: 60px;">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="' . $user_thumb_img . '">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading" title="'. $text .'">' . $text . '</h5>
									 </div>
								  </div>
							   </a>';
                } 
            }

        }
        echo json_encode(array('html' => $html, 'total_count' => $total_count));

    }
}

?>
