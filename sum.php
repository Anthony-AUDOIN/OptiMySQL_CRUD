<?php

include('db.php');

if (isset($_POST['sum'])) {
    $type = addslashes($_POST['type']);
    $adresse = addslashes($_POST['adresse']);
    $nom = addslashes($_POST['nom']);
    $email = addslashes($_POST['email']);
    $query = "SELECT SUM(id_users) FROM users WHERE supprime = 0 LIMIT 1000000";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Insertion impossible");
    }

    $_SESSION['message'] = 'Insertion de la personne réussie';
    $_SESSION['message_type'] = 'success';
    header('Location: index.php');

}
