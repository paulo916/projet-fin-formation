<?php
// Interdit l'accès si pas connecté
session_start();
if (!isset($_SESSION['connected']) || $_SESSION['connected'] === false) {
    //header('location:index.html?c=end');
    //exit();
}