<?php
include("db.php");
$type = '';
$adresse = '';
$nom = '';
$email = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id_users = $id";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $type = $row['type'];
        $adresse = $row['adresse'];
        $nom = $row['nom'];
        $email = $row['email'];
    } else {
        $_SESSION['message'] = 'Modification de la personne reussie';
        $_SESSION['message_type'] = 'warning';
        header('Location: edit.php?id=$id');
    }
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $type = addslashes($_POST['type']);
    $adresse = addslashes($_POST['adresse']);
    $nom = addslashes($_POST['nom']);
    $email = addslashes($_POST['email']);

    $query = "UPDATE users SET type = '$type', adresse = '$adresse', nom = '$nom', email = '$email' WHERE id_users=$id";
    mysqli_query($connection, $query);
    $_SESSION['message'] = 'Modification de la personne reussie';
    $_SESSION['message_type'] = 'warning';
    header('Location: index.php');
}

?>
<?php include('includes/header.php'); ?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="form-group">
                        <input name="type" type="text" class="form-control" value="<?php echo $type; ?>">
                    </div>
                    <div class="form-group">
                        <input name="adresse" type="text" class="form-control" value="<?php echo $adresse; ?>">
                    </div>
                    <div class="form-group">
                        <input name="nom" type="text" class="form-control" value="<?php echo $nom; ?>">
                    </div>
                    <div class="form-group">
                        <input name="email" type="text" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <input type="submit" name="update" class="btn btn-success btn-block" value="Valider">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
