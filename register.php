<?php
include "../db.php";

$message = "";

if (isset($_POST['register'])) {

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO client (nom, email, password)
            VALUES ('$nom', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {

        // 🔥 success message + redirect
        echo "<script>
            alert('✅ Compte créé avec succès');
            window.location.href='../commande/add.php';
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
    <title>client</title>

    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #00b894, #0984e3);
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
            background: #00b894;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }

        button:hover {
            background: #019875;
        }

        a {
            display: block;
            margin-top: 10px;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

<form method="POST">
    <h2>client</h2>

    <?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>

    <input type="text" name="nom" placeholder="Nom" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="register">
        Créer compte
    </button>

    <a href="login.php">Déjà un compte ? Login</a>
</form>

</body>
</html>