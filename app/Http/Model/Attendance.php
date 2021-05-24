<?php
namespace App\Http\Model; 
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Hash;

class Attendance extends Model{
	
	public function UpdateCheckin($req_data){
		
		if($req_data['check_in_status'] == "1") {
			
			$data['userid'] 		= $req_data['userid'];
			$data['check_in'] 		= "1";
			$data['check_out'] 		= "0";
			$data['checkin_time'] 	= $req_data['check_in_time'];
			$data['checkout_time'] 	= $req_data['check_out_time'];
			
			$checkinid  =  DB::table('userattendance')->insertGetId($data);
			
				
			$data1['user_checkinid']	=	$checkinid;
			$data1['lattitude']			=	$req_data['lattitue'];
			$data1['longitude']			=	$req_data['longitude'];
			
			$checkinid  =  DB::table('user_trackLocation')->insert($data1);
			
			
			$returnArray = array();
			$returnArray['check_in'] = "1";
			$returnArray['check_out'] = "0";
			$returnArray['success_status'] = "true";
			
		}else if($req_data['check_out_status'] == "1"){
			
			$data['userid'] 		= $req_data['userid'];
			$data['check_in'] 		= "0";
			$data['check_out'] 		= "1";
			$data['checkin_time'] 	= $req_data['check_out_time'];
			$data['checkout_time'] 	= $req_data['check_out_time'];
			
			$checkinid  =  DB::table('userattendance')->insertGetId($data);
			
				
			$data1['user_checkinid']	=	$checkinid;
			$data1['lattitude']			=	$req_data['lattitue'];
			$data1['longitude']			=	$req_data['longitude'];
			
			$checkinid  =  DB::table('user_trackLocation')->insert($data1);
			
			$returnArray = array();
			$returnArray['check_in'] = "0";
			$returnArray['check_out'] = "1";
			$returnArray['success_status'] = "true";
			
		}
		
		return $returnArray;
		
	}
	
	
	public function TrackingAUserByPlace($req_data){
		
		$searchdate  =  $req_data['date'];
		$track_user_id  = $req_data['trackeduserid'];
		
		$data  =  "SELECT * FROM userattendance LEFT JOIN user_trackLocation ON user_trackLocation.user_checkinid = userattendance.checkin_id WHERE userattendance.userid = '".$track_user_id."' AND DATE_FORMAT(userattendance.checkin_time,'%Y-%m-%d') = '".trim($searchdate)."'";
		
		$sql = DB::select($data);
		
		$trackArray = array();
		if(count($sql)) {
			
			
			foreach($sql as $v) {
				
				$val = array();
				
				$val['lattitude'] =  $v->lattitude;
				$val['longitude'] =  $v->longitude;
				if($v->check_in == 1) {
					$val['status']    =   "check_in";
				}else if($v->check_out == 1) {
					$val['status']    =   "check_out";
				}
				$val['date']  = $searchdate;
				$trackArray[] = $val;
				
			}
		}
		
		if(count($trackArray) ==  1) $trackArray = $trackArray[0];
		
		return $trackArray;
	}
	
	
	
	
}

?>