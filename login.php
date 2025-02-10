<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = "SELECT * FROM gym_customers WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);


    if (!$user) {
        $query = "SELECT * FROM gym_details WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
    }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: home.php"); 
        exit;
    } else {
        echo "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Flex-Fit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gradient Header Theme */
        .header {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .form-container {
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #6B73FF;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #000DFF;
        }

        .back-link a {
            color: #6B73FF;
            text-decoration: none;
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
        <h1>Login</h1>
        <p>Welcome back to Flex-Fit!</p>
    </div>

    <div class="container form-container d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg rounded" style="width: 100%; max-width: 400px;">
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-custom w-100">Login</button>
            </form>
        </div>
    </div>

    <div class="text-center mt-4 back-link">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>