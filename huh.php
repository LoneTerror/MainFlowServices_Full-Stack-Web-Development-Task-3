<?php
// Start session to access session variables
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to login page after logout
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Huh.php</title>
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
            background-color: green;
            color: white;
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
            padding: 60px 80px;
            border-radius: 15px;
            background: linear-gradient(to top, rgba(202, 172, 172, 0.651), rgba(214, 119, 119, 0.651));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        button {
            font-size: 18px;
            margin-top: 20px;
            padding: 5px;
            background-color: rgb(90, 90, 90);
            color: white;
            border: none;
            width: 50%;
            border-radius: 8px;
            width: 35%;
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
            margin: 8px;
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
    <?php if (isset($_SESSION['user_id'])) : ?>
        <div class="message">Welcome! You are logged in.</div>
    <?php endif; ?>

    <form method="POST" action="">
        <h2>Welcome to my workstation, Now...</h2>
        <img src="spongebob-done.gif" alt="">
        <audio id="meme" src="Galaxy-Brain-meme.mp3" autoplay></audio>
        <?php if (isset($_SESSION['user_id'])) : ?>
            <button type="submit" name="logout">Logout</button>
        <?php else : ?>
            <p>You are not logged in.</p>
        <?php endif; ?>
    </form>
</body>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            var audio = document.getElementById('meme');
            audio.volume = 0.5;
        });
    </script>
</html>
