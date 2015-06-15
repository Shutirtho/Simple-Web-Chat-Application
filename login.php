
<!DOCTYPE html>
<html>
<head>
<title>FRIEND-LIST</title>
<link type="text/css" rel="stylesheet" href="style.css" />
</head>


<?php
    
    session_start();
    if(isset($_GET['logout'])){
        //User has opted to logout without starting a chat
        unset($_SESSION['name'.$_GET['uid']]);
        //session_destroy();
        header("Location: index.php"); //Redirect the user to the login page
    }
    ?>

<?php
    
    $mysqliconn1 = new mysqli('127.0.0.1','root','password','chat');//open connection to db
	
     if($mysqliconn1->connect_error)
                   {
	
			     die('connect error ('. $mysqliconn1->connect_errno.')'.$mysqliconn1->connect_error);
	
		           }
		           
		          $uid=$_GET['userid'] ;
		           
		           //fetch friendlist names from database for user
		            $friend111=mysqli_query($mysqliconn1,"SELECT friend1 FROM User WHERE id='$uid'");
		           	$friend222=mysqli_query($mysqliconn1,"SELECT friend2 FROM User WHERE id='$uid'");
		           	$friend333=mysqli_query($mysqliconn1,"SELECT friend3 FROM User WHERE id='$uid'");
		           	$friend444=mysqli_query($mysqliconn1,"SELECT friend4 FROM User WHERE id='$uid'");
		           	$friend555=mysqli_query($mysqliconn1,"SELECT friend5 FROM User WHERE id='$uid'");
		           	$friend11=$friend111->fetch_assoc();
		           	$friend22=$friend222->fetch_assoc();
		           	$friend33=$friend333->fetch_assoc();
		           	$friend44=$friend444->fetch_assoc();
		           	$friend55=$friend555->fetch_assoc();
		           	$friend1=mysqli_query($mysqliconn1,"SELECT name FROM User WHERE id='$friend11[friend1]'");
		           	$friend2=mysqli_query($mysqliconn1,"SELECT name FROM User WHERE id='$friend22[friend2]'");
		           	$friend3=mysqli_query($mysqliconn1,"SELECT name FROM User WHERE id='$friend33[friend3]'");
		           	$friend4=mysqli_query($mysqliconn1,"SELECT name FROM User WHERE id='$friend44[friend4]'");
		           	$friend5=mysqli_query($mysqliconn1,"SELECT name FROM User WHERE id='$friend55[friend5]'");
		            $f1=$friend1->fetch_assoc();
		           	$f2=$friend2->fetch_assoc();
		           	$f3=$friend3->fetch_assoc();
		           	$f4=$friend4->fetch_assoc();
		           	$f5=$friend5->fetch_assoc();
		           	
		           	
?>
        		           


<div id="wrapper">
<div id="menu">
<p class="welcome">Welcome,<b><?php echo strtoupper($_SESSION['name'.$uid][1]); ?> </b> Select a friend to chat with</p>
<p class="logout"><a id="exit" href="#">Exit Chat</a></p>
<div style="clear:both"></div>
</div>

<div id="myid" style="display: none;">
<?php
    $uid=$_GET['userid'];//This div is used to transfer the userid of user to javascript
    echo $uid;
    ?>
</div>


<!--Buttons for friendlist-->
<div id="friendlist">
<button type="button" class="myButton" id="btn1" name="<?=strtoupper($f1[name])?>" value="<?=$friend11[friend1]?>"><?=strtoupper($f1[name])?></button><br>
<button type="button" class="myButton" id="btn2" name="<?=strtoupper($f2[name])?>" value="<?=$friend22[friend2]?>"><?=strtoupper($f2[name])?></button><br>
<button type="button" class="myButton" id="btn3" name="<?=strtoupper($f3[name])?>" value="<?=$friend33[friend3]?>"><?=strtoupper($f3[name])?></button><br>
<button type="button" class="myButton" id="btn4" name="<?=strtoupper($f4[name])?>" value="<?=$friend44[friend4]?>"><?=strtoupper($f4[name])?></button><br>
<button type="button" class="myButton" id="btn5" name="<?=strtoupper($f5[name])?>" value="<?=$friend55[friend5]?>"><?=strtoupper($f5[name])?></button><br>
</div>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js">
</script>

<script type="text/javascript">

$(document).ready(function(){
                  
    var div = document.getElementById("myid");//Retrieve the userid of user from php script
    var myid = parseInt(div.textContent,10);
  
   $("#exit").click(function(){
       var exit = confirm("Are you sure you want to end the session?");
       if(exit==true){
           window.location = 'login.php?logout=true&uid='+myid;}
   });

  //First friend button selected
   $("#btn1").click(function(){
      id=$(this).val();
      name=$(this).attr("name");
      location.href=("chat1.php?idf="+id+"&nm="+name+"&idm="+myid);//redirect to chat box
   });

   //Second friend button selected
   $("#btn2").click(function(){
      id=$(this).val();
      name=$(this).attr("name");
      location.href=("chat1.php?idf="+id+"&nm="+name+"&idm="+myid);//redirect to chat box
      
   });
                  
   //Third friend button selected
   $("#btn3").click(function(){
      id=$(this).val();
      name=$(this).attr("name");
      location.href=("chat1.php?idf="+id+"&nm="+name+"&idm="+myid);//redirect to chat box
   });
                  
   //Fourth friend button selected
   $("#btn4").click(function(){
      id=$(this).val();
      name=$(this).attr("name");
      location.href=("chat1.php?idf="+id+"&nm="+name+"&idm="+myid);//redirect to chat box
   });
                  
   //Fifth friend button selected
   $("#btn5").click(function(){
      id=$(this).val();
      name=$(this).attr("name");
      location.href=("chat1.php?idf="+id+"&nm="+name+"&idm="+myid);//redirect to chat box
           
   });

});
</script>



</body>
</html>