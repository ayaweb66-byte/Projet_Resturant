<?php
include "../db.php";

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    // CHECK واش فيها plats
    $check = "SELECT COUNT(*) as total 
              FROM plat 
              WHERE categorie_id = $id";

    $result = mysqli_query($conn, $check);
    $row = mysqli_fetch_assoc($result);

    if($row['total'] > 0){
        // ❌ ALERT
        echo "<script>
                alert('❌ Cette catégorie contient des plats !');
                window.location.href='get.php';
              </script>";
        exit();
    }

    // DELETE
    $sql = "DELETE FROM categorie WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        header("Location: get.php");
        exit();
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }

} else {
    header("Location: get.php");
    exit();
}
?>