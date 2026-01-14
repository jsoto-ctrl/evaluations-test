<html>
  <head>
<link href="https://www.iub.edu/~ancla/spanport/css/brand.css" rel="stylesheet">
<?

$page = "Student Evals: Search Results"; 
echo "<title>$page</title>";

?>
  </head>
  <body>
<?
include ("css/header.html");
		
$query_lastname = $_POST['query_lastname'];

require ('lib/config_general.php');

		$db_name = "student_evals";
		$connection = @mysql_connect($servidor,$usuario_db,$contrasenna) or die("Couldn't connect to $servidor.");
		mysql_set_charset('utf8',$connection);
		$db = @mysql_select_db($db_name, $connection) or die("Couldn't select database.");
		$sql ="SELECT record, userID, last, first, appointment from instructors where last LIKE '$query_lastname' order by last, first";
		$ln_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$result = mysql_num_rows($ln_result);
		while ($row = mysql_fetch_array($ln_result)) {
		
			$userID=$row['userID'];
			$record=$row['record'];
			$last=$row['last'];
			$first=$row['first'];
			$appointment=$row['appointment'];
			
		$display_lastname .= "<tr><td>$last, $first</td><td>$userID</td><td>$appointment</td>
		<td><a href=\"report_instructor.php?query_user=$userID&last=$last&first=$first&appointment=$appointment\"><b>[View Report]</b></a>
		 <a href=\"addStats_form.php?query_user=$userID&last=$last&first=$first&appointment=$appointment\"><b>[Add Stats]</b></a></td>
		
		</tr>";
		} 
		
			if ($result == ""||!$result) {
			print "<p>&nbsp;</p><h3>No Records Found</h3><div class=\"content\">There's nobody with that last name. Feel free to try again with some wildcards.</div><p>&nbsp;</p><p>&nbsp;</p>";
			include ("css/footer.php");

			exit;
			}

?>      
<p>&nbsp;</p><h2>Student Evaluations: Results</h2>
<div class="content"><form method="post" action="report_instructor.php">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr><td><h4>Instructor</h4></td><td><h4>Username</h4></td><td><h4>Appointment</h4></td><td>Action</td></tr>
	
	<? echo "$display_lastname" ?>

	
</table></form></div><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<?
include ("css/footer.php");

?>       </body>
  </html>