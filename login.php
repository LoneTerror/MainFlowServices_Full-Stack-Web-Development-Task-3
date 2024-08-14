<?php
require 'config.php';

session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $message = "Login successful!";
        
        header("Location: huh.php");
        exit();
    } else {
        $message = "Invalid username or password!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
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

        .message {
            position: absolute;
            top: 30vh;
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

        form {
            font-size: 18px;
            width: 100%;
            max-width: 400px;
            padding: 40px 40px;
            border-radius: 15px;
            background: linear-gradient(to top, rgba(202, 172, 172, 0.651), rgba(214, 119, 119, 0.651));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input, button {
            font-size: 18px;
            width: 85%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 12px;
            border: 2px solid #646464;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }


        button {
            font-size: 18px;
            margin-top: 20px;
            padding: 5px;
            background-color: rgb(90, 90, 90);
            color: white;
            border: none;
            width: 50%;
        }

        button:hover {
            cursor: pointer;
            background-color: #45a049;
            transform: scale(1.15);
            transition: transform 0.4s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
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
    <?php if ($message): ?>
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
        <h2>Welcome Back!</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <a href="forgot_password.php">Forgot Password?</a>
        <a href="signup.php">Not Registered? SignUp here</a>
    </form>
</body>
</html>
