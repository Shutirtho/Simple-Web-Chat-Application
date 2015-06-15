<?php
session_start();
$uid=$_POST['userid'];//user id of user
date_default_timezone_set('America/Los_Angeles');
if(isset($_SESSION['name'.$uid])){
   $text = $_POST['text'];//message to be enterd into chat log
   $num=$_POST['number'];//unique ending of chat log filename

   $fp = fopen("log".$num.".html", 'a');//chat log file is opened for writting
   fwrite($fp, "<div class='msgln'>(".date("l g:i A").") <b>".$_SESSION['name'.$uid][1]."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
   fclose($fp);
}
?>