<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

$user = $_SESSION['user'];

// Handle logout directly in the home page
if (isset($_GET['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page after logout
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Flex-Fit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gradient Header Theme */
        .header {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .home-container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .btn-custom {
            background-color: #6B73FF;
            color: white;
            font-weight: bold;
            margin: 10px 0;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #000DFF;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p>Your personalized fitness dashboard</p>
    </div>

    <div class="container home-container text-center">
        <a href="profile.php" class="btn btn-custom w-50">View Profile</a>
        <a href="map.php" class="btn btn-custom w-50">Find Nearby Gyms</a>
        <a href="home.php?logout=true" class="btn btn-danger w-50">Log Out</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>