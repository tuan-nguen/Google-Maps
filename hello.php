<?php
//require("phpsqlajax_dbinfo.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Opens a connection to a MySQL server
$connection=mysqli_connect ('localhost', 'root', '123456');
if (!$connection) {
  die('Not connected : ' . mysqli_error());
}

// Set the active MySQL database
$db_selected = mysqli_select_db($connection, 'wordpress');
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error());
}

$stringCoordinates = file_get_contents('/var/www/html/coordinates.txt');
/** For testing purposes
if($stringCoordinates){
  echo $stringCoordinates;
}
*/

/** The .php file reads from a .txt file
  * and pulls the coordinates from it */

$array = explode(",", $stringCoordinates);
$lat1 = $array[0];
$lat2 = $array[2];
$lng1 = $array[1];
$lng2 = $array[3];

/** For testing purposes
echo "\n";
echo $lat1;
echo "\n";
echo $lat2;
echo "\n";
echo $lng1;
echo "\n";
echo $lng2;
echo "\n";
*/


// Select all the rows in the markers table
$query = "SELECT city, country, lat, lng FROM newTable WHERE lat >= ' " . $lat1 . " ' AND lng >= ' " . $lng1 . " '
                                                       AND lat <= ' " . $lat2 . " ' AND lng <= ' " . $lng2 . " ' ";
$result = mysqli_query($connection, $query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<marker ';
  echo 'city="' . $row['city'] . '" ';
  echo 'country="' . parseToXML($row['country']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}

// End XML file
echo '</markers>';
?>
