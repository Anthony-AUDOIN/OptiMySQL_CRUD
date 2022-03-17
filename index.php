<?php include("db.php"); ?>

<?php include('includes/header.php');
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
?>

<main class="container p-4">
    <div class="row">
        <div class="col-md-4">
            <!-- Popup form -->
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['message']);
            } ?>

            <div class="card card-body">
                <form action="save.php" method="POST">
                    <div class="form-group">
                        <input type="number" min="0" name="type" class="form-control" placeholder="Type" autofocus
                               required
                               onkeypress="verifierCaracteres(event); return false;">
                    </div>
                    <div class="form-group">
                        <input type="text" name="adresse" class="form-control" placeholder="Adresse" autofocus required
                               onkeypress="verifierCaracteres(event); return false;">
                    </div>
                    <div class="form-group">
                        <input type="text" name="nom" class="form-control" placeholder="Nom" autofocus required
                               onkeypress="verifierCaracteres(event); return false;">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required autofocus
                               onkeypress="verifierCaracteres(event); return false;">
                    </div>
                    <input type="submit" name="save" class="btn btn-success btn-block" value="Valider">
                </form>

            </div>
            <br>
            <div class="card card-body">
                <br>
                <button class="page-item page-link"><a href="line.php">Insert per line</a></button>
                <br>
                <button class="page-item page-link"><a href="multi.php">Insert Multi</a></button>
                <br>
                <button class="page-item page-link"><a href="bulk.php">Insert Bulk</a></button>
            </div>
            <div class="card card-body">
                <br>
                <button class="page-item page-link"><a href="sum.php">Total ID</a></button>
            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Adresse</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT SQL_CALC_FOUND_ROWS * FROM users ORDER BY 1 DESC  LIMIT 0, 10";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) == 0) { ?>
                    <tr>
                        <td colspan="5">Aucun enregistrement</td>
                    </tr>
                    <?php
                } else {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_users']); ?></td>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                            <td><?php echo htmlspecialchars($row['adresse']); ?></td>
                            <td><?php echo htmlspecialchars($row['nom']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id_users'] ?>" class="btn btn-secondary">
                                    <i class="fas fa-marker"></i>
                                </a>
                                <a href="delete.php?id=<?php echo $row['id_users'] ?>" class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <form action="index.php" method="get">
                        <button class="page-item page-link" name="page" value="<?php echo $page - 1 ?>"
                                type="submit">
                            Previous
                        </button>
                        <button class="page-item page-link" name="page" value="<?php echo $page + 1 ?>"
                                type="submit">
                            Next
                        </button>
                    </form>
                </ul>
            </nav>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>
