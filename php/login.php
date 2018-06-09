


 
 
 <?php
 require '../config/databaseConfig.php';
 session_start();  // session starts with the help of this function 



if(isset($_SESSION['use']))   // Checking whether the session is already there or not if 
                              // true then header redirect it to the home page directly 
 {
    header("Location:home.php"); 
 }

if(isset($_POST['login']))   // it checks whether the user clicked login button or not 
{
     $user = $_POST['user'];
     $pass = $_POST["pass"];

	 
	
	 $sql =mysqli_query( $dbconn,"SELECT password,id FROM users WHERE trim(username) ='$user'");
	 
	 
  $row = mysqli_fetch_array($sql);
echo $row[0];
echo $row[1];
  

  
if(password_verify(trim($pass),trim($row["password"])))
	{
			
		if (!$sql || mysqli_num_rows($sql) == 0){
	     echo "eroare";}
	 else
	 {   
          $result = mysqli_num_rows($sql);                             
          $_SESSION['use']=$row[1];
		  echo '<script type="text/javascript"> window.open("../php/home.php","_self");</script>';            //  On Successful Login redirects to home.php
	}}
else {
			
	echo"Nume utilizator sau parola gresita";
			}
        
}
 ?>





<html>

<head>
<title> Login Page   </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/IndexStyle.css">
</head>


<body>     
  <div class="desktop"> 
    <div class="container">           
      <div class="topbar">
          <form action="" method="post">
          <div class="fl"><input type="text" name="user" ></div>
          <div class="fl" ><input type="password" name="pass"></div>
          <div class="fl"><input  style="width: 210px;" type="submit" name="login" value="LOGIN"></div>
           </form>
      </div>
    </div>  
	</div>
	
	<div class="col-1"></div>
      <div class="col-4 motto">Don’t listen to what they say. Go see.</div>
      <div class="col-1"></div>
      <div class="col-5">
        <div  class="div1">
            <div class="title" style="font-size: 10px">Don't have an account yet?</div>
            <div class="title"><p>Sign up </p></div>
            <form action="../html/map-page.html">
                <label for="fname">Username:</label>
                <input style="width: 350px" type="text" id="fname" name="username" placeholder="username..">
                <label for="lname">Password:</label>
                <input style="width: 350px" type="password" id="lname" name="password" placeholder="password..">
                <label  for="country">Country:</label>
                  <select style="width: 350px" id="country" name="country">
                    <option value="australia">Australia</option>
                    <option value="canada">Canada</option>
                    <option value="usa">USA</option>
                    <option value="australia">Romania</option>
                    <option value="canada">Italia</option>
                    <option value="usa">Mexic</option>
                    <option value="australia">Canada</option>
                    <option value="canada">China</option>
                    <option value="usa">Portugalia</option>
                     <option value="australia">Danemarca</option>
                    <option value="canada">Finlanda</option>
                    <option value="usa">Ungaria</option>
                </select>  
                <label for="idate">Birthday:</label>
                    <input style="width: 350px" type="Date" id="idate" name="bday"> 
                    <input style="width: 350px" type="submit" value="Sign up">
            </form>
        </div>
      </div>
	</body>