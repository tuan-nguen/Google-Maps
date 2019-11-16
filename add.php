<?php
$conn = mysqli_connect("localhost", "root", "Fishface93", "wordpress");
$url = "/home/tuan/Desktop/World Cities/convertcsv.xml";
$xml = simplexml_load_file($url);

$sql = "LOAD XML LOCAL INFILE '/home/tuan/Desktop/World Cities/convertcsv.xml'
        INTO TABLE 'markers'
        ROWS IDENTIFIED BY '<row>'";
$result = mysqli_query($conn, $sql);
?>
