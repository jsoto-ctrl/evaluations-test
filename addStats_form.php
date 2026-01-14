<html>
  <head>
<link href="https://www.iub.edu/~ancla/spanport/css/brand.css" rel="stylesheet">
<?

$page = "Student Evals: Data Entry"; 
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
$year = date("Y");
$this_month = date("n");

	if ($this_month >= "1" && $this_month <= "4") {
	$expectedYear = ($year - 1);
	} else {
	$expectedYear = $year;
	}	
	
?>      


<p>&nbsp;</p><h2>Student Evaluations: Enter Stats</h2>
<h3>Enter stats for <? echo "$first $last" ?></h3>

<div class="content"><form method="post" action="addStats_results.php">

<table width="100%" border="0" cellspacing="0" cellpadding="15">

  <tr>
    <td width="25%">Course:</td><td width="75%"><input name="add_course" type="text" id="add_course" value="" size=20 maxlength=255></td>  </tr>
    <tr>  <td width="25%">Section:</td><td width="75%"><input name="add_section" type="text" id="add_section" value="" size=20 maxlength=255></td>  </tr>
 
     <tr> <td width="25%">Term:</td><td width="75%">
     
<select name="add_term">
<option value="" selected>Select</option>

<option value="Fall">Fall</option>
<option value="Spring">Spring</option>
<option value="Summer I">Summer I</option>
<option value="Summer II">Summer II</option>
</select>
     
     
     </td>  </tr>
<tr>   <td width="25%">Year:</td><td width="75%"><input name="add_year" type="text" id="add_year" value="<? echo "$expectedYear"; ?>"  size=20 maxlength=255></td> </tr>
<tr>   <td width="25%">Type:</td><td width="75%">


<select name="add_type">
<option value="" selected>Select</option>
<option value="Mid-Term">Mid-Term</option>
<option value="Semester">End-of Term</option>

</select>

</tr>
  <tr><td width="25%">Outstanding Course:</td><td width="75%"><input name="add_mean1" type="text" id="add_mean1" value="" size=20 maxlength=255></td></tr>
 <tr><td width="25%">Outstanding Instructor:</td><td width="75%"><input name="add_mean2" type="text" id="add_mean2" value="" size=20 maxlength=255></td>
  </tr>
  <tr>

   
    <td colspan = "4"><p>&nbsp;</p><center>
      <input type="submit" name="submit" value="Add">
    </center>
    <input type="hidden" name = "user" value = "<? echo "$query_user"; ?>">
    <input type="hidden" name = "last" value = "<? echo "$last"; ?>">
    <input type="hidden" name = "first" value = "<? echo "$first"; ?>">
    <input type="hidden" name = "appointment" value = "<? echo "$appointment"; ?>">
    
    
    
    </td>
  </tr>
</table></form></div><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<?
include ("css/footer.php");

?>       </body>
  </html>