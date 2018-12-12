<?php

echo "<head><script src='conv.js'></head>"

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('db.sqlite');
    }
}

$db = new MyDB();

$finPointArray = array();
$finLatArray = array();
$finLongArray = array();

for ($i=1; $i<=259; $i++) {
    $result = $db->query("SELECT * FROM GEO_POINT WHERE GEO_POI_ID=".$i);

    $arrayData = $result->fetchArray();

    /*
    echo "<pre>";
    var_dump($arrayData[0]);
    var_dump($arrayData[1]);
    var_dump($arrayData[2]);
    echo "</pre>";
    */

    array_push($finPointArray, $arrayData[0]);
    array_push($finLatArray, $arrayData[1]);
    array_push($finLongArray, $arrayData[2]);

}

/*
echo "<pre>";
var_dump(count($finPointArray));
var_dump(count($finLatArray));
var_dump(count($finLongArray));
var_dump($finPointArray);
var_dump($finLatArray);
var_dump($finLongArray);
echo "</pre>";
*/


$arcArrayId = array();
$arcArrayDeb = array();
$arcArrayFin = array();

$distanceBetweenPoints = null;

for ($j=1; $j<=count($finPointArray); $j++) {
    $indexPlus = $j+1;
    $point1 = $finPointArray[$j];
    $point2 = $finPointArray[$indexPlus];

    $p1Lat = $finLatArray[$j];
    $p1Lng = $finLongArray[$j];
    $p2Lat = $finLatArray[$indexPlus];
    $p2Lng = $finLongArray[$indexPlus];

    $newDistance = calculDistance($p1Lat, $p1Lng, $p2Lat, $p2Lng);
    echo "<pre>";
    var_dump($newDistance);
    echo "</pre>";
}

/*
echo "<pre>";
var_dump($arcArray);
echo "</pre>";
 */

function calculDistance($p1Lat, $p1Lng, $p2Lat, $p2Lng) {

    //CONVERSION EN LAMBERT II Etendu



    $minusLat = $p1Lat - $p2Lat; //Y
    $minusLng = $p1Lng - $p2Lng; //X

    // =SQRT(POWER(G13;2) + POWER(H13;2)) / 1000
    return sqrt(pow($minusLng, 2) + pow($minusLat, 2)) / 1000;
}

function conversionDecToLambIIEt() {

}

function calculLargeur() {
    $graph = array(
        array(0, 1, 1, 0, 0, 0),
        array(1, 0, 0, 1, 0, 0),
        array(1, 0, 0, 1, 1, 1),
        array(0, 1, 1, 0, 1, 0),
        array(0, 0, 1, 1, 0, 1),
        array(0, 0, 1, 0, 1, 0),);
        
    function init($visited, $graph){
    foreach ($graph as $key => $vertex) {
        $visited[$key] = 0;
    }
    }
    function breadthFirst($graph, $start, $visited){
        $visited = array();
        $queue = array();
        init($visited, $graph);
        array_push($queue, $start);
        $visited[$start] = 1;
        while (count($queue)) {
            $t = array_shift($queue);
            foreach ($graph[$t] as $key => $vertex) {
                if (!$visited[$key] && $vertex == 1) {
                    $visited[$key] = 1;
                    array_push($queue, $key);
                }
            }
        }
        print_r($visited);
    }
    breadthFirst($graph, 2);
}



?>