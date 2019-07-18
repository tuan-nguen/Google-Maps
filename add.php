<?php
$conn = mysqli_connect("localhost", "root", "123456", "wordpress");
$url = "http://api.openweathermap.org/data/2.5/forecast?id=524901&APPID=2d8b5a89602a5f579ec1372b11a82894&mode=xml";
$xml = simplexml_load_file($url);
//print_r($xml);

foreach($xml->forecast->time as $row){
    $deg = $row->windDirection->attributes()->deg;
    $code = $row->windDirection->attributes()->code;
    $name = $row->windDirection->attributes()->name;
    
    $sql = "INSERT INTO newTable(deg,code,name) VALUES ('" . $deg . "','" . $code . "','" . $name . "')";
    
    $result = mysqli_query($conn, $sql);
    
} 