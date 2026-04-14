<?php
session_start();
include "../db.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    $admin = mysqli_fetch_assoc($result);

    if ($admin 
        && $admin['nom'] == "AYA MHANHNA"
        && password_verify($password, $admin['password'])) {

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nom'] = $admin['nom'];

        header("Location: dashbord_admin.php");
        exit;

    } else {
        $error = "❌ Accès refusé (admin non autorisé)";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #2d3436, #0984e3);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}

form {
    background: white;
    padding: 30px;
    width: 330px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    text-align: center;
}

h2 {
    color: #2c3e50;
    margin-bottom: 20px;
}

input {
    width: 90%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
}

button {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background: #0984e3;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:hover {
    background: #0652dd;
}

a {
    display: block;
    margin-top: 15px;
    text-decoration: none;
    color: #2c3e50;
}

.error {
    color: red;
    margin: 10px 0;
}
</style>

</head>

<body>

<form method="POST">
    <h2>Admin Login</h2>

    <?php
    if (!empty($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="login">Se connecter</button>
   <!--
    <a href="registreadmin.php">Créer admin</a>    -- >
</form>

</body>
</html>