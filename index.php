<?php

require("Dijkstra.php");

function runTest() {
	$g = new Graph();

	$g->addEdge("a", "b", 85);
	$g->addEdge("b", "a", 85);
	$g->addEdge("a", "c", 217);
	$g->addEdge("c", "a", 217);
	$g->addEdge("a", "e", 173);
	$g->addEdge("e", "a", 173);

	$g->addEdge("b", "f", 80);
	$g->addEdge("f", "b", 80);

	$g->addEdge("c", "g", 186);
	$g->addEdge("g", "c", 186);
	$g->addEdge("c", "h", 103);
	$g->addEdge("h", "c", 103);

	$g->addEdge("h", "d", 183);
	$g->addEdge("d", "h", 183);
	$g->addEdge("h", "j", 167);
	$g->addEdge("j", "h", 167);
	
	$g->addEdge("e", "j", 502);
	$g->addEdge("j", "e", 502);
	
	$g->addEdge("f", "i", 250);
	$g->addEdge("i", "f", 250);

	$g->addEdge("i", "j", 84);
	$g->addEdge("j", "i", 84);

	list($distances, $prev) = $g->paths_from("a");
	
	$path = $g->paths_to($prev, "j");
	
	print_r($path);
	
}
//runTest();

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('db.sqlite');
    }
}

$db = new MyDB();

$result = $db->query('SELECT * FROM GEO_POINT WHERE GEO_POI_ID=1');
var_dump($result->fetchArray());