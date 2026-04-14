<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Catégorie</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<h2>➕ Ajouter une catégorie</h2>

<form action="" method="POST">
    <input type="text" name="nom" placeholder="Nom de la catégorie" required>
    <button type="submit" name="add">Ajouter</button>
</form>

</body>
</html>
<?php
include "../db.php";

if(isset($_POST['add'])){
    $nom = $_POST['nom'];

    if(!empty($nom)){
        $stmt = $conn->prepare("INSERT INTO categorie (nom) VALUES (?)");
        $stmt->bind_param("s", $nom);

        if($stmt->execute()){
            echo "<p style='color:green;'>✅ Catégorie ajoutée</p>";
            header("Location:../plat/add.php");
            exit;
        } else {
            echo "<p style='color:red;'>❌ Erreur</p>";
        }
    } else {
        echo "<p style='color:red;'>⚠️ Champ vide</p>";
    }
}
?>