<?php


## Script 3: Follows set_spanport_users.php
### This script This will will grab all necessary fields from scheduler.sections and use them to 

#a) create (if not present) or empty an existing master.sections_next,
# b) populate master.sections_next (SWEEET!) with courses, sections, location, days, time, supervisor and instructor's usernames if the IUIE roster has 
#them available at the time of running. Karla prepares the course schedule one year in advance, so this tool can be used at the end of one semester to
#populate that pesky master.sections table, cutting significantly in Ancla setup time for the next academic session. 

#!!! In order to activate sections_next, we'll need to rename master.sections to master.sections_something and rename master.sections_next to master.sections. 
# That way we can populate this master table at any time without interfering with the existing master.sections. !!!!!
################################################################################################################################################################


	require ('../lib/config_general.php');
	#require ('lib/supervisors.php');

	$table = "sections_next";
	$update = "1"; ## Assuming there is a table and data to update

	$connection = @mysql_connect($servidor,$usuario_db,$contrasenna) or die("Couldn't connect to $servidor.");
	mysql_set_charset('utf8',$connection);
	$db = @mysql_select_db("master", $connection) or die("Couldn't select master database: Error #". mysql_errno() . ": " . mysql_error());

##############################################################################################
## First check if table sections_next exists. If it doesn't, create it and copy basic sections for staff access.

	mysql_unbuffered_query("SET profiling = 1");  // for profiling only
	@mysql_unbuffered_query("SELECT 1 FROM `$table` LIMIT 1 ");
	
		if (mysql_errno() == 1146){
		$update = "0";
		$sql = "CREATE master.TABLE $table LIKE master.sections";
		$result = @mysql_query($sql, $connection) or die("Table creation error!<br />Error #". mysql_errno() . ": " . mysql_error());
		
		if ($result > "0") { echo "Table $table created.<br />"; }

		
		$sql2 = "INSERT INTO master.$table SELECT * FROM master.sections WHERE locked = '1'";
		$result2 = @mysql_query($sql2, $connection) or die("Insertion error!<br />Error #". mysql_errno() . ": " . mysql_error());

		if ($result2 > "0") { echo "Basic sections inserted into $table.<br />"; }



		} else if(mysql_errno() > 0){
		$update = "0";
	  	echo mysql_error();    
		}

	$results = mysql_query("SHOW PROFILE");  // for profiling only
			
##############################################################################################
## Now drop the table if it existed prior to this run and populate master.sections_next with the existing data from scheduler.sections
##############################################################################################
	

	if ($update > 0) {

	$sql_drop = "DROP table master.$table";
	$result_drop = @mysql_query($sql_drop, $connection) or die("Couldn't drop $table #". mysql_errno() . ": " . mysql_error());
	
	$sql = "CREATE TABLE master.$table LIKE master.sections";
	$result = @mysql_query($sql, $connection) or die("Table creation error!<br />Error #". mysql_errno() . ": " . mysql_error());
	
	if ($result > "0") { echo "Table $table created.<br />"; }

	
	$sql2 = "INSERT INTO master.$table SELECT * FROM master.sections WHERE locked = '1'";
	$result2 = @mysql_query($sql2, $connection) or die("Insertion error!<br />Error #". mysql_errno() . ": " . mysql_error());

	if ($result2 > "0") { echo "Basic sections inserted into $table.<br />"; }

	}


	$db = @mysql_select_db("scheduler", $connection) or die("Couldn't select scheduler: Error #". mysql_errno() . ": " . mysql_error());

		$sql3 = "SELECT section, course, supervisor, instructor, last, first, days, time, start, end, room
		FROM scheduler.sections WHERE active = '1'";
		## We'll use the active field in that table to determine if the section is on hold/cancelled or not.
		$result3 = @mysql_query($sql3, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		
		while ($row = mysql_fetch_array($result3)) {
		
		$last=$row['last'];
		$first=$row['first'];
		$username=$row['instructor'];
		$course=$row['course'];
		$section=$row['section'];
		$days=$row['days'];
		$time=$row['time'];
		$start=$row['start'];
		$end=$row['end'];
		$room=$row['room'];
		$supervisor=$row['supervisor'];
		
		
				$sql4 = "INSERT INTO master.$table (section,course,supervisor,instructor,days,time,room,active)
				VALUES
				(\"$section\",\"$course\",\"$supervisor\",\"$username\",\"$days\",\"$time\",\"$room\",\"1\")";
				$result4 = @mysql_query($sql4, $connection) or die("Insertion error<br>Error #". mysql_errno() . ": " . mysql_error());
				
				if ($result4) {
				print "$course, section $section was inserted.<br />";
				} else {
				print "<font color=maroon><b>$course, section $section was not added.</font></b><br />";
				}		
		
		
		
		}
		
		
		
		
?>