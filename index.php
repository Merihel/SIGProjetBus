<?php
ini_set('display_errors', 1);

//require("updateDistance.php");
require("MyDB.php");

function init() {
	$db = new MyDB();
	$pointName = $db->query("SELECT * FROM GEO_POINT");
	
	echo "<form method='post' action='treatForm.php'>";
	echo "<h5>Départ</h5>";
	echo "<select name='dep'>";

	while($row = $pointName->fetchArray()) {
		echo "<option value='".$row[0]."'>".$row[0]."_".$row[3]."</option>";
	}
	echo "</select><br/>";

	echo "<h5>Destination</h5>";
	echo "<select name='des'>";

	while($row = $pointName->fetchArray()) {
		echo "<option value='".$row[0]."'>".$row[0]."_".$row[3]."</option>";
	}
	echo "</select><br/><br/>";

	echo "<input type='submit' name='submit' value='Telecharger le KML'>";
	echo "</form>";

	echo "<form method='GET' action='getFullKml.php'>";
	echo "<input type='submit' name='submit2' value='Telecharger le KML complet'>";
	echo "</form>";
}

init();

?>
