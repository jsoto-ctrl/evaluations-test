<?


	$time = time();
	$this_month = date("n");
	$this_day = date("j");
	$this_day_week = date("l");
	$this_hour = date("h");
	$this_minute = date("i");
	$this_second = date("s");
	$meridian = date("A");
	$this_year = date("Y");
	$today = date("j M Y");
	$time_zone = date("T");
	
	#With leading zeros to get into strings
	$this_day_long = date("d");
	
	$this_day_zero = date("d");
	$this_month_zero = date("m");

	$this_month_long = date("M");
	$this_year_long = date("Y");
	$this_hour_long = date("H");
	$this_minute_long = date("i");
	#Minutes are not being used so leave them out
	$today_string = "$this_year_long$this_month_long$this_day_long$this_hour_long";
	$copyright = "$this_year_long";
	
	if ($this_month >= "1" && $this_month <= "5") {
	$DATEsession = "Spring";
	} else 	if ($this_month >= "8" && $this_month <= "12") {
	$DATEsession = "Fall";
	}
#	$now = "$this_month/$this_day/$this_year at $this_hour:$this_minute";

	$now = "".strftime("%m/%d/%Y at %H:%M:%S")."";
	$now_date = "$this_day_week, $this_month_long $this_day_long, $this_year_long";
	$now_time = "$this_hour_long:$this_minute_long:$this_second";

#### Month names
if ($month == "01") {
$month_name = "January";
} else if ($month == "02") {
$month_name = "February";
} else if ($month == "03") {
$month_name = "March";
} else if ($month == "04") {
$month_name = "April";
} else if ($month == "05") {
$month_name = "May";
} else if ($month == "06") {
$month_name = "June";
} else if ($month == "07") {
$month_name = "July";
} else if ($month == "08") {
$month_name = "August";
} else if ($month == "09") {
$month_name = "September";
} else if ($month == "10") {
$month_name = "October";
} else if ($month == "11") {
$month_name = "November";
} else if ($month == "12") {
$month_name = "December";
}
?>