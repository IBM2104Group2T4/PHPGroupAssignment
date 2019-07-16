<?php
	include "includes/initialize.php";
	include "header.php";
?>
		<h1>Email not sending</h1>
<?php
	$text = $_SESSION['text'];
	echo 'Email could not be sent.<br>';
	echo 'Mailer error: '. $text;
	include "footer.php";
?>