<?php
namespace App\Http\Model; 
use Illuminate\Database\Eloquent\Model;
use DB;

class userRegister extends Model{
	
	public function CreateUSer($userDetails){
		
		$data['username'] 		= $userDetails['username'];
		$data['useremail']		= $userDetails['useremail'];
		$data['mobilenumber'] 	= $userDetails['mobilenumber'];
		$data['admin'] 			= $userDetails['admin'];
		$data['password'] 		= $userDetails['password'];
		
		DB::table('User')->insert($data);
		
	}
	
	
	
}

?>