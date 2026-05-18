<?php
require "config.php";

/* =========================
   SAFE SESSION CHECK
========================= */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   CSRF TOKEN
========================= */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* =========================
   ERROR MESSAGE
========================= */
$error = "";

/* =========================
   LOGIN ATTEMPT LIMIT
========================= */
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = 0;
}

/* lock for 30 seconds after 5 attempts */
if ($_SESSION['login_attempts'] >= 5 &&
    (time() - $_SESSION['last_attempt_time']) < 30) {
    die("Too many attempts. Please wait 30 seconds.");
}

/* =========================
   LOGIN PROCESS
========================= */
if (isset($_POST['login'])) {

    /* CSRF CHECK (SECURE) */
    if (!isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid request!");
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    /* GET USER */
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    /* VERIFY USER */
    if ($user && password_verify($password, $user['password'])) {

        /* OPTIONAL: check account status */
        if (isset($user['status']) && $user['status'] !== 'active') {
            die("Account is disabled.");
        }

        /* RESET LOGIN ATTEMPTS */
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = 0;

        /* NEW SESSION ID */
        session_regenerate_id(true);

        /* STORE SESSION */
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        /* OPTIONAL: refresh CSRF token after login */
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        header("Location: dashboard.php");
        exit();

    } else {

        /* FAILED LOGIN */
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();

        $error = "Invalid login details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secure Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    font-family: Arial;
    background: url('images/crown.jpg') no-repeat center center fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.box {
    background: white;
    padding: 30px;
    width: 320px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
}

button {
    width: 100%;
    padding: 12px;
    background: #0d6efd;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background: #0b5ed7;
}

.error {
    background: #ffdddd;
    color: #d8000c;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}
</style>
</head>

<body>

<div class="box">

    <h2>Secure Login</h2>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="hidden" name="csrf_token"
               value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit" name="login">Login</button>

    </form>

</div>

</body>
</html>