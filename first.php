<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 85%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 85%;
        width: 85%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

<html>
  <body>
    <div id="map"></div>

    <form>
      <input type="text" id="lat1"  />
      <input type="text" id="lng1"  />
      <input type="text" id="lat2" />
      <input type="text" id="lng2"  />
      <button onclick="initMap();return false">
    </form> 

    <script type="text/javascript">
        /** For testing purposes
        function test() {
          alert(document.getElementById("lat1").value);
          alert(document.getElementById("lng1").value);
          alert(document.getElementById("lat2").value);
          alert(document.getElementById("lng2").value);
        } */
      
        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(42.697510, 23.324150),
          zoom: 12
        });
        geocoder = new google.maps.Geocoder();
        var infoWindow = new google.maps.InfoWindow;

        // Download the xml file with markers
        downloadUrl('http://localhost/hello.php/?lat1=' + document.getElementById("lat1").value + 
                                               '&lng1=' + document.getElementById("lng1").value + 
                                               '&lat2=' + document.getElementById("lat2").value + 
                                               '&lng2=' + document.getElementById("lng2").value, function(data) {
          var xml = data.responseXML;
          var markers = xml.documentElement.getElementsByTagName('marker');
          Array.prototype.forEach.call(markers, function(markerElem) {
            var city = markerElem.getAttribute('city');
            var name = markerElem.getAttribute('country');
            var point = new google.maps.LatLng(
                parseFloat(markerElem.getAttribute('lat')),
                parseFloat(markerElem.getAttribute('lng')));

            // Show info about city
            var infowincontent = document.createElement('div');
            var strong = document.createElement('strong');
            strong.textContent = city;
            infowincontent.appendChild(strong);
            infowincontent.appendChild(document.createElement('br'));

            // Show info about country
            var strong1 = document.createElement('strong1');
            strong1.textContent = name;
            infowincontent.appendChild(strong1);
            infowincontent.appendChild(document.createElement('br'));

            // Show latitude
            var strong2 = document.createElement('strong2');
            strong2.textContent = point.lat();
            infowincontent.appendChild(strong2);
            infowincontent.appendChild(document.createElement('br'));

            // Show longitude
            var strong3 = document.createElement('strong3');
            strong3.textContent = point.lng();
            infowincontent.appendChild(strong3);
            infowincontent.appendChild(document.createElement('br'));


            var text = document.createElement('text');
            infowincontent.appendChild(text);
            var marker = new google.maps.Marker({
              map: map,
              position: point,
            });
            marker.addListener('click', function() {
              infoWindow.setContent(infowincontent);
              infoWindow.open(map, marker);
            });
          });
        });
      }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };
        request.open('GET', url, true);
        request.send(null);
      } 
      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyIJzGBXjNTOfI4LQV-PSj2tR74jWtiuQ&callback=initMap">
    </script>
  </body>
</html>
