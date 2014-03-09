<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>By The Public</title>
        <script src="http://maps.google.com/maps/api/js?sensor=false"
        type="text/javascript"></script>
        <script src="js/keydragzoom.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/getvideos.js"></script>
        <link href="css/twitter-styles.css" rel="stylesheet" type="text/css" />
        <link href="css/webpage.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            @font-face { font-family:GraublauWeb; src:url(GraublauWeb.otf) format("opentype") }
            @font-face { font-family:GraublauWeb; src:url(GraublauWebBold.otf) format("opentype"); font-weight:bold }

            body * {
                margin: 0; padding: 0;
            }

            ul#grid {
                list-style: none;
                margin: 20px auto 0;
                width: 200px;  /*was 468*/
            }

            #grid li {
                float: left;
                margin: 0 5px 10px 5px;
            } 

            .portfolio {
                padding: 20px;
                margin-left: auto; margin-right: auto;  margin-top:auto;
                /*background-color: #ffd7ce;*/
                width: 150px; /*was 510*/
                /*these two properties will be inherited by .portfolio h2 and .portfolio p */
                font-family: 'GraublauWeb', arial, serif; 
                text-align: center;
                float:right;
            }

            .portfolio h2 {
                clear: both;
                font-size: 35px;
                font-weight: normal;
                color: #58595b;
            }

            .portfolio p {
                font-size: 15px;
                color: #58595b;
                /*text-shadow: 1px 1px 1px #aaa;
                */
            }

            #grid li a:hover img {
                opacity:0.3;  filter:alpha(opacity=30);
            }

            #grid li img {
                background-color: white;
                padding: 7px; margin: 0;
                border: 1px dotted #58595b;
                width: 129px;
                height: 145px;
            }

            #grid li a {
                display: block;
            }
        </style>
        <script type="text/javascript">

            
            var map;
            var lat, lon, lat1, lon1,url;
            var markers = [];
            var iterator = 0;
            var mapZoom;
            var geocoder;
            var startLocation;
            var infoWindow = new google.maps.InfoWindow;
            var dist;
            function load() {
                initialize();
                map = new google.maps.Map(document.getElementById("map"), {
                    center: new google.maps.LatLng(37.8575071562503,-102.041015625),
                    zoom: 4,
                    mapTypeId: 'roadmap'
                });
                map.enableKeyDragZoom();
                var dz = map.getDragZoomObject();
                google.maps.event.addListener(map, 'click', function(event) {
                    mapZoom = map.getZoom();
                    startLocation = event.latLng;
                });
            }
            function bindInfoWindow(marker, map, infoWindow, html) {
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(map, marker);
                    lat1 = marker.getPosition().lat();
                    lon1 = marker.getPosition().lng();
                    url=html;
                    document.getElementById("btn1").click();
                });

            }

            function drop() {
                for (var i = 0; i < neighborhoods.length; i++) {
                        addMarker();
                }
            }
            function addMarker() {
                var tempHTML = markerHTML[iterator];
                var markerINFO = new google.maps.Marker({
                    position: neighborhoods[iterator],
                    map: map,
                    draggable: false,
                    animation: google.maps.Animation.DROP
                });
                bindInfoWindow(markerINFO, map, infoWindow, tempHTML);
                markers.push(markerINFO);
                iterator++;
            }
           

function initialize() {
    geocoder = new google.maps.Geocoder();
}

function codeAddress() {
    var address = document.getElementById("address").value;
    geocoder.geocode({
        'address': address
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
//            $('#lat').val(results[0].geometry.location.lat());
//            $('#lng').val(results[0].geometry.location.lng());
            map.setZoom(15);
            map.setCenter(results[0].geometry.location);
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}
        </script>
    </head>
    <body onload="load()">
        <div align="center"><h1> By The Public </h1></div>
        <div id="c1"><div id="map" style="width: 1200px; height: 600px"></div></div>
        <div>
            <input id="address" type="text" value="90007"/>
<!--            <input id="lat" type="text" disabled="true"/>
            <input id="lng" type="text" disabled="true"/>-->
            <input type="button" value="Geocode" onclick="codeAddress()">
            <input id="btn1" type="button" value="Get Videos" hidden="true"/>
        </div>
    </body>
</html>