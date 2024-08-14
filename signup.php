<?php
require 'config.php';

$message = '';
$messageClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "User already exists";
        $messageClass = 'error';
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $message = "Signup successful!";
            $messageClass = 'success';
        } else {
            $message = "Error: " . $stmt->error;
            $messageClass = 'error';
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('sunset-mountains.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 15px;
            background: linear-gradient(to top, rgba(202, 172, 172, 0.651), rgba(214, 119, 119, 0.651));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .base_container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            font-size: 30px;
            text-align: center;
            margin-bottom: 20px;
        }

        input, button {
            font-size: 18px;
            width: 140%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 12px;
            border: 2px solid #646464;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        button[type=submit] {
            margin-top: 10px;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            padding: 8px;
            background-color: rgb(90, 90, 90);
            width: 50%;
        }

        button[type=submit]:hover {
            cursor: pointer;
            background-color: #45a049;
            transform: scale(1.15);
            transition: transform 0.4s ease;
        }

        .message {
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 400px;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 12px;
            text-align: center;
            opacity: 0;
            visibility: hidden;
            z-index: 9999;
            transition: opacity 0.6s ease-in-out, visibility 0.6s ease-in-out;
        }

        .message.show {
            opacity: 1;
            visibility: visible;
        }

        .message.error {
            background-color: red;
            color: rgb(207, 207, 207);
            font-weight: bold;
        }

        .message.success {
            background-color: green;
            color: rgb(207, 207, 207);
            font-weight: bold;
        }

        a {
            text-decoration: none;
            font-size: 14px;
            padding: 6px;
            text-align: center;
            margin-top: 16px;
            color: blue;
            display: inline-block;
            transition: transform 0.18s ease-out, background-color 0.2s ease-out;
            border-radius: 8px;
        }

        a:hover {
            text-decoration: underline;
            transform: scale(1.05);
            background-color: rgb(138, 138, 138);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($message)) : ?>
            <div class="message <?php echo $messageClass; ?>"><?php echo $message; ?></div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    setTimeout(function() {
                        document.querySelector('.message').classList.add('show');
                    }, 100);
                });
            </script>
        <?php endif; ?>

        <form method="POST" action="">
            <h2>Welcome!</h2>
            <div class="base_container">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Signup</button>
            <a href="login.php">Already Registered? Login here</a>
            </div>
        </form>
    </div>
</body>
</html>
