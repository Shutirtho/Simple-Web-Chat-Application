
<?php
    
    session_start();
    if(isset($_GET['logout'])){
        //User has opted to logout
        $fp = fopen("log".$_GET['lognum'].".html", 'a');//User chat details stored in files with name log(sum of ids)
        fwrite($fp, "<div class='msgln'><i>User ". $_GET['nm'] ." has left the chat session.</i><br></div>");
        fclose($fp);
        unset($_SESSION['name'.$_GET['uid']]);//remove user data from session variable
        
        header("Location: index.php"); //Redirect the user to the login page
    }
    ?>
<!DOCTYPE html>
<html>
<head>
<title>Chat-Box</title>
<link type="text/css" rel="stylesheet" href="style.css" />
</head>


<div id="wrapper">
<div id="menu">
<p class="welcome">Chatting with <b><?php echo $_GET['nm']; ?></b></p>
<p class="logout"><a id="exit" href="#">Exit Chat</a></p>
<div style="clear:both"></div>
</div>

<div id="chatbox"></div>
<?php
session_start();
$mysqliconn1 = new mysqli('127.0.0.1','root','password','chat');

if($mysqliconn1->connect_error)
{

	die('connect error ('. $mysqliconn1->connect_errno.')'.$mysqliconn1->connect_error);

}
$idmm=$_GET['idm'];
$name11=mysqli_query($mysqliconn1,"SELECT name FROM User WHERE id='$idmm'");
$name1=$name11->fetch_assoc();
$name=$name1['name'];




    //Chat log files are named as log100101 for users with userids 100 & 101,log102103 for users with userids 102 & 103 and so on
    if($_GET['idm']<$_GET['idf'])
    {
        $sum=($_GET['idm']*1000)+$_GET['idf'];
    }
    else{
        $sum=($_GET['idf']*1000)+$_GET['idm'];
        }
    
if(file_exists("log".$sum.".html") && filesize("log".$sum.".html") > 0){
    $handle = fopen("log".$sum.".html", "r");
    $contents = fread($handle, filesize("log".$sum.".html"));
    fclose($handle);

   
}
?>

<form name="message" action="">
<input name="usermsg>" type="text" id="usermsg" size="63" />
<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
</form>
</div>

<!--The following divs are used to transfer value from php script to javascript using DOM -->
<div id="myid" style="display: none;">
    <?php 
        $idmm = $_GET['idm']; 
        echo $idmm;//This transfers the id of user
        ?>
        </div>
        
 <div id="fname" style="display: none;">
    <?php 
        $name=$name1['name'];//This transfers the name of user who leaves the chat session
        echo $name;
        ?>
  </div>
 
<div id="lognum" style="display: none;">
    <?php 
        //This will transfer the unique ending of log filename for each pair of users

        if($_GET['idm']<$_GET['idf'])
        {
            $sum=($_GET['idm']*1000)+$_GET['idf'];
        }
        else{
            $sum=($_GET['idf']*1000)+$_GET['idm'];
            }
        echo $sum;
        ?>
</div>          

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js">
</script>

<script type="text/javascript">

$(document).ready(function(){

	//Retrieve data from php script
	var div = document.getElementById("fname");
	var nm = div.textContent;//name of user who leaves the chat session
	var div = document.getElementById("lognum");
	var lognum = parseInt(div.textContent,10);//unique ending of log filenames for each pair of users
	var div = document.getElementById("myid");
	var myid = parseInt(div.textContent,10);//id of user
  
   $("#exit").click(function(){
       var exit = confirm("Are you sure you want to end the session?");
       if(exit==true){window.location.href = "chat1.php?logout=true&lognum="+lognum+"&nm="+nm+"&uid="+myid;}
   });


   $("#submitmsg").click(function(){
      var clientmsg = $("#usermsg").val();//grab user entered message
      if(clientmsg.toString().length>0)
      {
      $.post("post.php", {text: clientmsg,number: lognum,userid: myid});//send it to post.php for storing it in file for display
      }
      $("#usermsg").attr("value", "");//clear the message input box
      return false;
   });
   
   setInterval (loadLog, 2500);//Reload file every 2500 ms
                              

//Load the file containing the chat data
function loadLog(){
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;

    $.ajax({ url: "log"+lognum+".html",
             cache: false,
             success: function(html){
                $("#chatbox").html(html);//Insert the chat data into the chatbox
                var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
                if(newscrollHeight > oldscrollHeight){
                    $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); 
                }
             },
    });
}
});
</script>



</body>
</html>
