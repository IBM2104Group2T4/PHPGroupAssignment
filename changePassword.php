<?php
	include "includes/initialize.php";
	if ($_SESSION['isLogin'] == false){
		header("Location:index.php");
		exit();
	}
	include "header.php";
	error_reporting(0);
	if (isset($_POST['submit'])){
		include "includes/config.php";
		$password = $_SESSION['password'];
		$username = $_SESSION['username'];
		$currentPassword = $_POST['currentPassword'];
		$newPassword = $_POST['newPassword'];
		$confirmNewPassword = $_POST['confirmNewPassword'];
		$message = "";
		$message1 = "";
		$message2 = "";
		$message3 = "";
		$valid = true;
		$valid1=true;
		if (empty($currentPassword)){
			$message = "Current password cannot be empty.<br>";
			$valid = false;
		}
		if (empty($newPassword)){
			$message1 = "New password cannot be empty.<br>";
			$valid = false;
		}
		if (empty($confirmNewPassword)){
			$message2 = "Confirm new password cannot be empty.<br>";
			$valid = false;
		}
		if ($valid){
			$currentPassword = md5($currentPassword);
			if ($password!=$currentPassword){
				$message = "Old password is incorrect.<br>";
				$valid1 = false;
			}
			if ($newPassword!=$confirmNewPassword){
				$message2 = "New password and confirm password must be same.<br>";
				$valid1 = false;
			}
			if (strlen($newPassword) < 8 && strlen($confirmNewPassword)<8 && !empty($newPassword) && !empty($confirmNewPassword)){
				$message1 = "New password must be more than 8 characters.<br>";
				$valid1 = false;
			}
		}
		if($valid && $valid1){
			$newPassword = md5($newPassword);
			$confirmNewPassword = md5($confirmNewPassword);
			if ($password==$currentPassword && $newPassword==$confirmNewPassword){
				$sql="update user set password='$newPassword' where username='$username'";
				$query = $conn->prepare($sql);
				$query->execute();
				$message3="Your Password succesfully changed.";
				$_SESSION['password'] = $newPassword;
			}
		}
	}
?>
	<h2 class="login-word">Change Password</h2>
	
	<form class="login-form" method="post" action="changePassword.php">
		      
				<?php if (isset($_POST['submit'])){
							echo '<span style="color:red">'.$message3.'</span>';			
						}
				?>
	           
        
         <div class="login-input-container">
				<input type="password" name="currentPassword" autocomplete="off" required/>
            	<label for="currentPassword" class="login-form-label"><span class="login-form-label-span">Current Password:</span> </label>
            </div>
        
				<br>
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message.'</span>';			
				}
				?>
                <br>
        
		 <div class="login-input-container">
				<input type="password" name="newPassword" autocomplete="off" required/>
            	<label for="newPassword" class="login-form-label"><span class="login-form-label-span">New Password:</span> </label>
            </div>
			
				<br>
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message1.'</span>';			
				}
				?>
                <br>
			
         <div class="login-input-container">
				<input type="password" name="confirmNewPassword" autocomplete="off" required/>
            	<label for="confirmPassword" class="login-form-label"><span class="login-form-label-span">Confirm Password:</span> </label>
            </div>
				
                <br>
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message2.'</span>';			
				}
				?>
                <br>
			
		
		&nbsp &nbsp <input id="button" type="submit" value="Submit" name="submit">
	</form>
<?php
	include "footer.php";
?>
