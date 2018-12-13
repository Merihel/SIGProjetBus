<?php

ini_set('display_errors', false);

require("MyDB.php");

$finPointArray = array();
$finLatArray = array();
$finLongArray = array();
$allArcs = array();
$allChemins = array();

initFile($finPointArray, $finLatArray, $finLongArray, $allArcs, $allChemins);

function initFile($finPointArray, $finLatArray, $finLongArray, $allArcs, $allChemins) {
    $allArray = getAllPoints($finPointArray, $finLatArray, $finLongArray);
    $allChemins = getAllArcs($allArcs, $allArray[0], $allArray[1], $allArray[2], $allChemins);
    return $allChemins;
}

function getAllPoints($finPointArray, $finLatArray, $finLongArray) {
    $db1 = new MyDB();
    $result = $db1->query("SELECT * FROM GEO_POINT");
    
    array_push($finPointArray, 0);
    array_push($finLatArray, 0);
    array_push($finLongArray, 0);

    while ($row = $result->fetchArray()) {
        $tempLatArray = array();
        $tempLongArray = array();

        array_push($tempLatArray, $row[0]);
        array_push($tempLatArray, $row[1]);
        array_push($tempLongArray, $row[0]);
        array_push($tempLongArray, $row[2]);

        array_push($finPointArray, $row[0]);
        array_push($finLatArray, $tempLatArray);
        array_push($finLongArray, $tempLongArray);
    }

    return [$finPointArray, $finLatArray, $finLongArray];
}


function getAllArcs($allArcs, $finPointArray, $finLatArray, $finLongArray, $allChemins) {
    $db2 = new MyDB();
    $resultArc = $db2->query("SELECT * FROM GEO_ARC");
    while ($row = $resultArc->fetchArray()) {
        array_push($allArcs, $row);
    }
    /*

    echo "<pre>FinLatArray - ";
    var_dump($finLatArray);
    //var_dump($point1);
    echo "</pre>"; 

    echo "<pre>AllArcs - ";
    var_dump($allArcs);
    echo "</pre>"; 
    echo count($allArcs) . " est le nombre d'arcs <br/>";
    */
    for ($s=0; $s<count($allArcs); $s++) {
        $arrayChemins = array();
        $db3 = new MyDB();
        //echo $s." - ";
        $chemin = $db3->query("SELECT * FROM GEO_ARC WHERE GEO_ARC_ID =".$allArcs[$s][0]);
        while ($row = $chemin->fetchArray()) {
            //var_dump($row);
            $row["GEO_ARC_DISTANCE"] = calculDistance($row["GEO_ARC_DEB"], $row["GEO_ARC_FIN"], $finLatArray, $finLongArray);
            array_push($arrayChemins, $row);
        }
        array_push($allChemins, $arrayChemins);
    }

    return $allChemins;
}

function calculDistance($point1, $point2, $finLatArray, $finLongArray) {

    //echo "<script>console.log('CALCUL DISTANCE FOR ".$point1." & ".$point2."')</script>";

    $point1 = $point1 - 1;
    $point2 = $point2 - 1;

    $p1Lat = $finLatArray[$point1][1];
    $p1Lng = $finLongArray[$point1][1];
    $p2Lat = $finLatArray[$point2][1];
    $p2Lng = $finLongArray[$point2][1];

    $unit = 'M';
            
    $rlat1 = pi() * $p1Lat/180;
    $rlat2 = pi() * $p2Lat/180;
    $rlon1 = pi() * $p1Lng/180;
    $rlon2 = pi() * $p2Lng/180;
    
    $theta = $p1Lng-$p2Lng;
    $rtheta = pi() * $theta/180;

    $dist = sin($rlat1) * sin($rlat2) + cos($rlat1) * cos($rlat2) * cos($rtheta);
    $dist = acos($dist);
    $dist = $dist * 180/pi();
    $dist = $dist * 60 * 1.1515;
    
    if ($unit=="K") { $dist = $dist * 1.609344; }
    if ($unit == "M") { $dist = $dist * 1.609344 * 1000; }
    if ($unit == "N") { $dist = $dist * 0.8684; }

    //echo "<script>console.log('We got ".$dist." for ".$point1." and ".$point2."')</script>";
    
    return $dist;
}

?>