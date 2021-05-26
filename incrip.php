<?php
// Test si connecté
session_start();
$is_in = false;
if (isset($_SESSION['connected']) && $_SESSION['connected'] === true) {
    $is_in = true;
}

// Imports
include_once('inc/constants.inc.php');
include_once('inc/dbconnect.inc.php');
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
    <div class="jumbotron mt-5">
        <p>Vous pouvez vous inscrire où vous connecté en cliquant sur le bouton ci-dessous.</p>

        <span style="display:<?php echo ($is_in ? 'none' : ''); ?>">
        <a href="fale-conosco.html"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#register">Inscription</button></a>
        <a href="connection.html"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#login">Connexion</button></a>
        </span>
    </div>
    <?php
    include_once('inc/functions.inc.php');
    echo display_alert('c', 'ok', 'success', 'Bienvenue ' . (isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : '') . ' !');
    echo display_alert('c', 'ko', 'danger', 'Mail ou mot de passe incorrect !');
    echo display_alert('c', 'end', 'warning', 'La session est échue !');
    echo display_alert('u2', 'ok', 'success', 'Le compte a été activé avec succès !');
    echo display_alert('u', 'ok', 'success', 'Le compte a été créé avec succès !');
    echo display_alert('u', 'ko', 'danger', 'Le compte n\'a pas pu être créé !');
    ?>
</body>
</html>