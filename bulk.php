<?php
include('db.php');

$timeStart = microtime(true);

$users = new SplFixedArray(500000);
$json_string_fn = file_get_contents("json/prenoms.json");
$json_string_ln = file_get_contents("json/lastnames.json");
$json_string_fournisseur = file_get_contents("json/fournisseurs.json");
$firstNames = json_decode($json_string_fn);
$lastnames = json_decode($json_string_ln);
$fournisseurs = json_decode($json_string_fournisseur);

$nbName = count($firstNames) - 1;
$nbLastname = count($lastnames) - 1;
$nbFourni = count($fournisseurs) - 1;

$file_path = "./users.txt";
$fp = fopen($file_path, 'a+');

for ($i = 1; $i < 1000000; $i++) {
    $randName = $firstNames[rand(0, $nbName)];
    $randFamilyName = $lastnames[rand(0, $nbLastname)];
    $randFourni = $fournisseurs[rand(0, $nbFourni)];

    $adresse = rand(1, 99) . " rue test" . rand(0, 99) . " " . rand(1, 92) . "000 ville " . rand(0, 999);

    $mail = strtolower(str_replace(" ", ".", $randName)) . "." . strtolower(str_replace(" ", ".", $randFamilyName)) . "@" . $randFourni;

    $user['name'] = $randName . " " . $randFamilyName;
    $user['mail'] = $mail;
    $user['adresse'] = $adresse;

    fputcsv($fp, array(
        $i,
        $user['name'],
        $user['mail'],
        $user['adresse'],
        "|",
    ));
}

try {
    $query = "LOAD DATA LOCAL INFILE 'C://wamp64//www//crudSQL//users.txt' INTO TABLE users FIELDS TERMINATED BY ',' LINES TERMINATED BY '|' (id_users, adresse, nom, email);";
    $result = mysqli_query($connection, $query);

    $timeStop = microtime(true);
    $allTime = $timeStop - $timeStart;

    $_SESSION['message'] = 'Insertion par fichier terminée en ' . $allTime;
    $_SESSION['message_type'] = 'success';
    header('Location: index.php');
} catch (Exception $e) {
    $_SESSION['message'] = 'Insertion par fichier échoué : ' . $e;
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    echo $e;
}