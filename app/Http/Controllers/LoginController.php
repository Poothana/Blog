<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Http\Model\userRegister;
use App\Http\Model\UserLogin;

class LoginController extends Controller{
	
	public function UserLogin(Request $request){
		
		$userLogin = (new UserLogin())->UserAuthenticate($request->all());
		echo json_encode($userLogin);
		
	}
}

?>