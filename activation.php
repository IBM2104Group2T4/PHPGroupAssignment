<?php
include "includes/config.php";
include "includes/initialize.php";
include "header.php";
error_reporting(0); //error reporting = 0
$username=$_GET['x'];
$password=$_GET['y'];
$status=1;

$sql2 = "SELECT * from user WHERE username='$username' and password='$password'";
$query2 = $conn -> prepare($sql2);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);
if($query2->rowCount() > 0){
	foreach($results2 as $result2){
		if($result2->status == 0){
			$sql = "update user set status='$status' WHERE username='$username' and password='$password'";
			$query = $conn->prepare($sql);
			$query -> execute();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Verification</title>
        
        
</head>
    <body style="background-color:#d3d9de;">
		<main class="mn-inner">
            <div class="row" style="margin-left:53px">
                <div class="col s12">
                    <div class="page-title"><h4>Verfication<h4></div>
                </div>
				<div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
							<div class="row" style="margin-left:53px">
								<h5><?php echo "Your account is activated."; ?></h5><br>
								<a href="login.php">Click here to login</a>
							</div>
						</div>		
					</div>	
				</div>
			</div>
		</main>
    </body>
</html>

<?php 
	}
		else{
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Verification</title>
        
        
</head>
    <body style="background-color:#d3d9de;">
		<main class="mn-inner">
            <div class="row" style="margin-left:53px">
                <div class="col s12">
                    <div class="page-title"><h4>Verfication</h4></div>
                </div>
				<div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
							<div class="row" style="margin-left:53px">
								<h5><?php echo "Your account was activated."; ?></h5>
								<a href="login.php">Click here to login</a>								
							</div>
						</div>		
					</div>	
				</div>
			</div>
		</main>
    </body>
</html>
<?php
		}
	}
}
include "footer.php";
?>