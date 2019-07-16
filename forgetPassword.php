<?php
	include "includes/initialize.php";
	if ($isLogin == true){
		header("location:index.php");
		exit();
	}
		//echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
	include "header.php";
?>
		<h2 class="forget-pwd-title">Forgotten Password?</h2>
	<h2 class="forget-pwd-title">Find Your Account</h2>
	
	<form class="login-form" method="post" action="forgetPassword.php">
		
			<h5>Please enter your email address and username to get a new password via email.</h5>
			<span id="invalidInput"></span>
			
        
        
         <div class="login-input-container">
				<input type="text" name="email" autocomplete="off" required/>
            	<label for="email" class="login-form-label"><span class="login-form-label-span">Email: </span> </label>
            </div>
            <br>
                <label id="invalidEmail"></label>
			<br>
            <br>
        
                 <div class="login-input-container">
				<input type="text" name="username" autocomplete="off" required/>
            	<label for="username" class="login-form-label"><span class="login-form-label-span">Username: </span> </label>
            </div>
                <br>
				<label id="invalidUsername"></label>
                <br>
                <br>
		&nbsp &nbsp <input id="button" type="submit" value="Submit" name="submit">
	</form>
<?php
	include "footer.php";
?>

<?php
	if (isset($_POST['submit'])){
		$email = $_POST['email'];
		$username = $_POST['username'];
		$check = true;
		
		if (empty($email)){
			echo "<script type='text/javascript'> document.getElementById('invalidEmail').innerHTML = 'Email cannot be empty';</script>";
			$check = false;
		}
		if (empty($username)){
			echo "<script type='text/javascript'> document.getElementById('invalidUsername').innerHTML = 'Username cannot be empty';</script>";
			$check = false;
		}
		if ($check){
			include 'includes/config.php';
			$sql = "SELECT * FROM user WHERE username=:username AND email=:email";
			$stmt = $conn -> prepare($sql);
			$stmt -> execute([':username' => $username, ':email' => $email]);
			
			if ($stmt -> rowCount() > 0){
				

				$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				$password = array(); //remember to declare $pass as an array
				$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
				for ($i = 0; $i < 10; $i++) {
					$password[] = $alphabet[rand(0, $alphaLength)];
				}
				$newPassword = implode ($password);
				
				$encrypt = md5($newPassword);
				
				$sql1 = "UPDATE user SET password = '$encrypt' WHERE email='$email'";
				$query = $conn->prepare($sql1);
				$query->execute();
				
				require 'php-mailer-master/PHPMailerAutoload.php';
				$mail = new PHPMailer;
				
				$mail->Timeout = 30;									// request time
				$mail->isSMTP();                                      	// Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com'; 					  	// Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               	// Enable SMTP authentication
				$mail->Username = 'group2.inti.php@gmail.com';        	// SMTP username
				$mail->Password = '1234@5678';                       	// SMTP password
				//$mail->SMTPSecure = 'tls';                         	// Enable TLS encryption, ssl also accepted
				$mail->Port = 25;  									  	// TCP port to connect to

				$mail->setFrom('group2.inti.php@gmail.com','Educational Portal <no-reply>');
				$mail->addAddress($email);  
				$mail->isHTML(true);                                  	// Set email format to HTML

				$mail->Subject = 'New Password!';
				$mail->Body    = 'Dear '.$username.',<br> <br> 
					Your account\'s password has been changed.<br>Now your current password is '.$newPassword.'
				<br><br>';
				
				
				
				if($mail->send()) {
					echo "<script type='text/javascript'> alert('Email has been sent to your email account. Please check your email.'); </script>";
					//header('login.php');
					echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
					
				} else {
					//header('failSent.php');
					$_SESSION['text'] = $mail -> ErrorInfo;
					echo "<script type='text/javascript'> document.location = 'failSent.php'; </script>";
				}
				
			}
			else
			{
				echo "<script type='text/javascript'> document.getElementById('invalidInput').innerHTML = 'The email and username that you\'ve entered doesn\'t match any account.';</script>";

			}
		}
		
	}


?>