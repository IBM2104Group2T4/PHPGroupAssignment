<?php
	require("fpdf181/fpdf.php");
	$pdf = new FPDF();
	if (isset($_GET['id']))
	{
		
		require ("includes/config.php");
		$id = $_GET['id'];
		
		//sql command here
		$sql = "SELECT * FROM college WHERE id='$id'";
		$result = $conn -> prepare($sql);
		$result -> execute();
		$data = $result -> fetchAll(PDO::FETCH_OBJ);
		foreach($data as $c)
		{
			$name = $c -> name;
			$picture = $c -> picture;
			$description = $c -> description;
			$course = $c -> course;
			$state = $c -> state;
			$address = $c -> address;
			$contactNumber = $c -> contactNumber;
			$officeHours = $c -> officeHours;
		}
		//some setting
		
		$array = explode('.', $picture);
		$pictureExt = end($array);
		
		$array = explode(', ', $address);
		$fullAddress = $address ."\n$state";
		
		$finalDescription = "      $description";
		
		$picturePath = "College_Image/$picture";
		
		
		$pdf -> AddPage();
		$pdf -> SetTitle("$name");
		$pdf -> SetFont("Arial", "BU", 14);
		
		
		$pdf -> Cell(10, 3, "", 0);
		$pdf -> ln();
		$pdf -> Cell(20, 0, "", 0);
		$pdf -> setFontSize(25);
		$pdf -> MultiCell(150, 10, "$name", 0, 'C', 0);
		$pdf -> setFontSize(12);

		
		$pdf -> Line(0, 40, 1000, 40);
		$pdf -> setXY(20, 50);
		
		$pdf -> setFont("Arial", "B", 16);
		
		$pdf -> Cell(40, 13, "Description: ", 0);
		$pdf -> SetFont("Arial", "", 14);
		$pdf -> ln();
		$pdf -> Cell(10);
		$pdf -> MultiCell(170, 7, "$finalDescription", 0);
		$pdf -> ln();
		
		$y = $pdf -> gety();
		$y = $y + 2;
		
		$pdf -> setFontSize(20);
		$pdf -> Image($picturePath, 21, $y, 75, 75, $pictureExt);
		
		$pdf -> setY($y);
		$pdf -> Cell(90);
		$pdf -> setFont("Arial", "B", 12);
		$pdf -> MultiCell(40, 10, "Available Course : ", 0);
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> setXY(140, $y);
		$pdf -> MultiCell(70, 8, "$course", 0, 'L');

		$pdf -> Cell(0, 3);
		$pdf -> ln();
		
		$pdf -> Cell(90);
		$pdf -> setFont("Arial", "B", 12);
		$pdf -> Cell(37, 10, "Contact Number : ", 0);
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> Cell(103, 10, "$contactNumber", 0);
		$pdf -> ln();
		$pdf -> Cell(0, 3);
		$pdf -> ln();
		
		$pdf -> Cell(90);
		$pdf -> setFont("Arial", "B", 12);
		$pdf -> Cell(30, 10, "Office Hours : ", 0);
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> Cell(103, 10, "$officeHours", 0);
		$pdf -> ln();
		$pdf -> Cell(0, 3);
		$pdf -> ln();
		
		$pdf -> Cell(90);
		$pdf -> setFont("Arial", "B", 12);
		$pdf -> Cell(21, 10, "Address : ", 0);
		$pdf -> SetFont("Arial", "", 12);
		$pdf -> MultiCell(90, 10, "$fullAddress", 0, "L");
		$pdf -> ln();
	}
	$pdf -> output();
	
?>
