<?php
require 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $reset_code = bin2hex(random_bytes(16));

    $stmt = $conn->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
    $stmt->bind_param("ss", $reset_code, $email);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        // Example: Send email with reset link (replace with actual mailer code)
        $reset_link = "http://yourdomain.com/auth/reset_password.php?code=$reset_code";
        // In a real application, send the $reset_link via email to the user

        $message = "A password reset link has been sent to your email.";
    } else {
        $message = "Invalid email!";
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
            position: relative; /* Ensure relative positioning for absolute children */
        }

        .base_container{
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
            justify-content: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, button {
            font-size: 18px;
            width: 140%;
            padding: 8px;
            position: relative;
            margin-bottom: 15px;
            border-radius: 12px;
            border: 2px solid #646464;
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        button {
            font-size: 18px;
            margin-top: 18px;
            margin-left: auto;
            margin-right: auto;
            padding: 6px;
            background-color: rgb(90, 90, 90);
            color: white;
            border: none;
            width: 70%;
            align-items: center;
            
        }

        button:hover {
            cursor: pointer;
            background-color: #45a049;
            transform: scale(1.15);
            transition: transform 0.4s ease;
        }

        .message {
            position: absolute;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 400px;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 12px;
            background-color: red;
            color: rgb(207, 207, 207);
            text-align: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.6s ease-in-out, visibility 0.6s ease-in-out;
        }

        .message.show {
            opacity: 1;
            visibility: visible;
        }

        a {
            text-decoration: none;
            font-size: 14px;
            text-align: center;
            margin-top: 5px;
            color: blue;
            margin: 4px;
            padding: 6px;
        }

        a:hover {
            cursor: pointer;
            text-decoration: underline;
            transform: scale(1.05);
            transition: transform 0.3s ease-out;
            background-color: rgb(138, 138, 138);
            border-radius: 8px;
        }

    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    setTimeout(function() {
                        document.querySelector('.message').classList.add('show');
                    }, 100);
                });
            </script>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="base_container">
            <h2>Forgot Password</h2>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Send Reset Link</button>
            <a href="login.php">Back To Login</a>
            </div>
        </form>
    </div>
</body>
</html>
