<?php
SESSION_START();
if (isset($_SESSION['isLogin'])){
	SESSION_UNSET();
	SESSION_DESTROY();
}
header("location:index.php"); 
//echo "<script type='text/javascript'> document.location = 'index.php'; </script>";

?>