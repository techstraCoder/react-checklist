<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once __DIR__ . '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// #[\AllowDynamicProperties]
class Users extends CI_Controller {
	function __construct(){
		header('Access-Control-Allow-Origin: *');
		// header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Content-Type");
        // header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Headers: *");
        header('Content-type: application/json');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
        $this->load->model('User_model','users');
		
	}


//   function __construct() {
//     parent::__construct();

//     // Allow CORS for all origins or a specific one
    

//     $this->load->model('User_model', 'users');
// }


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
	function teamstatustask(){
		$requestData = json_decode(file_get_contents("php://input"));
		$team_id = $requestData->teamid;

		$getTeamdetails = $this->users->getteamtaskdetails($team_id);

		echo json_encode($getTeamdetails);
	}

   function loginUser_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		$user_name=$requestData->username;
		$pass_word=$requestData->password;
		$result=$this->users->loginUser($user_name,$pass_word);
		echo json_encode($result);
	}
	function Currentweekabsentdetails(){
	   $requestData = json_decode(file_get_contents("php://input"));
	   //$board_id = $requestData->board_id;
	  // $absentDetails =  $this->users->currentAbsentDetails($board_id);
	   $absentDetails =  $this->users->currentAbsentDetails();
	  echo json_encode($absentDetails);
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

       $requestData = json_decode(file_get_contents("php://input"));

       $added_by = isset($requestData->userid) ? intval($requestData->userid) : 0;
	   $board_id = isset($requestData->board_id) ? intval($requestData->board_id) : 0;
	   $team_id =  isset($requestData->teamid) && is_array($requestData->teamid)  ? array_map('intval',$requestData->teamid) : [];
	   $message = isset($requestData->message) ? trim($requestData->message) : ''; 
	   $start_date = $requestData->start_date ?  trim($requestData->start_date) : '';
	   $end_date = $requestData->end_date ?  trim($requestData->end_date) : '';
	   $is_important = isset($requestData->is_important) ? intval($requestData->is_important) :0;  
	  
	   $result=$this->users->notifyTeam($added_by,$board_id,$team_id,$message,$start_date,$end_date,$is_important);
			if($result==true):
			$msg = ['status'=>true,'user'=>$result,"msg"=>"Message added successfully"];
		else:
			$msg = ['status'=>false,'msg'=>'Something went wrong'];
		endif;
		$user= json_encode($msg);
		print_r($user);
	}
	function allDates(){
		$requestData = json_decode(file_get_contents("php://input"));
		// echo '<pre>';print_r($requestData);exit;
		$user_id = $requestData->userid;
		$current = $requestData->logged;
	
		$getAlllistTask = $this->users->getDatesList($user_id,$current);
		echo json_encode($getAlllistTask);
	}

	function Selectedlist(){
		$requestData = json_decode(file_get_contents("php://input"));
		$startRange = $requestData->list->previousDate;
		$endRange   = $requestData->list->next;
		$uuid       = $requestData->list->uuid;
		$datelist = array('startDate'=>$startRange,'endDate'=>$endRange,'uuid'=>$uuid);
		$getAlllistTask = $this->users->getselectedDates($datelist);
		echo json_encode($getAlllistTask);

	}

	// function Sortupdatelist(){
		// $requestData =json_decode(file_get_contents("php://input"));
        // $newIndex = $requestData->newIndex;
		// $oldIndex = $requestData->oldIndex;
		// $editID   = $requestData->editID; 
		// $planned_date = $requestData->planned_date;
		// $user_id  = $requestData->user_id;
		// $eventtype = $requestData->event;
		// $sortResults = $this->users->getSortupdateDetails($newIndex,$oldIndex,$editID,$planned_date,$user_id,$eventtype);
		// echo json_encode($sortResults);
	// }

	function Sortupdatelist(){
	  $requestData =json_decode(file_get_contents("php://input"));
      $details = $requestData->details;
	  $user_id  = $requestData->user_id;
	  $sortResults = $this->users->getSortupdateDetails($details,$user_id);
	  echo json_encode($sortResults);

	}

	function allDatesUsers(){
		$requestData = json_decode(file_get_contents("php://input"));
		// $user_id = $requestData->userid;
		$getAlllistTask = $this->users->getDatesListUsers();
		echo json_encode($getAlllistTask);
	}

	function addTaskList_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		
		/** Insert Specific Users details */
		$insert_details = array('user_id'=>trim($requestData->userid),
								'team_id'=>trim($requestData->teamid),
								'summary'=>$requestData->summary,
								'ticket_no'=>trim($requestData->ticket),
								'event_type'=>trim($requestData->task),
								'status'=>trim($requestData->status),
								'planned_date'=>trim($requestData->planned_date),
								'timelog'=>trim($requestData->timelog),
							    'isprivate'=>(int)trim($requestData->is_private),
							    'task_category'=>trim($requestData->task_category),
								'original_estimate'=>trim($requestData->original_estimate),
								'remaining_estimate'=>trim($requestData->remaining_estimate),
								'ticket_status'=>trim($requestData->ticketypeStatus),
								'colorcode'=>trim($requestData->iscolor)
							  ); 
							  
		 			    
		$Adduserdetails = $this->users->addTask($insert_details);
		echo json_encode($Adduserdetails);
	}

	public function get_cur_bucket_list(){
        $requestData = json_decode(file_get_contents("php://input"));
		//$fetch_array_list_date = $this->users->fetchTasklist($current_date,$yesterday_date,$tomorrow_date,$requestData->useruid);
		$fetch_array_list_date = $this->users->fetchnewTasklist($requestData->planneddate,$requestData->useruid,$requestData->islist);
		echo json_encode($fetch_array_list_date);
		
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

	//public function getUserTask_post(){
        //$requestData = json_decode(file_get_contents("php://input"));
		//  $yesterday_date = $requestData->isyesterdaylist;
		//  $current_date   = $requestData->istodaylist;
		//  $tomorrow_date  = $requestData->istomorrowlist;
		//  echo $current_date;
		//  echo $yesterday_date;
		//  echo $tomorrow_date;
        // // $current_date = date('Y-m-d');
        // // // $yesterday_date = date('Y-m-d', strtotime(' -1 day'));
        // //   $tomorrow_date = date('Y-m-d', strtotime('+1 day'));
        // $fetch_array_list_date = $this->users->fetchTasklist($current_date,$yesterday_date,$tomorrow_date,$requestData->useruid);
		// echo json_encode($fetch_array_list_date);
     //}

	 public function getUserTask_post() {
        $requestData = json_decode(file_get_contents("php://input"));
         $current_date = date('Y-m-d');
         $yesterday_date = date('Y-m-d', strtotime(' -1 day'));
         $tomorrow_date = date('Y-m-d', strtotime('+1 day'));
         $fetch_array_list_date = $this->users->fetchTasklist($current_date,$yesterday_date,$tomorrow_date,$requestData->useruid);
		 echo json_encode($fetch_array_list_date);
      }
     function deleteUser(){
		$requestData = json_decode(file_get_contents("php://input"));
		$userid   = $requestData->userid;

		$deleteusers = $this->users->Removeusers($userid);
		echo json_encode($deleteusers);
	 }
	
     function usersrole(){
		$requestData = json_decode(file_get_contents("php://input"));
		$userroleupdate = $requestData->updatedetails;

		$updateRoles=$this->users->updateUsersRole($userroleupdate);
		echo json_encode($updateRoles);
	 }

	function updateChecklistStatus_post(){
		$requestData = json_decode(file_get_contents("php://input"));
        //echo '<pre>';print_r($requestData);exit;
		$task_id = $requestData->task_id;
		$user_id = $requestData->userid;
		$task_status = $requestData->status;
		// $result=$this->users->updateChecklistreactupdated($team_id,$user_id,$task_id,$task_status);
		$result=$this->users->updateChecklistreactupdated($user_id,$task_id,$task_status);
		$user= json_encode($result);
		print_r($user);
	}

	// public function updateChecklistStatus_post(){
    //     $requestData = json_decode(file_get_contents("php://input"));
    //     $task_id = $requestData->task_id;
    //     $user_id = $requestData->userid;
	// 	$status = $requestData->status;
	// 	$taskname = $requestData->taskname;
	// 	$originalestimate = $requestData->original;
	// 	$remainingestimate = $requestData->remaining;
    //    	$ticketname = $requestData->tickettypestatus;
	// 	$ticketcolor = $requestData->colorcode;

	// 	$completed_tasks = $this->users->updateChecklist($task_id,$user_id,$status,$taskname,$originalestimate,$remainingestimate,$ticketname,$ticketcolor);
        
	// 		$message_update = array('msg'=>$completed_tasks);
	// 		echo json_encode($message_update);
		
		
    // }


	function addBlocker_post(){
		$requestData = json_decode(file_get_contents("php://input"));

		$team_id=$requestData->team_id;
		$user_id=$requestData->user_id;
		$sent_to=$requestData->received_from;
		$blocker_message=explode(' ',$requestData->blocker_message,2);
		$planned_date=$requestData->planned_date;
		$result=$this->users->addBlockerMessage($team_id,$user_id,$sent_to,$blocker_message[1],$planned_date);
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
        $user_id = $requestData->user_id;
        $sent_from = array();
        $planned_date = $requestData->planned_date;
        $received_from=$this->users->getBlockerList($team_id,$user_id,$planned_date);
        $sent_from=$this->users->getBlockerListSent($team_id,$user_id,$planned_date);
      if(!empty($sent_from)){
          //$msg = ['status'=>true, 'blocker_messages_sent'=>$sent_from];
          $msg = ['status'=>true,'blocker_messages_received'=>$received_from, 'blocker_messages_sent'=>$sent_from];
		  //$msg = ['status'=>true,'blocker_messages_sent'=>$sent_from];
         }else{
           $msg = ['status'=>false,'msg'=>'No data Found'];
         }
        echo  json_encode($msg);
    //  echo $final;
       
    }

	function get_specific_teams_list(){
		$requestData = json_decode(file_get_contents("php://input"));
		$board_id = $requestData->board_id;
		$team_id =  $requestData->team_id;
		$listUsers=$this->users->listUsers($board_id,$team_id);
		echo json_encode($listUsers);
	}


	// function getBlockerMeassage_post(){
	// 	$requestData = json_decode(file_get_contents("php://input"));
	// 	$team_id=$requestData->team_id;
	// 	$user_id=$requestData->user_id;
	// 	$planned_date=$requestData->planned_date;
	//    $result=$this->users->getBlockerList($team_id,$user_id,$planned_date);
	//    if(!empty($result)){
	//  		$msg = ['status'=>true,'blocker_messages'=>$result,"count"=>count($result)];
	//  	}else{
	//  		$msg = ['status'=>false,'msg'=>'No data Found'];
	//  	}
	//     echo  json_encode($msg);
		
	// }
	

	function addUserAttendence_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		$user_id=$requestData->user_id;
		$team_id=$requestData->team_id;
		$is_absent=1;
		$start_date=$requestData->start_date;
		$end_date=$requestData->end_date;
		$added_by=$requestData->added_by;
		$msg=$this->users->addAttendence($user_id,$team_id,$is_absent,$start_date,$end_date,$added_by);
		// if($result==true):
		// 	$msg ="Attendence added successfully";
		// else:
		// 	$msg ="Something went wrong";
		// endif;
		echo json_encode($msg);
	}
	

	function getUserAttendence_post(){
		$requestData = json_decode(file_get_contents("php://input"));
		$user_id= isset($requestData->user_id) ? intval($requestData->user_id):0;
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
       // echo '<pre>';print_r($requestData);exit;
        // $ticketstatus = $requestData->ticketstatus;
		// echo $ticketstatus;
		
		$fetch_data['fieldname']=array(
			'fieldname'=>$requestData->fieldname,
			'value'=>$requestData->value,
			'task_id'=>$requestData->taskid
		);
		// if($ticketstatus === 'ticket'){
        //  $fetch_data['fieldname']=array(
        //     'fieldname'=>$requestData->fieldname,
        //     'value'=>$requestData->value,
        //     'task_id'=>$requestData->taskid,
		// 	'task_category'=>$requestData->task,
		// 	'original_estimate'=>$requestData->oestimate,
		// 	'remaining_estimate'=>$requestData->restimate
        // );
		// }else{
		// 	$fetch_data['fieldname']=array(
		// 		'fieldname'=>$requestData->fieldname,
		// 		'value'=>$requestData->value,
		// 		'task_id'=>$requestData->taskid
		// 	);
		// }
		
		// $getUpdatebucketlistdetails = $this->users->getcolumndetailsUpdated($fetch_data,$ticketstatus);
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
		$board_id = $requestData->board_id;
		$getTeamdetails =$this->users->getTeamdetails($board_id);
		echo json_encode($getTeamdetails);
	}

	public function postNotification(){
		$requestData = json_decode(file_get_contents("php://input"));
		$team_id = array();
		if($requestData->board !=0){
			$board = $requestData->board;
			$startDate = $requestData->startDate;
			$endDate = $requestData->endDate;
			$team_id = $requestData->teamid;
			$message = $requestData->message;
			$added_id = $requestData->added_by;
			$postNotification = $this->users->postNotificationdetails($added_id,$board,$team_id,$message,$startDate,$endDate);
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

	/**Add checlists details */
   public function addchecklistdetails(){
	 $requestData = json_decode(file_get_contents("php://input"));
		$summary = $requestData->summary;
		$event_type = ($requestData->task == 1 ? 1 : 2);
		$teamid = $requestData->teamid;
		$ticketno = $requestData->ticket;
		$userid = $requestData->userid;
		$current_date = $requestData->planned_date;
		$estimatedtime = $requestData->timelog;
     $insert_details = array(
		  'summary' => addslashes($summary),
		  'task_type'=> $event_type,
		  'team_id'=>$teamid,
		  'user_id'=>$userid,
		  'current_date'=>$current_date,
		  'estimated_time'=> $estimatedtime,
		  'ticket_no'=>$ticketno
	 );
	 $Adduserdetails = $this->users->getAddeddetailsSpecific($insert_details);
	 echo json_encode($Adduserdetails);
   } 

//    function Copyticketclone(){
	
// 	$requestData = json_decode(file_get_contents("php://input"));
// 	// $getTicketDetails = getJiraTicket("11122");
// 	 $tt = $requestData->ticket;
// 	$getdetails =  $this->users->getJiraTicket($tt);
	
// 	if($getdetails['statuscode'] === 200){
// 		$taskCategory = $getdetails['task_category'];
// 		$originalestimate = $getdetails['originalEstimate'];
// 		$timeSpent = $getdetails['timespent'];
// 		$remainingEstimate = $getdetails['remainingEstimate'];
// 		$ticketstatus = $getdetails['ticketstatus'];
// 		$colorcode = $getdetails['colorcode'];

// 	 }else{
// 		$taskCategory = '';
// 		$originalestimate = '';
// 		$timeSpent = '';
// 		$remainingEstimate = '';
// 		$ticketstatus ='';
// 		$colorcode ='';
// 	 }
//         $getcloneticketDetails = array(
// 			'startdate'=>(isset($requestData->startdate) ? $requestData->startdate : ''),
// 			'enddate'=> (isset($requestData->enddate) ? $requestData->enddate : ''),
// 			'task_title'=> $requestData->tasktitle,
// 			'ticket_no'=> $requestData->ticket,
// 			'task_type'=>$requestData->task_type,
// 			'user_id'=>$requestData->userid,
// 			'team_id'=>$requestData->teamid,
// 			'taskCategory'=>$taskCategory,
// 			'originalestimate'=>$originalestimate,
// 			'timespent'=>$timeSpent,
// 			'remianing'=>$remainingEstimate,
// 			'ticket_status'=>$ticketstatus,
// 			'colorcode'=>$colorcode
// 	   );
// 	   $getCloneDetails = $this->users->getCloneDetails($getcloneticketDetails);
// 	   echo json_encode($getCloneDetails);
	
// 	//  echo $getTicketDetails;exit;
	
	
	
//    }



   /** React JS */
   /** React Js */  
   function Copyticketclone(){
	$requestData = json_decode(file_get_contents("php://input"));
	
	$getcloneticketDetails = array(
		'startdate'=>(isset($requestData->startdate) ? $requestData->startdate : ''),
		'enddate'=> (isset($requestData->enddate) ? $requestData->enddate : ''),
		'task_title'=> $requestData->details->summary,
		'ticket_no'=> $requestData->details->ticket_no,
		'task_type'=>$requestData->details->event_type,
		'user_id'=>$requestData->userid,
		'team_id'=>$requestData->teamid,
		'timelog'=>0,
		'taskCategory'=>"",
		'originalestimate'=>"",
		'timespent'=>"",
		'remianing'=>"",
		'ticket_status'=>"",
		'colorcode'=>""
   );

   $getCloneDetails = $this->users->getCloneDetails($getcloneticketDetails);
   echo json_encode($getCloneDetails);
   }
    


   /** Activity pOST */
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
function dashboard_summary_post(){
	$requestData = json_decode(file_get_contents("php://input"));
	$requested_date= $requestData->requested_date;
	$result=$this->users->dashboardSummary($requested_date);
	$summary= json_encode($result);
	echo $summary;
}


/** Calendar Details */
function calendardetails(){
   $requestData = json_decode(file_get_contents("php://input"));
 
   $start_date = isset($requestData->start_date) ? $requestData->start_date:'';
   $end_date   = isset($requestData->end_date) ? $requestData->end_date:'';
   $teamid     = is_array($requestData->teamid) ? implode(',',$requestData->teamid) :'';
   $details = array();
   array_push($details,["startdate"=>$start_date,"endate"=>$end_date,"teamid"=>$teamid]);
   $result = $this->users->absentCalendarSummary($details);
   $details = json_encode($result);
   echo $details;

}

function attendance_summary_post(){
	$requestData = json_decode(file_get_contents("php://input"));
	$requested_date= $requestData->requested_date;
	$result=$this->users->attendanceSummary($requested_date);
	
	echo json_encode($result);
}


 /*Absent list*/
 function absent_summary_post(){
	
	$requestData = json_decode(file_get_contents("php://input"));
	$user_id= $requestData->user_id;
	$type = $requestData->type;
	$result=$this->users->absentSummary($user_id,$type);
    echo json_encode($result);
 }

 function getgroupActivitylog(){
	$requestData = json_decode(file_get_contents("php://input"));
	$board_id = $requestData->board_id;
	$getTeamdetails =$this->users->getAllteamdeatilsingroup($board_id);
	echo $getTeamdetails;
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

 function updateactivitylog(){
	$requestData = json_decode(file_get_contents("php://input"));
	$userid = $requestData->userid;
	$username = $requestData->tickettitle;
	$ticketno = $requestData->ticket_no;
	$activity_type = trim($requestData->activity_type);
	$activity_details = trim(addslashes($requestData->details));

	
    $updateActivityLogs = $this->users->updateactivityCardDetails($userid,$ticketno,$activity_type,$activity_details);
	
 }

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


function getnamesearch(){
	$requestData = json_decode(file_get_contents("php://input"));
	$searchterm = $requestData->searchterm;
	$fieldname = $requestData->fieldname;
	$searchskip = (int)$requestData->skip;
	$limit = (int)$requestData->limit;
	// $startdate = date('Y-m-d',strtotime($requestData->startdate));
	// $enddate = date('Y-m-d',strtotime($requestData->enddate));

	$response = $this->users->searchUser($searchterm,$fieldname,$searchskip,$limit);
	//$searchitems = searchresults($response);
	 echo json_encode($response);

}

function activitytitle(){
	$getActivitytitle = $this->users->activitytitle();
	echo json_encode($getActivitytitle);

}

function activitydate(){
	$requestData = json_decode(file_get_contents("php://input"));
	$startrange = '';
	$endRange ='';
	$fieldname = $requestData->fieldname;
	// $startdate = date("Y-m-d",strtotime($requestData->startdate));
	// $enddate =  date("Y-m-d",strtotime($requestData->enddate));
	$startdate = $requestData->startdate;
	$enddate =  $requestData->enddate;
	$endRange = date("Y-m-d",strtotime($enddate));
	$startrange = date("Y-m-d",strtotime($startdate));
	
	$skip = $requestData->skip;
	$limit = $requestData->limit;
	$getActivitysearcdate = $this->users->searchDate($fieldname,$startrange,$endRange,$skip,$limit);
	echo json_encode($getActivitysearcdate);

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
	 if(isset($requestData->searchdate[0])){
		$enddate = $requestData->searchdate[0];
	 }else{
		$enddate =false;
	 }
}
$getFilteredResults = $this->users->getFilteredResultsActivitytypenoactivitytype(trim($user_id),trim($activity_type),trim($startdate),trim($enddate),$skip,$limit);
echo json_encode($getFilteredResults);
}

function barchartstatus(){
    $requestData = json_decode(file_get_contents("php://input"));
    
    $username = isset($requestData->userid) ? $requestData->userid :"";
    $teamid = isset($requestData->teamid) ?  $requestData->teamid:"";
    $startdate = isset($requestData->startdate) ? $requestData->startdate:"";
    $enddate = isset($requestData->enddate) ? $requestData->enddate : $requestData->startdate;
   

    
	if (!is_array($teamid)) {
        $teamid = !empty($teamid) ? [$teamid] : [];
		
    }

    $teamvariable = array();
    foreach($teamid as $x) {
        array_push($teamvariable, $x);
    }

        $getbardetails = $this->users->getBargraphDetails(trim($username),$teamvariable,trim($startdate),trim($enddate));
 
   
    echo json_encode($getbardetails);
   
}
function jiradata(){
	$requestData = json_decode(file_get_contents("php://input"));
	// $ticket_no=isset($_POST['ticket_no'])?$_POST['ticket_no']:'WE-49519';
    $ticket_no = !empty($requestData->ticketno) ? $requestData->ticketno:'';
    $userid = $requestData->userid;
	$jiraUrl="https://jira.xpaas.lenovo.com/rest/api/latest/issue/$ticket_no";
	


	$jql = 'fields=timetracking';
	$requestUrl = "$jiraUrl?$jql";

	$ch = curl_init($requestUrl);
	curl_setopt_array($ch, [
		CURLOPT_RETURNTRANSFER => true,  // Return response as a string
		CURLOPT_HTTPHEADER => [
			'Accept: application/json',
			'Authorization: Bearer '.$apiToken.'',
			 // Specify the expected response format
		],
		CURLOPT_USERPWD => "$userId:$apiToken",
		 // Basic authentication using email and API token
	]);

	$response = curl_exec($ch);
	$responseData = json_decode($response, true);
	 
	
	echo isset($responseData["fields"]["timetracking"]["originalEstimate"]) ? $responseData["fields"]["timetracking"]["originalEstimate"]:'';
}


//new code 
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
        $colorcodejira = array('default'=>'#6787F1','inprogress'=>'#e98224','success'=>'green');
	
		$colorcode = $colorcodejira[$decodedResponse->fields->status->statusCategory->colorName];
		// Access issuetype object and retrieve the name field
		$issueTypeName = $decodedResponse->fields->issuetype->name;
		$colorstatus   = $colorcode;
		$ticketstatus  = $decodedResponse->fields->status->name; 
		
		$originalEstimate =isset($decodedResponse->fields->timetracking->originalEstimate) ? $decodedResponse->fields->timetracking->originalEstimate : 0.0;
		$remainingEstimate = $decodedResponse->fields->timetracking->remainingEstimate;
		$timeSpent=isset($decodedResponse->fields->timetracking->timeSpent) ? $decodedResponse->fields->timetracking->timeSpent : '0h';
		$timespentestimate = ($timeSpent === 'null') ? '0h' : $timeSpent;
		// $msg = ['task_category'=>$issueTypeName,'originalEstimate'=>$originalEstimate,'remainingEstimate'=>$remainingEstimate,'statuscode'=>$statusCode,'timespent'=>$timeSpent];
		$msg = ['task_category'=>$issueTypeName,'originalEstimate'=>$originalEstimate,'remainingEstimate'=>$timeSpent,'statuscode'=>$statusCode,'timespent'=>$timeSpent,'ticketstatus'=>$ticketstatus,'colorcode'=>$colorstatus]; 
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
	$requestData = json_decode(file_get_contents("php://input"));
	// $user_id=$_POST['user_id']?$_POST['user_id']:1;
	$user_id = isset($requestData->user_id) ? intval($requestData->user_id):0;
	// $access_key=$_POST['jira_access_key']?$_POST['jira_access_key']:'0';
	$access_key = isset($requestData->jira_access_key) ? trim($requestData->jira_access_key) : '';
	$addJiraKeys = $this->users->addUserJiraAcessKeys($user_id,$access_key);
	$message = array('msg'=>$addJiraKeys);
	echo json_encode($message);

}


/** SSO login details */
function getCurrentUser(){
	echo get_current_user(); 
 } 
 
 function loginUser_post_sso(){
	 $requestData = json_decode(file_get_contents("php://input"));
	 
	 $user_name=trim($requestData->username);
	 $pass_word=trim($requestData->password);
	 
	 $result=$this->users->loginUser($user_name,$pass_word);
	 
	  echo json_encode($result);
}



//CQL SUPPORT Features

function ticket_label(){
   $requestData = json_decode(file_get_contents("php://input"));
   $start_date = $requestData->startdate;
   $end_date = $requestData->enddate;
   $ticket_no = $requestData->ticketno;
   $user_id = $requestData->member;
   $team_memberid = '';
   $result=$this->users->cql_ticket($user_id,$ticket_no,$team_memberid,$start_date,$end_date);
   echo json_encode($result);
	 
 }
 
 function fetchlabelcql(){
	 $requestData = json_decode(file_get_contents("php://input"));
	 $start_date = $requestData->startdate;
	 $end_date = $requestData->enddate;
	 $ticket_no = $requestData->ticketno;
	 $result=$this->users->cql_label_ticket($ticket_no,$start_date,$end_date);
	 echo json_encode($result);
 }
 function user_reports_post(){
	
    $start_date=$_POST['start_date'];
    $end_date=$_POST['end_date'];
    $label = $_POST['label'];
    $team_member_id = $_POST['team_member_id'];
    $user_id= $_POST['user_id'];
	echo $start_date;
	
    $result=$this->users->userReports($user_id,$label,$team_member_id,$start_date,$end_date);
    $summary= json_encode($result);
    print_r($summary);
}
 

 //Pending Tasks users
//  function pendingtasks(){
// 	$requestData = json_decode(file_get_contents("php://input"));
// 	$user_id = $requestData->currentuserid;

// 	$current_date = date('Y-m-d');
// 	$previous_date = date('Y-m-d', strtotime(' -1 day'));
// 	$date_arr = array();
// 	if(date('w', strtotime($previous_date)) == 6 ){
// 		$previous_date =  date('Y-m-d', strtotime('-2 days'));
// 	}
// 	else if(date('w', strtotime($previous_date)) == 0 ){
// 		$previous_date = date('Y-m-d', strtotime('-3 days'));

//    }else {
// 	    $previous_date;
//    }

  	
// 	$getPendingTaskslits = $this->users->showpendingchecklistItems($previous_date,$user_id);
// 	echo json_encode($getPendingTaskslits);
	
// }



function pendingtasks(){
	$requestData = json_decode(file_get_contents("php://input"));
	$user_id = $requestData->currentuserid;

	$current_date = date('Y-m-d');
	$previous_date = date('Y-m-d', strtotime(' -1 day'));
	$date_arr = array();

if(date('w', strtotime($current_date)) == 6 ){
			$previous_date =  date('Y-m-d', strtotime('-3 days'));
	 	}
	 	else if(date('w', strtotime($current_date)) == 0 ){
	 		$previous_date = date('Y-m-d', strtotime('-2 days'));
	
	    }else if(date('w', strtotime($current_date)) == 1){
            $previous_date = date('Y-m-d', strtotime('-3 days'));
		}else {
	 	    $previous_date;
	    }
	
   
//    echo $previous_date;exit;
  	
	$getPendingTaskslits = $this->users->showpendingchecklistItems($previous_date,$user_id);
	echo json_encode($getPendingTaskslits);
	
}

//Forget password Email abanerjee2
function resetmail(){

	$requestData = json_decode(file_get_contents("php://input"));
	$email = $requestData->email;
	
    $random = bin2hex(random_bytes(10));	
	$findemail = $this->users->findemail($email,$random);
   
	$msg = [];	
    if($findemail['status'] == 1){
    		
	$this->load->library('mail_library');

	$mail = $this->mail_library->load();

	// SMTP configuration
	$mail->isSMTP();
	// $mail->SMTPDebug = 2; 
    $mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'codertechben@gmail.com';
	$mail->Password = 'phlkmidtdwlnqzqy';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;

	$mail->setFrom('codertechben@gmail.com', 'Checklist-support');
	$mail->addReplyTo('codertechben@gmail.com','Checklist-support');

	// Add a recipient
	$mail->addAddress($email);

	
	// Email subject
	$mail->Subject = 'Password Reset Information [checklistsupport@lenovo.com]';

	// Set email format to HTML
	$mail->isHTML(true);

	// Email body content
	
	$mailContent = "<p style='font-weight:700;'>We have Recieved a password reset confirmation Related to your account </p>
		<p>Please Click on this link to verify your account reset confirmation</p><p><a href='http://localhost/checklist/index.php/verifytoken?token=$random&email=$email'>Click to verify</a></p>";
	$mail->Body = $mailContent;

	// Send email
	if(!$mail->send()){
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}else{
		 $msg = ["status"=>1,"msg"=>"Email has been Sent Successfuly"];
	}
	}else{ 
        //$msg = "Email id not Found.Please Recheck your mail";
		$msg = ["status"=>0,"msg"=>"Email id not Found.Please Recheck your mail"]; 
	}
	echo json_encode($msg);
	
}

function verifytoken(){
	
	$verifydata = $this->users->updateUserPassword($_GET["token"],$_GET["email"]);

	$sendPassword =$this->users->passwordreseter($verifydata['status'],$verifydata['email'],$_GET["token"]);

	header("Location: https://outlook.office.com/mail/inbox/");
	exit;
}
#end Forget Password Mail 


# Send weekely report Mail

public function sendmail() {
        // Get POST data
        $data = json_decode(file_get_contents('php://input'), true);
        $email1 = $data['email1'] ?? '';
        $name1 = $data['name1'] ?? '';
        $email2 = $data['email2'] ?? '';
        $name2 = $data['name2'] ?? '';
		$body = $data['mailbody'] ?? '';
     
      $total_logged = 0;

     $html = '';
	$this->load->library('mail_library');
    $mail = $this->mail_library->load();
// if($total_logged > 0) {
if(!empty($body)){

$html = '<h3>Task Report</h3>';
$html .= '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">';
$html .= '<thead><tr>';

if (is_array($body) && !empty($body) && isset($body[0]) && is_array($body[0])) {
    foreach (array_keys($body[0]) as $key) {
        $html .= '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
    }
} 
// else {
//     // Handle empty or invalid $body gracefully
//     $html .= '<th>No Data</th>';
// }


$html .= '</tr></thead><tbody>';

foreach (json_decode(json_encode($body)) as $row=>$value) {
	$total_logged = $total_logged + $body[$row]['logged_hours']; 
    
	 $html .= '<tr>';
     foreach ($value as $dd) {
        
    //   //  print_r($row);  
         $html .= '<td>' . htmlspecialchars($dd) . '</td>';
     }
     $html .= '</tr>';
	
}
  $html .='<tr><td colspan="9">Total Logged Hours</td><td>'.$total_logged.'</td></tr>'; 
// echo $total_logged;
 $html .= '</tbody></table>';
}
 // echo '<pre>';print_r($value_1);
// echo '<pre>';print_r($html);exit;
	// echo $html;
	// exit();

        try {
            // $mail->isSMTP();
            // $mail->Host = 'smtp.gmail.com';
            // $mail->SMTPAuth = true;
            // $mail->Username = 'codertechben@gmail.com';
            // $mail->Password = 'phlkmidtdwlnqzqy'; // Use Gmail App Password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $mail->Port = 587;




			$mail->isSMTP();
            $mail->Host = 'smtpinternal.lenovo.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'cpadmin@lenovo.com';
            $mail->Password = 'Wo_l?p^?S'; // Use Gmail App Password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 25;
			$mail->SMTPSecure    = false;
            $mail->SMTPAutoTLS   = false;
            $mail->SMTPAuth      = true;
           $mail->SMTPDebug = 3;
            $mail->setFrom('cpadmin@lenovo.com', 'cpadmin@lenovo.com');
            // $mail->addAddress($email2, $name2);
			  $mail->addAddress('abanerjee2@lenovo.com','abanerjee');
            // $mail->addAddress($email2, $name2);
            // $mail->addCC($email1);
			// $mail->addCC('abanerjee2@lenovo.com');
            
			$mail->isHTML(true);
            $mail->Subject = 'weekly';
            // $mail->Body = $html;
			$mail->Body    = 'Testing internal SMTP.';

            $mail->send();
            echo "✅ Email sent successfully!";
        } catch (Exception $e) {
            echo "❌ Mailer Error: {$mail->ErrorInfo}";
        }
    }

 /** Get Developer Status */
 function devstatus(){
	$current_date =  date('Y-m-d');
	$get_dev_status = $this->users->developerStatus($current_date);
	
	echo json_encode($get_dev_status);
 }


 function MailSender() {
   $this->load->library('email');	
   $requestData = json_decode(file_get_contents("php://input"));
   $emailuser = isset($requestData->user_email) ? trim(is_string($requestData->user_email)):'';
   $messagebody = isset($requestData->messagebody) ? trim($requestData->messagebody):''; 
 
   /** SMTP configuration */
   
    $emailconfig = array(
        'protocol'  => 'smtp',
        'smtp_host' => '10.64.190.56',  // Replace with your internal SMTP IP/hostname
        'smtp_port' => 25,          // Port 25 is usually used internally without encryption
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'newline'   => "\r\n",
        'smtp_crypto' => '',        // No TLS or SSL for most internal servers
    );

   $this->email->initialize($emailconfig);

   $this->email->from('cpadmin@lenovo.com', 'Checklist Admin');
   $this->email->to($emailuser);
   $this->email->subject('Test Email from Checklist');
   if(!empty($messagebody)){
    $this->email->message('<p>"'.$messagebody.'"</p>');
   }
   
    if ($this->email->send()) {
        echo "Email sent successfully.";
    } else {
        echo $this->email->print_debugger();
    }
   //echo $emailuser;
 }


 

}
