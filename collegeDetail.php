<?php
	include "includes/initialize.php";
	include "header.php";
    include "includes/config.php";
	error_reporting(0);
   
?>

<div>
    <?php
	
	$sql = "SELECT * FROM college WHERE ID=$_GET[detail]";
	$result = $conn -> prepare($sql);
	$result -> execute();
	$data = $result -> fetchAll(PDO::FETCH_OBJ);
	$no = 0;
	$row = $result -> rowCount();
    
 
    
    
	if ($row > 0)
	{
		foreach($data as $c)
		{
            $collegeId = $c -> ID;
			$collegeName = $c -> name;
            $collegePicture = $c -> picture;
            $collegeDescription = $c -> description;
            $collegeCourse = $c -> course;
            $collegeState = $c -> state;
            $collegeAddress = $c -> address;
            $collegeContact = $c -> contactNumber;
            $collegeOfficeHours = $c -> officeHours
            ?>
              <fieldset class="product-detail-container">
            <legend>College Details</legend>
            
             <div class="detail-image"> 
             <img src="College_Image/<?php echo $collegePicture ?>" width="300" height="200">
             </div>
             
             <div class="detail-content">
                 
                 <span>College Name: <br> <b><?php echo $collegeName ?> </b></span>
             <br>
             <br>
                 <span>College Description:<br> <b><?php echo $collegeDescription ?> </b></span>
             <br>
             <br>
                 <span>College Course: <br><b><?php echo $collegeCourse ?></b></span>
             <br>
             <br>
                 <span>College State: <br><b><?php echo $collegeState ?></b></span> 
             <br>
             <br>
                 <span>College Address: <br><b><?php echo $collegeAddress ?></b></span> 
             <br>
             <br>
             <span>College Contact: <br><b><?php echo $collegeContact ?></b></span> 
             <br>
             <br>
                 
                <span>College Office Hour: <br><b><?php echo $collegeOfficeHours ?></b></span> 
             <br>
             <br>
                 
            </div>
             <br>
           
             
      
      </fieldset>
            
    
    <?php
		}
        
        
	}
    
    $rateErr = "";
    $commentErr = "";
    

    if(isset($_POST['commentSubmitted'])){
        
        /*$sql3 = "SELECT * FROM review WHERE collegeID=$_GET[detail] AND username=$_SESSION[username]";
        $result2 = $conn -> prepare($sql3);
	    $result2 -> execute();
	    $data2 = $result2 -> fetchAll(PDO::FETCH_OBJ);
	    $row2 = $data2 -> rowCount();
            echo $_GET[detail] . $_SESSION[username];
            echo $row2;
        if($query2->rowCount() > 0){
				foreach($results2 as $result2){
         if ($row2 > 0){              
            $commentErr = "You have rated and commented!";
                      }else{
                            
        }
         }}*/
        $row111=0;
        $sql3 = "SELECT * from review WHERE collegeID='$_GET[detail]' AND username='$_SESSION[username]'";
		$query3 = $conn -> prepare($sql3);
		$query3->execute();
		$results3=$query3->fetchAll(PDO::FETCH_OBJ);
			if($query3->rowCount() > 0){
				
                $commentErr = "You have rated and commented.";
                
            }else{
        if(empty($_POST['rate'])){
            $commentErr = "Please rate this college!";    
        }else{
            $rate = $_POST['rate'];
        if(empty($_POST['comments'])){
            $commentErr = "Please comment this college";
        }else{
            $comment = $_POST['comments'];
        }
         if(empty($_POST['rate']) && empty($_POST['comments'])){
            $commentErr = "Please rate & comment this college!";
        }
        
        if($isLogin == True){
        if(!empty($_POST['rate']) && !empty($_POST['comments'])){
            
            $date = date("Y/m/d");
            
            $sql1 = "INSERT INTO review (collegeID, username, rating, comment, date1) VALUES (?,?,?, ?, ?)";
            
            
            $stmt = $conn->prepare($sql1);
            $stmt->execute([$_GET['detail'],$_SESSION['username'],$rate, $comment, $date]);
            echo "<script>alert('Rate and Comment Successfully')</script>";
        }
        
    }else{
           $rateErr = "Please login first." ;
        }
                      }
            }
         }
       
      
   
    ?>
    
    <div class="comment-section">
        <h3><u>Rating Section</u></h3>
        <form action="collegeDetail.php?detail=<?php echo $collegeId; ?>" method="post">
            <div class="rate-comment">
             <div class="rate">
                 Rate this College!
                 <br>
                <input type="radio" id="star5" name="rate" value="5" />
                <label for="star5" title="text">5 stars</label>
                <input type="radio" id="star4" name="rate" value="4" />
                <label for="star4" title="text">4 stars</label>
                <input type="radio" id="star3" name="rate" value="3" />
                <label for="star3" title="text">3 stars</label>
                <input type="radio" id="star2" name="rate" value="2" />
                 <label for="star2" title="text">2 stars</label>
                 <input type="radio" id="star1" name="rate" value="1" />
                <label for="star1" title="text">1 star</label>
                 <br>
                 <span><?php echo $rateErr; ?></span>
            </div>
            <div class="comment-area">
            <textarea name="comments" cols="50" rows="5" placeholder="Please comment here...."></textarea>
                <span id="error-message1"><?php echo $commentErr; ?></span>
                <br>
                <!--<input type="submit" name="editComment" value="Edit your comment" style="margin-top:15px;">-->
                
                <!--<?php
                    
                if(isset($_POST["editComment"])){
                    
                    $sql4 = "SELECT * from review WHERE collegeID='$_GET[detail]' AND username='$_SESSION[username]'";
		              $query4 = $conn -> prepare($sql4);
		              $query4->execute();
		              $results4=$query4->fetchAll(PDO::FETCH_OBJ);
			             if($query4->rowCount() > 0){
                            foreach($result as $c){
                                $commentDetail1 = $c -> htmlentities($a -> comment);
                                
                                echo '<textarea>'.$commentDetail.'</textarea>';
                                    
                            }
                }
                    
                }
                
                ?>
                -->
            </div>
            </div>
            
            
            
            <div class="rating-submit-button">
                <input id="button" type="submit" name="commentSubmitted" value="RATE!" style="margin-left:0;">   
                
            </div>
        </form>
        </div>
    <br>
        
        <div>
            <div class="all-comment">
            <?php
                $sql2 = "SELECT * FROM review WHERE collegeID = $_GET[detail] ORDER BY id DESC";
	           $result1 = $conn -> prepare($sql2);
	           $result1 -> execute();
	           $data1 = $result1 -> fetchAll(PDO::FETCH_OBJ);
	           $row1 = $result1 -> rowCount();
                
                if ($row1 > 0){
		              foreach($data1 as $a){
                          $username = $a -> username;
                          $rate1 = $a -> rating;
                          $comment1 = htmlentities($a -> comment);
                          $date1 = $a -> date1;
                        ?>
                        
                        <div class="comment-box">
                            <span>Date: <?php echo $date1;?></span>
                            <br>
                            <span>Rating: <?php echo $rate1;?></span>
                            <br>
                            <span>Comment: <?php echo nl2br($comment1);?></span>
                            <br>
                            <span>From,<?php echo $username;?></span>
                            
                        </div>

                          
                          
                     <?php  
                      
                      }
                }
            
            ?>
                        </div>
        </div>
    
    


</div>
<?php
	include "footer.php";
?>