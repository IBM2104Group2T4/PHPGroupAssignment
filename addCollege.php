<?php
	include "includes/initialize.php";
	if ($_SESSION['isLogin'] == false){
		header("Location:index.php");
		exit();
	}
	include "header.php";
	if (isset($_POST['submit'])){
		include "includes/config.php";
		error_reporting(0);
		$name = $_POST['name'];
		$picture = $_FILES['picturePath'];
		$description = $_POST['description'];
		$courseAvailable = $_POST['courseAvailable'];
		$state = $_POST['state'];
		$address = $_POST['address'];
		$address1 = $_POST['address1'];
		$contactNumber = $_POST['contactNumber'];
		$officeHours = $_POST['officeHours'];
		$officeHours = implode(' - ', $officeHours);
		$check = true;
		
		$sql = "SELECT name from college";
		$query = $conn -> prepare($sql);
		$query->execute();
		$results=$query->fetchAll(PDO::FETCH_OBJ);
		if($query->rowCount() > 0){
			foreach($results as $result){
				if ($name == $result->name){
					$message = "The college name already exists.";
					$check = false;
				}
			}
		}
		if (empty($name)){
			$message = "College name cannot be empty.";
			$check = false;
		}
		
		$pictureName = $picture['name'];
		$pictureNewName = "";
		$pictureTmpName = $picture['tmp_name'];
		$pictureError = $picture['error'];
		$pictureSize = $picture['size'];
		$pictureExplode = explode('.', $pictureName);
		$pictureExt = strtolower(end($pictureExplode));
		$ImageExt = array('png', 'jpg', 'jpeg');
		
		if ($pictureError !== 4){
			if (in_array($pictureExt, $ImageExt)){
				if ($pictureSize <= 2000000){
					if ($pictureError == 0){
					$pictureNewName = uniqid('', true).".".$pictureExt;
					$picturePath = 'College_Image/'.$pictureNewName;
					move_uploaded_file($pictureTmpName, $picturePath);
					}
					else{
					$uploadError = array(
					1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
					2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
					3 => 'The uploaded file was only partially uploaded',
					4 => 'No file was uploaded',
					6 => 'Missing a temporary folder',
					7 => 'Failed to write file to disk.',
					8 => 'A PHP extension stopped the file upload.');
					
					$message1 = "$uploadError[$pictureError]";
					$check = false;
					}
					
				}
				else{
					$message1 = "This image is too big";
					$check = false;
				}
			}
			else{
				$message1 = "This is not an image";
				$check = false;
			}
		}
		else{
			$message1 = "No file was uploaded";
			$check = false;
		}
			
		if (empty($description)){
			$message2 = "College description cannot be empty.";
			$check = false;
		}
		if (empty($courseAvailable)){
			$message3 = "Course available cannot be empty.";
			$check = false;
		}
		if (empty($state)){
			$message4 = "Please select one state.";
			$check = false;
		}
		if (empty($address[0])){
			$message5 = "House Number cannnot be empty.";
			$check = false;
		}
		if (empty($contactNumber)){
			$message6 = "Contact number cannot be empty.";
			$check = false;
		}
		else if (!preg_match("/^[0-9]{2,3}-[0-9]{7,8}$/", $contactNumber))
		{
			$message6 = "Contact number not in correct format";
			$check = false;	
		}
		if (empty($officeHours)){
			$message7 = "Office hour cannot be empty.";
			$check = false;
		}
		if (empty($address[1])){
			$message11 = "Street cannot be empty";
		}
		if (empty($address1[0])){
			$message9 = "Postcode cannot be empty";
		}
		else if (!is_numeric($address1[1])){
			$message9 = "Postcode can only numeric";
		}
		if (empty($address1[1])){
			$message10 = "City cannot be empty";
		}
		if ($check){
			$address = implode(', ',$address);
			$address1 = implode(', ',$address1);
			$address .= "\n$address1";
			$sql1="INSERT INTO college(name,picture,description,course,state,address,contactNumber,officeHours) VALUES('$name','$pictureNewName','$description','$courseAvailable','$state','$address','$contactNumber','$officeHours')";
			$query1 = $conn->prepare($sql1);
			$query1->execute();
			$message8 = "College successfully added.";
		}
	}
?>
	<h2 class="login-word">Add College</h2>
	
	<form class="login-form" method="post" action="addCollege.php" enctype="multipart/form-data">
		
				<?php if (isset($_POST['submit'])){
							echo '<span style="color:red">'.$message8.'</span>';			
						}
				?>
		          
                  <div class="login-input-container">
				<input type="text" name="name" autocomplete="off" required/>
            	<label for="name" class="login-form-label"><span class="login-form-label-span">Name:</span> </label>
            </div>
                <br>
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message.'</span>';			
				}
				?>
			     <br>
        
                 
		
				Picture:
				<input type="file" name="picturePath">
			     <?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message1.'</span>';			
				}
				?>
                <br>
                <br>
        
                 
			
				Description:
                <br>
				<textarea class="add-description" type="text" name="description" rows="6" cols="60" maxlength="500"></textarea>
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message2.'</span>';			
				}
				?>
                <br>
                <br><br>
        
                <div class="login-input-container">
				<input type="text" name="courseAvailable" autocomplete="off" required/>
            	<label for="courseAvailable" class="login-form-label"><span class="login-form-label-span">Course Available:</span> </label>
            </div>
                <br>
			
				
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message3.'</span>';			
				}
				?>
                <br><br>
			
				State:
				<br>

				<select class="time-select" name="state">
					<?php
						$states = array("Penang", "Kedah", "Kelantan", "Negeri Sembilan", "Kuala Lumpur", "Perak", "Perlis", "Sabah", "Sarawak", "Terengganu", "Melacca", "Selangor", "Pahang");
						sort($states);
						foreach($states as $state){
							echo "<option value=\"$state\">$state</option>";
						}
					?>
				</select>
				
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message4.'</span>';			
				}
				?>
			     <br><br>
                <br>
			
				<u>Address</u>
			     <br>
				
                  <div class="login-input-container">
				<input type="text" name="address[]" autocomplete="off" required/>
            	<label for="address[]" class="login-form-label"><span class="login-form-label-span">House No.:</span> </label>
            </div>
			     <br>
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message5.'</span>';			
				}
				?>
				<br>
				  <div class="login-input-container">
				<input type="text" name="address[]" autocomplete="off" required/>
            	<label for="address[]" class="login-form-label"><span class="login-form-label-span">Street Name:</span> </label>
            </div>
				<br>
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message11.'</span>';			
				}
				?>
				<br>
                  <div class="login-input-container">
				<input type="text" name="address1[]" autocomplete="off" required/>
            	<label for="address1[]" class="login-form-label"><span class="login-form-label-span">Postcode:</span> </label>
            </div>
                <br>
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message9.'</span>';			
				}
				?>
				<br>
				  <div class="login-input-container">
				<input type="text" name="address1[]" autocomplete="off" required/>
            	<label for="address1[]" class="login-form-label"><span class="login-form-label-span">City:</span> </label>
            </div>
			     <br>
        
			
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message10.'</span>';			
				}
				?>
                <br><br>

			       <div class="login-input-container">
				<input type="text" name="contactNumber" autocomplete="off" required/>
            	<label for="contactNumber" class="login-form-label"><span class="login-form-label-span">Contact Number:</span> </label>
            </div>
				<br>
				
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message6.'</span>';			
				}
				?>
                <br><br>
			
			
				<u>Office Hours</u>
                <br>
			
			
				Opening time:
		      <br>		
        
				<select class="time-select" name = "officeHours[]">
				<option value = "8AM">8AM</option>
				<option value = "8.30AM">8.30AM</option>
				<option value = "9AM">9AM</option>
				<option value = "9.30AM">9.30AM</option>
				<option value = "10AM">10AM</option>
				</select>
                <br>


				Close time:
				<br>
        
				<select class="time-select" name = "officeHours[]">
				<option value = "5PM">5PM</option>
				<option value = "5.30PM">5.30PM</option>
				<option value = "6PM">6PM</option>
				<option value = "6.30PM">6.30PM</option>
				<option value = "7PM">7PM</option>
				<option value = "7.30PM">7.30PM</option>
				</select>
				<br>
        
				<?php if (isset($_POST['submit'])){
					echo '<span style="color:red">'.$message7.'</span>';			
				}
				?>
			     <br><br>
                <br>
                <br>
		
		&nbsp &nbsp <input id="button" type="submit" value="Add College" name="submit">
	</form>
<?php
	include "footer.php";
?>
