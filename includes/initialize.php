<?php
	SESSION_START();
	$isLogin = null;
	$email = null;
	$username = null;
	$gender = null;
	$state = null;
	$phoneNo = null;
	$admin = null;
	$password = null;
	
	if (isset($_SESSION['isLogin'])){
		$isLogin = $_SESSION['isLogin'];
		if ($isLogin == true){			
			$id = $_SESSION['id'];
			$email = $_SESSION['email'];
			$username = $_SESSION['username'];
			$gender = $_SESSION['gender'];
			$state = $_SESSION['state'];
			$phoneNo = $_SESSION['phoneNo'];
			$admin = $_SESSION['admin'];
			$password = $_SESSION['password'];
		}
		else{
			$isLogin = false;
		}
	}
	else{
		$isLogin = false;
	}
?>