<?php
namespace App\Http\Model; 
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Hash;

class UserLogin extends Model{
	
	public function UserAuthenticate($userDetails){
		
		$username  = $userDetails['username'];
		$password  = $userDetails['password'];
		
		$data = DB::Select("SELECT * FROM User WHERE username = '".$username."' AND password = '".$password."'");
		
		$returnarray = array();
		
		if(count($data) == 0) {
			
			$returnarray['is_authenticate'] = "false";
			$returnarray['is_admin'] 		= "";
			$returnarray['accesskey'] 		= "";
			
		}else if(count($data) > 0){
			$returnarray['is_authenticate'] = "true";
			$returnarray['is_admin'] 		= $data[0]->admin;
			$returnarray['accesskey'] 		= $this->generateAccessKey($data[0]->id);
			
			
			$userdetails['id'] 				= $data[0]->id;
			$userdetails['username'] 		= $data[0]->username;
			$userdetails['useremail'] 		= $data[0]->useremail;
			$userdetails['mobilenumber'] 	= $data[0]->mobilenumber;
			
			$returnarray['userdetails']  =   $userdetails;
			
			DB::table('User')->where('id',$data[0]->id)->update(['accesskey'=>$returnarray['accesskey'] ]);
		}
		
		return $returnarray;
		
	}
	
	public function generateAccessKey($loginuserid){
		date_default_timezone_set('Asia/Calcutta');
		$date = date('Y-m-d H:i:s', time());
		$dateval=Hash::make($date);
		$datevaluserid_val=Hash::make($loginuserid);
		$accesskey=$dateval.'_'.$datevaluserid_val;
		return $accesskey;
	}
	
	public function CheckAuthenticateUser($accessKey){
		
		$sql  = DB::Select("SELECT * FROM user WHERE accesskey = '".$accessKey."'");
		
		if(count($sql)) {
			$status  = "true";
		}else{
			$status  = "false";
		}
		return $status;
	}
	
	
	
}

?>