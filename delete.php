<?php

include("db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id_users = $id";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query Failed.");
    }

    $_SESSION['message'] = 'Suppression de la personne réussie';
    $_SESSION['message_type'] = 'warning';
    header('Location: index.php');
}