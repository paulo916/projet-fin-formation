<?php
// Imports
include_once('inc/session.inc.php');
include_once('inc/constants.inc.php');
include_once('class/model2.class.php');
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
    <?php
    $table = 'customers';
    echo '<h1>Table : ' . ucfirst($table) . '</h1>';
    $cust = new Model2('MY', HOST, PORT, DATA, USER, PASS, $table);
    echo '<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
	<li class="breadcrumb-item active" aria-current="page">Clients</li>
	</ol>
	</nav>';
    echo $cust::makeTable(
        'tblCust',
        'SELECT * FROM ' . $table,
        array(),
        array('t' => $table, 'k' => 'cno')
    );
    ?>
</body>

</html>