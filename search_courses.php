<?php
echo "Hey!<br />";
$search_str='Class Nbr:';
$lines = file('allCourses.csv');
$process = $_REQUEST['process'];

$table = "sections_spring16";

	require ('lib/config_general.php');

	$connection = @mysql_connect($servidor,$usuario_db,$contrasenna) or die("Couldn't connect to $servidor.");
	$db = @mysql_select_db("master", $connection) or die("Couldn't select database.");
	

	foreach($lines as $line){
	$loc = "";	
	$commas = substr_count($line, ",");


	if ($commas == "42") {
	$inst_set = "1";
	list($section_string, $course_string, $inst_string,$inst_string2, $time_string,$days_string,$loc_string)=explode(",",$line);
	} else {
	$inst_set = "0";
	list($section_string, $course_string, $inst_string,$time_string,$days_string,$loc_string)=explode(",",$line);
	}
	
		if(stristr($section_string, 'Class Nbr:') == TRUE){
		
		$section = substr_replace($section_string, '',0,-5);
		$section = trim($section);
		
		$course = substr_replace($course_string, '',0,-4);
		$course = trim($course);
		$courseL = substr_replace($course_string, '',0,-5);
		$courseL = substr_replace($courseL, '',1);

		$courseL = trim($courseL);
		$course_number = $course;
		$course = "$courseL$course";
		
		$days = substr_replace($days_string, '',0,-4);
		$days = trim($days);	
		if ($days == "MTWR") { $days = "D"; }
		$inst = substr_replace($inst_string, '',0,16);
		$inst = trim($inst);	
		
		$inst2 = substr_replace($inst_string2, '',-1);
		$inst2 = trim($inst2);	
		
	
		$loc = substr_replace($loc_string, '',0,-9);		
		$loc = trim($loc);	
		$length = strlen($loc);
		#echo "length is $length<br />";
		$cut_length = ($length - 2);
		$cut_length = "-$cut_length";
		#echo "cutlength is $cut_length<br />";

		$loc = substr_replace($loc, '',0, $cut_length);

		$time = explode('-',$time_string);
		$start = $time[0];
		$length2 = strlen($start);
		#echo "length is $length2<br />";
		$cut_length2 = ($length2 - 7);
		$cut_length2 = "-$cut_length2";
		#echo "cutlength is $cut_length2<br />";
		$start = substr_replace($start, '',0, $cut_length2);
		$start = substr_replace($start, '',6);
		$start = trim($start);
		$hour = substr_replace($start, '',2);
		include ('lib/hours.php');
		$end = $time[1];
		
		require ('lib/supervisors.php');
		
		#ACP classes are still reported by IUIE, but location and days are missing. Test against that. 
				if ($course_number < 251 && $loc != "ion:" && $days != "s:" && $courseL == "S") {
				echo "Section stripped is $section<br />";
				echo "Course stripped is $course, letter is <b>$courseL</b>, course number is $course_number<br />";
				echo "Days stripped is $days<br />";
				echo "Location stripped is $loc<br />";
				echo "Time exploded is $start but hour is $hour<br />";
					if ($process) {
					echo "<font color=navy>Insertion here</font><br />";
					
				$sql = "INSERT INTO $table (section,course,supervisor,days,time,room,active)
				VALUES
				(\"$section\",\"$course\",\"$sup_user\",\"$days\",\"$hour\",\"$loc\",\"1\")";
				$result = @mysql_query($sql, $connection) or die("Insertion error<br>Error #". mysql_errno() . ": " . mysql_error());
				
				if ($result) {
				print "Section added.<br />";
				} else {
				print "Section was not added.<br />";
				}
					
					
					}
					if ($inst_set == "1") {
					echo "Instructor is set to <b>$inst, $inst2</b><br />";
					}
				#echo "We have $commas in this line.<br />";
				echo "<hr>";
				}
		
		}
	}

?>
