<?php
require("DbConnect.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Tableau SIG</title>
</head>
<body>

  <?php

      $db = new DbConnect();
      $result = $db->query('SELECT * FROM GEO_ARC, GEO_POINT WHERE GEO_POINT.GEO_POI_ID = GEO_ARC.GEO_ARC_DEB');
      $resultArcFin = $db->query('SELECT GEO_POI_NOM FROM GEO_ARC, GEO_POINT WHERE GEO_POINT.GEO_POI_ID = GEO_ARC.GEO_ARC_FIN');

?>

<h1>Tableau des arrêts de bus : </h1>
<table border=1>
   <thead>
	<tr>
		<th>Point 1</th>
    <th>Point 2</th>
    <th>Temps</th>
    <th>Distance</th>
	</tr>
   </thead>

   <tbody>


<?php
  while($row = $result->fetchArray()) {
 ?>

  <tr>
  <td><?php echo $row['GEO_POI_NOM']; ?></td>
  <td><?php echo $resultArcFin->fetchArray()['GEO_POI_NOM']; ?></td>
  <td><?php echo $row['GEO_ARC_TEMPS']; ?></td>
  <td><?php echo $row['GEO_ARC_DISTANCE']; ?></td>
  </tr>
  <?php
} // fin while
  ?>

   </tbody>
</table>

</body>
</html>
