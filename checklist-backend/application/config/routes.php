<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['500_override'] = '';
//$route['translate_uri_dashes'] = FALSE;


//Step 1 APIs

$route['getusers'] = 'Users/getUsers_post';

$route['add_user'] = 'Users/addUser_post';
$route['get_all_dates'] = 'Users/allDates';
$route['get_tasks_res'] = 'Users/allDatesUsers';
$route['notify_team']='Users/notifyTeam_post';
$route['update_user_roles'] = 'Users/usersrole';
$route['getNotifications']='Users/getNotifications';
$route['update_password']='Users/updatePassword_post';
$route['get_specific_bucket_list']='Users/get_cur_bucket_list';
$route['get_team_members']='Users/getTeamMembers_post';
$route['get_teams'] = 'Users/getTeams';
$route['login_user']='Users/loginUser_post';
$route['taskstatus'] ='Users/teamstatustask';
$route['get_specific_board_teams_list']='Users/get_specific_teams_list';
$route['add_task_list']='Users/addTaskList_post';
$route['get_task_list']='Users/getUserTask_post';
$route['update_checklist_status']='Users/updateChecklistStatus_post';
$route['update_bucket_list']='Users/updatebucketlist';
$route['editdetailsusers']='Users/getEdituserDetailsspecific';
$route['updatetaskcolumn']='Users/gettaskUpdatedetailscolumn';
$route['updatetaskcolumnjira'] = 'Users/gettaskUpdatedetailscolumnjira';
$route['add_blocker_message']='Users/addBlocker_post';
$route['get_blocker_message']='Users/getBlockerMeassage_post';
$route['add_attendence']='Users/addUserAttendence_post';
$route['get_attendence']='Users/getUserAttendence_post';
$route['deletetasks1'] = 'Users/deletetasks1';
$route['deleteuser'] = 'Users/deleteUser';
$route['getboarddetails'] = 'Users/boarddetails';
$route['getteamdetails'] = 'Users/teamdetails';
$route['postnotifications'] = 'Users/postNotification';
$route['getNotificationtoast'] = 'Users/getNotificationtoast';
$route['addchecklistdetails'] = 'Users/addchecklistdetails';
$route['updatesortoder'] = 'Users/Sortupdatelist';
$route['selectedlist'] = 'Users/Selectedlist';
$route['copyticket'] = 'Users/Copyticketclone';
$route['private_tracker'] = 'Users/privateMode';



$route['deactivateusersdetails'] = 'Users/deactivateUsers';
$route['activity_track_details'] = 'Users/activity_track_details';
$route['updateactivitylog'] = 'Users/updateactivitylog';

$route['activity_tracker'] = 'Users/track_user_activity_post';



$route['getbatchdevs'] = 'Users/getbatchdevs';

/** Get All teams in a Board */
$route['teamlistdevs'] = 'Users/teamlistdevs';

$route['activity_log']='Users/getChecklistItemActivityLog_post';
$route['total_activity_log_messages']='Users/getTotalActivitylogmessages';
$route['track_activity_log']='Users/getgroupActivitylog';
$route['loadactivitytracker'] = 'Users/loadactivityTracker';

/** Attendance functionality */
$route['getCurrentweekabsentdetails'] = 'Users/Currentweekabsentdetails';
$route['dashboard_summary'] ='Users/dashboard_summary_post';
$route['attendance_summary'] ='Users/attendance_summary_post';
$route['absent_summary'] ='Users/absent_summary_post';


/** Search for different Parameters */
$route['getnameSearch'] = 'Users/getnamesearch';
$route['searchactivitytracker'] = 'Users/searchresults';
$route['allactivities'] = 'Users/activitytitle';
$route['datesearch'] = 'Users/activitydate';
$route['sortdatasearch'] = 'Users/sortdatasearch';
$route['barchartstatus'] = 'Users/barchartstatus';
// $route['jira'] = 'Users/jiradata';
$route['add_jira_key']='Users/addJiraKey_post';
$route['jira_data']='Users/getjiraDatawithToken_post';
$route['jqldata']='Users/jiradataJQL';
$route['currentuser']='Users/getCurrentUser';

$route['login_user_sso']='Users/loginUser_post_sso';

//Jql Data
$route['jqlticket'] ='Users/ticket_label';
$route['jqllabel'] ='Users/fetchlabelcql';

$route['pendingtasks'] = 'Users/pendingtasks';

$route['timetool'] = 'Users/timetool';

$route['sendmail'] = 'Users/sendmail';
$route['resetmail'] = 'Users/resetmail';

$route['verifytoken'] = 'Users/verifytoken';

$route['devstatus'] = 'Users/devstatus';

$route['sendmail'] = 'Users/MailSender';


$route['calendarabsentdetails'] ='Users/calendardetails';
?>

