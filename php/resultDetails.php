<?php


if(isset($_GET['country'])){
	$countryID = $_GET['country'];
	echo 'Country ID ' . $countryID;
}else{
	echo "country id ";
}

$monthValue = $_POST['month'];
$personType = $_POST['personType'];
$personGender = $_POST['gender'];

//echo $monthValue . ' ' . $personType . ' ' . $personGender;

?>