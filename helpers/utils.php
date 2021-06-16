<?php


class Utils{
	
	public static function deleteSession($name){
		if(isset($_SESSION[$name])){
			$_SESSION[$name] = null;
			unset($_SESSION[$name]);
		}
		
		return $name;
	}
	
	public static function isAdmin(){
		if(!isset($_SESSION['admin'])){
			header("Location:".base_url.'usuario/login');
		}else{
			return true;
		}
	}

	public static function NoentrarAdmin(){
		if(isset($_SESSION['admin'])){
			header('location:'.base_url.'Admin/ctrAdmin');
		}else{
			true;
		}
	}

	


	
	
	
}










?>