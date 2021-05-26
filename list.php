<?php
// Imports
include_once('inc/session.inc.php');
include_once('inc/constants.inc.php');
include_once('class/database.class.php');

// Connexion
$db = new Database('MY', HOST, PORT, DATA, USER, PASS);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body class="container">
    <h1>Liste des données</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
            <li class="breadcrumb-item"><a href="bo.php">Back-office</a></li>
            <li class="breadcrumb-item active" aria-current="page">Liste des données</li>
        </ol>
    </nav>
<div id="interface">
    <section id="myTable">
        <?php
        // Teste si la querystring contient nom de la table
        if (isset($_GET['t']) && !empty($_GET['t'])) {
            $t = $_GET['t'];
        } else {
            $t = null;
        }

        // Teste si la querystring contient nom de la colonne : avec Tina TERNAIRE
        $k = (isset($_GET['k']) && !empty($_GET['k'])) ? $_GET['k'] : null;

        // Si les deux tests sont OK
        if ($t && $k) {
            // Affiche le tableau HTML si table existe
            if ($db->tableExists($t, DATA)) {
                $sql = 'SELECT * FROM ' . $t;
                echo $db->makeTable('tblList', $sql, array(), array('t' => $t, 'k' => $k));
            } else {
                echo '<div class="alert alert-danger" role="alert">La table ' . $t . ' n\'existe pas !</div>';
            }
        }
        ?>
    </section>
</div>
</body>

</html>