<?php
include "../db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Restaurant</title>

<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#74ebd5,#9face6);
    font-family:Arial;
}

form{
    background:white;
    padding:25px;
    width:320px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}

h2{
    text-align:center;
    margin-bottom:15px;
    color:#333;
}

input, select{
    width:100%;
    padding:10px;
    margin-bottom:10px;
    border:1px solid #ccc;
    border-radius:6px;
}

button{
    width:100%;
    padding:10px;
    background:#007bff;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

button:hover{
    background:#0056b3;
}
</style>

</head>

<body>

<form action="" method="POST">
    <h2>Ajouter un plat</h2>

    <input type="text" name="nom" placeholder="Nom du plat" required>

    <input type="number" step="0.01" name="prix" placeholder="Prix" required>

    <select name="categorie_id" required>
        <option value="">-- Choisir une catégorie --</option>

        <?php
        // ✅ منع التكرار
        $result = mysqli_query($conn, "SELECT MIN(id) as id, nom FROM categorie GROUP BY nom");

        while($row = mysqli_fetch_assoc($result)){
            echo "<option value='".$row['id']."'>".$row['nom']."</option>";
        }
        ?>
    </select>

    <button type="submit">Ajouter</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ✅ حماية
    $nom = htmlspecialchars($_POST['nom']);
    $prix = $_POST['prix'];
    $categorie_id = $_POST['categorie_id'];

    if (!empty($nom) && !empty($prix) && !empty($categorie_id)) {

        // ✅ prepared statement (حماية من SQL Injection)
        $stmt = $conn->prepare("INSERT INTO plat (nom, prix, categorie_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $nom, $prix, $categorie_id);

        if ($stmt->execute()) {
            echo "<script>
                alert('✅ Plat ajouté avec succès');
                window.location.href='get.php';
            </script>";
        } else {
            echo "<script>alert('❌ Erreur');</script>";
        }

    } else {
        echo "<script>alert('⚠️ Remplis tous les champs');</script>";
    }
}
?>

</body>
</html>