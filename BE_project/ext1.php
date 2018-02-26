<?php
/*
require_once('dbconnect.php');
$query= "SELECT * FROM login_details WHERE no = 1";

if($result = mysqli_query(,$con,$query))
{
while($row=mysqli_fetch_row($result))
{
$email = $result[1];
$password=$result[2];
}
}
*/
//include("reg.php");
include("example.php");

header("refresh: 25; url ='http://localhost/ext1.php'");

#fetch the contents of the mail displayed on browser.
$h = file_get_contents("http://localhost/example.php");
//$h = file_get_contents(include("example.php"));

#parse the mail contents as string,then break and store it in array data structure.
$words = explode(" ",$h);




##perform a regular expression match and extract sentence as a whole from meeting to fullstop.


if(preg_match('/(Presentation\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Meeting\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Conference\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Consortium\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Match\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Summit\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Convocation\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Convention\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Gathering\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Panel\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Session\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Seminar\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Summit\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Symposium\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Workshop\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(Interview\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(presentation\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(meeting\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(conference\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(consortium\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(match\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(summit\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(convocation\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(convention\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(gathering\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(panel\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(session\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(seminar\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(summit\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(symposium\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(workshop\s+)(.*)(\s..*)/',$h,$abc) || preg_match('/(interview\s+)(.*)(\s..*)/',$h,$abc) || ){
//print_r($abc);
$msg = $abc[0];
echo $msg;
echo "<br>";
}


##various regular expressions to extract date,time formats
##pattern matching of date format dd-mm-yyyy
$pattern1 = "/\d{2}\-\d{2}\-\d{4}/";

$pattern2 = "/\d{2}\'/'\d{2}\'/'\d{4}/";
$pattern3 = "/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/";

if(preg_match($pattern1, $h, $matches2) ||  preg_match($pattern3,$h,$matches2) || preg_match($pattern2 ,$value,$matches2)) {
$date1 = $matches2[0];
   echo $date1;
echo "<br>";
}
##pattern matching of date format dd/mm/yyyy.

/*
if (preg_match($pattern2,$value,$matches3)){
$date = $matches3[0];
echo $date;
echo "<br>";
}
*/
##pattern matching of time format 23:59 am/pm.
$patt = "/(10|11|12|0?[1-9]):[0-5][0-9] (am|pm)/";
$patt1= '/([0-2][\d]):(\d{2})/';
if(preg_match($patt,$h,$time) || preg_match($patt1,$h,$time)){
$timing = $time[0];
echo $timing;
echo "<br>";
}



##pattern matching of date format dd-mm/m-yyyy.
/*
preg_match('/(\d{2})-(\D*)-(\d{4})/', $h, $matches1);
//print_r($matches1);
$date2=$matches1[0];
echo $date2;
echo "<br>";
*//*
##pattern matching of the date format dd/mm/yy(yy)
if(preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/',$h,$matches4)){
//print_r($matches4);
$date3= $macthes4[0];
echo $date3;
echo "<br>";
}*/
/*
##pattern matching of time format 00:00.
if(preg_match('/([0-2][\d]):(\d{2})/',$h,$abc)){
//print_r($abc);
echo @$abc[0];
echo "<br>";
}
/*

## pattern matching of format Sunday..Monday 1..3(0..9)st/th/nd/rd yyyy. 
$pattern = "/\w+day\s\d{1,2}(st|th|rd|nd)\s\w+/";
  if (preg_match($pattern, $value, $matches)) {
    //print_r($matches);
	echo @$matches[0];
echo "<br>";  
}

*/


define('HOST','localhost');
define('USER','root');
define('PASS','oracle');
define('DB','register');

$con = mysqli_connect("localhost","root","oracle","register") or die('unable to connect');


$sql = "INSERT INTO message_details (message , date , time)
VALUES ('$msg','$date1','$timing')";

if(mysqli_query($con,$sql)){
echo 'got mail';
}
else 
{echo 'wait';}

mysqli_close($con);


?>
