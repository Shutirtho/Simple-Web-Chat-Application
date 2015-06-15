
<?php session_start();


function loginForm(){
echo'
<div id="loginform">
<form action="" method="post">
<p>Please enter your login information to continue:</p>
    <label for="userid">User-Id #: </label>
<input type="number" name="userid" id="userid" /><br />
<label for="upassword">Password:</label>
<input type="password" name="upassword" id="upassword" /><br />
<input type="submit" name="enter" id="enter" value="Enter" />
</form>
</div>
';
}

   if(isset($_POST['userid']) && isset($_POST['upassword'])){
	//protected against sql injection
	$uid =  stripslashes(htmlspecialchars($_POST['userid']));
	$pass = stripslashes(htmlspecialchars($_POST['upassword']));
	if(!$error) {
	
		// connect to database
	
		$mysqliconn = new mysqli('127.0.0.1','root','password','chat');
	
     if($mysqliconn->connect_error)//connection failed
                   {
	
			     die('connect error ('. $mysqliconn->connect_errno.')'.$mysqliconn->connect_error);
	
		           }
		
		
		
	
     //Get user data from db
    $result=mysqli_query($mysqliconn,"SELECT * FROM User WHERE id='$uid' and password='$pass'");

    // Mysqli_num_row is counting table row
     $count=mysqli_num_rows($result);
     // If result matched $myusername and $mypassword, table row must be 1 row
     if($count==1)
         {
            
            $nameq=mysqli_query($mysqliconn,"SELECT name FROM User WHERE id='$uid' and password='$pass'");
           
           $result=$nameq->fetch_assoc();
           if(!isset($_SESSION['name'.$uid])){
           	//Storing both userid and name of user in session variable
            $_SESSION['name'.$uid]=array("(string)$uid","$result[name]");
            
            header("Location:login.php?userid=".$uid);
           }
           else{
               //User tries to login from two tabs
           	echo '<span class="error">Please logout from previous session to login!</span>';
           	loginForm();
           	
           }

          }
     else {//User enters wrong login details
	        echo '<span class="error">Incorrect UserId/Password!</span>';
           }
}
}



?>


<!DOCTYPE html>
<html>
<head>
<title>chat</title>
<link type="text/css" rel="stylesheet" href="style.css" />
</head>

<?php
if(!isset($_SESSION['name'.$uid])){
loginForm();
}


?>





</body>
</html>


