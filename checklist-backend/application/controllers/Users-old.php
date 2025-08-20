<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
	function __construct(){
	header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        // header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Headers:*");
        header('Content-type: application/json');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->database();
		$this->db->query("SET SESSION wait_timeout = 28800;");
        $this->db->query("SET SESSION interactive_timeout = 28800;");
		$this->db->query("SET SESSION innodb_lock_wait_timeout = 120");
        //$this->db->query("SET SESSION wait_timeout = 600");
        $this->db->query("SET SESSION net_read_timeout = 120");
        $this->db->query("SET SESSION net_write_timeout = 120");
        $this->load->model('User_model','users');	
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	 function index()
	{
		
		//$this->load->view('index');
		$this->load->view('userlogin'); 
		//   $this->load->model('User_model');
		//  $this->User_model->getUsersData();
	}

	function dashboard(){
		$this->load->view('dashboard'); 
	}

    function getUsers_post()
	{
		
		$team_id="1";
		echo $team_id; die;
		$result=$this->users->getUsersData($team_id);
		if(!empty($result)){
				$msg = ['status'=>true,'userdata'=>$result,"count"=>count($result)];
			}else{
				$msg = ['status'=>false,'userdata'=>'No data Found'];
			}
		$final= json_encode($msg);
		print_r($final);
	}

	function getTeams(){
		$result=$this->users->getTeamsList();
		if(!empty($result)){
			$msg = ['status'=>true,'teams'=>$result,"count"=>count($result)];
		}else{
			$msg = ['status'=>false,'msg'=>'No data Found'];
		}
		$teams= json_encode($msg);
		print_r($teams);
	}

	//function addUser_post($first_name,$last_name,$user_name,$email,$team_id,$pass_word,$designation){
	function addUser_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		$first_name=$requestData->first_name;
		$last_name=$requestData->last_name;
		$user_name=$requestData->user_name;
		$email=$requestData->email;
		$team_id=$requestData->team_id;
		$board_id =$requestData->board_id;
		$pass_word=$requestData->pass_word;
		$access_role = $requestData->access_role;
		$added_by = $requestData->added_by;

		$result=$this->users->addUsers($first_name,$last_name,$user_name,$email,$team_id,$board_id,$pass_word,$access_role,$added_by);
		if($result==true):
			$msg = ['status'=>true,'user'=>$result,"msg"=>"user added successfully"];
		else:
			$msg = ['status'=>false,'msg'=>'Something went wrong'];
		endif;
		$user= json_encode($msg);
		print_r($user);
	}
	function loginUser_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		// echo '<pre>';print_r($requestData);
		$user_name=$requestData->username;
		$pass_word=$requestData->password;
		$result=$this->users->loginUser($user_name,$pass_word);
		echo json_encode($result);
	}

	// function notifyTeam_post(){
	// 	//print_r($_POST['first_name']);die;
	// 	$user_id=$_POST['user_id'];
	// 	$team_id=$_POST['team_id'];
	// 	$message=$_POST['message'];
	// 	$result=$this->users->notifyTeam($user_id,$team_id,$message);
	// 	if($result==true):
	// 		$msg = ['status'=>true,'user'=>$result,"msg"=>"Message added successfully"];
	// 	else:
	// 		$msg = ['status'=>false,'msg'=>'Something went wrong'];
	// 	endif;
	// 	$user= json_encode($msg);
	// 	print_r($user);
	// }

	function getNotifications(){
		$team_id=$_POST['team_id'];
		$result=$this->users->getNotifications($team_id);
		if(!empty($result)){
			$msg = ['status'=>true,'notifications'=>$result,"count"=>count($result)];
		}else{
			$msg = ['status'=>false,'msg'=>'No data Found'];
		}
		$teams= json_encode($msg);
		print_r($teams);
	}

	function updatePassword_post(){
		$requestData = json_decode(file_get_contents("php://input"));
        $userid = $requestData->userid;
        $oldpassword = $requestData->oldpassword;
        $newpassword = $requestData->newpassword;
		$result=$this->users->updatePassword($oldpassword,$newpassword,$userid);
		$user= json_encode($result);
		print_r($user);
	}


	function getTeamMembers_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		$user_id= isset($requestData->userid) ?  $requestData->userid : '';
		$result=$this->users->getUsersData($user_id);
		if(!empty($result)){
				$msg = ['status'=>true,'userdata'=>$result,"count"=>count($result)];
			}else{
				$msg = ['status'=>false,'userdata'=>'No data Found'];
			}
		echo json_encode($result);
	}


	function notifyTeam_post(){
		$added_by=$_POST['added_by'];
		$board_id=$_POST['board_id'];
		$team_id=$_POST['team_id'];
		$message=$_POST['message'];
		$start_date=$_POST['start_date'];
		$end_date=$_POST['end_date'];
		$is_important=$_POST['is_important'];
		$result=$this->users->notifyTeam($added_by,$board_id,$team_id,$message,$start_date,$end_date,$is_important);
			if($result==true):
			$msg = ['status'=>true,'user'=>$result,"msg"=>"Message added successfully"];
		else:
			$msg = ['status'=>false,'msg'=>'Something went wrong'];
		endif;
		$user= json_encode($msg);
		print_r($user);
	}
	

 function addTaskList_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		
		$insert_details = array('user_id'=>trim($requestData->userid),
								'team_id'=>trim($requestData->teamid),
								'summary'=>trim($requestData->summary),
								'ticket_no'=>trim($requestData->ticket),
								'event_type'=>trim($requestData->task),
								// 'status'=>trim($requestData->status),
								'planned_date'=>trim($requestData->planned_date),
								'timelog'=>trim($requestData->timelog),
								'isprivate'=>(int)trim($requestData->is_private),
								'task_category'=>trim($requestData->task_category),
								'original_estimate'=>trim($requestData->original_estimate),
								'remaining_estimate'=>trim($requestData->remaining_estimate),
								'ticket_status'=>trim($requestData->ticketypeStatus),
								'colorcode'=>trim($requestData->iscolor)
								);       
		$result=$this->users->addTask($insert_details);
		$message_arr = array('msg'=>$result);
        echo json_encode($message_arr);     
		// 	if($result==true):
		// 	$msg = ['status'=>true,"msg"=>"Task added successfully"];
		// else:
		// 	$msg = ['status'=>false,'msg'=>'Something went wrong'];
		// endif;
		// $user= json_encode($msg);
		// print_r($user);
	}

	

	// function getUserTask_post(){
	// 	$team_id=$_POST['team_id'];
	// 	$user_id=$_POST['user_id'];
	// 	$result1=$this->users->getTodaysTasks($team_id,$user_id);
	// 	$result2=$this->users->getYesterdaysTasks($team_id,$user_id);
	// 	$result3=$this->users->getFutureTasks($team_id,$user_id);
	// 	$msg = ['status'=>true,'istodaylist'=>$result1,'isyesterdaylist'=>$result2,'istomorrowlist'=>$result3];
	// 	$final= json_encode($msg);
	// 	print_r($final);
	// }


	public function getUserTask_post(){
        $requestData = json_decode(file_get_contents("php://input"));
         $current_date = date('Y-m-d');
         $yesterday_date = date('Y-m-d', strtotime(' -1 day'));
         $tomorrow_date = date('Y-m-d', strtotime('+1 day'));
         $fetch_array_list_date = $this->users->fetchTasklist($current_date,$yesterday_date,$tomorrow_date,$requestData->useruid);
		 echo json_encode($fetch_array_list_date);
     }


	// function updateChecklistStatus_post(){
	// 	$team_id=$_POST['team_id'];
	// 	$user_id=$_POST['user_id'];
	// 	$task_id=$_POST['task_id'];
	// 	$task_status=$_POST['task_status'];
	// 	$result=$this->users->updateChecklist($team_id,$user_id,$task_id,$task_status);
	// 	$user= json_encode($result);
	// 	print_r($user);
	// }

	public function updateChecklistStatus_post(){
        $requestData = json_decode(file_get_contents("php://input"));
        $task_id = $requestData->task_id;
        $user_id = $requestData->userid;
		$status = $requestData->status;
		$taskname = $requestData->taskname;
		$originalestimate = $requestData->original;
		$remainingestimate = $requestData->remaining;
		$ticketname = $requestData->tickettypestatus;
		$ticketcolor = $requestData->colorcode;

        $completed_tasks = $this->users->updateChecklist($task_id,$user_id,$status,$taskname,$originalestimate,$remainingestimate,$ticketname,$ticketcolor);
        $message_update = array('msg'=>$completed_tasks);
        echo json_encode($message_update);
    }


	function addBlocker_post(){
        $requestData = json_decode(file_get_contents("php://input"));
 
        $team_id=$requestData->team_id;
        $added_by=$requestData->added_by;
        $sent_to=$requestData->sent_to;
        $message=$requestData->message;
        $planned_date=$requestData->planned_date;
        $result=$this->users->addBlockerMessage($team_id,$added_by,$sent_to,$message,$planned_date);
        if($result==true):
            $msg = ['status'=>true,'blocker_message'=>$result,"msg"=>"blocker added successfully"];
        else:
            $msg = ['status'=>false,'msg'=>'Something went wrong'];
        endif;
        $user= json_encode($msg);
        print_r($user);
    }
	function getBlockerMeassage_post(){
		    $requestData = json_decode(file_get_contents("php://input"));

		    $team_id = $requestData->team_id;
		    $added_by = $requestData->added_by;
		    $sent_from = array();
		    $planned_date = $requestData->planned_date;
            $received_from=$this->users->getBlockerList($team_id,$added_by,$planned_date);
            $sent_from=$this->users->getBlockerListSent($team_id,$added_by,$planned_date);
        if( !empty($sent_from)){
            $msg = ['status'=>true,'blocker_messages_received'=>$received_from, 'blocker_messages_sent'=>$sent_from];
        }else{
            $msg = ['status'=>false,'msg'=>'No data Found'];
        }
		echo  json_encode($msg);
       
    }
	

	/*function addUserAttendence_post(){
		$user_id=$_POST['user_id'];
		$team_id=$_POST['team_id'];
		$is_absent=$_POST['is_absent'];
		$start_date=$_POST['start_date'];
		$end_date=$_POST['end_date'];
		$added_by=$_POST['added_by'];
		$result=$this->users->addAttendence($user_id,$team_id,$is_absent,$start_date,$end_date,$added_by);
		if($result==true):
			$msg = ['status'=>true,"msg"=>"Attendence added successfully"];
		else:
			$msg = ['status'=>false,'msg'=>'Something went wrong'];
		endif;
		$user= json_encode($msg);
		print_r($user);
	}*/

	function addUserAttendence_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		$user_id=$requestData->user_id;
		$team_id=$requestData->team_id;
		$is_absent=1;
		$start_date=$requestData->start_date;
		$end_date=$requestData->end_date;
		$added_by=$requestData->added_by;
		$result=$this->users->addAttendence($user_id,$team_id,$is_absent,$start_date,$end_date,$added_by);
		if($result==true):
			$msg ="Attendence added successfully";
		else:
			$msg ="Something went wrong";
		endif;
		echo json_encode($msg);
	}
	

	function getUserAttendence_post(){
		$user_id=$_POST['user_id'];
		$result=$this->users->getAttendence($user_id);
		if(!empty($result)){
			$msg = ['status'=>true,'attendence_details'=>$result,"count"=>count($result)];
		}else{
			$msg = ['status'=>false,'msg'=>'No data Found'];
		}
	$final= json_encode($msg);
	print_r($final);
	} 

	/** New Functions added for Checklist bucket */
	public function updatebucketlist(){
        $requestData = json_decode(file_get_contents("php://input"));
        $update_details = array(
              'task_id'=>$requestData->arr->task_id,
              'summary'=>$requestData->arr->summary,
              'status'=>$requestData->arr->status,
              'event_type'=>$requestData->arr->event_type,
              'ticket_no'=>$requestData->arr->ticket_no,
              'timelog'=>$requestData->arr->timelog,
              'userid'=>$requestData->bucketuser
        );
        $date_modified = $requestData->list;
        $update_task_list = $this->users->update_task_list($update_details,$date_modified);
        echo json_encode($update_task_list);
    }

	public function getEdituserDetailsspecific(){
        $requestData = json_decode(file_get_contents("php://input"));
        $user_id = $requestData->user_id;
        $edit_id = $requestData->edit_id;
        $edit_details = $this->users->Updateedituserdetailspopup($user_id,$edit_id);
        echo json_encode($edit_details);
    }

	public function gettaskUpdatedetailscolumn(){
        $requestData = json_decode(file_get_contents("php://input"));
        $fetch_data = array();
        $fetch_data['fieldname']=array(
            'fieldname'=>$requestData->fieldname,
            'value'=>$requestData->value,
            'task_id'=>$requestData->taskid
        ); 
        $getUpdatebucketlistdetails = $this->users->getcolumndetailsUpdated($fetch_data);
        $message = array('msg'=>$getUpdatebucketlistdetails);
         echo json_encode($message);
    }

	public function deletetasks1(){
        $requestData = json_decode(file_get_contents("php://input"));
        $delete_id = $requestData->del_id;
        $user_id = $requestData->userid;
        $deleted_tasks = $this->users->getdeletedStatus2($delete_id,$user_id);
        echo json_encode($deleted_tasks);
    }

	public function boarddetails(){
		$requestData = json_decode(file_get_contents("php://input"));
		//$admin_id = (isset($requestData->admin_id) ?  $requestData->admin_id : 'admin');
		$getBoarddetails =$this->users->getRegiondetails();
		echo json_encode($getBoarddetails);
	}

	public function teamdetails(){
		$requestData = json_decode(file_get_contents("php://input"));
		$admin_id = (isset($requestData->admin_id) ?  $requestData->admin_id : 1);
		$getTeamdetails =$this->users->getTeamdetails($admin_id);
		echo json_encode($getTeamdetails);
	}

	public function postNotification(){
		$requestData = json_decode(file_get_contents("php://input"));
		$board = $requestData->board;
		if($board !=0){
			$board = $requestData->board;
			$startDate = $requestData->startDate;
			$endDate = $requestData->endDate;
			$teamid = $requestData->teamid;
			$message = $requestData->message;
			$added_id = 1;
			$postNotification = $this->users->postNotificationdetails($added_id,$board,$teamid,$message,$startDate,$endDate);
        $message = array('msg'=>$postNotification);
		echo json_encode($message);
		}
	}

	public function getNotificationtoast(){
		$requestData = json_decode(file_get_contents("php://input"));
	    $team_id = $requestData->board_id;
		$current_date = date('Y-m-d');
		$getNotificationDetails = $this->users->getNotificationsposts($current_date,$team_id);
		echo json_encode($getNotificationDetails);
	}

   function Currentweekabsentdetails(){
	   $requestData = json_decode(file_get_contents("php://input"));
	   $absentDetails =  $this->users->currentAbsentDetails();
	  echo json_encode($absentDetails);
	}

	public function allDates(){
		$requestData = json_decode(file_get_contents("php://input"));
 		$user_id = $requestData->userid;
		$current = $requestData->logged;
        $getAlllistTask = $this->users->getDatesList($user_id,$current);
		echo json_encode($getAlllistTask);
	}


	public function allDatesPrev(){
		$requestData = json_decode(file_get_contents("php://input"));
		$user_id = $requestData->userid;
		$getAlllistTask = $this->users->getDatesListprev($user_id);
		echo json_encode($getAlllistTask);
		
	}

	/**function Copyticketclone(){
		$requestData = json_decode(file_get_contents("php://input"));
		$getcloneticketDetails = array(
			 'startdate'=>(isset($requestData->startdate) ? $requestData->startdate : ''),
			 'enddate'=> (isset($requestData->enddate) ? $requestData->enddate : ''),
			 'task_title'=> $requestData->tasktitle,
			 'ticket_no'=> $requestData->ticket,
			 'task_type'=>$requestData->task_type,
			 'user_id'=>$requestData->userid,
			 'team_id'=>$requestData->teamid,
		);
		$getCloneDetails = $this->users->getCloneDetails($getcloneticketDetails);
		echo json_encode($getCloneDetails);
	}**/

	/** New Copy Functionaliy **/
	function Copyticketclone(){
	
	$requestData = json_decode(file_get_contents("php://input"));
	// $getTicketDetails = getJiraTicket("11122");
	 $tt = $requestData->ticket;
	$getdetails =  $this->users->getJiraTicket($tt);
	if($getdetails['statuscode'] === 200){
		$taskCategory = $getdetails['task_category'];
		$originalestimate = $getdetails['originalEstimate'];
		$timeSpent = $getdetails['timespent'];
		$remainingEstimate = $getdetails['remainingEstimate'];
		$ticketstatus = $getdetails['ticketstatus'];
		$colorcode = $getdetails['colorcode'];
	 }else{
		$taskCategory = '';
		$originalestimate = '';
		$timeSpent = '';
		$remainingEstimate = '';
		$ticketstatus ='';
		$colorcode ='';
	 }
        $getcloneticketDetails = array(
			'startdate'=>(isset($requestData->startdate) ? $requestData->startdate : ''),
			'enddate'=> (isset($requestData->enddate) ? $requestData->enddate : ''),
			'task_title'=> $requestData->tasktitle,
			'ticket_no'=> $requestData->ticket,
			'task_type'=>$requestData->task_type,
			'user_id'=>$requestData->userid,
			'team_id'=>$requestData->teamid,
			'taskCategory'=>$taskCategory,
			'originalestimate'=>$originalestimate,
			'timespent'=>$timeSpent,
			'remianing'=>$remainingEstimate,
			'ticket_status'=>$ticketstatus,
			'colorcode'=>$colorcode
	   );
	   $getCloneDetails = $this->users->getCloneDetails($getcloneticketDetails);
	   echo json_encode($getCloneDetails);
	
	//  echo $getTicketDetails;exit;
	
   }

	// function Sortupdatelist(){
	// 	$requestData =json_decode(file_get_contents("php://input"));
    //     $newIndex = $requestData->newIndex;
	// 	$oldIndex = $requestData->oldIndex;
	// 	$editID   = $requestData->editID; 
	// 	$planned_date = $requestData->planned_date;
	// 	$user_id  = $requestData->user_id;
	// 	$eventtype = $requestData->event;
	// 	$sortResults = $this->users->getSortupdateDetails($newIndex,$oldIndex,$editID,$planned_date,$user_id,$eventtype);
	// 	echo json_encode($sortResults);
	// }
	function Sortupdatelist(){
	  $requestData =json_decode(file_get_contents("php://input"));
      $details = $requestData->details;
	  $user_id  = $requestData->user_id;
	  $sortResults = $this->users->getSortupdateDetails($details,$user_id);
	  echo json_encode($sortResults);

	}

    /** Calendar Function */
	function Selectedlist(){
		$requestData = json_decode(file_get_contents("php://input"));
		$startRange = $requestData->list->previousDate;
		$endRange   = $requestData->list->next;
		$uuid       = $requestData->list->uuid;
		$datelist = array('startDate'=>$startRange,'endDate'=>$endRange,'uuid'=>$uuid);
		$getAlllistTask = $this->users->getselectedDates($datelist);
		echo json_encode($getAlllistTask);
	}

	/** Team bubble status **/
	 function teamstatustask(){
		$requestData = json_decode(file_get_contents("php://input"));
		$team_id = $requestData->teamid;
   		$getTeamdetails = $this->users->getteamtaskdetails($team_id);
		echo json_encode($getTeamdetails);
	}

	/** Activity Messages **/
	 function getChecklistItemActivityLog_post(){
	$requestData = json_decode(file_get_contents("php://input"));
	$team_id = $requestData->team_id;
	$loadoptions = isset($requestData->load) ? (int)$requestData->load : '0';

	if($loadoptions == 0){
		$result=$this->users->getActivityLog($team_id);
	}else{
		$result=$this->users->getActivityLog($team_id,$loadoptions);
	}
	
	if(!empty($result)){
		$msg = ['status'=>true,'activity'=>$result];
	}else{
		$msg = ['status'=>false,'msg'=>'No data Found'];
	}
    echo json_encode($msg);	
}

function getTotalActivitylogmessages(){
	$requestData = json_decode(file_get_contents("php://input"));

	// $team_id = 1;
	$team_id = $requestData->team_id;
	$resultCount=$this->users->getactivityMessagesCount($team_id);
	echo json_encode($resultCount);
}

function usersrole(){
	$requestData = json_decode(file_get_contents("php://input"));
	$userroleupdate = $requestData->updatedetails;

	$updateRoles=$this->users->updateUsersRole($userroleupdate);
	echo json_encode($updateRoles);
}
/** Specific Users List */
	function get_specific_teams_list(){
		$requestData = json_decode(file_get_contents("php://input"));
		$board_id = $requestData->board_id;
		$team_id =  $requestData->team_id;
		$listUsers=$this->users->listUsers($board_id,$team_id);
		echo json_encode($listUsers);
	}
  function teamlistdevs(){
	$requestData = json_decode(file_get_contents("php://input"));
	$bid = $requestData->bid;  
	$getAllteamslist = $this->users->getAllTeamlist($bid);
	echo json_encode($getAllteamslist);
}
function getbatchdevs(){
	$requestData = json_decode(file_get_contents("php://input"));
	$team_id = $requestData->teamid;

	$getteamsdevs = $this->users->getteamdevsBatch($team_id);
	echo json_encode($getteamsdevs);
}
function deleteUser(){
		$requestData = json_decode(file_get_contents("php://input"));
		$userid   = $requestData->userid;

		$deleteusers = $this->users->Removeusers($userid);
		echo json_encode($deleteusers);
}

/*Dashbord summary data*/
function dashboard_summary_post(){
	$requestData = json_decode(file_get_contents("php://input"));
	$requested_date= $requestData->requested_date;
	$result=$this->users->dashboardSummary($requested_date);
	echo json_encode($result);
	// echo $summary;
}

function attendance_summary_post(){
	$requestData = json_decode(file_get_contents("php://input"));
	$requested_date= $requestData->requested_date;
	$result=$this->users->attendanceSummary($requested_date);
	
	echo json_encode($result);
}

/*Absent list*/
// function absent_summary_post(){
// 	$from_date=isset($_POST['from_date'])?$_POST['from_date']:'0';
// 	$to_date=isset($_POST['to_date'])?$_POST['to_date']:'0';
// 	$user_id=$_POST['user_id'];
// 	$type=$_POST['type'];
// 	$result=$this->users->absentSummary($from_date,$to_date,$user_id,$type);
// 	$summary= json_encode($result);
// 	print_r($summary);
// }
 function absent_summary_post(){
	
	$requestData = json_decode(file_get_contents("php://input"));
	$user_id= $requestData->user_id;
	$type = $requestData->type;
	$result=$this->users->absentSummary($user_id,$type);
    echo json_encode($result);
 }

// /* Track Activity users*/
// function track_user_activity_post(){
//     /*
//     Activity types
//     1-Add User
//     2-Modify user
//     3-Delete user
//     4-Add Checklist
//     5-Copy Checklist
//     6-Delete Checklist
//     7-Update checklist
//     8-Notify team
//     9-Blocker Conversation
//     10-Mark attendance
//     11-Change password
//     12-Login
   
//     */
//         $user_id=$_POST['user_id'];
//         $added_by=$_POST['added_by'];
//         $activity_type=$_POST['activity_type'];
//         $activity_details=$_POST['activity_details'];
//         $result=$this->users->addUserActivity($user_id,$added_by,$activity_type,$activity_details);
//         if($result==true):
//             $msg = ['status'=>true,"msg"=>"activity added successfully"];
//         else:
//             $msg = ['status'=>false,'msg'=>'Something went wrong'];
//         endif;
//         $user= json_encode($msg);
//         print_r($user);
// }
 /* Track Activity users*/
function track_user_activity_post(){
    /*
    Activity types
    1-Add User
    2-Modify user
    3-Delete user
    4-Add Checklist
    5-Copy Checklist
    6-Delete Checklist
    7-Update checklist
    8-Notify team
    9-Blocker Conversation
    10-Mark attendance
    11-Change password
    12-Login
   
    */
	 $requestData = json_decode(file_get_contents("php://input"));
 
        $user_id=$requestData->user_id;
        $added_by=$requestData->added_by;
        $activity_type=$requestData->activity_type;
        $activity_details=$requestData->activity_details;
		$board_id = $requestData->board_id;
	 	 $ticketno = $requestData->ticket_no; 	
        $result=$this->users->addUserActivity($user_id,$added_by,$activity_type,$activity_details,$board_id,$ticketno);
        echo json_encode($result);
}

function deactivateUsers(){
	$requestData = json_decode(file_get_contents("php://input"));
	$userid = $requestData->userid;
	$added_by = $requestData->added_by;
	$getuserdetails = $this->users->getdeactivateDetails($userid,$added_by);
	echo json_encode($getuserdetails);
 }
  function activity_track_details(){
	$requestData = json_decode(file_get_contents("php://input"));
	$userid = $requestData->userid;
	$username = $requestData->username;
	$added_by = $requestData->added_by;
	$deactivateusers = $this->users->deactivateDetails($userid,$added_by,$username);
	echo json_encode($deactivateusers);
 }
 function loadactivityTracker(){
    $requestData = json_decode(file_get_contents("php://input"));
	$skip = (int)$requestData->skip;
	$limit = (int)$requestData->limit;
	$response = $this->users->userActivity($skip,$limit);
	echo json_encode($response); 
}
function privateMode(){
	$requestData = json_decode(file_get_contents("php://input"));
	$taskid = $requestData->taskid;
	$checkstatus = $requestData->status;
	
	$response = $this->users->decodeactivity($taskid,$checkstatus);
}
function sortdatasearch(){
$requestData = json_decode(file_get_contents("php://input"));
$user_id = isset($requestData->user_id) ? $requestData->user_id : " ";
$activity_type = isset($requestData->activity_type) ? ($requestData->activity_type): " ";


$skip =  (int)$requestData->skip;
$limit = (int)$requestData->limit;

if(isset($requestData->searchdate[0])){
	$startdate = $requestData->searchdate[0];
}else{
	$startdate =false;
}
if(isset($requestData->searchdate[1]) && $requestData->searchdate[1] != null ){
	$enddate = $requestData->searchdate[1];
}else{
	$enddate = $requestData->searchdate[0];
	//  if(isset($requestData->searchdate[0])){
	// 	$enddate = $requestData->searchdate[0];
	//  }else{
	// 	$enddate =false;
	//  }
}
$getFilteredResults = $this->users->getFilteredResultsActivitytypenoactivitytype(trim($user_id),trim($activity_type),trim($startdate),trim($enddate),$skip,$limit);
echo json_encode($getFilteredResults);
}

function activitytitle(){
	$getActivitytitle = $this->users->activitytitle();
	echo json_encode($getActivitytitle);

}
 function barchartstatus(){
	$requestData = json_decode(file_get_contents("php://input"));
	
$username = isset($requestData->username) ? $requestData->username :"";
$teamid = isset($requestData->teamid) ? trim($requestData->teamid) :"";
if(isset($requestData->dates[0])){
	$startdate = $requestData->dates[0];
}else{
	$startdate =false;
}
if(isset($requestData->dates[1]) && $requestData->dates[1] != null ){
	$enddate = $requestData->dates[1];
}else{
	 if(isset($requestData->dates[0])){
		$enddate = $requestData->dates[0];
	 }else{
		$enddate =false;
	 }
}

//$startdate = isset($requestData->dates[0]) ? $requestData->dates[0]:"";
//$enddate = isset($requestData->dates[1] || $requestData->dates[1] != null) ? $requestData->dates[1]:$requestData->dates[0];
$getbardetails = $this->users->getBargraphDetails(trim($username),trim($teamid),trim($startdate),trim($enddate));
 echo json_encode($getbardetails);
 }

 /*Jira Data*/
function getjiraDatawithToken_post(){
	$requestData = json_decode(file_get_contents("php://input"));
	$ticket_no = !empty($requestData->ticketno) ? $requestData->ticketno:'';

	// $user_id=isset($_POST['user_id'])?$_POST['user_id']:1;
	//$ticket_no=isset($_POST['ticket_no'])?$_POST['ticket_no']:'0';
	$jiraUrl="https://jira.xpaas.lenovo.com/rest/api/latest/issue/$ticket_no";
	$getJiraKeys = $this->users->getJiraAccessKey();
	$jira_user_access_key = $getJiraKeys['jira_access_key'];
	$apiToken=$jira_user_access_key;
	$userId='uk2';
	$jql = 'fields=issuetype,timetracking,status';
	// URL with JQL query parameters
	$requestUrl = "$jiraUrl?$jql";
	
	$ch = curl_init($requestUrl);
	
	 // Set cURL options
	curl_setopt_array($ch, [
		CURLOPT_RETURNTRANSFER => true,   // Return response as a string
		CURLOPT_HTTPHEADER => [
			'Accept: application/json',
			'Authorization: Bearer '.$apiToken.'', 
			// Specify the expected response format
		],
		CURLOPT_USERPWD => "$userId:$apiToken", 
		// Basic authentication using email and API token
	]);
	
  
	// Execute cURL session
	$response = curl_exec($ch);

	// Check for errors
	if(curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	} else {
		// HTTP status code
		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo "Status options";
		// echo $statusCode;exit;
		// Check if request was successful (status code 200)
		if ($statusCode == 200) {
			$decodedResponse = json_decode($response);
		// Output the response (for demonstration)
        //New color code Added
        // $colorcodejira = array('default'=>'#6787F1','yellow'=>'#e98224','green'=>'green');
		$colorcodejira = array('default'=>'#6787F1','inprogress'=>'#e98224','success'=>'green');
		$colorcode = $colorcodejira[$decodedResponse->fields->status->statusCategory->colorName];
		$ticketstatus  = $decodedResponse->fields->status->name;
		$colorstatus   = $colorcode; 
		//New Code Added for color code  
		// Access issuetype object and retrieve the name field
		$issueTypeName = $decodedResponse->fields->issuetype->name;
		$originalEstimate =isset($decodedResponse->fields->timetracking->originalEstimate) ? $decodedResponse->fields->timetracking->originalEstimate : 0.0;
		$remainingEstimate = isset($decodedResponse->fields->timetracking->remainingEstimate) ? $decodedResponse->fields->timetracking->remainingEstimate:'';
		$timeSpent=isset($decodedResponse->fields->timetracking->timeSpent) ? $decodedResponse->fields->timetracking->timeSpent : '0h';
		$timespentestimate = ($timeSpent === 'null') ? '0h' : $timeSpent;
		// $msg = ['task_category'=>$issueTypeName,'originalEstimate'=>$originalEstimate,'remainingEstimate'=>$remainingEstimate,'statuscode'=>$statusCode,'timespent'=>$timeSpent];
		$issueStatusColor = $decodedResponse->fields->status->statusCategory->colorName;
		$issueStatusName = $decodedResponse->fields->status->statusCategory->name;
		$msg = ['issueStatusColor'=>$issueStatusColor,'issueStatusName'=>$issueStatusName,'task_category'=>$issueTypeName,'originalEstimate'=>$originalEstimate,'remainingEstimate'=>$timeSpent,'statuscode'=>$statusCode,'timespent'=>$timeSpent,'ticketstatus'=>$ticketstatus,'colorcode'=>$colorstatus]; 
		echo json_encode($msg);
		} else {
			echo 'Error: ' . $statusCode;
		}
	}
	// Close cURL session
	curl_close($ch);
}

/*Add Jira Personal Access Key*/ 
function addJiraKey_post(){
	$user_id=$_POST['user_id']?$_POST['user_id']:1;
	$access_key=$_POST['jira_access_key']?$_POST['jira_access_key']:'0';
	$addJiraKeys = $this->users->addUserJiraAcessKeys($user_id,$access_key);
	$message = array('msg'=>$addJiraKeys);
	echo json_encode($message);

}
 
/*Generate User Report*/ 
function getreports_post(){
	$user_id=isset($_POST['user_id'])?$_POST['user_id']:1;
	$ticket_no=isset($_POST['ticket_no'])?$_POST['ticket_no']:'';
	$from_date=isset($_POST['from_date'])?$_POST['from_date']:'';
	$to_date=isset($_POST['to_date'])?$_POST['to_date']:'';
	$status=isset($_POST['status'])?$_POST['status']:'';
	$task_type=isset($_POST['task_type'])?$_POST['task_type']:'';
	$result=$this->users->reportByfilter($user_id,$ticket_no,$from_date,$to_date,$status,$task_type);
	$summary= json_encode($result);
	print_r($summary);

}

/** Current SSO login details **/

/** Get Current User SSO Login */
function getCurrentUser(){
 $getCurrentUser = get_current_user() ? get_current_owner() : $_SERVER['AUTH_USER'];
  $user = posix_getpwuid(posix_geteuid());
  echo '<pre>';print_r($user);
 // echo $getCurrentUser; 
 // echo gethostname();
   //$getCurrentUser = get_current_user() ? get_current_user() : $_SERVER['REDIRECT_REMOTE_USER'];
   $loggedinUser = $getCurrentUser;
   echo json_encode($loggedinUser);
}
 
function loginUser_post_sso(){
	$requestData = json_decode(file_get_contents("php://input"));
	$user_name=trim($requestData->username);
	$pass_word=trim($requestData->password);
	
    $result=$this->users->loginUser($user_name,$pass_word);
	
	 echo json_encode($result);
}

}
