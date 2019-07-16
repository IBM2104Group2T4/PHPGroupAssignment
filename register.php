<?php
	include "includes/initialize.php";
	if ($isLogin == true){
		header("location:index.php");
		exit();
	}
		//echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
	include"header.php";
?>
	<form class="login-form" action="register.php" method="post">
        <h1>Registration</h1>
			     
        
            <div class="login-input-container">
				<input id="usn" type="text" name="username" placeholder="" autocomplete="off" required/>
            	<label for="username" class="login-form-label"><span class="login-form-label-span">Username: </span> </label>
            </div>
			     <br>
                <label id="invalidUsername"></label>
                <br>
                <br>
        
        <script>
            
            document.getElementById('usn').addEventListener("focusin",usernamePlaceholder);
            
            document.getElementById('usn').addEventListener("focusout",placeholder);
            
            function usernamePlaceholder(){
                 document.getElementById('usn').placeholder = "E.g. John Lee";
            }
            
            function placeholder(){
                 document.getElementById('usn').placeholder = "";
            }
        </script>
        
        
                <div class="login-input-container">
				<input id="eml" type="text" name="email" placeholder="" autocomplete="off" required/>
            	<label for="email" class="login-form-label"><span class="login-form-label-span">Email: </span> </label>
            </div>
			     <br>
                <label id="invalidEmail"></label>
                <br>
                <br>
        
        
        <script>
            
            document.getElementById('eml').addEventListener("focusin",emailPlaceholder);
            
            document.getElementById('eml').addEventListener("focusout",placeholder);
            
            function emailPlaceholder(){
                 document.getElementById('eml').placeholder = "E.g. abc@gmail.com";
            }
            
            function placeholder(){
                 document.getElementById('eml').placeholder = "";
            }
        </script>
        
        
        
                <div class="login-input-container">
				<input id="pwd" type="password" name="password" placeholder="" autocomplete="off" required/>
            	<label for="password" class="login-form-label"><span class="login-form-label-span">Password: </span></label>
            </div>
			     <br>
                <label id="invalidPassword"></label>
                <br>
                <br>
        
        
         <script>
            
            document.getElementById('pwd').addEventListener("focusin",pwdPlaceholder);
            
            document.getElementById('pwd').addEventListener("focusout",placeholder);
            
            function pwdPlaceholder(){
                 document.getElementById('pwd').placeholder = "At least 8 characters";
            }
            
            function placeholder(){
                 document.getElementById('pwd').placeholder = "";
            }
        </script>
        
        
                <div class="login-input-container">
				<input id="cpwd" type="password" name="password2" placeholder="" autocomplete="off" required/>
            	<label for="password2" class="login-form-label"><span class="login-form-label-span">Confirm Password: </span> </label>
            </div>
			     <br>
                <label id="invalidPassword2"></label>
                <br>
                <br>
        
         <script>
            
            document.getElementById('cpwd').addEventListener("focusin",pwdPlaceholder);
            
            document.getElementById('cpwd').addEventListener("focusout",placeholder);
            
            function pwdPlaceholder(){
                 document.getElementById('cpwd').placeholder = "At least 8 characters";
            }
            
            function placeholder(){
                 document.getElementById('cpwd').placeholder = "";
            }
        </script>
        
        
			
			
				Gender:
                <br>
				<input id="gender-radio" type="radio" name="gender" value="M">Male
					<input id="gender-radio" type="radio" name="gender" value="F">Female
                <br>
				<label id="invalidGender"></label>
                <br>
                <br>
                
        
                

				State:
				
					<select class="time-select" name="state">
						<?php
							$states = array("Penang", "Kedah", "Kelantan", "Negeri Sembilan", "Kuala Lumpur", "Perak", "Perlis", "Sabah", "Sarawak", "Terengganu", "Melacca", "Selangor", "Pahang");
							sort($states);
							foreach($states as $state){
								echo "<option value=\"$state\">$state</option>";
							}
						?>
					</select>
                    <br>
                    <br>
				
			     <div class="login-input-container">
				<input id="pn" type="text" name="phoneNo" placeholder="" autocomplete="off" required/>
            	<label for="phoneNo" class="login-form-label"><span class="login-form-label-span">Phone Number:</span> </label>
            </div>
			     <br>
                <label id="invalidPhoneNo"></label>
                <br>
                <br>
			
		<script>
            
            document.getElementById('pn').addEventListener("focusin",pwdPlaceholder);
            
            document.getElementById('pn').addEventListener("focusout",placeholder);
            
            function pwdPlaceholder(){
                 document.getElementById('pn').placeholder = "E.g. 012-3456789";
            }
            
            function placeholder(){
                 document.getElementById('pn').placeholder = "";
            }
        </script>
        
		
		<input id="button" type="submit" value="Submit" name="submit">
	</form>
			
<?php
	include "footer.php";
?>

<?php
	if(isset($_POST['submit'])){
		include ('includes/config.php');
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$gender = null;
		$state = $_POST['state'];
		$phoneNo = $_POST['phoneNo'];
		$valid = true;
		
		$sql = "SELECT username, email FROM user WHERE username=:username OR email=:email";
		$getResults = $conn -> prepare($sql);
		$getResults -> execute([':username' => $username, ':email' => $email]);
		$results = $getResults -> fetchAll(PDO::FETCH_OBJ);
		$row = $getResults -> rowCount();
		$i = 0;

		$getName = null;
		$getEmail = null;
		
		if ($row > 0){
			foreach ($results as $data){
				$getName[$i] = $data -> username;
				$getEmail[$i] = $data -> email;
				$i++;
			}
		}
		if (empty($username)){
			echo "<script type='text/javascript'> document.getElementById('invalidUsername').innerHTML = 'Username cannot be empty'; </script>";
			$valid = false;
		}
		else if ($row > 0){
			foreach ($getName as $name){
				if ($username == $name){
					echo "<script type='text/javascript'> document.getElementById('invalidUsername').innerHTML = 'The username has been taken.'; </script>";
					$valid = false;
				}
			}
		}
		
		if (empty($email)){
			echo "<script type='text/javascript'> document.getElementById('invalidEmail').innerHTML = 'Email cannot be empty'; </script>";
			$valid = false;
		}
		else if(substr($email, strlen($email) - 4) != '.com' || strpos($email, '@') === false){
			echo "<script type='text/javascript'> document.getElementById('invalidEmail').innerHTML = 'Invalid email format'; </script>";
			$valid = false;
		}
		else if ($row > 0){
			foreach($getEmail as $mail){
				if ($email == $mail){
					echo "<script type='text/javascript'> document.getElementById('invalidEmail').innerHTML = 'The email has been taken'; </script>";
					$valid = false;
				}
			}
		}
		
		if (empty($password)){
			echo "<script type='text/javascript'> document.getElementById('invalidPassword').innerHTML = 'Password cannot be empty'; </script>";
			$valid = false;
		}
		else if (strlen($password) < 8){
			echo "<script type='text/javascript'> document.getElementById('invalidPassword').innerHTML = 'Use 8 characters or more for your password'; </script>";
		}
		
		if (empty($password2)){
			echo "<script type='text/javascript'> document.getElementById('invalidPassword2').innerHTML = 'Password cannot be empty'; </script>";
			$valid = false;			
		}
		else if ($password != $password2 && !empty($password) && !empty($password2)){
			echo "<script type='text/javascript'> document.getElementById('invalidPassword2').innerHTML = 'Those password didn\'t match'; </script>";
			$valid = false;
		}
		if (!isset($_POST['gender'])){
			echo "<script type='text/javascript'> document.getElementById('invalidGender').innerHTML = 'Gender cannot be empty'; </script>";
			$valid = false;
		}
		if (empty($phoneNo)){
			echo "<script type='text/javascript'> document.getElementById('invalidPhoneNo').innerHTML = 'Phone number cannot be empty'; </script>";
			$valid = false;			
		}
		else if (!preg_match("/^[0-9]{3}-[0-9]{7,8}$/", $phoneNo)){
			echo "<script type='text/javascript'> document.getElementById('invalidPhoneNo').innerHTML = 'Phone number format are not valid'; </script>";
			$valid = false;	
		}
		
		if ($valid)
		{
			
			$gender = $_POST['gender'];
			$password = md5($password);
			$status = 0;
			$admin = 0;
			$date=date('Y-m-d'); //to print current date in (yyyy-mm-dd);
						
			require 'php-mailer-master/PHPMailerAutoload.php';
			
			set_time_limit(120);
			$mail = new PHPMailer;
			$mail->Timeout = 30;									// request time
			$mail->isSMTP();                                    	// Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  						// Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               	// Enable SMTP authentication
			$mail->Username = 'group2.inti.php@gmail.com';          // SMTP username
			$mail->Password = '1234@5678';                          // SMTP password
			//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, ssl also accepted
			$mail->Port = 25;  										// TCP port to connect to
			$mail->setFrom('group2.inti.php@gmail.com','Educational Portal <no-reply>');
			$mail->addAddress($email); 
			$mail->isHTML(true);                                 	// Set email format to HTML
			$mail->Subject = 'Account Activation!';
			$mail->Body    = 'Dear '.$username.',<br> <br> 
			Please verify your account with the link given <br><br>
			<a href="http://localhost/Group2/activation.php?x='.$username.'&y='.$password.'"> Activate </a>';
				
				
			if($mail->send()) {
				$sql="INSERT INTO user(username,password,email,gender,state,status,date,phoneNo,admin) 
				      VALUES('$username','$password','$email','$gender','$state','$status','$date','$phoneNo', '$admin')";
				$setResult = $conn -> prepare($sql);
				$setResult -> execute();
				echo "<script type='text/javascript'> alert('Email has been sent. Please check your email to activate your account'); </script>";
				echo "<script type='text/javascript'> document.location = 'register.php'; </script>";
				
			}
			else {
				$_SESSION['text'] = $mail -> ErrorInfo;
				echo "<script type='text/javascript'> document.location = 'failSent.php'; </script>";
			}
			
		}
	}
	

?>
