<?php
	include "includes/initialize.php";
	if ($_SESSION['isLogin'] == false){
		header("Location:index.php");
		exit();
	}
	include "header.php";
	include "includes/config.php";
	if(isset($_GET['del'])){
		$id=$_GET['del'];
		$sql = "DELETE FROM college WHERE id=$id";
		$query = $conn->prepare($sql);
		$query -> execute();
	}
?>
	<body>
	<h2 class="login-word"><center>Manage College</center></h2>
	
		<table class="table" cellpadding="20px" border="1" align="center">
			<thead>	
				<tr>
					<th>No</th>
					<th>Name</th>  
					<th>State</th>
					<th>Address</th>
					<th>Contact Number</th>
					<th>Office Hours</th>
					<th width="60">Action</th>
					<th>View</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$sql = "SELECT * from college";
				$query = $conn -> prepare($sql);
				$query->execute();
				$results=$query->fetchAll(PDO::FETCH_OBJ);
				$no=1;
				if($query->rowCount() > 0){
					foreach($results as $result){		
			?>
			<tr>
				<td><?php echo $no?></td>
				<td><?php echo htmlentities($result->name)?></td>
				<td><?php echo htmlentities($result->state)?></td>
				<td><?php echo nl2br($result->address)?></td>
				<td><?php echo htmlentities($result->contactNumber)?></td>
				<td><?php echo htmlentities($result->officeHours)?></td>
                <td>
			<?php echo'<a href="editCollege.php?id='.htmlentities($result->ID).'"><i class="material-icons" title="Edit">mode_edit</i></a>';?>	
			<a href="manageCollege.php?del=<?php echo ($result->ID);?>" 
			onclick="return confirm('Are you sure want to delete? The data is irreversible once you delete it!');">
			<i class="material-icons" title="Delete">delete</i></a></td>
			<td><a id="view-button" href="collegeDetail.php?detail=<?php echo ($result->ID);?>" class="" >View</a></td>
			</tr>
<?php
		$no++;
		}
	}
?>
		</tbody>
	</table>
<?php
	include "footer.php";
?>
