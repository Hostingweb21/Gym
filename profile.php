<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];

    // Update user information
    if (isset($user['gym_name'])) { // Gym Owner
        $query = "UPDATE gym_details SET name = '$name', email = '$email', phoneNo = '$phoneNo' WHERE id = {$user['id']}";
    } else { // Customer
        $query = "UPDATE gym_customers SET name = '$name', email = '$email', phoneNo = '$phoneNo' WHERE id = {$user['id']}";
    }

    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success'>Profile updated successfully!</div>";
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phoneNo'] = $phoneNo;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Flex-Fit</title>
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

        .profile-card {
            margin-top: 50px;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-card h5 {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .profile-card p {
            margin: 5px 0;
        }

        .edit-btn {
            margin-top: 20px;
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Your Profile</h1>
    </div>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="card profile-card">
            <h5 class="card-title">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h5>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phoneNo']); ?></p>

            <a href="edit_profile.php" class="btn btn-primary edit-btn">Edit Profile</a>
        </div>
    </div>

    <div class="back-link">
        <a href="home.php">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
