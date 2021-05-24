<?php
// Constantes liées à l'application
const APP_NAME = 'projet fin formation';

// Constantes liées à la BDD
switch ($_SERVER['HTTP_HOST']) {
    case 'localhost':
    case '127.0.0.1':
        define('HOST', 'localhost');
        define('PORT',  3306);
        define('DATA', 'clients');
        define('USER', 'root');
        define('PASS', '');
        break;
    case 'baobab-ingenierie.fr':
        define('HOST', 'mysql5-5.pro');
        define('PORT', '');
        define('DATA', 'baobabinsql5');
        define('USER', 'baobabinsql5');
        define('PASS', 'secret');
        break;
    default:
        throw new Exception('Erreur SERVER : les paramètres de connexion sont introuvables.');
}