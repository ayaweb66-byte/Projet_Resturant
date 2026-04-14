<?php
include "../db.php";

$message = "";

if (isset($_POST['register'])) {

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (nom, email, password)
            VALUES ('$nom', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
            alert('✅ Admin créé avec succès');
            window.location.href='dashbord_admin.php';
        </script>";
        exit;

    } else {
        $message = "❌ Erreur: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>

    <style>
        body {
            font-family: Arial;
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
            width: 350px;
            border-radius: 12px;
            text-align: center;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0984e3;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }

        button:hover {
            background: #0652dd;
        }

        .error {
            color: red;
        }

        a {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<form method="POST">
    <h2>Admin </h2>

    <?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>

    <input type="text" name="nom" placeholder="Nom" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="register">Créer Admin</button>

    <a href="login.php">Déjà admin ? Login</a>
</form>

</body>
</html>