<?php

if(isset($_GET['filename'])){
	$filepath = $_GET['filename'];

	if($filepath == '../exports/exportAsXML.xml'){
		header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename("exportAsXML.xml"));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($filepath));
	    readfile($filepath);
	    exit;
	}

	if($filepath == '../exports/exportAsHTML.html'){
		header('Content-Type: application/html');
	    header('Content-Disposition: attachment; filename='.basename("exportAsHTML.html"));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($filepath));
	    readfile($filepath);
	    exit;
	}

	if($filepath == '../exports/exportAsCSV.csv'){
		header('Content-Type: application/csv');
	    header('Content-Disposition: attachment; filename='.basename("exportAsCSV.csv"));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($filepath));
	    readfile($filepath);
	    exit;
	}

	if($filepath == '../exports/exportAsJSON.json'){
		header('Content-Type: application/json');
	    header('Content-Disposition: attachment; filename='.basename("exportAsJSON.json"));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($filepath));
	    readfile($filepath);
	    exit;
	}	
}

?>