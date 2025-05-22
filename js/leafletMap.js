
// Set the map container's width and height to 100% of the viewport
var mapContainer = document.getElementById('map');
mapContainer.style.width = '100%';
mapContainer.style.height = '100vh';

var map = L.map("map");

// Get current location and add circle to the map
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var currentLat = position.coords.latitude;
        var currentLng = position.coords.longitude;
        var currentLocation = [currentLat, currentLng];

        // Create circle and add it to the map
        var circle = L.circle(currentLocation, {
            color: 'red',
            fillColor: 'black',
            fillOpacity: 0.5,
            radius: 200
        }).addTo(map);

        // Create the button element
        var button = L.Control.extend({
            options: {
                position: 'topleft'
            },

            onAdd: function (map) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                container.style.backgroundColor = 'red';
                container.style.width = '30px';
                container.style.height = '30px';
                container.style.borderRadius = '4px';
                container.style.boxShadow = '0 1px 5px rgba(0, 0, 0, 0.65)';
                container.style.cursor = 'pointer';
                container.style.backgroundImage = 'url("images/recenter.png")';
                container.style.backgroundSize = 'contain';

                container.innerHTML = '<i class="fas fa-location-arrow"></i>';

                container.onclick = function(){
                    map.setView(currentLocation, 13);
                }

                return container;
            }
        });

// Add the button to the map
        map.addControl(new button());

        // Add tile layer to the map
        var tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

// Define the satellite layer
        var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: 'Esri, DigitalGlobe, GeoEye, i-cubed, USDA, USGS, AEX, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        });

// Define the terrain layer
        var terrainLayer = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.png', {
            maxZoom: 18,
            attribution: 'Map tiles by Stamen Design, under CC BY 3.0. Data by OpenStreetMap, under ODbL'
        });

// Add both layers to a layer group
        var baseLayers = {
            "Tile" : tileLayer,
            "Satellite": satelliteLayer,
            "Terrain": terrainLayer
        };

// Add the layer control to the map
        L.control.layers(baseLayers).addTo(map);



// Create a popup for the circle marker
        var popup = L.popup({ closeButton: false })
            .setContent("<p>My Location</p><img src='images/myLocation.png' alt='My Image' width='100' height='100' />");


// Bind the popup to the circle marker and show it on hover
        circle.on('mouseover', function (event) {
            popup.setLatLng(event.latlng)
                .openOn(map);
        });

// Hide the popup when the mouse moves away from the circle marker
        circle.on('mouseout', function (event) {
            map.closePopup(popup);
        });

        // Set the view of the map to the current location
        map.setView(currentLocation, 13);

        // Add tile layer to the map
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var xhr = new XMLHttpRequest(); // Create an XMLHttpRequest object
        xhr.open('GET', 'markers.php', true); // Open a connection to the PHP script
        xhr.send();

        let popupOption = { "closeButton": false } // setting f

        // Handle the response
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Parse the JSON data
                var data = JSON.parse(xhr.responseText);
                // Loop through the data and add markers to the map. Parsed JSON objects have correct field names from the DB
                data.forEach(function(chargePointData) {
                    var markerText = '<address>' + chargePointData.address + '<br/>' + chargePointData.postcode + '</address><p>Cost: £' + chargePointData.cost + '</p><img src="images/carLogo2.png">';

                    var markerColour = {color: 'red'};
                    var marker = L.marker([chargePointData.lat, chargePointData.long], markerColour).addTo(map).on('mouseover', event => { event.target.bindPopup(markerText).openPopup(); }).on('mouseout', event => { event.target.closePopup(); });
                });
            }
        };
    });



}

