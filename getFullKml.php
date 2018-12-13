<?php
header("Content-Type: application/vnd.google-earth.kml+xml");
header("Content-Disposition: attachment; filename=location.kml");
echo('<?xml version="1.0" encoding="utf-8"?>');
?>

<kml xmlns="http://www.opengis.net/kml/2.2">

  <Document>
		<Placemark>
			<name>Ligne n°1</name>
			<LineString>
				<coordinates>
					5.241573,46.210953
					5.243783,46.20808
					5.241951,46.20723
					5.241136,46.207668
					5.238305,46.209862
					5.234411,46.207527
					5.233699,46.208813
					5.228174,46.207378
					5.220401,46.207573
					5.218682,46.203632
					5.218689,46.203571
					5.218759,46.203716
					5.221935,46.203197
					5.218843,46.200665
					5.218574,46.200638
					5.220666,46.200653
					5.225301,46.200401
					5.225723,46.1982
					5.225383,46.195892
					5.225011,46.193909
					5.226242,46.190197
					5.226944,46.188503
					5.224562,46.187672
				</coordinates>
			</LineString>
		</Placemark>
		<?php while ($row = $result->fetchArray()) { ?>
		<Placemark id=<?php echo '"'.strval($row['GEO_POI_ID']).'"'; ?>>
			<name><?php echo $row['GEO_POI_NOM']; ?></name>
			<Point>
				<coordinates><?php echo $row['GEO_POI_LONGITUDE']; ?>,<?php echo $row['GEO_POI_LATITUDE']; ?></coordinates>
			</Point>
		</Placemark>
	<?php } ?>
	</Document>
</kml>