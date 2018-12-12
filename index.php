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



// CREATION DU FICHIER KML (une pop up de téléchargement s'ouvre au lancement de la page) //
$result = $db->query('SELECT * FROM GEO_POINT');

$dom = new DOMDocument('1.0', 'UTF-8');
$node = $dom->createElementNS('http://www.opengis.net/kml/2.2', 'kml'); // ou : $node = $dom->createElementNS('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);
$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);

// OPTION : POUR AJOUTER UN STYLE
// $restStyleNode = $dom->createElement('Style');
// $restStyleNode->setAttribute('id', 'restaurantStyle');
// $restIconstyleNode = $dom->createElement('IconStyle');
// $restIconstyleNode->setAttribute('id', 'restaurantIcon');
// $restIconNode = $dom->createElement('Icon');
// $restHref = $dom->createElement('href', 'http://maps.google.com/mapfiles/kml/pal2/icon63.png');
// $restIconNode->appendChild($restHref);
// $restIconstyleNode->appendChild($restIconNode);
// $restStyleNode->appendChild($restIconstyleNode);
// $docNode->appendChild($restStyleNode);



while ($row = $result->fetchArray()) {
	$node = $dom->createElement('Placemark');
  $placeNode = $docNode->appendChild($node);
	$placeNode->setAttribute('id', 'placemark' . $row['GEO_POI_ID']);

	 $nameNode = $dom->createElement('name',htmlentities($row['GEO_POI_NOM']));
	 $placeNode->appendChild($nameNode);
	 // optionnel :
	 // $descNode = $dom->createElement('description', $row['GEO_POI_NOM']);
 	 // $placeNode->appendChild($descNode);
	 // 	 $styleUrl = $dom->createElement('styleUrl', '#restaurantStyle');
	 // $placeNode->appendChild($styleUrl);

	  $pointNode = $dom->createElement('Point');
	  $placeNode->appendChild($pointNode);

	  // On crée un élément coordinates et on lui donne la valeur de la longitude et latitude
	  $coorStr = $row['GEO_POI_LONGITUDE'] . ','  . $row['GEO_POI_LATITUDE'];
	  $coorNode = $dom->createElement('coordinates', $coorStr);
	  $pointNode->appendChild($coorNode);
}

	$kmlOutput = $dom->saveXML();
	header('Content-type: application/vnd.google-earth.kml+xml');
	echo $kmlOutput;
