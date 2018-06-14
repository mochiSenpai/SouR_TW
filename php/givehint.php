<?php

require '../config/databaseConfig.php';
// run query
$result = mysqli_query($dbconn, "SELECT * FROM users");


while ($row = mysqli_fetch_array($result)) {
    $a[] = $row['username'];
}



$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $q = str_replace(' ', '', $q);
    foreach($a as $name) {
        if (stristr($q, str_replace(' ', '', $name))) {
            $hint = "taken";
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "available" : $hint;
?>