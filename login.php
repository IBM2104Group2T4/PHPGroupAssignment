<?php
	include "includes/initialize.php";
	if ($isLogin == true){
		header("location:index.php");
		exit();
	}
		//echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
	include "header.php";
?>
		<h1 class="login-word">Login</h1>
	
		<form class="login-form" action="login.php" method="post" >
			
                <div id="invalidInput"></div>
            <br>
            
            <div class="login-input-container">
				<input type="text" name="username" autocomplete="off" required/>
            	<label for="username" class="login-form-label"><span class="login-form-label-span">Username:</span> </label>

			</div>

            <br>  
			<label id="invalidUsername"></label>
            <br>
            
            <br>
   
            <div class="login-input-container">
                <input type="password" name="password" autocomplete="off" required/>
            	<label for="password" class="login-form-label"><span class="login-form-label-span">Password:</span> </label>
            </div>

            <br>
			<label id="invalidPassword"></label>
            <br>
			&nbsp &nbsp <a style="color:blue;" href="forgetPassword.php"><u>Forget Password?</u></a><br><br>
			&nbsp &nbsp <input id="button" type="submit" name="login" value="Submit">
		</form>
<?php
	include "footer.php";
?>

<?php
include ("includes/config.php");
if (isset($_POST['login'])){
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$empty = false;
	if (empty($username)){
		echo "<script type='text/javascript'> document.getElementById('invalidUsername').innerHTML = 'Username cannot be empty'; </script>";
		$empty = true;
	}
	if ($password == md5('')){
		echo "<script type='text/javascript'> document.getElementById('invalidPassword').innerHTML = 'Password cannot be empty'; </script>";
		$empty = true;
	}
	if (!$empty){
		$sql ="SELECT * FROM user WHERE username=:username and password=:password";
		$query= $conn -> prepare($sql);
		$query-> execute([':username' => $username, ':password' => $password]);
		$results=$query->fetchAll(PDO::FETCH_OBJ);
		if($query->rowCount() > 0){
			foreach ($results as $result) {
				$status=$result->status;
				$_SESSION['id']=$result->ID;
				$_SESSION['username']=$result->username;
				$_SESSION['email']=$result->email;
				$_SESSION['gender']=$result->gender;
				$_SESSION['state']=$result->state;
				$_SESSION['phoneNo']=$result->phoneNo;
				$_SESSION['admin']=$result->admin;
				$_SESSION['password']=$result->password;
			}
			if ($status==1){
				$_SESSION['isLogin'] = true;
				//header("location:index.php");
				echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
				
			}
			else{
				echo "<script>alert('Your account is not activated. Please check your email');</script>";
			}
		}
		else {
			
			echo "<script type='text/javascript'> document.getElementById('invalidInput').innerHTML= 'The username that you\'ve entered doesn\'t match any account.'; </script>";
		}
	}
}
?>