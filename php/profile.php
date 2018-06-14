<?php

require '../config/databaseConfig.php';
session_start();

$use = $_SESSION['use'];
//echo "\n\n\n";
//echo $user;



/*get user data*/

$userquerry = "SELECT * FROM users WHERE id =?";
if($userBasicData = $dbconn->prepare($userquerry)) { 
   $userBasicData->bind_param('s', $use);
   $userBasicData->execute();
   
} else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}

$result = $userBasicData->get_result();
while($row = $result->fetch_assoc()) {
   $userrow[] = $row;
}
if(!$userrow) exit('No rows');



/*get user country name*/
$userCountryQuery = "SELECT * FROM countries WHERE id = ?";

if($userCountry = $dbconn->prepare($userCountryQuery)) { 
   $country=$userrow[0]['country_id'];
   $userCountry->bind_param('s', $country);
   $userCountry->execute();
   
} else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}

$result =$userCountry->get_result();
while($row = $result->fetch_assoc()) {
  $countryrow[] = $row;
}
//if(!$countryrow) exit('No rows');


 
/*compute user age based on birthdate*/
 
  

$ageQuery = "SELECT TIMESTAMPDIFF(year, ?, now()) AS 'age'";

if($userAgePrepare = $dbconn->prepare($ageQuery)) { 
   $birthday=$userrow[0]['birthday'];
   $userAgePrepare->bind_param('s', $birthday);
   $userAgePrepare->execute();
   
} else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}

$result =$userAgePrepare->get_result();
while($row = $result->fetch_assoc()) {
  $userAge[] = $row;
}
if(!$userAge) exit('No rows');


/*get user data to display on profile*/
$username = $userrow[0]['username'];
$age = $userAge[0]['age'];
$birthday = $userrow[0]['birthday'];
$usercountry = $countryrow[0]['name'];

$profilePictureId = $userrow[0]['profilePic_id'];

/*get list of visited countries (ids)*/


$visitedCountriesQuery = "SELECT DISTINCT country_id from choices c join souvenirs s on c.id_souvenir = s.id WHERE c.id_user = ?";

if($visitedCountries = $dbconn->prepare($visitedCountriesQuery)) { 
   $country=$userrow[0]['country_id'];
 $visitedCountries->bind_param('s', $use);
 $visitedCountries->execute();
   
} else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}

$result = $visitedCountries->get_result();
$countriesCount= mysqli_num_rows($result);
while($row = $result->fetch_assoc()) {
  $countries[]=$row;
  
}
//if(!$countries) exit('No rows');



/*get list of liked items*/
$likedItemsQuery = "SELECT * FROM choices WHERE id_user =?";

if($likedItems = $dbconn->prepare($likedItemsQuery)) { 
$id=$userrow[0]['id'];
  $likedItems->bind_param('s', $id);
  $likedItems->execute();
   
} else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}

$result =$likedItems->get_result();
while($row = $result->fetch_assoc()) {
 $likedItemsCount= mysqli_num_rows($result);
}
//if(!$likedItemsCount) exit('No rows');




/*profile pic*/
$profilePicQuery = "SELECT * FROM profilePictures WHERE id = ?";

if($profilePicRes = $dbconn->prepare($profilePicQuery)) { 
   $profilePicRes->bind_param('s', $profilePictureId);
   $profilePicRes->execute();
   
} else {
    $error = $dbconn->errno . ' ' . $dbconn->error;
    echo $error; 
}

$result =$profilePicRes->get_result();
while($row = $result->fetch_assoc()) {
  $profilePictureArr[] = $row;
}
//if(!$profilePictureArr) exit('No rows');
$profilePicture = $profilePictureArr[0]['filename'];


?>



<html>

<head>
	<title> My Profile </title>

	<!--<link rel="stylesheet" type="text/css" href="../css/MyProfileStyle.css">-->
	<link rel="stylesheet" type="text/css" href="../css/MyProfileStyle.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

	<!--********************************* STICKY TOPBAR **************************-->

	<div id = "sidebar" style="top:2%; left: 6%;">
		<div>
			<div><p class = "menu"><img src="../images/empty.png" class = "icon"></p></div>

			<div><a href = "../php/profile.php"><p class = "menu"><img src="../images/profile.png" class = "icon zoom"></p></a></div>
			<div><a href = "../php/home.php"><p class = "menu"><img src="../images/search.png" class = "icon zoom"></p></a></div>
			<div><a href = 'logout.php'><p class = "menu"><img src="../images/logout.png" class = "icon zoom"></p></a></div>

		</div>
	</div>

	<div id = "sidebarSecond">
		
	</div>

	<!--******************************* STICKY TOPBAR END **************************-->


	<div class = "profile col-12">

		<div class = "col-2 break"></div>


		<div class="col-8 mainProfileSpace">

			<div id="description" class = "col-12">
				<div class = "col-2 empty"></div>

				<!--<div class = "col-3">-->
					<div class = "profilePicture col-2">
						<img src = '../images/<?php echo $profilePicture;?>' class = "imgProfile">
					</div>
				<!--</div>-->

				<div class = "col-1 empty"></div>

				<div class = "col-6 userDescription">
					<!--<div class = "userDescription">-->

						<div class = "username">
							<?php echo $username ?>
						</div>
						<div class = "countryAge">
							<?php
								echo $usercountry . ', ' . $age . ' years'
							?>
						</div>
						<div class = "dob"><?php echo $birthday ?></div>
					<!--</div>-->
				</div>

				<div class = "col-1 empty"></div>
			</div><!--end description div-->
	</div>

	<div class = "col-2 break"></div>
</div>


<div class = "profile col-12">

		<div class = "col-2 break"></div>

		<div class="col-8 mainProfileSpace">

			
			<div id = "accountStatus">
				<p class="normalP">You've been through</p>
				<p class = "countP"><?php echo $countriesCount ?> countries</p>
				<p class="normalP">and got interested in</p>
				<p class = "countP"><?php echo $likedItemsCount ?> souvenirs</p>
			</div>

		<?php
			$countryCounter = 0;
			echo count($countries);
			for($x=0;$x<=count($countries);$x++)
			{
				 $currentCountry = $countries[$x]['country_id'];
			echo $countries[$x]['country_id'];
		   
		  ?>

			<div id = "myItems">
				
				<div class = "country col-12">
					<div class = "col-2 empty"></div>

					<div class = "col-8">

						<button class = "accordion col-12"> 
						<?php
						
						
                             $countryNameQuery = "SELECT name FROM countries WHERE id =?";

                             if($countryName = $dbconn->prepare($countryNameQuery)) { 

                              $countryName->bind_param('s', $currentCountry);
                              $countryName->execute();
   
                              } else {
                              $error = $dbconn->errno . ' ' . $dbconn->error;
                              echo $error; }

                              $result =$countryName->get_result();
                              while($row = $result->fetch_assoc()) {
                              $cName[] = $row;
                             

 
						

							  echo  $row['name'];?> </button>
						<div class="panel col-12">
						<?php 
						
					$countryItemsQuery = 'SELECT * FROM choices c join souvenirs s on c.id_souvenir = s.id and country_id = ? and c.id_user = ?';

                   if($countryItems = $dbconn->prepare($countryItemsQuery)) { 
                       $countryItems>bind_param('ss', $currentCountry, $use);
                       $countryItems->execute();
   
                     } else {
                        $error = $dbconn->errno . ' ' . $dbconn->error;
                        echo $error; 
}

                   $result = $countryItems->get_result();
                   while($rows = $result->fetch_assoc()) {

						
						
							
						?>
						  <p class = "idea">
						  	§ &nbsp <?php echo "laaaa" ?>
						  </p>
						 <?php } ?>
						</div>
					</div>

					<div class = "col-2 empty"></div>
				</div>

			<?php }} ?>
			</div><!--end myItems div-->

		</div><!--end mainProfile div-->

		<div class="col-2"></div>			

	
		</div>
</div>


<script>
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
	  acc[i].addEventListener("click", function() {
	    this.classList.toggle("active");
	    var panel = this.nextElementSibling;
	    if (panel.style.maxHeight){
	      panel.style.maxHeight = null;
	    } else {
	      panel.style.maxHeight = panel.scrollHeight + "px";
	    } 
	  });
	}
</script>

</body>

</html>