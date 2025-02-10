<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $phoneNo = $_POST['phoneNo'];

    if ($role == 'customer') {
        $query = "INSERT INTO gym_customers (name, email, password, phoneNo) VALUES ('$name', '$email', '$password', '$phoneNo')";
    } else {
        $address = $_POST['address'];
        $gymName = $_POST['gymName'];
        $query = "INSERT INTO gym_details (name, address, email, password, gymName, phoneNo) VALUES ('$name', '$address', '$email', '$password', '$gymName', '$phoneNo')";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: home.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Flex-Fit</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            font-family: 'Roboto', sans-serif;
        }

        .container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #6B73FF;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #6B73FF;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #000DFF;
        }

        .text-link {
            text-align: center;
            margin-top: 10px;
        }

        .text-link a {
            color: #6B73FF;
            text-decoration: none;
        }

        .text-link a:hover {
            color: #000DFF;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h2>Register</h2>
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="phoneNo" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
                <div class="card-footer text-link">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
