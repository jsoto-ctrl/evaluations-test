<html>
  <head>
<link href="https://www.iub.edu/~ancla/spanport/css/brand.css" rel="stylesheet">
<?

$page = "Top Instructors"; 
echo "<title>$page</title>";

?>
  </head>
  <body>
<?
include ("css/header.html");
$now = "".strftime("%m/%d/%Y at %H:%M:%S")."";
$this_year = date("Y");

require ('lib/config_general.php');

		$db_name = "student_evals";
		$connection = @mysql_connect($servidor,$usuario_db,$contrasenna) or die("Couldn't connect to $servidor.");
		mysql_set_charset('utf8',$connection);
		$db = @mysql_select_db($db_name, $connection) or die("Couldn't select database.");
		$sql ="select avg(mean_course) as Mean1, avg(mean_instructor) as Mean2, count(course) as sections,last, first from evaluations,instructors 
		where appointment = 'AI' and session NOT LIKE '%mid%' and active = '1' and userID=user and year <= '$this_year' group by user order by Mean2 DESC LIMIT 20";
		$ln_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$result = mysql_num_rows($ln_result);
		while ($row = mysql_fetch_array($ln_result)) {
			$i = $i+1;

			$Mean1=$row['Mean1'];
			$Mean2=$row['Mean2'];
			$sections=$row['sections'];
			$last=$row['last'];
			$first=$row['first'];

			$block .= "<tr><td>$i</td><td> $last, $first</td><td>$sections</td><td>$Mean1</td><td>$Mean2</td></tr>";
			
			
		} 
		
			if ($result == ""||!$result) {
			print "<p>&nbsp;</p><h3>No Records Found</h3><div class=\"content\">No student evaluation stats have been reported for $first $last.</div><p>&nbsp;</p><p>&nbsp;</p>";
			include ("css/footer.php");

			exit;
			}
		
								
								
								
?>      

<div class="content">
<h4>Report Date: <? echo "$now"; ?></h4>




<h5>Top 20 Associate Instructors</h5>
<p>Mid-Term evaluations are not considered in the combined averages below.</p>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr bgcolor="#FFFFCC"><td></td><td><b>Name</b></td><td><b>Sections Taught</b></td><td><b>Outstanding Course</b></td><td><b>Outstanding Instructor</b></td></tr>
	
	<?php echo "$block" ?>

	
</table>

<!-- 
<?php

		### Get NTTs
			$sql2 ="select avg(mean_course) as Mean1, avg(mean_instructor) as Mean2, count(course) as sections,last, first from evaluations,instructors 
		where appointment = 'NTT' and session NOT LIKE '%mid%' and course != '0000' and active = '1' and userID=user and year <= '$this_year' group by user order by Mean2 DESC LIMIT 5 ";
		$ln_result2 = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$result2 = mysql_num_rows($ln_result2);
		while ($row = mysql_fetch_array($ln_result2)) {
		$j = $j+1;
			$Mean1=$row['Mean1'];
			$Mean2=$row['Mean2'];
			$sections=$row['sections'];
			$last=$row['last'];
			$first=$row['first'];
			
			$diff = ($Mean2 - $Mean1);
			$block2 .= "<tr><td>$j</td><td> $last, $first</td><td>$sections</td><td>$Mean1</td><td>$Mean2</td><td>$diff</td></tr>";
			
			
		} 
		
			if ($result2 == ""||!$result2) {
			print "<p>&nbsp;</p><h3>No Records Found</h3><div class=\"content\">No student evaluation stats have been reported for $first $last.</div><p>&nbsp;</p><p>&nbsp;</p>";
			include ("css/footer.php");

			exit;
			}
?>
<h5>II. Top NTTs</h5>
<p>Mid-Term evaluations are not considered in the combined averages below.</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr bgcolor="#FFFFCC"><td></td><td><b>Name</b></td><td><b>Sections Taught</b></td><td><b>Outstanding Course</b></td><td><b>Outstanding Instructor</b></td><td>Difference</td></tr>
	
	<? echo "$block2" ?>

	
</table>
 -->




</div><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<?
include ("css/footer.php");

?>       </body>
  </html>