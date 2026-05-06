<html>
  <head>
<link href="https://www.iub.edu/~ancla/spanport/css/brand.css" rel="stylesheet">
<?

$page = "Student Evals: Search"; 
echo "<title>$page</title>";

?>
  </head>
  <body>
<?
include ("css/header.html");

?>      
<p>&nbsp;</p><h2>Student Evaluations: Search</h2>
	  <h3>Test upload from browser</h3>
<div class="content"><form method="post" action="search_results.php">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
	<td colspan="2"><p>Type in the last name you wish to look up. You can use wildcards to expand your search. The percent sign acts like a wildcard. Think of it as having the meaning of <i>whatever.</i></p>
	<hr><h4>Search examples</h4>
	
	<p>Strict search: Enter "Soto" and only instructors with that exact last name will be retrieved.</p>
	<p>Wildcard search: Enter "Sot%" and instructors with last names that start with "SOT" will be retrieved. Results may include "Sotomayor," "Sotarro," besides "Soto." 
	You can also enter the wildcard sign at the beginning of the last name, as in "%son" and the program will show "Anderson" and "Henderson" if available. Enclose a few letters within wildcards and the program will look for the occurrence of
	 those few letters within a last name, as in "%der%", which would generate results such as "An<b>der</b>sen", "An<b>der</b>ssen", "An<b>der</b>son", "Hen<b>der</b>son", etc.</p><p>The wildcard option may be handy if you don't recall exactly how the last name is spelled.</p>
	<p>Upper and lower cases are irrelevant in this search.</p>	<hr>

	 </td>
  </tr>
  <tr>
    <td width="50%"><strong>Last name </strong>(wildcards % allowed)</td>
    <td width="50%"><strong>
      <input name="query_lastname" type="text" id="last_name" value="" size=20 maxlength=255>
    </strong></td>
  </tr>
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="75%" align="left"><strong>
      <input type="submit" name="submit" value="Look up last name">
    </strong></td>
  </tr>
</table></form></div><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<?
include ("css/footer.php");

?>       </body>
  </html>
