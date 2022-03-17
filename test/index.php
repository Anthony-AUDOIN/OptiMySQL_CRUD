<?php
ini_set('memory_limit', '-1');
//connexion au serveur
$serveur = "localhost";
$login = "admin";
$pass = "admin";
$dbname = "mysqlopti";
$chemin_image = "http://archeodunum/";
$hsc = function ($p) {
    return htmlspecialchars($p, ENT_QUOTES, 'utf-8');
};

// échappement des caractères dangereux
try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$dbname;charset=UTF8", $login, $pass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Echec : ' . $e->getMessage();
}

//requête SQL et mise en forme en tableau
$page = (!empty($_GET['page']) ? $_GET['page'] : 1);
$limite = 10;
$debut = ($page - 1) * $limite;
$sql2 = "SELECT SQL_CALC_FOUND_ROWS * from users";
$sql2 = $connexion->prepare($sql2);
$sql2->bindValue('debut', $debut, PDO::PARAM_INT);
$sql2->bindValue('limite', $limite, PDO::PARAM_INT);

$sql2->execute();
$resultFoundRows = $connexion->query('SELECT found_rows()');
$nombredElementsTotal = $resultFoundRows->fetchColumn();
?>
    <style>
        th {
            text-align: center;
        }

        td {
            border: 1px solid lightgrey;
            padding: 5px !important;
            vertical-align: middle;
        }
    </style>

    <table class="table table-hover">
        <thead>
        <tr>
            <th width=25%> ID </th>
            <th width=25%> Type </th>
            <th width=25%> Adresse </th>
            <th width=25%> Nom </th>
        </tr>
        </thead>

        <?php
        while ($row = $sql2->fetch()) {
            $row = array_map($hsc, $row);
            // échappement de toutes les valeurs
            $notice = (!empty($row['Notice'])) ? '<a href=' . $row['Notice'] . '><img src=' . $chemin_image . 'lien alt=notice width=30% /></a>' : '';
            $fiche_RO = (!empty($row['Fiche'])) ? '<a href=' . $chemin_image . 'collaborateur/' . $row['Nom'] . '-' . $row['Prénom'] . '>' . $row['Nom_Auteur'] . '</a>' : '' . $row['Nom_Auteur'] . '';
            echo "<tr>
		<td>" . $row['id_users'] ."</td>
		<td>" . $row['type'] . "</td>
		<td>" . $row['adresse'] . "</td>
		<td>" . $row['nom'] . "</td>
		<td>" . $row['email'] . "</td>
		<td Style='text-align:center !important'>" . $notice . "</td>
		<td><a href='modifier_site?id=" . $row['ID_Site'] . "&o=u'>Modifier</a></td>
	</tr>\n";
        }

        ?>
    </table>
<?php
$nombreDePages = ceil($nombredElementsTotal / $limite);


if ($page > 1):
    ?><a href="?page=<?php echo $page - 1; ?>">Page précédente</a> — <?php
endif;


for ($i = 1; $i <= $nombreDePages; $i++):
    ?><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a> <?php
endfor;


if ($page < $nombreDePages):
    ?>— <a href="?page=<?php echo $page + 1; ?>">Page suivante</a><?php
endif;
?>