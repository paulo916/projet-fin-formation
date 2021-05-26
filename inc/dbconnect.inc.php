<?php
    // Connexion à la BDD en utilisant PDO
    try {
        // Tentative de connexion
        // $cnn = new PDO('mysql:host=localhost;dbname=holidays;charset=utf8', 'root', 'root');
        $cnn = new PDO('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DATA . ';charset=utf8', USER, PASS);
        // Affecte les attributs à la connexion
        $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $cnn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $err) {
        // Si erreur de connexion
        echo '<p class="alert alert-danger">' . $err->getMessage() . '</p>';
    }