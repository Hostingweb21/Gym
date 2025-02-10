<?php
session_start();

// Ensure the user is logged in, otherwise redirect them to the login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$user = $_SESSION['user']; // Fetch user data from the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Nearby Gyms - Flex-Fit</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            text-align: center;
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: #fff;
            padding: 20px;
        }

        #map {
            flex: 1;
            width: 100%;
        }

        .back-link {
            text-align: center;
            margin: 10px 0;
        }

        .back-link a {
            text-decoration: none;
            color: #6B73FF;
            font-weight: bold;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: #000DFF;
        }

        .info {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Find Nearby Gyms</h1>
        </div>

        <div id="map"></div>

        <div class="info" id="info">Loading map...</div>

        <div class="back-link">
            <a href="home.php">Back to Home</a> <!-- Link to home.php (PHP page) -->
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map;

        map = L.map('map').setView([0, 0], 2); // Initialize map at global view

        // Add OpenStreetMap tiles to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        // Get user's geolocation and display map centered on their location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const userLocation = [position.coords.latitude, position.coords.longitude];
                map.setView(userLocation, 15); // Zoom into the user's location

                // Place a marker at the user's location
                L.marker(userLocation).addTo(map).bindPopup('Your Location').openPopup();

                document.getElementById('info').innerText = "Location fetched successfully!";
                findNearbyGyms(userLocation); // Call function to find nearby gyms
            }, () => {
                document.getElementById('info').innerText = "Failed to get your location.";
            });
        } else {
            document.getElementById('info').innerText = "Geolocation is not supported by your browser.";
        }

        // Function to find and display nearby gyms
        function findNearbyGyms(userLocation) {
            // Example gym locations (these would ideally come from your database)
            const gymLocations = [
                { name: "Gym 1", coords: [userLocation[0] + 0.001, userLocation[1] + 0.001] },
                { name: "Gym 2", coords: [userLocation[0] - 0.001, userLocation[1] - 0.001] },
                { name: "Gym 3", coords: [userLocation[0] + 0.002, userLocation[1] - 0.002] }
            ];

            // Add markers for each gym
            gymLocations.forEach(gym => {
                L.marker(gym.coords).addTo(map).bindPopup(gym.name);
            });

            // Update the status message
            document.getElementById('info').innerText = "Nearby gyms are displayed on the map.";
        }
    </script>
</body>
</html>
