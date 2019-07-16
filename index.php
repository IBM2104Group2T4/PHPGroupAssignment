<?php
	include "includes/initialize.php";
	include "header.php";
    include "includes/config.php";
?>

<style>
#loadMore {
    padding-bottom: 30px;
    padding-top: 30px;
    text-align: center;
    width: 100%;
}

#loadMore a {
    background: #042a63;
    border-radius: 3px;
    color: white;
    display: inline-block;
    padding: 10px 30px;
    transition: all 0.25s ease-out;
    -webkit-font-smoothing: antialiased;
}

#loadMore a:hover {
    background-color: #021737;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="js/loadmore.js"></script>

<div>
    <?php
		$sql = "SELECT * FROM college";
		$result = $conn -> prepare($sql);
		$result -> execute();
		$data = $result -> fetchAll(PDO::FETCH_OBJ);
		$row = $result -> rowCount();
		if ($row > 0)
		{
			$no = 0;
			foreach($data as $c)
			{
				$collegeId[$no] = $c -> ID;
				$collegeName[$no] = $c -> name;
				$collegePicture[$no++] = $c -> picture;
			}
			$array = array();
			for ($i = 0; $i < $row; $i++)
			{
				$check = false;
				while (!$check)
				{
					$random = rand(0, $row - 1);
					if (!in_array($random, $array))
					{
						$array[$i] = $random;
						$check = true;
					}
				}
				
			}
			for ($i = 0; $i < $row; $i++)
			{				
				echo '<div class="moreBox" style="display:none;">
							<div class="gallery">
								<a href="collegeDetail.php?detail='.$collegeId[$array[$i]].'">
									<img src="College_Image/'.$collegePicture[$array[$i]].'" alt="" width="600px" height="400px">				
										<div class="desc">'.$collegeName[$array[$i]].'</div>
								</a>
							</div>
						</div>';
			}
		}		
	?>
	<div id='loadMore'>
		<a href='#'>Load More</a>
	</div>
</div>
	
<?php
	include "footer.php";
?>