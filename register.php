<?php
require "config.php";

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = "";

if (isset($_POST['register'])) {

    // CSRF CHECK
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid request!");
    }

    // INPUT CLEANING
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // VALIDATION
    if (empty($username) || empty($password)) {
        $message = "All fields are required!";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters!";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {

        // CHECK USER EXISTS
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $message = "Username already exists!";
        } else {

            // HASH PASSWORD
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // INSERT USER
            $insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");

            if ($insert->execute([$username, $hashed_password, 'staff'])) {

                // SAFE REDIRECT TO LOGIN
                header("Location: login.php?registered=1");
                exit();

            } else {
                $message = "Something went wrong!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secure Register</title>

<style>
body {
    font-family: Arial;
    background: blue;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.box {
    background: white;
    padding: 25px;
    width: 350px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

input {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
}

button {
    width: 100%;
    padding: 10px;
    background: green;
    color: white;
    border: none;
    cursor: pointer;
}

.msg {
    color: red;
}
</style>
</head>

<body>

<div class="box">
    <h2>Create Account</h2>

    <p class="msg"><?php echo $message; ?></p>

    <form method="POST">

    <input type="text" name="username" placeholder="Username" required>

    <!-- Password -->
    <div>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="button" onclick="togglePassword('password')">Show</button>
    </div>

    <!-- Confirm Password -->
    <div>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="button" onclick="togglePassword('confirm_password')">Show</button>
    </div>

    <!-- CSRF TOKEN -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <button type="submit" name="register">Register</button>
    <p>Already have an account? <a href="login.php">Login here</a></p>

</form>

</div>
<script>
function togglePassword(fieldId) {
    var input = document.getElementById(fieldId);

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>
</body>
</html>