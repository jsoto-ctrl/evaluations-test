<html>
  <head>
<link href="https://www.iub.edu/~ancla/spanport/css/brand.css" rel="stylesheet">
<?

$page = "Student Evals: Instructor Report"; 
echo "<title>$page</title>";

?>
  </head>
  <body>
<?
include ("css/header.html");
$now = "".strftime("%m/%d/%Y at %H:%M:%S")."";
$query_user = $_REQUEST['query_user'];
$last = $_REQUEST['last'];
$first = $_REQUEST['first'];
$appointment = $_REQUEST['appointment'];

require ('lib/config_general.php');

		$db_name = "student_evals";
		$connection = @mysql_connect($servidor,$usuario_db,$contrasenna) or die("Couldn't connect to $servidor.");
		mysql_set_charset('utf8',$connection);
		$db = @mysql_select_db($db_name, $connection) or die("Couldn't select database.");
		$sql ="select avg(mean_course) as Mean1, avg(mean_instructor) as Mean2, course, count(course) as sections from evaluations where user = '$query_user' and session NOT LIKE '%mid%' group by course order by course";
		$ln_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$result = mysql_num_rows($ln_result);
		while ($row = mysql_fetch_array($ln_result)) {
			$Mean1=$row['Mean1'];
			$Mean2=$row['Mean2'];
			$course=$row['course'];
			$sections=$row['sections'];
									

			if ($course != "0.00") {		
			$combined .= "<tr><td>$course</td><td>$sections</td><td>$Mean1</td><td>$Mean2</td></tr>";
			}
			
		} 
		
			if ($result == ""||!$result) {
			print "<p>&nbsp;</p><h3>No Records Found</h3><div class=\"content\">No student evaluation stats have been reported for $first $last.</div><p>&nbsp;</p><p>&nbsp;</p>";
			include ("css/footer.php");

			exit;
			}


								$sql2 ="select course, section, course_type, section_type, year, session, session_type, mean_course, mean_instructor from evaluations where user = '$query_user' order by year ASC, session DESC, course, section, session_type ASC";
								$result2 = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
								$num_rows = mysql_num_rows($result2);
								while ($row = mysql_fetch_array($result2)) {
									$course=$row['course'];
									$section=$row['section'];
									$section_type=$row['section_type'];
									$year=$row['year'];
									$session=$row['session'];
									$session_type=$row['session_type'];
									$mean_course=$row['mean_course'];
									$mean_instructor=$row['mean_instructor'];	
									
									if ($mean_course == "0.00") {
									$mean_course = "--------";
									}
									if ($mean_instructor == "0.00") {
									$mean_instructor = "--------";
									}			
									
									if ($course == "0.00") {
									$course = "----";
									}	
									
									if ($section == "0000") {
									$section = "----";
									}	
									if ($mean_instructor < "2.80" && $mean_instructor >= "2.01") {
									$mean_instructor = "<b>$mean_instructor</b>";
									} else if ($mean_instructor > "3.49") {
									$mean_instructor = "<b><font color=green>$mean_instructor</font></b>";
									} else if ($mean_instructor <= "2.00" && $mean_instructor > "0.00") {
									$mean_instructor = "<b><font color=maroon>$mean_instructor</font></b>";
									}																	
									$i = $i+1;
									
											if ($section_type == "" && $session_type == "Course Release") {
											$section_type = "-----";
											} else if ($section_type != "") {
											$section_type = "($section_type)";
											} else {
											$section_type = "(Regular)";
											}
						
									
									
									$detailed .= "<tr><td>$i</td><td>$session $year</td><td>$session_type</td><td>$course</td><td>$section $section_type</td><td>$mean_course</td><td>$mean_instructor</td></tr>";
									
								}
								
						
		
								
								
								
?>      
<p>&nbsp;</p><h2>Instructor Report: <? echo "$last, $first [$query_user] [$appointment]" ?></h2>

<div class="content">
<h4>Report Date: <? echo "$now"; ?></h4>

<?php 
echo "
<p align=\"right\"><a href= \"addStats_form.php?query_user=$query_user&last=$last&first=$first&appointment=$appointment\"><img src=\"images/add.jpg\" alt=\"Add Stats\" height=\"35\" width=\"35\" border=\"0\"></a></p>";
?>


<h5>I. Combined Stats</h5>
<p>Mid-Term evaluations are not considered in the combined averages below.</p>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr bgcolor="#FFFFCC"><td><b>Course(s) Taught</b></td><td><b>Sections Taught</b></td><td><b>Outstanding Course</b></td><td><b>Outstanding Instructor</b></td></tr>
	
	<? echo "$combined" ?>

	
</table>
<h5>II. Detailed Stats</h5>
<p>Records sorted chronologically.</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr bgcolor="#FFFFCC"><td><b></b></td><td><b>Term</b></td><td><b>Type</b></td><td><b>Course</b></td><td><b>Section</b></td><td><b>Outstanding Course</b></td><td><b>Outstanding Instructor</b></td></tr>
	
	<? echo "$detailed" ?>

	
</table>



</div><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<?
include ("css/footer.php");

?>       </body>
  </html>