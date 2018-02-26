<?php

include("receivemail.class.php");

header("refresh: 85; url ='http://localhost/example.php'");

//$name = $GET['name'];
$email = $_GET['email'];
$password = $_GET['password'];

 
// Creating a object of reciveMail Class
$obj= new receiveMail('imap.gmail.com','itsaboutlinux@gmail.com','johnnybravo','imap','993',true,true);
//$obj= new receiveMail('imap.gmail.com','$email','$password','imap','993',true,true);

##Connect to the Mail Box
##If connection fails give error message and exit
$obj->connect();  

##Get Total Number of Unread Email in mail box as integer value.
$tot=$obj->get_total_emails();
echo "Total Mails:: $tot<br>";

for($i=$tot;$i>0;$i--)
{
##Get Header Info Return Array Of Headers as (subject,to,toOth,toNameOth,from,fromName)
	$head=$obj->get_email_header($i);  
	echo "Subjects :: ".$head['subject']."<br>";
	echo "TO :: ".$head['to']."<br>";	
        echo "To Other :: ".$head['toOth']."<br>";
	echo "ToName Other :: ".$head['toNameOth']."<br>";
	echo "From :: ".$head['from']."<br>";
	echo "FromName :: ".$head['fromName']."<br>";
	echo "<br><br>";
	echo "<br>";
##Get Body Of Mail number Return String Get Mail id in interger
	echo $obj-> get_email_body($i);  
	

	$ar=explode(",",$str);
	foreach($ar as $key=>$value)
		echo ($value=="")?"":"Atteched File :: ".$value."<br>";
	echo "<br>";
##Delete Mail from Mail box
	//$obj->deleteMails($i); 
}
//include("ext1.php");
##close mail box
$obj->close_mailbox();   

?>
