<?php

include('db.php');

if (isset($_POST['save'])) {
    $type = addslashes($_POST['type']);
    $adresse = addslashes($_POST['adresse']);
    $nom = addslashes($_POST['nom']);
    $email = addslashes($_POST['email']);
    $query = "INSERT INTO users(type, adresse, nom, email) VALUES ('$type', '$adresse', '$nom', '$email')";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Insertion impossible");
    }

    $_SESSION['message'] = 'Insertion de la personne réussie';
    $_SESSION['message_type'] = 'success';
    header('Location: index.php');

}
