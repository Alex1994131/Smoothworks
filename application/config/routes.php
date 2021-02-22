<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//// BEGIN ADMIN ROUTE /////
$route['admin'] = 'admin/dashboard';
$route['admin/terms'] = 'admin/dashboard/terms';

$route['admin/gigs/(:any)'] = 'admin/gigs/index/$1';
$route['admin/gig_activate'] = 'admin/gigs/gig_activate';
$route['admin/admin_delete_gigs'] = 'admin/gigs/admin_delete_gigs';

$route['admin/projects/(:any)'] = 'admin/projects/index/$1';
$route['admin/admin_delete_projects'] = 'admin/projects/admin_delete_projects';

$route['language/pages'] = 'admin/language/pages';
$route['language/pages/(:any)'] = 'admin/language/language';
$route['language_list'] = 'admin/language/language_list';
$route['language_web_list'] = 'admin/language/language_web_list';
$route['language/add-keyword/(:any)'] = 'admin/language/add_keyword';
$route['language/add-page'] = 'admin/language/add_page';
$route['language/keywords'] = 'admin/language/keywords';
$route['language/add-web-keyword'] = 'admin/language/add_web_keyword';

$route['admin/membership'] = 'admin/membership/index';
$route['admin/membership/create'] = 'admin/membership/create_membership';
$route['admin/membership/edit/(:any)'] = 'admin/membership/edit_membership/$1';
$route['admin/membership_detail'] = 'admin/membership/membership_detail';
$route['admin/membership_detail/create_detail'] = 'admin/membership/create_detail';
$route['admin/membership_detail/edit_detail/(:any)'] = 'admin/membership/edit_detail/$1';
$route['admin/membership_group'] = 'admin/membership/membership_group';

$route['orders'] = 'admin/orders';
$route['approve_success/(:any)'] = 'admin/orders/approve_success/$1';
$route['admin/orders/(:any)'] = 'admin/orders/index/$1';
$route['admin/completed_orders'] = 'admin/orders/completed_orders';
$route['admin/completed_orders/(:any)'] = 'admin/orders/completed_orders/$1';
$route['admin/pending_orders'] = 'admin/orders/pending_orders';
$route['admin/pending_orders/(:any)'] = 'admin/orders/pending_orders/$1';
$route['admin/cancel_orders'] = 'admin/orders/cancel_orders';
$route['admin/cancel_orders/(:any)'] = 'admin/orders/cancel_orders/$1';
$route['admin/decline_orders'] = 'admin/orders/decline_orders';
$route['admin/decline_orders/(:any)'] = 'admin/orders/decline_orders/$1';

$route['admin/emailsettings'] = 'admin/settings/emailsettings';

$route['admin/financial/affiliate'] = 'admin/financial/affiliate';
$route['admin/financial/membership'] = 'admin/financial/membership';
$route['admin/financial/commission'] = 'admin/financial/commission';
/*  END ADMIN ROUTE  */


/* BEGIN USER ROUTE  */

// Welcome
$route['get/(:any)/(:any)'] = 'welcome/affiliate/$1/$2';
$route['activate_account/(:any)'] = 'welcome/activate_account/$1';
$route['change_password/(:any)'] = 'welcome/change_password/$1';
$route['check_password'] = 'welcome/check_password';

$route['password'] = 'welcome/password';
$route['profile'] = 'welcome/profile';
$route['payment'] = 'welcome/payment';
$route['user-profile'] = 'welcome/user_profile';
$route['user-profile/(:any)'] = 'welcome/user_profile/$1';
$route['user-profile/(:any)/(:num)'] = 'welcome/user_profile/$1/$2';
$route['terms'] = 'welcome/terms';
$route['tandc'] = 'welcome/tandc';
$route['pages/(:any)'] = 'welcome/pages/$1';
$route['prf_crop'] = 'welcome/prf_crop';
$route['invite-friend'] = 'welcome/invite_friend';
$route['logout'] = 'welcome/logout';

// Gigs
$route['add-gigs'] = 'user/gigs/add_gigs';
$route['edit-gigs/(:any)'] = 'user/gigs/edit_gigs/$1';
$route['save-gigs'] = 'user/gigs/save_gigs';
$route['my-gigs'] = 'user/gigs/my_gigs';
$route['my-gigs/(:any)'] = 'user/gigs/my_gigs/$1';
$route['gig-preview'] = 'user/gigs/gig_preview';
$route['gig-preview/(:any)'] = 'user/gigs/gig_preview/$1';
$route['buy-gigs'] = 'user/gigs/buy_gigs';
$route['buy-gigs/(:any)'] = 'user/gigs/buy_gigs/$1';
$route['purchase-success'] = 'user/gigs/purchase_success';
$route['purchase-success/(:any)'] = 'user/gigs/purchase_success/$1';
$route['favourites'] = 'user/gigs/favourites';
$route['add_favourites'] = 'user/gigs/add_favourites';
$route['remove_favourites'] = 'user/gigs/remove_favourites';
$route['get_state_list'] = 'user/gigs/get_state_list';
$route['load_more_feedbacks'] = 'user/gigs/load_more_feedbacks';
$route['load_more_userfeedbacks'] = 'user/gigs/load_more_userfeedbacks';
$route['devicedetails'] = 'user/gigs/devicedetails';


//Projects
$route['add-project'] = 'user/projects/add_project';
$route['edit-project/(:any)'] = 'user/projects/edit_project/$1';
$route['edit-project/(:any)/(:any)'] = 'user/projects/edit_project/$1/$2';
$route['save-project'] = 'user/projects/save_project';
$route['my-project'] = 'user/projects/my_project';
$route['buy-project'] = 'user/projects/buy_project';
$route['buy-project/(:any)'] = 'user/projects/buy_project/index/$1';
$route['project-preview'] = 'user/projects/project_preview';
$route['project-preview/(:any)'] = 'user/projects/project_preview/$1';
$route['project-preview/(:any)/(:any)'] = 'user/projects/project_preview/$1/$2';
$route['project-proposals/view/(:any)'] = 'user/projects/project_proposals/$1';
$route['project-proposals/award'] = 'user/projects/proposal_award';
$route['project-proposals/accept'] = 'user/projects/proposal_accept';
$route['project-proposals/create_milestone'] = 'user/projects/proposal_create_milestone';
$route['project-proposals/validate_balances'] = 'user/projects/proposal_validate_balances';
$route['project-proposals/request_milestone'] = 'user/projects/proposal_request_milestone';
$route['project-proposals/release'] = 'user/projects/proposal_release';
$route['project-proposals/cancel'] = 'user/projects/proposal_cancel';

//Team Management
$route['team_management'] = 'user/team_management';
$route['team_management/invite/(:any)'] = 'user/team_management/invite_developer/$1';
$route['team_management/exit/(:any)'] = 'user/team_management/exit_developer/$1';

//Membership Management
$route['membership'] = 'user/membership';
$route['membership-success'] = 'user/membership/membership_success';
$route['membership-success/(:any)'] = 'user/membership/membership_success/$1';

// Search country and state
$route['search'] = 'user/search/index';
$route['search/(:any)'] = 'user/search/index';
$route['search/index'] = 'user/search/index';
$route['search/index/(:any)'] = 'user/search/index/$1/';
$route['search/index/(:num)/(:any)'] = 'user/search/index/$1/$2';
$route['search/index/(:num)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3';
$route['search/index/(:num)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4';
$route['search/index/(:num)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5';
$route['search/index/(:num)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6';
$route['search/location'] = 'user/search/location';
$route['search/location/(:any)'] = 'user/search/location/$1';
$route['search/recent'] = 'user/search/recent';
$route['search/recent/(:any)'] = 'user/search/recent/$1';
$route['search/category'] = 'user/search/category';
$route['search/category/(:any)'] = 'user/search/category/$1';
$route['search/category/(:any)/(:any)'] = 'user/search/category/$1/$2';
$route['category-search/(:any)'] = 'user/search/category_search/$1';

$route['message'] = 'user/message';
$route['message/(:any)'] = 'user/message/index/$1';

$route['notification'] = 'user/notification';

$route['transactions'] = 'user/transactions';
$route['balances'] = 'user/balances';
/* END USER ROUTE */