<?php

require '../config/databaseConfig.php';

session_start();

$errors = array(); 


if(isset($_POST['signup'])){
$username = $_POST['username'];
$password = $_POST['password'];
$country = $_POST['country'];
$bday = $_POST['bday'];
$result = mysqli_query($dbconn,"SELECT count(*) as total from users");
$data = mysqli_fetch_assoc($result);


$newID = intval($data['total'] + 1);
//CHeck if it is not empty
 if (empty($username)) { array_push($errors, "Username is required"); }
 if (empty($password)) { array_push($errors, "Password is required"); }
 if (empty($country)) { array_push($errors, "Country is required"); }
 if (empty($bday)) { array_push($errors, "Birthday is required"); }
	//Check input
if(!preg_match("/^[a-zA-Z]*$/", $username)){array_push($errors, "Username must contain only letters");} 
if(!preg_match("/^[a-zA-Z0-9]*$/", $password)){array_push($errors, "Password can contain only letters and numbers");}
		//Check if username is unique
$sql = "SELECT * FROM users WHERE trim(username) = \"".$username."\"";
$result = mysqli_query($dbconn, $sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0){ array_push($errors, "Username is alrady used. Please choose another one");}


if (count($errors) == 0) {
			//hashing the password
			//$hashedPwd = trim(password_hash($pass, PASSWORD_DEFAULT));
$hashedPwd = trim(password_hash($password, PASSWORD_BCRYPT, [12]));
			//$_SESSION['id'] = $row['id'];
			//insert the user
			/*echo $newID;
			echo $username;
			echo $hashedPwd;
			echo $country;
			echo $bday;*/
			//$query = "INSERT INTO 'users' ('id', 'username', 'password', 'country_id', 'birthday', 'profilePic_id') values (2, 'oana', 'pparola', 'usa', '11-01-1998', 2)";
			$time = strtotime($bday);
			$newbirthday = date('Y-m-d', $time);

			$picQuery = mysqli_query($dbconn, "SELECT count(*) as picId from profilePictures;");
			
			$data = mysqli_fetch_assoc($picQuery);
	

			$profilePic = rand(1, intval($data['picId']));
			
			$query = "INSERT INTO `users`(`id`, `username`, `password`, `country_id`, `birthday`, `profilePic_id`) VALUES (". $newID .", \"". $username ." \", \" ". $hashedPwd . " \" , " . $country . " , \"" . $newbirthday ." \",".$profilePic." )";

			
			$data = mysqli_query($dbconn,$query);
			
			/*if($result){
		echo '<br>Data inserted';
	}else{
		echo '<br><br>Insert FAILED';
	}*/
			$_SESSION['username'] = $username;
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
          <form action="" method = "post">
          <div class="fl"><input type="text" id="fname" name="regusername" placeholder="username.."></div>
          <div class="fl" ><input type="password" id="lname" name="regpassword" placeholder="password.."></div>
          <div class="fl"><input style="width: 210px;" type="submit" value="Login" name = "login"></div>
           </form>
      </div>
    </div>  
    <div>
      <div class="col-1"></div>
      <div class="col-4 motto">Don’t listen to what they say. Go see.</div>
      <div class="col-1"></div>
      <div class="col-5">
        <div  class="div1">
            <div class="title" style="font-size: 10px">Don't have an account yet?</div>
            <div class="title"><p>Sign up </p></div>
            
            <form action="" method="POST">
            	<?php include('errors.php'); ?>
                <label for="fname">Username:</label>
                <input style="width: 350px" type="text" id="fname" name="username" placeholder="username.." >
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
        </div>
      </div>


</body>
</html> 