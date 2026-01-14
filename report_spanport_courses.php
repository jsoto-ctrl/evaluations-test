<html>
  <head>
<link href="https://www.iub.edu/~ancla/spanport/css/brand.css" rel="stylesheet">
<?

$page = "Report SpanPort Courses"; 
echo "<title>$page</title>";

?>
  </head>
  <body>
<?
include ("css/header.html");
$term = "Spring 2016";
$now = "".strftime("%m/%d/%Y at %H:%M:%S")."";

$table = "sections";

	require ('lib/config_general.php');

	$connection = @mysql_connect($servidor,$usuario_db,$contrasenna) or die("Couldn't connect to $servidor.");
	$db = @mysql_select_db("scheduler", $connection) or die("Couldn't select database.");
	

	$sql1 = "SELECT count(section) as course_count,course from sections group by course order by course";
	$result1 = @mysql_query($sql1, $connection) or die("Insertion error<br>Error #". mysql_errno() . ": " . mysql_error());
	$total_courses = mysql_num_rows($result1);
	
	
		while ($row = mysql_fetch_array($result1)) {


			$course_count=$row['course_count'];
			$curso=$row['course'];
	
			$courseBlock .= "<b>Course:</b> $curso &nbsp; &nbsp;&nbsp;&nbsp;<b>Sections:</b> $course_count<br />";
			
			}
			
			
	$sql = "SELECT section,course,last,first,days,time,start,end,room from sections where active = '1' order by course,start,section";
	$result = @mysql_query($sql, $connection) or die("Insertion error<br>Error #". mysql_errno() . ": " . mysql_error());
	$total_sections = mysql_num_rows($result);
	
	$hold = "4";
	$total_sections = ($total_sections - $hold);
	
		while ($row = mysql_fetch_array($result)) {
		$status = "";
		$section = "";
		
			$last=$row['last'];
			$first=$row['first'];
			$course=$row['course'];
			$section=$row['section'];
			$days=$row['days'];
			$start=$row['start'];
			$end=$row['end'];
			$room=$row['room'];		
			
			#ID tentative sections
			if ($section == "12335"||$section == "5048"||$section == "5089"||$section == "5091") {
			$status = "[HOLD]";
			}
			$i = $i + 1;
			if(stristr($course, 'C') == TRUE) {
			$blockCat .= "<tr><td>$i</td><td>$course</td><td>$section $status </td><td>$start-$end</td><td>$days</td><td>$room</td><td>$first $last</td></tr>";
			} else if(stristr($course, 'P') == TRUE) {
			$blockPort .= "<tr><td>$i</td><td>$course</td><td>$section $status </td><td>$start-$end</td><td>$days</td><td>$room</td><td>$first $last</td></tr>";
			} else {
			$blockSpan .= "<tr><td>$i</td><td>$course</td><td>$section $status </td><td>$start-$end</td><td>$days</td><td>$room</td><td>$first $last</td></tr>";
			}			
			
		}						
					
		echo "<p>&nbsp;</p><h2>Tentative Schedule Report for $term</h2>
				<blockquote>
		<h4>$now</h4><h4>$total_sections active sections, $hold on hold</h4>
		
		
		<h3>I. Catalan Courses</h3>

		<table width = \"750\" border = \"1\">
		$blockCat
		</table>
		<p>&nbsp;</p>
		
		<h3>II. Portuguese Courses</h3>

		<table width = \"750\" border = \"1\">
		$blockPort
		</table>
		<p>&nbsp;</p>
		<DIV style=\"page-break-after:always\"></DIV>

		<h3>III. Spanish Courses</h3>
		<table width = \"750\" border = \"1\">
		$blockSpan
		</table>
		<DIV style=\"page-break-after:always\"></DIV>

		
		<h3>IV. Courses & Sections Summary</h3>

		$courseBlock
		<p>&nbsp;</p>
		
		</blockquote>
		<p>&nbsp;</p>
		<p>&nbsp;</p>";
		
				


include ("css/footer.php");

?>       </body>
  </html>