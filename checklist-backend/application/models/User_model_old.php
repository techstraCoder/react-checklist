<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class User_model extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -getBargraphDetails
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
   
	public function index()
	{
	  // $this->load->database();
	//$this->load->view('index');
      // echo "Hello world!";
	}


	//******Profile view*******//
	function getUsersData($user_id){
		if(!empty($user_id)){
		 $sql="SELECT *  FROM users where is_active=1 and id='".$user_id."'";	
		}else{
		 $sql="SELECT *  FROM users where is_active=1";
		}
		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	public function addTask($insertdetails){
	$status = 0;
    
	if($insertdetails['summary'] != ''){
		$position_query = "SELECT MAX(order_position) AS position FROM checklist where user_id='".$insertdetails["user_id"]."' and planned_date='".$insertdetails["planned_date"]."'";
		$res = $this->db->query($position_query);
		foreach($res->result('array') as $getspecificdetails){
             $position= $getspecificdetails['position'];
		}
		//echo $position;
		if($position == ''){
			$position=1;
		}else{
			$position = $position + 1;
		}
		$activity_type="4";
		$activity_details="Ticket has been added ".$insertdetails["ticket_no"]."";
		if($insertdetails["user_id"] !=" "){
			$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details,ticket_status,colorcode)VALUES('".$insertdetails["user_id"]."','".$insertdetails["user_id"]."','".$activity_type."','".$activity_details."','".$insertdetails["ticket_status"]."','".$insertdetails["colorcode"]."')";
			$insertlog = $this->db->query($insertactivitylog);
			 if($insertlog == 1){
			 	echo "activiyt log updated";
			 }	
		}
		$db_query = "INSERT INTO checklist(user_id,team_id,task_title,ticket_no,task_type,planned_date,estimated_time,order_position,is_private,task_category,original_estimate,remaining_estimate,ticket_status,colorcode)VALUES('".$insertdetails["user_id"]."','".$insertdetails["team_id"]."','". addslashes($insertdetails["summary"])."','".$insertdetails["ticket_no"]."','".$insertdetails["event_type"]."','".$insertdetails["planned_date"]."','".$insertdetails["timelog"]."','".$position."','".$insertdetails["isprivate"]."','".$insertdetails["task_category"]."','".$insertdetails["original_estimate"]."','".$insertdetails["remaining_estimate"]."','".$insertdetails["ticket_status"]."','".$insertdetails["colorcode"]."')";
		$insert_res = $this->db->query($db_query);
		if($insert_res == 1){
			echo 'Inserted Updated';
		}else{
			echo 'Not Updated';
		}
	}
}


	function getTeamsList(){
		$sql="SELECT id,team_name FROM teams where is_active=1";
		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	// function addUsers($first_name,$last_name,$user_name,$email,$team_id,$pass_word){
	// 	$insert_sql = "insert users set first_name='".$first_name."',last_name='".$last_name."',user_name='".$user_name."',email ='".$email."',team_id=".$team_id.",
	// 	pass_word=MD5('".$pass_word."')";
	//     $result= $this->db->query($insert_sql);
	// 	return $result;
	// }

 /** Original Function for logging **/
//  function loginUser($user_name,$pass_word){

// 		$user = "SELECT user.id as user_id, user.team_id,user.board_id,team.team_name,user.access_role,CONCAT(user.first_name,' ',user.last_name) as full_name, user.user_name, user.first_name,user.email, team.team_name from users as user
// 		INNER JOIN teams as team ON user.team_id = team.id where user_name='".$user_name."' AND pass_word='".$pass_word."'
// 		";
// 		 /** getting today tomorrow and yesterday date */
// 		 $current_date = date('Y-m-d');
// 		 $yesterday_date = date('Y-m-d', strtotime(' -1 day'));
// 		 $tomorrow_date = date('Y-m-d', strtotime('+1 day'));
// 		 /** end of date list */
// 		$loggedinname = array();
// 		$team_id ='';
// 		$region_id='';
// 		$team_name='';
// 		$username='';
// 		$email='';
// 		$fullname='';
// 		$user_id='';
// 		$access_role='';
// 		$region_name='';
// 		$loginname='';
// 		$loginname_firstname='';
// 		$res = $this->db->query($user);
//         foreach($res->result('array') as $loggeddetails){
//             $region_id = $loggeddetails['board_id'];
// 			$user_id = $loggeddetails['user_id'];
// 			$team_id = $loggeddetails['team_id'];
// 			$team_name = $loggeddetails['team_name'];
// 			$fullname = $loggeddetails['full_name'];
// 			$loginname = $loggeddetails['user_name'];
// 			$loginname_firstname = $loggeddetails['first_name'];
// 			$email = $loggeddetails['email'];
// 			$access_role = $loggeddetails['access_role'];
// 		}
// 		$activity_type="12";
// 		$activity_details ="User has logged in now";
// 		if(!empty($user_id)){
// 			$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details)VALUES('".$user_id."','".$user_id."','".$activity_type."','".$activity_details."')";
// 			$res = $this->db->query($insertactivitylog);	
// 		}
// 		$get_region_name = "SELECT * FROM boards where id='".$region_id."' and is_active='1'";
// 		$res = $this->db->query($get_region_name);
// 		foreach($res->result('array') as $regiondetails){
// 			$region_name = $regiondetails['board_name'];
// 		}
// 		/** Pending & completed Tasks */
// 		$tottsk = array();
// 		$gettasklist = "SELECT user_id,status,planned_date FROM checklist WHERE planned_date >='".$yesterday_date."' AND planned_date <='".$tomorrow_date."' and status=0";
// 		$pendingtasks =array();
// 		$completedtask=array();
// 		$gettaskres = $this->db->query($gettasklist);
 
// 		foreach($gettaskres->result('array') as $gettotaltasklist){
// 		   $tottsk[$gettotaltasklist['user_id']][] = $gettotaltasklist['status'];
// 		}
		
// 		$getalltaskcount_comp = array();
// 		$final_completed_array = array();
// 		$gettasklist1 = "SELECT * FROM checklist WHERE planned_date >='".$yesterday_date."' AND planned_date <='".$tomorrow_date."' AND status= 1";
// 		$gettaskres1 = $this->db->query($gettasklist1);
// 		foreach($gettaskres1->result('array') as $gettotaltasklist1){
// 			   $getalltaskcount_comp[$gettotaltasklist1['user_id']][]= $gettotaltasklist1['status'];
// 		}  
// 		/** End pending & completed Tasks */
// 		// get other users in the same group and team_id
// 		$getotherUsersinSamegroup = "SELECT * FROM users WHERE team_id='".$team_id."' AND is_active ='1' ORDER BY first_name ASC";
// 		$res = $this->db->query($getotherUsersinSamegroup);
// 		$otheruserdetails = array();
// 		if($res->num_rows() > 0){
// 		foreach($res->result('array') as $otherloggedindetails){
//             $otheruserdetails['users'][] = array('username'=>$otherloggedindetails['user_name'],
// 			                                     'first_name'=>$otherloggedindetails['first_name'],
// 			                                     'user_id'=>$otherloggedindetails['id'],
// 												 'team'=>$team_name,
// 												 'group'=>$region_name,
// 												 'team_id'=>$otherloggedindetails['team_id'],
// 												 'completed'=>(isset($getalltaskcount_comp[$otherloggedindetails['id']]) ? count($getalltaskcount_comp[$otherloggedindetails['id']]) : ''),
//                                                  'pending'=>(isset($tottsk[$otherloggedindetails['id']]) ? count($tottsk[$otherloggedindetails['id']]) : '')
// 												);	
// 		 }
// 	   }
      
// 	   $getdashboarduser_details = array();
// 	   $getdashboarduser_details = array_merge(array('loggediname'=>$loginname,'firstname'=>$loginname_firstname,'team'=>$team_name,'group'=>$region_name,'user_id'=>$user_id,'team_id'=>$team_id,'access_role'=>$access_role,'board_id'=>$region_id),$otheruserdetails);
// 	   return $getdashboarduser_details;
// 	}


// SSO & Login Features
function loginUser($user_name,$pass_word){

	
		    $query= '';
		   if($pass_word != '' && $user_name !=''){
			    $query ="SELECT user.id as user_id, user.team_id,user.board_id,team.team_name,user.access_role,CONCAT(user.first_name,' ',user.last_name) as full_name, user.user_name, user.first_name,user.email, team.team_name from users as user
			INNER JOIN teams as team ON user.team_id = team.id where user_name='".$user_name."' AND pass_word='".$pass_word."'
			"; 	
			}else {
				$query = "SELECT user.id as user_id, user.team_id,user.board_id,team.team_name,user.access_role,CONCAT(user.first_name,' ',user.last_name) as full_name, user.user_name, user.first_name,user.email, team.team_name from users as user
			INNER JOIN teams as team ON user.team_id = team.id where user_name='".$user_name."'";
			}
        
			// $user = "SELECT user.id as user_id, user.team_id,user.board_id,team.team_name,user.access_role,CONCAT(user.first_name,' ',user.last_name) as full_name, user.user_name, user.first_name,user.email, team.team_name from users as user
			// INNER JOIN teams as team ON user.team_id = team.id where user_name='".$user_name."' AND pass_word='".$pass_word."'
			// ";
		    
			$user = $query;
			
		
		 /** getting today tomorrow and yesterday date */
		 $current_date = date('Y-m-d');
		 $yesterday_date = date('Y-m-d', strtotime(' -1 day'));
		 $tomorrow_date = date('Y-m-d', strtotime('+1 day'));
		 /** end of date list */
		$loggedinname = array();
		$team_id ='';
		$region_id='';
		$team_name='';
		$username='';
		$email='';
		$fullname='';
		$user_id='';
		$access_role='';
		$region_name='';
		$loginname='';
		$loginname_firstname='';
		
		$res = $this->db->query($user);
	    
// echo $this->db->last_query();
// print_r($this->db->error());
// 		exit;

        foreach($res->result('array') as $loggeddetails){
            $region_id = $loggeddetails['board_id'];
			$user_id = $loggeddetails['user_id'];
			$team_id = $loggeddetails['team_id'];
			$team_name = $loggeddetails['team_name'];
			$fullname = $loggeddetails['full_name'];
			$loginname = $loggeddetails['user_name'];
			$loginname_firstname = $loggeddetails['first_name'];
			$email = $loggeddetails['email'];
			$access_role = $loggeddetails['access_role'];
		}
		$activity_type="12";
		$activity_details ="User has logged in now";
		if(!empty($user_id)){
			$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details)VALUES('".$user_id."','".$user_id."','".$activity_type."','".$activity_details."')";
			$res = $this->db->query($insertactivitylog);	
		}
		$get_region_name = "SELECT * FROM boards where id='".$region_id."' and is_active='1'";
		$res = $this->db->query($get_region_name);
		foreach($res->result('array') as $regiondetails){
			$region_name = $regiondetails['board_name'];
		}
		/** Pending & completed Tasks */
		$tottsk = array();
		$gettasklist = "SELECT user_id,status,planned_date FROM checklist WHERE planned_date >='".$yesterday_date."' AND planned_date <='".$tomorrow_date."' and status=0";
		$pendingtasks =array();
		$completedtask=array();
		$gettaskres = $this->db->query($gettasklist);
 
		foreach($gettaskres->result('array') as $gettotaltasklist){
		   $tottsk[$gettotaltasklist['user_id']][] = $gettotaltasklist['status'];
		}
		
		$getalltaskcount_comp = array();
		$final_completed_array = array();
		$gettasklist1 = "SELECT * FROM checklist WHERE planned_date >='".$yesterday_date."' AND planned_date <='".$tomorrow_date."' AND status= 1";
		$gettaskres1 = $this->db->query($gettasklist1);
		foreach($gettaskres1->result('array') as $gettotaltasklist1){
			   $getalltaskcount_comp[$gettotaltasklist1['user_id']][]= $gettotaltasklist1['status'];
		}  
		/** End pending & completed Tasks */
		// get other users in the same group and team_id
		$getotherUsersinSamegroup = "SELECT * FROM users WHERE team_id='".$team_id."' AND is_active ='1' ORDER BY first_name ASC";
		$res = $this->db->query($getotherUsersinSamegroup);
		$otheruserdetails = array();
		if($res->num_rows() > 0){
		foreach($res->result('array') as $otherloggedindetails){
            $otheruserdetails['users'][] = array('username'=>$otherloggedindetails['user_name'],
			                                     'first_name'=>$otherloggedindetails['first_name'],
			                                     'user_id'=>$otherloggedindetails['id'],
												 'team'=>$team_name,
												 'group'=>$region_name,
												 'team_id'=>$otherloggedindetails['team_id'],
												 'completed'=>(isset($getalltaskcount_comp[$otherloggedindetails['id']]) ? count($getalltaskcount_comp[$otherloggedindetails['id']]) : ''),
                                                 'pending'=>(isset($tottsk[$otherloggedindetails['id']]) ? count($tottsk[$otherloggedindetails['id']]) : '')
												);	
		 }
	   }
      
	   $getdashboarduser_details = array();
	   $getdashboarduser_details = array_merge(array('loggediname'=>$loginname,'firstname'=>$loginname_firstname,'team'=>$team_name,'group'=>$region_name,'user_id'=>$user_id,'team_id'=>$team_id,'access_role'=>$access_role,'board_id'=>$region_id),$otheruserdetails);
	   return $getdashboarduser_details;
	}


	// function notifyTeam($user_id,$team_id,$message){
		
	// 	$insert_sql = "insert notify set user_id=".$user_id.",team_id=".$team_id.",message='".$message."'";
	//     $result= $this->db->query($insert_sql);
	// 	return $result;
	// }

	function getNotifications($team_id){

		$sql="SELECT n.message notification_message, CONCAT(u.first_name,' ',u.last_name) as from_name FROM notify n
		INNER JOIN users u ON u.id=n.added_by
		where n.is_active=1 AND  n.team_id=$team_id";
		//print_r($sql);die;
		$result = $this->db->query($sql)->result_array();
		return $result;
	}
	
	

	function updatePassword($oldpassword,$newpassword,$userid){
		$passdetails = array();
		$checkPw = "select pass_word from users where id='".$userid."' AND pass_word=MD5('".$oldpassword."')";
		$result= $this->db->query($checkPw)->result_array();
		/** Get Username */
        $passwordChange = "SELECT user_name from users where id='".$userid."'";
		$result = $this->db->query($passwordChange);
		 if(!empty($result)){
				foreach($result->result('array') as $userdetails){
					$passdetails = $userdetails["user_name"];
				}
			}
		/**End Get Username */
		$activity_type = "11";
		$activity_details = "Password has been Updated for ".$passdetails;
		if(!(empty($result))){
			$updatepw="update users set pass_word=MD5('".$newpassword."') WHERE id='".$userid."'";
			$pwresult= $this->db->query($updatepw);
			if($pwresult==true){
				if(!empty($userid)){
					$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details)VALUES('".$userid."','".$userid."','".$activity_type."','".$activity_details."')";
					$res = $this->db->query($insertactivitylog);	
				}
				$msg = ['status'=>true,"msg"=>"password updated successfully"];
			}else{
				$msg = ['status'=>false,'msg'=>'failed to update the password'];
			}
		}else{
			$msg = ['status'=>false,'msg'=>'password is already exist'];
		}
		return $msg;
		
	}




	function notifyTeam($added_by,$board_id,$team_id,$message,$start_date,$end_date,$is_important){
		$insert_sql = "insert notify set added_by=$added_by, board_id=$board_id,team_id=$team_id,message='".$message."',start_date='".$start_date."',end_date='".$end_date."',is_important=$is_important";
	    $result= $this->db->query($insert_sql);
		return $result;
	}


	// function addTask($user_id,$team_id,$task_title,$ticket_no,$planned_date,$estimated_time){
	// 	$insert_sql = "insert checklist set user_id=$user_id, team_id=$team_id,task_title='".$task_title."',ticket_no='".$ticket_no."',planned_date='".$planned_date."',estimated_time='".$estimated_time."'";
	// 	//print_r($insert_sql);die;
	//     $result= $this->db->query($insert_sql);
	// 	return $result;

	// }

	/*function addTask($insertdetails){
		$summary = addslashes($insertdetails['summary']);
		$team_id = $insertdetails['team_id'];
		$ticket_no =$insertdetails['ticket_no'];
		$status = $insertdetails['status'];
		$planned_date = $insertdetails['planned_date'];
		$timelog = $insertdetails['timelog'];
		$userid = $insertdetails['user_id'];
		$event_type = $insertdetails['event_type'];
		$msg='';
		if($summary !=''){
			$db_query = "INSERT INTO checklist(user_id,team_id,task_title,ticket_no,task_type,status,planned_date,estimated_time)VALUES('".$userid."','".$team_id."','".$summary."','".$ticket_no."','".$event_type."','".$status."','".$planned_date."','".$timelog."')";
		    $insert_res = $this->db->query($db_query);
			if($insert_res == 1){
				$msg ='1';
			}else{
				$msg ='0';
			}
			return $msg;
		}
	}*/
	/** GET TASKS LIST  */
	public function fetchTasklist($current_date,$yesterday_date,$tomorrow_date,$user_id){
		$alltasklistcontent= array();
		$yesterdaylist = array();
		$yesterdaylistcontent = array();
		$todaylistcontent = array();
		$tomorrowlistcontent = array();
		$todaylist = array();
		$tomorrowlist = array(); 
		$completedyesterdaytask=array();
		$completedtodaytask=array();
		$completedtomorrowtask=array();
		$completed_yetserday = array();
		$yesterday_task_list = array();
		$get_yesterday_list = "SELECT * FROM checklist where planned_date='".$yesterday_date."' and user_id='".$user_id."'";
		$db_yesterday = $this->db->query($get_yesterday_list);
		foreach($db_yesterday->result('array') as $yesterdaylist){
		   
			$yesterdaylistcontent[]= array(
			  'task_id'=>$yesterdaylist['id'],
			  'summary'=> $yesterdaylist['task_title'],
			  'event_type'=> $yesterdaylist['task_type'],
			  'ticket_no' => $yesterdaylist['ticket_no'],
			  'planned_date'=> $yesterdaylist['planned_date'],
			  'timelog'=> $yesterdaylist['estimated_time'],
			  'status'=>$yesterdaylist['status']
			);
		}
		$yesterday_pending_tasks = array();
		$yesterday_completed_tasks = array();
		$yesterday_total_task_duration = array();
		foreach($yesterdaylistcontent as $rows){
			if($rows['status'] === '0'){
			   array_push($yesterday_pending_tasks,$rows['status']);
			}
			if($rows['status'] === '1'){
			  array_push($yesterday_completed_tasks,$rows['status']);
			}
			array_push($yesterday_total_task_duration,$rows['timelog']);
		}
  
		/** current list */
		$today_pending_tasks = array();
		$today_completed_tasks = array();
		$today_total_task_duration = array();
		$get_current_list = "SELECT * FROM checklist where planned_date='".$current_date."' and user_id='".$user_id."'";
		$db_current = $this->db->query($get_current_list);
		foreach($db_current->result('array') as $todaylist){
		  $todaylistcontent[]= array(
			'task_id'=>$todaylist['id'],
			'summary'=> $todaylist['task_title'],
			'event_type'=> $todaylist['task_type'],
			'ticket_no' => $todaylist['ticket_no'],
			'planned_date'=>$todaylist['planned_date'],
			'timelog'=> $todaylist['estimated_time'],
			'status'=>$todaylist['status']
		   );
		}
		foreach($todaylistcontent as $rows){
		  if($rows['status'] === '0'){
			 array_push($today_pending_tasks,$rows['status']);
		  }
		  if($rows['status'] === '1'){
			array_push($today_completed_tasks,$rows['status']);
		  }
		  array_push($today_total_task_duration,$rows['timelog']);
	  }
  
	  /**get tomorrow list */
	  $tomorrow_pending_tasks = array();
	  $tomorrow_completed_tasks = array();
	  $tomorrow_total_task_duration = array();
	  $get_tomorrow_list = "SELECT * FROM checklist where planned_date='".$tomorrow_date."' and user_id='".$user_id."'";
		$db_current = $this->db->query($get_tomorrow_list);
		foreach($db_current->result('array') as $tomorrowlist){
		  $tomorrowlistcontent[]= array(
			'task_id'=>$tomorrowlist['id'],
			'summary'=> $tomorrowlist['task_title'],
			'event_type'=> $tomorrowlist['task_type'],
			'ticket_no' => $tomorrowlist['ticket_no'],
			'planned_date'=>$tomorrowlist['planned_date'],
			'timelog'=> $tomorrowlist['estimated_time'],
			'status'=>$tomorrowlist['status']
		   );
		}
		foreach($tomorrowlistcontent as $rows){
		  if($rows['status'] === '0'){
			 array_push($tomorrow_pending_tasks,$rows['status']);
		  }
		  if($rows['status'] === '1'){
			array_push($tomorrow_completed_tasks,$rows['status']);
		  }
		  array_push($tomorrow_total_task_duration,$rows['timelog']);
	  }
		
		$alltasklistcontent['isyesterdaylist']= array($yesterdaylistcontent,'taskduration'=>array_sum($yesterday_total_task_duration),'pendingtasks'=>(count($yesterday_pending_tasks)+count($yesterday_completed_tasks)),'islist'=>'isyesterdaylist','completedtasks'=>count($yesterday_completed_tasks)); 
		$alltasklistcontent['istodaylist']= array($todaylistcontent,'taskduration'=>array_sum($today_total_task_duration),'pendingtasks'=>(count($today_pending_tasks)+count($today_completed_tasks)),'islist'=>'istodaylist','completedtasks'=>count($today_completed_tasks)); 
		$alltasklistcontent['istomorrowlist']= array($tomorrowlistcontent,'taskduration'=>array_sum($tomorrow_total_task_duration),'pendingtasks'=>(count($tomorrow_pending_tasks)+count($tomorrow_completed_tasks)),'islist'=>'istomorrowlist','completedtasks'=>count($tomorrow_completed_tasks)); 
		return $alltasklistcontent;
  
  
	  }

	/** TASK LIST IS ENDED */



	function getTodaysTasks($team_id,$user_id){
		$sql="SELECT * from checklist
		where team_id=$team_id AND  user_id=$user_id AND planned_date=CURRENT_DATE()";
		//print_r($sql);die;
		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	function getYesterdaysTasks($team_id,$user_id){
		$sql="SELECT * from checklist
		where team_id=$team_id AND  user_id=$user_id AND planned_date=CURRENT_DATE() - INTERVAL 1 DAY";
		//print_r($sql);die;
		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	function getFutureTasks($team_id,$user_id){
		$sql="SELECT * from checklist
		where team_id=$team_id AND  user_id=$user_id AND planned_date=CURRENT_DATE()+INTERVAL 1 DAY";
		//print_r($sql);die;
		$result = $this->db->query($sql)->result_array();
		return $result;
	}


	// function updateChecklist($team_id,$user_id,$task_id,$task_status){
	// 	//print_r($team_id);
	// 	$updateChecklist="update checklist set status=".$task_status." WHERE id=$task_id AND user_id=$user_id AND team_id=$team_id";
	// 	//print_r($updateChecklist);die;
	// 		$checklistResult= $this->db->query($updateChecklist);
	// 		if($checklistResult==true){
	// 			$msg = ['status'=>true,"msg"=>"status updated successfully"];
	// 		}else{
	// 			$msg = ['status'=>false,'msg'=>'failed to update the status'];
	// 		}
	// 		return $msg;
	// }


	function updateChecklist($task_id,$user_id,$status,$taskname,$originalestimate,$remainingestimate,$ticketname,$ticketcolor){
		$msg ='';
		// $update_task_list = "UPDATE checklist SET status='".$status."' WHERE  id='".$task_id."' and user_id ='".$user_id."'";
		if($status == 0){
			$update_task_list = "UPDATE checklist SET status='".$status."' WHERE  id='".$task_id."' and user_id ='".$user_id."'";
		}else{
			$update_task_list = "UPDATE checklist SET status='".$status."',task_category='".$taskname."',original_estimate='".$originalestimate."',remaining_estimate='".$remainingestimate."',ticket_status='".$ticketname."',colorcode='".$ticketcolor."' WHERE  id='".$task_id."' and user_id ='".$user_id."'";
		}
		$db_task_list = $this->db->query($update_task_list);
		if($db_task_list == 1){
		   $msg.= "task has been completed";
		}else{
		   $msg.= "problem in validating";
		}
		return $msg;
	}



	// function addBlockerMessage($team_id,$user_id,$sent_to,$blocker_message,$planned_date){
	// 	$insert_sql = "insert blocker_message set team_id=$team_id,added_by=$user_id, sent_to=$sent_to,message='".$blocker_message."',planned_date='".$planned_date."'";
	// 	//print_r($insert_sql);die;
	//     $result= $this->db->query($insert_sql);
	// 	return $result;
	// }
	function addBlockerMessage($team_id,$added_by,$sent_to,$message,$planned_date){
		$insert_sql = "insert blocker_message set team_id=$team_id,added_by=$added_by, sent_to=$sent_to,message='".$message."',planned_date='".$planned_date."'";
	    $result= $this->db->query($insert_sql);
		return $result;
	}
	/** get All Team list */
	public function getAllTeamlist($bid){
		$sql = "SELECT * FROM teams where board_id='".$bid."' and is_active=1";
        $result = $this->db->query($sql);
	    $batchlist = array();   
	   foreach($result->result('array') as $batchname){
		   $batchlist[] =array(
			          'id'=>$batchname['id'],
					  'temname'=>$batchname['team_name']
		   );
	   }
	   return $batchlist;
	 
	}

/** fetch specifii team details */
 public function getteamdevsBatch($team_id){
	$db_query = "SELECT * FROM users where team_id='".$team_id."' and is_active=1";
	$result = $this->db->query($db_query);
	$users_list = array();
	 foreach($result->result('array') as $userslist){
		$users_list[] =array(
			          'user_id'=>$userslist['id'],
					  'first_name'=>$userslist['first_name'],
					  'team_id'=>$userslist['team_id']
		   );
	   }
	  return $users_list;
 }

	function getBlockerList($team_id, $added_by, $planned_date) {
			$sql = "SELECT b.message,b.added_by,b.sent_to, b.planned_date, CONCAT(u.first_name,' ',u.last_name) as received_from 
					FROM blocker_message b
					INNER JOIN users u ON u.id = b.added_by 
					WHERE b.team_id = '".$team_id."' AND u.id=b.added_by  AND b.planned_date = '".$planned_date."'";
			$result = $this->db->query($sql)->result_array();
			return $result;
		}
		
		function getBlockerListSent($team_id,$added_by,$planned_date) {
			$sql = "SELECT b.message ,b.added_by,b.sent_to, b.planned_date, CONCAT(u.first_name,' ',u.last_name) as sent_from FROM blocker_message b
					INNER JOIN users u ON u.id = b.added_by
					WHERE b.team_id ='".$team_id."' AND u.id=b.added_by  AND b.planned_date = '".$planned_date."'";
			$result = $this->db->query($sql)->result_array();
			return $result;
		}


	function addAttendence($user_id,$team_id,$is_absent,$start_date,$end_date,$added_by){
		$passdetails = array();
		$insert_sql = "insert user_attendence set user_id=$user_id,team_id=$team_id, is_absent=$is_absent,start_date='".$start_date."',end_date='".$end_date."',added_by=$added_by";
	    $result= $this->db->query($insert_sql);
		/** Get Username */
        $passwordChange = "SELECT user_name from users where id='".$user_id."'";
		$result = $this->db->query($passwordChange);
		 if(!empty($result)){
				foreach($result->result('array') as $userdetails){
					$passdetails = $userdetails["user_name"];
				}
		 }
		/**End Get Username */
		$activity_type = "10";
		$activity_details = "Attendance has been added for ".$passdetails;
		if(!empty($user_id)){
			$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details)VALUES('".$added_by."','".$added_by."','".$activity_type."','".$activity_details."')";
			$res = $this->db->query($insertactivitylog);
		}
		return $result;
	}
	/** AttendanceSummary **/
    public function attendanceSummary($requested_date){
	$details = array();
	$labels_data_second = array();
	$chartdata = array();
	$label = array('Present','Absent');
	$availability_in_percentage="SELECT COUNT(ua.id) AS total_absent,(SELECT COUNT(id) from users where is_active=1 AND team_id IN(6,8,9)) total_users,(SELECT COUNT(id) from users where is_active=1 AND team_id IN(6,8,9))- (SELECT COUNT(ua.id)) as present_users,(SELECT ROUND(COUNT(ua.user_id)/COUNT(id)*100,2) from users where is_active=1) absent, (SELECT ROUND(100-COUNT(ua.user_id)/COUNT(id)*100,2) from users where is_active=1) present FROM user_attendence ua WHERE '".$requested_date."' BETWEEN ua.start_date and ua.end_date and ua.is_absent=1 AND ua.team_id IN(6,8,9)";
	$result3= $result = $this->db->query($availability_in_percentage);
		foreach($result3->result('array') as $userslist){
			$details =array(
				    is_null($userslist['present']) ? 100.00:$userslist['present'],
					$userslist['absent']
					
			   );
		    $labels_data_second = array(
				$userslist['present_users'],
				$userslist['total_absent']
			); 
		   }
		 for($i=0;$i<count($details);$i++){
			if($details[$i] != 0.00){
				   	 $chartdata []= array(
					'label'=>$label[$i],
					'labels'=> $labels_data_second[$i],
					'percentage'=>$details[$i],

			   );
			}
			  
			 
		 }

		 if(!empty($result3)):
			$msg =$chartdata;
		 else:
			$msg =['status'=>false,'msg'=>'Something went wrong'];
		 endif;
		return $msg;
	
}
 
	function getAttendence($user_id){
		$sql="SELECT * from user_attendence
		where user_id=$user_id AND end_date>=CURRENT_DATE()";
		//print_r($sql);die;
		$result = $this->db->query($sql)->result_array();
		return $result;
	}


	/** New functions added for Checklist Bucket */
	public function update_task_list($list,$date){
		$task_id = $list['task_id'];
		$summary = $list['summary'];
		$status  = $list['status'];
		$event_type = $list['event_type'];
		$ticket_no = $list['ticket_no'];
		$timelog = $list['timelog'];
		$userid = $list['userid'];
		$msg=''; 
		$date_modified = $date;
  
		$update_query = "UPDATE checklist SET planned_date='".$date_modified."' where id='".$task_id."' and user_id='".$userid."'";
		$db_current = $this->db->query($update_query);
		if($db_current == 1){
		  $msg .='Updated task';
		}else{
		  $msg .='Updated task no';
		}
		return $msg;
	 }

	 public function Updateedituserdetailspopup($uid,$task_id){
		$dbquery = "Select * from checklist where id ='".$task_id."' and user_id='".$uid."'";
		$res = $this->db->query($dbquery);
		$specificuserdetails = array();
		$specificuserdetailscontent = array();
		foreach($res->result('array') as $specificuserdetails){
		 $specificuserdetailscontent = array(
			 'task_id'=>$specificuserdetails['id'],
			 'summary'=> $specificuserdetails['task_title'],
			 'event_type'=> $specificuserdetails['task_type'],
			 'ticket_no' => $specificuserdetails['ticket_no'],
			 'planned_date'=>$specificuserdetails['planned_date'],
			 'timelog'=> $specificuserdetails['estimated_time'],
			 'status'=>$specificuserdetails['status'],
			 'userid'=>$specificuserdetails['user_id']
		   );
	   }
	   return $specificuserdetailscontent;
	 }

     public function getcolumndetailsUpdated($fielddetais){
		$msg='';
		$db_query = "UPDATE checklist SET ".$fielddetais['fieldname']['fieldname']."='".$fielddetais['fieldname']['value']."' WHERE id='".$fielddetais['fieldname']['task_id']."'";
		if($this->db->query($db_query) == 1){
		 $msg .="Upadation details";
		}else{
		 $msg .="updation details problem";
		}
	 	return $msg; 
   }
   public function getdeletedStatus2($delete_id,$userid){
	$delete_task_list = "DELETE  FROM checklist where id='".$delete_id."' and user_id='".$userid."'";
	$db_task_list = $this->db->query($delete_task_list);
	$activity_type ="6";
	$activity_details = "Item has been deleted from Checklist";
	if($db_task_list == 1){
		if(!empty($userid)){
			$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details)VALUES('".$userid."','".$userid."','".$activity_type."','".$activity_details."')";
			$insertlog = $this->db->query($insertactivitylog);
			if($insertlog == 1){
			   echo 'aCTIVITY log';
			}
		}
	   $msg.= "task has been completed";
	}else{
	   $msg.= "problem in validating";
	}
  }

  /** get board details according to admin added */
  public function getRegiondetails(){
	 $admin_id = 1;
	 $db_query = "SELECT * FROM boards where added_by='".$admin_id."' and is_active=1";
	 $res = $this->db->query($db_query);
	 $boarddetails = array();
	 $boarddetailsContent = array();
	 foreach($res->result('array') as $boarddetails){
         $boarddetailsContent[] = array('id'=>$boarddetails['id'],'region_name'=>$boarddetails['board_name']); 
	 }
	 return $boarddetailsContent;
  }

  public function getTeamdetails($admin_id){
	 $admin_id = '1';
	 $db_query = "SELECT * FROM teams where added_by='".$admin_id."' and is_active=1";
	 $res = $this->db->query($db_query);
	 $teamdetails = array();
	 $teamdetailsContent = array();
	 foreach($res->result('array') as $teamdetails){
		$teamdetailsContent[] = array('id'=>$teamdetails['id'],'team_name'=>$teamdetails['team_name']);
	 }
	 return $teamdetailsContent;
  }

  public function postNotificationdetails($added_id,$board,$teamid,$message,$startDate,$endDate){
	$db_query = "INSERT INTO notify(added_by,board_id,team_id,message,start_date,end_date,is_important,is_active)VALUES('1','".$board."','".$teamid."','".$message."','".$startDate."','".$endDate."','1','1')";
	$res = $this->db->query($db_query);
	$msg='';
		if($res == 1){
			$msg= "Notification has been Updated";
		 }else{
			$msg= "problem in Updation";
		 }
	 return $msg;

  }

  public function getNotificationsposts($curr_date,$team_id){
	 $db_query = "SELECT * from notify where start_date<='".$curr_date."' AND end_date>='".$curr_date."' and board_id='".$team_id."'";
	
	 $res = $this->db->query($db_query);
	 $notifydetails = array();
	 $notifyContent = array();
	 foreach($res->result('array') as $notifydetails){
		$notifyContent[] = array('id'=>$notifydetails['id'],
		                         'added_by'=>$notifydetails['added_by'], 
		                         'board_id'=>$notifydetails['board_id'],
								 'team_id'=>$notifydetails['team_id'],
								 'message'=>$notifydetails['message'],
								 'start_date'=>$notifydetails['start_date'],
								 'end_date'=>$notifydetails['end_date']
								); 
	 }
	//   echo '<pre>';print_r($notifyContent);exit;
	 return $notifyContent;
  }
  /** Add admin model users */
  function addUsers($first_name,$last_name,$user_name,$email,$team_id,$board_id,$pass_word,$access_role,$added_by){
		// $insert_sql = "insert users set first_name='".$first_name."',last_name='".$last_name."',user_name='".$user_name."',email ='".$email."',team_id=".$team_id.",
		// pass_word='".$pass_word."'";
		if($first_name !='' || $user_name!=''){
				$insertnewusers  ="INSERT INTO users(first_name,last_name,user_name,email,board_id,team_id,pass_word,access_role,is_active,added_by)VALUES('".$first_name."','".$last_name."','".$user_name."','".$email."','".$board_id."','".$team_id."',MD5('".$pass_word."'),'".$access_role."','1','".$added_by."')";
		     $result= $this->db->query($insertnewusers);
		            return $result;
		 	}
		
	}
 
  /** Get Dates Lists with users speciific dates */
  public function getDatesList($user_id,$currentuser){
	//echo var_dump($user_id);
	$date_array = array();
	$nextMonthdate = array();

	$id = $user_id;
	
	$date=strtotime(date('Y-m-d'));
	//$nextMonth = date('Y-m-d',strtotime('+40 days',$date));
	//$prevMonth = date('Y-m-d',strtotime('-24 days',$date));
       $useridsQA = array('67','58','61','70');
	   
	   if(in_array($id,$useridsQA)){
        //$nextMonth = date('Y-m-d',strtotime('+4 days',$date));
        //$prevMonth = date('Y-m-d',strtotime('-5 days',$date));
		$nextMonth = date('Y-m-d',strtotime('+2 days',$date));
        $prevMonth = date('Y-m-d',strtotime('-2 days',$date));
	   }else {
		$nextMonth = date('Y-m-d',strtotime('+6 days',$date));
        $prevMonth = date('Y-m-d',strtotime('-6 days',$date));
	   }	
	   if($id =='23'){
		$nextMonth = date('Y-m-d',strtotime('+2 days',$date));
        $prevMonth = date('Y-m-d',strtotime('-5 days',$date));
	   }
	   if($id =='60'){
		$nextMonth = date('Y-m-d',strtotime('+2 days',$date));
        $prevMonth = date('Y-m-d',strtotime('-2 days',$date));
	   }
	    if($id =='26'){
		$nextMonth = date('Y-m-d',strtotime('+6 days',$date));
        $prevMonth = date('Y-m-d',strtotime('-6 days',$date));
	   }
	   if($id =='1'){
		$nextMonth = date('Y-m-d',strtotime('+2 days',$date));
        $prevMonth = date('Y-m-d',strtotime('-3 days',$date));
	   }
	   if($id == '64'){
		 $nextMonth = date('Y-m-d',strtotime('+4 days',$date));
         $prevMonth = date('Y-m-d',strtotime('-5 days',$date)); 
	   }
	//    if($id =='60'){
	// 	$nextMonth = date('Y-m-d',strtotime('+2 days',$date));
    //     $prevMonth = date('Y-m-d',strtotime('-3 days',$date));
	//    }

	
	for($x=strtotime($prevMonth);$x<=strtotime($nextMonth);$x += (86400)){
		$date = date('Y-m-d', $x); 
		if(date('w', strtotime($date)) !=6 && date('w', strtotime($date)) !=0){
			$date_array[] =$date;
		}
	}
    
     $week_a = array();
	
	ini_set('max_execution_time', 6000);
    $this->db->query("SET sql_mode = ''");
	$res = $this->db->query("SELECT user_id,planned_date,task_title,ticket_no,status,task_type,CAST(estimated_time AS FLOAT) AS estimated_time,id,order_position,is_private,task_category,original_estimate,remaining_estimate,ticket_status,colorcode FROM checklist WHERE user_id=$id AND DATE(planned_date) >= '".$prevMonth."' AND DATE(planned_date) < '".$nextMonth."' ORDER BY DATE(planned_date),order_position",true);
    
	
	 $getspecificdetails = array();
	 $alltasklistcontent = array();
	 $getdatelist = array();
	 $task_total = array();
	 $total_task_added = array();
	 $total_completed_task = array();
	 $total_task_in_board = array();
	 $pending_task_in_board = array();
	 $final_list = array();
	 $new_created_array = array();

 foreach($res->result() as $getspecificdetails){
	$getdatelist[$getspecificdetails->planned_date][] = array(
      'id'=>$getspecificdetails->id,
 	  'summary'=>($getspecificdetails->is_private == 1 && $getspecificdetails->user_id != $currentuser ) ? ' ' :    $getspecificdetails->task_title,
      'ticket_no'=> $getspecificdetails->ticket_no,
'event_type'=> $getspecificdetails->task_type,
'status' => $getspecificdetails->status,
'estimated_time'=>$getspecificdetails->estimated_time,
'task_id'=>$getspecificdetails->id,
'planned_date'=>$getspecificdetails->planned_date,
'order_position'=>$getspecificdetails->order_position,
'isprivate'=>$getspecificdetails->is_private,
'taskname'=>$getspecificdetails->task_category,
'taskoriginalestimate'=>$getspecificdetails->original_estimate,
'taskremainingestimate'=>$getspecificdetails->remaining_estimate,
'ticket_status'=>$getspecificdetails->ticket_status,
'colorcode'=>$getspecificdetails->colorcode

	);
	//   $task_total[$getspecificdetails->planned_date]['isooo'][] = $getspecificdetails->task_category === 'oof' ? "1":"-1";
			  $task_total[$getspecificdetails->planned_date]['total_task'][] = $getspecificdetails->status;
	 		  $task_total[$getspecificdetails->planned_date]['estimated_time'][] = $getspecificdetails->estimated_time;
	 		  $task_total[$getspecificdetails->planned_date]['completed_task'][] = $getspecificdetails->status == 1;
	 		  $total_task_added[$getspecificdetails->planned_date]['timelog'] = number_format(array_sum($task_total[$getspecificdetails->planned_date]['estimated_time']),1);
	 		  $total_task_added[$getspecificdetails->planned_date]['total'] = count($task_total[$getspecificdetails->planned_date]['total_task']);
	          $total_task_added[$getspecificdetails->planned_date]['pending'] = count(array_filter($task_total[$getspecificdetails->planned_date]['completed_task'])); 

   }
   for($x=0;$x<count($date_array);$x++){
		 	 if(isset($getdatelist[$date_array[$x]])){
		 		$final_list[$date_array[$x]]['content'] = $getdatelist[$date_array[$x]];
		 	 }else{
		 		$final_list[$date_array[$x]]['content'] = array();
		 	 }
		 }

		 for($x=0;$x<count($date_array);$x++){
						if(isset($getdatelist[$date_array[$x]])){
						   $final_list[$date_array[$x]]['content'] = $getdatelist[$date_array[$x]];
						}else{
						   $final_list[$date_array[$x]]['content'] = array();
						}
				   }

				   $index = 0;
		foreach(array_keys($final_list) as $key){
				$final_list[$key]['index'] = $index++;
				$final_list[$key]['fulldate'] = $key;
				// $final_list[$key]['isoo'] = (isset($task_total[$key]['isooo'][0]) ? $task_total[$key]['isooo'][0] : '-1');  
				$final_list[$key]['total_task_in_board'] = (isset($total_task_added[$key]['total']) ? $total_task_added[$key]['total'] :'');
				$final_list[$key]['total_pending_in_board'] = (isset($total_task_added[$key]['pending']) ? $total_task_added[$key]['pending'] :'');
				$final_list[$key]['total_estimated_time'] = (isset($total_task_added[$key]['timelog']) ? $total_task_added[$key]['timelog'] : '');  
				
				
			}
		
		// echo json_encode(var_dump($final_list));
		
		return $final_list;

}

       /** Copy Items List details */
 public function getCloneDetails($ticketClone){
	$todayDate = date('Y-m-d');
    $startdate = $ticketClone['startdate'];
	
	if($startdate != $todayDate){
		$counterDate = date('Y-m-d',strtotime($startdate));
	}else{
		$counterDate = date('Y-m-d',strtotime("+1 day", strtotime($startdate)));
	}
	// $counterDate = date('Y-m-d',strtotime("+1 day", strtotime($startdate)));
	$enddate   = $ticketClone['enddate'];
	$user_id   = $ticketClone['user_id'];
	$event_type = $ticketClone['task_type'];
	$team_id   = $ticketClone['team_id'];
	$summary   = addslashes($ticketClone['task_title']);
	$ticket_no = $ticketClone['ticket_no'];
	$task_category = $ticketClone['taskCategory'];
	$timeSpent = $ticketClone['timespent'];
	// $originalestimate = isset($ticketClone['timespent']) ? $ticketClone['timespent'] : $ticketClone['originalestimate'];
	// $remainingestimate = $ticketClone['remianing'];
	$originalestimate = isset($ticketClone['originalestimate']) ? $ticketClone['originalestimate'] : $ticketClone['originalestimate'];
	// $remainingestimate = isset($ticketClone['timespent']) ? isset($ticketClone['timespent']) : '0h';
	$remainingestimate = $timeSpent;
	$ticketstatus = $ticketClone['ticket_status'];
	$colorcode =$ticketClone['colorcode'];
	$status    = 0;
	$timelog   = 0;
	$datesArray = array();
	if($enddate !=''){
		for ($currentDate = strtotime($counterDate); $currentDate <= strtotime($enddate); $currentDate += (86400)) {
            $date = date('Y-m-d', $currentDate);
            $datesArray[] = $date;
        }
	}else{
		$datesArray[] = $startdate;
	}

	foreach($datesArray as $value){
		$clonedetailsquery = "INSERT INTO checklist(user_id,team_id,task_title,ticket_no,task_type,status,planned_date,estimated_time,order_position,is_private,task_category,original_estimate,remaining_estimate,ticket_status,colorcode,is_copied)VALUES('".$user_id."','".$team_id."','".$summary."','".$ticket_no."','".$event_type."','".$status."','".$value."','".$timelog."',1,0,'".$task_category."','".$originalestimate."','".$remainingestimate."','".$ticketstatus."','".$colorcode."',1)";
	    $copy_res = $this->db->query($clonedetailsquery);
		if($copy_res == 1){
          $msg = "Records has been copied sucessfully";  
		}else{
		  $msg =  "Problem in updation";
		}
	}
	return $msg;
	
 }

 /** Maintain Sort results */
// /** Maintain Sort results */
// public function getSortupdateDetails($newIndex,$oldIndex,$editID,$planned_date,$user_id,$eventtype){
// 	$idarr = array();
// 	if($newIndex > $oldIndex){
// 		//Minus
// 	  $s = "SELECT id FROM checklist where order_position <='".$newIndex."' and order_position >'".$oldIndex."' and planned_date='".$planned_date."' and user_id='".$user_id."'";
	
// 	  $res = $this->db->query($s);
// 	  foreach($res->result('array') as $gets){
//            $idarr[] = $gets['id'];
// 	  }
// 	  for($i=0;$i<count($idarr);$i++){
//       $update[$i]= "UPDATE checklist set order_position = CAST(order_position as INTEGER)-1 WHERE id='".$idarr[$i]."' and planned_date='".$planned_date."' and user_id='".$user_id."'";
// 	  $res = $this->db->query($update[$i]);
// 	  }
// 	}
// 	if($newIndex < $oldIndex){
// 		//plus
// 	  $s = "SELECT id FROM checklist where order_position <='".$oldIndex."' and order_position >='".$newIndex."' and planned_date='".$planned_date."' and user_id='".$user_id."'";
// 	  $res = $this->db->query($s);
// 	  foreach($res->result('array') as $gets){
//            $idarr[] = $gets['id'];
// 	  }
//       for($i=0;$i<count($idarr);$i++){
// 		$update[$i]= "UPDATE checklist set order_position = CAST(order_position as INTEGER)+1 WHERE id='".$idarr[$i]."' and planned_date='".$planned_date."' and user_id='".$user_id."'";
// 		$res = $this->db->query($update[$i]);
// 	  }
	 
// 	}
// 	$val = intval($newIndex);
// 	$update = "UPDATE checklist set order_position ='".$val."' WHERE id='".$editID."' and planned_date='".$planned_date."' and user_id='".$user_id."'";
// 	$res = $this->db->query($update);
// 	return $res;
//  }
/** latest code for sort update detaisl */
public function getSortupdateDetails($details,$user_id){
	$arr = array();
	foreach($details as $key=>$value){
		$arr = $value;
	}
	$value = json_decode(json_encode($arr),true);
	for($i=0;$i<count($value);$i++){
		$update = "UPDATE checklist set order_position ='".($i+1)."' WHERE id='".$value[$i]['id']."' and planned_date='".$value[$i]['planned_date']."' and user_id='".$user_id."'";
        $res = $this->db->query($update);	
	}
	return $res;
}

 /** Checking for previous & Next nmonth Dates */
   /** Get Dates Lists with users speciific dates */
   public function getDatesListprev($user_id){
	
	$date_array = array();
	$nextMonthdate = array();

	$date=strtotime(date('Y-m-d'));
	$nextMonth = date('Y-m-d',strtotime('+24 days',$date));
	$prevMonth = date('Y-m-d',strtotime('-14 days',$date));
	for($x=strtotime($prevMonth);$x<=strtotime($nextMonth);$x += (86400)){
		$date = date('Y-m-d', $x); 
		if(date('w', strtotime($date)) !=6 && date('w', strtotime($date)) !=0){
			$date_array[] =$date;
		}
	}
   
     $week_a = array();
	
	$db_query = "SELECT planned_date,task_title,ticket_no,status,task_type,estimated_time,id,is_private FROM checklist WHERE user_id='".$user_id."'"; 
	$res = $this->db->query($db_query);
	 $getspecificdetails = array();
	 $alltasklistcontent = array();
	 $getdatelist = array();
	 $task_total = array();
	 $total_task_added = array();
	 $total_completed_task = array();
	 $total_task_in_board = array();
	 $pending_task_in_board = array();
	 $final_list = array();
	 $new_created_array = array();
	
		foreach($res->result('array') as $getspecificdetails){
			$getdatelist[$getspecificdetails['planned_date']][]=array(
				        'id'=>$getspecificdetails['id'],
					    'summary'=>$getspecificdetails['task_title'],
						'ticket_no'=> $getspecificdetails['ticket_no'],
						'event_type'=> $getspecificdetails['task_type'],
						'status' => $getspecificdetails['status'],
						'estimated_time'=>$getspecificdetails['estimated_time'],
						'task_id'=>$getspecificdetails['id'],
						'planned_date'=>$getspecificdetails['planned_date'],
						'isprivate'=>$getspecificdetails['is_private']
				  );
		  $task_total[$getspecificdetails['planned_date']]['total_task'][] = $getspecificdetails['status'];
		  $task_total[$getspecificdetails['planned_date']]['estimated_time'][] = $getspecificdetails['estimated_time'];
		  $task_total[$getspecificdetails['planned_date']]['completed_task'][] = $getspecificdetails['status'] == 1;
		  $total_task_added[$getspecificdetails['planned_date']]['timelog'] = array_sum($task_total[$getspecificdetails['planned_date']]['estimated_time']);
		  $total_task_added[$getspecificdetails['planned_date']]['total'] = count($task_total[$getspecificdetails['planned_date']]['total_task']);
          $total_task_added[$getspecificdetails['planned_date']]['pending'] = count(array_filter($task_total[$getspecificdetails['planned_date']]['completed_task'])); 
		}
			
		
		for($x=0;$x<count($date_array);$x++){
			 if(isset($getdatelist[$date_array[$x]])){
				$final_list[$date_array[$x]]['content'] = $getdatelist[$date_array[$x]];
			 }else{
				$final_list[$date_array[$x]]['content'] = array();
			 }
		}
		foreach(array_keys($final_list) as $key){
			   $final_list[$key]['fulldate'] = $key;
			   $final_list[$key]['total_task_in_board'] = (isset($total_task_added[$key]['total']) ? $total_task_added[$key]['total'] :'');
			   $final_list[$key]['total_pending_in_board'] = (isset($total_task_added[$key]['pending']) ? $total_task_added[$key]['pending'] :'');
			   $final_list[$key]['total_estimated_time'] = (isset($total_task_added[$key]['timelog']) ? $total_task_added[$key]['timelog'] : '');  
			
			
		   }
	       return $final_list;
	 }
     /** Private Mode hide & Unhide **/
	/*function decodeactivity($tid,$status){

	$decodedetails = array();

	if($status == 1){
		$getenc = "SELECT * from checklist where id='".$tid."'";
	    $dbquery1 = $this->db->query($getenc);
		foreach($dbquery1->result('array') as $tracker){
			
			$decodedetails = array(
				 "ticket_no"=>convert_uuencode($tracker["ticket_no"]),
				 "title"=>convert_uuencode($tracker["task_title"]),
				 "time"=>convert_uuencode($tracker["estimated_time"])
			);
		}
		$details_update ="UPDATE checklist SET task_title='".$decodedetails["title"]."',ticket_no='".$decodedetails["ticket_no"]."',estimated_time='".$decodedetails["time"]."',is_private=1  where id='".$tid."'";
		
		$upquery = $this->db->query($details_update);
		if($upquery === 1){
			echo 'update';
		}
	}
	if($status == 0){
		$getenc = "SELECT * from checklist where id='".$tid."'";
	    $dbquery1 = $this->db->query($getenc);
		foreach($dbquery1->result('array') as $tracker){
			
			$decodedetails = array(
				 "ticket_no"=>convert_uudecode($tracker["ticket_no"]),
				 "title"=>convert_uudecode($tracker["task_title"]),
				 "time"=>convert_uudecode($tracker["estimated_time"])
			);
		}
		$details_update ="UPDATE checklist SET task_title='".$decodedetails["title"]."',ticket_no='".$decodedetails["ticket_no"]."',estimated_time='".$decodedetails["time"]."',is_private=0  where id='".$tid."'";
		$upquery = $this->db->query($details_update);
		if($upquery === 1){
			echo 'update';
		}
	}
}*/
 /** Query Updated **/
function decodeactivity($tid,$status){

	$decodedetails = array();

	if($status == 1){
		$details_update ="UPDATE checklist SET is_private =1 where id='".$tid."'";
		
		$upquery = $this->db->query($details_update);
		if($upquery === 1){
			echo 'update';
		}
	}
	if($status == 0){
		$details_update ="UPDATE checklist SET is_private=0  where id='".$tid."'";
		$upquery = $this->db->query($details_update);
		if($upquery === 1){
			echo 'update';
		}
	}
}
/** End Query Updated **/

	 /**Latest updated Functions */
	function listUsers($board_id,$team_id){
		// $db_query = "SELECT * FROM users WHERE board_id='".$board_id."' AND team_id='".$team_id."'";
		$db_query = "SELECT b.board_name,t.team_name,u.user_name,u.email,u.id,u.access_role FROM boards b,teams t,users u WHERE b.id='".$board_id."' AND t.id='".$team_id."' AND u.team_id= t.id AND u.board_id=b.id AND u.is_active=1";
		$result = $this->db->query($db_query)->result_array();
		return $result;
	}
	 public function Removeusers($userid){
		$delete_user = "DELETE  FROM users where id='".$userid."' and is_active=1";
		$db_task_list = $this->db->query($delete_user);
		if($db_task_list == 1){
			$msg.= "User Has been Removed";
		 }else{
			$msg.= "Something went Wrong";
		 }
	 } 
	 /** Get Selected dates from Calendar */
	  /** Get Selected Dates */
	  public function getselectedDates($datelist){
		$startDate = $datelist['startDate'];
		$endDate   = $datelist['endDate'];
		$user_id   = $datelist['uuid'];
		
		$task_total = array();
		$total_task_added = array();
	   

		$date_array = array();
		for($i=strtotime($startDate);$i<=strtotime($endDate);$i+= (86400)){
		   $date = date('Y-m-d', $i);
		   if(date('w', strtotime($date)) !=6 && date('w', strtotime($date)) !=0){
			   $date_array[]= $date;
		   }
		}
		$getdatelistusers = array();
		$mergeDatearraylist = array();

		$final_list = array();

		$db_query = "SELECT id,planned_date,task_title,ticket_no,status,task_type,CAST(estimated_time AS FLOAT) AS estimated_time FROM checklist where planned_date BETWEEN '".$startDate."' AND '".$endDate."' and user_id='".$user_id."'";
		$res = $this->db->query($db_query);
		
		   foreach($res->result('array') as $getspecificdetails){
			   $getdatelist[$getspecificdetails['planned_date']][] = array(
					   'id'=>$getspecificdetails['id'],
					   'summary'=>$getspecificdetails['task_title'],
					   'ticket_no'=> $getspecificdetails['ticket_no'],
					   'event_type'=> $getspecificdetails['task_type'],
					   'status' => $getspecificdetails['status'],
					   'estimated_time'=>$getspecificdetails['estimated_time'],
					   'task_id'=>$getspecificdetails['id'],
					   'planned_date'=>$getspecificdetails['planned_date']
				   );

				   $task_total[$getspecificdetails['planned_date']]['total_task'][] = $getspecificdetails['status'];
				   $task_total[$getspecificdetails['planned_date']]['estimated_time'][] = $getspecificdetails['estimated_time'];
				   $task_total[$getspecificdetails['planned_date']]['completed_task'][] = $getspecificdetails['status'] == 1;		
				   $total_task_added[$getspecificdetails['planned_date']]['timelog'] = number_format(array_sum($task_total[$getspecificdetails['planned_date']]['estimated_time']),1);
				   $total_task_added[$getspecificdetails['planned_date']]['total'] = count($task_total[$getspecificdetails['planned_date']]['total_task']);
				   $total_task_added[$getspecificdetails['planned_date']]['pending'] = count(array_filter($task_total[$getspecificdetails['planned_date']]['completed_task'])); 
			   
			   }
			   for($x=0;$x<count($date_array);$x++){
				   if(isset($getdatelist[$date_array[$x]])){
					  $final_list[$date_array[$x]]['content'] = $getdatelist[$date_array[$x]];
				   }else{
					  $final_list[$date_array[$x]]['content'] = array();
				   }
			  }

			  foreach(array_keys($final_list) as $key){
			   $final_list[$key]['fulldate'] = $key;
			   $final_list[$key]['month'] = date('F',strtotime($key));
			   $final_list[$key]['year'] = date('Y', strtotime($key));
			   $final_list[$key]['date'] = date('j', strtotime($key));
			   $final_list[$key]['total_task_in_board'] = (isset($total_task_added[$key]['total']) ? $total_task_added[$key]['total'] :'');
			   $final_list[$key]['total_pending_in_board'] = (isset($total_task_added[$key]['pending']) ? $total_task_added[$key]['pending'] :'');
			   $final_list[$key]['total_estimated_time'] = (isset($total_task_added[$key]['timelog']) ? $total_task_added[$key]['timelog'] : '');  
			
			
				 }
			  
				$mergeDatearraylist = $final_list;
				return $mergeDatearraylist;	
	}


	/** Latest code for team bubbles chat and task list edited */
	public function getteamtaskdetails($team_id){
		$current_date = date('Y-m-d');
		// $yesterday_date = date('Y-m-d', strtotime(' -1 day')); 
		$yesterday_date = $current_date;
		$date_array = array();
		$yesterday_date_value = '';
		$yesterday_pending_tasks = array();
		$alldates_pending_tasks = array();
		$getTotalpendingtasks = array();
		$listallusers = array(); 
		/** get Yesterday date */
		$nextMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 1));
		$lastdateofnextMonth= date('Y-m-d', strtotime('+30 days'));
		/** End get Yesterdday date */ 
		/** fetch Total completed tasks for yesterday  */
		for($x=strtotime($nextMonth);$x<=strtotime($lastdateofnextMonth);$x += (86400)){
		   $date = date('Y-m-d', $x); 
			   if($date != $yesterday_date  && date('w', strtotime($current_date)) == 6){
				   $yesterday_date_value = date('Y-m-d', strtotime(' -1 day'));
			   }else if($date != $yesterday_date && date('w', strtotime($current_date)) == 0){
				   $yesterday_date_value = date('Y-m-d', strtotime(' -2 day'));
			   }
			   /*else if($date != $yesterday_date && date('w', strtotime($current_date)) == 1){
				   $yesterday_date_value = date('Y-m-d', strtotime(' -3 day'));
			   }*/
			   else{
				   $yesterday_date_value = $yesterday_date;
			   }
		}
	   /** Select All uers */
	   $db_query = "SELECT id,first_name from users where team_id='".$team_id."' and is_active=1";
	   $res = $this->db->query($db_query);
	   foreach($res->result('array') as $getusers){
		   $listallusers[]= array('id'=>$getusers['id'],'first_name'=>$getusers['first_name']); 
	   }
	   
	   /** End Select All users */
	   $db_query = "SELECT u.id,u.first_name, sum(case when c.status = 1 then 1 else 0 end) as completedtasks, sum(case when c.status <> 1 then 1 else 0 end) as pendingtasks from checklist c inner join users u on u.id = c.user_id and u.team_id = c.team_id AND c.planned_date ='".$yesterday_date_value."' AND c.team_id='".$team_id."' group by c.user_id ORDER BY u.first_name DESC"; 
	   $res = $this->db->query($db_query);
	   foreach($res->result('array') as $getyesterday_task_list){
			   $yesterday_pending_tasks[$getyesterday_task_list['id']] = array(
					'id' => $getyesterday_task_list['id'],
					'first_name'=>$getyesterday_task_list['first_name'],
					'yesterday_pending_tasks'=>$getyesterday_task_list['pendingtasks']
			   );  
	   }

	   $final_result = array();
	   $bd_query = "SELECT u.id,u.first_name, sum(case when c.status = 1 then 1 else 0 end) as completedtasks, sum(case when c.status <> 1 then 1 else 0 end) as pendingtasks from checklist c inner join users u on u.id = c.user_id and u.team_id = c.team_id AND c.planned_date <>'".$yesterday_date_value."' AND c.team_id='".$team_id."' group by c.user_id";  
	   $res = $this->db->query($bd_query);
	   $all_pending_tasks = array();
	  
		foreach($res->result('array') as $getyesterday_task_list){
				$all_pending_tasks[$getyesterday_task_list['id']] = array(
					'id' => $getyesterday_task_list['id'],
					'first_name'=> $getyesterday_task_list['first_name'],
					'alldates_pending_tasks'=>$getyesterday_task_list['pendingtasks']
					);  
	  }
	  for($i=0;$i<count($listallusers);$i++){
		$final_result[$listallusers[$i]['id']] = array(
			   'user_id'=> $listallusers[$i]['id'],
			   'first_name'=> $listallusers[$i]['first_name'],
			   'yesterday_pending_tasks'=> isset($yesterday_pending_tasks[$listallusers[$i]['id']]['yesterday_pending_tasks']) ? $yesterday_pending_tasks[$listallusers[$i]['id']]['yesterday_pending_tasks'] : '0',
			   'alldates_pending_tasks'=>isset($all_pending_tasks[$listallusers[$i]['id']]['alldates_pending_tasks']) ? $all_pending_tasks[$listallusers[$i]['id']]['alldates_pending_tasks'] : '0'
		);
	  }

	  return $final_result;
	}

	/** Activity Messages **/
	 /** activity posts */
	 function getActivityLog($team_id,$loadoptions=''){
		
		$loadmore = 3;
		if($loadoptions === '' ){
            $loadmore = 3;
		}else{
			$loadmore = $loadoptions;
		}
        $db_query="SELECT CONCAT('Latest changes are done by ',u.first_name,' ',u.last_name) as activity_message, c.date_updated from checklist as c INNER JOIN users u ON u.id=c.user_id where c.team_id='".$team_id."'  order by c.id DESC LIMIT $loadmore";
		$result = $this->db->query($db_query)->result_array();
		return $result;
		 		
    }
	public function currentAbsentDetails(){
	$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
    $end = (date('D') != 'Sat') ? date('Y-m-d', strtotime('Friday this week')) : date('Y-m-d');
    $bargraphdates = array();
    
	$absentbargraphdetails = array(); 
	for ($currentDate = strtotime($start);$currentDate <= strtotime($end);$currentDate += (86400)) {
	  $date = date('Y-m-d',$currentDate);
	  $bargraphdates[]= $date;
	}
     $details = array(); 
	for($i=0;$i<count($bargraphdates);$i++){
		$absentbargraph ="SELECT COUNT(*) As no_of_users, '".$bargraphdates[$i]."' as selecteddate FROM `user_attendence` WHERE '".$bargraphdates[$i]."' BETWEEN start_date AND end_date AND team_id in (6,8,9)";
		$result3[$i]= $this->db->query($absentbargraph);
		foreach($result3[$i]->result('array') as $userslist){
		   $details[] = array('no_of_users'=>$userslist["no_of_users"],'slected_date'=>date('d/m',strtotime($userslist["selecteddate"])));
		}
	}
	return $details; 

 }
    /** Update Users Roles new **/
	public function updateUsersRole($updatedetails){
		$userrole = $updatedetails->userRole;
		$userid = $updatedetails->userid;
		$userteamid = $updatedetails->teamid;
		$useremail =  $updatedetails->email;
		$first_name = $updatedetails->firstname;
		$last_name  = $updatedetails->lastname;
		$username = $updatedetails->username;
		$added_by = $updatedetails->added_by;
		$updateroles="update users set team_id='".$userteamid."' , access_role='".$userrole."',first_name='".$first_name."',last_name='".$last_name."' WHERE id='".$userid."' and email='".$useremail."' and is_active=1";
	   
		$updaterolesresult= $this->db->query($updateroles);
		$activity_type ="2";
		$activity_details =  $username." User has been Modified";
			if($updaterolesresult==true){
				 /** Insert Into activity Logs */
			 if(!empty($username) || !empty($added_by)){
				$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details)VALUES('".$added_by."','".$added_by."','".$activity_type."','".$activity_details."')";
				$insertlog = $this->db->query($insertactivitylog);
				if($insertlog == 1){
				 	echo "updated";
				 }	
			 }
				$msg = ['status'=>true,"msg"=>"User Role has been updated successfully"];
			}else{
				$msg = ['status'=>false,'msg'=>'Something went wrong'];
			}
	      return $msg;		
	 }

	/** getactivityMessagesCount */
	public function getactivityMessagesCount($team_id){
	   $sql="SELECT count(*) AS totalmessagescount FROM checklist where team_id=$team_id";
	   $result = $this->db->query($sql);
	   $TotalMessagesCount = array();   
	   foreach($result->result('array') as $totalCount){
		   $TotalMessagesCount[] = $totalCount['totalmessagescount'];
	   }
	   return $TotalMessagesCount;
	}
	
  /* Add task list for sort order posiiton */
 /* public function getAddeddetailsSpecific($insertdetails){
	$status = 0;
    
	if($insertdetails['summary'] != ''){
		$position_query = "SELECT MAX(order_position) AS position FROM checklist where user_id='".$insertdetails["user_id"]."' and planned_date='".$insertdetails["planned_date"]."'";
		$res = $this->db->query($position_query);
		foreach($res->result('array') as $getspecificdetails){
             $position= $getspecificdetails['position'];
		}
		//echo $position;
		if($position == ''){
			$position=1;
		}else{
			$position = $position + 1;
		}
		$db_query = "INSERT INTO checklist(user_id,team_id,task_title,ticket_no,task_type,status,planned_date,estimated_time,order_position)VALUES('".$insertdetails["user_id"]."','".$insertdetails["team_id"]."','".$insertdetails["summary"]."','".$insertdetails["ticket_no"]."','".$insertdetails["event_type"]."','".$status."','".$insertdetails["planned_date"]."','".$insertdetails["timelog"]."','".$position."')";
		$insert_res = $this->db->query($db_query);
		if($insert_res == 1){
			echo 'Inserted Updated';
		}else{
			echo 'Not Updated';
		}
	}  */ 
 
 	
	function dashboardSummary($requested_date){ 
    /**Modified */
	$task_summary="Select COUNT(id) as task_planned,
    round(SUM(estimated_time),2) as hours_planned,
    (SELECT round(COUNT(DISTINCT user_id)*8.5,2) from checklist where planned_date='".$requested_date."') as available_hours,
    (SELECT COUNT(id)  from checklist WHERE status=1 AND planned_date='".$requested_date."' ) as completed_tasks,
    (SELECT round(SUM(estimated_time),2)  from checklist WHERE status=1 AND planned_date='".$requested_date."' ) as completed_hours,
    (SELECT ROUND(COUNT(DISTINCT user_id)*8.5 - round(SUM(estimated_time),2),2) from checklist WHERE status IN(0,1) AND planned_date='".$requested_date."') as remaining_hours
    from checklist WHERE team_id in (6,8,9) AND planned_date='".$requested_date."'";
	/** end modified */

	$absent_list="select CONCAT(u.first_name,' ',u.last_name) as user_name,ua.start_date,ua.end_date,IF(DATEDIFF(ua.end_date, ua.start_date) = 0, 1, DATEDIFF(ua.end_date, ua.start_date)) as no_of_days
    from user_attendence ua
    INNER JOIN users u
    ON u.id=ua.user_id
    WHERE '".$requested_date."' BETWEEN ua.start_date AND ua.end_date AND ua.team_id IN(6,8,9)";
    
	$availability_in_percentage="SELECT COUNT(ua.id) AS total_absent,
    (SELECT COUNT(id)   from users where is_active=1 AND team_id IN(6,8,9)) total_users,
    (SELECT ROUND(COUNT(ua.id)/COUNT(id)*100,2) from users where is_active=1 AND team_id IN(6,8,9)) absent_percentage,
    (SELECT ROUND(100-COUNT(ua.id)/COUNT(id)*100,2) from users where is_active=1 AND team_id IN(6,8,9)) present_percentage
    FROM user_attendence ua WHERE '".$requested_date."' BETWEEN ua.start_date AND ua.end_date";
	
    
	$result1= $this->db->query($task_summary)->result_array();
    $result2= $this->db->query($absent_list)->result_array();
    $result3= $this->db->query($availability_in_percentage)->result_array();
    //print_r($result1);die;
    if(!empty($result1) || !empty($result2) || !empty($result3)):
        $msg = ['status'=>true,"task_summary"=>$result1,"absent_list"=>$result2,"availability_in_percentage"=>$result3];
     else:
        $msg = ['status'=>false,'msg'=>'Something went wrong'];
     endif;
    return $msg;
    
}

//Absent list
/*	function absentSummary($from_date,$to_date,$user_id,$type){
		if($type==0):
			$absent_list="select CONCAT(u.first_name,' ',u.last_name) as user_name, ua.start_date, ua.end_date,
			IF(DATEDIFF(ua.end_date, ua.start_date) = 0, 1, DATEDIFF(ua.end_date, ua.start_date)) as no_of_days
			from user_attendence ua
			INNER JOIN users u
			ON u.id=ua.user_id
			WHERE ua.start_date>=$from_date AND ua.end_date<=$to_date";
		else:
			$absent_list="select CONCAT(u.first_name,' ',u.last_name) as user_name, ua.start_date, ua.end_date,
			IF(DATEDIFF(ua.end_date, ua.start_date) = 0, 1, DATEDIFF(ua.end_date, ua.start_date)) as no_of_days
			from user_attendence ua
			INNER JOIN users u
			ON u.id=ua.user_id
			WHERE ua.user_id=$user_id";
		endif;
		//print_r($absent_list);die;
		$result= $this->db->query($absent_list)->result_array();
		//print_r($result);die;
		if(!empty($result)):
            $msg = ['status'=>true,"absent_list"=>$result];
         else:
            $msg = ['status'=>false,'msg'=>'No data found'];
         endif;
		return $msg;
	}*/
	function absentSummary($user_id,$type){
	$absent_list="select CONCAT(u.first_name,' ',u.last_name) as user_name, ua.start_date, ua.end_date,
		IF(DATEDIFF(ua.end_date, ua.start_date) = 0, 1, DATEDIFF(ua.end_date, ua.start_date)) as no_of_days
		from user_attendence ua
		INNER JOIN users u
		ON u.id=ua.user_id
		WHERE ua.user_id='".$user_id."'";
	//print_r($absent_list);die;
	$result= $this->db->query($absent_list)->result_array();
	//print_r($result);die;
	if(!empty($result)):
		$msg = ['status'=>true,"absent_list"=>$result];
	 else:
		$msg = ['status'=>false,'msg'=>'No data found'];
	 endif;
	return $msg;
 }
	// /** Activity Model */
	// function addUserActivity($user_id,$added_by,$activity_type,$activity_details){
    //     $insert_sql = "insert user_activity_log set user_id=$user_id,added_by=$added_by, activity_type=$activity_type,activity_details='".$activity_details."'";
    //     $result= $this->db->query($insert_sql);
    //     return $result;
    // }
/** Activity Model */
function addUserActivity($user_id,$added_by,$activity_type,$activity_details,$board_id,$ticket_no){
	
	$teamdetails = array();
	$taskdetails= '';
	$getUserDetails  = "SELECT id,first_name,last_name from users where board_id='".$board_id."' and is_active=1";
	$dbquery = $this->db->query($getUserDetails);
    foreach($dbquery->result('array') as $teamlist){
       $teamdetails[$teamlist["id"]] = $teamlist["first_name"];  
	}
	if(!empty($ticket_no)){
		$taskdetails = $activity_details.' '.$ticket_no;
	}else{
		$taskdetails = $activity_details;
	}
	if(!empty($user_id)){
		$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details)VALUES('".$user_id."','".$added_by."','".$activity_type."','".$taskdetails."')";
		$insertlog = $this->db->query($insertactivitylog);
	}
	
}

	function getdeactivateDetails($userid,$added_by){
		
		$userdetailsactive = array();
		$teamdetails = array();
		 $getTeamdetails = "SELECT id,team_name FROM teams";
		 $result1 = $this->db->query($getTeamdetails);
		
		 	foreach($result1->result('array') as $details){
                 $teamdetails[$details['id']] = $details["team_name"];
		 	}
		
		  
         if(!empty($userid)){
			$deactivatedetails = "SELECT * from users where id='".$userid."'";
			
			$result = $this->db->query($deactivatedetails);
		    if(!empty($result)){
				foreach($result->result('array') as $userdetails){
                   $userdetailsactive = array(
					   'id'=>$userdetails['id'],
					   'username'=>$userdetails['user_name'],
					   'first_name'=>$userdetails['first_name'],
					   'last_name'=>$userdetails['last_name'],
					   'batchname'=>$teamdetails[$userdetails['team_id']]
				   ); 
				}
			}
			return $userdetailsactive;
		}
		
	}

	function deactivateDetails($userid,$added_by,$username){
		$deactivateuser = "UPDATE users set is_active=0 where id='".$userid."'";
		$db = $this->db->query($deactivateuser);
		$activity_type = "3";
		$activity_details = $username." has been deactivated";

		if($db == true){
			$msg = ['status'=>true,'msg'=>'user deactived successfully'];
			if($userid !=''){
				$insertactivitylog = "INSERT INTO user_activity_log(user_id,added_by,activity_type,activity_details)VALUES('".$added_by."','".$added_by."','".$activity_type."','".$activity_details."')";
				$res = $this->db->query($insertactivitylog);	
			}
				
		}else {
			$msg =['status'=>false,'msg'=>'Something went wrong'];
		}
		return $msg;
	}
	function userActivity($skip,$limit){
	$activity_type=array(
		'1'=>"Add User",
		'2'=>'Modifiy User',
		'3'=>'Delete User',
		'4'=>'Add Checklist',
		'5'=>'Copy Checklist',
		'6'=>'Delete Checklist',
		'7'=>'Update Checklist',
		'8'=>'Notify Team',
		'9'=>'Blocker Conversation',
		'10'=>'Mark attendance',
		'11'=>'Change Password',
		'12'=>'Login'
	);
	$tracker_details = array();
	$countDetails = array();
	$getTotalcount ="select count(*) as totalCount from user_activity_log";
	
	$dbquery1 = $this->db->query($getTotalcount);
	foreach($dbquery1->result('array') as $trackercount){
       $countDetails = $trackercount["totalCount"];
	}

	$getuserActivity = "select a.id as uid,u.user_name as username,a.activity_type as activity,a.activity_details as details,CAST(a.date_added as DATE) as dateupdated,DATE_FORMAT(convert_tz(a.date_added,'+00:00','+05:30'),'%l.%i %p') as time from users u,user_activity_log a where u.id=a.user_id ORDER BY a.id DESC limit $skip,$limit";
	$dbquery = $this->db->query($getuserActivity);
	
		foreach($dbquery->result('array') as $tracker){
			
			$tracker_details[]= array(
				 "id"=>$tracker["uid"],
				 "username"=> $tracker["username"],
				 "activity"=> $activity_type[$tracker["activity"]],
				 "details"=> $tracker["details"],
				 "currentdate"=>$tracker["dateupdated"],
				 "time"=>$tracker["time"]
			);
		}
     if(!empty($tracker_details)):
		$msg = ['status'=>true,"tracker_list"=>$tracker_details,"totalcount"=>$countDetails];
	 else:
		$msg = ['status'=>false,'msg'=>'No data found'];
	 endif;
		return $msg;

}

/** Activity Tracker **/
function getFilteredResultsActivitytypenoactivitytype($user_id,$activity_type,$startdate,$enddate,$skip,$limit){
	$activity_type_values=array(
		'0'=>"Ticket Has been Updated",
		'1'=>"Add User",
		'2'=>'Modifiy User',
		'3'=>'Delete User',
		'4'=>'Add Checklist',
		'5'=>'Copy Checklist',
		'6'=>'Delete Checklist',
		'7'=>'Update Checklist',
		'8'=>'Notify Team',
		'9'=>'Blocker Conversation',
		'10'=>'Mark attendance',
		'11'=>'Change Password',
		'12'=>'Login'
	);

if($enddate ==='' || $enddate === 'null'){
	$enddate = $startdate;
}	  
	
if($startdate != ''){
	  $condition1 = "and CAST(a.date_added as DATE)  BETWEEN '".$startdate."' and '".$enddate."'";
   }else{
	$condition1 = '';
   }
   if($user_id != ''){
	$condition2 = "and a.user_id ='".$user_id."'";
   }else{
	$condition2 ='';
   }
   if($activity_type !=''){
	$condition3 = "and a.activity_type='".$activity_type."'";
   }else{
	$condition3 ='';
   }
	$filter = "SELECT a.id as uid,u.user_name as username,a.activity_type,a.activity_details as details,CAST(a.date_added as DATE) as dateupdated,DATE_FORMAT(convert_tz(a.date_added,'+00:00','+05:30'),'%l.%i %p') as time from user_activity_log a,users u where u.id=a.user_id  $condition1  $condition2 $condition3 ORDER BY a.id DESC limit $skip,$limit";
	$result = $this->db->query($filter);
    $userSpecificDetails= array();	
  foreach($result->result('array') as $records){
 	$userSpecificDetails[] = array(
 	 "id"=>$records["uid"],
 	 "username"=>$records["username"],
 	 "activity"=>$activity_type_values[$records["activity_type"]],
 	 "details"=> $records["details"],
	 "currentdate"=>$records["dateupdated"],
	 "time"=>$records["time"]
 	);  
  }

  $totalresults = "SELECT count(*) as TotalRecords from user_activity_log a,users u where u.id=a.user_id  $condition1 $condition2 $condition3";

  $countresults = $this->db->query($totalresults);

    $countRecords = "";
  foreach($countresults->result('array') as $cd){
       $countRecords = $cd["TotalRecords"]; 
  } 

  if(!empty($userSpecificDetails)):
	$msg = ['status'=>true,"tracker_list"=>$userSpecificDetails,"totalcount"=>$countRecords];
   else:
	  $msg = ['status'=>false,'msg'=>'No data found'];
   endif;
	  return $msg;
   
}

function activitytitle(){
	$activity_type=array(
		'0'=>"Ticket Has been Updated",
		'1'=>"Add User",
		'2'=>'Modifiy User',
		'3'=>'Delete User',
		'4'=>'Add Checklist',
		'5'=>'Copy Checklist',
		'6'=>'Delete Checklist',
		'7'=>'Update Checklist',
		'8'=>'Notify Team',
		'9'=>'Blocker Conversation',
		'10'=>'Mark attendance',
		'11'=>'Change Password',
		'12'=>'Login'
	);

	return $activity_type;
}
// function getBargraphDetails($username,$teamid,$startdate,$enddate){
// 	$getbargraphdetails = array();

// 	$countteamid = "SELECT count(*) as totalusers from users where team_id='".$teamid."' and is_active=1";
// 	$countresults =  $this->db->query($countteamid);
//     $countdetails ='';
// 	foreach($countresults->result('array') as $records){
// 		  $countdetails = $records['totalusers'];
// 	}

// 	if($teamid != ''){
// 		$conditon1 ="and c.team_id='".$teamid."'"; 
// 		$teamcond1 = ",round('".$countdetails."'*8.5,2) as hoursperday";
// 		$selectcond1 = "c.team_id";
// 	}else{
// 		$conditon1 = '';
// 		$teamcond1 ='';
// 		$selectcond1='';
// 	}
// 	if($username != ''){
// 		$condition2 ="and c.user_id='".$username."'";
// 		$teamcond2 = ",round(COUNT(DISTINCT c.user_id)*8.5,2) as hoursperday";
// 		$selectcond2 = "c.user_id"; 
// 	    // $selectedoptions2 ="u.id,u.first_name, sum(case when c.status = 1 then 1 else 0 end) as completedtasks, sum(case when c.status <> 1 then 1 else 0 end) as pendingtasks,c.planned_date as date,round(SUM(estimated_time),2) as hours_planned";
// 	}else{
// 		$condition2 ='';
// 		$teamcond2 ='';
// 		$selectcond2='';
// 		// $selectedoptions2='';
// 	}
// //   $dbfilter ="SELECT sum(case when c.status = 1 then 1 else 0 end) as completedtasks, sum(case when c.status <> 1 then 1 else 0 end) as pendingtasks,round(sum(case when c.status = 1 then estimated_time else 0 end),2) as completedhours,round(sum(case when c.status = 0 then estimated_time else 0 end),2) as pendinghours,c.planned_date as date,round(SUM(estimated_time),2) as hours_planned from checklist c inner join users u on u.id = c.user_id $condition2 $conditon1  AND c.planned_date BETWEEN '".$startdate."' AND '".$enddate."' GROUP BY c.planned_date";
     
//    //latest
// //    $dbfilter ="SELECT  '".$selectcond1."' '".$selectcond2."',sum(case when c.status = 1 then 1 else 0 end) as completedtasks, sum(case when c.status <> 1 then 1 else 0 end) as pendingtasks,round(sum(case when c.status = 1 then estimated_time else 0 end),2) as completedhours,round(sum(case when c.status = 0 then estimated_time else 0 end),2) as pendinghours,c.planned_date as date,round(SUM(estimated_time),2) as hours_planned $teamcond1 $teamcond2 from checklist c inner join users u on u.id = c.user_id $condition2 $conditon1  AND c.planned_date BETWEEN '".$startdate."' AND '".$enddate."' GROUP by c.planned_date,'".$selectcond1."' '".$selectcond2."'"; 
     
// 	//Modified
// 	$dbfilter ="SELECT  '".$selectcond1."' '".$selectcond2."',sum(case when c.status = 1 then 1 else 0 end) as completedtasks, sum(case when c.status <> 1 then 1 else 0 end) as pendingtasks,sum(case when c.status = 1 then 1 when c.status = 0 then 1 else 0 end) as totaltasks,round(sum(case when c.status = 1 then estimated_time else 0 end),2) as completedhours,round(sum(case when c.status = 0 then estimated_time else 0 end),2) as pendinghours,c.planned_date as date,round(SUM(estimated_time),2) as hours_planned $teamcond1 $teamcond2 from checklist c inner join users u on u.id = c.user_id $condition2 $conditon1  AND c.planned_date BETWEEN '".$startdate."' AND '".$enddate."' GROUP by c.planned_date,'".$selectcond1."' '".$selectcond2."'";
	
// 	$countresults =  $this->db->query($dbfilter);
	 
	 
// 	 $userbargraphdeatails = array();
// 	 $totalhoursday = array();
// 	 $totaltask = array();
// 	 $totalcompletedtasks = array();
// 	 $totalplannedhours = array();

// 	 foreach($countresults->result('array') as $records){
//            $userbargraphdeatails[] = array(
// 			  "completedtasks"=>$records["completedtasks"],
// 			  "pendingtasks"=>$records["pendingtasks"],
// 			  "planneddate"=>$records["date"],
// 			  "hours_planned"=>$records["hours_planned"],
// 			  "completed_hours"=>$records["completedhours"],
// 			  "pending_hours"=>$records["pendinghours"]+$records["completedhours"],
// 			  "hoursperday"=>$records["hoursperday"],
// 			//   "availablehours"=>abs(floor(($records["hoursperday"]-$records["hours_planned"])*2)/2),
// 			  "availablehours"=>($records["hours_planned"] < $records["hoursperday"]) ? '0':  abs(floor(($records["hoursperday"]-$records["hours_planned"])*2)/2)
// 		   );
// 		   $totalhoursday[]= $records["hoursperday"];
// 		   $totaltask[] = $records["totaltasks"];
// 		   $totalplannedhours[] = $records["pendinghours"] + $records["completedhours"];
// 		   $totalcompletedtasks[] = $records["completedtasks"];
// 	 }

// 	//  if(!empty($userbargraphdeatails)){
//     //     return $userbargraphdeatails;
// 	//  }
// 	$bargraphdetails_arr = array("userbargraphdetails"=>$userbargraphdeatails,"CompletedTasks"=>array_sum($totalcompletedtasks),"totaltask"=>array_sum($totaltask),"totalhoursday"=>array_sum($totalhoursday),"plannedhours"=>array_sum($totalplannedhours));
// 	if(!empty($bargraphdetails_arr)){
// 		return $bargraphdetails_arr;
// 	}
		

// }

//Graph Details
function getBargraphDetails($username,$teamid,$startdate,$enddate){
	$getbargraphdetails = array();
	
	$countteamid = "SELECT count(*) as totalusers from users where team_id='".$teamid."' and is_active=1";
	$countresults =  $this->db->query($countteamid);
    $countdetails ='';
	$totalhours='';
	foreach($countresults->result('array') as $records){
		  $countdetails = $records['totalusers'];
	}
    $totalhrs = round(($countdetails*8.5),2); 
    //Attendance details for cureent users
	$attendance = array();
	for($currentdate = strtotime($startdate);$currentdate <= strtotime($enddate); $currentdate += (86400)){
		$a = date('Y-m-d',$currentdate);
		$attendance[] = $a;
			  
		}
    
     //Attendance Team id 
	$getcountdetails = array();
    for($i=0;$i<count($attendance);$i++){
	   $teamidetails = "SELECT count(ua.is_absent) as totalusers,date('".$attendance[$i]."') as planned_date from user_attendence ua where ua.team_id='".$teamid."'and date('".$attendance[$i]."') BETWEEN start_date and end_date";
	   $db_query = $this->db->query($teamidetails);

	   foreach($db_query->result('array') as $records){
		$getcountdetails[$attendance[$i]] = array(
			'teamcount'=>$records['totalusers'],
			'planneddate'=>$records['planned_date']
		);
	   }
	}
   
	
	$userabsent = array();		
    for($i=0;$i<count($attendance);$i++){
		
		$db ="SELECT coalesce(user_id,'".$username."') as user_id,count(start_date) as absentdetails,date('".$attendance[$i]."') as planned_date from user_attendence where user_id='".$username."' and date('".$attendance[$i]."') BETWEEN start_date AND end_date";
		
		$db_query = $this->db->query($db);
	
		foreach($db_query->result('array') as $records){
             $userabsent[$attendance[$i]] = array(
				 'user_id'=>$records['user_id'],
				 'absentdetails'=>$records['absentdetails'],
		 		 'start_date'=>$records['planned_date']
		 	);
		 }
	}
	
	if($teamid != ''){
		$conditon1 ="and c.team_id='".$teamid."'";
		
		$teamcond1 = ",round('".$countdetails."'*8.5,2) as hoursperday";
		$selectcond1 = "c.team_id";
	}else{
		$conditon1 = '';
		$teamcond1 ='';
		$selectcond1='';
	}
	if($username != ''){
		$condition2 ="and c.user_id='".$username."'";
		$teamcond2 = ",round(COUNT(DISTINCT c.user_id)*8.5,2) as hoursperday";
		$selectcond2 = "c.user_id"; 
	    // $selectedoptions2 ="u.id,u.first_name, sum(case when c.status = 1 then 1 else 0 end) as completedtasks, sum(case when c.status <> 1 then 1 else 0 end) as pendingtasks,c.planned_date as date,round(SUM(estimated_time),2) as hours_planned";
	}else{
		$condition2 ='';
		$teamcond2 ='';
		$selectcond2='';
		// $selectedoptions2='';
	}
	
	
	 $dbfilter ="SELECT  '".$selectcond1."' '".$selectcond2."',sum(case when c.status = 1 then 1 else 0 end) as completedtasks, sum(case when c.status <> 1 then 1 else 0 end) as pendingtasks,sum(case when c.status = 1 then 1 when c.status = 0 then 1 else 0 end) as totaltasks,round(sum(case when c.status = 1 then estimated_time else 0 end),2) as completedhours,round(sum(case when c.status = 0 then estimated_time else 0 end),2) as pendinghours,c.planned_date as date,round(SUM(estimated_time),2) as hours_planned $teamcond1 $teamcond2 from checklist c inner join users u on u.id = c.user_id $condition2 $conditon1  AND c.planned_date BETWEEN '".$startdate."' AND '".$enddate."' GROUP by c.planned_date,'".$selectcond1."' '".$selectcond2."'"; 
    // echo $dbfilter;exit;
	$countresults =  $this->db->query($dbfilter);
	 $userbargraphdeatails = array();
	 $totalhoursday = array();
	 $totaltask = array();
	 $totalcompletedtasks = array();
	 $totalplannedhours = array();
	 $color1='rgba(98, 227, 169,0.54)';
	 $color2 ='rgba(98, 227, 169,0.54)';
	 $bgcolor ='';
	 $cal='';
	 $gethoursperday = '';
	 foreach($countresults->result('array') as $records){
		 // echo $getcountdetails[$records["date"]]["teamcount"];
		  if($teamid !=''){
			  $bgcolor =($getcountdetails[$records["date"]]["teamcount"] == 0) ? $color1 : $color2;
			   $cal = $countdetails - $getcountdetails[$records["date"]]["teamcount"];
			  $gethoursperday = round($cal*8.5,2);
		  }else{
			 $bgcolor =($userabsent[$records["date"]]["absentdetails"] == 1) ? $color2: $color1;
			 $gethoursperday = $records["hoursperday"];
			//  $gethoursperday = ($userabsent[$records["date"]]["absentdetails"] == 1) ? '0.0':$records["hoursperday"];
		  }
		  $userbargraphdeatails[] = array(
                "completedtasks"=>$records["completedtasks"],
				"pendingtasks"=>isset($records["pendingtasks"]) ? $records["pendingtasks"] : '0',
				"planneddate"=>$records["date"],
				"absentdetails"=>isset($userabsent[$records["date"]]["absentdetails"]) ? $userabsent[$records["date"]]["absentdetails"] : '0',
				"hours_planned"=>isset($records["hours_planned"]) ? $records["hours_planned"] : '0.0',
				"completed_hours"=>isset($records["completedhours"]) ? $records["completedhours"] : '0.0',
				"backgroundColor"=>$bgcolor,
				"pending_hours"=>$records["pendinghours"] + $records["completedhours"],
				"hoursperday"=>$gethoursperday,
				//"hoursperday"=>isset($records["hoursperday"]) ? $records["hoursperday"]:'0.0',
				"availablehours"=>($records["hours_planned"] < $records["hoursperday"]) ? '0':  abs(($records["hoursperday"]-$records["hours_planned"]))
			 
		  );		  
           $totalhoursday[]= $gethoursperday;
		   $totaltask[] = $records["totaltasks"];
		   $totalplannedhours[] = $records["pendinghours"] + $records["completedhours"];
		   $totalcompletedtasks[] = $records["completedtasks"];
		   
	 }
    

	 
	$bargraphdetails_arr = array("userbargraphdetails"=>$userbargraphdeatails,"CompletedTasks"=>array_sum($totalcompletedtasks),"totaltask"=>array_sum($totaltask),"totalhoursday"=>array_sum($totalhoursday),"plannedhours"=>array_sum($totalplannedhours));
   	 //return $bargraphdetails_arr;

	 if(!empty($bargraphdetails_arr)){
 	   return $bargraphdetails_arr;
      }
	

}
		public function addUserJiraAcessKeys($user_id,$jira_access_key){
			$sql = "INSERT INTO user_jira_access_keys(user_id,jira_access_key)VALUES($user_id,'".$jira_access_key."')";
			$res = $this->db->query($sql);
			$msg='';
				if($res == 1){
					$msg= "Access key has been Updated";
				 }else{
					$msg= "problem in adding";
				 }
			 return $msg;
		
		  }

		public function getJiraAccessKey(){
		$access_data="SELECT jira_access_key
			FROM user_jira_access_keys";
			
		$result= $this->db->query($access_data)->row_array();
	return $result;
}


/** New jira code */
/** Get Time details with Jira ticket No for Copy Funtionality */
public function getJiraTicket($ticketNo){
	
	// $user_id=isset($_POST['user_id'])?$_POST['user_id']:1;
	//$ticket_no=isset($_POST['ticket_no'])?$_POST['ticket_no']:'0';
	$jiraUrl="https://jira.xpaas.lenovo.com/rest/api/latest/issue/$ticketNo";
	$getJiraKeys = $this->getJiraAccessKey();
	$jira_user_access_key = $getJiraKeys['jira_access_key'];
	$apiToken=$jira_user_access_key;
	$userId='uk2';
	 $jql = 'fields=issuetype,timetracking,status';
	 // URL with JQL query parameters
	 $requestUrl = "$jiraUrl?$jql";
	
	 $ch = curl_init($requestUrl);
	
	//  // Set cURL options
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
	
  
	// // Execute cURL session
	 $response = curl_exec($ch);

	// // Check for errors
	if(curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	} else {
		// HTTP status code
		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo "Status options";
		// echo $statusCode;exit;
		if ($statusCode == 200) {
			$decodedResponse = json_decode($response);
		// Output the response (for demonstration)
        //Added New Color Code
        //  $colorcodejira = array('default'=>'#6787F1','yellow'=>'#e98224','green'=>'green');
		 $colorcodejira = array('default'=>'#6787F1','inprogress'=>'#e98224','success'=>'green');
         $colorcode = $colorcodejira[$decodedResponse->fields->status->statusCategory->colorName];
		 $colorstatus   = $colorcode;
		 $ticketstatus  = $decodedResponse->fields->status->name; 
		//End Added new color code
		// Access issuetype object and retrieve the name field
		$issueTypeName = $decodedResponse->fields->issuetype->name;
		$originalEstimate =isset($decodedResponse->fields->timetracking->originalEstimate) ? $decodedResponse->fields->timetracking->originalEstimate : 0.0;
		$remainingEstimate = $decodedResponse->fields->timetracking->remainingEstimate;
		$timeSpent=isset($decodedResponse->fields->timetracking->timeSpent) ? $decodedResponse->fields->timetracking->timeSpent : '0h';
		$timespentestimate = ($timeSpent === 'null') ? '0h' : $timeSpent;
		$msg = ['task_category'=>$issueTypeName,'originalEstimate'=>$originalEstimate,'remainingEstimate'=>$timeSpent,'statuscode'=>$statusCode,'timespent'=>$timeSpent,'ticketstatus'=>$ticketstatus,'colorcode'=>$colorstatus]; 
		echo json_encode($msg);
		} else {
			echo 'Error: ' . $statusCode;
		}
		return $msg;
	}
	// Close cURL session
	curl_close($ch);  
}

//get  reports by filters
function reportByfilter($user_id,$ticket_no,$from_date,$to_date,$status,$task_type){
		$report_data="select task_title,ticket_no,
					IF(task_type=1, 'Task', 'Meetings') as task_type,
					IF(status=0, 'In Progress', 'Completed') as task_status,
					IF(is_private=0, 'No', 'Yes') as task_privacy,
					planned_date,estimated_time as spent_time
					from checklist where user_id=$user_id AND planned_date BETWEEN '$from_date' AND '$to_date'";
			$report_summary="SELECT SUM(estimated_time) as total_spent from checklist where user_id=$user_id AND planned_date BETWEEN '$from_date' AND '$to_date'";
					if($task_type!=''){
						$report_data.="AND task_type='$task_type'";
						$report_summary.="AND task_type='$task_type'";
					}
					if($status!=''){
						$report_data.="AND status='$status'";
						$report_summary.="AND status='$status'";
					}
					if($ticket_no!=''){
						$report_data.="AND ticket_no='$ticket_no'";
						$report_summary.="AND ticket_no='$ticket_no'";
					}
					$result= $this->db->query($report_data)->result_array();
					$result1= $this->db->query($report_summary)->row_array('total_spent');
					//print_r($result1['total_spent']);die;
			
			if(!empty($result)):
				$msg = ['status'=>true,"total_items"=>count($result),'total_time_spent'=>$result1['total_spent'],"report_data"=>$result];
			else:
				$msg = ['status'=>false,'msg'=>'No data found'];
			endif;
			return $msg;
	}
}

