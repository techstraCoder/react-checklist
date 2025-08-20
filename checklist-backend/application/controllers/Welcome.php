<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
	function __construct(){
		parent::__construct();
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
		$result=$this->users->getUsersData();
		if(!empty($result)){
				$msg = ['status'=>true,'userdata'=>$result,"count"=>count($result)];
			}else{
				$msg = ['status'=>false,'userdata'=>'No data Found'];
			}
		$final= json_encode($msg);
		print_r($final);
	}


	function getUsers()
	{
		header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		$result=$this->users->getUsersData();
		if(!empty($result)){
				$msg = ['status'=>true,'userdata'=>$result,"count"=>count($result)];
			}else{
				$msg = ['status'=>false,'userdata'=>'No data Found'];
			}
		$final= json_encode($msg);
		print_r($final);
	}

}
