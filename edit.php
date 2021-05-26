<?php
// Imports
include_once('inc/session.inc.php');
include_once('inc/constants.inc.php');
include_once('class/database.class.php');

// Teste si la querystring contient nom de la table, pk et valeur
$t = (isset($_GET['t']) && !empty($_GET['t'])) ? $_GET['t'] : null;
$k = (isset($_GET['k']) && !empty($_GET['k'])) ? $_GET['k'] : null;
$v = (isset($_GET['v']) && !empty($_GET['v'])) ? $_GET['v'] : null;

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
    <h1>Edition des données<?php echo ($t ? ' : ' . $t : ''); ?></h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
            <li class="breadcrumb-item"><a href="bo.php">Back-office</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Liste des données</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edition des données</li>
        </ol>
    </nav>

    <section id="myForm">
        <?php
        echo $db->makeForm($t, $k, $v);
        ?>
    </section>

</body>

</html>