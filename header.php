<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>College Portal</title>
<meta name="keywords" content="free website templates, pro teal, web design, 2-column" />
<meta name="description" content="Pro Teal - free website template (2-column layout) from templatemo.com" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ennui.contentslider.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
function filter() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("searchfield");
  filter = input.value.toUpperCase();
  div = document.getElementById("dropdown");
  a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
	    if (filter.length != 0){
			txtValue = a[i].textContent || a[i].innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
			//found
		    a[i].style.display = "block";
		    } else {
			//not found
			a[i].style.display = "none";
			}
		}
	    else
		{
			a[i].style.display = "none";
		}
    }
}
function clearFilter()
{
	
	div = document.getElementById("dropdown");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
		a[i].style.display = "none";
    }
}
function fillInput(z)
{
    document.getElementById("searchfield").value = z.textContent;
}
function filter1() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("college1");
  filter = input.value.toUpperCase();
  div = document.getElementById("compare-college1");
  a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
	    if (filter.length != 0){
			txtValue = a[i].textContent || a[i].innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
			//found
		    a[i].style.display = "block";
		    } else {
			//not found
			a[i].style.display = "none";
			}
		}
	    else
		{
			a[i].style.display = "none";
		}
    }
}
function clearFilter1()
{
	
	div = document.getElementById("compare-college1");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
		a[i].style.display = "none";
    }
}
function fillInput1(z)
{
    document.getElementById("college1").value = z.textContent;
}
function filter2() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("college2");
  filter = input.value.toUpperCase();
  div = document.getElementById("compare-college2");
  a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
	    if (filter.length != 0){
			txtValue = a[i].textContent || a[i].innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
			//found
		    a[i].style.display = "block";
		    } else {
			//not found
			a[i].style.display = "none";
			}
		}
	    else
		{
			a[i].style.display = "none";
		}
    }
}
function clearFilter2()
{
	
	div = document.getElementById("compare-college2");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
		a[i].style.display = "none";
    }
}
function fillInput2(z)
{
    document.getElementById("college2").value = z.textContent;
}
function timeout(dur)
{
	setTimeout(clearFilter, dur);
}
function timeout1(dur)
{
	setTimeout(clearFilter1, dur);
}
function timeout2(dur)
{
	setTimeout(clearFilter2, dur);
}
</script>
</head>
<body>
<?php
	include "includes/config.php";
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
<div id="search_box" style="position: relative; display: inline-block;">
	<div class="dropdown-content" id="dropdown">
	<input type="text" placeholder="Search College" name="q" id="searchfield" title="searchfield" onfocus="clearText()" onblur="clearText(this)" onkeyup="filter()" onfocusin="filter()" onfocusout="timeout(200)" />
		<?php
			if ($row > 0)
			{
				foreach ($collegeID as $index => $id)
				{
					echo "<a href=\"collegeDetail.php?detail=$id\">$collegeName[$index]</a>";
					// echo "<a onclick=\"fillInput(this)\" name=\"a\">$collegeName[$index]</a>";
				}
			}
		?>
    </div>
</div>
<div id="templatemo_wrapper">

	<div id="templatemo_header">
    
    	<div id="site_title">
            <h1><a href="http://www.templatemo.com/page/1" target="_parent">
                <img src="images/educationPortalLogo.png" alt="Site Title" width="150" height="80" />
                <!--span>free website templates</span--></a>
			</h1>
      	</div>
                
        <div class="cleaner"></div>
	</div> <!-- end of header -->
    
    
    <div id="templatemo_menu">
    
        <ul>
            <li><a href="index.php">Home</a></li>
			<?php
				if ($isLogin == false){
					echo "<li><a href=\"login.php\">Login</a></li>";
					echo "<li><a href=\"register.php\">Register</a></li>";
				}
			
				echo "<li><a href=\"compareCollege.php\">Comparison</a></li>";
			
				if ($isLogin == true){
					if ($admin == true){
						//echo "<li><a href=\"#\">Manage User</a></li>";					
						echo '<li><a href="addCollege.php">Add College</a></li>';
						echo '<li><a href="manageCollege.php">Manage College</a></li>';
					}
					echo '<li><a href="changePassword.php">Change Password</a></li>';
					echo '<li><a href="logout.php">Logout</a></li>';
				}
			?>
        </ul>    	
    
    </div> <!-- end of templatemo_menu -->
	<div id="templatemo_content_wrapper">
        <div id="templatemo_content"></div> <!-- end of templatemo_content -->