<?php
// Démarre ou restaure une session
session_start();
// Détruit les variables
session_unset();
// Détruit la session en cours
session_destroy();
// Renvoi vers accueil
header('location:incrip.php?c=end');