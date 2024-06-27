// Initialize the map
const map = L.map('map').setView([53.1653, 5.7815], 9);

// Add OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Sample markers
var markers = [
    L.marker([53.1653, 5.7815]).addTo(map)

];

// Circle to represent the radius
var circle = L.circle([53.1653, 5.7815], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 5000 // Default 5 km radius
}).addTo(map);

function updateRadius() {
    var radius = document.getElementById("radius").value * 1000; // Convert km to meters
    circle.setRadius(radius);

    // Update circle position if needed (optional)
    circle.setLatLng(map.getCenter());

    // Filter markers within the radius
    markers.forEach(function(marker) {
        var distance = map.distance(circle.getLatLng(), marker.getLatLng());
        if (distance <= radius) {
            marker.addTo(map); // Show marker
        } else {
            map.removeLayer(marker); // Hide marker
        }
    });
}

function geocodeAddress() {
    var address = document.getElementById("address").value;
    var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

    fetch(url)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.length > 0) {
                var lat = data[0].lat;
                var lon = data[0].lon;
                var location = new L.LatLng(lat, lon);

                map.setView(location, 11);
                circle.setLatLng(location);
                updateRadius();
            } else {
                alert('Address not found!');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            alert('Failed to geocode address.');
        });
}
