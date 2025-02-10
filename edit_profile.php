<?php
session_start();
include 'db_connect.php'; // Ensure you have a database connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$userId = $user['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNo = $_POST['phoneNo'];
    
    // Update user profile in the database
    $sql = "UPDATE gym_customers SET name=?, email=?, phoneNo=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $phoneNo, $userId);

    if ($stmt->execute()) {
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phoneNo'] = $phoneNo;
        $message = "<div class='alert alert-success'>Profile updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error updating profile: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Flex-Fit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gradient Header */
        .header {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: white;
            text-align: center;
            padding: 20px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 60vh;
        }

        .form-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .form-card h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .submit-btn {
            background-color: #6B73FF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #000DFF;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
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

        .message {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Edit Profile</h1>
    </div>

    <div class="container form-container">
        <div class="form-card">
            <h3>Update Your Details</h3>
            <form action="edit_profile.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phoneNo" class="form-label">Phone Number</label>
                    <input type="text" id="phoneNo" name="phoneNo" class="form-control" value="<?php echo htmlspecialchars($user['phoneNo']); ?>" required>
                </div>
                <button type="submit" class="btn submit-btn w-100">Update Profile</button>
            </form>

            <div class="message">
                <?php if (isset($message)) echo $message; ?>
            </div>
        </div>
    </div>

    <div class="back-link">
        <a href="profile.php">Back to Profile</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
