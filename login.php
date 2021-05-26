<?php
// Récup session lancée par le captcha
session_start();

// Imports
include_once('inc/constants.inc.php');
include_once('inc/dbconnect.inc.php');

// Récup des valeurs saisies et cryptage
if (isset($_POST['mail']) && !empty($_POST['mail'])) {
    $params[':mail'] = sha1(md5($_POST['mail']) . strlen($_POST['mail']));
} else {
    $params[':mail'] = null;
}

if (isset($_POST['pass']) && !empty($_POST['pass'])) {
    $params[':pass'] = hash('sha512', sha1($_POST['pass']) . $_POST['mail']);
} else {
    $params[':pass'] = null;
}

$captcha = (isset($_POST['captcha']) && !empty($_POST['captcha'])) ? htmlspecialchars($_POST['captcha']) : null;

// Teste mail et pass
$sql = 'SELECT * FROM members WHERE mail=:mail AND pass=:pass AND active=1';
$qry = $cnn->prepare($sql);
$qry->execute($params);

if (($qry->rowCount() === 1) && ($captcha === $_SESSION['captcha'])) {
    // Création session
    session_unset();
    session_destroy(); // Session créée par le captcha !
    session_start(); // Nouvelle session
    $row = $qry->fetch();
    $_SESSION['connected'] = true;
    $_SESSION['mail'] = $_POST['mail'];
    $_SESSION['pseudo'] = $row['pseudo'];
    $_SESSION['status'] = $row['status'];
    // Renvoi vers BO
    header('location:index.php?c=ok');
} else {
    header('location:index.php?c=ko');
}

// Déconnexion
unset($cnn);