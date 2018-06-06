
<?php

require '../config/databaseConfig.php';
//require '../php/resultDetails.php';

$countryID = $_GET['countryID'];
$monthValue = $_GET['month'];
$personType = $_GET['personType'];
$personGender = $_GET['gender'];

$query = "SELECT * FROM souvenirs WHERE 
				country_id = '{$countryID}' AND 
				(gender_id = '{$personGender}' OR 
				gender_id = 3) AND
				('{$monthValue}' BETWEEN period_start AND period_end) AND
				('{$personType}' BETWEEN age_min AND age_max)
				ORDER BY rating_value DESC
				";
				

$data = mysqli_query($dbconn,$query);
/*
echo 'countryID = ' . $countryID;
echo '<br>monthValue = ' . $monthValue;
echo '<br>personType = ' . $personType;
echo '<br>personGender = ' . $personGender;
*/
?>

<hmtl>

<head>
	<title> Results </title>

	<link rel="stylesheet" type="text/css" href="../css/ResultsStyle.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>


<!--********************************* STICKY TOPBAR **************************-->

<div id = "sidebar" style="top:2%; left: 6%;">
	<div>
		<div><p class = "menu"><img src="../images/empty.png" class = "icon"></p></div>
		<div><a href = "../html/MyProfile.html"><p class = "menu"><img src="../images/profile.png" class = "icon zoom"></p></a></div>
		<div><a href = "../html/map-page.html"><p class = "menu"><img src="../images/search.png" class = "icon zoom"></p></a></div>
		<div><a href = "../html/signup.html"><p class = "menu"><img src="../images/logout.png" class = "icon zoom"></p></a></div>
	</div>
</div>

<div id = "sidebarSecond">

</div>


<!--******************************* STICKY TOPBAR END **************************-->


<div id = "pagewrapper">

<div class="col-12 breakrow"></div>

<center>
<div class="col-12">
	<h1 id="resTitleText" align="center"><a href="#" class="effect-underline">You may want to consider...</a></h1>
</div>
</center>

<div class="col-12 breakrow"></div>

<div class="row"> 

<div class="col-2 empty"></div>

<?php 
	while($row = mysqli_fetch_array($data)){
		$title = $row['name'];
		$itemDesc = $row['description'];
		$price = $row['price'];
		$imgSource = $row['photo_link'];

		?>
		<div class="col-3 option">

			<img src = '../images/<?php echo $imgSource?>' class="image">
			<div class = "itemTitle"> <?php echo $title?> </div>
			<div class = "itemDescription"> <?php echo $itemDesc?></div>
			<div class="priceTxt"><?php echo $price?> $</div>
				<button class = "button">

					<div class = "buttonText">I'd like this!</div>

				</button>

		</div>

		
	<?php
		if($row = mysqli_fetch_array($data)){
			$title = $row['name'];
			$itemDesc = $row['description'];
			$price = $row['price'];
			$imgSource = $row['photo_link'];
	?>
	
		<div class="col-2 empty"></div>
		<div class="col-3 option">
			<img src = '../images/<?php echo $imgSource?>' class="image">
			<div class = "itemTitle"> <?php echo $title?> </div>
			<div class = "itemDescription"> <?php echo $itemDesc?></div>
			<div class="priceTxt"><?php echo $price?> $</div>
				<button class = "button">

					<div class = "buttonText">I'd like this!</div>

				</button>

			</div>
		<?php } ?> 

		<div class="col-12 breakrow"></div>
<?php } ?> 
	
<!------- ANOTHER ROW OF IMAGES -------->


</div>


</body>

</html>