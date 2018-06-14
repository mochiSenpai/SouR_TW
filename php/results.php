
<?php
session_start(); 
ob_start();

      if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
       {
           header("Location:register.php");  
       }
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
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.45.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.45.0/mapbox-gl.css' rel='stylesheet' />

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
<form action="" method="post">
    <input type="submit" class="buttonExport" name="exportXML" value="Format as XML" />
	<input type="submit" class="buttonExport" name="exportHTML" value="Format as HTML" />
    <input type="submit" class="buttonExport" name="exportJSON" value="Format as JSON" />
	<input type="submit" class="buttonExport" name="exportCSV" value="Format as CSV" />

</form>
</center>

<div class="col-12 breakrow"></div>
<div class="col-12 breakrow"></div>
<div class="col-12 breakrow"></div>


<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.2.0/mapbox-gl-geocoder.min.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.2.0/mapbox-gl-geocoder.css' type='text/css' />
<div id='map' style = 'width: 100%; height: 600px'></div>


<script>
mapboxgl.accessToken = 'pk.eyJ1IjoibWVnaXRzdW5lc2FtYSIsImEiOiJjamlmMTJjdXMwMzNlM3hwcHh3a3BtaWo2In0.CpfazKnqMuv1RUUG15E_VA';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/navigation-guidance-day-v2',
    center: [-79.4512, 43.6568],
    zoom: 13
});

map.addControl(new MapboxGeocoder({
    accessToken: mapboxgl.accessToken
}));



map.on('load', function(){

	map.addLayer({
		'id': 'souvs',
		'type' : 'fill',
		'source' :{
			'type' : 'geojson',
			'data' : {
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              12.460899353027342,
              41.90636538970964
            ],
            [
              12.458839416503906,
              41.904449008830824
            ],
            [
              12.455577850341797,
              41.902277040963696
            ],
            [
              12.455406188964844,
              41.89537735883385
            ],
            [
              12.467422485351562,
              41.88592102814744
            ],
            [
              12.482185363769531,
              41.88093672300255
            ],
            [
              12.496948242187498,
              41.88515423727906
            ],
            [
              12.498493194580078,
              41.890393791460134
            ],
            [
              12.495059967041014,
              41.89780510977138
            ],
            [
              12.485618591308594,
              41.90163821282425
            ],
            [
              12.472572326660156,
              41.90585436043303
            ],
            [
              12.460899353027342,
              41.90636538970964
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          14.18060302734375,
          40.863679665481676
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          14.2218017578125,
          40.853293085675155
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          14.20257568359375,
          40.88133311333721
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          13.216552734375,
          38.07836562996712
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          13.370361328125,
          38.06106741381201
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              9.181137084960938,
              45.49263040497991
            ],
            [
              9.181137084960938,
              45.49263040497991
            ],
            [
              9.181137084960938,
              45.49263040497991
            ],
            [
              9.181137084960938,
              45.49263040497991
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              9.170494079589844,
              45.497202941621225
            ],
            [
              9.151268005371094,
              45.49287107405929
            ],
            [
              9.138908386230469,
              45.48877955983892
            ],
            [
              9.130325317382812,
              45.4733735463996
            ],
            [
              9.136505126953125,
              45.46133466725163
            ],
            [
              9.155044555664062,
              45.44881150540617
            ],
            [
              9.193840026855469,
              45.451460867719966
            ],
            [
              9.209976196289062,
              45.46085305860481
            ],
            [
              9.221305847167969,
              45.469280615977105
            ],
            [
              9.216156005859375,
              45.48276208721778
            ],
            [
              9.213409423828125,
              45.49238973487207
            ],
            [
              9.189720153808594,
              45.49816553360498
            ],
            [
              9.170494079589844,
              45.497202941621225
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          9.178047180175781,
          45.508031152686875
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          9.18731689453125,
          45.51260243872574
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          7.6677703857421875,
          45.06260912911284
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {
        "marker-color": "#00d500",
        "marker-size": "medium",
        "marker-symbol": ""
      },
      "geometry": {
        "type": "Point",
        "coordinates": [
          10.3271484375,
          43.89789239125797
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          11.557617187499998,
          43.8503744993026
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Point",
        "coordinates": [
          12.7880859375,
          43.42100882994726
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              27.577056884765625,
              47.17104415159213
            ],
            [
              27.566070556640625,
              47.16730970131578
            ],
            [
              27.56744384765625,
              47.14956747670928
            ],
            [
              27.593536376953125,
              47.148633511301426
            ],
            [
              27.605895996093746,
              47.15797242686648
            ],
            [
              27.60177612304687,
              47.172911278266604
            ],
            [
              27.577056884765625,
              47.17104415159213
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              25.882415771484375,
              47.56540738772852
            ],
            [
              25.87005615234375,
              47.557993859037765
            ],
            [
              25.885162353515625,
              47.5459446373605
            ],
            [
              25.89752197265625,
              47.537601245618134
            ],
            [
              25.92361450195312,
              47.54779854409145
            ],
            [
              25.92498779296875,
              47.558920607496525
            ],
            [
              25.907135009765625,
              47.56540738772852
            ],
            [
              25.882415771484375,
              47.56540738772852
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              25.34683227539062,
              47.357431944587034
            ],
            [
              25.335845947265625,
              47.349989032003215
            ],
            [
              25.352325439453125,
              47.34161450055501
            ],
            [
              25.371551513671875,
              47.349989032003215
            ],
            [
              25.36056518554687,
              47.360222766169485
            ],
            [
              25.34683227539062,
              47.357431944587034
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              23.860931396484375,
              47.921864146583786
            ],
            [
              23.866424560546875,
              47.916342040161155
            ],
            [
              23.89251708984375,
              47.90713721964109
            ],
            [
              23.90350341796875,
              47.920943836444415
            ],
            [
              23.882904052734375,
              47.929226038300406
            ],
            [
              23.860931396484375,
              47.921864146583786
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              23.6041259765625,
              46.73044845188485
            ],
            [
              23.63983154296875,
              46.75679832604253
            ],
            [
              23.60687255859375,
              46.78689669816405
            ],
            [
              23.54644775390625,
              46.78313532151751
            ],
            [
              23.54095458984375,
              46.74738913515841
            ],
            [
              23.6041259765625,
              46.73044845188485
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              24.19464111328125,
              45.767522962149876
            ],
            [
              24.1973876953125,
              45.78284835197676
            ],
            [
              24.1204833984375,
              45.805828539928356
            ],
            [
              24.13970947265625,
              45.76943886620391
            ],
            [
              24.19464111328125,
              45.767522962149876
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              25.5816650390625,
              45.59482210127054
            ],
            [
              25.7025146484375,
              45.606352077118316
            ],
            [
              25.675048828125,
              45.64860838388028
            ],
            [
              25.521240234375,
              45.637087095718734
            ],
            [
              25.521240234375,
              45.590978249451936
            ],
            [
              25.5816650390625,
              45.59482210127054
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              28.5699462890625,
              44.11125397357155
            ],
            [
              28.63037109375,
              44.17038488259618
            ],
            [
              28.553466796875,
              44.209772586984485
            ],
            [
              28.509521484375,
              44.17038488259618
            ],
            [
              28.498535156249996,
              44.11914151643737
            ],
            [
              28.5699462890625,
              44.11125397357155
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              2.274169921875,
              48.748945343432936
            ],
            [
              2.4609375,
              48.75618876280552
            ],
            [
              2.48291015625,
              48.90805939965008
            ],
            [
              2.35107421875,
              48.929717630629554
            ],
            [
              2.197265625,
              48.91527985344383
            ],
            [
              2.13134765625,
              48.7996273507997
            ],
            [
              2.274169921875,
              48.748945343432936
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              -1.043701171875,
              44.98811302615805
            ],
            [
              -1.16455078125,
              44.86365630540611
            ],
            [
              -1.142578125,
              44.715513732021336
            ],
            [
              -0.889892578125,
              44.72332018895825
            ],
            [
              -0.85693359375,
              44.793530904744074
            ],
            [
              -0.8349609375,
              44.91813929958515
            ],
            [
              -1.043701171875,
              44.98811302615805
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              2.032470703125,
              41.51680395810118
            ],
            [
              2.13134765625,
              41.335575973123916
            ],
            [
              2.274169921875,
              41.45919537950706
            ],
            [
              2.48291015625,
              41.582579601430346
            ],
            [
              2.2961425781249996,
              41.672911819602085
            ],
            [
              2.032470703125,
              41.51680395810118
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              -3.6035156249999996,
              40.111688665595956
            ],
            [
              -3.33984375,
              40.3130432088809
            ],
            [
              -3.53759765625,
              40.49709237269567
            ],
            [
              -4.130859375,
              40.48038142908172
            ],
            [
              -4.04296875,
              40.16208338164617
            ],
            [
              -3.6035156249999996,
              40.111688665595956
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              -6.85546875,
              37.52715361723378
            ],
            [
              -6.43798828125,
              37.28279464911045
            ],
            [
              -6.0205078125,
              37.24782120155428
            ],
            [
              -6.1962890625,
              37.37015718405753
            ],
            [
              -6.85546875,
              37.52715361723378
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              -0.362548828125,
              51.56341232867588
            ],
            [
              -0.45043945312499994,
              51.49506473014368
            ],
            [
              -0.3076171875,
              51.358061573190916
            ],
            [
              0.02197265625,
              51.39920565355378
            ],
            [
              0.142822265625,
              51.48822432632349
            ],
            [
              -0.098876953125,
              51.56341232867588
            ],
            [
              -0.362548828125,
              51.56341232867588
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              -2.252197265625,
              53.51418452077113
            ],
            [
              -2.230224609375,
              53.38332836757156
            ],
            [
              -1.8896484375,
              53.35710874569601
            ],
            [
              -1.878662109375,
              53.494581793167185
            ],
            [
              -2.13134765625,
              53.55988897245464
            ],
            [
              -2.252197265625,
              53.51418452077113
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              4.921875,
              43.44494295526125
            ],
            [
              4.9658203125,
              43.42100882994726
            ],
            [
              5.064697265625,
              43.27720532212024
            ],
            [
              5.25146484375,
              43.29320031385282
            ],
            [
              5.2734375,
              43.38109758727857
            ],
            [
              4.921875,
              43.44494295526125
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              13.304443359375,
              52.55631606540653
            ],
            [
              13.304443359375,
              52.55631606540653
            ],
            [
              13.304443359375,
              52.55631606540653
            ],
            [
              13.304443359375,
              52.55631606540653
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              13.2275390625,
              52.382305628707854
            ],
            [
              13.875732421875,
              52.382305628707854
            ],
            [
              13.875732421875,
              52.60971939156648
            ],
            [
              13.2275390625,
              52.60971939156648
            ],
            [
              13.2275390625,
              52.382305628707854
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              11.019287109375,
              49.38237278700955
            ],
            [
              11.6015625,
              49.38237278700955
            ],
            [
              11.6015625,
              49.532339195028115
            ],
            [
              11.019287109375,
              49.532339195028115
            ],
            [
              11.019287109375,
              49.38237278700955
            ]
          ]
        ]
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "type": "Polygon",
        "coordinates": [
          [
            [
              9.580078125,
              53.48804553605622
            ],
            [
              10.546875,
              53.48804553605622
            ],
            [
              10.546875,
              53.69670647530323
            ],
            [
              9.580078125,
              53.69670647530323
            ],
            [
              9.580078125,
              53.48804553605622
            ]
          ]
        ]
      }
    }
  ]
}
}
	});
});

</script>


<div class="col-12 breakrow"></div>
<div class="col-12 breakrow"></div>
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

 	
	
   $filePath = '../exports/exportAsXML.xml';

   $dom = new DOMDocument('1.0', 'utf-8'); 
   $root = $dom->createElement('suveniruri'); 
   
 
	$rows = array();
	while($newRow = mysqli_fetch_assoc($newDataToExport)) {
	    $rows[] = $newRow;
		
	}

		//var_dump( $rows);
	
	 for($x=0;$x<count($rows);$x++)	{
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

	   header('Location: exports.php?filename=../exports/exportAsXML.xml');
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

	for($x=0;$x<count($therows);$x++){
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
	

	header('Location: exports.php?filename=../exports/exportAsHTML.html');
} 


  function JSON($newDataToExport){
	
	$rows = array();
	while($newRow = mysqli_fetch_assoc($newDataToExport)) {
	    $rows[] = $newRow;
	}

	$myfile = fopen("../exports/exportAsJSON.json", "w") or die ("Unable to open file!");
	$txt = json_encode($rows);
	fwrite($myfile, $txt);	
	fclose($myfile);

	header('Location: exports.php?filename=../exports/exportAsJSON.json');
 } 

  function CSV($newDataToExport){
		$header = array("Name", "Description", "Price","ImageSource");
		$file = fopen("../exports/exportAsCSV.csv", "w");
		fputcsv($file, $header,';','"');

		while ($row = mysqli_fetch_assoc($newDataToExport)){
			$line = array($row['name'], $row['description'], $row['price'], $row['photo_link']);
		    fputcsv($file, $line,';','"');
		}

		fclose($file);

	    header('Location: exports.php?filename=../exports/exportAsCSV.csv');
	}



?>