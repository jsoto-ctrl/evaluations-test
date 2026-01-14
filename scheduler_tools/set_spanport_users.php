<?php
## Script 2: Follows set_spanport_courses.php
### This script looks up usernames in master.instructors. If found, it updates scheduler.sections. If not, it reports them in a list, so
### that they can be manually added. I'm adding it as the second script to be run after set_spanport.courses.php
###	Script 3: populate.php
	require ('../lib/config_general.php');
	require ('../lib/supervisors.php');


	$connection = @mysql_connect($servidor,$usuario_db,$contrasenna) or die("Couldn't connect to $servidor.");
	mysql_set_charset('utf8',$connection);
	$db = @mysql_select_db("scheduler", $connection) or die("Couldn't select database.");
	

#		$sql ="select master.instructors.inst_id, scheduler.sections.instructor, scheduler.sections.last, scheduler.sections.first
#		FROM master.instructors INNER JOIN scheduler.sections
#		ON master.instructors.inst_last = scheduler.sections.last
		
		$sql = "SELECT last, first, instructor, course, section FROM sections ORDER by last, first";
		$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$instructors_found = mysql_num_rows($result);
		while ($row = mysql_fetch_array($result)) {
		
		$instructores = "";
			$last=$row['last'];
			$first=$row['first'];
			$username=$row['username'];
			$course=$row['course'];
			$section=$row['section'];
			
			if ($last != "" && $first != "") {
			$instructores[] = "$last, $first, $course";
			}
			
			
			if ($last == "" && $first == "") {
			$block = "<font color=maroon><b>No instructor found for $course, section $section</font></b><br />";
			} else {
			$block .= "$last, $first, $username<br />";
			}

			foreach ($instructores as $profesor) {
			$sennas = explode(',', $profesor);
			$apellido = $sennas[0];
			$nombre = $sennas[1];
			$curso = $sennas[2];


			$nombres = preg_split('/ +/', $nombre);
			$pila = $nombres[1];
			
			#print "Profesor is $profesor, but is composed of $apellido and $nombre: $curso. El nombre de pila es <b>$pila</b><br />";
			
			$sql2 = "SELECT inst_id, inst_name, inst_last from master.instructors where inst_last = '$apellido' and inst_name LIKE '$pila'";
			$result2 = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
			$updated = "";
				while ($row = mysql_fetch_array($result2)) {
		
					$master_user=$row['inst_id'];
					$master_first=$row['inst_name'];
					$master_last=$row['inst_last'];
				
				

				#echo "$apellido, $nombre [$pila] teaching $curso was found as $master_last, $master_first, $master_user in the master DB<br />";
				
				$sql3 = "UPDATE scheduler.sections SET instructor = '$master_user' WHERE last LIKE '%$master_last%' and first LIKE '%$master_first%'";
				$result3 = @mysql_query($sql3, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				$updated = mysql_num_rows($result3);
				#print "Updated $updated";
				if ($updated > "0") { echo "<b>Username was set to $master_user for $pila $apellido in scheduler.sections<br /></b>"; }
				#else { echo "<b><font color=maroon>Username was not updated for $pila $apellido<br /></b></font>"; }
				
				
				}
			
			$left = "";
			### Now let's who is left
				$sql4 = "SELECT instructor, first, last, course, section from scheduler.sections where instructor = 'unknown' and first != '' and last != '' order by last, first";
				$result4 = @mysql_query($sql4, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				while ($row = mysql_fetch_array($result4)) {
				
					$last=$row['last'];
					$first=$row['first'];
					$instructor=$row['instructor'];
					$course=$row['course'];
					$section=$row['section'];
				
				$left .= "$last, $first is teaching $course, section $section<br />";
				}
				
			}

		}
		
		
		print "<h2>Unmatched</h2>$left";
		
		
		
?>