<?php 
##Main ReciveMail Class File 

//$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['password'];



class ReceiveMail 
{ 
    private $protocol= 'imap'; 
	private $hostname= 'imap.gmail.com';
	private $port = 993;
	private $username= 'itsaboutlinux@gmail.com';
	private $password= 'johnnybravo';
	//private $username= '$email';
	//private $password= '$password';
	private $ssl = true;
	private $novalidate = false;
##create protected mailbox on local m/c.	
    protected $mybox=''; 
    protected $is_connected = false;
	protected $error_msg = array();
	
	public function __construct($host=null,$user=null,$pass=null,$protocol=null,$port=null,$ssl=null,$novalidate=null)
	{
## assign the users mailbox credits for local mailbox 
		$this->hostname = (is_null($host) ? $this->hostname : $host);
		$this->username = (is_null($user) ? $this->username : $user);
		$this->password = (is_null($pass) ? $this->password : $pass);
		$this->protocol = (is_null($protocol) ? $this->protocol : $protocol);
		$this->port = (is_null($port) ? $this->port : $port);
		$this->ssl = (is_null($ssl) ? $this->ssl : $ssl);
		$this->novalidate = (is_null($novalidate) ? $this->novalidate : $novalidate);
	}
     
##Connect To the Mail Box 
    public function connect() 
    { 
##establish connection to mail server using protocol
		$con = '{'.$this->hostname.':'.$this->port.'/'.$this->protocol.($this->ssl?'/ssl':'').($this->novalidate?'/novalidate-cert':'').'}INBOX';
##open connection if connection iss established else display error message.
        $this->mybox=imap_open($con,$this->username,$this->password) or die('Can not connect to '.$this->hostname.' on port '.$this->port.': '.imap_last_error()); 

##receive in local mailbox        
        if($this->mybox) 
        { 
			$this->is_connected = true;
			return true;
		}
		return false;
    } 
	public function is_connected()
	{
		return $this->is_connected;
	}
## fetch mail header content.
    public function get_email_header($mid=null) 
    { 
        if(!$this->is_connected || is_null($mid)) 
            return false; 

        $mail_header=imap_headerinfo($this->mybox,$mid);
//echo imap_fetchheader($this->mybox,$mid);
##mail header info is stored in array data structure.
        $sender=$mail_header->from[0]; 
        $sender_replyto=$mail_header->reply_to[0]; 
		$mail_details = array();
        if(strtolower($sender->mailbox)!='mailer-daemon' && strtolower($sender->mailbox)!='postmaster') 
        { 
##mail date and time details stored in array datastructure
            $mail_details=array( 
				'datetime'=>date("Y-m-d H:i:s",$mail_header->udate),
				'from'=>strtolower($sender->mailbox).'@'.$sender->host, 
				'fromName'=>$sender->personal, 
				'replyTo'=>strtolower($sender_replyto->mailbox).'@'.$sender_replyto->host, 
				'replyToName'=>$sender_replyto->personal, 
				'subject'=>iconv_mime_decode($mail_header->subject,0, "utf-8"),
				'to'=>strtolower($mail_header->toaddress),
				'full_header'=>serialize($mail_header)
			); 
        } 
        return $mail_details; 
    } 
## total number of mails extracted.
	public function get_total_emails()
    { 
        if(!$this->is_connected) 
            return false; 
##displaying total no of mails.
		return imap_num_msg($this->mybox); 
    } 
## fetching body of email contents
    public function get_email_body($mid=null,$format='text') 
    { 
        if(!$this->is_connected || is_null($mid)) 
            return false; 
		
	$body = "";
## if body content is in text format store content is local mailbox mybox.
	if(strtolower($format) == 'text')
		$body = $this->get_part($this->mybox, $mid, "TEXT/HTML"); 
        
        if ($body == "") 
            $body = $this->get_part($this->mybox, $mid, "TEXT/PLAIN"); 
        if ($body == "") { 
            return ""; 
        } 
        return $body; 
    }  

##delete mail content
    public function delete_email($mid=null) 
    { 
        if(!$this->is_connected || is_null($mid)) 
            return false; 
    
        imap_delete($this->mybox,$mid); 
    } 
## close mailbox when connection is lost.
    public function close_mailbox() 
    { 
        if(!$this->is_connected) 
            return false; 

        imap_close($this->mybox,CL_EXPUNGE); 
    } 
##Get Mime type Internal Private Use 
    private function get_mime_type(&$structure) 
    { 
##mime_type helps in
        $primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"); 
        
        if($structure->subtype) { 
            return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype; 
        } 
        return "TEXT/PLAIN"; 
    } 
##Get Part Of Message Internal Private Use 
    private function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false) 
    { 
        if(!$structure) { 
            $structure = imap_fetchstructure($stream, $msg_number); 
        } 
        if($structure) { 
            if($mime_type == $this->get_mime_type($structure)) 
            { 
                if(!$part_number) 
                { 
                    $part_number = "1"; 
                } 
                $text = imap_fetchbody($stream, $msg_number, $part_number); 
				
				if($structure->encoding == 1) {
					return imap_utf8($text);
				}
                else if($structure->encoding == 3) 
                { 
                    return imap_base64($text); 
                } 
                else if($structure->encoding == 4) 
                { 
                    return imap_qprint($text); 
                } 
                else 
                { 
                    return $text; 
                } 
            } 
            if($structure->type == 1) /* multipart */ 
            { 
                while(list($index, $sub_structure) = each($structure->parts)) 
                { 
					$prefix='';
                    if($part_number) 
                    { 
                        $prefix = $part_number . '.'; 
                    } 
                    $data = $this->get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1)); 
                    if($data) 
                    { 
                        return $data; 
                    } 
                } 
            } 
        } 
        return false; 
    } 
} 
?>
