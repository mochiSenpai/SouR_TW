
<?php

require '../config/databaseConfig.php';

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

$itemsID = array();
$counter = 0;

session_start();


/*
echo 'countryID = ' . $countryID;
echo '<br>monthValue = ' . $monthValue;
echo '<br>personType = ' . $personType;
echo '<br>personGender = ' . $personGender;
*/

if(isset($_POST['add'])){
	add($_POST['add']);
}

function add($val){
	require '../config/databaseConfig.php';
	$suvID = intval($val);

	$use = $_SESSION['use'];

	//$newIDQuery = "SELECT COUNT(*) AS 'total' FROM choices WHERE id_user =..";
	$result = mysqli_query($dbconn,"SELECT count(*) as total from choices");
	$data = mysqli_fetch_assoc($result);

	$newID = intval($data['total'] + 1);
	//echo 'New ID = '.$newID . '<br><br>';

	$insertQuery = "INSERT INTO `choices`(`id`, `id_user`, `id_souvenir`) VALUES (". $newID .",". $use ."," . $suvID . ")";
	//echo $insertQuery;
	$result = mysqli_query($dbconn,$insertQuery);
	/*
	if($result){
		echo '<br>Data inserted';
	}else{
		echo '<br><br>Insert FAILED';
	}
	*/

}

?>

<html>

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
		<div><a href = "../php/profile.php"><p class = "menu"><img src="../images/profile.png" class = "icon zoom"></p></a></div>
		<div><a href = "../php/home.php"><p class = "menu"><img src="../images/search.png" class = "icon zoom"></p></a></div>
		<div><a href='logout.php'><p class = "menu"><img src="../images/logout.png" class = "icon zoom"></p></a></div>
	</div>
</div>

<div id = "sidebarSecond">

</div>


<!--******************************* STICKY TOPBAR END **************************-->


<div id = "pagewrapper">

<?php 

	$num_rows = mysqli_num_rows($data);

	if($num_rows == 0){
		?>
		<div class="col-12 breakrow"></div>
		<div class="col-12 breakrow"></div>
		<div class="col-12 breakrow"></div>
		<center>
		<div class="col-12">
			<h1 id="resTitleText" align="center"><a href="#" class="effect-underline">Unfortulately... <br> we found no matches for your requirements :(</a></h1>
		</div>
		</center>

		<?php
		exit();
	}else{ ?>
		<div class="col-12 breakrow"></div>
		<center>
		<div class="col-12">
			<h1 id="resTitleText" align="center"><a href="#" class="effect-underline">You may want to consider...</a></h1>
		</div>
		</center>
<?php

	}
?>




<div class="col-12 breakrow"></div>

<div class="row"> 

<div class="col-2 empty"></div>

<?php 
	while($row = mysqli_fetch_array($data)){
		$itemsID[$counter] = $row['id'];
		$counter = $counter + 1;

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
			<form action = "<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
				<button onclick="add()" class = "button" name = "add" value = "
				<?php echo $itemsID[$counter - 1]; ?>" >

					<div class = "buttonText">I'd like this!</div>

				</button>
			</form>

		</div>

		
	<?php
		if($row = mysqli_fetch_array($data)){
			$itemsID[$counter] = $row['id'];
			$counter = $counter + 1;

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
				<form action = "<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
				<button onclick="add()" class = "button" name = "add" value = "
				<?php echo $itemsID[$counter - 1]; ?>" >

					<div class = "buttonText">I'd like this!</div>

				</button>
			</form>

			</div>
		<?php } ?> 

		<div class="col-12 breakrow"></div>
		<div class="row"> 

<div class="col-2 empty"></div>
<?php } ?> 
<div class="col-2">

</div>

</div>

<center>

<style>
.buttonExport {
    position: relative;
    background-color: #8F0907;
    border: none;
    font-size: 16px;
    color: #FFFFFF;
    padding: 20px;
    width: 150px;
    text-align: center;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    text-decoration: none;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 5px 5px #251B1B;
}

.buttonExport:after {
    content: "";
    background: #8F0907;
    display: block;
    position: absolute;
    padding-top: 300%;
    padding-left: 350%;
    margin-left: -20px!important;
    margin-top: -120%;
    opacity: 0;
    transition: all 0.8s
}

.buttonExport:active:after {
    padding: 0;
    margin: 0;
    opacity: 1;
    transition: 0s
}

</style>

<form action="" method="post">
    <input type="submit" class="buttonExport" name="exportXML" value="Format as XML" />
	<input type="submit" class="buttonExport" name="exportHTML" value="Format as HTML" />
    <input type="submit" class="buttonExport" name="exportJSON" value="Format as JSON" />
	<input type="submit" class="buttonExport" name="exportCSV" value="Format as CSV" />

</form>
</center>

<div class="col-12 breakrow"></div>

</body>
</html>

<?php
 

 function getDataToExport($databaseConn){
 	$countryID = $_GET['countryID'];
	$monthValue = $_GET['month'];
	$personType = $_GET['personType'];
	$personGender = $_GET['gender'];

 	$queryForExport = "SELECT * FROM souvenirs WHERE 
				country_id = '{$countryID}' AND 
				(gender_id = '{$personGender}' OR 
				gender_id = 3) AND
				('{$monthValue}' BETWEEN period_start AND period_end) AND
				('{$personType}' BETWEEN age_min AND age_max)
				ORDER BY rating_value DESC
				";
				

	$mydata = mysqli_query($databaseConn,$queryForExport);

	return $mydata;
 }

   
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['exportXML']))
    {
    	$dataToExport = getDataToExport($dbconn);
        XML($dataToExport);
    }
 
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['exportHTML']))
    {
    	$dataToExport = getDataToExport($dbconn);
        HTML($dataToExport);
    }
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['exportJSON']))
    {
    	$dataToExport = getDataToExport($dbconn);
        JSON($dataToExport);
    }
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['exportCSV']))
    {
    	$dataToExport = getDataToExport($dbconn);
        CSV($dataToExport);
    }

    function XML($newDataToExport){

 	
	
   $filePath = '../exports/FormatXML.xml';

   $dom = new DOMDocument('1.0', 'utf-8'); 
   $root = $dom->createElement('suveniruri'); 
   
 
	$rows = array();
	while($newRow = mysqli_fetch_assoc($newDataToExport)) {
	    $rows[] = $newRow;
		
	}

		//var_dump( $rows);
	


 for($x=0;$x<count($rows);$x++)
	{
	   $id= $rows[$x]['id'];
	   $nume=  $rows[$x]["name"];
	   $des=  $rows[$x]["description"];
	   $photo= $rows[$x]["photo_link"];
	   $price=  $rows[$x]["price"];
	
    $book = $dom->createElement('suvenir');
    $ID= $dom->createElement('id', $id); 
    $book->appendChild($ID); 
	$NUME=$dom->createElement('nume', $nume); 
	$book->appendChild($NUME);
	$DESCRIPTION=$dom->createElement('description', $des); 
	$book->appendChild($DESCRIPTION);
	$PHOTO=$dom->createElement('link_photo', $photo); 
	$book->appendChild($PHOTO);
	$PRICE=$dom->createElement('price', $price); 
	$book->appendChild($PRICE);
    $root->appendChild($book); 
   }
   
   $dom->appendChild($root); 
   $dom->save($filePath); 
}





 function HTML($newDataToExport){
	
	$therows = array();

	while($newRow = mysqli_fetch_assoc($newDataToExport)) {
	    $therows[] = $newRow;
		
	}

$myfile = fopen("../exports/exportAsHTML.html", "w") or die("Unable to open file!");


   
$data = "<table border = '1'>";
fwrite($myfile, $data);
$txt = "<tr><td>ID</td><td>Name</td><td>Description</td><td>Photo</td><td>Price</td></tr>\n";
fwrite($myfile,$txt );
for($x=0;$x<count($therows);$x++)
	{
	   $id= $therows[$x]['id'];
	   $nume=  $therows[$x]["name"];
	   $des=  $therows[$x]["description"];
	   $photo= $therows[$x]["photo_link"];
	   $price=  $therows[$x]["price"];
	$text = "<tr><td>".$id."</td><td>".$nume."</td><td>".$des."</td><td>".$photo."</td><td>".$price."</td></tr>\n";
	fwrite($myfile, $text);

}

$end = "</table>";
fwrite($myfile, $end);

	fclose($myfile);  
     
 } 
  function JSON($newDataToExport){
	
	$rows = array();
	while($newRow = mysqli_fetch_assoc($newDataToExport)) {
	    $rows[] = $newRow;
	}

	
	fclose($myfile);   
 } 

  function CSV($newDataToExport){
	
	
     echo "FormatCSV";

    
     
 } 
?>