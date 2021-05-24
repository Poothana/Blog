<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Http\Model\Attendance;
use App\Http\Model\UserLogin;

class CheckInController extends Controller{
	
	public function UpdateCheckinStatus(Request $request){
		
		
		$accesskey  = $request->get('accesskey');
		$loginstatus  = (new UserLogin())->CheckAuthenticateUser($accesskey);
		
		if($loginstatus == 'true') {
			$data  = (new Attendance())->UpdateCheckin($request->all());
			$data['login_status'] = "true";
			
		}else{
			$data['login_status'] = "false";
		}
		
		echo json_encode($data);
		
	}
	
	public function TrackingAUser(Request $request){
		
		$accesskey  = $request->get('accesskey');
		$loginstatus  = (new UserLogin())->CheckAuthenticateUser($accesskey);
		
		if($loginstatus == 'true') {
			$data['record']  = (new Attendance())->TrackingAUserByPlace($request->all());
			$data['login_status'] = "true";
		}else{
			$data['login_status'] = "false";
		}
		
		// print_R($data);
		 echo json_encode($data);
		
	}
}

?>