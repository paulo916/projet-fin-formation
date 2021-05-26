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
    <h1>Back-office</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Back-office</li>
        </ol>
    </nav>

    <section id="clients">
        <?php
        $sql =
            "SELECT TABLE_NAME, COLUMN_NAME
            FROM information_schema.columns
            WHERE TABLE_SCHEMA=:tn
            AND COLUMN_KEY=:ck
            AND TABLE_NAME IN (SELECT TABLE_NAME
                                FROM information_schema.columns
                                WHERE TABLE_SCHEMA=:tn
                                AND COLUMN_KEY=:ck
                                GROUP BY TABLE_NAME
                                HAVING COUNT(TABLE_NAME)=1)";
        $params = array(
            ':tn' => DATA,
            ':ck' => 'PRI'
        );
        $data = $db->getData($sql, $params);

        // Ajoute un list-group avec liaion vers list.php vs table/pk
        $html = '<ul class="list-group mb-5">';
        foreach ($data as $row) {
            $html .= '<li class="list-group-item list-group-item-action"><a href="list.php?t=' . $row["TABLE_NAME"] . '&k=' . $row["COLUMN_NAME"] . '">' . ucfirst($row["TABLE_NAME"]) . '</a></li>';
        }
        $html .= '</ul>';
        echo $html;
        ?>
    </section>

    <section id="databases">
        <?php
        // Afficher la liste des BDD du serveur
        //echo $db->makeSelect('dbs', 'SHOW DATABASES');
        ?>
    </section>

    <section id="badges" class="d-flex flex-wrap">
        <?php
        // Exécution requête
        $sql = 'SELECT TABLE_NAME, TABLE_ROWS FROM information_schema.tables WHERE TABLE_SCHEMA=?';
        $params = array(DATA);
        $data = $db->getData($sql, $params);

        // Génération badges
        $html = '';
        foreach ($data as $row) {
            $html .= '<h4 class="m-2">' . ucfirst($row['TABLE_NAME']) . ' <span class="badge badge-info">' . $row['TABLE_ROWS'] . '</span></h4>';
        }
        echo $html;
        ?>
    </section>
    <script src="javascript/bo.js"></script>
</body>

</html>