<<<<<<< HEAD
=======
<?php

require '../config/databaseConfig.php';
session_start();

$user = $_SESSION['username'];
echo "\n\n\n";
echo $user;

$userBasicDataQuery = "SELECT * FROM users WHERE trim(username) = \"".$user."\""; //de preluat din cookie/sesiune
$userBasicData = mysqli_query($dbconn, $userBasicDataQuery);
//echo mysqli_num_rows($userBasicData);
$userrow = mysqli_fetch_assoc($userBasicData);



//echo $userrow['country_id'];

$userCountryQuery = "SELECT * FROM countries WHERE id = ".$userrow['country_id'];
$userCountry = mysqli_query($dbconn, $userCountryQuery);
$countryrow = mysqli_fetch_array($userCountry);


$ageQuery = "SELECT TIMESTAMPDIFF(year, '" . $userrow['birthday'] . "', curdate()) AS 'age'";
$userAgePrepare = mysqli_query($dbconn, $ageQuery);
$userAge = mysqli_fetch_array($userAgePrepare);

$username = $userrow['username'];
$age = $userAge['age'];
$birthday = $userrow['birthday'];
$country = $countryrow['name'];
$profilePictureId = $userrow['profilePic_id'];


$visitedCountriesQuery = "SELECT DISTINCT country_id from choices c join souvenirs s on c.id_souvenir = s.id WHERE c.id_user = ".$userrow['id'];
$visitedCountries = mysqli_query($dbconn, $visitedCountriesQuery);
$countriesCount = mysqli_num_rows($visitedCountries);

$likedItemsQuery = "SELECT * FROM choices WHERE id_user =".$userrow['id'];
$likedItems = mysqli_query($dbconn, $likedItemsQuery);
$likedItemsCount = mysqli_num_rows($likedItems);


$profilePicQuery = "SELECT * FROM profilePictures WHERE id = " . $profilePictureId;
$profilePicRes = mysqli_query($dbconn, $profilePicQuery);
$profilePictureArr = mysqli_fetch_array($profilePicRes);
$profilePicture = $profilePictureArr['filename'];


//echo $profilePicture;
/*
echo 'Username = ' . $username . '<br>';
echo 'Country = ' . $country . '<br>';
echo 'Birthday = ' . $birthday .'<br>';
echo 'Age = ' . $age . '<br>';
echo 'Number of countries = ' . $countriesCount . '<br>';
echo 'Souvenirs = ' . $likedItemsCount . '<br>';
echo 'Imgsrc = ' . $profilePicture;
*/
?>



>>>>>>> b7b431379799430242817584c6894a0401cbc588
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
<<<<<<< HEAD
			<div><a href = "../html/MyProfile.html"><p class = "menu"><img src="../images/profile.png" class = "icon zoom"></p></a></div>
			<div><a href = "../html/map-page.html"><p class = "menu"><img src="../images/search.png" class = "icon zoom"></p></a></div>
			<div><a href='logout.php'><p class = "menu"><img src="../images/logout.png" class = "icon zoom"></p></a></div>
=======
			<div><a href = "../php/profile.php"><p class = "menu"><img src="../images/profile.png" class = "icon zoom"></p></a></div>
			<div><a href = "../html/map-page.html"><p class = "menu"><img src="../images/search.png" class = "icon zoom"></p></a></div>
			<div><a href = "../html/signup.html"><p class = "menu"><img src="../images/logout.png" class = "icon zoom"></p></a></div>
>>>>>>> b7b431379799430242817584c6894a0401cbc588
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
<<<<<<< HEAD
						<img src="../images/prof-pic.png" class = "imgProfile">

=======
						<img src = '../images/<?php echo $profilePicture;?>' class = "imgProfile">
>>>>>>> b7b431379799430242817584c6894a0401cbc588
					</div>
				<!--</div>-->

				<div class = "col-1 empty"></div>

				<div class = "col-6 userDescription">
					<!--<div class = "userDescription">-->
<<<<<<< HEAD
						<div class = "username">Username</div>
						<div class = "countryAge">Romania, 20 years</div>
						<div class = "dob">17 - March - 1997</div>
=======
						<div class = "username">
							<?php echo $username ?>
						</div>
						<div class = "countryAge">
							<?php
								echo $country . ', ' . $age . ' years'
							?>
						</div>
						<div class = "dob"><?php echo $birthday ?></div>
>>>>>>> b7b431379799430242817584c6894a0401cbc588
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
<<<<<<< HEAD
				<p class = "countP">4 countries</p>
				<p class="normalP">and got interested in</p>
				<p class = "countP">10 souvenirs</p>
			</div>

=======
				<p class = "countP"><?php echo $countriesCount ?> countries</p>
				<p class="normalP">and got interested in</p>
				<p class = "countP"><?php echo $likedItemsCount ?> souvenirs</p>
			</div>

		<?php
			$countryCounter = 0;
			while($countryRow = mysqli_fetch_array($visitedCountries)){
				$currentCountry = $countryRow['country_id'];
		  ?>
>>>>>>> b7b431379799430242817584c6894a0401cbc588

			<div id = "myItems">
				
				<div class = "country col-12">
					<div class = "col-2 empty"></div>

					<div class = "col-8">
<<<<<<< HEAD
						<button class = "accordion col-12"> France </button>
						<div class="panel col-12">
						  <p class = "idea">đź—¸ Marseille Soap</p>
						  <p class = "idea">đź—¸ Wine</p>
						  <p class = "idea">đź—¸ Eiffel Tower Keychain</p>
						  <p class = "idea">đź—¸ Sea Salt</p>
						</div>
					</div>

					<div class = "col-2 empty"></div>
				</div>

				<div class = "country col-12">
					<div class = "col-2 empty"></div>

					<div class = "col-8">
						<button class = "accordion col-12"> Nederlands </button>
						<div class="panel col-12">
						  <p class = "idea">đź—¸ Quality spoon</p>
						</div>
					</div>

					<div class = "col-2 empty"></div>
				</div>

				<div class = "country col-12">
					<div class = "col-2 empty"></div>

					<div class = "col-8">
						<button class = "accordion col-12"> Great Britain </button>
						<div class="panel col-12">
						  <p class = "idea">đź—¸ Tea</p>
						  <p class = "idea">đź—¸ Tea cup</p>
						  <p class = "idea">đź—¸ Big Ban Keychain</p>
=======
						<button class = "accordion col-12"> <?php
						$countryNameQuery = "SELECT name FROM countries WHERE id =" . $currentCountry;
						$countryName = mysqli_query($dbconn, $countryNameQuery);
						$cName = mysqli_fetch_array($countryName);

						echo $cName['name']; ?> </button>
						<div class="panel col-12">
						<?php 
							$countryItemsQuery = 'SELECT * FROM choices c join souvenirs s on c.id_souvenir = s.id and country_id = '. $currentCountry;
							$countryItems = mysqli_query($dbconn,$countryItemsQuery);

							while($item = mysqli_fetch_array($countryItems)){

						?>
						  <p class = "idea">
						  	§ &nbsp <?php echo $item['name'] ?>
						  </p>
						 <?php } ?>
>>>>>>> b7b431379799430242817584c6894a0401cbc588
						</div>
					</div>

					<div class = "col-2 empty"></div>
				</div>

<<<<<<< HEAD
				<div class = "country col-12">
					<div class = "col-2 empty"></div>

					<div class = "col-8">
						<button class = "accordion col-12"> Germany </button>
						<div class="panel col-12">
						  <p class = "idea">đź—¸ Ceramic beer bottle</p>
						  <p class = "idea">đź—¸ Personalized T-Shirt</p>
						</div>
					</div>

					<div class = "col-2 empty"></div>
				</div>
=======
		<?php } ?>
>>>>>>> b7b431379799430242817584c6894a0401cbc588
			</div><!--end myItems div-->

		</div><!--end mainProfile div-->

		<div class="col-2"></div>			

	
		</div>
</div>



<<<<<<< HEAD
<div class="footer col-12" >
<div class="dropdown">
<p>Contact</p>
      <div class="dropdown-content">
      <p>Phone:0767705960</p>
      <p>Email:SouR@gmail.com</p>
	  <p>Adress:Iasi,Amurgului,11 </p>
</div></div>


<div class="footertext1">
<p>Contact</p>
</div>
<div class="footertext2">

<p>Phone: 0233456789</p>
<p>Email: SouR@gmail.com
</p>
<p>Adress:Iasi,Amurgului,11 </p>

</div>
</div>

<center>
<div  class="bottombar col-12 ">
@Copyright 2018
</div> 
</center>

=======
>>>>>>> b7b431379799430242817584c6894a0401cbc588

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