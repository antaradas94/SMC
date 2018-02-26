<?php
 

 


$username = $_GET['email'];
$password = $_GET['password'];

if($username == '' || $password == ''){
echo 'please fill values';
}

else{
require_once('dbconnect.php');
$sql= "SELECT * FROM login_details WHERE username ='$username'";

$check = mysqli_fetch_array(mysqli_query($con,$sql));

if(isset($check)){
echo 'welcome back'.$username;
}

else {
$sql = "INSERT INTO login_details (username,password)
VALUES ('$username','$password')";
if(mysqli_query($con,$sql)){
echo 'registered';}
else{echo 'try again';}
}
}

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
 mysqli_close($con);
*/
 
?>

