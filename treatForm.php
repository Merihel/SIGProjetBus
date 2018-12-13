<?php
    ini_set('display_errors', 1);

    require("updateDistance.php");
    //require("MyDB.php");

    $depart = explode("_",$_POST['dep']);
    $destination = explode("_",$_POST['des']);
    $tableauChemins = initFile(array(), array(), array(), array(), array());
    $currentChemin = null;

    /*
    echo "<pre>";
    //var_dump($tableauChemins);
    echo "</pre>";
*/

    for ($i=1; $i<=count($tableauChemins); $i++) {
        if ($tableauChemins[$i][0][1] == $depart[0] && $tableauChemins[$i][0][2] == $destination[0]) {
            //echo "Found it at ".$tableauChemins[$i][0][0];
            $currentChemin = $tableauChemins[$i][0];
        }
    }

    if ($currentChemin != null) {
        /*
        echo "<pre>";
        var_dump($currentChemin);
        echo "</pre>";
        */
        //getFullKml($currentChemin);
    } else {
        echo "Chemin non trouvé";
        die;
    }

    $dbKml = new MyDB();

    $resultForPoint1 = $dbKml->query("SELECT * FROM GEO_POINT WHERE GEO_POI_ID = ".$currentChemin[1]);
    $point1 = $resultForPoint1->fetchArray();
    $resultForPoint2 = $dbKml->query("SELECT * FROM GEO_POINT WHERE GEO_POI_ID = ".$currentChemin[2]);
    $point2 = $resultForPoint2->fetchArray();
    
    /*
    echo "<pre>";
    var_dump($point1);
    var_dump($point2);
    echo "</pre>";
    */

    header("Content-Type: application/vnd.google-earth.kml+xml");
    header("Content-Disposition: attachment; filename=location.kml");
    echo('<?xml version="1.0" encoding="utf-8"?>');
    ?>

    <kml xmlns="http://www.opengis.net/kml/2.2">
    <Document>
            <Placemark>
                <name>Ligne n°1</name>
                <LineString>
                    <coordinates><?php
                        echo $point1[2].",".$point1[1]." "; 
                        echo $point2[2].",".$point2[1];
                    ?></coordinates>
                </LineString>
            </Placemark>
            <Placemark id=<?php echo '"'.strval($point1['GEO_POI_ID']).'"'; ?>>
                <name><?php echo $point1['GEO_POI_NOM']; ?></name>
                <Point>
                    <coordinates><?php echo $point1['GEO_POI_LONGITUDE']; ?>,<?php echo $point1['GEO_POI_LATITUDE']; ?></coordinates>
                </Point>
            </Placemark>
            <Placemark id=<?php echo '"'.strval($point2['GEO_POI_ID']).'"'; ?>>
                <name><?php echo $point2['GEO_POI_NOM']; ?></name>
                <Point>
                    <coordinates><?php echo $point2['GEO_POI_LONGITUDE']; ?>,<?php echo $point2['GEO_POI_LATITUDE']; ?></coordinates>
                </Point>
            </Placemark>
        </Document>
    </kml>
