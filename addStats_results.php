<html>
  <head>
<link href="https://www.iub.edu/~ancla/spanport/css/brand.css" rel="stylesheet">
<?

$page = "Student Evals: Entry Results"; 
echo "<title>$page</title>";

?>
  </head>
  <body>
<?
include ("css/header.html");
require ('lib/config_general.php');


$user = $_POST['user'];
$first = $_POST['first'];
$last = $_POST['last'];

$course = $_POST['add_course'];
$section = $_POST['add_section'];
$term = $_POST['add_term'];
$year = $_POST['add_year'];
$mean1 = $_POST['add_mean1'];
$mean2 = $_POST['add_mean2'];

$type = $_POST['add_type'];

		
require ("lib/nav.php");

	if (!$user||!$course||!$section||!$term||!$year||!$mean1||!$mean2) {
	print "<p>&nbsp;</p><h2>Missing Info</h2><div class = \"content\"><div>You need to enter all information in the previous form. Go back and try again.</div><p>&nbsp;</p><p>&nbsp;</p></div>";
	include ("css/footer.php");
	print" </body></html>";
	exit;
	
	if ($type == "") {
	$type = "Semester";
	}
	
	}

	$db_name = "student_evals";
	$connection = @mysql_connect($servidor,$usuario_db,$contrasenna) or die("Couldn't connect to $servidor.");
	$db = @mysql_select_db($db_name, $connection) or die("Couldn't select database.");

	
	$sql = "INSERT INTO evaluations
	(user,year,course,section,session,session_type,mean_course,mean_instructor)
	VALUES
	(\"$user\",\"$year\",\"$course\",\"$section\",\"$term\", \"$type\",\"$mean1\", \"$mean2\")";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	
	if ($result) {
	$result_text = "<div class=\"content\">Stats added for $first $last</div>";
	} else {
	$result_text = "<font color=red>Error</h3></font><div class=\"content\">Stats were NOT added for $first $last</div>";
	}
	
	mysql_close($connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	
?>


<div class="content">
<h2>Results</h2>
<? echo "$result_text <center>$back</center>"; ?>
</div><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

<?
include ("css/footer.php");
?>

     </body>
  </html>

