<?php
// Imports
include_once('inc/session.inc.php');
include_once('inc/constants.inc.php');
include_once('class/model.class.php');

// Teste les variable du GET
$t = (isset($_GET['t']) && !empty($_GET['t'])) ? $_GET['t'] : null;
$k = (isset($_GET['k']) && !empty($_GET['k'])) ? $_GET['k'] : null;
$v = (isset($_GET['v']) && !empty($_GET['v'])) ? $_GET['v'] : null;

// Selon cas : INSERT ou UPDATE
if ($t && $k) {
    $table = new Model('MY', HOST, PORT, DATA, USER, PASS, $t);
    if ($v) {
        // Mise à jour
        $nb = $table->update($_POST, $k, $v);
    } else {
        // Insertion
        $nb = $table->insert($_POST);
    }
    $table->disconnect();
    header('location:list.php?t=' . $t . '&k=' . $k);
}