<?php
	include "includes/initialize.php";
	include "header.php";
	include "includes/config.php";
	error_reporting(0);
	if (isset($_POST['submit'])){
		$college1 = $_POST['college1'];
		$college2 = $_POST['college2'];
		$check=false;
		$check1=false;
		$empty=true;
		
		if (empty($college1) && empty($college2)){
			$message = "Please enter two college<br>";
			$empty=false;
		}
		if(empty($college1)){
			$message = "Please enter first college<br>";
			$empty=false;
		}
		if(empty($college2)){
			$message = "Please enter second college<br>";
			$empty=false;
		}
		if($empty){
			if ($college1 != $college2){
				$sql3 = "SELECT * from college";
				$query3 = $conn -> prepare($sql3);
				$query3->execute();
				$results3=$query3->fetchAll(PDO::FETCH_OBJ);
					if($query3->rowCount() > 0){
						foreach($results3 as $result3){
							if ($result3->name==$college1){
								$check=true;
							}
						}
					}
				$sql4 = "SELECT * from college";
				$query4 = $conn -> prepare($sql4);
				$query4->execute();
				$results4=$query4->fetchAll(PDO::FETCH_OBJ);
					if($query4->rowCount() > 0){
						foreach($results4 as $result4){
							if ($result4->name==$college2){
								$check1=true;
							}
						}
					}
				if (!$check && !$check1){
					$message = "Both college not found in our database";
				} 
				else {
					if(!$check){
						$message .= "First college not found in our database<br>";
					}
					if(!$check1){
						$message .= "Second college not found in our database";
					}
				}
			}
			else{
				$message = "Please do not select the same college.";
			}
		}
	}
?>
<?php
	$sql = "SELECT id,name FROM college";
	$result = $conn -> prepare($sql);
	$result -> execute();
	$data = $result -> fetchAll(PDO::FETCH_OBJ);
	$no = 0;
	$row = $result -> rowCount();
	if ($row > 0)
	{
		foreach($data as $c)
		{
			$collegeID[$no] = $c -> id;
			$collegeName[$no++] = $c -> name;
		}
	}
?>
	<body>
	<h2 class="login-word">Compare College</h2>
		<form class="compare-form" action="compareCollege.php" method="post">
            <div class="compare-grid">
			<div id="compare-college1" class="dropdown-content compare-container" style="position: relative;">
			<input type="text" placeholder="Enter first college" name="college1" id="college1" title="searchfield" onfocus="clearText()" onblur="clearText(this)" onkeyup="filter1()" onfocusin="filter1()" onfocusout="timeout1(200)" />
				<?php
				if ($row > 0)
				{	
					foreach ($collegeID as $index => $id)
					{
						echo "<a onclick=\"fillInput1(this)\" name=\"a\">$collegeName[$index]</a>";
					}
				}
				?>
            </div>
			<div id="vs" class="compare-container">VS</div>
			<div id="compare-college2" class="dropdown-content compare-container" style="position: relative;">
			<input  type="text" placeholder="Enter second college" name="college2" id="college2" title="searchfield" onfocus="clearText()" onblur="clearText(this)" onkeyup="filter2()" onfocusin="filter2()" onfocusout="timeout2(200)"  />
				<?php
				if ($row > 0)
				{	
					foreach ($collegeID as $index => $id)
					{
						echo "<a onclick=\"fillInput2(this)\" name=\"a\">$collegeName[$index]</a>";
					}
				}
				?>
			</div>
            </div>
            <br>
			<input id="compare-button" type="submit" value="Submit" name="submit">
            <br>
            <br>
		</form>
		<?php if (isset($_POST['submit'])){
				echo '<span style="color:red">'.$message.'</span>';			
				}
		?>
		<br><br>
	<?php
		if(isset($_POST['submit']) && !empty($college1) && !empty($college2) && $check && $check1){
		$sql = "SELECT * from college WHERE name='$college1'";
		$query = $conn -> prepare($sql);
		$query->execute();
		$results=$query->fetchAll(PDO::FETCH_OBJ);
			if($query->rowCount() > 0){
				foreach($results as $result){
					$i=0;
					$sql5 = "SELECT * from review WHERE collegeID='$result->ID'";
					$query5 = $conn -> prepare($sql5);
					$query5->execute();
					$results5=$query5->fetchAll(PDO::FETCH_OBJ);
						if($query5->rowCount() > 0){
							foreach($results5 as $result5){
								$totalRating += $result5->rating;
								$i++;
							}
							$averageRating = $totalRating/$i;
							$averageRating = number_format($averageRating, 2);
						}
						else{
							$averageRating = 0;
						}
						
		$sql2 = "SELECT * from college WHERE name='$college2'";
		$query2 = $conn -> prepare($sql2);
		$query2->execute();
		$results2=$query2->fetchAll(PDO::FETCH_OBJ);
			if($query2->rowCount() > 0){
				foreach($results2 as $result2){
					$j=0;
					$sql6 = "SELECT * from review WHERE collegeID='$result2->ID'";
					$query6 = $conn -> prepare($sql6);
					$query6->execute();
					$results6=$query6->fetchAll(PDO::FETCH_OBJ);
						if($query6->rowCount() > 0){
							foreach($results6 as $result6){
								$totalRating1 += $result6->rating;
								$j++;
							}
							$averageRating1 = $totalRating1/$j;
							$averageRating1 = number_format($averageRating1, 2);
						}
						else {
							$averageRating1=0;
						}
						
		echo '<table class="table" cellpadding="20px" border="1">
					<tr>
						<td>Name</td>
						<td>'.$result->name.'</td>
						<td>'.$result2->name.'</td>
					</tr>
					<tr>
						<td>State</td>
						<td>'.$result->state.'</td>
						<td>'.$result2->state.'</td>
					</tr>						
					<tr>
						<td>Address</td>
						<td>'.nl2br($result->address).'</td>
						<td>'.nl2br($result2->address).'</td>
					</tr>						
					<tr>
						<td>Contact Number</td>
						<td>'.$result->contactNumber.'</td>
						<td>'.$result2->contactNumber.'</td>
					</tr>
					<tr>
						<td>Office Hours</td>
						<td>'.$result->officeHours.'</td>
						<td>'.$result2->officeHours.'</td>
					</tr>
					<tr>
						<td>Rating</td>
						<td>'.$averageRating.' / 5</td>
						<td>'.$averageRating1.' / 5</td>
					</tr>
		</table>';
				}
			}
		}
	}
}
?>
		
<?php
	include "footer.php";
?>
