<?php
	include "includes/initialize.php";
	if ($_SESSION['isLogin'] == false){
		header("Location:index.php");
		exit();
	}
	include "header.php";
	include "includes/config.php";
?>

<?php
		$message1 = "";
		$message2 = "";
		$message3 = "";
		$message4 = "";
		$message5 = "";
		$message6 = "";
		$message7 = "";
		$message8 = "";
		$message9 = "";
		
		$id = $_GET['id'];
		if (isset($_POST['submit']))
		{
			$check = true;
			$name = $_POST['name'];
			$description = $_POST['description'];
			$courseAvailable = $_POST['courseAvailable'];
			$state = $_POST['state'];
			$address = $_POST['address'];
			$address1 = $_POST['address1'];
			$contactNumber = $_POST['contactNumber'];
			$officeHours = $_POST['officeHours'];
			$officeHours = implode(' - ', $officeHours);
			$picturePath = $_FILES['picturePath'];
			
			if (empty($name))
			{
				$message1 = "College name cannot be empty";
				$check = false;
			}
			else
			{
				$sql = "SELECT * FROM college WHERE name='$name' AND id<>$id";
				$result = $conn -> prepare($sql);
				$result -> execute();
				if ($result -> rowCount() > 0)
				{
					$message1 = "College name has repeated";
					$check = false;
				}
			}
			
			if (empty($description))
			{
				$message3 = "Description cannot be empty";
				$check = false;
			}
			
			if (empty($courseAvailable))
			{
				$message4 = "Course cannot be empty";
				$check = false;
			}
			
			if (empty($address[0]))
			{
				$message5 = "House Number cannot be empty";
				$check = false;
			}
			if (empty($address[1]))
			{
				$message6 = "Street cannot be empty";
				$check = false;
			}
			if (empty($address1[0]))
			{
				$message7 = "Postcode cannot be empty";
				$check = false;
			}
			else if (!is_numeric($address1[0]))
			{
				$message7 = "Postcode can only contain numeric";
				$check = false;
			}
			if (empty($address1[1]))
			{
				$message8 = "City cannot be empty";
				$check = false;
			}
			if (empty($contactNumber))
			{
				$message9 = "Contact number cannot be empty";
				$check = false;
			}
			else if (!preg_match("/^[0-9]{2,3}-[0-9]{7,8}$/", $contactNumber))
			{
				$message9 = "Contact number not in correct format";
				$check = false;	
			}			
			$address = implode(', ',$address);
			$address1 = implode(', ',$address1);
			$address = "$address\n$address1";
			//file checking
			$imageNewName ="";
			$imageName = $picturePath['name'];
			$imageTmpName = $picturePath['tmp_name'];
			$imageSize = $picturePath['size'];
			$imageError = $picturePath['error'];
			$imageSplit = explode('.', $imageName);
			$imageExt = strtolower(end($imageSplit));
			$extArray = array('jpg', 'jpeg', 'png');
			if ($imageError !== 4)
			{
				if (in_array($imageExt, $extArray))
				{
					if ($imageError === 0)
					{
						if ($imageSize <= 2000000)
						{
							$imageNewName = uniqid("", true).".".$imageExt;
							$imageNewPath = "image/".$imageNewName;
							move_uploaded_file($imageTmpName, $imageNewPath);
						}
						else if ($check)
						{
							$sql2 = "UPDATE college SET name = '$name',picture = '$imageNewName',description = '$description',course = '$courseAvailable', state = '$state',address = '$address', contactNumber = '$contactNumber',officeHours = '$officeHours' WHERE id ='$id'";
							$query = $conn->prepare($sql2);
							$query->execute();
							echo "<script type='text/javascript'> alert('Successfully edited'); </script>";

						}
					}
					else
					{
						$message2 = "Something error when upload the image";
					}
				}
				else
				{
					$message2 = "This is not an image file";
				}
			}
			else
			{
				if($check){
					$sql2 = "UPDATE college SET name = '$name',description = '$description',course = '$courseAvailable', state = '$state',address = '$address', contactNumber = '$contactNumber',officeHours = '$officeHours' WHERE id ='$id'";
					$query = $conn->prepare($sql2);
					$query->execute();
					echo "<script type='text/javascript'> alert('Successfully edited'); </script>";
				}
			}
			
				
				
			
		}
		
		$sql= "SELECT * FROM college WHERE id = $id";
		$query = $conn->prepare($sql);
		$query->execute();
		$results = $query-> fetchALL(PDO::FETCH_OBJ);
		foreach($results as $result){
			$name = $result->name;
			$picture = $result->picture;
			$description =$result->description;
			
			$courseAvailable = $result->course;
			$state = $result->state;
			$address = nl2br($result->address);
			$contactNumber = $result->contactNumber;
			$officeHours = $result->officeHours;
		}
		
		$addressArr=  explode('<br />',$address);
		$addressArr1 = explode(', ', $addressArr[0], 2);
		$addressArr2 = explode(', ', $addressArr[1]);
		
		$officeHoursArr = explode(' - ', $officeHours);
		
		
		
?>

<body>
	<h2 class="login-word"><center>Edit College</center></h2>
	
	<br><br><br><br>
	
	<form class="login-form" method="post" action="editCollege.php?id=<?php echo "$id";?>" enctype="multipart/form-data">
	
	<div class="login-input-container">
			<input type="text" name="name" value="<?php echo htmlentities($name);?>" required/>
            <label for="name" class="login-form-label"><span class="login-form-label-span">Name:</span> </label>
    </div>
    <br>
	<span id="invalidName"><?php echo $message1;?></span>
	<br>
	<br>
	<img src="College_Image/<?php echo $picture;?>" alt="<?php echo $name;?>" width="300px" height ="300px">
	<br> 
	<br>
	<b>Picture: (Leave it if do not want to change the picture)</b><br>
	<input type="file" name="picturePath" value="<?php echo htmlentities($productPicture);?>"/><br><br>
	<span id="invalidFile"><?php echo $message2;?></span>
	<br><br>
	
	<u><b>Description:</b></u>
        <br>
		<textarea class="add-description" type="text" name="description" rows="6" cols="60" maxlength="500" ><?php echo htmlentities($description);?></textarea>
		<br>
	<br><span id="invalidDescription"><?php echo $message3;?></span><br><br>

	<div class="login-input-container">
		<input type="text" name="courseAvailable" value="<?php echo($courseAvailable);?>" required/>
        <label for="courseAvailable" class="login-form-label"><span class="login-form-label-span">Course Available:</span> </label>
    </div><br>
	<span id="invalidCourse"><?php echo $message4;?></span>
    <br><br>
	
	<u><b>States:</b></u>
				
		<select class="time-select" name="state">
		<?php
			$states = array("Penang", "Kedah", "Kelantan", "Negeri Sembilan", "Kuala Lumpur", "Perak", "Perlis", "Sabah", "Sarawak", "Terengganu", "Melacca", "Selangor", "Pahang");
			sort($states);
			foreach($states as $state1){
				echo "<option value=\"$state1\"";
				if ($state == $state1){
					echo " selected";
				}
				echo ">$state1</option>";
			}
		?>
		</select>

	<br><br> <br>

    <u><b>Address</b></u>
	
			     <br>
				
                <div class="login-input-container">
				<input type="text" name="address[]" value="<?php echo htmlentities($addressArr1[0]);?>" required/>
            	<label for="address[]" class="login-form-label"><span class="login-form-label-span">House No.:</span> </label>
            </div>
			     <br><span id="invalidHouseNo"><?php echo $message5;?></span>
				<br><br>
				  <div class="login-input-container">
				<input type="text" name="address[]" value="<?php echo htmlentities($addressArr1[1]);?>" required/>
            	<label for="address[]" class="login-form-label"><span class="login-form-label-span">Street Name:</span> </label>
            </div>
				<br><span id="invalidStreet"><?php echo $message6;?></span>
				<br><br>
                  <div class="login-input-container">
				<input type="text" name="address1[]" value="<?php echo htmlentities($addressArr2[0]);?>" required/>
            	<label for="address1[]" class="login-form-label"><span class="login-form-label-span">Postcode:</span> </label>
            </div>
                <br><span id="invalidPostcode"><?php echo $message7;?></span>
        <br><br>
				  <div class="login-input-container">
				<input type="text" name="address1[]" value="<?php echo htmlentities($addressArr2[1]);?>" required/>
            	<label for="address1[]" class="login-form-label"><span class="login-form-label-span">City:</span> </label>
            </div>
			     <br><span id="invalidCity"><?php echo $message8;?></span>
		
	<br><br>
		
	<div class="login-input-container">
			<input type="text" name="contactNumber" value="<?php echo htmlentities($contactNumber);?>" required/>
            <label for="contactNumber" class="login-form-label"><span class="login-form-label-span">Contact Number:</span> </label>
    </div>

    <br><span id="invalidContact"><?php echo $message9;?></span><br>
		<br>
	<u>Office Hours</u>
                <br>
			
			
				Opening time:
		        <br>		
				<select class="time-select" name = "officeHours[]">
				<?php
					$openHours = array("8AM","8.30AM","9AM","9.30AM","10AM");
					ksort($openHours);
					foreach($openHours as $openHour){
						echo "<option value = \"$openHour\" ";
						if($officeHoursArr [0]==$openHour){
							echo ' selected';
							
						}
						
						echo ">$openHour</option>";
					}
					
				?>
				</select>
                <br>
				
				
				Close time:
				<br>
        		<select class="time-select" name = "officeHours[]">
				<?php
					$closeHours = array("5PM","5.30PM","6PM","6.30PM","7PM","7.30PM");
					ksort($closeHours);
					foreach($closeHours as $closeHour){
						echo "<option value = \"$closeHour\" ";
						if($officeHoursArr[1]==$closeHour){
							echo ' selected';	
							
						}
						
						echo ">$closeHour</option>";
					}
				
				?>
				</select>
				<br>
				
	<br><br>
	
		&nbsp &nbsp <input id="button" type="submit" value="Edit College" name="submit">
	</form>
	
<?php

	include "footer.php";
?>
	
	
	
