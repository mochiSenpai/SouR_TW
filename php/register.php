<?php

require '../config/databaseConfig.php';

session_start();
if(isset($_SESSION['use']))   // Checking whether the session is already there or not if 
                              // true then header redirect it to the home page directly 
 {
    header("Location:home.php"); 
 }
 $login=array();
if(isset($_POST['login']))   // it checks whether the user clicked login button or not 
{
     $user = $_POST['user'];
     $pass = $_POST['pass'];

	 

  if($log = $dbconn->prepare("SELECT password,id FROM users WHERE trim(username) =?")) { 
   $log->bind_param('s', $user);
   $log->execute();
   
} else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}

$result = $log->get_result();
while($row = $result->fetch_assoc()) {
   array_push($login,$row);
}
if(!$login)
	echo"Nume utilizator sau parola gresita";

	 

if($login){
  
if(password_verify(trim($pass),trim($login[0]["password"])))
	{
			
		if (!$result || mysqli_num_rows($result) == 0){
	     echo "eroare";}
	 else
	 {   
                                    
          $_SESSION['use']=$login[0]['id'];
		  echo '<script type="text/javascript"> window.open("../php/home.php","_self");</script>';            //  On Successful Login redirects to home.php
	}
}
else {
			
	echo"Nume utilizator sau parola gresita";
			}
        
}}

$errors = array(); 


if(isset($_POST['signup'])){
$username = $_POST['username'];
$password = $_POST['password'];
$country = $_POST['country'];
$bday = $_POST['bday'];

//CHeck if it is not empty
 if (empty($username)) { array_push($errors, "Username is required"); }
 if (empty($password)) { array_push($errors, "Password is required"); }
 if (empty($country)) { array_push($errors, "Country is required"); }
 if (empty($bday)) { array_push($errors, "Birthday is required"); }
	//Check input
if(!preg_match("/^[a-zA-Z]*$/", $username)){array_push($errors, "Username must contain only letters");} 
if(!preg_match("/^[a-zA-Z0-9]*$/", $password)){array_push($errors, "Password can contain only letters and numbers");}
		//Check if username is unique
		
		
		
if($sig = $dbconn->prepare("SELECT * FROM users WHERE trim(username) = ?")) { 
   $sig->bind_param('s', $username);
   $sig->execute();
   
} else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}

$result = $sig->get_result();
while($row = $result->fetch_assoc()) {
  $resultCheck = mysqli_num_rows($result);
}

		
		

if($resultCheck > 0){ array_push($errors, "Username is alrady used. Please choose another one");}


if (count($errors) == 0) {
			//hashing the password
			//$hashedPwd = trim(password_hash($pass, PASSWORD_DEFAULT));
			
			
			
			
			
			
			
$result = mysqli_query($dbconn,"SELECT count(*) as total from users");
$data = mysqli_fetch_assoc($result);

$newID = intval($data['total'] + 2);
$_SESSION['use'] = $newID;

$hashedPwd = trim(password_hash($password, PASSWORD_BCRYPT, [12]));
			
			//insert the user
			
			$time = strtotime($bday);
			$newbirthday = date('Y-m-d', $time);

			$picQuery = mysqli_query($dbconn, "SELECT count(*) as picId from profilePictures;");
			
			$data = mysqli_fetch_assoc($picQuery);
	

			$profilePic = rand(1, intval($data['picId']));
			
			/*$query = "INSERT INTO `users`(`id`, `username`, `password`, `country_id`, `birthday`, `profilePic_id`) VALUES (". $newID .", \"". $username ." \", \" ". $hashedPwd . " \" , " . $country . " , \"" . $newbirthday ." \",".$profilePic." )";

			
			$data = mysqli_query($dbconn,$query);*/
			
			if($insert = $dbconn->prepare("INSERT INTO `users`(`id`, `username`, `password`, `country_id`, `birthday`, `profilePic_id`) VALUES
			(?,?,?,?,?,?)")) {
			$insert->bind_param('ssssss',  $newID,$username,$hashedPwd ,$country ,$newbirthday,$profilePic);
            $insert->execute();}
			else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}
			
		
			//$_SESSION['use'] = $newID;
			header('Location: ../php/profile.php');
			}
    }
	

	

?>


<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/IndexStyle.css">
 
</head>


<body>     
  <div class="desktop"> 
    <div class="container">           
      <div class="topbar">
          <form action="" method="post" autocomplete="off">
          <div class="fl"><input type="text" name="user" onkeyup="showHint(this.value)" ></div>
          <div class="fl" ><input type="password" name="pass"></div>
          <div class="fl"><input  style="width: 210px;" type="submit" name="login" value="LOGIN"></div>
           </form>
      </div>


       <script>
        function showHint(str) {
        if (str.length == 0) { 
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "gethint.php?q=" + str, true);
            xmlhttp.send();
    }
}
</script>
    </div> 


    <div>
       <div style="position: absolute; top: 60px; left: 817px;"> <p>Suggestions: <span id="txtHint"></span></p> </div>

      <div class="col-1"></div>
      <div class="col-4 motto">Don’t listen to what they say. Go see.</div>
      <div class="col-1"></div>
      <div class="col-5">
        <div  class="div1">
            <div class="title" style="font-size: 10px">Don't have an account yet?</div>
            <div class="title"><p>Sign up </p></div>
            
            <form action="" method="post" autocomplete="off">
            	<?php include('errors.php'); ?>
                <label for="fname">Username:</label>
                <input style="width: 350px" type="text" id="fname" name="username" placeholder="username.." onkeyup="giveHint(this.value)">
                <p>User: <span id="textHint"></span></p>
                <label for="lname">Password:</label>
                <input style="width: 350px" type="password" id="lname" name="password" placeholder="password..">
                <label  for="country">Country:</label>
                  <select style="width: 350px" id="country" name="country">

                    <option value="1">Romania</option>
                    <option value="2">France</option>
                    <option value="3">Italy</option>
                    <option value="4">Germany</option>
                    <option value="5">Sweden</option>
                    <option value="6">Norway</option>
                    <option value="7">Finland</option>
                    <option value="8">UK</option>
                    <option value="9">Spain</option>
                
                </select>  
                <label for="idate">Birthday:</label>
                    <input style="width: 350px" type="Date" id="idate" name="bday"> 
                    <input style="width: 350px" type="submit" value="Sign up" name = "signup">
            </form>
            <script>
              function giveHint(str) {
              if (str.length == 0) { 
                  document.getElementById("textHint").innerHTML = "";
                  return;
              } else {
                  var xmlhttp = new XMLHttpRequest();
                  xmlhttp.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                          document.getElementById("textHint").innerHTML = this.responseText;
                      }
                  };
                  xmlhttp.open("GET", "givehint.php?q=" + str, true);
                  xmlhttp.send();
    }
}
</script>
        </div>
      </div>


</body>
</html> 