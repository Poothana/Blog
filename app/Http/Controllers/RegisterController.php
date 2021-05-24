<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Http\Model\userRegister;

class RegisterController extends Controller{
	
	public function UserCreate(Request $request){
		
		(new userRegister())->CreateUSer($request->all());
		
		$data['status'] ="true";
		echo json_encode($data);
	}
}

?>